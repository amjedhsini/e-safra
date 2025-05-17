<?php 
session_start();
include "../../Utils/Util.php";
if (isset($_SESSION['username']) && isset($_SESSION['instructor_id'])) {
    include "../../Utils/Validation.php";
    include "../../Database.php";
    include "../../Models/Course.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $topic_title = Validation::clean($_POST["topic_title"]);
        $course_id = Validation::clean($_POST["course_id"]);
        $chapter_id = Validation::clean($_POST["chapter_id"]);

        if (empty($topic_title) || empty($course_id) || empty($chapter_id)) {
            $em = "All fields are required.";
            Util::redirect("../Courses-add.php", "error", $em);
        } else {
            $db = new Database();
            $conn = $db->connect();
            $course = new Course($conn);

            $data = [$chapter_id, $course_id, $topic_title];
            $res = $course->insert_topic($data);
            
            if ($res) {
                $sm = "New Topic Successfully Created!";
                Util::redirect("../Courses-add.php", "success", $sm);
            } else {
                $em = "An error occurred while creating the topic.";
                Util::redirect("../Courses-add.php", "error", $em);
            }
            $conn = null;
        }
    } else {
        $em = "Invalid request method.";
        Util::redirect("../Courses-add.php", "error", $em);
    }
} else {
    $em = "Please log in first.";
    Util::redirect("../../login.php", "error", $em);
}
?>
