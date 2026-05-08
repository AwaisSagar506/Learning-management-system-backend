<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::create([
            'name' => 'Alice Admin',
            'email' => 'admin@lms.io',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'avatar' => 'https://i.pravatar.cc/100?img=1',
        ]);

        $instructor = User::create([
            'name' => 'Ian Instructor',
            'email' => 'instructor@lms.io',
            'password' => Hash::make('inst123'),
            'role' => 'instructor',
            'avatar' => 'https://i.pravatar.cc/100?img=12',
        ]);

        $instructor2 = User::create([
            'name' => 'Maria Rossi',
            'email' => 'maria@lms.io',
            'password' => Hash::make('pass123'),
            'role' => 'instructor',
            'avatar' => 'https://i.pravatar.cc/100?img=20',
        ]);

        User::create([
            'name' => 'Sara Student',
            'email' => 'student@lms.io',
            'password' => Hash::make('stud123'),
            'role' => 'student',
            'avatar' => 'https://i.pravatar.cc/100?img=5',
        ]);

        // Courses
        $c1 = Course::create([
            'title' => 'Mastering React 18',
            'description' => 'Build modern, scalable apps with React, Hooks, and Context API.',
            'category' => 'Web Development',
            'level' => 'Intermediate',
            'price' => 49,
            'instructor_id' => $instructor->id,
            'thumbnail' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=600',
            'duration' => '12h',
            'students' => 1240,
            'rating' => 4.8,
        ]);

        $c2 = Course::create([
            'title' => 'Laravel 11 from Scratch',
            'description' => 'Backend mastery with Laravel: APIs, Auth, Eloquent, and Deployment.',
            'category' => 'Backend',
            'level' => 'Beginner',
            'price' => 39,
            'instructor_id' => $instructor->id,
            'thumbnail' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600',
            'duration' => '18h',
            'students' => 890,
            'rating' => 4.7,
        ]);

        $c3 = Course::create([
            'title' => 'UI/UX Design Fundamentals',
            'description' => 'Learn design thinking, Figma, and create stunning interfaces.',
            'category' => 'Design',
            'level' => 'Beginner',
            'price' => 29,
            'instructor_id' => $instructor2->id,
            'thumbnail' => 'https://images.unsplash.com/photo-1561070791-2526d30994b8?w=600',
            'duration' => '8h',
            'students' => 2100,
            'rating' => 4.9,
        ]);

        // Lessons
        Lesson::create([
            'course_id' => $c1->id,
            'title' => 'Introduction to React',
            'duration' => '10:30',
            'content' => 'React is a JavaScript library for building user interfaces.',
            'order' => 1
        ]);

        Lesson::create([
            'course_id' => $c1->id,
            'title' => 'JSX & Components',
            'duration' => '15:00',
            'content' => 'Learn JSX and how components compose your UI.',
            'order' => 2
        ]);

        Lesson::create([
            'course_id' => $c1->id,
            'title' => 'Hooks Deep Dive',
            'duration' => '22:10',
            'content' => 'useState, useEffect, useMemo with practical patterns.',
            'order' => 3
        ]);

        Lesson::create([
            'course_id' => $c2->id,
            'title' => 'Setting up Laravel',
            'duration' => '12:00',
            'content' => 'Install Composer, Laravel CLI.',
            'order' => 1
        ]);

        Lesson::create([
            'course_id' => $c2->id,
            'title' => 'Routing & Controllers',
            'duration' => '18:00',
            'content' => 'Define routes and controllers.',
            'order' => 2
        ]);

        Lesson::create([
            'course_id' => $c3->id,
            'title' => 'Design Principles',
            'duration' => '14:00',
            'content' => 'Hierarchy, contrast, alignment, repetition.',
            'order' => 1
        ]);

        // Quizzes
        Quiz::create([
            'course_id' => $c1->id,
            'title' => 'React Fundamentals Quiz',
            'questions' => [
                [
                    'id' => 1,
                    'question' => 'What hook manages state?',
                    'options' => ['useState', 'useEffect', 'useRef', 'useMemo'],
                    'correct' => 0
                ],
                [
                    'id' => 2,
                    'question' => 'JSX stands for?',
                    'options' => ['Java Syntax XML', 'JavaScript XML', 'JSON Syntax', 'None'],
                    'correct' => 1
                ],
                [
                    'id' => 3,
                    'question' => 'Which is NOT a React hook?',
                    'options' => ['useState', 'useFetch', 'useEffect', 'useContext'],
                    'correct' => 1
                ],
            ],
        ]);

        Quiz::create([
            'course_id' => $c2->id,
            'title' => 'Laravel Basics Quiz',
            'questions' => [
                [
                    'id' => 1,
                    'question' => 'Laravel templating engine?',
                    'options' => ['Twig', 'Blade', 'Smarty', 'Pug'],
                    'correct' => 1
                ],
                [
                    'id' => 2,
                    'question' => 'Eloquent is a ___ ?',
                    'options' => ['Templating Engine', 'ORM', 'Router', 'Mailer'],
                    'correct' => 1
                ],
            ],
        ]);
    }
}