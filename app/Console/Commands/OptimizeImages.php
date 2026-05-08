<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize
        {--disk=public : The storage disk to scan}
        {--dir=visual-assets : Directory within the disk to scan}
        {--dry-run : Show what would be done without making changes}';

    protected $description = 'Generate WebP variants and responsive sizes for local images';

    /**
     * Image extensions we can convert to WebP.
     */
    protected array $convertibleExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * Responsive widths to generate (in pixels).
     */
    protected array $responsiveWidths = [400, 800, 1200, 1600];

    public function handle(): int
    {
        $disk = Storage::disk($this->option('disk'));
        $dir = $this->option('dir');
        $dryRun = $this->option('dry-run');

        $files = $disk->allFiles($dir);
        $this->info("Scanning disk [{$this->option('disk')}] directory [{$dir}]...");
        $this->newLine();

        $converted = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (!in_array($extension, $this->convertibleExtensions)) {
                continue;
            }

            // Skip if it's already a generated variant (contains width suffix)
            if (preg_match('/-\d+w\.(webp|jpg|jpeg|png)$/', $file)) {
                continue;
            }

            $fullPath = $disk->path($file);

            if (!file_exists($fullPath)) {
                $this->warn("  File not found: {$file}");
                $errors++;
                continue;
            }

            $fileSize = filesize($fullPath);
            $baseName = pathinfo($file, PATHINFO_FILENAME);
            $dirName = pathinfo($file, PATHINFO_DIRNAME);

            // Generate WebP version
            $webpPath = $dirName . '/' . $baseName . '.webp';

            if (!$disk->exists($webpPath)) {
                if ($dryRun) {
                    $this->line("  [DRY-RUN] Would create: {$webpPath}");
                } else {
                    $result = $this->convertToWebP($fullPath, $disk->path($webpPath));
                    if ($result) {
                        $saved = $fileSize - filesize($disk->path($webpPath));
                        $savedPercent = $fileSize > 0 ? round(($saved / $fileSize) * 100) : 0;
                        $this->info("  ✓ WebP: {$webpPath} (saved {$savedPercent}%)");
                        $converted++;
                    } else {
                        $this->warn("  ✗ Failed: {$webpPath}");
                        $errors++;
                    }
                }
            } else {
                $skipped++;
            }

            // Generate responsive variants for large images (>100KB)
            if ($fileSize > 100 * 1024) {
                foreach ($this->responsiveWidths as $width) {
                    $variantPath = $dirName . '/' . $baseName . '-' . $width . 'w.' . $extension;

                    if (!$disk->exists($variantPath)) {
                        if ($dryRun) {
                            $this->line("  [DRY-RUN] Would create: {$variantPath}");
                        } else {
                            $result = $this->resizeImage($fullPath, $disk->path($variantPath), $width);
                            if ($result) {
                                $this->info("  ✓ Resized: {$variantPath}");
                                $converted++;
                            } else {
                                $this->warn("  ✗ Failed: {$variantPath}");
                                $errors++;
                            }
                        }
                    } else {
                        $skipped++;
                    }
                }
            }
        }

        $this->newLine();
        $this->table(
            ['Metric', 'Count'],
            [
                ['Converted/Resized', $converted],
                ['Skipped (already exists)', $skipped],
                ['Errors', $errors],
            ]
        );

        return Command::SUCCESS;
    }

    /**
     * Convert an image to WebP format.
     */
    protected function convertToWebP(string $sourcePath, string $destPath): bool
    {
        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));

        // If source is already WebP, just copy
        if ($extension === 'webp') {
            return copy($sourcePath, $destPath);
        }

        // Use GD or Imagick to create WebP
        $image = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($sourcePath),
            'png' => @imagecreatefrompng($sourcePath),
            'gif' => @imagecreatefromgif($sourcePath),
            default => false,
        };

        if (!$image) {
            return false;
        }

        // Preserve alpha channel for PNG
        if ($extension === 'png') {
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }

        $result = imagewebp($image, $destPath, 80);
        imagedestroy($image);

        return $result;
    }

    /**
     * Resize an image to a specific width, maintaining aspect ratio.
     */
    protected function resizeImage(string $sourcePath, string $destPath, int $targetWidth): bool
    {
        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));

        $sourceImage = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($sourcePath),
            'png' => @imagecreatefrompng($sourcePath),
            'gif' => @imagecreatefromgif($sourcePath),
            'webp' => @imagecreatefromwebp($sourcePath),
            default => false,
        };

        if (!$sourceImage) {
            return false;
        }

        $origWidth = imagesx($sourceImage);
        $origHeight = imagesy($sourceImage);

        // Don't upscale
        if ($targetWidth >= $origWidth) {
            imagedestroy($sourceImage);
            return copy($sourcePath, $destPath);
        }

        $ratio = $origHeight / $origWidth;
        $targetHeight = (int) round($targetWidth * $ratio);

        $resized = imagecreatetruecolor($targetWidth, $targetHeight);

        // Preserve transparency
        imagealphablending($resized, false);
        imagesavealpha($resized, true);

        imagecopyresampled($resized, $sourceImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $origWidth, $origHeight);

        $result = match ($extension) {
            'jpg', 'jpeg' => imagejpeg($resized, $destPath, 85),
            'png' => imagepng($resized, $destPath, 8),
            'gif' => imagegif($resized, $destPath),
            'webp' => imagewebp($resized, $destPath, 80),
            default => false,
        };

        imagedestroy($sourceImage);
        imagedestroy($resized);

        return $result;
    }
}
