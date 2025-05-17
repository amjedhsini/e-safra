<?php
session_start();
include "../../Utils/Util.php";  // Utility class for redirection

// Check if the admin is logged in
if (isset($_SESSION['username']) && isset($_SESSION['admin_id'])) {

    if (isset($_POST['instructor_id'])) {
        $instructor_id = $_POST['instructor_id'];  // Get instructor_id from POST

        // Sanitize the instructor ID to avoid SQL injection
        $instructor_id = intval($instructor_id);  // Ensure it's an integer

        // Check if instructor_id is valid
        if ($instructor_id <= 0) {
            echo "error: Invalid instructor ID";
            exit;
        }

        // Database connection
        include "../../Database.php";
        $db = new Database();
        $db_conn = $db->connect();

        // Start a transaction to ensure that all delete actions happen together
        $db_conn->beginTransaction();

        try {
            //  Delete related records from the 'instructor' table
            $delete_instructor_query = "DELETE FROM instructor WHERE instructor_id = :instructor_id";
            $delete_instructor_stmt = $db_conn->prepare($delete_instructor_query);
            $delete_instructor_stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
            $delete_instructor_stmt->execute();

            // Commit the transaction if everything went well
            $db_conn->commit();
            echo "success";  // Success message if the instructor is deleted

        } catch (Exception $e) {
            // Rollback the transaction in case of any error
            $db_conn->rollBack();
            echo "error: Unable to delete the instructor. " . $e->getMessage();  // Output error message for debugging
        }
    } else {
        echo "error: No instructor ID provided.";
    }
} else {
    echo "error: Admin not logged in.";
}
?>
