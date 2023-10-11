<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->files;
        }

        return response()->json([
            'users' => $users
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, FileService $fileService)
    {
        // $userId = auth()->user()->id;
        $fileService->uploadFile($request, 1);

        return response()->json([
            'message' => 'Success create file'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = File::find($id);

        $file->delete();
        return response()->json(['message' => 'File deleted successfully']);
    }
}
