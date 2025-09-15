<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include global configuration
require_once '../../include/global.php';
require_once './send_confirmation_email.php';
require_once './send_admin_notification_email.php';

// Google Verification Recaptcha v2
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secretKey = "6Ld0agQrAAAAANgot3mH1PwUX1gMCKCt8oauq3wG"; // reCAPTCHA v2 secret key
    $responseKey = $_POST['g-recaptcha-response'];
    
    // Verify reCAPTCHA v2
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        "secret" => $secretKey,
        "response" => $responseKey,
        "remoteip" => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/x-www-form-urlencoded\r\n",
            "method"  => "POST",
            "content" => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captchaSuccess = json_decode($verify);

    // Check reCAPTCHA
    if ($captchaSuccess->success) {
        try {
            // Tạo kết nối mysqli
            $mysqli = connectDB();
            
            // Lấy và làm sạch dữ liệu từ form
            $fullname = $mysqli->real_escape_string($_POST['fullname'] ?? '');
            
            $birth_day = (int)($_POST['day'] ?? 0);
            $birth_month = (int)($_POST['month'] ?? 0);
            $birth_year = (int)($_POST['year'] ?? 0);
            $birthplace = $mysqli->real_escape_string($_POST['birthplace'] ?? '');
            $parish = $mysqli->real_escape_string($_POST['parish'] ?? '');
            $diocese = $mysqli->real_escape_string($_POST['diocese'] ?? '');
            $education_level = $mysqli->real_escape_string($_POST['education'] ?? '');
            $graduation_year = !empty($_POST['graduationYear']) ? (int)$_POST['graduationYear'] : 0;
            $major = $mysqli->real_escape_string($_POST['major'] ?? '');
            
            // Xử lý chứng chỉ
            $certificates = isset($_POST['certificate']) ? $_POST['certificate'] : [];
            $ielts_certificate = in_array('ielts', $certificates) ? 1 : 0;
            $toefl_certificate = in_array('toefl', $certificates) ? 1 : 0;
            $toeic_certificate = in_array('toeic', $certificates) ? 1 : 0;
            $other_certificate = in_array('other', $certificates) ? 1 : 0;
            
            // Lấy scores
            $ielts_score = $mysqli->real_escape_string($_POST['ielts_score'] ?? '');
            $toefl_score = $mysqli->real_escape_string($_POST['toefl_score'] ?? '');
            $toeic_score = $mysqli->real_escape_string($_POST['toeic_score'] ?? '');
            
            // Địa chỉ và thông tin liên hệ
            $permanent_address = $mysqli->real_escape_string($_POST['permanent_address'] ?? '');
            $contact_address = $mysqli->real_escape_string($_POST['contact_address'] ?? '');
            $email = $mysqli->real_escape_string($_POST['email'] ?? '');
            $phone = $mysqli->real_escape_string($_POST['phone'] ?? '');
            
            // Thông tin ơn gọi trước đây
            $previous_vocation = $mysqli->real_escape_string($_POST['previous_vocation'] ?? '');
            $previous_vocation_time = $mysqli->real_escape_string($_POST['previous_vocation_time'] ?? '');
            
            // Người giới thiệu
            $referrer = $mysqli->real_escape_string($_POST['referrer'] ?? '');
            $is_self_discovery = isset($_POST['referral']) && $_POST['referral'] === 'self' ? 1 : 0;
            
            // Thông tin dự thi
            $exam_location = $mysqli->real_escape_string($_POST['exam_location'] ?? '');
            $language_choice = $mysqli->real_escape_string($_POST['language'] ?? '');
            $exam_date_choice = $mysqli->real_escape_string($_POST['exam_date'] ?? '');
            
            // Nguyện vọng
            $aspiration = $mysqli->real_escape_string($_POST['aspiration'] ?? '');
            
            // Thông tin gia đình
            $father_name = $mysqli->real_escape_string($_POST['father_name'] ?? '');
            $father_birth_year = !empty($_POST['father_birth_year']) ? (int)$_POST['father_birth_year'] : 0;
            $father_occupation = $mysqli->real_escape_string($_POST['father_occupation'] ?? '');
            $mother_name = $mysqli->real_escape_string($_POST['mother_name'] ?? '');
            $mother_birth_year = !empty($_POST['mother_birth_year']) ? (int)$_POST['mother_birth_year'] : 0;
            $mother_occupation = $mysqli->real_escape_string($_POST['mother_occupation'] ?? '');
            $family_parish = $mysqli->real_escape_string($_POST['family_parish'] ?? '');
            $family_diocese = $mysqli->real_escape_string($_POST['family_diocese'] ?? '');
            $parish_priest = $mysqli->real_escape_string($_POST['parish_priest'] ?? '');
            
            // Chuẩn bị câu truy vấn SQL
            $sql = "INSERT INTO candidates (
                        fullname, birth_day, birth_month, birth_year, birthplace, parish, diocese, 
                        education_level, graduation_year, major, 
                        ielts_certificate, ielts_score, toefl_certificate, toefl_score, 
                        toeic_certificate, toeic_score, other_certificate, 
                        permanent_address, contact_address, email, phone, 
                        previous_vocation, previous_vocation_time, referrer, is_self_discovery, 
                        exam_location, language_choice, aspiration,
                        father_name, father_birth_year, father_occupation, 
                        mother_name, mother_birth_year, mother_occupation, 
                        family_parish, family_diocese, parish_priest,
                        exam_date
                    ) VALUES (
                        '$fullname', $birth_day, $birth_month, $birth_year, '$birthplace', '$parish', '$diocese',
                        '$education_level', $graduation_year, '$major',
                        $ielts_certificate, '$ielts_score', $toefl_certificate, '$toefl_score',
                        $toeic_certificate, '$toeic_score', $other_certificate,
                        '$permanent_address', '$contact_address', '$email', '$phone',
                        '$previous_vocation', '$previous_vocation_time', '$referrer', $is_self_discovery,
                        '$exam_location', '$language_choice', '$aspiration',
                        '$father_name', $father_birth_year, '$father_occupation',
                        '$mother_name', $mother_birth_year, '$mother_occupation',
                        '$family_parish', '$family_diocese', '$parish_priest',
                        '$exam_date_choice'
                    )";
            
            // Thực thi câu lệnh
            if (!$mysqli->query($sql)) {
                throw new Exception("Lỗi thực thi câu lệnh: " . $mysqli->error);
            }
            
            // Lấy ID của record mới thêm vào
            $candidate_id = $mysqli->insert_id;
            
            // Gọi hàm gửi email xác nhận
            sendConfirmationEmail($email, $fullname);
            
            //Gửi mail thông báo người đăng ký mới cho admin
            sendAdminNotificationEmail($fullname, $email, $phone);
            
            // Đóng kết nối
            closeDB();
            
            // Chuyển hướng đến trang thành công với thông báo
            header('Location: success.php?id=' . $candidate_id);
            exit;
        } catch (Exception $e) {
            // Xử lý lỗi
            $error_message = 'Lỗi xử lý form: ' . $e->getMessage();
            
            // Tạo file log để ghi lại lỗi
            error_log(date('Y-m-d H:i:s') . " - " . $error_message . "\n", 3, "db_errors.log");
            
            // Chuyển hướng đến trang lỗi với thông báo lỗi
            header('Location: error.php?message=' . urlencode($error_message));
            exit;
        }
    } else {
        // Ghi log lỗi
        error_log("reCAPTCHA verification failed: " . json_encode($captchaSuccess));
        
        // Chuyển hướng đến trang lỗi
        header('Location: error.php?message=' . urlencode("Đăng ký thất bại. Vui lòng thử lại."));
        exit;
    }
}
?>