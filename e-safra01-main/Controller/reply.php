<?php
session_start();
include "../Utils/Util.php";
$pdo = new PDO("mysql:host=localhost;dbname=e-safra", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get the posted data from the form
$sender   = $_POST['sender'];
$receiver = $_POST['receiver'];
$subject  = $_POST['subject'];
$message  = $_POST['message'];

// Ensure the required fields are provided
if (empty($sender) || empty($receiver) || empty($subject) || empty($message)) {
    Util::redirect("../Instructor/instructor_messages.php", "error", "All fields are required");
} else {
    // Insert the reply message into the database
    $stmt = $pdo->prepare("
        INSERT INTO messages (sender, receiver, subject, message, created_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->execute([$sender, $receiver, $subject, $message]);

    // Redirect to the instructor messages page
    header("Location: ../Instructor/instructor_messages.php");
    exit();
}
?>
