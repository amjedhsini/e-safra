<?php 
  session_start();
  include "../Utils/Util.php";
  if (isset($_SESSION['username']) && isset($_SESSION['admin_id'])) {
      include "../Controller/Admin/Instructor.php";
      $row_count = getCount();

      $page = 1;
      $row_num = 5;
      $offset = 0;
      $last_page = ceil($row_count / $row_num);
      if(isset($_GET['page'])){
          if($_GET['page'] > $last_page){
              $page = $last_page;
          } else if($_GET['page'] <= 0){
              $page = 1; 
          } else {
              $page = $_GET['page'];
          }
      }
      if($page != 1) $offset = ($page-1) * $row_num;
      $instructors = getSomeInstructors($offset, $row_num);
      $title = "E-Safra - Instructors";
      include "inc/Header.php"; 
      include "inc/NavBar.php";
?>

<div class="container">
  <div class="list-table pt-5">
    <?php if ($instructors) { ?>
      <h4>All Instructors (<?=$row_count?>) <a class="btn btn-success md-btn" href="Instructor-add.php">Add Instructor</a></h4>

      <table class="table table-bordered">
          <tr>
            <th>#Id</th>
            <th>Full name</th>
            <th>Status</th>
            <th>Update</th>
            <th>Delete</th>
          </tr>
          <?php foreach ($instructors as $instructor) { ?>
          <tr>
          <td><?=$instructor["instructor_id"]?></td>
           <td><a href="instructor.php?instructor_id=<?=$instructor["instructor_id"]?>"><?=$instructor["first_name"]?> <?=$instructor["last_name"]?></a></td>
           <td class="status"> <?=$instructor["status"]?></td>
           <td class="action_btn">
             <a href="update-instructor-profile.php?instructor_id=<?=$instructor['instructor_id']?>" class="btn btn-primary">Update</a>
           </td>
           <td class="action_btn">
             <a href="javascript:void()" onclick="DeleteInstructor(<?=$instructor['instructor_id']?>)" class="btn btn-danger">Delete</a>
           </td>
          </tr>
          <?php } ?>
      </table>
      <?php if ($last_page > 1 ) { ?>
      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-3 border">
          <!-- Pagination logic remains same -->
      </div>
      <?php }}else { ?>
        <div class="alert alert-info" role="alert">
          0 instructors record found in the database
        </div>
      <?php } ?>
  </div>
</div>

<?php include "inc/Footer.php"; ?>

<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
function DeleteInstructor(inst_id) {
    if (confirm('Are you sure you want to delete this instructor? This action cannot be undone.')) {
        $.ajax({
            url: "Action/delete-instructor.php",
            type: "POST",
            data: { instructor_id: inst_id },
            success: function(data) {
                if (data == "success") {
                    alert("Instructor deleted successfully.");
                    location.reload();
                } else {
                    alert(data);
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + error);
            }
        });
    }
}
</script>

<?php
 } else { 
   $em = "First login ";
   Util::redirect("../login.php", "error", $em);
}
?>
