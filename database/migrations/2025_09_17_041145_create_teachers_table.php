<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_name', 100);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('employee_id', 20)->unique();
            $table->date('joining_date');
            $table->string('designation', 50);
            $table->string('qualification', 200)->nullable();
            $table->integer('experience')->default(0);
            $table->decimal('salary', 10, 2)->default(0);
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive', 'resigned'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
