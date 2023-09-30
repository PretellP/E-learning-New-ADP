<?php

namespace App\Services;

use App\Models\{CourseCategory};
use Exception;

class CourseCategoryService
{
    static function withCategoryRelationshipsQuery()
    {
        return CourseCategory::with(
            [
                'file' => fn ($query) =>
                $query->where('file_type', 'imagenes')
            ]
        )
            ->withCount('courses');
    }

    public function store($request, $storage)
    {
        $data = normalizeInputStatus($request->validated());

        $categoryModel = CourseCategory::create($data);

        if ($categoryModel) {
            if ($request->hasFile('image')) {

                $file_type = 'imagenes';
                $category = 'cursoslibres';
                $belongsTo = 'cursoslibres';
                $relation = 'one_one';

                $file = $request->file('image');

                return app(FileService::class)->store(
                    $categoryModel,
                    $file_type,
                    $category,
                    $file,
                    $storage,
                    $belongsTo,
                    $relation
                );
            }
            return $categoryModel;
        }

        throw new Exception('Ocurrio un error al realizar el registro');
    }

    public function update($request, $storage, CourseCategory $categoryModel)
    {
        $data = normalizeInputStatus($request->validated());

        $isUpdated = $categoryModel->update($data);

        if($isUpdated)
        {
            if($request->hasFile('image'))
            {
                app(FileService::class)->destroy($categoryModel->file, $storage);

                $file_type = 'imagenes';
                $category = 'cursoslibres';
                $file = $request->file('image');
                $belongsTo = 'cursoslibres';
                $relation = 'one_one';

                return app(FileService::class)->store(
                    $categoryModel,
                    $file_type,
                    $category,
                    $file,
                    $storage,
                    $belongsTo,
                    $relation
                );
            }

            return $isUpdated;
        };

        throw new Exception('Ocurrió un error al realizar el registro');
    }

    public function destroy($storage, CourseCategory $categoryModel)
    {
        app(FileService::class)->destroy($categoryModel->file, $storage);

        $isdeleted = $categoryModel->delete();

        if($isdeleted){
            return true;
        }

        throw new Exception('No es posible eliminar el registro');
    }   

}
