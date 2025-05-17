<?php 
  session_start();
  include "../Controller/Admin/System.php";  
  $student_count    = getstudentsCount();
  $Instructor_count = getInstructorCount();
  $Course_count     = getCourseCount();
  $title = "Admin Dashboard - E-SAFRA";
  include "inc/Header.php"; 
  include "inc/NavBar.php";
?>

<div class="container dashboard-wrapper" style="padding-top: 80px;">
  <div class="dashboard-layout">
    <!-- Left Panel: Overall Statistics Cards -->
    <div class="left-panel">
      <h2>Overview</h2>
      <div class="dashboard-cards">
        <div class="card">
          <h5>Total Students</h5>
          <p><?php echo $student_count; ?></p>
        </div>
        <div class="card">
          <h5>Total Instructors</h5>
          <p><?php echo $Instructor_count; ?></p>
        </div>
        <div class="card">
          <h5>Total Courses</h5>
          <p><?php echo $Course_count; ?></p>
        </div>
      </div>

      <!-- Button to navigate to the change-password page -->
      <div class="d-grid mt-4">
        <a href="change-password.php" class="btn btn-dark btn-lg py-2 shadow-sm">
          Change Admin Password
        </a>
      </div>
    </div>
    
    <!-- Right Panel: Analysis & Charts -->
    <div class="right-panel">
      <h2>Analysis & Trends</h2>
      <div class="analysis-section">
        <div class="chart-box">
          <h4>Student Growth (Last 4 Weeks)</h4>
          <canvas id="studentGrowthChart" width="400" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "inc/Footer.php"; ?>

<script>
// Sample Data for Student Growth Chart
var studentGrowthData = {
  labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
  datasets: [{
    label: 'New Students',
    data: [10, 25, 15, 20],
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderColor: 'rgba(75, 192, 192, 1)',
    borderWidth: 1
  }]
};

var ctx1 = document.getElementById('studentGrowthChart').getContext('2d');
new Chart(ctx1, {
  type: 'bar',
  data: studentGrowthData,
  options: {
      scales: {
          y: { beginAtZero: true }
      }
  }
});
</script>

<style>
  /* Custom styles to match the admin theme */
  .dashboard-wrapper {
    margin-top: 20px;
  }

  .dashboard-layout {
    display: flex;
    justify-content: space-between;
  }

  .left-panel {
    width: 40%;
  }

  .right-panel {
    width: 55%;
  }

  .dashboard-cards {
    display: flex;
    justify-content: space-between;
  }

  .card {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 30%;
    text-align: center;
  }

  .card h5 {
    font-size: 18px;
    color: #2c3e50;
  }

  .card p {
    font-size: 24px;
    font-weight: bold;
    color: #e3b500;
  }

  /* Button style for Change Password */
  .btn-dark {
    background-color: #e3b500;
    color: #fff;
    font-weight: 600;
    border-radius: 5px;
    transition: all 0.3s ease;
  }

  .btn-dark:hover {
    background-color: #d4aa00;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
</style>
