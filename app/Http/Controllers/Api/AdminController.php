<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::all();

        $user = User::find($this->userId);

        foreach ($files as $file) {
            $file->users;
        }

        return response()->json([
            'files' => $files,
            'user_role' => $user->getRoles()
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, FileService $fileService)
    {
        $fileService->uploadFile($request, $this->userId);

        return response()->json([
            'message' => 'Success create file'
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = File::find($id);

        $file->delete();
        return response()->json(['message' => 'File deleted successfully'], 200);
    }
}
