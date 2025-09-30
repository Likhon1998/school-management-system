<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name', 100);
            $table->enum('exam_type', ['test', 'half_yearly', 'annual']);
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['upcoming', 'ongoing', 'completed']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
