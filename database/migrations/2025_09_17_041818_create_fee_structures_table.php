<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->enum('fee_type', ['monthly', 'admission', 'exam', 'annual']);
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            
            // New fields
            $table->enum('month', ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'])->nullable();
            $table->string('exam_name', 100)->nullable();
            $table->string('description', 255)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
