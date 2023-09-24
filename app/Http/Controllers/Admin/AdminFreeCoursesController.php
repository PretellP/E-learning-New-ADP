<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Owenoj\LaravelGetId3\GetId3;
use Yajra\DataTables\DataTables;

use App\Models\{CourseCategory, Course, CourseSection, SectionChapter};
use App\Services\FreeCourseService;
use Exception;

class AdminFreeCoursesController extends Controller
{
    private $freeCourseService;

    public function __construct(FreeCourseService $service)
    {
        $this->freeCourseService = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->freeCourseService->getCoursesDataTable();
        }

        $categories = $this->freeCourseService->withCategoryRelationshipsQuery()->get();

        return view('admin.free-courses.index', [
            'categories' => $categories
        ]);
    }

    public function storeCategory(CategoryRequest $request) 
    {
        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->freeCourseService->storeCategory($request, $storage);
            
            $categories = $this->freeCourseService->withCategoryRelationshipsQuery()->get();

            $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();

        }catch(Exception $e){
            abort(500, $e->getMessage());
        }

        return response()->json([
            "success" => true,
            "html" => $html
        ]);
    }

    public function getDataCategory(CourseCategory $category)
    {
        $category->loadImage();
        $url_img = verifyImage($category->file);

        return response()->json([
            "description" => $category->description,
            "status" => $category->status,
            "url_img" => $url_img
        ]);
    }

    public function updateCategory(CategoryRequest $request, CourseCategory $category)
    {
        $category->loadImage();
        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->freeCourseService->updateCategory($request, $storage, $category);
        }catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($request['place'] == 'show') {
            $category->loadImage();
            $html = view('admin.free-courses.partials.category-box', compact('category'))->render();
            return response()->json([
                'html' => $html,
                'description' => mb_strtolower($category->description, 'UTF-8')
            ]);
        } else {
            $categories = CourseCategory::with(['courses', 'file'])->get();
            $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();

            return response()->json([
                'html' => $html
            ]);
        }
    }

    public function destroyCategory(Request $request, CourseCategory $category)
    {
        $category->loadImage();
        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->freeCourseService->destroyCategory($storage, $category);
        }catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($request->has('place')) {
            return response()->json([
                "route" => route('admin.freeCourses.index')
            ]);
        } else {
            $categories = CourseCategory::with(['courses', 'file'])->get();
            $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
    }

    public function getCategoriesRegisterCourse()
    {
        return response()->json([
            "categories" => CourseCategory::all()
        ]);
    }

    public function storeFreecourse(Request $request)
    {
        $status = $request['courseStatusCheckbox'] == 'on' ? 'S' : 'N';
        $recom = $request['courseRecomCheckbox'] == 'on' ? 1 : 0;

        $path = 'img/freecourses/';
        $file = $request->file('courseImageRegister');
        $uuid = $file->hashName();
        $storeUrl = $path . $uuid;


        if ($request->has('fixedCategory')) {
            $category = $request['fixedCategory'];
        } else {
            $category = $request['category'];
        }

        $course = Course::create([
            "course_type" => 'FREE',
            "category_id" => $category,
            "description" => $request['name'],
            "subtitle" => $request['subtitle'],
            "date" => getCurrentDate(),
            "hours" => 0,
            "time_start" => '0:00:00',
            "time_end" => '0:00:00',
            "url_img" => $storeUrl,
            "active" => $status,
            "flg_recom" => $recom,
            'flg_public' => 'N'
        ]);

        if ($course) {
            Storage::putFileAs($path, $file, $uuid);
        }

        if ($request['verifybtn'] == 'show') {
            $route = route('admin.freeCourses.courses.index', $course);

            return response()->json([
                "show" => true,
                "route" => $route
            ]);
        } else {
            if ($request->has('fixedCategory')) {
                $category = CourseCategory::where('id', $category)->with('courses')->first();
                $html = view('admin.free-courses.partials.category-box', compact('category'))->render();
            } else {
                $categories = CourseCategory::with('courses')->get();
                $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();
            }

            return response()->json([
                "show" => false,
                "success" => true,
                "html" => $html
            ]);
        }
    }



    // ------- CATEGORIES INDEX ----------


    public function showCategory(Request $request, CourseCategory $category)
    {
        if ($request->ajax()) {
            return $this->freeCourseService->getCoursesDataTable($category->id);
        }

        $category->loadImage();

        return view('admin.free-courses.categories.index', [
            'category' => $category,
        ]);
    }

    // ---- FREE COURSE INDEX --------------

    public function showCourse(Course $course)
    {
        $course->loadFreeCourseRelationships();

        $sectionActive = '';

        return view('admin.free-courses.courses.index', [
            'course' => $course,
            'sectionActive' => $sectionActive
        ]);
    }

    public function getDataCourse(Course $course)
    {
        $course->loadFreeCourseImage();

        $url_img = verifyImage($course->file);

        return response()->json([
            "description" => $course->description,
            "subtitle" => $course->subtitle,
            "status" => $course->active,
            "recom" => $course->flg_recom,
            "url_img" => $url_img
        ]);
    }

    public function updateFreecourse(Request $request, Course $course)  // FALTA
    {
        $status = $request['courseStatusCheckbox'] == 'on' ? 'S' : 'N';
        $recom = $request['courseRecomCheckbox'] == 'on' ? 1 : 0;

        $course->loadFreeCourseRelationships();

        $this->freeCourseService->updateCourse($request, $course); // FALTA

        if ($request->hasFile('courseImageEdit')) {
            $path = 'img/freecourses/';
            $file_path = $course->url_img;
            if ($course->url_img != null && Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $file = $request->file('courseImageEdit');
            $uuid = $file->hashName();
            $store_url = $path . $uuid;

            Storage::putFileAs($path, $file, $uuid);
            $url_img = $store_url;
        } else {
            $url_img = $course->url_img;
        }

        $course->update([
            "description" => $request['name'],
            "subtitle" => $request['subtitle'],
            "url_img" => $url_img,
            "active" => $status,
            "flg_recom" => $recom
        ]);

        $html = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $description = mb_strtolower($course->description, 'UTF-8');

        return response()->json([
            "success" => true,
            "description" => $description,
            "html" => $html
        ]);
    }

    public function destroyCouse(Course $course) // FALTA
    {
        $img_path = $course->url_img;
        Storage::delete($img_path);
        $course->delete();

        $category = $course->courseCategory;

        return response()->json([
            "route" => route('admin.freeCourses.categories.index', $category)
        ]);
    }

    public function updateSectionOrder(Request $request, CourseSection $section) // FALTA
    {
        $order = $request['value'];

        if ($section->section_order != $order) {

            CourseSection::where('course_id', $section->course_id)
                ->where('section_order', $order)
                ->update([
                    "section_order" => $section->section_order
                ]);

            $section->update([
                "section_order" => $order
            ]);
        }

        $course = $section->course->loadFreeCourseRelationships();

        $sectionActive = getActiveSection($request['id']);

        $html = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "html" => $html
        ]);
    }

    public function storeSection(Request $request, Course $course) // FALTA
    {
        parse_str($request['form'], $form);

        $course->loadMax('courseSections', 'section_order'); 

        $lastOrder = $course->course_sections_max_section_order == null ?
                    0 : $course->course_sections_max_section_order;

        $section = CourseSection::create([
            "title" => $form['title'],
            "section_order" => $lastOrder + 1,
            "course_id" => $course->id
        ]);

        $course->loadFreeCourseRelationships();

        $sectionActive = getActiveSection($request['id']);

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection
        ]);
    }

    public function getDataSection(CourseSection $section)
    {
        $sections = CourseSection::where('course_id', $section->course_id)
                    ->orderBy('section_order', 'ASC')
                    ->get(['id', 'section_order', 'course_id']);

        return response()->json([
            "title" => $section->title,
            "sections" => $sections,
            'order' => $section->section_order
        ]);
    }

    public function updateSection(Request $request, CourseSection $section) // FALTA
    {
        parse_str($request['form'], $form);

        if ($section->section_order != $form['order']) {
            CourseSection::where('course_id', $section->course_id)
                ->where('section_order', $form['order'])
                ->update([
                    "section_order" => $section->section_order
                ]);
        }

        $section->update([
            "title" => $form['title'],
            "section_order" => $form['order'],
        ]);

        $course = $section->course->loadFreeCourseRelationships();
        
        $sectionActive = getActiveSection($request['id']);

        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "htmlSection" => $htmlSection,
            "active" => $sectionActive,
            "id" => $section->id,
            "title" => $section->title
        ]);
    }


    public function destroySection(Request $request, CourseSection $section) // FALTA
    {
        $course_id = $section->course_id;
        $section->delete();

        $sections = CourseSection::where('course_id', $course_id)
                    ->orderBy('section_order', 'ASC')->get();

        $order = 1;
        foreach ($sections as $section) {
            $section->update([
                "section_order" => $order
            ]);
            $order++;
        }

        $is_active = 0;
        $htmlChapter = '';

        $course = $this->freeCourseService->withFreeCourseRelationshipsQuery()
                                            ->where('id', $course_id)
                                            ->first();

        $sectionActive = getActiveSection($request['id']);

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        if ($request['active'] == 'active') {
            $htmlChapter  = view('admin.free-courses.partials.chapter-list-empty')->render();
            $is_active = 1;
        }

        return response()->json([
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection,
            "is_active" => $is_active,
            "htmlChapter" => $htmlChapter
        ]);
    }

    public function getChapterTable(Request $request, CourseSection $section)
    {
        if ($request->ajax()) {

            if ($request['type'] == 'html') {

                $html = view('admin.free-courses.partials.chapters-list', compact('section'))->render();

                return response()->json([
                    "html" => $html,
                    'title' => $section->title,
                ]);
            } elseif ($request['type'] == 'table') {
                return $this->freeCourseService->getChaptersDataTable($section->id);
            }
        }
        abort(403);
    }

    public function storeChapter(Request $request, CourseSection $section) // FALTA
    {
        $section->loadMax('sectionChapters', 'chapter_order');

        $videoDur = new GetId3($request->file('file'));
        $duration = round($videoDur->getPlaytimeSeconds() / 60);

        $path = 'videos/freecourses/' . $section->course_id . '/' . $section->id . '/';
        $video = $request->file('file');
        $uuid = $video->hashName();
        $storeUrl = $path . $uuid;

        $lastOrder = $section->section_chapters_max_chapter_order == null ? 0 :
                                $section->section_chapters_max_chapter_order;

        Storage::putFileAs($path, $video, $uuid);

        SectionChapter::create([
            "title" => $request['title'],
            "description" => $request['description'],
            "chapter_order" => $lastOrder + 1,
            "url_video" => $storeUrl,
            "duration" => $duration,
            "section_id" => $section->id
        ]);

        $course = $this->freeCourseService->withFreeCourseRelationshipsQuery()
                                            ->where('id', $section->course_id)
                                            ->first();
            
        $sectionActive = getActiveSection($request['sectionActive']);

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();
        $htmlChapter = view('admin.free-courses.partials.chapters-list', compact('section'))->render();

        return response()->json([
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection,
            "htmlChapter" => $htmlChapter,
            "id" => $section->id,
        ]);
    }

    public function getDataChapter(SectionChapter $chapter)
    {
        $chaptersList = SectionChapter::where('section_id', $chapter->section_id)
            ->orderBy('chapter_order', 'ASC')
            ->get(['id', 'section_id', 'chapter_order']);

        return response()->json([
            "chapter" => $chapter,
            "chapters_list" => $chaptersList
        ]);
    }

    public function updateChapter(Request $request, SectionChapter $chapter) // FALTA
    {
        $order = $request['order'];
        $url_video = $chapter->url_video;
        $duration = $chapter->duration;

        $section = $chapter->courseSection;

        if ($order != $chapter->chapter_order) {
            SectionChapter::where('section_id', $chapter->section_id)
                ->where('chapter_order', $order)
                ->update([
                    "chapter_order" => $chapter->chapter_order
                ]);
        }

        if ($request->has('file')) {

            if ($url_video != null && Storage::exists($url_video)) {
                Storage::delete($url_video);
            }

            $videoDur = new GetId3($request->file('file'));
            $duration = round($videoDur->getPlaytimeSeconds() / 60);

            $path = 'videos/freecourses/' . $section->course_id . '/' . $section->id . '/';
            $video = $request->file('file');
            $uuid = $video->hashName();
            Storage::putFileAs($path, $video, $uuid);
            $url_video = $path . $uuid;
        }

        $chapter->update([
            "title" => $request['title'],
            "description" => $request['description'],
            "chapter_order" => $order,
            "url_video" => $url_video,
            "duration" => $duration
        ]);

        $course = $this->freeCourseService->withFreeCourseRelationshipsQuery()
                                            ->where('id', $section->course_id)
                                            ->first();

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlChapter = view('admin.free-courses.partials.chapters-list', compact('section'))->render();

        return response()->json([
            "htmlChapter" => $htmlChapter,
            "htmlCourse" => $htmlCourse,
            "id" => $section->id
        ]);
    }

    public function getChapterVideoData(SectionChapter $chapter)
    {
        $url_video = asset('storage/' . $chapter->url_video);

        return response()->json([
            "url_video" => $url_video,
            "section" => $chapter->courseSection->title,
            "chapter" => $chapter->title
        ]);
    }

    public function destroyChapter(Request $request, SectionChapter $chapter) // FALTA
    {
        $section = $chapter->courseSection;

        $chapter->progressUsers()->detach();
        $video_path =  $chapter->url_video;
        Storage::delete($video_path);

        $chapter->delete();

        $chapters = SectionChapter::where('section_id', $section->id)
                    ->orderBy('chapter_order', 'ASC')->get();

        $order = 1;
        foreach ($chapters as $remanentChapter) {
            $remanentChapter->update([
                "chapter_order" => $order
            ]);
            $order++;
        }

        $course = $this->freeCourseService->withFreeCourseRelationshipsQuery()
                                            ->where('id', $section->course_id)
                                            ->first();

        $sectionActive = getActiveSection($request['id']);

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();
        $htmlChapter = view('admin.free-courses.partials.chapters-list', compact('section'))->render();

        return response()->json([
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection,
            "htmlChapter" => $htmlChapter,
            "id" => $section->id
        ]);
    }
}
