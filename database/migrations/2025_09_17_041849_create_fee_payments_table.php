<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('fee_structure_id')->constrained('fee_structures')->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['cash', 'bank', 'mobile_banking']);
            $table->string('receipt_number')->unique();
            $table->enum('status', ['paid', 'partial', 'pending'])->default('pending');

            // New field
            $table->string('remarks', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
