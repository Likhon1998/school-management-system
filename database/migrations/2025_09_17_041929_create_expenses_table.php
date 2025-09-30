<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_category', 100); // Salary, Utilities, Maintenance, etc.
            $table->decimal('amount', 10, 2);
            $table->date('expense_date');
            $table->text('description')->nullable();
            $table->string('receipt_number')->nullable();
            $table->foreignId('approved_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
