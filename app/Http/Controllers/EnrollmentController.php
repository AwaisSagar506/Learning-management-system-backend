<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            $request->user()
                ->enrollments()
                ->with('course.instructor:id,name')
                ->get()
        );
    }

    public function enroll(Request $request, Course $course)
    {
        $enrollment = Enrollment::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'course_id' => $course->id
            ],
            [
                'progress' => 0,
                'completed_lessons' => []
            ]
        );

        $course->increment('students');

        return response()->json(
            $enrollment->load('course'),
            201
        );
    }

    public function completeLesson(Request $request, Course $course)
    {
        $request->validate([
            'lesson_id' => 'required|integer'
        ]);

        $enrollment = Enrollment::where('user_id', $request->user()->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $completed = $enrollment->completed_lessons ?? [];

        if (!in_array($request->lesson_id, $completed)) {
            $completed[] = $request->lesson_id;
        }

        $total = $course->lessons()->count() ?: 1;

        $enrollment->update([
            'completed_lessons' => $completed,
            'progress' => round((count($completed) / $total) * 100),
        ]);

        return response()->json($enrollment);
    }
}