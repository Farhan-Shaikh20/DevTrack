<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack - Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <h1><i class="fa-solid => fa-code-branch" style="color:var(--primary); margin-right:8px;"></i>DevTrack</h1>
                <p>Sign in to manage your projects & client dashboard</p>
            </div>
            
            <form method="post" action="login.php">
                <div class="form-group">
                    <label><i class="fa-regular fa-envelope"></i> Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@devtrack.com" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fa-solid fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-full" style="margin-top: 1rem;">
                    Sign In <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
