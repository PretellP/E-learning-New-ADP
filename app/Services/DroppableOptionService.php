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

    public function update(DroppableOption $droppable, $description)
    {
        return $droppable->update([
            "description" => $description
        ]);
    }

    public function destroy(DroppableOption $droppable)
    {
        $success = false;

        $isDeleted = $droppable->delete();

        if($isDeleted){
            $success = true;
        }

        return $success;
    }
}