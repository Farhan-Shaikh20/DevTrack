<?php
require "../../includes/auth.php";
require "../../config/database.php";

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $company_name = trim($_POST["company_name"]);
    $phone = trim($_POST["phone"]);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql_user = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt_user = mysqli_prepare($conn, $sql_user);
    $role = "client";
    mysqli_stmt_bind_param($stmt_user, "ssss", $name, $email, $hashed_password, $role);

    if (mysqli_stmt_execute($stmt_user)) {
        $user_id = mysqli_insert_id($conn);
        $sql_client = "INSERT INTO client (user_id, company_name, phone) VALUES (?, ?, ?)";
        $stmt_client = mysqli_prepare($conn, $sql_client);
        mysqli_stmt_bind_param($stmt_client, "iss", $user_id, $company_name, $phone);

        if (mysqli_stmt_execute($stmt_client)) {
            $message = "Client added successfully!";
        } else {
            $error = "Error adding client info: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_client);
    } else {
        $error = "Error adding user. Email may already exist.";
    }
    mysqli_stmt_close($stmt_user);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - Add Client</title>
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
            <h2 style="margin-bottom: 1.5rem;"><i class="fa-solid fa-user-plus" style="color:var(--primary);"></i> Add New Client</h2>

            <?php if ($message) { echo "<div class='alert alert-success'>$message</div>"; } ?>
            <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

            <form method="POST">
                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="John Doe">
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required placeholder="john@example.com">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Set default password">
                </div>

                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="company_name" class="form-control" required placeholder="Acme Corp">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="+1 234 567 890">
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary btn-full"><i class="fa-solid fa-check"></i> Save Client</button>
                    <a href="index.php" class="btn btn-secondary btn-full">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>