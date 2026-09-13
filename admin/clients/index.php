<?php
require "../../includes/auth.php";
require "../../config/database.php";

$sql = "SELECT client.id, users.name, users.email, client.company_name, client.phone
        FROM client
        INNER JOIN users ON client.user_id = users.id
        ORDER BY client.id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - Manage Clients</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand">
            <i class="fa-solid fa-cubes"></i> DevTrack <span>Admin</span>
        </div>
        <div class="nav-user">
            <a href="../dashboard.php" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>
            <a href="../../logout.php" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Manage Clients</h1>
                <p class="page-subtitle">View, create, edit or delete system client accounts</p>
            </div>
            <a href="add.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New Client</a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0) { ?>
                        <?php while ($client = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><strong>#<?php echo $client["id"]; ?></strong></td>
                                <td><?php echo htmlspecialchars($client["name"]); ?></td>
                                <td><?php echo htmlspecialchars($client["email"]); ?></td>
                                <td><span class="badge badge-planning"><?php echo htmlspecialchars($client["company_name"]); ?></span></td>
                                <td><?php echo htmlspecialchars($client["phone"]); ?></td>
                                <td style="text-align: right;">
                                    <a href="edit.php?id=<?php echo $client['id']; ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-pen"></i> Edit</a>
                                    <a href="delete.php?id=<?php echo $client['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this client?');"><i class="fa-solid fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">No client records found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>