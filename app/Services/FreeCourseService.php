<?php

namespace App\Services;

use App\Models\{Course, SectionChapter};
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
        )
        ->where('course_type', 'FREE')
        ->withCount(['courseSections', 'courseChapters'])
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
        )
        ->where('course_type', 'FREE')
        ->withCount(['courseSections', 'courseChapters'])
            ->withSum('courseChapters', 'duration');
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
                $status = $course->active;
                return '<span class="status ' . getStatusClass($status) . '">' .
                            getStatusText($status) .
                        '</span>';
            })
            ->addcolumn('recom', function ($course) {
                return getStatusRecomended($course->flg_recom);
            })
            ->rawColumns(['description', 'course_category.description', 'active', 'recom'])
            ->make(true);

        return $allCourses;
    }


    public function store($request, $storage)
    {
        $data = normalizeInputStatus($request->validated());

        $course = Course::create($data + [
            "course_type" => 'FREE',
            "date" => getCurrentDate(),
            "hours" => 0,
            "time_start" => '0:00:00',
            "time_end" => '0:00:00'
        ]);

        if ($course) {
            if ($request->hasFile('image')) {

                $file_type = 'imagenes';
                $category = 'cursoslibres';
                $belongsTo = 'cursoslibres';
                $relation = 'one_one';

                $file = $request->file('image');

                app(FileService::class)->store(
                    $course,
                    $file_type,
                    $category,
                    $file,
                    $storage,
                    $belongsTo,
                    $relation
                );
            }

            return $course;
        }

        throw new Exception(config('parameters.exception_message'));
    }


    public function update($request, $storage, Course $course)
    {
        $data = normalizeInputStatus($request->validated());

        $isUpdated = $course->update($data);

        if ($isUpdated) {
            if ($request->hasFile('image')) {
                app(FileService::class)->destroy($course->file, $storage);

                $file_type = 'imagenes';
                $category = 'cursoslibres';
                $file = $request->file('image');
                $belongsTo = 'cursoslibres';
                $relation = 'one_one';

                app(FileService::class)->store(
                    $course,
                    $file_type,
                    $category,
                    $file,
                    $storage,
                    $belongsTo,
                    $relation
                );
            }

            return $isUpdated;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function destroy($storage, Course $course)
    {
        if (app(FileService::class)->destroy($course->file, $storage)) {
            $isDeleted = $course->delete();
            if ($isDeleted) {
                return true;
            }
        };

        throw new Exception(config('parameters.exception_message'));
    }

    public function attachSectionRelationships($query)
    {
        return $query->with('sectionChapters')
            ->orderBy('section_order', 'ASC')
            ->withSum('sectionChapters', 'duration')
            ->withCount('sectionChapters');
    }
}
