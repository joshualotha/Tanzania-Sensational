<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Models\VisualAsset;

class VisualAssetController extends Controller
{
    public function index()
    {
        $perPage = (int)request()->query('per_page', 24);
        $perPage = max(6, min(96, $perPage));

        // For predictable client-side rotation (e.g. hero carousels), keep ordering stable.
        $query = VisualAsset::query()->orderBy('created_at')->orderBy('id');

        if ($section = request()->query('section')) {
            $query->where('section', $section);
        }

        if ($q = request()->query('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('key', 'like', '%' . $q . '%')
                    ->orWhere('section', 'like', '%' . $q . '%');
            });
        }

        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section' => 'required|string',
            'key' => 'required|string|unique:visual_assets,key',
            'url' => 'required|string',
            'type' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        $asset = VisualAsset::create($validated);
        return response()->json($asset, 201);
    }

    public function show($key)
    {
        $asset = VisualAsset::where('key', $key)->firstOrFail();
        return response()->json($asset);
    }

    public function update(Request $request, $key)
    {
        $asset = VisualAsset::where('key', $key)->firstOrFail();
        
        $validated = $request->validate([
            'section' => 'sometimes|string',
            'key' => [
                'sometimes',
                'string',
                Rule::unique('visual_assets', 'key')->ignore($asset->id),
            ],
            'url' => 'sometimes|string',
            'type' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        $asset->update($validated);
        return response()->json($asset);
    }

    public function destroy($key)
    {
        $asset = VisualAsset::where('key', $key)->firstOrFail();

        $deleteFile = (bool) request()->boolean('delete_file', false);
        if ($deleteFile) {
            $url = (string)($asset->url ?? '');
            // Only delete files that we serve from /storage/... (public disk).
            if (str_starts_with($url, '/storage/')) {
                $path = ltrim(substr($url, strlen('/storage/')), '/');
                if ($path !== '') {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $asset->delete();
        return response()->json(null, 204);
    }
}
