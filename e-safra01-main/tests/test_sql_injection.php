<?php
// Test SQL Injection protection on login for all roles
include __DIR__ . '/../Config.php';
include __DIR__ . '/../Database.php';

function test_sql_injection($role, $payload) {
    $db = new Database();
    $conn = $db->connect();
    if ($role === 'admin') {
        $stmt = $conn->prepare('SELECT * FROM admin WHERE email = :payload OR username = :payload');
    } elseif ($role === 'instructor') {
        $stmt = $conn->prepare('SELECT * FROM instructor WHERE email = :payload OR username = :payload');
    } elseif ($role === 'student') {
        $stmt = $conn->prepare('SELECT * FROM student WHERE email = :payload OR username = :payload');
    } else {
        echo "Unknown role: $role\n";
        return;
    }
    $stmt->bindParam(':payload', $payload);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result && count($result) > 0) {
        echo ucfirst($role) . " SQL Injection test: FAIL (Injection succeeded)\n";
    } else {
        echo ucfirst($role) . " SQL Injection test: SUCCESS (Injection blocked)\n";
    }
}

$payload = "' OR '1'='1";
test_sql_injection('admin', $payload);
test_sql_injection('instructor', $payload);
test_sql_injection('student', $payload);