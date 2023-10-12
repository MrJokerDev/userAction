<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends Controller
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

        foreach ($files as $file) {
            $file->users;
        }
        return response()->json([
            'files' => $files
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

        return response()->json(['message' => 'File deleted successfully'], 200);
    }
}
