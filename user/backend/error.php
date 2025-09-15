<?php
// Kiểm tra nếu biến $error_message tồn tại
// Đoạn mã PHP trong file này rất đơn giản, chỉ hiển thị thông báo lỗi nếu có
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lỗi đăng ký - Thỉnh viện Đa Minh</title>
    <link rel="stylesheet" href="../css/error.css">
</head>
<body>
    <div class="error-container">
        <h1 class="error-title">Lỗi khi đăng ký</h1>
        
        <div class="error-message">
            <p>Rất tiếc, đã xảy ra lỗi khi xử lý đăng ký của bạn.</p>
            <?php if (isset($error_message)): ?>
                <p><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
        </div>
        
        <p>Vui lòng thử lại sau hoặc liên hệ với chúng tôi để được hỗ trợ.</p>
        
        <a href="../../index.php" class="home-button">Quay lại form đăng ký</a>
    </div>
</body>
</html>