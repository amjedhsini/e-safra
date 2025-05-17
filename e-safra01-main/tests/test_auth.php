<?php
// Test d’authentification (Connexion et gestion des sessions sécurisées) for all roles
session_start();
include __DIR__ . '/../Config.php';
include __DIR__ . '/../Database.php';

function test_auth($role, $email, $username, $password) {
    $db = new Database();
    $conn = $db->connect();
    if ($role === 'admin') {
        $stmt = $conn->prepare('SELECT * FROM admin WHERE email = :email OR username = :username');
    } elseif ($role === 'instructor') {
        $stmt = $conn->prepare('SELECT * FROM instructor WHERE email = :email OR username = :username');
    } elseif ($role === 'student') {
        $stmt = $conn->prepare('SELECT * FROM student WHERE email = :email OR username = :username');
    } else {
        echo "Unknown role: $role\n";
        return;
    }
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user[$role . '_id'] ?? $user['id'] ?? null;
        echo ucfirst($role) . " authentication test: SUCCESS\n";
    } else {
        echo ucfirst($role) . " authentication test: FAIL\n";
    }
}

// Admin test (from DB dump)
test_auth('admin', 'admin@e-safra.com', 'admin', 'admin123'); // Change password if needed
// Instructor test (example, update with real data)
test_auth('instructor', 'instructor@example.com', 'instructor', 'instructor123');
// Student test (example, update with real data)
test_auth('student', 'student@example.com', 'student', 'student');