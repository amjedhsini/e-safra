<?php
session_start();
include "../../Utils/Util.php";  // Utility class for redirection
include "../../Utils/Validation.php";  // Utility class for validation
include "../../Database.php";  // Include database connection

// Check admin session
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    $em = "Please login first.";
    Util::redirect("../login.php", "error", $em);
}

// Ensure the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $em = "All fields are required.";
        Util::redirect("change-admin-password.php", "error", $em);
    }

    if ($new_password !== $confirm_password) {
        $em = "New passwords do not match.";
        Util::redirect("change-admin-password.php", "error", $em);
    }

    if (strlen($new_password) < 8) {
        $em = "Password must be at least 8 characters long.";
        Util::redirect("change-admin-password.php", "error", $em);
    }

    // Database connection
    $db = new Database();
    $db_conn = $db->connect();

    // Check if the old password is correct
    $stmt = $db_conn->prepare("SELECT password FROM admin WHERE admin_id = :admin_id");
    $stmt->bindParam(':admin_id', $_SESSION['admin_id'], PDO::PARAM_INT);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin || !password_verify($old_password, $admin['password'])) {
        $em = "Incorrect old password.";
        Util::redirect("change-admin-password.php", "error", $em);
    }

    // Hash the new password
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    try {
        $update_stmt = $db_conn->prepare("UPDATE admin SET password = :password WHERE admin_id = :admin_id");
        $update_stmt->bindParam(':password', $hashed_new_password);
        $update_stmt->bindParam(':admin_id', $_SESSION['admin_id']);
        $update_stmt->execute();

        $success_msg = "Password updated successfully.";
        Util::redirect("change-admin-password.php", "success", $success_msg);
    } catch (Exception $e) {
        $em = "An error occurred. Please try again later.";
        Util::redirect("change-admin-password.php", "error", $em);
    }
}
?>
