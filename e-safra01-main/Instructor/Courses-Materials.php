<?php 
session_start();
include "../Utils/Util.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['instructor_id'])) {
  
    include "../Controller/Instructor/CoursesMaterial.php";
  
    $instructor_id = $_SESSION['instructor_id'];
    $row_count = getCountByInstructorId($instructor_id);

    $page = 1;
    $row_num = 5;
    $offset = 0;
   
    $last_page = ceil($row_count / $row_num);
    if(isset($_GET['page'])){
    if($_GET['page'] > $last_page){
        $page = $last_page;
    }else if($_GET['page'] <= 0){
        $page = 1; 
    }else $page = $_GET['page'];
    }
    if($page != 1) $offset = ($page-1) * $row_num;
    $CoursesMaterials = getSomeCoursesMaterialsByInstructorId($offset, $row_num, $instructor_id);
    # Header
    $title = "E-Safra - Courses Materials ";
    include "inc/Header.php";

?>

<style>
  :root {
    --primary: #000000;
    --secondary: #836f0a;
    --accent: #5c5951;
    --light: #fffcf2;
    --dark: #2a2a2a;
    --text-dark: #333333;
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
    color: var(--text-dark);
    font-family: 'Nunito', sans-serif;
    overflow-x: hidden;
  }

  /* Full-width wrapper */
  .container {
    max-width: 800px; /* Reduced width for better layout */
    margin: auto;
    padding: 1rem;
}

  /* Header with action button */
  .list-table h4 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
  }
  .list-table h4 .btn-primary {
    background: var(--dark);
    border: 2px solid var(--dark);
    color: var(--light);
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    transition: background 0.3s, transform 0.3s;
  }
  .list-table h4 .btn-primary:hover {
    background: var(--secondary);
    border-color: var(--secondary);
    transform: translateY(-2px);
  }

  /* Table styling */
  .list-table .table {
    width: 100%;
    border-collapse: collapse;
    background: var(--light);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
  }
  .list-table .table th,
  .list-table .table td {
    padding: 0.85rem 1.25rem;
    text-align: left;
  }
  .list-table .table thead th {
    background: var(--dark);
    color: var(--light);
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    border: none;
  }
  .list-table .table tbody tr {
    transition: background 0.2s, transform 0.2s;
  }
  .list-table .table tbody tr:nth-child(even) {
    background: #fafafa;
  }
  .list-table .table tbody tr:hover {
    background: var(--light);
    transform: translateX(4px);
  }
  .list-table .table tbody td {
    border-top: 1px solid var(--border-light);
  }

  /* URL code styling */
  .list-table .status mark code {
    display: inline-block;
    background: var(--secondary);
    color: var(--light);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.85rem;
    word-break: break-all;
  }

  /* Pagination */
  .list-table .border {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
    background: none !important;
    box-shadow: none !important;
    border: none !important;
  }
  .list-table .border .btn {
    border-radius: 50px;
    padding: 0.5rem 0.9rem;
    font-size: 0.9rem;
    transition: background 0.3s, transform 0.3s;
  }
  .btn-secondary {
    background: var(--dark);
    border: 1px solid var(--dark);
    color: var(--light);
  }
  .btn-secondary:hover:not(.disabled) {
    background: var(--accent);
    border-color: var(--accent);
    transform: translateY(-2px);
  }
  .btn-success {
    background: var(--secondary);
    border: 1px solid var(--secondary);
    color: var(--light);
  }
  .btn-success:hover {
    background: var(--accent);
    border-color: var(--accent);
    transform: translateY(-2px);
  }
  .btn.disabled, 
  .btn:disabled {
    opacity: 0.6;
    pointer-events: none;
  }

  /* “No data” alert */
  .alert-info {
    background: #fff3cd;
    border: 1px solid #ffecb5;
    color: #856404;
    border-radius: 8px;
    padding: 1rem 1.25rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  }

  /* Responsive tweaks */
  @media (max-width: 768px) {
    .container {
      padding: 1.5rem;
    }
    .list-table h4 {
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }
    .list-table .table th,
    .list-table .table td {
      padding: 0.6rem 1rem;
    }
    .list-table .border .btn {
      padding: 0.4rem 0.75rem;
      font-size: 0.85rem;
    }
  }
</style>
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>

<div class="container">

  
  <div class="list-table pt-5">
  
 <h4>All Courses Materials (<?=$row_count?>) <a href="Courses-Materials-add.php" class="btn btn-primary">Upload Material</a></h4><br>
 <?php if ($CoursesMaterials) { ?>
  <table class="table table-bordered">
      <tr>
      <th>File</th>
        <th>Type</th>
        <th>URL</th>
      </tr>
      <?php foreach ($CoursesMaterials as $CoursesMaterial) {?>
      <tr>
      <td><a href="<?=$CoursesMaterial["URL"]?>"><img src="../assets/img/Logo.jpg" width="100"></td>
       <td><?=$CoursesMaterial["type"]?></td>
       <td class="status"> <mark><code class="p-2"><?=$CoursesMaterial["URL"]?></code></td>
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
            <a href="Courses-Materials.php?page=<?=$prev?>" class="btn btn-secondary m-2">Prev</a>
           <?php }else { ?>
            <a href="#" class="btn btn-secondary m-2 disabled">Prev</a>
            
           <?php 
           }
           $push_mid = $page;
           if ($page >= 2)  $push_mid = $page - 1;
           if ($page > 3)  $push_mid = $page - 3;
          
           for($i = $push_mid; $i < 5 + $page; $i++){
            if($i == $page){ ?>
             <a href="Courses-Materials.php?page=<?=$i?>" class="btn btn-success m-2"><?=$i?></a>
           <?php }else{ ?>
             <a href="Courses-Materials.php?page=<?=$i?>" class="btn btn-secondary m-2"><?=$i?></a>

           <?php } 
           if($last_page <= $i)break;

            } 
            if($next_btn){
            ?>
            <a href="Courses-Materials.php?page=<?=$next?>" class="btn btn-secondary m-2">Next</a>
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
<script src="../assets/js/jquery-3.5.1.min.js"></script>
<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>