<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassTeacherController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeePaymentController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Academic\AcademicYearController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentAcademicHistoryController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentFeeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherAttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherSubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile, Role & Permission Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permissions
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('/permissions/delete/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

/*
|--------------------------------------------------------------------------
| Academic & User Management Routes (Admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('academic_years', AcademicYearController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('students', StudentController::class);
    Route::resource('student_academic_history', StudentAcademicHistoryController::class);
    Route::resource('users', UserController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('teacher_subjects', TeacherSubjectController::class);
    Route::resource('class_teachers', ClassTeacherController::class);
    Route::resource('student_attendance', StudentAttendanceController::class);
    Route::resource('teacher_attendance', TeacherAttendanceController::class);
    Route::resource('examinations', ExaminationController::class);
    Route::resource('exam_schedules', ExamScheduleController::class);
    Route::resource('exam_results', ExamResultController::class);
    Route::resource('fee_structures', FeeStructureController::class);
    Route::resource('fee_payments', FeePaymentController::class)->except(['edit']);
    Route::resource('expenses', ExpenseController::class);

    // Admin: Student Fee CRUD (except index/show)
    Route::resource('student_fees', StudentFeeController::class)->except(['index', 'show']);
    Route::post('/student-fees/{studentFee}/pay', [StudentFeeController::class, 'updatePayment'])->name('student_fees.updatePayment');
    Route::delete('/student-fees/{studentFee}', [StudentFeeController::class, 'destroy'])->name('student_fees.destroy');
});

/*
|--------------------------------------------------------------------------
| Student Dashboard & Fee Routes (Student)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('student')->group(function () {
    Route::get('/fees', [StudentFeeController::class, 'index'])->name('student_fees.index'); // Pending dues
    Route::get('/fees/history', [StudentFeeController::class, 'history'])->name('student_fees.history'); // Payment history
});

/*
|--------------------------------------------------------------------------
| AJAX routes (student dues)
|--------------------------------------------------------------------------
*/
Route::get('fee_payments/student-dues/{student}', [FeePaymentController::class, 'getStudentTotalDues'])->name('fee_payments.studentTotalDues');
Route::post('fee_payments/store-total', [FeePaymentController::class, 'storeTotal'])->name('fee_payments.storeTotal');

require __DIR__ . '/auth.php';
