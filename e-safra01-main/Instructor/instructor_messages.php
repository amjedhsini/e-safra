<?php
session_start();
include "../Utils/Util.php";

// Check if the instructor is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['instructor_id'])) {
    Util::redirect("../login.php", "error", "Please login first");
}

include "../Controller/instructor/instructor.php";

// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=e-safra", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get the instructor's ID and username from the session
$instructor_id = $_SESSION['instructor_id'];
$instructor_username = $_SESSION['username'];

// Fetch the instructor's full name
$stmt = $pdo->prepare("SELECT first_name, last_name FROM instructor WHERE instructor_id = ?");
$stmt->execute([$instructor_id]);
$inst = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the instructor exists in the database
if (!$inst) {
    die("Instructor not found.");
}

// Build the full name
$instructor_fullname = $inst['first_name'] . ' ' . $inst['last_name'];

// Fetch messages where the receiver is the instructor
$stmt = $pdo->prepare("SELECT * FROM messages WHERE receiver = ? ORDER BY created_at DESC");
$stmt->execute([$instructor_fullname]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set the page title
$title = "E-safra - Instructor Messaging";

// Include the page header
include "inc/Header.php";
?>

<style>
    /* Global styles */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f9;
        color: #333;
        margin-top: 0;  /* Remove top margin */
        margin-bottom: 0;  /* Remove bottom margin */
        padding: 0;
    }

    h1 {
        text-align: center;
        color: #007BFF;
        margin-bottom: 20px;
        font-size: 2.5rem;
        font-weight: bold;
    }

    .container {
        width: 100%;
        margin: 0;  /* Ensure the container spans the full width */
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        min-height: 100vh;  /* Ensure the container takes full screen height */
    }

    .message-card {
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .message-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .message-card strong {
        color: #555;
        font-weight: bold;
    }

    .message-card p {
        margin-top: 10px;
        color: #555;
        white-space: pre-line;
        line-height: 1.6;
    }

    .reply-form {
        margin-top: 20px;
    }

    textarea {
        width: 100%;
        height: 120px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        resize: vertical;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    button {
        margin-top: 10px;
        background-color: #007BFF;
        color: white;
        padding: 10px 20px;
        font-size: 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    .no-messages {
        text-align: center;
        font-size: 1.2rem;
        color: #888;
        margin-top: 20px;
    }

    /* Ensure the footer is full-width and fixed at the bottom */
    footer {
        width: 100%;
        background-color: #333;
        color: white;
        text-align: center;
        padding: 15px;
        position: relative;
        bottom: 0;
    }
</style>
<?php include "inc/NavBar.php"; ?>
<div class="container">
    
    <h1>Instructor's Inbox</h1>

    <!-- Display message or no messages available -->
    <?php if (empty($messages)): ?>
        <p class="no-messages"><em>No messages yet. Check back later!</em></p>
    <?php else: ?>
        <!-- Loop through the messages and display them -->
        <?php foreach ($messages as $msg): ?>
            <div class="message-card">
                <strong>From:</strong> <?= htmlspecialchars($msg['sender']) ?><br>
                <strong>To:</strong> <?= htmlspecialchars($msg['receiver']) ?><br>
                <strong>Subject:</strong> <?= htmlspecialchars($msg['subject']) ?><br>
                <strong>At:</strong> <?= htmlspecialchars($msg['created_at']) ?><br>
                <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>

                <!-- Reply form -->
                <form action="../Controller/reply.php" method="post">
                    <input type="hidden" name="sender" value="<?= htmlspecialchars($instructor_username) ?>">
                    <input type="hidden" name="receiver" value="<?= htmlspecialchars($msg['sender']) ?>">
                    <input type="hidden" name="subject" value="<?= htmlspecialchars($msg['subject']) ?>">
                    <label for="message">Reply:</label><br>
                    <textarea name="message" placeholder="Your reply..." required></textarea><br>
                    <button type="submit">Reply</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script src="../assets/js/jquery-3.5.1.min.js"></script>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>
