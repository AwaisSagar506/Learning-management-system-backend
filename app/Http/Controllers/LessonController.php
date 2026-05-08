<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        return response()->json($course->lessons);
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'duration' => 'nullable|string',
            'content' => 'nullable|string',
        ]);

        $data['order'] = $course->lessons()->count() + 1;

        $lesson = $course->lessons()->create($data);

        return response()->json($lesson, 201);
    }

    public function update(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'sometimes|string',
            'duration' => 'nullable|string',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $lesson->update($data);

        return response()->json($lesson);
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->json([
            'message' => 'Lesson deleted'
        ]);
    }
}