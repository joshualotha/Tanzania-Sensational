<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        // Force set temp upload directory if missing (fixes error 6 on cPanel/shared hosting)
        if (empty(ini_get('upload_tmp_dir')) && is_writable(sys_get_temp_dir())) {
            @ini_set('upload_tmp_dir', sys_get_temp_dir());
        }
        
        \Log::info('Upload attempt', [
            'has_file' => $request->hasFile('file'),
            'files_count' => count($_FILES ?? []),
            'file_key_exists' => isset($_FILES['file']),
            'file_error' => $_FILES['file']['error'] ?? 'not_set',
            'file_size' => $_FILES['file']['size'] ?? 'not_set',
            'file_name' => $_FILES['file']['name'] ?? 'not_set',
            'upload_tmp_dir' => ini_get('upload_tmp_dir'),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
        ]);

        // Direct $_FILES check (more reliable than $request->hasFile on some hosts)
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $errorCode = $_FILES['file']['error'] ?? 'unknown';
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds server PHP upload limit (upload_max_filesize).',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive in HTML form.',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder. Contact your hosting provider.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
            ];
            
            \Log::error('Upload failed', [
                'error_code' => $errorCode,
                'message' => $errorMessages[$errorCode] ?? 'Unknown error',
            ]);
            
            return response()->json([
                'message' => 'Upload failed',
                'errors' => ['file' => [$errorMessages[$errorCode] ?? 'The uploaded file is invalid or exceeds server limits.']]
            ], 422);
        }

        // Validate folder parameter only
        $folder = $request->input('folder', 'uploads');
        $folder = preg_replace('/[^a-zA-Z0-9_\-\/]/', '', $folder);
        $folder = trim($folder, '/');
        if ($folder === '') $folder = 'uploads';

        // Get the uploaded file from $_FILES
        $uploadedFile = new \Illuminate\Http\UploadedFile(
            $_FILES['file']['tmp_name'],
            $_FILES['file']['name'],
            $_FILES['file']['type'] ?? 'application/octet-stream',
            $_FILES['file']['error'],
            true
        );

        $path = $uploadedFile->storePublicly($folder, 'public');

        // Always return a relative URL so it works on any host/port
        $relativeUrl = '/storage/' . ltrim($path, '/');

        \Log::info('Upload successful', ['path' => $path, 'url' => $relativeUrl]);

        return response()->json([
            'path' => $path,
            'url' => $relativeUrl,
        ], 201);
    }
}

