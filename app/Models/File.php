<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hash', 'file', 'filename'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_file', 'file_id', 'user_id')->withTimestamps();
    }
}
