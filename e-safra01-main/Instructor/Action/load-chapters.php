<?php
session_start();
include "../../Utils/Util.php";
include "../../Database.php";
include "../../Models/Course.php";

if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Create database connection
    $db = new Database();
    $conn = $db->connect();
    $course = new Course($conn);

    // Fetch chapters based on course_id
    $chapters = $course->getChapters($course_id);

    // Check if chapters are found
    if ($chapters) {
        foreach ($chapters as $chapter) {
            echo '<option value="' . $chapter['chapter_id'] . '">' . $chapter['title'] . '</option>';
        }
    } else {
        echo 0;  // No chapters available
    }

    $conn = null; // Close connection
} else {
    echo 0; // Invalid request
}
?>
