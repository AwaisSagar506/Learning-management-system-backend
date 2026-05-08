<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        return response()->json(
            Quiz::with('course:id,title')->latest()->get()
        );
    }

    public function show(Quiz $quiz)
    {
        return response()->json($quiz);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'questions' => 'required|array|min:1',
        ]);

        return response()->json(
            Quiz::create($data),
            201
        );
    }

    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'title' => 'sometimes|string',
            'course_id' => 'sometimes|exists:courses,id',
            'questions' => 'sometimes|array',
        ]);

        $quiz->update($data);

        return response()->json($quiz);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return response()->json([
            'message' => 'Quiz deleted'
        ]);
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'answers' => 'required|array'
        ]);

        $score = 0;

        foreach ($quiz->questions as $i => $q) {
            if (isset($request->answers[$i]) && $request->answers[$i] == $q['correct']) {
                $score++;
            }
        }

        $result = QuizResult::create([
            'user_id' => $request->user()->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total' => count($quiz->questions),
            'answers' => $request->answers,
        ]);

        return response()->json([
            'id' => $result->id,
            'quizId' => $quiz->id,
            'quizTitle' => $quiz->title,
            'score' => $score,
            'total' => count($quiz->questions),
            'date' => $result->created_at->toIso8601String(),
        ], 201);
    }

    public function myResults(Request $request)
    {
        return response()->json(
            $request->user()
                ->quizResults()
                ->with('quiz:id,title')
                ->latest()
                ->get()
                ->map(fn ($r) => [
                    'id' => $r->id,
                    'quizId' => $r->quiz_id,
                    'quizTitle' => $r->quiz?->title,
                    'score' => $r->score,
                    'total' => $r->total,
                    'date' => $r->created_at->toIso8601String(),
                ])
        );
    }
}