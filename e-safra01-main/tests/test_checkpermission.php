<?php
// Test des permissions utilisateurs (User permissions test)
// This test checks if users with different roles (admin, instructor, student) can access restricted actions.
include __DIR__ . '/../Config.php';
include __DIR__ . '/../Database.php';

function check_permission($role, $action) {
    // Simulate a permissions matrix (customize as needed)
    $permissions = [
        'admin' => ['manage_users', 'manage_courses', 'view_reports'],
        'instructor' => ['manage_courses', 'view_reports'],
        'student' => ['view_courses'],
    ];
    $allowed = in_array($action, $permissions[$role] ?? []);
    echo ucfirst($role) . " access to '$action': " . ($allowed ? "ALLOWED" : "DENIED") . "\n";
}

// Example permission checks
check_permission('admin', 'manage_users');      // Should be ALLOWED
check_permission('admin', 'view_courses');      // Should be DENIED
check_permission('instructor', 'manage_courses'); // Should be ALLOWED
check_permission('student', 'manage_users');    // Should be DENIED
check_permission('student', 'view_courses');    // Should be ALLOWED