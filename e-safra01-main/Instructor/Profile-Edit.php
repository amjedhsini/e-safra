<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['instructor_id'])) {
    include "../Controller/Instructor/Instructor.php";

    $_id =  $_SESSION['instructor_id'];
    $instructor = getById($_id);

   if (empty($instructor['instructor_id'])) {
     $em = "Invalid Student id";
     Util::redirect("../logout.php", "error", $em);
   }
    # Header
    $title = "E-Safra - Instructor ";
    include "inc/Header.php";

?>
<style>
  
  :root {
    --primary: #e3b500;
    --primary-hover: #c79d00;
    --accent: #000000;
    --background: #ffffff;
    --surface: #f8f8f8;
    --text-primary: #000000;
    --text-secondary: #444444;
    --border: #000000;
    --gradient: linear-gradient(135deg, var(--primary) 0%, #f8d347 100%);
}

body {
    background: #f9f9f9;
    font-family: Arial, sans-serif;
}

.container {
    max-width: 1200px; /* Reduced width for better layout */
    margin: auto;
    padding: 1rem;
}

.r-side {
    background-color: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h4 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--accent);
    margin-bottom: 1.5rem;
    position: relative;
    padding-left: 1rem;
}

h4::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 70%;
    background: var(--primary);
}

.form-label {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.form-control {
    border-radius: 8px;
    padding: 1rem;
    font-size: 1rem;
    border: 1px solid var(--border);
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 5px var(--primary);
}

textarea.form-control {
    resize: none;
}

.mb-3 {
    margin-bottom: 1.5rem;
}

.btn {
    background-color: var(--primary);
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
}

.input-group {
    display: flex;
    align-items: center;
}

.input-group .form-control {
    flex: 1;
}

.input-group button {
    border-radius: 8px;
}

input[type="password"] {
    padding: 1rem;
}

input[type="submit"] {
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 1rem;
    background-color: var(--primary);
    border: none;
    color: white;
}

input[type="submit"]:hover {
    background-color: var(--primary-hover);
}

.alert {
    margin-top: 1rem;
    font-size: 1rem;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .r-side {
        padding: 1.5rem;
    }

    h4 {
        font-size: 1.25rem;
    }

    .form-control {
        font-size: 0.875rem;
    }

    .btn {
        padding: 0.5rem 1rem;
    }
}

</style>
<script>
    function generatePassword() {
        const randomString = Math.random().toString(36).slice(-6);
        document.getElementById('instructorPassword').value = randomString;
        document.getElementById('confirmPassword').value = randomString;
        document.getElementById('instructorPassword').type = "text";
        document.getElementById('confirmPassword').type = "text";
    }
</script>
<?php include "inc/NavBar.php"; ?>
<div class="container">
  <!-- NavBar & Profile-->
 
        <?php include "inc/Profile.php"; ?>


    <div class="r-side p-5  mx-2 shadow">
    <?php 
      if (isset($_GET['error'])) { ?>
        <p class="alert alert-danger"><?=Validation::clean($_GET['error'])?></p>
    <?php } ?>
    <?php 
      if (isset($_GET['success'])) { ?>
        <p class="alert alert-success"><?=Validation::clean($_GET['success'])?></p>
    <?php } ?>
      <h4>Edit Account Information</h4>
        <form style="max-width: 600px;"
              action="Action/upload-profile-details.php"
              method="POST">
          <div class="mb-3">
            <label class="form-label">First name</label>
            <input type="text" 
                   class="form-control"
                   name="first_name"
                   value="<?=$instructor['first_name']?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Last name</label>
            <input type="text" 
                   class="form-control"
                   value="<?=$instructor['last_name']?>"
                   name="last_name">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" 
                   class="form-control"
                   value="<?=$instructor['email']?>"
                   name="email">
          </div>
          <div class="mb-3">
            <label class="form-label">Date of birth</label>
            <input type="date" 
                   class="form-control"
                   value="<?=$instructor['date_of_birth']?>"
                   name="date_of_birth">
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
        
        <h4 class="mt-5">Change Password</h4>
        <form id="ChangePassword"
              method="post"
              action="Action/change-password.php"
              style="max-width: 600px;">
          <div class="mb-3">
            <label class="form-label">Current password</label>
            <input type="password" 
                   placeholder="Current password" 
                   class="form-control"
                   name="password">
          </div>
          <div class="mb-3">
              <label for="instructorPassword" class="form-label">New Password</label>
              <div class="input-group">
                  <input type="password" class="form-control" id="instructorPassword" name="new_password" placeholder="Enter new password" aria-describedby="generatePasswordButton" >
                  <button class="btn btn-outline-secondary" type="button" id="generatePasswordButton" onclick="generatePassword()">Auto Generate</button>
              </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm password</label>
            <input type="password" 
                   placeholder="Current password" 
                   class="form-control"
                   id="confirmPassword"
                   name="confirm_password">
          </div>

          
          <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
  </div>
</div>

 <!-- Footer -->
<?php include "inc/Footer.php"; ?>

<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>
