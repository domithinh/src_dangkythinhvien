<?php
// Khởi động session
session_start();

// Xóa tất cả biến session
$_SESSION = array();

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: ../index.php");
exit();
?>