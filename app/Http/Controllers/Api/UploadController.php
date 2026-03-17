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

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path), // /storage/...
        ], 201);
    }
}

