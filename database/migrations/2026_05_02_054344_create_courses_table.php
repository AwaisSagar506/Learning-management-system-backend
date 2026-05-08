<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            $table->string('category')->default('General');

            $table->enum('level', [
                'Beginner',
                'Intermediate',
                'Advanced'
            ])->default('Beginner');

            $table->decimal('price', 8, 2)->default(0);

            $table->string('thumbnail')->nullable();
            $table->string('duration')->default('0h');

            $table->foreignId('instructor_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->integer('students')->default(0);
            $table->decimal('rating', 2, 1)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};