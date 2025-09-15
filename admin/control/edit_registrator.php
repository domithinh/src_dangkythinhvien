<?php
session_start();
require_once '../../include/global.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // If accessing directly without submitting form, redirect to view page
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = intval($_GET['id']);
        header("Location: view_registrator.php?id=$id");
    } else {
        header("Location: display_registrations.php");
    }
    exit();
}

// Get candidate ID from form or URL
$id = isset($_POST['candidate_id']) ? intval($_POST['candidate_id']) : 
     (isset($_GET['id']) ? intval($_GET['id']) : 0);

if ($id <= 0) {
    die("Lỗi: Không tìm thấy ID người đăng ký");
}

try {
    // Connect to database
    $mysqli = connectDB();
    
    // Collect form data with validation
    $fullname = $_POST['fullname'] ?? '';
    $birth_day = intval($_POST['day'] ?? 0);
    $birth_month = intval($_POST['month'] ?? 0);
    $birth_year = intval($_POST['year'] ?? 0);
    $birthplace = $_POST['birthplace'] ?? '';
    $parish = $_POST['parish'] ?? '';
    $diocese = $_POST['diocese'] ?? '';
    $education_level = $_POST['education'] ?? '';
    $graduation_year = !empty($_POST['graduationYear']) ? intval($_POST['graduationYear']) : null;
    $major = $_POST['major'] ?? '';
    $permanent_address = $_POST['permanent_address'] ?? '';
    $contact_address = $_POST['contact_address'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $previous_vocation = $_POST['previous_vocation'] ?? '';
    $previous_vocation_time = $_POST['previous_vocation_time'] ?? '';
    $exam_location = $_POST['exam_location'] ?? '';
    $language_choice = $_POST['language'] ?? '';
    $exam_date = $_POST['exam_date'] ?? '';
    $aspiration = $_POST['aspiration'] ?? '';
    $father_name = $_POST['father_name'] ?? '';
    $father_birth_year = !empty($_POST['father_birth_year']) ? intval($_POST['father_birth_year']) : null;
    $father_occupation = $_POST['father_occupation'] ?? '';
    $mother_name = $_POST['mother_name'] ?? '';
    $mother_birth_year = !empty($_POST['mother_birth_year']) ? intval($_POST['mother_birth_year']) : null;
    $mother_occupation = $_POST['mother_occupation'] ?? '';
    $family_parish = $_POST['family_parish'] ?? '';
    $family_diocese = $_POST['family_diocese'] ?? '';
    $parish_priest = $_POST['parish_priest'] ?? '';
    
    // Process certificate checkboxes
    $certificates = isset($_POST['certificate']) ? $_POST['certificate'] : [];
    $ielts_certificate = in_array('ielts', $certificates) ? 1 : 0;
    $toefl_certificate = in_array('toefl', $certificates) ? 1 : 0;
    $toeic_certificate = in_array('toeic', $certificates) ? 1 : 0;
    $other_certificate = in_array('other', $certificates) ? 1 : 0;
    
    // Process certificate scores
    $ielts_score = $_POST['ielts_score'] ?? '';
    $toefl_score = $_POST['toefl_score'] ?? '';
    $toeic_score = $_POST['toeic_score'] ?? '';
    
    // Process referral information
    $referral = $_POST['referral'] ?? '';
    $referrer = $_POST['referrer'] ?? '';
    $is_self_discovery = ($referral === 'self') ? 1 : 0;
    $referrer = $is_self_discovery ? '' : $referrer;
    
    // Escape all string inputs to prevent SQL injection
    $fullname = $mysqli->real_escape_string($fullname);
    $birthplace = $mysqli->real_escape_string($birthplace);
    $parish = $mysqli->real_escape_string($parish);
    $diocese = $mysqli->real_escape_string($diocese);
    $education_level = $mysqli->real_escape_string($education_level);
    $major = $mysqli->real_escape_string($major);
    $ielts_score = $mysqli->real_escape_string($ielts_score);
    $toefl_score = $mysqli->real_escape_string($toefl_score);
    $toeic_score = $mysqli->real_escape_string($toeic_score);
    $permanent_address = $mysqli->real_escape_string($permanent_address);
    $contact_address = $mysqli->real_escape_string($contact_address);
    $email = $mysqli->real_escape_string($email);
    $phone = $mysqli->real_escape_string($phone);
    $previous_vocation = $mysqli->real_escape_string($previous_vocation);
    $previous_vocation_time = $mysqli->real_escape_string($previous_vocation_time);
    $referrer = $mysqli->real_escape_string($referrer);
    $exam_location = $mysqli->real_escape_string($exam_location);
    $language_choice = $mysqli->real_escape_string($language_choice);
    $exam_date = $mysqli->real_escape_string($exam_date);
    $aspiration = $mysqli->real_escape_string($aspiration);
    $father_name = $mysqli->real_escape_string($father_name);
    $father_occupation = $mysqli->real_escape_string($father_occupation);
    $mother_name = $mysqli->real_escape_string($mother_name);
    $mother_occupation = $mysqli->real_escape_string($mother_occupation);
    $family_parish = $mysqli->real_escape_string($family_parish);
    $family_diocese = $mysqli->real_escape_string($family_diocese);
    $parish_priest = $mysqli->real_escape_string($parish_priest);
    
    // Prepare SQL statement for update - using direct value insertion instead of bind_param
    $sql = "UPDATE candidates SET 
            fullname = '$fullname', 
            birth_day = $birth_day, 
            birth_month = $birth_month, 
            birth_year = $birth_year, 
            birthplace = '$birthplace', 
            parish = '$parish', 
            diocese = '$diocese', 
            education_level = '$education_level', 
            graduation_year = " . ($graduation_year ? $graduation_year : "NULL") . ", 
            major = '$major', 
            ielts_certificate = $ielts_certificate, 
            ielts_score = '$ielts_score', 
            toefl_certificate = $toefl_certificate, 
            toefl_score = '$toefl_score', 
            toeic_certificate = $toeic_certificate, 
            toeic_score = '$toeic_score', 
            other_certificate = $other_certificate, 
            permanent_address = '$permanent_address', 
            contact_address = '$contact_address', 
            email = '$email', 
            phone = '$phone', 
            previous_vocation = '$previous_vocation', 
            previous_vocation_time = '$previous_vocation_time', 
            is_self_discovery = $is_self_discovery, 
            referrer = '$referrer', 
            exam_location = '$exam_location', 
            language_choice = '$language_choice', 
            exam_date = '$exam_date', 
            aspiration = '$aspiration', 
            father_name = '$father_name', 
            father_birth_year = " . ($father_birth_year ? $father_birth_year : "NULL") . ", 
            father_occupation = '$father_occupation', 
            mother_name = '$mother_name', 
            mother_birth_year = " . ($mother_birth_year ? $mother_birth_year : "NULL") . ", 
            mother_occupation = '$mother_occupation', 
            family_parish = '$family_parish', 
            family_diocese = '$family_diocese', 
            parish_priest = '$parish_priest'
            WHERE candidate_id = $id";
    
    // Execute the statement
    if ($mysqli->query($sql)) {
        // Set success message
        $_SESSION['success_message'] = "Thông tin đã được cập nhật thành công.";
    } else {
        // Set error message
        $_SESSION['error_message'] = "Lỗi khi cập nhật thông tin: " . $mysqli->error;
    }
    
    // Close connection
    $mysqli->close();
    
    // Redirect back to view page
    header("Location: view_registrator.php?id=$id");
    exit();
    
} catch (mysqli_sql_exception $e) {
    die("Lỗi database: " . $e->getMessage());
} catch (Exception $e) {
    die("Lỗi: " . $e->getMessage());
}