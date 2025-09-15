<?php
// Cấu hình kết nối đến cơ sở dữ liệu
$host = 'localhost'; // hoặc địa chỉ host của bạn
$dbname = 'thinhvie_quanly'; // tên database của bạn
$username = 'thinhvie_qldky'; // username của bạn
$password = 'ThinhvienDaminh@1'; // password của bạn
$charset = 'utf8mb4';
$port = 3306; // Port mặc định của MySQL

// Biến lưu trữ kết nối mysqli
$mysqli = null;

// Hàm kết nối đến database
function connectDB() {
    global $host, $username, $password, $dbname, $port, $charset, $mysqli;
    
    // Nếu kết nối đã tồn tại, trả về kết nối đó
    if ($mysqli !== null) {
        return $mysqli;
    }
    
    try {
        // Tạo kết nối mysqli
        $mysqli = new mysqli($host, $username, $password, $dbname, $port);
        
        // Kiểm tra kết nối
        if ($mysqli->connect_error) {
            throw new Exception('Lỗi kết nối cơ sở dữ liệu: ' . $mysqli->connect_error);
        }
        
        // Thiết lập charset
        $mysqli->set_charset($charset);
        error_log(date('Y-m-d H:i:s') . " - Kết nối thành công!\n", 3, "db_errors.log");
        return $mysqli;
    } catch (Exception $e) {
        // Xử lý lỗi
        $error_message = $e->getMessage();
        
        // Tạo file log để ghi lại lỗi
        error_log(date('Y-m-d H:i:s') . " - " . $error_message . "\n", 3, "db_errors.log");
        
        // Hiển thị trang lỗi
        include '../user/backend/error.php';
        exit;
    }
}

// Hàm đóng kết nối
function closeDB() {
    global $mysqli;
    
    if ($mysqli !== null) {
        $mysqli->close();
        $mysqli = null;
    }
}
?>