<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User};

class Publishing extends Model
{
    use HasFactory;

    protected $table = 'publishings';
    protected $fillable = [
        'type',
        'publishing_order',
        'title',
        'content',
        'publication_time',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this -> belongsTo(User::class, 'user_id', 'id');
    }

    public function file()
    {
        return $this -> morphOne(File::class, 'fileable');
    }

    public function loadImage()
    {
        return $this->load(['file' => fn($q) => $q->where('file_type', 'imagenes')]);
    }
}
