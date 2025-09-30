<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    protected $fillable = [
        'expense_category',
        'amount',
        'expense_date',
        'description',
        'receipt_number',
        'approved_by',
    ];

    /**
     * Relation to the user who approved the expense.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
