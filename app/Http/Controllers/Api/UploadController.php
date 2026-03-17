<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'folder' => 'nullable|string|max:80',
        ]);

        $folder = $validated['folder'] ?? 'uploads';
        $folder = preg_replace('/[^a-zA-Z0-9_\\-\\/]/', '', $folder);
        $folder = trim($folder, '/');
        if ($folder === '') $folder = 'uploads';

        $path = $request->file('file')->storePublicly($folder, 'public');

        // Always return a relative URL so it works on any host/port (e.g. localhost:8000).
        $relativeUrl = '/storage/' . ltrim($path, '/');

        // If the filesystem is configured to generate absolute URLs, normalize back to relative
        // when it points to this same app.
        $diskUrl = (string) Storage::disk('public')->url($path);
        $diskPath = parse_url($diskUrl, PHP_URL_PATH);
        if (is_string($diskPath) && str_starts_with($diskPath, '/storage/')) {
            $relativeUrl = $diskPath;
        }

        return response()->json([
            'path' => $path,
            'url' => $relativeUrl,
        ], 201);
    }
}

