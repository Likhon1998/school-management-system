<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    // List all students
    public function index()
    {
        $students = Student::with(['user', 'class', 'section', 'academicYear'])->paginate(10);
        return view('students.index', compact('students'));
    }

    // Show create form
    public function create()
    {
        $users = User::where('status', 'active')->get();
        $classes = ClassModel::where('status', 'active')->get();
        $sections = Section::where('status', 'active')->get();
        $academicYears = AcademicYear::where('status', 'active')->get();

        return view('students.create', compact('users', 'classes', 'sections', 'academicYears'));
    }

    // Store new student
    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:100',
            'admission_number' => 'required|string|unique:students,admission_number',
            'admission_date' => 'required|date',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'roll_number' => 'nullable|integer',
            'blood_group' => 'nullable|string|max:5',
            'religion' => 'nullable|string|max:20',
            'nationality' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'email' => 'required|email|unique:users,email|unique:students,email',
            'parent_email' => 'nullable|email|unique:students,parent_email',
            'emergency_contact' => 'nullable|string|max:15',
            'father_name' => 'nullable|string|max:100',
            'father_phone' => 'nullable|string|max:15',
            'father_occupation' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
            'mother_phone' => 'nullable|string|max:15',
            'guardian_name' => 'nullable|string|max:100',
            'guardian_phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,inactive,transferred',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create User first
        $user = User::create([
            'username' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'status' => $request->status,
        ]);

        $data = $request->all();
        $data['user_id'] = $user->id;

        // Auto-generate student_id if empty
        if (empty($data['student_id'])) {
            $lastStudent = Student::latest('id')->first();
            $number = $lastStudent ? $lastStudent->id + 1 : 1;
            $data['student_id'] = 'STU-' . str_pad($number, 4, '0', STR_PAD_LEFT);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student and user account created successfully.');
    }

    // Show edit form
    public function edit(Student $student)
    {
        $users = User::where('status', 'active')->get();
        $classes = ClassModel::where('status', 'active')->get();
        $sections = Section::where('status', 'active')->get();
        $academicYears = AcademicYear::where('status', 'active')->get();

        return view('students.edit', compact('student', 'users', 'classes', 'sections', 'academicYears'));
    }

    // Update student
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_name' => 'required|string|max:100',
            'admission_number' => 'required|string|unique:students,admission_number,' . $student->id,
            'admission_date' => 'required|date',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'roll_number' => 'nullable|integer',
            'blood_group' => 'nullable|string|max:5',
            'religion' => 'nullable|string|max:20',
            'nationality' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'email' => 'required|email|unique:users,email,' . $student->user_id . '|unique:students,email,' . $student->id,
            'parent_email' => 'nullable|email|unique:students,parent_email,' . $student->id,
            'emergency_contact' => 'nullable|string|max:15',
            'father_name' => 'nullable|string|max:100',
            'father_phone' => 'nullable|string|max:15',
            'father_occupation' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
            'mother_phone' => 'nullable|string|max:15',
            'guardian_name' => 'nullable|string|max:100',
            'guardian_phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,inactive,transferred',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->all();

        // Update User
        $userData = [
            'email' => $request->email,
            'status' => $request->status,
        ];
        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }
        $student->user()->update($userData);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student and user account updated successfully.');
    }

    // Delete student
    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        // Delete associated user
        if ($student->user) {
            $student->user->delete();
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student and user account deleted successfully.');
    }

    // Show student details
    public function show(Student $student)
    {
        $student->load(['user', 'class', 'section', 'academicYear']);
        return view('students.show', compact('student'));
    }

    // AJAX: Get next Student ID
    public function getNextStudentId()
    {
        $lastStudent = Student::latest('id')->first();
        $number = $lastStudent ? $lastStudent->id + 1 : 1;
        $nextId = 'STU-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        return response()->json(['student_id' => $nextId]);
    }
}
