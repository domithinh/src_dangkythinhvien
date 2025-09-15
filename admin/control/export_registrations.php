<?php
// Khởi động session
session_start();

// Kết nối đến file global.php
require_once '../../include/global.php';

// Kết nối CSDL
$conn = connectDB();

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Function to format education level
function formatEducation($education) {
    $educationMap = [
        'masters' => 'Thạc sĩ',
        'bachelor' => 'Đại học',
        'associate' => 'Cao đẳng',
        'highschool' => 'Phổ thông Trung học'
    ];
    
    return $educationMap[$education] ?? $education;
}

// Function to format birth date
function formatBirthDate($day, $month, $year) {
    return sprintf("%02d/%02d/%04d", $day, $month, $year);
}

// Function to get exam location
function getExamLocation($location) {
    $locationMap = [
        'da_minh' => 'Thỉnh Viện Đa Minh',
        'north' => 'Miền Bắc',
        'central' => 'Miền Trung'
    ];
    
    return $locationMap[$location] ?? $location;
}

// Function to get exam date
function getExamDate($exam_date) {
    // Nếu giá trị null hoặc chuỗi trống
    if ($exam_date === null || $exam_date === '') {
        return 'Chưa chọn';
    }
    
    $dateMap = [
        '2025-06-08' => '08/06/2025',
        '2025-06-22' => '22/06/2025'
    ];
    
    // Trả về ngày đã định dạng hoặc ngày gốc chuyển đổi sang định dạng dd/mm/yyyy
    return $dateMap[$exam_date] ?? date('d/m/Y', strtotime($exam_date));
}

// Function to get aspiration
function getAspiration($aspiration) {
    return $aspiration === 'priest' ? 'Linh mục' : ($aspiration === 'monk' ? 'Tu huynh' : 'Chưa xác định');
}

// Function to format language choice
function getLanguage($language) {
    $languageMap = [
        'english' => 'Tiếng Anh',
        'french' => 'Tiếng Pháp'
    ];
    
    return $languageMap[$language] ?? $language;
}

// Function to format yes/no bit values
function formatBit($value) {
    return $value ? 'Có' : 'Không';
}

// Danh sách các tên thánh thường gặp để nhận diện
function getCommonSaintNames() {
    return [
        'G.B', 'Đaminh', 'Giuse', 'Maria', 'Phanxicô', 'Antôn', 'Phêrô', 'Phaolô', 'Gioan', 
        'Anrê', 'Tôma', 'Giacôbê', 'Matthêu', 'Anna', 'Têrêsa', 'Lucia', 'Cecilia', 
        'Catarina', 'Tađêô', 'Augustinô', 'Micae', 'Martino', 'Raphael', 'Gabriel', 
        'Stêphanô', 'Vinh Sơn', 'Xavier', 'Philiphê', 'Bênađô', 'Đaminicô', 'Luca',
        'Maccô', 'Monica', 'Clêmentê', 'Laurensô', 'Clara', 'Elizabeth', 'Faustina',
        'Gioan Bosco', 'Gioan Baotixita', 'Anphong', 'Phanxica', 'Rôsa', 'Đaminh Savio'
    ];
}

// Function to split fullname into saint names, last name with middle name, and first name
function splitFullName($fullname) {
    // Mặc định là rỗng cho từng phần
    $result = [
        'saint_name' => '',
        'last_middle_name' => '',
        'first_name' => ''
    ];
    
    // Danh sách tên thánh thường gặp
    $saintNames = getCommonSaintNames();
    
    // Tách chuỗi theo khoảng trắng
    $parts = explode(' ', trim($fullname));
    
    // Nếu có ít nhất 3 phần
    if (count($parts) >= 3) {
        // Kiểm tra xem có hai tên thánh không
        $potentialSaints = [];
        
        // Kiểm tra từng phần ở đầu tên có phải là tên thánh không
        foreach ($parts as $index => $part) {
            if (in_array($part, $saintNames)) {
                $potentialSaints[] = $index;
            } else {
                // Nếu không phải tên thánh, dừng kiểm tra
                break;
            }
        }
        
        // Kiểm tra xem có tên thánh ghép (như "Gioan Baotixita") không
        foreach ($saintNames as $saintName) {
            if (strpos($saintName, ' ') !== false) {
                $saintParts = explode(' ', $saintName);
                if (count($saintParts) == 2) {
                    if (count($parts) >= 2 && $parts[0] == $saintParts[0] && $parts[1] == $saintParts[1]) {
                        $potentialSaints = [0, 1]; // Đánh dấu cả hai vị trí đầu tiên là tên thánh
                    }
                }
            }
        }
        
        if (!empty($potentialSaints)) {
            // Lấy tất cả tên thánh
            $saintNameParts = [];
            foreach ($potentialSaints as $index) {
                $saintNameParts[] = $parts[$index];
            }
            $result['saint_name'] = implode(' ', $saintNameParts);
            
            // Loại bỏ các phần tử đã được sử dụng cho tên thánh
            foreach ($potentialSaints as $index) {
                unset($parts[$index]);
            }
            $parts = array_values($parts); // Sắp xếp lại mảng
        } else {
            // Nếu không tìm thấy tên thánh trong danh sách, giả định phần đầu tiên là tên thánh
            $result['saint_name'] = array_shift($parts);
        }
        
        // Lấy phần cuối cùng làm tên
        $result['first_name'] = array_pop($parts);
        
        // Phần còn lại là họ và tên đệm
        $result['last_middle_name'] = implode(' ', $parts);
    } 
    // Nếu chỉ có 2 phần
    elseif (count($parts) == 2) {
        $result['saint_name'] = $parts[0]; // Phần đầu tiên làm tên thánh
        $result['first_name'] = $parts[1]; // Phần thứ hai làm tên
    }
    // Nếu chỉ có 1 phần
    elseif (count($parts) == 1) {
        $result['first_name'] = $parts[0]; // Phần duy nhất làm tên
    }
    
    return $result;
}

