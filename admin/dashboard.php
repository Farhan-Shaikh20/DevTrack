<?php
require "../includes/auth.php";
require "../config/database.php";

/* Total Clients */
$sql_clients = "SELECT COUNT(*) AS total_clients FROM client";
$result_clients = mysqli_query($conn, $sql_clients);
$row_clients = mysqli_fetch_assoc($result_clients);
$total_clients = $row_clients["total_clients"];

/* Total Projects */
$sql_projects = "SELECT COUNT(*) AS total_projects FROM projects";
$result_projects = mysqli_query($conn, $sql_projects);
$row_projects = mysqli_fetch_assoc($result_projects);
$total_projects = $row_projects["total_projects"];

/* Project Status Statistics */
$sql_planning = "SELECT COUNT(*) AS total FROM projects WHERE status = 'Planning'";
$result_planning = mysqli_query($conn, $sql_planning);
$row_planning = mysqli_fetch_assoc($result_planning);
$planning = $row_planning["total"];

$sql_in_progress = "SELECT COUNT(*) AS total FROM projects WHERE status = 'In Progress'";
$result_in_progress = mysqli_query($conn, $sql_in_progress);
$row_in_progress = mysqli_fetch_assoc($result_in_progress);
$in_progress = $row_in_progress["total"];

$sql_testing = "SELECT COUNT(*) AS total FROM projects WHERE status = 'Testing'";
$result_testing = mysqli_query($conn, $sql_testing);
$row_testing = mysqli_fetch_assoc($result_testing);
$testing = $row_testing["total"];

$sql_completed = "SELECT COUNT(*) AS total FROM projects WHERE status = 'Completed'";
$result_completed = mysqli_query($conn, $sql_completed);
$row_completed = mysqli_fetch_assoc($result_completed);
$completed = $row_completed["total"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand">
            <i class="fa-solid fa-cubes"></i> DevTrack <span>Admin</span>
        </div>
        <div class="nav-user">
            <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION["name"]); ?></strong></span>
            <a href="../logout.php" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Admin Dashboard</h1>
                <p class="page-subtitle">Overview of current clients, project progress & system status</p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="clients/index.php" class="btn btn-primary"><i class="fa-solid fa-users"></i> Manage Clients</a>
                <a href="projects/index.php" class="btn btn-secondary"><i class="fa-solid fa-diagram-project"></i> Manage Projects</a>
            </div>
        </div>

        <!-- Main Stats -->
        <div class="grid grid-cols-2" style="margin-bottom: 2rem;">
            <div class="stat-card" style="border-left: 4px solid var(--primary);">
                <span class="stat-label"><i class="fa-solid fa-users"></i> Total Registered Clients</span>
                <span class="stat-value"><?php echo $total_clients; ?></span>
            </div>
            <div class="stat-card" style="border-left: 4px solid var(--info);">
                <span class="stat-label"><i class="fa-solid fa-diagram-project"></i> Active & Total Projects</span>
                <span class="stat-value"><?php echo $total_projects; ?></span>
            </div>
        </div>

        <!-- Project Breakdown -->
        <div class="card">
            <h3 style="margin-bottom: 1.25rem; font-size: 1.1rem; color: var(--text-main);">
                <i class="fa-solid fa-chart-pie" style="color: var(--primary); margin-right: 6px;"></i> Project Status Overview
            </h3>
            <div class="grid grid-cols-4">
                <div class="stat-card" style="background: #f8fafc;">
                    <span class="stat-label">Planning</span>
                    <span class="stat-value" style="color: #0369a1;"><?php echo $planning; ?></span>
                </div>
                <div class="stat-card" style="background: #f8fafc;">
                    <span class="stat-label">In Progress</span>
                    <span class="stat-value" style="color: #b45309;"><?php echo $in_progress; ?></span>
                </div>
                <div class="stat-card" style="background: #f8fafc;">
                    <span class="stat-label">Testing</span>
                    <span class="stat-value" style="color: #6b21a8;"><?php echo $testing; ?></span>
                </div>
                <div class="stat-card" style="background: #f8fafc;">
                    <span class="stat-label">Completed</span>
                    <span class="stat-value" style="color: #15803d;"><?php echo $completed; ?></span>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> DevTrack Management System. Built with PHP & Clean Modern UI.</p>
    </footer>
</body>
</html>
<?php mysqli_close($conn); ?>