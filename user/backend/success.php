<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký thành công - Thỉnh viện Đa Minh</title>
    <link rel="stylesheet" href="../css/success.css">
</head>
<body>
    <div class="success-container">
        <h1 class="success-title">Đăng ký thành công!</h1>
        
        <div class="success-message">
            <p>Cảm ơn bạn đã đăng ký thi tuyển sinh ơn gọi Đa Minh.</p>
            <p>Hồ sơ của bạn đã được ghi nhận và đang chờ xử lý.</p>
        </div>
        
        <?php if (isset($_GET['id']) && is_numeric($_GET['id'])): ?>
            <p>Mã hồ sơ của bạn là:</p>
            <p class="reference-number">DM-<?php echo htmlspecialchars(str_pad($_GET['id'], 5, '0', STR_PAD_LEFT)); ?></p>
            <p>Vui lòng lưu lại mã hồ sơ này để theo dõi quá trình xét tuyển.</p>
        <?php endif; ?>
        
        <p>Chúng tôi sẽ liên hệ với bạn qua email hoặc điện thoại đã đăng ký để thông báo lịch thi và các thông tin cần thiết khác.</p>
        
        <a href="https://thinhviendaminh.net/" class="home-button">Về trang chủ</a>
    </div>
</body>
</html>