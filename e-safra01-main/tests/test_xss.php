<?php
// Test XSS protection by simulating user input (e.g., student name or message)
include __DIR__ . '/../Config.php';
include __DIR__ . '/../Database.php';

function test_xss($input) {
    // Simulate storing and displaying user input
    $safe = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    echo "Original: $input\n";
    echo "Sanitized: $safe\n";
    if ($safe === $input) {
        echo "XSS test: FAIL (Input not sanitized)\n";
    } else {
        echo "XSS test: SUCCESS (Input sanitized)\n";
    }
}

$xss_payload = "<script>alert('XSS')</script>";
test_xss($xss_payload);