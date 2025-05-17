<?php
session_start();
include "../Utils/Util.php";
include "../Database.php";

if (isset($_SESSION['username']) && isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];

    $db = new Database();
    $conn = $db->connect();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect instructor profile data
        $instructor_id = $_POST['instructor_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username']; // New username field
        $email = $_POST['email'];
        $status = $_POST['status'];
        $new_password = $_POST['new_password'] ?? null; // Optional new password

        // Sanitize inputs
        $first_name = htmlspecialchars($first_name);
        $last_name = htmlspecialchars($last_name);
        $username = htmlspecialchars($username);
        $email = htmlspecialchars($email);
        $status = htmlspecialchars($status);

        if ($new_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            // Update instructor details with new password
            $query = "UPDATE instructor SET first_name = ?, last_name = ?, username = ?, email = ?, status = ?, password = ? WHERE instructor_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$first_name, $last_name, $username, $email, $status, $hashed_password, $instructor_id]);
        } else {
            // Update instructor details without changing the password
            $query = "UPDATE instructor SET first_name = ?, last_name = ?, username = ?, email = ?, status = ? WHERE instructor_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$first_name, $last_name, $username, $email, $status, $instructor_id]);
        }

        Util::redirect("instructors.php", "success", "Instructor profile updated successfully!");
    }

    if (isset($_GET['instructor_id'])) {
        $instructor_id = $_GET['instructor_id'];
        $stmt = $conn->prepare("SELECT * FROM instructor WHERE instructor_id = ?");
        $stmt->execute([$instructor_id]);
        $instructor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$instructor) {
            Util::redirect("instructors.php", "error", "Instructor not found.");
        }
    }
    $title = "E-Safra - Update Instructor Profile";
    include "inc/Header.php";
?>

<div class="container">
    <h2>Update Instructor Profile</h2>
    <form method="POST" action="update-instructor-profile.php">
        <input type="hidden" name="instructor_id" value="<?= $instructor['instructor_id'] ?>">

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" value="<?= $instructor['first_name'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="<?= $instructor['last_name'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?= $instructor['username'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $instructor['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-control" name="status">
                <option value="active" <?= ($instructor['status'] == 'active') ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($instructor['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
            </select>
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
