<?php
session_start();
require_once '../../include/global.php';
$conn = connectDB();
// Bật logging lỗi
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Chuẩn bị truy vấn
    $stmt = $conn->prepare("SELECT id FROM admin_account WHERE username = ? AND password = ?");
    if (!$stmt) {
        error_log("Prepare statement failed: " . $conn->error);
        die("Database error.");
    }
    
    $stmt->bind_param("ss", $username, $password);
    if (!$stmt->execute()) {
        error_log("Execute statement failed: " . $stmt->error);
        die("Database error.");
    }
    
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id);
        $stmt->fetch();
    
        // Đăng nhập thành công
        $_SESSION['id'] = $id;
        header("Location: dashboard_registrators.php");
        exit();
    } else {
        error_log("Invalid login attempt for username: $username");
        echo "Invalid username or password.";
    }
    
    $stmt->close();
    
}

$conn->close();
?>