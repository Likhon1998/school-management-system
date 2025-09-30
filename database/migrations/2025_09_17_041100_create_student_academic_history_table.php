<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_academic_history', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->integer('roll_number')->nullable();
            $table->enum('promotion_status', ['promoted', 'failed', 'transferred'])->default('promoted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_academic_history');
    }
};
