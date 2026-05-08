<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('instructor:id,name');

        if ($request->mine && $request->user()) {
            $query->where('instructor_id', $request->user()->id);
        }

        return response()->json($query->latest()->get());
    }

    public function show(Course $course)
    {
        return response()->json(
            $course->load('instructor:id,name', 'lessons', 'quizzes')
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'level' => 'nullable|in:Beginner,Intermediate,Advanced',
            'price' => 'nullable|numeric',
            'thumbnail' => 'nullable|string',
            'duration' => 'nullable|string',
        ]);

        $data['instructor_id'] = $request->user()->id;

        $course = Course::create($data);

        return response()->json(
            $course->load('instructor:id,name'),
            201
        );
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'level' => 'nullable|in:Beginner,Intermediate,Advanced',
            'price' => 'nullable|numeric',
            'thumbnail' => 'nullable|string',
            'duration' => 'nullable|string',
        ]);

        $course->update($data);

        return response()->json(
            $course->load('instructor:id,name')
        );
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Course deleted'
        ]);
    }
}