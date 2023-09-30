<?php

namespace App\Services;

use App\Models\{Course, CourseSection};
use Exception;

class CourseSectionService
{
    public function store($request, Course $course)
    {
        $lastOrder = $course->getSectionLastOrder();

        $section = CourseSection::create($request + [
            "section_order" => $lastOrder + 1
        ]);

        if ($section) {
            return $section;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function update($request, CourseSection $section)
    {
        $this->updateOrder($request['section_order'], $section);

        $isUpdated = $section->update([
            "title" => $request['title']
        ]);

        if ($isUpdated) {
            return true;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function updateOrder($order, CourseSection $section)
    {
        $success = true;

        if ($section->section_order != $order) {

            CourseSection::where('course_id', $section->course_id)
                ->where('section_order', $order)
                ->update([
                    "section_order" => $section->section_order
                ]);

            $success = $section->update([
                "section_order" => $order
            ]);
        }

        return $success;
    }

    public function destroy(CourseSection $section)
    {
        $course_id = $section->course_id;

        $isDeleted =  $section->delete();

        if ($isDeleted) {
            $this->updateAllOrders($course_id);
            return true;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    private function updateAllOrders($course_id)
    {
        $sections = CourseSection::where('course_id', $course_id)
            ->orderBy('section_order', 'ASC')->get();

        $order = 1;
        foreach ($sections as $section) {
            $section->update([
                "section_order" => $order
            ]);
            $order++;
        }
    }
}
