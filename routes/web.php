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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permissions Routes
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('/permissions/delete/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Roles Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
});
Route::resource('academic_years', AcademicYearController::class)->middleware('auth');
Route::resource('classes', ClassController::class)->middleware('auth');
Route::resource('sections', SectionController::class)->middleware('auth');
Route::resource('subjects', SubjectController::class)->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class);
});
Route::resource('student_academic_history', StudentAcademicHistoryController::class)->middleware('auth');
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
Route::resource('fee_payments', FeePaymentController::class);
Route::resource('expenses', ExpenseController::class);
Route::get('/students/{student}/id-card/download', [StudentController::class, 'downloadIdCard'])->name('students.idcard.download');
Route::get('/students/next-id', [StudentController::class, 'getNextStudentId'])->name('students.nextId');
Route::get('/students/{student}/student_info', [StudentController::class, 'downloadPdf'])
     ->name('students.student_info');
Route::get('student-fee/{id}/pay', [StudentFeeController::class, 'pay'])->name('student_fee.pay');
Route::post('student-fee/{id}/pay', [StudentFeeController::class, 'storePayment'])->name('student_fee.store_payment');
Route::resource('student_fees', StudentFeeController::class)->middleware('auth');
Route::resource('fee_payments', FeePaymentController::class)->except(['edit']);
Route::get('students/{student}/fee_payments/edit', [FeePaymentController::class, 'editMultiple'])->name('fee_payments.editMultiple');
Route::put('students/{student}/fee_payments', [FeePaymentController::class, 'updateMultiple'])->name('fee_payments.updateMultiple');












require __DIR__ . '/auth.php';
