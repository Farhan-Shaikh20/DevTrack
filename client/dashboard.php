<?php
require "../includes/client_auth.php";
require "../config/database.php";

$user_id = $_SESSION["user_id"];

/* Get client information */
$sql = "SELECT client.id, users.name, users.email, client.company_name, client.phone
        FROM client
        INNER JOIN users ON client.user_id = users.id
        WHERE client.user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) != 1) {
    die("Client profile not found.");
}
$client = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

/* Count client's projects */
$client_id = $client["id"];
$sql_projects = "SELECT COUNT(*) AS total_projects FROM projects WHERE client_id = ?";
$stmt_projects = mysqli_prepare($conn, $sql_projects);
mysqli_stmt_bind_param($stmt_projects, "i", $client_id);
mysqli_stmt_execute($stmt_projects);
$result_projects = mysqli_stmt_get_result($stmt_projects);
$row_projects = mysqli_fetch_assoc($result_projects);
$total_projects = $row_projects["total_projects"];
mysqli_stmt_close($stmt_projects);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - Client Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fa-solid fa-cubes"></i> DevTrack <span>Client Portal</span></div>
        <div class="nav-user">
            <span>Welcome, <strong><?php echo htmlspecialchars($client["name"]); ?></strong></span>
            <a href="../logout.php" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Client Dashboard</h1>
                <p class="page-subtitle">Track your project status & view account profile details</p>
            </div>
            <a href="projects.php" class="btn btn-primary"><i class="fa-solid fa-folder-open"></i> View My Projects</a>
        </div>

        <div class="grid grid-cols-2" style="margin-bottom: 2rem;">
            <div class="card">
                <h3 style="margin-bottom: 1rem; color: var(--primary);"><i class="fa-solid fa-user"></i> My Profile</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div><strong>Name:</strong> <?php echo htmlspecialchars($client["name"]); ?></div>
                    <div><strong>Email:</strong> <?php echo htmlspecialchars($client["email"]); ?></div>
                    <div><strong>Company:</strong> <?php echo htmlspecialchars($client["company_name"]); ?></div>
                    <div><strong>Phone:</strong> <?php echo htmlspecialchars($client["phone"]); ?></div>
                </div>
            </div>

            <div class="stat-card" style="border-left: 4px solid var(--primary); justify-content: center;">
                <span class="stat-label"><i class="fa-solid fa-diagram-project"></i> Total Assigned Projects</span>
                <span class="stat-value"><?php echo $total_projects; ?></span>
                <div style="margin-top: 1.5rem;">
                    <a href="projects.php" class="btn btn-secondary btn-sm">Explore Projects <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> DevTrack Management System.</p>
    </footer>
</body>
</html>
<?php mysqli_close($conn); ?>