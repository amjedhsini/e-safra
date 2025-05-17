<?php
session_start();
include "../../Utils/Util.php";  // Utility class for redirection

// Check if the admin is logged in
if (isset($_SESSION['username']) && isset($_SESSION['admin_id'])) {

    if (isset($_POST['student_id'])) {
        $student_id = intval($_POST['student_id']);  // Sanitize to integer

        // Validate student_id
        if ($student_id <= 0) {
            echo "error: Invalid student ID";
            exit;
        }

        // Database connection
        include "../../Database.php";
        $db = new Database();
        $db_conn = $db->connect();

        // Start transaction
        $db_conn->beginTransaction();

        try {

            // Delete the student record
            $delStudent = "DELETE FROM student WHERE student_id = :student_id";
            $stmt2 = $db_conn->prepare($delStudent);
            $stmt2->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $stmt2->execute();

            // Commit if successful
            $db_conn->commit();
            echo "success";

        } catch (Exception $e) {
            // Rollback on error
            $db_conn->rollBack();
            echo "error: Unable to delete the student. " . $e->getMessage();
        }
    } else {
        echo "error: No student ID provided.";
    }
} else {
    echo "error: Admin not logged in.";
}
?>
