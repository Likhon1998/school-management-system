<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->text('content');
            $table->enum('target_audience', ['all', 'teachers', 'students', 'parents', 'specific_class'])->default('all');
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('cascade');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('low');
            $table->foreignId('published_by')->constrained('users')->onDelete('cascade');
            $table->date('publish_date');
            $table->date('expire_date')->nullable();
            $table->enum('status', ['active', 'expired', 'draft'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
