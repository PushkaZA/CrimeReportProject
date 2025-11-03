<?php
session_start();
require_once __DIR__ . '/../config.php';

// Check authentication and role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_register.php");
    exit();
}

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: manage_reports.php");
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = "Invalid request.";
    header("Location: manage_reports.php");
    exit();
}

// Validate required fields
$report_id = filter_input(INPUT_POST, 'report_id', FILTER_SANITIZE_NUMBER_INT);
$message = trim($_POST['message'] ?? ''); // Fixed: Don't use deprecated FILTER_SANITIZE_STRING

if (!$report_id || empty($message)) {
    $_SESSION['error'] = "Missing required fields.";
    header("Location: view_report.php?id=" . $report_id);
    exit();
}

try {
    // Verify report exists
    $stmt = $pdo->prepare("SELECT id FROM reports WHERE id = ?");
    $stmt->execute([$report_id]);
    
    if (!$stmt->fetch()) {
        $_SESSION['error'] = "Report not found.";
        header("Location: manage_reports.php");
        exit();
    }

    // Insert the note
    $stmt = $pdo->prepare("
        INSERT INTO messages (report_id, user_id, message_text, is_from_reporter, created_at)
        VALUES (?, ?, ?, 0, NOW())
    ");
    $stmt->execute([$report_id, $_SESSION['user_id'], $message]);

    $_SESSION['success'] = "Note added successfully.";
    
} catch (PDOException $e) {
    error_log('Error adding note: ' . $e->getMessage());
    $_SESSION['error'] = "Failed to add note: " . $e->getMessage();
}

// Redirect back to the report view
header("Location: view_report.php?id=" . $report_id);
exit();