<?php
require "../../includes/auth.php";
require "../../config/database.php";

if (!isset($_GET["id"])) {
    die("Client ID is missing.");
}
$client_id = $_GET["id"];

$message = "";
$error = "";

/* Get existing client data */
$sql = "SELECT client.id, client.user_id, users.name, users.email, client.company_name, client.phone
        FROM client
        INNER JOIN users ON client.user_id = users.id
        WHERE client.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $client_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) != 1) {
    die("Client not found.");
}
$client = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

/* Update client */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $company_name = trim($_POST["company_name"]);
    $phone = trim($_POST["phone"]);

    $sql_user = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt_user = mysqli_prepare($conn, $sql_user);
    mysqli_stmt_bind_param($stmt_user, "ssi", $name, $email, $client["user_id"]);
    mysqli_stmt_execute($stmt_user);
    mysqli_stmt_close($stmt_user);

    $sql_client = "UPDATE client SET company_name = ?, phone = ? WHERE id = ?";
    $stmt_client = mysqli_prepare($conn, $sql_client);
    mysqli_stmt_bind_param($stmt_client, "ssi", $company_name, $phone, $client_id);

    if (mysqli_stmt_execute($stmt_client)) {
        $message = "Client updated successfully!";
        // refresh data
        $client['name'] = $name;
        $client['email'] = $email;
        $client['company_name'] = $company_name;
        $client['phone'] = $phone;
    } else {
        $error = "Error updating client.";
    }
    mysqli_stmt_close($stmt_client);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - Edit Client</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fa-solid fa-cubes"></i> DevTrack <span>Admin</span></div>
        <div class="nav-user">
            <a href="index.php" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Back to Clients</a>
        </div>
    </nav>

    <div class="container" style="max-width: 600px;">
        <div class="card">
            <h2 style="margin-bottom: 1.5rem;"><i class="fa-solid fa-user-pen" style="color:var(--primary);"></i> Edit Client Details</h2>

            <?php if ($message) { echo "<div class='alert alert-success'>$message</div>"; } ?>
            <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

            <form method="POST">
                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($client['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($client['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="company_name" class="form-control" value="<?php echo htmlspecialchars($client['company_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($client['phone']); ?>">
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary btn-full"><i class="fa-solid fa-floppy-disk"></i> Update Client</button>
                    <a href="index.php" class="btn btn-secondary btn-full">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>