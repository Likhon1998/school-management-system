<?php


namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index() {
    $years = AcademicYear::orderBy('start_date', 'desc')->paginate(10);
    return view('academic_years.index', compact('years'));
    }


    public function create() {
        return view('academic_years.create');
    }

    public function store(Request $request) {
        $request->validate([
            'year_name' => 'required|unique:academic_years',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive'
        ]);

        AcademicYear::create($request->all());

        return redirect()->route('academic_years.index')
            ->with('success','Academic year created successfully.');
    }

    public function edit(AcademicYear $academicYear) {
        return view('academic_years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear) {
        $request->validate([
            'year_name' => 'required|unique:academic_years,year_name,'.$academicYear->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive'
        ]);

        $academicYear->update($request->all());

        return redirect()->route('academic_years.index')
            ->with('success','Academic year updated successfully.');
    }

    public function destroy(AcademicYear $academicYear) {
        $academicYear->delete();
        return redirect()->route('academic_years.index')
            ->with('success','Academic year deleted successfully.');
    }
}
