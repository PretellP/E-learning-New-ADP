<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Course, Document};


class Folder extends Model
{
    use HasFactory;

    protected $table = 'folders';
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'folder_id', 'id');
    }
}