try {
    // Truy vấn dữ liệu
    $query = "SELECT * FROM candidates ORDER BY candidate_id DESC";
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Lỗi truy vấn SQL: " . $conn->error);
    }

    // Lấy tất cả dữ liệu
    $candidates = $result->fetch_all(MYSQLI_ASSOC);

    // Tên file
    $filename = "Danh_sach_ung_vien_dang_ky_du_thi_" . date('Y-m-d') . ".xls";
    
    // Thiết lập headers để browser hiểu đây là file Excel
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Xuất dữ liệu dưới dạng bảng HTML (Excel có thể mở file HTML có định dạng đúng)
    echo '<!DOCTYPE html>';
    echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    echo '<head>';
    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    echo '<style>';
    echo 'td { border: 1px solid #000000; }';
    echo 'th { border: 1px solid #000000; font-weight: bold; background-color: #D9D9D9; }';
    echo '.header { font-size: 14pt; font-weight: bold; text-align: center; }';
    echo '.title { font-size: 16pt; font-weight: bold; text-align: center; }';
    echo '.date { text-align: center; }';
    echo '.center { text-align: center; }';
    echo '.right { text-align: right; }';
    echo '.footer { font-weight: bold; margin-top: 20px; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    
    // Tạo header
    echo '<div class="header">TỈNH DÒNG NỮ VƯƠNG CÁC THÁNH TỬ ĐẠO VIỆT NAM</div>';
    echo '<div class="header">THỈNH VIỆN THÁNH GIOAN TÔNG ĐỒ</div>';
    echo '<div>&nbsp;</div>';
    echo '<div class="title">DANH SÁCH ĐẦY ĐỦ ĐĂNG KÝ THI TUYỂN ƠN GỌI ĐAMINH</div>';
    echo '<div class="date">(Ngày xuất: ' . date('d/m/Y') . ')</div>';
    echo '<div>&nbsp;</div>';
    
    // Tạo bảng
    echo '<table>';
    echo '<tr>';
    echo '<th>STT</th>';
    echo '<th>Tên Thánh</th>';
    echo '<th>Họ và Tên Đệm</th>';
    echo '<th>Tên</th>';
    echo '<th>Ngày sinh</th>';
    echo '<th>Nơi sinh</th>';
    echo '<th>Giáo xứ</th>';
    echo '<th>Giáo phận</th>';
    echo '<th>Trình độ học vấn</th>';
    echo '<th>Năm tốt nghiệp</th>';
    echo '<th>Chuyên ngành</th>';
    echo '<th>Chứng chỉ IELTS</th>';
    echo '<th>Điểm IELTS</th>';
    echo '<th>Chứng chỉ TOEFL</th>';
    echo '<th>Điểm TOEFL</th>';
    echo '<th>Chứng chỉ TOEIC</th>';
    echo '<th>Điểm TOEIC</th>';
    echo '<th>Chứng chỉ khác</th>';
    echo '<th>Địa chỉ thường trú</th>';
    echo '<th>Địa chỉ liên lạc</th>';
    echo '<th>Email</th>';
    echo '<th>Điện thoại</th>';
    echo '<th>Ơn gọi trước đây</th>';
    echo '<th>Thời gian ơn gọi trước</th>';
    echo '<th>Người giới thiệu</th>';
    echo '<th>Tự tìm hiểu</th>';
    echo '<th>Địa điểm thi</th>';
    echo '<th>Ngày thi</th>';
    echo '<th>Thi Giáo lý</th>';
    echo '<th>Thi Việt ngữ</th>';
    echo '<th>Ngoại ngữ chọn thi</th>';
    echo '<th>Nguyện vọng</th>';
    echo '<th>Tên cha</th>';
    echo '<th>Năm sinh cha</th>';
    echo '<th>Nghề nghiệp cha</th>';
    echo '<th>Tên mẹ</th>';
    echo '<th>Năm sinh mẹ</th>';
    echo '<th>Nghề nghiệp mẹ</th>';
    echo '<th>Giáo xứ gia đình</th>';
    echo '<th>Giáo phận gia đình</th>';
    echo '<th>Linh mục quản xứ</th>';
    echo '<th>Ngày đăng ký</th>';
    echo '</tr>';
    
    // Đổ dữ liệu
    $count = 1;
    foreach ($candidates as $candidate) {
        // Tách họ tên thành 3 phần
        $nameParts = splitFullName($candidate['fullname']);
        
        echo '<tr>';
        echo '<td class="center">' . $count . '</td>';
        echo '<td class="center">' . $nameParts['saint_name'] . '</td>';
        echo '<td class="center">' . $nameParts['last_middle_name'] . '</td>';
        echo '<td class="center">' . $nameParts['first_name'] . '</td>';
        echo '<td class="center">' . formatBirthDate($candidate['birth_day'], $candidate['birth_month'], $candidate['birth_year']) . '</td>';
        echo '<td class="center">' . $candidate['birthplace'] . '</td>';
        echo '<td class="center">' . $candidate['parish'] . '</td>';
        echo '<td class="center">' . $candidate['diocese'] . '</td>';
        echo '<td class="center">' . formatEducation($candidate['education_level']) . '</td>';
        echo '<td class="center">' . ($candidate['graduation_year'] > 0 ? $candidate['graduation_year'] : '') . '</td>';
        echo '<td class="center">' . $candidate['major'] . '</td>';
        echo '<td class="center">' . formatBit($candidate['ielts_certificate']) . '</td>';
        echo '<td class="center">' . $candidate['ielts_score'] . '</td>';
        echo '<td class="center">' . formatBit($candidate['toefl_certificate']) . '</td>';
        echo '<td class="center">' . $candidate['toefl_score'] . '</td>';
        echo '<td class="center">' . formatBit($candidate['toeic_certificate']) . '</td>';
        echo '<td class="center">' . $candidate['toeic_score'] . '</td>';
        echo '<td class="center">' . formatBit($candidate['other_certificate']) . '</td>';
        echo '<td class="center">' . $candidate['permanent_address'] . '</td>';
        echo '<td class="center">' . $candidate['contact_address'] . '</td>';
        echo '<td class="center">' . $candidate['email'] . '</td>';
        echo '<td class="center">' . $candidate['phone'] . '</td>';
        echo '<td class="center">' . $candidate['previous_vocation'] . '</td>';
        echo '<td class="center">' . $candidate['previous_vocation_time'] . '</td>';
        echo '<td class="center">' . $candidate['referrer'] . '</td>';
        echo '<td class="center">' . formatBit($candidate['is_self_discovery']) . '</td>';
        echo '<td class="center">' . getExamLocation($candidate['exam_location']) . '</td>';
        echo '<td class="center">' . getExamDate($candidate['exam_date']) . '</td>';
        echo '<td class="center">' . formatBit($candidate['subject_catheism']) . '</td>';
        echo '<td class="center">' . formatBit($candidate['subject_vietnamese']) . '</td>';
        echo '<td class="center">' . getLanguage($candidate['language_choice']) . '</td>';
        echo '<td class="center">' . getAspiration($candidate['aspiration']) . '</td>';
        echo '<td class="center">' . $candidate['father_name'] . '</td>';
        echo '<td class="center">' . ($candidate['father_birth_year'] > 0 ? $candidate['father_birth_year'] : '') . '</td>';
        echo '<td class="center">' . $candidate['father_occupation'] . '</td>';
        echo '<td class="center">' . $candidate['mother_name'] . '</td>';
        echo '<td class="center">' . ($candidate['mother_birth_year'] > 0 ? $candidate['mother_birth_year'] : '') . '</td>';
        echo '<td class="center">' . $candidate['mother_occupation'] . '</td>';
        echo '<td class="center">' . $candidate['family_parish'] . '</td>';
        echo '<td class="center">' . $candidate['family_diocese'] . '</td>';
        echo '<td class="center">' . $candidate['parish_priest'] . '</td>';
        echo '<td class="center">' . date('d/m/Y H:i:s', strtotime($candidate['registration_date'])) . '</td>';
        echo '</tr>';
        $count++;
    }
    
    echo '</table>';
    
    // Tạo footer
    echo '<div class="footer">Tổng số ứng viên đăng ký dự thi : ' . ($count - 1) . '</div>';
    
    echo '</body>';
    echo '</html>';
    
    exit;

} catch (Exception $e) {
    // Xử lý lỗi kết nối hoặc truy vấn CSDL
    echo "<div style='background-color: #ffeeee; padding: 10px; margin-bottom: 15px; border: 1px solid #ff0000;'>";
    echo "<h3>LỖI EXPORT:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p><a href='display_registrations.php'>Quay lại danh sách</a></p>";
    echo "</div>";
    exit;
}

// Đóng kết nối
$conn->close();
?>