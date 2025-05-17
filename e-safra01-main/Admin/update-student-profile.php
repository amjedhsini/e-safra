<?php
session_start();
include "../Utils/Util.php";
include "../Database.php";

if (isset($_SESSION['username']) && isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];

    $db = new Database();
    $conn = $db->connect();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect student profile data
        $student_id = $_POST['student_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['date_of_birth'];
        $username = $_POST['username'];  // New username field
        $new_password = $_POST['new_password'] ?? null; // Optional new password

        // Sanitize the inputs
        $first_name = htmlspecialchars($first_name);
        $last_name = htmlspecialchars($last_name);
        $email = htmlspecialchars($email);
        $date_of_birth = htmlspecialchars($date_of_birth);
        $username = htmlspecialchars($username);

        // If a new password is provided, hash it
        if ($new_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            // SQL query to update student details including username and password
            $query = "UPDATE student SET first_name = ?, last_name = ?, email = ?, date_of_birth = ?, username = ?, password = ? WHERE student_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$first_name, $last_name, $email, $date_of_birth, $username, $hashed_password, $student_id]);
        } else {
            // SQL query to update student details without changing the password
            $query = "UPDATE student SET first_name = ?, last_name = ?, email = ?, date_of_birth = ?, username = ? WHERE student_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$first_name, $last_name, $email, $date_of_birth, $username, $student_id]);
        }

        Util::redirect("dashboard.php", "success", "Student profile updated successfully!");
    }

    if (isset($_GET['student_id'])) {
        $student_id = $_GET['student_id'];
        $stmt = $conn->prepare("SELECT * FROM student WHERE student_id = ?");
        $stmt->execute([$student_id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            Util::redirect("dashboard.php", "error", "Student not found.");
        }
    }
    $title = "E-Safra - Update Student Profile";
    include "inc/Header.php";
?>

<div class="container">
    <h2>Update Student Profile</h2>
    <form method="POST" action="update-student-profile.php">
        <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>">

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" value="<?= $student['first_name'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="<?= $student['last_name'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $student['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" class="form-control" name="date_of_birth" value="<?= $student['date_of_birth'] ?>" required>
        </div>

        <!-- New Username Field -->
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?= $student['username'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password (Leave empty if no change)</label>
            <input type="password" class="form-control" name="new_password">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php
    include "inc/Footer.php";
} else {
    Util::redirect("../login.php", "error", "Please login as admin.");
}
?>
