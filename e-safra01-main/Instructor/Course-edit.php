<?php 
  # Header
  $title = "E-Safra - Courses";
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
    padding: 2rem 1rem;
}

.card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    padding: 1.5rem;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.card-body {
    background-color: #ffffff;
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

.list-group-item {
    border: 1px solid var(--border);
    margin-bottom: 0.5rem;
    padding: 1rem;
    background-color: #fff;
}

.list-group-item .d-flex {
    align-items: center;
}

.list-group-item .form-control {
    margin-left: 10px;
}

.list-group-item .fa-edit {
    color: var(--primary);
    cursor: pointer;
}

.list-group-item .fa-edit:hover {
    color: var(--primary-hover);
}

.mt-5 {
    margin-top: 3rem;
}

.mb-3 {
    margin-bottom: 1.5rem;
}

.card-body .form-control {
    margin-top: 1rem;
}

.card-body .form-control + .form-control {
    margin-top: 0.75rem;
}

/* Flex container for Chapters and Topics */
.d-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.d-flex a {
    margin-right: 15px;
}

/* Make sure inputs and buttons align well */
input[type="text"] {
    width: 100%;
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

/* Adjust for mobile screens */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .card {
        padding: 1rem;
    }

    h4 {
        font-size: 1.25rem;
    }

    .form-control {
        font-size: 0.875rem;
    }
}
  </style>

<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>

  <h4 class="course-list-title"></h4>
  <div class="card">
    <div class="card-body">
      <form>
          <div class="mb-3">
            <label class="form-label">Course Title:</label>
            <input type="text" 
                   class="form-control"
                   value="Machine Learning Algorithms in Python">
          </div>
          <div class="mb-3">
            <label class="form-label">Course Description</label>
            <textarea name="" class="form-control" rows="3">Machine learning (ML) is a subfield of artificial intelligence (AI) that focuses on developing algorithms and models that enable computers to learn patterns from data and make predictions or decisions without being explicitly programmed.
            </textarea>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <form class="mt-5">
          <h4 id="Chapters">Chapters</h4>
          <div class="mb-3">
            <input type="text" 
                   class="form-control"
                   value="Chapter-1">
          </div>
          <div class="mb-3">
            <input type="text" 
                   class="form-control"
                   value="Chapter-2">
          </div>
        <button type="submit" class="btn btn-primary">Save</button>
        </form>


        <form class="mt-5">
        <h4 id="Chapters">Topic</h4>
        <ul class="list-group mb-3">
          <li class="list-group-item">
              Chapter-1
              <ul class="list-group mb-3">
                 <li class="list-group-item">
                  <div class="mb-3 d-flex align-items-center">
                    <a href="Courses-content-edit.php" > <i class="fa fa-edit fs-4"></i></a>
                    <input type="text" 
                           class="form-control"
                           value="Topic-1">
                  </div>
                  <div class="mb-3 d-flex align-items-center">
                    <a href="Courses-content-edit.php"> <i class="fa fa-edit fs-4"></i></a>
                    <input type="text" 
                           class="form-control"
                           value="Topic-2">
                  </div>
                 </li>
              </ul>
          </li>
          <li class="list-group-item">
              Chapter-2 
              <ul class="list-group mb-3">
                 <li class="list-group-item">
                  <div class="mb-3 d-flex align-items-center">
                    <a href="Courses-content-edit.php" > <i class="fa fa-edit fs-4"></i></a>
                    <input type="text" 
                           class="form-control"
                           value="Topic-1">
                  </div>
                  <div class="mb-3 d-flex align-items-center">
                    <a href="Courses-content-edit.php"> <i class="fa fa-edit fs-4"></i></a>
                    <input type="text" 
                           class="form-control"
                           value="Topic-2">
                  </div>
                 </li>
              </ul>
          </li>
        </ul>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
</div>
</div>
</div>

 <!-- Footer -->
<?php include "inc/Footer.php"; ?>