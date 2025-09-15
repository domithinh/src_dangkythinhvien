<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - Thỉnh viện Đa Minh</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="login-container">
        <h1 class="login-title">ĐĂNG NHẬP</h1>

        <?php if(isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="error-message">
            Đăng nhập không thành công. Vui lòng kiểm tra lại thông tin đăng nhập.
        </div>
        <?php endif; ?>

        <form class="login-form" action="./control/process_login.php" method="post">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="login-button">Đăng nhập</button>

            <!-- <a href="forgot-password.php" class="forgot-password">Quên mật khẩu?</a> -->
        </form>
    </div>
</body>

</html>