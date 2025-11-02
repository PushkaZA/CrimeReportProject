<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Reporting Website - User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Crime Reporting Website</h1>
        <div class="welcome-message">
            <p>Welcome, User: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
        <!-- Add your user dashboard content here -->
    </div>
</body>
</html>
