<?php

namespace App\Services;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public function uploadFile($req, $userId)
    {
        $file = $req->file;
        $fileOriginalName = $req->file->getClientOriginalName();

        $contents = file_get_contents($file->getRealPath());
        $md5Hash = md5($contents);

        $fileNewName = $md5Hash . '.' . $file->getClientOriginalExtension();

        $existingFile = File::where('file', $fileNewName)->first();

        if (!$existingFile) {
            $file->move(public_path('uploads'), $fileNewName);
        }

        $fileModel = File::create([
            'hash' => $md5Hash,
            'file' => $fileNewName,
            'filename' => $fileOriginalName,
        ]);

        $user = User::find($userId);
        $user->files()->syncWithoutDetaching([$fileModel->id]);

        return $fileModel;
    }
}
