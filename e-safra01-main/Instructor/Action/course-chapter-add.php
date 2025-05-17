<?php 
session_start();
include "../../Utils/Util.php";
if (isset($_SESSION['username']) && isset($_SESSION['instructor_id'])) {
    include "../../Utils/Validation.php";
    include "../../Database.php";
    include "../../Models/Course.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $chapter_title = Validation::clean($_POST["chapter_title"]);
        $course_id = Validation::clean($_POST["course_id"]);

        if (empty($chapter_title) || empty($course_id)) {
            $em = "Invalid chapter title or course.";
            Util::redirect("../Courses-add.php", "error", $em);
        } else {
            $db = new Database();
            $conn = $db->connect();
            $course = new Course($conn);

            $data = [$course_id, $chapter_title];
            $res = $course->insert_chapter($data);
            
            if ($res) {
                $sm = "New Chapter Successfully Created!";
                Util::redirect("../Courses-add.php", "success", $sm);
            } else {
                $em = "An error occurred while creating the chapter.";
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
