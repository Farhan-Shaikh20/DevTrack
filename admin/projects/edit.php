<?php
require "../../includes/auth.php";
require "../../config/database.php";

if (!isset($_GET["id"])) {
    die("Project ID is missing.");
}
$project_id = $_GET["id"];

$message = "";
$error = "";

$sql = "SELECT id, client_id, project_name, description, start_date, end_date, status FROM projects WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $project_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) != 1) {
    die("Project not found.");
}
$project = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$sql_clients = "SELECT client.id, users.name, client.company_name
                FROM client
                INNER JOIN users ON client.user_id = users.id
                ORDER BY users.name ASC";
$result_clients = mysqli_query($conn, $sql_clients);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST["client_id"];
    $project_name = trim($_POST["project_name"]);
    $description = trim($_POST["description"]);
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $status = $_POST["status"];

    $sql_update = "UPDATE projects SET client_id = ?, project_name = ?, description = ?, start_date = ?, end_date = ?, status = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "isssssi", $client_id, $project_name, $description, $start_date, $end_date, $status, $project_id);

    if (mysqli_stmt_execute($stmt_update)) {
        $message = "Project updated successfully!";
        $project['client_id'] = $client_id;
        $project['project_name'] = $project_name;
        $project['description'] = $description;
        $project['start_date'] = $start_date;
        $project['end_date'] = $end_date;
        $project['status'] = $status;
    } else {
        $error = "Error updating project.";
    }
    mysqli_stmt_close($stmt_update);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - Edit Project</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fa-solid fa-cubes"></i> DevTrack <span>Admin</span></div>
        <div class="nav-user">
            <a href="index.php" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Back to Projects</a>
        </div>
    </nav>

    <div class="container" style="max-width: 650px;">
        <div class="card">
            <h2 style="margin-bottom: 1.5rem;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary);"></i> Edit Project Details</h2>

            <?php if ($message) { echo "<div class='alert alert-success'>$message</div>"; } ?>
            <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

            <form method="POST">
                <div class="form-group">
                    <label>Client</label>
                    <select name="client_id" class="form-control" required>
                        <?php while ($client = mysqli_fetch_assoc($result_clients)) { ?>
                            <option value="<?php echo $client["id"]; ?>" <?php if ($client["id"] == $project["client_id"]) echo "selected"; ?>>
                                <?php echo htmlspecialchars($client["name"]) . " (" . htmlspecialchars($client["company_name"]) . ")"; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Project Name</label>
                    <input type="text" name="project_name" class="form-control" value="<?php echo htmlspecialchars($project["project_name"]); ?>" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"><?php echo htmlspecialchars($project["description"]); ?></textarea>
                </div>

                <div class="grid grid-cols-2">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="<?php echo $project["start_date"]; ?>">
                    </div>

                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" value="<?php echo $project["end_date"]; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Planning" <?php if ($project["status"] == "Planning") echo "selected"; ?>>Planning</option>
                        <option value="In Progress" <?php if ($project["status"] == "In Progress") echo "selected"; ?>>In Progress</option>
                        <option value="Testing" <?php if ($project["status"] == "Testing") echo "selected"; ?>>Testing</option>
                        <option value="Completed" <?php if ($project["status"] == "Completed") echo "selected"; ?>>Completed</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary btn-full"><i class="fa-solid fa-floppy-disk"></i> Update Project</button>
                    <a href="index.php" class="btn btn-secondary btn-full">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>