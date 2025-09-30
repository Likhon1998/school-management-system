<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Student IDs
            $table->string('student_id', 20)->unique(); // auto-generated
            $table->string('government_id', 50)->nullable()->unique(); // government ID

            // Personal Info
            $table->string('student_name', 100)->nullable();
            $table->date('admission_date');
            $table->string('admission_number', 20)->unique();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->integer('roll_number')->nullable();
            $table->string('blood_group', 5)->nullable();
            $table->string('religion', 20)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('address', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('parent_email', 100)->nullable()->unique();
            $table->string('emergency_contact', 15)->nullable();
            $table->text('medical_info')->nullable();

            // Parent / Guardian Info
            $table->string('father_name', 100)->nullable();
            $table->string('father_phone', 15)->nullable();
            $table->string('father_occupation', 100)->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->string('mother_phone', 15)->nullable();
            $table->string('guardian_name', 100)->nullable();
            $table->string('guardian_phone', 15)->nullable();

            // Status & timestamps
            $table->enum('status', ['active', 'inactive', 'transferred'])->default('active');
            $table->timestamps();
            $table->softDeletes(); // optional: keep deleted records
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
