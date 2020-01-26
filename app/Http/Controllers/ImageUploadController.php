<?php

namespace App\Http\Controllers;

use App\FileProcessor\FileNameGenerator;
use App\Jobs\ConvertImageJob;
use App\Jobs\SliceImageJob;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ImageUploadController extends Controller
{
    public function upload(Request $request){
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,bmp,gif,svg,pdf'
        ]);
        $uploadedFile = $request->file('image');
        $filenameGenerator = app()->make(FileNameGenerator::class);

        $filename = $uploadedFile->storeAs('uploads', $filenameGenerator->generate($uploadedFile), 'local');

        if ($uploadedFile->extension() === 'pdf') {
            ConvertImageJob::dispatch($filename)->onQueue('convert');
        } else {
            SliceImageJob::dispatch($filename)->onQueue('slice');
        }
    }
}
