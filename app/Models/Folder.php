<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Course, Document, File};

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
        return $this->hasMany(self::class, 'parent_folder_id', 'id');
    }

    public function parentFolder()
    {
        return $this->belongsTo(self::class, 'parent_folder_id', 'id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
