<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Course, Document, Folder};


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

    public function subFolders()
    {
        return $this->hasMany(Folder::class, 'parent_folder_id', 'id');
    }

    public function parentFolder()
    {
        return $this->belongsTo(Folder::class, 'parent_folder_id', 'id');
    }
}
