<?php 
session_start();
include "../../Utils/Util.php";
include "../../Database.php";
include "../../Models/Course.php";

if (isset($_POST['chapter_id'])) {
    $chapter_id = $_POST['chapter_id'];

    $db = new Database();
    $conn = $db->connect();
    $course = new Course($conn);

    $topics = $course->getTopicsByChapterId($chapter_id);

    if ($topics) {
        foreach ($topics as $topic) {
            echo '<option value="' . $topic['topic_id'] . '">' . $topic['title'] . '</option>';
        }
    } else {
        echo 0; // No topics found
    }

    $conn = null;
} else {
    echo 0; // Invalid request
}
?>


