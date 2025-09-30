<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_phone', 15);
            $table->text('message');
            $table->enum('sms_type', ['attendance', 'fee', 'result', 'notice', 'general'])->default('general');
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('cascade');
            $table->timestamp('sent_date')->nullable();
            $table->enum('status', ['sent', 'failed', 'pending'])->default('pending');
            $table->decimal('cost', 5, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
