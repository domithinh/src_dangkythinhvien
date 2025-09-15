<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../../PHPMailer/src/Exception.php';
require_once '../../PHPMailer/src/PHPMailer.php';
require_once '../../PHPMailer/src/SMTP.php';

function sendAdminNotificationEmail($fullname, $email, $phone) {
    $mysqli = connectDB();
    
    try {
        $mail = new PHPMailer(true);
        // Cấu hình SMTP an toàn hơn
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'truyenthong.thinhviendaminh@gmail.com'; 
        $mail->Password = 'usgjiiurqrtqubub';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; 
        
        // Thêm headers chống spam
        $mail->addCustomHeader('Precedence', 'bulk');
        $mail->addCustomHeader('List-Unsubscribe', '<mailto:truyenthong.thinhviendaminh@gmail.com>');
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->setFrom('truyenthong.thinhviendaminh@gmail.com', 'Thỉnh Viện Đa Minh');
        $mail->addAddress('thinhviendaminh@gmail.com', 'Quản Trị Viên');
        $mail->isHTML(true);
        $mail->Subject = 'THÔNG BÁO ĐĂNG KÝ TUYỂN SINH MỚI';


        
        
        // Prepare email body with candidate details
        $mail->Body = "
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: 0 auto; }
                .container { padding: 20px; background-color: #f4f4f4; }
                .content { background-color: white; padding: 20px; border-radius: 5px; }
                .btn { 
                    display: inline-block;
                    padding: 10px 20px;
                    border-radius: 50px;
                    background-color: #000000 !important;
                    color: #ffffff !important;
                    text-align: center;
                    text-decoration: none;
                    font-size: 16px;
                    transition: background-color 0.3s ease, color 0.3s ease;
                }
                .btn:hover {
                    background-color: #ff4500;
                    color: white;
                }
                .support { 
                    margin-top: 20px; 
                    font-size: 0.9em; 
                    color: #666; 
                    border-top: 1px solid #eee; 
                    padding-top: 15px; 
                }
                .support a { color: #007bff; text-decoration: none; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='content'>
                    <h2>Thông báo đăng ký tuyển sinh mới</h2>
                    
                    <p>Một bản đăng ký tuyển sinh mới đã được ghi nhận. Vui lòng đăng nhập trang quản trị để kiểm tra chi tiết. Dưới đây là một số thông tin cơ bản:</p>
                    
                    <p><strong>Họ và tên:</strong> $fullname </p>
                    <p><strong>Số điện thoại:</strong> $phone</p>
                    <p><strong>Email:</strong> $email </p>
                    
                    <a href='https://quanly.thinhviendaminh.net/admin' class='btn'>Đăng nhập trang quản trị</a>
                    
                    <div class='support'>
                        <p><strong>Hỗ trợ kỹ thuật:</strong><br>
                        Ban Truyền thông Thỉnh viện Đa Minh<br>
                        Website: <a href='https://thinhviendaminh.net'>thinhviendaminh.net</a><br>
                        Email: <a href='mailto:truyenthong.thinhviendaminh@gmail.com'>truyenthong.thinhviendaminh@gmail.com</a><br>
                        Facebook: <a href='https://www.facebook.com/thinhviendaminhvn'>https://www.facebook.com/thinhviendaminhvn</a>
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>";
        
        $mail->send();
        closeDB();
        
        return true;
    } catch (Exception $e) {
        error_log("Lỗi gửi email thông báo admin: " . $mail->ErrorInfo, 3, "admin_email_errors.log");
        return false;
    }
}
?>