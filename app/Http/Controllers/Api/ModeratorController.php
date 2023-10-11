<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends Controller
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
            'files' => $users
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, FileService $fileService)
    {
        $userId = auth()->user()->id;
        $fileService->uploadFile($request, 2);

        return response()->json([
            'message' => 'Success create file'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();

        $files = File::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere(function ($query) use ($user) {
                    $query->whereHas('roles', function ($query) use ($user) {
                        $query->where('name', 'moderator')
                            ->orWhere('name', 'user');
                    });
                });
        })->get();

        $file = $files->find($id);

        $file->delete();

        return response()->json(['message' => 'File deleted successfully']);
    }
}
