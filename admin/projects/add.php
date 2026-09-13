<?php
require "../../includes/auth.php";
require "../../config/database.php";

$message = "";
$error = "";

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

    $sql = "INSERT INTO projects (client_id, project_name, description, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssss", $client_id, $project_name, $description, $start_date, $end_date, $status);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Project added successfully!";
    } else {
        $error = "Error adding project.";
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - Add Project</title>
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
            <h2 style="margin-bottom: 1.5rem;"><i class="fa-solid fa-folder-plus" style="color:var(--primary);"></i> Create New Project</h2>

            <?php if ($message) { echo "<div class='alert alert-success'>$message</div>"; } ?>
            <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

            <form method="POST">
                <div class="form-group">
                    <label>Select Client</label>
                    <select name="client_id" class="form-control" required>
                        <option value="">-- Choose Client --</option>
                        <?php while ($client = mysqli_fetch_assoc($result_clients)) { ?>
                            <option value="<?php echo $client["id"]; ?>">
                                <?php echo htmlspecialchars($client["name"]) . " (" . htmlspecialchars($client["company_name"]) . ")"; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Project Name</label>
                    <input type="text" name="project_name" class="form-control" placeholder="E-commerce Redesign" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" placeholder="Enter detailed project scope and objectives..."></textarea>
                </div>

                <div class="grid grid-cols-2">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Planning">Planning</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Testing">Testing</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary btn-full"><i class="fa-solid fa-check"></i> Save Project</button>
                    <a href="index.php" class="btn btn-secondary btn-full">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>