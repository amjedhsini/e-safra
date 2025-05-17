<?php 
  session_start();
  include "../Utils/Util.php";
  if (isset($_SESSION['username']) && isset($_SESSION['admin_id'])) {
      include "../Controller/Admin/Student.php";
      $row_count = getCount(); // Function to get total number of students
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
      if ($page != 1) $offset = ($page-1) * $row_num;
      $students = getSomeStudent($offset, $row_num); // Function to get paginated student data
      $title = "E-Safra - Students";
      include "inc/Header.php"; 
      include "inc/NavBar.php";
?>

<div class="container">
    <div class="list-table pt-5">
        <?php if ($students) { ?>
        <h4>All Students (<?=$row_count?>)</h4>

        <table class="table table-bordered">
            <tr>
              <th>#Id</th>
              <th>Full name</th>
              <th>Status</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
            <?php foreach ($students as $student) { ?>
            <tr>
            <td><?=$student["student_id"]?></td>
            <td><a href="student.php?student_id=<?=$student["student_id"]?>"><?=$student["first_name"]?> <?=$student["last_name"]?></a></td>
            <td class="status"><?=$student["status"]?></td>
            <td class="action_btn">
                <a href="update-student-profile.php?student_id=<?=$student["student_id"]?>" class="btn btn-primary">Update</a>
            </td>
            <td class="action_btn">
                <a href="javascript:void()" onclick="DeleteStudent(<?=$student["student_id"]?>)" class="btn btn-danger">Delete</a>
            </td>
            </tr>
            <?php } ?>
        </table>
        <?php if ($last_page > 1 ) { ?>
        <div class="d-flex justify-content-center mt-3 border">
            <!-- Pagination logic -->
            <?php
                $prev = 1;
                $next = 1;
                $next_btn = true;
                $prev_btn = true;
                if($page <= 1) $prev_btn = false;
                if($last_page == $page) $next_btn = false;
                if($page > 1) $prev = $page - 1;
                if($page < $last_page) $next = $page + 1;

                if ($prev_btn) {
            ?>
            <a href="index.php?page=<?=$prev?>" class="btn btn-secondary m-2">Prev</a>
            <?php } else { ?>
            <a href="#" class="btn btn-secondary m-2 disabled">Prev</a>
            <?php } ?>

            <?php
            for($i = $page - 2; $i <= $page + 2; $i++) {
                if ($i > 0 && $i <= $last_page) {
                    if ($i == $page) { ?>
                        <a href="index.php?page=<?=$i?>" class="btn btn-success m-2"><?=$i?></a>
                    <?php } else { ?>
                        <a href="index.php?page=<?=$i?>" class="btn btn-secondary m-2"><?=$i?></a>
                    <?php }
                }
            }

            if ($next_btn) {
            ?>
            <a href="index.php?page=<?=$next?>" class="btn btn-secondary m-2">Next</a>
            <?php } else { ?>
            <a href="#" class="btn btn-secondary m-2 disabled">Next</a>
            <?php } ?>
        </div>
        <?php }} else { ?>
        <div class="alert alert-info" role="alert">
            0 students record found in the database
        </div>
        <?php } ?>
    </div>
</div>

<?php include "inc/Footer.php"; ?>

<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
function DeleteStudent(stud_id) {
    if (confirm('Are you sure you want to delete this student? This action cannot be undone.')) {
        $.ajax({
            url: "Action/delete-student.php",
            type: "POST",
            data: { student_id: stud_id },
            success: function(data) {
                if (data == "success") {
                    alert("Student deleted successfully.");
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
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>

