<?php
    session_start();

    $errors = [
        'login' => $_SESSION['login_error'] ?? "",
        'register' => $_SESSION['register_error'] ?? ""
    ];
    $success = [
        'register' => $_SESSION['register_success'] ?? "",
        'login' => ""
    ];

    $activeForm = $_SESSION['active_form'] ?? 'login';

    unset($_SESSION['login_error']);
    unset($_SESSION['register_error']);
    unset($_SESSION['register_success']);
    unset($_SESSION['active_form']);

    function showError($error){
        return !empty($error) ? "<p class='error-message'>$error</p>" : "";
    }

    function showSuccess($success){
        return !empty($success) ? "<p class='success-message'>$success</p>" : "";
    }

    function isActiveForm($formName, $activeForm){
        return $formName === $activeForm ? 'active' : "";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login & Register - Crime Report System</title>
</head>
<body class="auth-page">
    <div class="container">
        <!-- Anonymous Reporting Banner -->
        <div class="anonymous-banner">
            <div class="anonymous-content">
                <h3>🔒 Report Anonymously</h3>
                <p>No account needed. Report crimes instantly without registration.</p>
                <a href="anonymous_report.php" class="anonymous-btn">Submit Anonymous Report</a>
            </div>
        </div>

        <!-- Login Form -->
        <div class="form-box <?php echo isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="login_register_backend.php" method="post">
                <h2>Login</h2>
                <?php echo showError($errors['login']); ?>
                <?php echo showSuccess($success['login']); ?>

                <input type="text" name="username" placeholder="Enter username" required>
                <input type="password" name="password" placeholder="Enter your password" required>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>

        <!-- Register Form -->
        <div class="form-box <?php echo isActiveForm('register', $activeForm); ?>" id="register-form">
            <form action="login_register_backend.php" method="post">
                <h2>Register</h2>
                <?php echo showError($errors['register']); ?>
                <?php echo showSuccess($success['register']); ?>

                <input type="text" name="username" placeholder="Choose a username" required>
                <input type="password" name="password" placeholder="Enter your password" required>
                <input type="password" name="confirm_password" placeholder="Confirm your password" required>
                <select name="role" required>
                    <option value="">--Select Role--</option>
                    <option value="admin">Admin</option>
                    <option value="officer">Officer</option> 
                </select>
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>

        <!-- Divider -->
        <div class="divider">
            <span>OR</span>
        </div>

        <!-- Why Register Section -->
        <div class="info-card">
            <h3>Why Register an Account?</h3>
            <ul class="benefits-list">
                <li>✓ Track your report status</li>
                <li>✓ Receive updates on investigations</li>
                <li>✓ Submit multiple reports</li>
                <li>✓ Access your report history</li>
                <li>✓ Communicate with officers securely</li>
            </ul>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>