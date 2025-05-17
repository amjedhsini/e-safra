<?php
session_start();
include "../Utils/Util.php";
include "../Database.php";

if (isset($_SESSION['username']) && isset($_SESSION['instructor_id'])) {
    $instructor_id = $_SESSION['instructor_id'];
    $db = new Database();
    $conn = $db->connect();

    // Fetch instructor details
    $stmt = $conn->prepare("SELECT first_name FROM instructor WHERE instructor_id = ?");
    $stmt->execute([$instructor_id]);
    $instructor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$instructor) {
        Util::redirect("../logout.php", "error", "Invalid instructor ID");
    }

    // Fetch dashboard statistics
    $stmt = $conn->prepare("SELECT COUNT(*) as total_courses FROM course WHERE instructor_id = ?");
    $stmt->execute([$instructor_id]);
    $totalCourses = $stmt->fetch(PDO::FETCH_ASSOC)['total_courses'];

    $stmt = $conn->prepare("SELECT COUNT(DISTINCT student_id) as total_students FROM enrolled_student WHERE course_id IN (SELECT course_id FROM course WHERE instructor_id = ?)");
    $stmt->execute([$instructor_id]);
    $totalStudents = $stmt->fetch(PDO::FETCH_ASSOC)['total_students'];

    // Fetch recent messages
    $stmt = $conn->prepare("SELECT sender, message, created_at FROM messages WHERE receiver = ? ORDER BY created_at DESC LIMIT 5");
    $stmt->execute([$instructor['first_name']]);
    if ($stmt->rowCount() == 0) {
        $recentMessages = [];
    } else {
        $recentMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $recentMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $title = "E-Sfara-Instructor Dashboard";
    include "inc/Header.php";
?>



    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
    
            max-width: 2000px;
            width: 100%;
            margin: auto;
            padding: 0px;
        }
        .dashboard-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            padding: 30px;
            color: #333;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            margin-top: 20px;
        }
        .dashboard-header {
            text-align: center;
            color: #e3b500;
            margin-bottom: 30px;
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .dashboard-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .stat-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            text-align: center;
            width: 30%;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .stat-card h3 {
            color: #444;
            font-size: 1.8rem;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }
        .stat-card p {
            color: #555;
            font-size: 1.3rem;
        }
        .stat-card .stat-value {
            color: #e3b500;
            font-size: 2.5rem;
            font-weight: bold;
        }
        .list-group {
            margin-top: 25px;
            padding: 0;
            list-style: none;
        }
        .list-group-item {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .list-group-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .list-group-item strong {
            color: #333;
            font-weight: bold;
        }
        .list-group-item .text-muted {
            font-size: 0.9rem;
            color: #777;
        }
        .recent-activity {
            margin-top: 40px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .recent-activity h4 {
            font-size: 1.8rem;
            color: #444;
            margin-bottom: 20px;
        }
        .recent-activity ul {
            list-style: none;
            padding: 0;
        }
        .recent-activity li {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .recent-activity li:last-child {
            border-bottom: none;
        }
        .recent-activity li span {
            font-size: 1rem;
            color: #555;
        }
        .recent-activity li .activity-time {
            font-size: 0.85rem;
            color: #999;
        }
    </style>
<div class="container">
<?php include "inc/NavBar.php"; ?>
<div class="dashboard-container">
    <h1 class="dashboard-header">Instructor Dashboard</h1>
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Total Courses</h3>
            <p class="stat-value"><?php echo $totalCourses; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Students</h3>
            <p class="stat-value"><?php echo $totalStudents; ?></p>
        </div>
        <div class="stat-card">
            <h3>Messages</h3>
            <p class="stat-value">5</p>
        </div>
    </div>
    <h4>Recent Messages</h4>
    <ul class="list-group">
        <?php foreach ($recentMessages as $message): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($message['sender']) ?>:</strong> <?= htmlspecialchars($message['message']) ?>
                <br><small class="text-muted">Sent on <?= $message['created_at'] ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</div>

 <!-- Footer -->
 <?php include "inc/Footer.php"; ?>
<script src="../assets/js/jquery-3.5.1.min.js"></script>
<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>