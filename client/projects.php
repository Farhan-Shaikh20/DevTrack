<?php
require "../includes/client_auth.php";
require "../config/database.php";

$user_id = $_SESSION["user_id"];

/* Get client ID */
$sql_client = "SELECT id FROM client WHERE user_id = ?";
$stmt_client = mysqli_prepare($conn, $sql_client);
mysqli_stmt_bind_param($stmt_client, "i", $user_id);
mysqli_stmt_execute($stmt_client);
$result_client = mysqli_stmt_get_result($stmt_client);

if (mysqli_num_rows($result_client) != 1) {
    die("Client profile not found.");
}
$client = mysqli_fetch_assoc($result_client);
$client_id = $client["id"];
mysqli_stmt_close($stmt_client);

/* Get client's projects */
$sql_projects = "SELECT id, project_name, description, start_date, end_date, status
                 FROM projects
                 WHERE client_id = ?
                 ORDER BY id DESC";
$stmt_projects = mysqli_prepare($conn, $sql_projects);
mysqli_stmt_bind_param($stmt_projects, "i", $client_id);
mysqli_stmt_execute($stmt_projects);
$result_projects = mysqli_stmt_get_result($stmt_projects);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - My Projects</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fa-solid fa-cubes"></i> DevTrack <span>Client Portal</span></div>
        <div class="nav-user">
            <a href="dashboard.php" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>
            <a href="../logout.php" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">My Projects</h1>
                <p class="page-subtitle">Detailed list of projects assigned to your account</p>
            </div>
        </div>

        <div class="grid grid-cols-2">
            <?php if (mysqli_num_rows($result_projects) > 0) { ?>
                <?php while ($project = mysqli_fetch_assoc($result_projects)) { 
                    $status_class = 'badge-planning';
                    if ($project['status'] == 'In Progress') $status_class = 'badge-in-progress';
                    if ($project['status'] == 'Testing') $status_class = 'badge-testing';
                    if ($project['status'] == 'Completed') $status_class = 'badge-completed';
                ?>
                    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                                <h3 style="font-size: 1.2rem; color: var(--text-main);"><?php echo htmlspecialchars($project["project_name"]); ?></h3>
                                <span class="badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($project["status"]); ?></span>
                            </div>
                            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">
                                <?php echo htmlspecialchars($project["description"] ? $project["description"] : "No description provided."); ?>
                            </p>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
                                <span><i class="fa-regular fa-calendar"></i> <?php echo $project["start_date"] ? $project["start_date"] : 'TBD'; ?> to <?php echo $project["end_date"] ? $project["end_date"] : 'TBD'; ?></span>
                            </div>
                            <a href="project-details.php?id=<?php echo $project["id"]; ?>" class="btn btn-primary btn-sm btn-full">
                                View Full Details <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: var(--border); margin-bottom: 1rem;"></i>
                    <p style="color: var(--text-muted);">No projects currently assigned to your account.</p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
<?php 
mysqli_stmt_close($stmt_projects);
mysqli_close($conn); 
?>