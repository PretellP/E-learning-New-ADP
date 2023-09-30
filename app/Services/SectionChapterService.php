<?php

namespace App\Services;

use App\Models\{CourseSection, SectionChapter};
use Datatables;
use Exception;
use Owenoj\LaravelGetId3\GetId3;

class SectionChapterService
{
    public function getDataTable($section_id)
    {
        $allChapters = Datatables::of(
            SectionChapter::where('section_id', $section_id)

        )
            ->editColumn('duration', function ($chapter) {
                return $chapter->duration . ' minutos';
            })
            ->editColumn('description', function ($chapter) {
                $description = $chapter->description;
                if (strlen($chapter->description) > 100) {
                    $description =  mb_substr($chapter->description, 0, 100, 'UTF-8') . ' ...';
                }
                return $description;
            })
            ->addColumn('view', function ($chapter) {
                return ' <a href="javascript:void(0);" class="preview-chapter-video-button"
                            data-url="' . route('admin.freeCourses.chapters.getVideoData', $chapter) . '"> 
                            <i class="fa-solid fa-video"></i>
                        </a>';
            })
            ->addColumn('action', function ($chapter) {
                $btn = '<button data-id="' . $chapter->id . '" 
                                    data-url="' . route('admin.freeCourses.chapters.update', $chapter) . '" 
                                    data-send="' . route('admin.freeCourses.chapters.edit', $chapter) . '"
                                    data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                    editChapter"><i class="fa-solid fa-pen-to-square"></i></button>';

                $btn .= '<button href="javascript:void(0)" data-id="' .
                    $chapter->id . '" data-original-title="delete"
                                    data-url="' . route('admin.freeCourses.chapters.delete', $chapter) .
                    '" class="ms-3 delete btn btn-danger btn-sm
                                    deleteChapter"><i class="fa-solid fa-trash-can"></i></button>';

                return $btn;
            })
            ->rawColumns(['view', 'action'])
            ->make(true);

        return $allChapters;
    }

    public function store($request, CourseSection $section, $storage)
    {
        $lastOrder = $section->getChapterLastOrder();

        if ($request->hasFile('file')) {

            $video = $request->file('file');

            $videoId3 = new GetId3($video);
            $duration = round($videoId3->getPlaytimeSeconds() / 60);

            $chapter = SectionChapter::create($request->all() + [
                "chapter_order" => $lastOrder + 1,
                "duration" => $duration,
                "section_id" => $section->id
            ]);

            if ($chapter) {
                $file_type = 'videos';
                $category = 'cursoslibres';
                $belongsTo = 'cursoslibres';
                $relation = 'one_one';

                app(FileService::class)->store(
                    $chapter,
                    $file_type,
                    $category,
                    $video,
                    $storage,
                    $belongsTo,
                    $relation
                );

                return $chapter;
            }
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function update($request, SectionChapter $chapter, $storage)
    {
        $duration = $chapter->duration;
        $order = $request['chapter_order'];

        if ($order != $chapter->chapter_order) {
            SectionChapter::where('section_id', $chapter->section_id)
                ->where('chapter_order', $order)
                ->update([
                    "chapter_order" => $chapter->chapter_order
                ]);
        }

        if ($request->has('file')) {
            app(FileService::class)->destroy($chapter->file, $storage);

            $video = $request->file('file');
            $videoId3 = new GetId3($video);
            $duration = round($videoId3->getPlaytimeSeconds() / 60);

            $file_type = 'videos';
            $category = 'cursoslibres';
            $belongsTo = 'cursoslibres';
            $relation = 'one_one';

            app(FileService::class)->store(
                $chapter,
                $file_type,
                $category,
                $video,
                $storage,
                $belongsTo,
                $relation
            );
        }

        $isUpdated = $chapter->update($request->all() + [
            "duration" => $duration
        ]);

        if ($isUpdated) {
            return true;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function destroy(SectionChapter $chapter, $storage)
    {
        $section_id = $chapter->courseSection->id;
        $chapter->progressUsers()->detach();

        app(FileService::class)->destroy($chapter->file, $storage);

        $isDeleted = $chapter->delete();

        if ($isDeleted) {
            return $this->updateAllOrders($section_id);
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function updateAllOrders($section_id)
    {
        $chapters = SectionChapter::where('section_id', $section_id)
            ->orderBy('chapter_order', 'ASC')->get();

        $order = 1;
        foreach ($chapters as $remanentChapter) {
            $remanentChapter->update([
                "chapter_order" => $order
            ]);
            $order++;
        }

        return true;
    }
}
