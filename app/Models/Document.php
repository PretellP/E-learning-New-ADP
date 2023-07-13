<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Folder;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id', 'id');
    }

    protected $guarded = [];
}
