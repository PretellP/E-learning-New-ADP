<?php

namespace App\Services;

use App\Models\{DroppableOption};
use Exception;
use Yajra\DataTables\Facades\DataTables;

class droppableOptionService
{
    public function store($description, $alternative_id)
    {
        $success = false;

        $droppable = DroppableOption::create([
            "description" => $description,
            "dynamic_alternative_id" => $alternative_id
        ]);

        if($droppable){
            $success = true;
        }

        return $success;
    }
}