<?php

namespace App\Services;

use App\Models\{SectionChapter};
use Datatables;
use Exception;

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



}