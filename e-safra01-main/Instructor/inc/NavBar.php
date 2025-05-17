<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-custom-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashbord_instructor.php">
            <img src="../assets/img/Logo.png" alt="Online learning system" width="50" height="40">
            E-safra
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Replace this div with a nav tag -->
        <nav class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item position-relative">
                    <a class="nav-link" href="dashbord_instructor.php">dashboard</a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link" href="Courses.php">Your Courses</a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link" href="Courses-Materials.php">Courses Materials</a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link" href="instructor_messages.php">Messages</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Create
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="Courses-add.php">Create New Courses</a></li>
                        <li><a class="dropdown-item" href="Courses-add.php#Chapter">Create Chapter</a></li>
                        <li><a class="dropdown-item" href="Courses-add.php#Topic">Create Topic</a></li>
                        <li><a class="dropdown-item" href="Courses-content-add.php">Create Course Content</a></li>
                       
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="Profile-View.php">View Profile</a></li>
                        <li><a class="dropdown-item" href="Profile-Edit.php">Edit Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../Logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</nav>

<style>
:root {
    --primary-color: #333333;
    --secondary-color: #f8f9fa;
    --accent-color: #ffc107;
    --text-color: #333333;
    --light-gray: #6c757d;
    --white: #ffffff;
}


*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: var(--secondary-color);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--text-color);
    overflow-x: hidden;
    width: 100%;
    max-width: 100%;
}

/* Navbar styling */
.bg-custom-dark {
    background-color: #1c1c1e !important;
}

.navbar-brand img {
    margin-right: 0.5rem;
}

.navbar-nav .nav-link {
    color: #fff !important;
    font-weight: bold;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link:focus {
    background-color: #e3b500 !important;
    color: #000 !important;
}

.navbar-nav .nav-link.active {
    background-color: #e3b500 !important;
    color: #000 !important;
}

.dropdown-menu {
    background-color: #2c2c2e !important;
    border: none !important;
    border-radius: 0.5rem !important;
    padding: 0.5rem 0;
}

.dropdown-item {
    color: #fff !important;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.dropdown-item:hover,
.dropdown-item:focus {
    background-color: #e3b500 !important;
    color: #000 !important;
}

.dropdown-divider {
    border-top: 1px solid #444 !important;
    margin: 0.5rem 0 !important;
}

/* Force the navbar’s container to span the full width */
.navbar .container-fluid {
    width: 100%;
    max-width: 1200px; /* Keep navbar max width */
    margin-left: auto;
    margin-right: auto;
    padding-left: 1rem;
    padding-right: 1rem;

}
.navbar .container{
    width: 100%;
    max-width: 1200px; /* Keep navbar max width */
    margin-left: auto;
    margin-right: auto;
    margin-top: 0px;
    margin-bottom: 0px;
}

.navbar {
    background-color: #333333;
    color: #ffffff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.navbar-brand {
    color: #e3b500;
    font-weight: bold;
}
.navbar-brand:hover {
    color: #c79d00;
}
.navbar-nav .nav-link {
    color: #ffffff;
    font-size: 1.1rem;
    margin-right: 15px;
}
.navbar-nav .nav-link:hover {
    color: #e3b500;
}
.navbar-toggler {
    border-color: #e3b500;
}
.navbar-toggler-icon {
    background-color: #e3b500;
}
.dropdown-menu {
    background-color: #444444;
    border: none;
}
.dropdown-item {
    color: #ffffff;
}
.dropdown-item:hover {
    background-color: #e3b500;
    color: #000000;
}
</style>