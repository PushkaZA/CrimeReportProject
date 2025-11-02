<?php
session_start();
require_once __DIR__ . '/../config.php';

if (isset($_POST['submit_anonymous'])) {
    $crimeType = $_POST['crime_type'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $incidentDate = $_POST['incident_date'] ?? '';
    $description = trim($_POST['description'] ?? '');

    // Validation
    if (empty($crimeType) || empty($location) || empty($incidentDate) || empty($description)) {
        $_SESSION['report_error'] = 'All fields are required.';
        header('Location: anonymous_report.php');
        exit;
    }

    try {
        // Insert anonymous report (user_id will be NULL)
        $stmt = $pdo->prepare(
            "INSERT INTO crime_reports (user_id, crime_type, location, incident_date, description, status, is_anonymous) 
             VALUES (NULL, ?, ?, ?, ?, 'pending', 1)"
        );
        $stmt->execute([$crimeType, $location, $incidentDate, $description]);

        $_SESSION['report_success'] = 'Your anonymous report has been submitted successfully. Thank you for helping keep the community safe.';
        header('Location: anonymous_report.php');
        exit;

    } catch (PDOException $e) {
        error_log('Anonymous report error: ' . $e->getMessage());
        $_SESSION['report_error'] = 'Failed to submit report. Please try again later.';
        header('Location: anonymous_report.php');
        exit;
    }
} else {
    header('Location: anonymous_report.php');
    exit;
}
?>