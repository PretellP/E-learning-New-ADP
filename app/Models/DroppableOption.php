<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicAlternative;

class DroppableOption extends Model
{
    use HasFactory;

    protected $table = 'droppable_options';
    protected $guarded = [];

    public function alternative()
    {
        return $this -> belongsTo(DynamicAlternative::class, 'dynamic_alternative_id', 'id');
    }
}
