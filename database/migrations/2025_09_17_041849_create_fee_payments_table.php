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

            $table->decimal('amount_paid', 10, 2)->default(0);  // Amount paid in this transaction
            $table->decimal('due_amount', 10, 2)->default(0);     // Remaining due after this payment

            $table->date('payment_date');
            $table->enum('payment_method', ['cash', 'bank', 'mobile_banking'])->default('cash');
            $table->string('receipt_number')->unique();
            $table->enum('status', ['paid', 'partial', 'pending'])->default('pending'); // auto-updated based on payment

            $table->string('remarks', 255)->nullable();
            $table->string('receipt_file', 255)->nullable();  // Receipt upload for evidence

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
