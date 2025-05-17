<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['instructor_id'])) {
    include "../Controller/Instructor/Course.php";
    $instructor_id = $_SESSION['instructor_id'];
    $courses = getCoursesByInstructorId($instructor_id);

    # Header
    $title = "E-Safra - Create Course ";
    include "inc/Header.php";
    
    $title = $description  ="";
    if (isset($_GET["title"])) {
        $title = Validation::clean($_GET["title"]);
    }
    if (isset($_GET["description"])) {
        $description = Validation::clean($_GET["description"]);
    }
?>

<style>
:root {
    --primary-color: #333333;
    --secondary-color: #f8f9fa;
    --accent-color: #ffc107;
    --text-color: #333333;
    --light-gray: #6c757d;
    --white: #ffffff;
}

body {
    background-color: #f5f5f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--text-color);
}

.container {
    
    max-width: 2000px;
    width: 100%;
    margin: auto;
    padding: 0px;
}

h2, h4 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

form {
    background-color: var(--white);
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-label {
    font-weight: 600;
}

.form-control {
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.form-control:focus {
    border-color: var(--primary-color);
}

textarea.form-control {
    height: auto;
}

.mb-3 {
    margin-bottom: 1.5rem;
}

button[type="submit"] {
    background-color: var(--primary-color);
    color: var(--white);
    border-radius: 5px;
    border: none;
    padding: 0.75rem 1.5rem;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #000000;
    transform: translateY(-3px);
}

.table-bordered {
    width: 100%;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    margin-bottom: 1.5rem;
}

.table-bordered th, .table-bordered td {
    padding: 0.75rem;
    text-align: left;
    vertical-align: middle;
}

.table-bordered th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.table-bordered tr:hover {
    background-color: #f1f1f1;
}

.table-bordered td a {
    color: #007bff;
    text-decoration: none;
}

.table-bordered td a:hover {
    text-decoration: underline;
}

.d-flex {
    display: flex;
}

.justify-content-center {
    justify-content: center;
}

.mt-5 {
    margin-top: 3rem;
}

.m-2 {
    margin: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    cursor: pointer;
}

.btn-danger {
    background-color: #dc3545;
    color: var(--white);
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn-danger:hover {
    background-color: #c82333;
}

.alert {
    padding: 0.75rem 1.25rem;
    font-size: 1rem;
    border-radius: 5px;
}

.alert-warning {
    background-color: #ffeeba;
    color: #856404;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.bg-custom-accent {
    background-color: var(--accent-color) !important;
    color: var(--text-color) !important;
}

.bg-custom-dark {
    background-color: var(--primary-color) !important;
    color: var(--white) !important;
}

.bg-custom-gray {
    background-color: var(--light-gray) !important;
    color: var(--white) !important;
}

.card {
    background-color: var(--white);
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.card-header {
    background-color: var(--primary-color);
    color: var(--white);
    border-radius: 10px;
    padding: 1rem;
    font-weight: 600;
}

.stat-card {
    text-align: center;
    padding: 1.5rem;
}

.stat-icon {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    color: var(--accent-color);
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.25rem;
}

.stat-label {
    color: var(--light-gray);
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
}

.welcome-section {
    background: linear-gradient(135deg, var(--primary-color), #000000);
    color: var(--white);
    border-radius: 10px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem;
    border-radius: 10px;
    background-color: var(--white);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    color: var(--primary-color);
    text-decoration: none;
    height: 100%;
}

.action-btn:hover {
    background-color: var(--primary-color);
    color: var(--white);
    transform: translateY(-3px);
}

.action-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: var(--accent-color);
}

.action-btn:hover .action-icon {
    color: var(--accent-color);
}

.action-label {
    text-align: center;
    font-size: 0.9rem;
    font-weight: 500;
}

.todo-list {
    list-style-type: none;
    padding: 0;
}

.todo-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #eee;
}

.todo-item:last-child {
    border-bottom: none;
}

.todo-check {
    margin-right: 1rem;
}

.todo-text {
    flex: 1;
}

.checked {
    text-decoration: line-through;
    color: var(--light-gray);
}

.btn-custom-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: var(--white);
}

.btn-custom-primary:hover {
    background-color: #000000;
    border-color: #000000;
    color: var(--white);
}

.btn-custom-secondary {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    color: var(--text-color);
}

.btn-custom-secondary:hover {
    background-color: #e0a800;
    border-color: #e0a800;
    color: var(--text-color);
}

.btn-custom-outline {
    background-color: transparent;
    border-color: var(--accent-color);
    color: var(--text-color);
}

.btn-custom-outline:hover {
    background-color: var(--accent-color);
    color: var(--text-color);
}


</style>

<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>
    <!-- Form for creating a course -->
    <div class="mt-5" style="max-width: 800px;">
    <form id="courseForm" 
          class="mt-5"
          action="Action/course-add.php"
          method="POST"
          enctype="multipart/form-data">
         <?php if (isset($_GET['error'])) { ?>
        <p class="alert alert-warning"><?=Validation::clean($_GET['error'])?></p>
        <?php } ?>
        <?php 
        if (isset($_GET['success'])) { ?>
        <p class="alert alert-success"><?=Validation::clean($_GET['success'])?></p>
        <?php } ?>
        <h2>Create a New Course</h2>
        <div class="mb-3" >
            <label for="courseTitle" class="form-label">Course Title</label>
            <input type="text" 
                   class="form-control" 
                   id="courseTitle" 
                   name="title"
                   placeholder="Enter course title" 
                   value="<?=$title?>"
                   required />
        </div>
        <div class="mb-3">
            <label for="courseDescription" class="form-label">Course Description</label>
            <textarea class="form-control" 
                      id="courseDescription" 
                      rows="4" 
                      name="description" 
                      placeholder="Enter course description" 
                      required ><?=$description?></textarea>
        </div>
        <div class="mb-3">
            <label for="Cover" class="form-label">Cover Image</label>
            <input type="file" class="form-control" 
                   id="Cover" placeholder="Enter course title" 
                   name="cover" />
        </div>

        <button type="submit" class="btn btn-primary">Create Course</button>
    </form>

    <hr>

    <!-- Form for creating chapters linked to a specific course -->
    <form id="Chapter" 
          class="mt-5"
          action="Action/course-chapter-add.php"
          method="POST">
        <h2>Create a New Chapter</h2>
        <div class="mb-3">
            <label for="courseSelect" class="form-label">Select Course</label>
            <select class="form-select" id="courseSelect" name="course_id" required>
                <?php if ($courses) { ?>
                    <?php foreach ($courses as $course) { ?>
                        <option value="<?=$course['course_id']?>"><?=$course['title']?></option>
                    <?php }?>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="chapterTitle" class="form-label">Chapter Title</label>
            <input type="text" 
                   class="form-control" 
                   id="chapterTitle" 
                   placeholder="Enter chapter title" 
                   name="chapter_title" 
                   required>
        </div>
        <button type="submit" class="btn btn-primary">Create Chapter</button>
    </form>

    <hr>


    <form id="Topic" 
          class="mt-5"
          action="Action/course-topic-add.php"
          method="POST">
        <h2>Create a New Topic</h2>
        <div class="mb-3">
            <label for="courseSelectTopic" class="form-label">Select Course</label>
            <select class="form-select" id="courseSelectTopic" name="course_id" required>
               <?php if ($courses) { ?>
                    <?php foreach ($courses as $course) { ?>
                        <option value="<?=$course['course_id']?>"><?=$course['title']?></option>
                    <?php }?>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="chapterSelect" class="form-label">Select Chapter</label>
            <select class="form-select" 
                    id="chapterSelect" 
                    name="chapter_id" 
                    required>
            </select>
        </div>
        <div class="mb-3">
            <label for="topicTitle" class="form-label">Topic Title</label>
            <input type="text" 
                   class="form-control" 
                   id="topicTitle" 
                   placeholder="Enter topic title" 
                   name="topic_title" 
                   required>
        </div>
        <button type="submit" class="btn btn-primary">Create Topic</button>
    </form>
   </div>
</div>


</div>
<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Trigger AJAX when a course is selected
        $("#courseSelectTopic").on("change", function() {
            var course_id = $(this).val();  // Get the selected course ID

            // Make the AJAX call to fetch chapters based on the selected course
            $.ajax({
                url: "Action/load-chapters.php",
                method: "POST",
                data: { 'course_id': course_id },
                success: function(data) {
                    // Check if chapters exist
                    if (data != 0) {
                        $("#chapterSelect").html(data);  // Populate the chapter dropdown
                    } else {
                        alert("No chapters available for this course. Please create chapters first.");
                        $("#chapterSelect").html('<option value="">No chapters available</option>'); // Show message when no chapters exist
                    }
                },
                error: function() {
                    alert("Error loading chapters. Please try again.");
                }
            });
        });

        // Trigger the change event on page load in case a course is pre-selected
        if ($("#courseSelectTopic").val()) {
            $("#courseSelectTopic").trigger("change");
        }
    });
</script>


 <!-- Footer -->
<?php include "inc/Footer.php"; ?>

 

<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>
