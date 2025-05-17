<?php 
session_start();
include "../Utils/Util.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['instructor_id'])) {

    include "../Controller/Instructor/Course.php";

    $instructor_id = $_SESSION['instructor_id'];
    $row_count = getCountByInstructorId($instructor_id);

    $page = 1;
    $row_num = 5;
    $offset = 0;

    $last_page = ceil($row_count / $row_num);
    if (isset($_GET['page'])) {
        if ($_GET['page'] > $last_page) {
            $page = $last_page;
        } else if ($_GET['page'] <= 0) {
            $page = 1; 
        } else {
            $page = $_GET['page'];
        }
    }
    if ($page != 1) $offset = ($page - 1) * $row_num;
    $courses = getSomeCoursesByInstructorId($offset, $row_num, $instructor_id);
   
    
    $title = "E-Safra - Courses ";
    include "inc/Header.php";
?>

<style>
  :root {
    --bg: #f5f5f5;
    --bg-alt: #ffffff;
    --color: #222222;
    --color-light: #777777;
    --accent: #ffc107;
    --dark: #000000;
    --border: #dddddd;
  }

  /* Reset & box sizing */
  *, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    background-color: var(--bg);
    color: var(--color);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    overflow-x: hidden;
  }

  /* Full-width page wrapper */
  .container {
    max-width: 1200px;
    width: 100%;
    margin: auto;
    padding: 0px;
  }

  /* Section heading */
  .list-table h4 {
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--dark);
    letter-spacing: 0.5px;
  }

  /* Table card */
  .list-table .table {
    width: 100%;
    border-collapse: collapse;
    background-color: var(--bg-alt);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  }

  /* Sticky header */
  .list-table .table thead {
    position: sticky;
    top: 0;
    z-index: 2;
  }
  .list-table .table thead th {
    background-color: var(--dark);
    color: var(--bg-alt);
    text-transform: uppercase;
    font-size: 0.85rem;
    padding: 1rem 1.25rem;
    border: none;
  }

  /* Rows & cells */
  .list-table .table tbody td {
    padding: 0.75rem 1.25rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
  }

  .list-table .table tbody tr:nth-child(even) {
    background-color: #fafafa;
  }
  .list-table .table tbody tr:hover {
    background-color: var(--bg-alt);
    transform: translateX(4px);
    transition: background-color 0.2s, transform 0.2s;
  }

  /* Status pill */
  .status {
    display: inline-block;
    padding: 0.25em 0.75em;
    background-color: var(--dark);
    color: black;
    font-size: 0.85rem;
    border-radius: 50px;
    text-align: center;
  }

  /* Action buttons */
  .action_btn .btn {
    padding: 0.4rem 0.9rem;
    font-size: 0.85rem;
    border-radius: 50px;
    transition: background-color 0.3s, color 0.3s;
  }
  .btn-warning {
    background-color: var(--accent);
    border-color: var(--accent);
    color: var(--dark);
  }
  .btn-warning:hover {
    background-color: #e0a800;
    border-color: #e0a800;
    color: var(--bg-alt);
  }

  /* Pagination container */
  .list-table .border {
    background: none !important;
    box-shadow: none !important;
    margin-top: 2rem;
    display: flex;
    justify-content: center;
  }

  /* Pagination buttons */
  .list-table .border .btn {
    margin: 0 0.25rem;
    border-radius: 50px;
    font-size: 0.9rem;
    padding: 0.5rem 0.85rem;
    transition: all 0.3s;
  }
  .btn-secondary {
    background: var(--bg-alt);
    border: 1px solid var(--border);
    color: var(--color);
  }
  .btn-secondary:hover:not(.disabled) {
    background: var(--dark);
    color: var(--bg-alt);
    border-color: var(--dark);
  }
  .btn-success {
    background: var(--dark);
    border: 1px solid var(--dark);
    color: var(--bg-alt);
  }
  .btn-success:hover {
    background: #333;
    border-color: #333;
  }
  .btn.disabled, .btn:disabled {
    opacity: 0.5;
    pointer-events: none;
  }

  /* “No data” alert */
  .alert-info {
    background-color: #fff3cd;
    border-color: #ffecb5;
    color: #856404;
    border-radius: 6px;
    padding: 1rem 1.25rem;
  }
</style>

<script src="../assets/js/jquery-3.5.1.min.js"></script>
<?php include "inc/NavBar.php"; ?>
<div class="container">
  <div class="list-table pt-5">
    <?php if ($courses) { ?>
    <h4>Your Courses (<?=$row_count?>)</h4>

    <table class="table table-bordered">
        <tr>
          <th>#Id</th>
          <th>Course Title</th>
          <th>Status</th>
          <th>Action</th>
       
        </tr>
        <?php foreach ($courses as $course) { ?>
        <tr>
        <td><?=$course["course_id"]?></td>
         <td><?=$course["title"]?></td>
         <td class="status"> <?=$course["status"]?></td>
         <td class="action_btn">
          <?php  
          $status = $course["status"];
          $course_id = $course["course_id"];
          $text_temp = $course["status"] == "Public" ? "Private": "Public";
          ?> 
          <a href="javascript:void()" onclick="ChangeStatus(this, <?=$course_id?>)" class="btn btn-warning"><?=$text_temp?></a>
         </td>
  
        </tr>
        <?php } ?>
    </table>
    <?php if ($last_page > 1 ) { ?>
    <div class="d-flex justify-content-center mt-3 border">
        <?php
            $prev = 1;
            $next = 1;
            $next_btn = true;
            $prev_btn = true;
            if($page <= 1) $prev_btn = false; 
            if($last_page ==  $page) $next_btn = false; 
            if($page > 1) $prev = $page - 1;
            if($page < $last_page) $next = $page + 1;
            
            if ($prev_btn){
            ?>
            <a href="Courses.php?page=<?=$prev?>" class="btn btn-secondary m-2">Prev</a>
           <?php }else { ?>
            <a href="#" class="btn btn-secondary m-2 disabled">Prev</a>
            
           <?php 
           }
           $push_mid = $page;
           if ($page >= 2)  $push_mid = $page - 1;
           if ($page > 3)  $push_mid = $page - 3;
          
           for($i = $push_mid; $i < 5 + $page; $i++){
            if($i == $page){ ?>
             <a href="Courses.php?page=<?=$i?>" class="btn btn-success m-2"><?=$i?></a>
           <?php }else{ ?>
             <a href="Courses.php?page=<?=$i?>" class="btn btn-secondary m-2"><?=$i?></a>

           <?php } 
           if($last_page <= $i) break;
            } 
            if($next_btn){
            ?>
            <a href="Courses.php?page=<?=$next?>" class="btn btn-secondary m-2">Next</a>
        <?php }else { ?>
           <a href="#" class="btn btn-secondary m-2 disabled" des>Next</a>
        <?php } ?>
    </div>

    <?php }}else { ?>
      <div class="alert alert-info" role="alert">
        0 Course record found in the database
    </div>

    <?php } ?>
  </div>
</div>

 <!-- Footer -->
<?php include "inc/Footer.php"; ?>

<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>
