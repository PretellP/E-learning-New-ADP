<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Folder;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';
    protected $guarded = [];


    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id', 'id');
    }

}
