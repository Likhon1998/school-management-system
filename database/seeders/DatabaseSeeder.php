<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset Spatie cache first/last
        app('cache')->forget('spatie.permission.cache');

        $guard = 'web';

        /**
         * PERMISSIONS MATRIX (from PDF features)
         * Convention: "<action> <resource>"
         * CRUD = view/create/edit/delete
         */
        $resources = [
            // -------- User & RBAC (User Management) --------
            'users'           => ['view','create','edit','delete'],
            'roles'           => ['view','create','edit','delete'],
            'permissions'     => ['view','create','edit','delete'],
            // -------- Academic Structure (classes/sections/subjects/years, syllabus, routine) --------
            'academic_years'  => ['view','create','edit','delete'],
            'classes'         => ['view','create','edit','delete'],
            'sections'        => ['view','create','edit','delete'],
            'subjects'        => ['view','create','edit','delete'],
            'syllabi'         => ['view','create','edit','delete'],
            'timetables'      => ['view','create','edit','delete'],
            // -------- Student Management --------
            'students'        => ['view','create','edit','delete','show'],
            'student_promotions' => ['view','create'],
            'student_transfers'  => ['view','create'],
            'student_records'    => ['view','create','edit'],
            'student_academic_history' => ['view','create','edit','delete'],
            // -------- Teacher Management --------
            'teachers'        => ['view','create','edit','delete'],
            'teacher_subjects' => ['view','create','edit','delete'],
            'class_teachers'   => ['view','create','edit','delete'],
            'salaries'         => ['view','create','edit','delete'],
            // -------- Attendance (Students & Teachers) --------
            'student_attendance' => ['view','create','edit','delete'],
            'teacher_attendance' => ['view','create','edit','delete'],
            // -------- Exams & Results --------
            'examinations'    => ['view','create','edit','delete'],
            'exam_schedules'  => ['view','create','edit','delete'],
            'exam_results'    => ['view','create','edit','delete'],
            'grades'          => ['view','create','edit','delete'],
            'assignments'     => ['view','create','edit','delete'],
            // -------- Financial Management --------
            'fee_structures'  => ['view','create','edit','delete'],
            'fee_payments'    => ['view','create','edit','delete'],
            'expenses'        => ['view','create','edit','delete'],
            'scholarships'    => ['view','create','edit','delete'],
            'financial_reports' => ['view'],
            // -------- Communication --------
            'notices'         => ['view','create','edit','delete','publish'],
            'sms_logs'        => ['view','create'],
            'messages'        => ['view','create','delete'],
            'events'          => ['view','create','edit','delete'],
            // -------- Reports & Analytics --------
            'reports'         => ['view'],
            'student_fees'     => ['view','create','edit','delete','show','history'],
        ];

        // Build/create permissions
        $allPermissionNames = [];
        foreach ($resources as $resource => $actions) {
            foreach ($actions as $action) {
                $name = "{$action} {$resource}";
                $allPermissionNames[] = $name;
                Permission::firstOrCreate(['name' => $name, 'guard_name' => $guard]);
            }
        }

        // Super Admin role gets EVERYTHING
        $superAdmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => $guard]);
        $superAdmin->syncPermissions(Permission::whereIn('name', $allPermissionNames)->get());

        // Ensure Super Admin user exists (using username instead of name)
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'], // Ensure email is unique
            ['username' => 'superadmin', 'password' => bcrypt('123456789')] // Use 'username' instead of 'name'
        );

        // Assign the 'superadmin' role to the user
        if (! $user->hasRole('superadmin')) {
            $user->assignRole('superadmin');
        }

        // Clear Spatie permission cache
        app('cache')->forget('spatie.permission.cache');
    }
}
