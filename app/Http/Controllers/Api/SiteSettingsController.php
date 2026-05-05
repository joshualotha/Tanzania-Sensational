<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    /**
     * Public endpoint – returns settings as a flat key-value map
     * so the frontend can easily consume them.
     */
    public function publicIndex()
    {
        $settings = SiteSetting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group')
            ->map(function ($items) {
                return $items->mapWithKeys(function ($s) {
                    // value is stored as ['value' => '...'] – unwrap it
                    $raw = $s->value;
                    return [$s->key => is_array($raw) && array_key_exists('value', $raw) ? $raw['value'] : $raw];
                });
            });

        return response()->json([
            'settings' => $settings,
        ]);
    }

    public function index()
    {
        $settings = SiteSetting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group')
            ->map(function ($items) {
                return $items->mapWithKeys(function ($s) {
                    return [$s->key => $s->value];
                });
            });

        return response()->json([
            'settings' => $settings,
        ]);
    }

    public function upsert(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.general' => 'nullable|array',
            'settings.contact' => 'nullable|array',
            'settings.social' => 'nullable|array',
            'settings.branding' => 'nullable|array',
        ]);

        $groups = $validated['settings'];

        foreach ($groups as $group => $pairs) {
            if (!is_array($pairs)) continue;
            foreach ($pairs as $key => $value) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    [
                        'group' => $group,
                        'value' => is_array($value) ? $value : ['value' => $value],
                    ]
                );
            }
        }

        return $this->index();
    }
}

