<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../../PHPMailer/src/Exception.php';
require_once '../../PHPMailer/src/PHPMailer.php';
require_once '../../PHPMailer/src/SMTP.php';

function sendConfirmationEmail($email, $fullname) {
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
        $mail->setFrom('truyenthong.thinhviendaminh@gmail.com', 'Thỉnh Viện Đa Minh Việt Nam');
        $mail->addAddress($email, $fullname);
        
        $mail->isHTML(true);
        $mail->Subject = 'ĐĂNG KÝ THÀNH CÔNG';
        
        // Nội dung email được cập nhật theo yêu cầu
        $mail->Body = "
        <html>
        <head>
            <meta charset='UTF-8'>
        </head>
        <body style='font-family: Arial, sans-serif; max-width: 600px; margin: auto;'>
            <h2 style='color: #050038;'>ĐĂNG KÝ THÀNH CÔNG</h2>
            <p>Kính chào <strong>$fullname</strong>,</p>
            <p>Thỉnh viện Đa Minh Việt Nam đã ghi nhận bản đăng ký thi tuyển của bạn. Ban Giám đốc sẽ liên lạc và trao đổi cụ thể với bạn về việc thi tuyển sắp tới. Theo dõi Thỉnh viện Đa Minh trên các nền tảng để cập nhật thông tin thêm.<br> Giải đáp các thắc mắc tại: <a href='https://thinhviendaminh.net/faq/'>https://thinhviendaminh.net/faq/</a>
                <br> Tìm hiểu thêm về Thỉnh viện Đa Minh: <a href='https://thinhviendaminh.net/gioi-thieu-thinh-vien-da-minh-viet-nam/'>https://thinhviendaminh.net/gioi-thieu-thinh-vien-da-minh-viet-nam/</a>
            </p>
            <p>Xin cảm ơn,<br>Ban Truyền Thông Thỉnh viện Đa Minh Việt Nam</p>
            
            <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
            
            <h3>Theo dõi Thỉnh viện:</h3>
            <p><strong>Thỉnh viện Đa Minh Việt Nam</strong></p>
            <p>Website: <a href='https://thinhviendaminh.net'>thinhviendaminh.net</a></p>
            <p>Email: <a href='mailto:truyenthong.thinhviendaminh@gmail.com'>truyenthong.thinhviendaminh@gmail.com</a></p>
            <p>Facebook: <a href='https://www.facebook.com/thinhviendaminhvn'>https://www.facebook.com/thinhviendaminhvn</a></p>
            <p>Địa chỉ: 70/1 Tổ 1, Kp Bình Đường 3, P. An Bình, Tp. Dĩ An, Bình Dương (<a href='https://maps.app.goo.gl/9vZD44U9tmZoFjPX8'>Xem bản đồ</a>)</p>
        </body>
        </html>";
        
        $mail->send();
        closeDB();
        
        return true;
    } catch (Exception $e) {
        error_log("Lỗi gửi email: " . $mail->ErrorInfo, 3, "email_errors.log");
        return false;
    }
}
?>