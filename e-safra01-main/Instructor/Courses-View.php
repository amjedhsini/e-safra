<?php 
session_start();
include "../Utils/Util.php";
include "../Controller/Instructor/Course.php"; 

// Check if the instructor is logged in
if (isset($_SESSION['username']) && isset($_SESSION['instructor_id'])) {
    $instructor_id = $_SESSION['instructor_id'];

    // Ensure that course_id, chapter, and topic are set in the URL
    if (isset($_GET['course_id'], $_GET['chapter'], $_GET['topic'])) {
        $course_id = $_GET['course_id']; 
        $chapter_id = $_GET['chapter']; 
        $topic_id = $_GET['topic']; 
    } else {
        die("Missing required parameters.");
    }

    // Database connection
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=e-safra", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    // Fetch course, chapter, and topic information from the content table
    $stmt = $pdo->prepare("SELECT c.title AS course_title, ch.title AS chapter_title, t.title AS topic_title, con.data AS content_data
                           FROM content con
                           JOIN course c ON c.course_id = con.course_id
                           JOIN chapter ch ON ch.chapter_id = con.chapter_id
                            JOIN topic t ON t.topic_id = con.topic_id
                            WHERE c.course_id = ? AND ch.chapter_id = ? AND t.topic_id = ?");
                    
    $stmt->execute([$course_id, $chapter_id, $topic_id]);
    $content_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$content_data) {
        die("Content not found.");
    }

    // Set title dynamically based on the course and topic
    $title = $content_data['course_title'] . " - " . $content_data['chapter_title'] . " - " . $content_data['topic_title'];
    include "inc/Header.php";
?>
<style>
    :root {
        --primary: #000000;
        --secondary: #836f0a;
        --accent: #5c5951;
        --light: #fffcf2;
        --dark: #2a2a2a;
        --text: #333333;
        --border-light: #e0e0e0;
    }

    /* Reset & box-sizing */
    *, *::before, *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: var(--light);
        color: var(--text);
        font-family: 'Nunito', sans-serif;
        overflow-x: hidden;
    }

    /* Full-width wrapper */
    .container {
        max-width: 2000px;
        width: 100%;
        margin: auto;
        padding: 0px;
    }

    /* Side-by-side layout */
    .side-by-side {
        display: flex;
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .side-by-side { flex-direction: column; }
    }

    /* Left sidebar */
    .l-side {
        flex: 0 0 280px;
        background: var(--light);
        border: 1px solid var(--border-light);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        height: fit-content;
    }
    .l-side .list-group {
        list-style: none;
        padding-left: 0;
    }
    .l-side .list-group-item {
        border: none;
        background: transparent;
        padding: 0.5rem 0;
    }
    .l-side .list-group-item > a.btn.badge-primary {
        display: inline-block;
        background: var(--secondary);
        color: var(--light) !important;
        padding: 0.4rem 0.8rem;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        transition: background 0.3s;
    }
    .l-side .list-group-item > a.btn.badge-primary:hover {
        background: var(--dark);
    }

    /* Right content area */
    .r-side {
        flex: 1;
        background: var(--light);
        border: 1px solid var(--border-light);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }
    .r-side .btn-primary {
        background: var(--primary);
        border: 2px solid var(--primary);
        color: var(--light) !important;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        transition: background 0.3s, transform 0.3s;
    }
    .r-side .btn-primary:hover {
        background: var(--secondary);
        border-color: var(--secondary);
        transform: translateY(-2px);
    }

    .r-side h4 {
        margin: 1rem 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
    }
    .r-side h5 {
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        color: var(--secondary);
    }

    /* Prev/Next controls */
    .r-side .btn-secondary,
    .r-side .btn-success {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 600;
        transition: background 0.3s, transform 0.3s;
    }
    .r-side .btn-secondary {
        background: var(--dark);
        border: none;
        color: var(--light) !important;
        margin-right: 0.5rem;
    }
    .r-side .btn-secondary:hover {
        background: var(--text);
        transform: translateY(-1px);
    }
    .r-side .btn-success {
        background: var(--secondary);
        border: none;
        color: var(--light) !important;
    }
    .r-side .btn-success:hover {
        background: var(--accent);
        transform: translateY(-1px);
    }

    /* “Update Course” link spacing */
    .r-side > .btn-primary {
        margin-bottom: 2rem;
    }
</style>

<div class="container">
    <!-- NavBar & Profile-->
    <?php include "inc/NavBar.php"; ?>
    <div class="side-by-side mt-5">
        <div class="l-side shadow p-3">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="Courses-content-update.php?course_id=<?= $course_id ?>&chapter=1&topic=1" class="btn badge-primary">Chapter 1</a>
                    <ul>
                        <li>
                            <a href="Courses-content-update.php?course_id=<?= $course_id ?>&chapter=1&topic=1" class="btn badge-primary">Topic 1</a>
                        </li>
                        <li>
                            <a href="Courses-content-update.php?course_id=<?= $course_id ?>&chapter=1&topic=2" class="btn badge-primary">Topic 2</a>
                        </li>
                        <li>
                            <a href="Courses-content-update.php?course_id=<?= $course_id ?>&chapter=1&topic=3" class="btn badge-primary">Topic 3</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="r-side p-5 shadow">
            <a href="Course-edit.php?course_id=<?= $course_id ?>" class="btn btn-primary">Update Course</a><br><br>
            <h4>Course: <?= $content_data['course_title'] ?></h4>
            <h5>Chapter: <?= $content_data['chapter_title'] ?></h5>
            <h5>Topic: <?= $content_data['topic_title'] ?></h5>
            <div>
                <p><?= nl2br($content_data['content_data']) ?></p>
                <div class="d-flex  justify-content-between mt-5">
                    <a href="Courses-content-update.php?course_id=<?= $course_id ?>&chapter=1&topic=<?= $topic_id - 1 ?>" class="btn btn-secondary">Previous</a>
                    <a href="Courses-content-update.php?course_id=<?= $course_id ?>&chapter=1&topic=<?= $topic_id + 1 ?>" class="btn btn-success">Next</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>
<?php
} else {
    // Redirect if the instructor is not logged in
    $em = "First login";
    Util::redirect("../login.php", "error", $em);
}
?>
