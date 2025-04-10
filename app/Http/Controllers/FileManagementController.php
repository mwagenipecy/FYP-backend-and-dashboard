<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagementController extends Controller
{
    
    public function index()
    {

        return view('pages.files.file-management');
    }

    public function previewDocument(Request $request)
    {
        $path = $request->path;

        if (!Storage::exists($path)) {
            abort(404);
        }

        $mimeType = Storage::mimeType($path);
        $content = Storage::get($path);

        // For PDFs and images, display directly in the browser
        if (in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'])) {
            return response($content)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . basename($path) . '"');
        }

        // For text files, display as plain text
        if (str_starts_with($mimeType, 'text/')) {
            return response($content)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'inline; filename="' . basename($path) . '"');
        }

        // For other file types, force download
        return response($content)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . basename($path) . '"');
    }


}
