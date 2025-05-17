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
     $em = "Invalid instructor id";
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
    background: var(--background);
    font-family: 'Roboto', Arial, sans-serif;
    color: var(--text-primary);
    margin: 0;
    padding: 0;
}
input[type="submit"] {
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 1rem;
    background-color: var(--primary);
    border: none;
    color: white;
}
.container {
    width: 100%;
    max-width: 1200px;
    margin: 2rem auto;
    padding: 1rem;
    background: var(--surface);
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.r-side {
    background-color: var(--background);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h4 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary);
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
    width: 6px;
    height: 70%;
    background: var(--primary);
    border-radius: 3px;
}

.list-group {
    padding: 0;
    list-style-type: none;
}

.list-group-item {
    border: 1px solid var(--border);
    margin-bottom: 0.5rem;
    padding: 1rem;
    background-color: var(--surface);
    font-size: 1rem;
    color: var(--text-primary);
    border-radius: 8px;
    transition: background-color 0.3s, transform 0.2s;
}

.list-group-item:hover {
    background-color: var(--primary-hover);
    color: var(--background);
    transform: translateY(-2px);
}

.list-group-item p {
    margin: 0;
}

.list-group-item:last-child {
    margin-bottom: 0;
}

p {
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.alert {
    margin-top: 1rem;
    font-size: 1rem;
    border-radius: 8px;
    padding: 1rem;
}

.alert-danger {
    background-color: #F8D7DA;
    color: #721C24;
}

.alert-success {
    background-color: #D4EDDA;
    color: #155724;
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    h4 {
        font-size: 1.5rem;
    }

    .list-group-item {
        font-size: 0.875rem;
        padding: 0.75rem;
    }
}
</style>
<?php include "inc/NavBar.php"; ?>
<div class="container">
  <!-- NavBar & Profile-->
   
        <?php include "inc/Profile.php"; ?>
    <div class="r-side p-5 shadow mx-2">
      <h4>Account Information</h4>
        <ul class="list-group" style="max-width: 600px;">
          <li class="list-group-item">First name: <?=$instructor['first_name']?></li>
          <li class="list-group-item">Last name: <?=$instructor['last_name']?></li>
          <li class="list-group-item">Email: <?=$instructor['email']?></li>
          <li class="list-group-item">Date of birth: <?=$instructor['date_of_birth']?></li>
          <li class="list-group-item">Joined at: <?=$instructor['date_of_joined']?></li>
          <li class="list-group-item">Username: <?=$instructor['username']?></li>
        </ul>
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
