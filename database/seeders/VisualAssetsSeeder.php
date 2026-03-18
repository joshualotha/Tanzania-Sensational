<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Process\Process;
use App\Models\VisualAsset;

class VisualAssetsSeeder extends Seeder
{
    public function run(): void
    {
        $script = base_path('scripts/visual-assets-catalog.mjs');
        if (!is_file($script)) {
            $this->command?->warn("Visual assets catalog script not found: {$script}");
            return;
        }

        $process = new Process(['node', $script]);
        $process->setTimeout(120);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->command?->warn('Visual assets catalog generation failed.');
            $this->command?->warn($process->getErrorOutput() ?: $process->getOutput());
            return;
        }

        $json = trim($process->getOutput());
        $records = json_decode($json, true);
        if (!is_array($records)) {
            $this->command?->warn('Visual assets catalog output was not valid JSON.');
            return;
        }

        $inserted = 0;
        foreach ($records as $r) {
            $key = (string)($r['key'] ?? '');
            if ($key === '') continue;

            $exists = VisualAsset::where('key', $key)->exists();
            if ($exists) continue; // skip existing to preserve admin edits

            VisualAsset::create([
                'section' => (string)($r['section'] ?? 'general'),
                'key' => $key,
                'url' => (string)($r['url'] ?? ''),
                'type' => (string)($r['type'] ?? 'image'),
                'metadata' => is_array($r['metadata'] ?? null) ? $r['metadata'] : null,
            ]);
            $inserted++;
        }

        $this->command?->info("VisualAssetsSeeder: inserted {$inserted} records (skipped existing).");
    }
}

