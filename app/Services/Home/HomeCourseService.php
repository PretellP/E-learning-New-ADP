<?php

namespace App\Services\Home;
use App\Models\{Course};

class HomeCourseService
{
    public function getAvailableCourses()
    {
        return Course::whereHas('events', function ($q) {
                $q->where('date', '>=', getCurrentDate())
                ->where('events.active', 'S');
            })
                ->with([
                    'events' => fn ($q2) =>
                    $q2->where('date', '>=', getCurrentDate())
                        ->where('events.active', 'S')
                        ->with(['user', 'room'])
                        ->withCount(['participants' => fn($q) => 
                            $q->where('certifications.evaluation_type', 'certification')
                        ]),

                    'file'  => fn ($q3) =>
                    $q3->where('file_type', 'imagenes')
                        ->where('category', 'cursos')
                ])
                ->where('course_type', 'REGULAR')->get();
    }

    public function getAvailableEvents(Course $course)
    {
        return $course->events()    
                        ->where('date', '>=', getCurrentDate())
                        ->where('events.active', 'S')
                        ->with(['user', 'room', 'participants' => fn($q) =>
                            $q->where('certifications.evaluation_type', 'certification')
                                ->select('users.id')
                        ])
                        ->get();
    }
}
