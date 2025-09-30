<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    /**
     * Display a listing of the examinations.
     */
    public function index()
    {
        $examinations = Examination::with('academicYear')
                            ->orderBy('start_date', 'desc')
                            ->paginate(10);

        return view('examinations.index', compact('examinations'));
    }

    /**
     * Show the form for creating a new examination.
     */
    public function create()
    {
        $academicYears = AcademicYear::all();
        return view('examinations.create', compact('academicYears'));
    }

    /**
     * Store a newly created examination in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:100',
            'exam_type' => 'required|in:test,half_yearly,annual',
            'academic_year_id' => 'required|exists:academic_years,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        Examination::create($validated);

        return redirect()->route('examinations.index')
                         ->with('success', 'Examination created successfully.');
    }

    /**
     * Show the form for editing the specified examination.
     */
    public function edit(Examination $examination)
    {
        $academicYears = AcademicYear::all();
        return view('examinations.edit', compact('examination', 'academicYears'));
    }

    /**
     * Update the specified examination in storage.
     */
    public function update(Request $request, Examination $examination)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:100',
            'exam_type' => 'required|in:test,half_yearly,annual',
            'academic_year_id' => 'required|exists:academic_years,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        $examination->update($validated);

        return redirect()->route('examinations.index')
                         ->with('success', 'Examination updated successfully.');
    }

    /**
     * Remove the specified examination from storage.
     */
    public function destroy(Examination $examination)
    {
        $examination->delete();

        return redirect()->route('examinations.index')
                         ->with('success', 'Examination deleted successfully.');
    }
}
