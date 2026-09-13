<?php
require "../includes/client_auth.php";
require "../config/database.php";

$user_id = $_SESSION["user_id"];

if (!isset($_GET["id"])) {
    die("Project ID is missing.");
}
$project_id = $_GET["id"];

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

/* Get project */
$sql_project = "SELECT id, project_name, description, start_date, end_date, status
                FROM projects
                WHERE id = ? AND client_id = ?";
$stmt_project = mysqli_prepare($conn, $sql_project);
mysqli_stmt_bind_param($stmt_project, "ii", $project_id, $client_id);
mysqli_stmt_execute($stmt_project);
$result_project = mysqli_stmt_get_result($stmt_project);

if (mysqli_num_rows($result_project) != 1) {
    die("Project not found or access denied.");
}
$project = mysqli_fetch_assoc($result_project);
mysqli_stmt_close($stmt_project);

$status_class = 'badge-planning';
if ($project['status'] == 'In Progress') $status_class = 'badge-in-progress';
if ($project['status'] == 'Testing') $status_class = 'badge-testing';
if ($project['status'] == 'Completed') $status_class = 'badge-completed';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - <?php echo htmlspecialchars($project["project_name"]); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fa-solid fa-cubes"></i> DevTrack <span>Client Portal</span></div>
        <div class="nav-user">
            <a href="projects.php" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> My Projects</a>
        </div>
    </nav>

    <div class="container" style="max-width: 800px;">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <h2><i class="fa-solid fa-diagram-project" style="color:var(--primary);"></i> <?php echo htmlspecialchars($project["project_name"]); ?></h2>
                <span class="badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($project["status"]); ?></span>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <h4 style="color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem;">Project Description</h4>
                <p style="background: var(--bg-main); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                    <?php echo nl2br(htmlspecialchars($project["description"] ? $project["description"] : "No description provided for this project.")); ?>
                </p>
            </div>

            <div class="grid grid-cols-2" style="margin-bottom: 1.5rem;">
                <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
                    <div style="font-size: 0.8rem; color: var(--text-muted);"><i class="fa-regular fa-calendar-check"></i> Start Date</div>
                    <div style="font-weight: 600; font-size: 1.1rem; margin-top: 0.25rem;"><?php echo $project["start_date"] ? $project["start_date"] : 'Not set'; ?></div>
                </div>

                <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
                    <div style="font-size: 0.8rem; color: var(--text-muted);"><i class="fa-regular fa-calendar-xmark"></i> Estimated Completion</div>
                    <div style="font-weight: 600; font-size: 1.1rem; margin-top: 0.25rem;"><?php echo $project["end_date"] ? $project["end_date"] : 'Not set'; ?></div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <a href="projects.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back to Projects</a>
                <a href="dashboard.php" class="btn btn-primary"><i class="fa-solid fa-house"></i> Client Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>