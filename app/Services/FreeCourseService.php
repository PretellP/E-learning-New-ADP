<?php

namespace App\Services;

use App\Models\{Course, CourseCategory, SectionChapter};
use Exception;
use Yajra\DataTables\Facades\DataTables;

class FreeCourseService
{
    static function withFreeCourseRelationshipsQuery()
    {
        return Course::with(
            [
                'courseCategory',
                'courseSections' => fn ($query) =>
                $query->orderBy('section_order', 'ASC')
                    ->withCount('sectionChapters'),
                'file' => fn ($query2) =>
                $query2->where('file_type', 'imagenes')
                    ->where('category', 'cursoslibres')
            ]
        )->withCount(['courseSections', 'courseChapters'])
            ->withSum('courseChapters', 'duration');
    }

    public function attachFreeCourseRelationships($query)
    {
        return $query->with(
                [
                    'courseCategory',
                    'courseSections' => fn ($query) =>
                    $query->orderBy('section_order', 'ASC')
                        ->withCount('sectionChapters'),
                    'file' => fn ($query2) =>
                    $query2->where('file_type', 'imagenes')
                        ->where('category', 'cursoslibres')
                ]
                )->withCount(['courseSections', 'courseChapters'])
                ->withSum('courseChapters', 'duration');
    }

    public function attachSectionRelationships($query)
    {
        return $query->with('sectionChapters')
                    ->orderBy('section_order', 'ASC')
                    ->withSum('sectionChapters', 'duration')
                    ->withCount('sectionChapters');
    }

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
    
    // CLASSROOM FREE COURSE

    public function getPendingAndFinishedCourses($allCourses, $coursesProgress)
    {
        $followingCourses = $allCourses->whereIn('id', $coursesProgress->keys()->all());

        $pendingCourses = collect();
        $finishedCourses = collect();

        foreach ($followingCourses as $followingCourse) {
            $courseProgress = $coursesProgress[$followingCourse->id];
            $Nprogress = getCompletedChapters($courseProgress);

            if ($followingCourse->course_chapters_count == $Nprogress) {
                $finishedCourses->push($followingCourse);
            } else {
                $pendingCourses->push($followingCourse);
            }
        }

        return array($pendingCourses, $finishedCourses);
    }

    public function getNextChapter($nextSections, SectionChapter $currentChapter)
    {
        $next_chapter = null;
        $i = 0;
        foreach ($nextSections as $section) {
            $next_chapter = $i == 0 ?
                $section->sectionChapters
                ->where('chapter_order', $currentChapter->chapter_order + 1)
                ->first()
                : $section->sectionChapters
                ->where('chapter_order', 1)
                ->first();

            if ($next_chapter != null) {
                break;
            }
            $i++;
        }

        return $next_chapter;
    }

    public function getPreviousChapter($previousSections, SectionChapter $currentChapter)
    {
        $previousChapter = null;
        $i = 0;
        foreach ($previousSections as $section) {
            $previousChapter = $i == 0 ?
                $section->sectionChapters
                ->where('chapter_order', $currentChapter->chapter_order - 1)
                ->first()
                : $section->sectionChapters
                ->where('chapter_order', count($section->sectionChapters))
                ->first();
    
            if ($previousChapter != null) {
                break;
            }
    
            $i++;
        }
    
        return $previousChapter;
    }


    // ADMIN FREE COURSE

    public function getCoursesDataTable(int $category_id = null)
    {
        $query = Course::with([
            'courseCategory',
        ])
            ->withCount(['courseSections', 'courseChapters'])
            ->withSum('courseChapters', 'duration')
            ->where('course_type', 'FREE');

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        $allCourses = DataTables::of($query)
            ->editColumn('description', function ($course) {
                return '<a href="' . route('admin.freeCourses.courses.index', $course) . '">' . $course->description . '</a>';
            })
            ->editColumn('course_category.description', function ($course) {
                $category = $course->courseCategory;
                return '<a href="' . route('admin.freeCourses.categories.index', $category) . '">' . $course->courseCategory->description . '</a>';
            })
            ->addColumn('sections', function ($course) {
                return $course->course_sections_count;
            })
            ->addColumn('chapters', function ($course) {
                return $course->course_chapters_count;
            })
            ->addColumn('duration', function ($course) {
                return getFreeCourseTime($course->course_chapters_sum_duration);
            })
            ->editColumn('active', function ($course) {
                $status = $course->active == 'S' ? 'active' : 'inactive';
                $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                $statusBtn = '<span class="status ' . $status . '">' . $txtBtn . '</span>';

                return $statusBtn;
            })
            ->addcolumn('recom', function ($course) {
                $recomBtn = $course->flg_recom == 1 ?
                    '<i class="fa-solid fa-star flg-recom-btn active"></i>' :
                    '<i class="fa-regular fa-star flg-recom-btn"></i>';

                return $recomBtn;
            })
            ->rawColumns(['description', 'course_category.description', 'active', 'recom'])
            ->make(true);

        return $allCourses;
    }

    // CATEGORY 

    public function storeCategory($request, $storage)
    {
        $data = normalizeInputStatus($request->validated());

        $categoryModel = CourseCategory::create($data + [
            "url_img" => '',
        ]);

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

    public function updateCategory($request, $storage, CourseCategory $categoryModel)
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

    public function destroyCategory($storage, CourseCategory $categoryModel)
    {
        app(FileService::class)->destroy($categoryModel->file, $storage);

        return $categoryModel->delete();

        throw new Exception('No es posible eliminar el registro');
    }   

    // SHOW COURSE

    public function getChaptersDataTable($section_id)
    {
        $allChapters = DataTables::of(
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
                                    data-send="' . route('admin.freeCourses.chapters.getData', $chapter) . '"
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

    public function updateCourse($request, Course $course)
    {
        // app(FileService::class)->
    }
}
