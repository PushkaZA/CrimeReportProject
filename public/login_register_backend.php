<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/../config.php';

// Simple debug logger (writes to public/debug.log)
function dbg_log($msg) {
    $file = __DIR__ . '/debug.log';
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n";
    // suppress errors to avoid breaking page output; user can inspect file
    @file_put_contents($file, $line, FILE_APPEND);
}

if (isset($_POST['register'])) {
    $phonenumber = $_POST['phonenumber'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    dbg_log('Register POST received: phonenumber=' . $phonenumber . ' role=' . $role);

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        $_SESSION['active_form'] = 'register';
        header("Location: login_register.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT phonenumber FROM users WHERE phonenumber = ?");
    $stmt->bind_param("s", $phonenumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['register_error'] = "Phone number is already registered.";
        $_SESSION['active_form'] = 'register';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_stmt = $conn->prepare("INSERT INTO users (phonenumber, password, role) VALUES (?, ?, ?)");
        if ($insert_stmt === false) {
            $err = "Prepare failed: " . $conn->error;
            dbg_log('Insert prepare error: ' . $err);
            $_SESSION['register_error'] = $err;
            $_SESSION['active_form'] = 'register';
        } else {
            $insert_stmt->bind_param("sss", $phonenumber, $hashed_password, $role);
            if ($insert_stmt->execute()) {
                $_SESSION['register_success'] = "Registration Successful. You can log in.";
                $_SESSION['active_form'] = 'login';
                dbg_log('Insert succeeded for phonenumber=' . $phonenumber . ' role=' . $role);
            } else {
                $err = "Registration failed: " . $insert_stmt->error;
                dbg_log('Insert execute error: ' . $err);
                $_SESSION['register_error'] = $err;
                $_SESSION['active_form'] = 'register';
            }
            $insert_stmt->close();
        }
    }

    header("Location: login_register.php");
    exit();
}

if (isset($_POST['login'])) {
    $phonenumber = $_POST['phonenumber'];
    $password = $_POST['password'];

    dbg_log('Login POST received: phonenumber=' . $phonenumber);

    $stmt = $conn->prepare("SELECT * FROM users WHERE phonenumber = ?");
    $stmt->bind_param("s", $phonenumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['phonenumber'] = $user['phonenumber'];
            if ($user['role'] === 'admin') {
                header("Location: admin-site/admin_page.php");
            } else {
                header("Location: user-site/user_page.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = "Incorrect phone number or password.";
    $_SESSION['active_form'] = 'login';
    header("Location: login_register.php");
    exit();
}
?>