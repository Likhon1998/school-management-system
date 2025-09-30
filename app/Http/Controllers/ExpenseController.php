<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the expenses.
     */
    public function index()
    {
        $expenses = Expense::with('approver')->latest()->paginate(15);
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new expense.
     */
    public function create()
    {
        $users = User::all();
        return view('expenses.create', compact('users'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'expense_category' => 'required|string|max:100',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:50|unique:expenses,receipt_number',
            'approved_by' => 'nullable|exists:users,id',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')
                         ->with('success', 'Expense added successfully.');
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit(Expense $expense)
    {
        $users = User::all();
        return view('expenses.edit', compact('expense', 'users'));
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_category' => 'required|string|max:100',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:50|unique:expenses,receipt_number,' . $expense->id,
            'approved_by' => 'nullable|exists:users,id',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')
                         ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')
                         ->with('success', 'Expense deleted successfully.');
    }
}
