<?php
require "../../includes/auth.php";
require "../../config/database.php";

$sql = "SELECT projects.id, projects.project_name, projects.description, projects.start_date, projects.end_date, projects.status, users.name, client.company_name
        FROM projects
        INNER JOIN client ON projects.client_id = client.id
        INNER JOIN users ON client.user_id = users.id
        ORDER BY projects.id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - Manage Projects</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fa-solid fa-cubes"></i> DevTrack <span>Admin</span></div>
        <div class="nav-user">
            <a href="../dashboard.php" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>
            <a href="../../logout.php" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Manage Projects</h1>
                <p class="page-subtitle">Track project progress, timeline dates, and assigned clients</p>
            </div>
            <a href="add.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New Project</a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Project Name</th>
                        <th>Client</th>
                        <th>Company</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0) { ?>
                        <?php while ($project = mysqli_fetch_assoc($result)) { 
                            $status_class = 'badge-planning';
                            if ($project['status'] == 'In Progress') $status_class = 'badge-in-progress';
                            if ($project['status'] == 'Testing') $status_class = 'badge-testing';
                            if ($project['status'] == 'Completed') $status_class = 'badge-completed';
                        ?>
                            <tr>
                                <td><strong>#<?php echo $project["id"]; ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($project["project_name"]); ?></strong></td>
                                <td><?php echo htmlspecialchars($project["name"]); ?></td>
                                <td><?php echo htmlspecialchars($project["company_name"]); ?></td>
                                <td><?php echo $project["start_date"] ? $project["start_date"] : '-'; ?></td>
                                <td><?php echo $project["end_date"] ? $project["end_date"] : '-'; ?></td>
                                <td><span class="badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($project["status"]); ?></span></td>
                                <td style="text-align: right;">
                                    <a href="edit.php?id=<?php echo $project['id']; ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-pen"></i> Edit</a>
                                    <a href="delete.php?id=<?php echo $project['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this project?');"><i class="fa-solid fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 2rem; color: var(--text-muted);">No projects found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>