<?php
// Khởi động session
session_start();

require_once '../../include/global.php';

// Kiểm tra xem có ID được truyền vào không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Không tìm thấy ID ứng viên.";
    header("Location: display_registrations.php");
    exit;
}

$candidate_id = intval($_GET['id']);

// Kết nối CSDL
$conn = connectDB();

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

try {
    // Chuẩn bị câu truy vấn xóa
    $query = "DELETE FROM candidates WHERE candidate_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }
    
    // Bind tham số
    $stmt->bind_param("i", $candidate_id);
    
    // Thực thi truy vấn
    if ($stmt->execute()) {
        $_SESSION['success'] = "Đã xóa thông tin ứng viên thành công.";
    } else {
        throw new Exception("Lỗi khi xóa: " . $stmt->error);
    }
    
    // Đóng statement
    $stmt->close();
    
} catch (Exception $e) {
    $_SESSION['error'] = "Lỗi: " . $e->getMessage();
}

// Đóng kết nối
$conn->close();

// Chuyển hướng về trang danh sách
header("Location: dashboard_registrators.php");
exit;
?>