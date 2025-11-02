<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_register.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: user_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Reporting Website - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Crime Reporting Website - Admin Dashboard</h1>
        <div class="welcome-message">
            <p>Welcome, Admin: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
        <!-- Add your admin dashboard content here -->
    </div>
</body>
</html>