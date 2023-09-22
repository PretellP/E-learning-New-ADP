<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    
    protected $table = 'files';

    protected $fillable = [
        'file_path', 'file_url', 'file_type', 'category', 'fileable_id', 'fileable_type',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function getNameAttribute()
    {
        return basename($this->file_path);
    }
}
