<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        // Add a check to return a precise error if max_upload_size in PHP.ini is intercepting
        if (!$request->hasFile('file') && $request->header('Content-Length') > 0) {
            return response()->json([
                'message' => 'Upload failed. The file exceeds the server\'s maximum upload limit or is corrupted.',
                'errors' => ['file' => ['File exceeds server PHP limits.']]
            ], 422);
        }

        $validated = $request->validate([
            // Removed 'mimes' because cPanel environments occasionally lack 'fileinfo'
            // and fail strict mime guessing, causing 422s. The frontend already enforces image types.
            'file' => 'required|file|max:51200',
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

