<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Anonymous Report - Crime Report System</title>
</head>
<body class="auth-page">
    <div class="container">
        <div class="form-box active">
            <form action="submit_anonymous_report.php" method="post">
                <h2>🔒 Anonymous Crime Report</h2>
                <p style="color: #666; margin-bottom: 20px;">Your identity will remain completely confidential.</p>
                
                <?php 
                if(isset($_SESSION['report_success'])) {
                    echo "<p class='success-message'>" . $_SESSION['report_success'] . "</p>";
                    unset($_SESSION['report_success']);
                }
                if(isset($_SESSION['report_error'])) {
                    echo "<p class='error-message'>" . $_SESSION['report_error'] . "</p>";
                    unset($_SESSION['report_error']);
                }
                ?>

                <select name="crime_type" required>
                    <option value="">--Select Crime Type--</option>
                    <option value="theft">Theft</option>
                    <option value="assault">Assault</option>
                    <option value="burglary">Burglary</option>
                    <option value="vandalism">Vandalism</option>
                    <option value="fraud">Fraud</option>
                    <option value="drug_related">Drug Related</option>
                    <option value="other">Other</option>
                </select>

                <input type="text" name="location" placeholder="Location of incident" required>
                
                <input type="date" name="incident_date" placeholder="Date of incident" required>
                
                <textarea name="description" rows="6" placeholder="Describe the incident in detail..." required style="width: 100%; padding: 15px; border: none; background: #eee; border-radius: 6px; font-family: 'Poppins', serif; font-size: 16px; margin-bottom: 20px; resize: vertical;"></textarea>

                <button type="submit" name="submit_anonymous">Submit Anonymous Report</button>
                <p><a href="login_register.php">← Back to Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>