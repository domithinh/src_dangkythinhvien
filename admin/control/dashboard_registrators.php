<?php
// Khởi động session (Thêm vào đầu file display_registrations.php)
session_start();

require_once '../../include/global.php';

// Kết nối CSDL
$conn = connectDB();

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

try {
    // Phân trang
    $records_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start_from = ($page - 1) * $records_per_page;

    // Xây dựng câu truy vấn với điều kiện tìm kiếm và lọc
    $where_conditions = [];
    $params = [];
    $param_types = '';

    // Xử lý tìm kiếm
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = '%' . $_GET['search'] . '%';
        $where_conditions[] = "(fullname LIKE ? OR parish LIKE ? OR diocese LIKE ? OR phone LIKE ? OR email LIKE ?)";
        $params = array_merge($params, [$search, $search, $search, $search, $search]);
        $param_types .= 'sssss';
    }

    // Xử lý lọc theo trình độ học vấn
    if (isset($_GET['education']) && !empty($_GET['education'])) {
        $where_conditions[] = "education_level = ?";
        $params[] = $_GET['education'];
        $param_types .= 's';
    }

    // Xử lý lọc theo địa điểm thi
    if (isset($_GET['location']) && !empty($_GET['location'])) {
        $where_conditions[] = "exam_location = ?";
        $params[] = $_GET['location'];
        $param_types .= 's';
    }

    // Xử lý lọc theo nguyện vọng
    if (isset($_GET['aspiration']) && !empty($_GET['aspiration'])) {
        $where_conditions[] = "aspiration = ?";
        $params[] = $_GET['aspiration'];
        $param_types .= 's';
    }

    // Tạo câu lệnh WHERE
    $where_clause = '';
    if (!empty($where_conditions)) {
        $where_clause = " WHERE " . implode(' AND ', $where_conditions);
    }

    // Đếm tổng số bản ghi thỏa mãn điều kiện
    $count_query = "SELECT COUNT(*) as total FROM candidates" . $where_clause;
    $stmt = $conn->prepare($count_query);

    if (!empty($params)) {
        $stmt->bind_param($param_types, ...$params);
    }

    $stmt->execute();
    $count_result = $stmt->get_result();
    $total_records = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_records / $records_per_page);

    // Truy vấn dữ liệu có giới hạn
    $query = "SELECT * FROM candidates" . $where_clause . " ORDER BY candidate_id DESC LIMIT ?, ?";
    $stmt = $conn->prepare($query);

    if (!empty($params)) {
        $param_types .= 'ii';
        $params[] = $start_from;
        $params[] = $records_per_page;
        $stmt->bind_param($param_types, ...$params);
    } else {
        $stmt->bind_param('ii', $start_from, $records_per_page);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $candidates = $result->fetch_all(MYSQLI_ASSOC);

} catch (Exception $e) {
    // Xử lý lỗi kết nối hoặc truy vấn CSDL
    echo "<div style='background-color: #ffeeee; padding: 10px; margin-bottom: 15px; border: 1px solid #ff0000;'>";
    echo "<h3>LỖI DATABASE:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
    die("Lỗi database: " . $e->getMessage());
}
function getAdminNames($conn) {
    $query = "SELECT full_name FROM admin_account";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $admin_names = [];
    while ($row = $result->fetch_assoc()) {
        $admin_names[] = $row['full_name'];
    }

    $stmt->close();
    return $admin_names;
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

// Function to format certificates
function formatCertificates($row) {
    $certificates = [];
    
    if ($row['ielts_certificate']) {
        $cert = 'IELTS';
        if (!empty($row['ielts_score'])) {
            $cert .= ': ' . $row['ielts_score'];
        }
        $certificates[] = $cert;
    }
    
    if ($row['toefl_certificate']) {
        $cert = 'TOEFL';
        if (!empty($row['toefl_score'])) {
            $cert .= ': ' . $row['toefl_score'];
        }
        $certificates[] = $cert;
    }
    
    if ($row['toeic_certificate']) {
        $cert = 'TOEIC';
        if (!empty($row['toeic_score'])) {
            $cert .= ': ' . $row['toeic_score'];
        }
        $certificates[] = $cert;
    }
    
    if ($row['other_certificate']) {
        $certificates[] = 'Chứng chỉ khác';
    }
    
    return empty($certificates) ? 'Không có' : implode(', ', $certificates);
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
    $examDateMap = [
        '2025-06-09' => '09/06/2025',
        '2025-06-23' => '23/06/2025'
    ];
    
    return $exam_date ? ($examDateMap[$exam_date] ?? 'Chưa xác định') : 'Chưa chọn';
}
// Function to get aspiration
function getAspiration($aspiration) {
    return $aspiration === 'priest' ? 'Linh mục' : ($aspiration === 'monk' ? 'Tu huynh' : 'Chưa xác định');
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đăng ký - Thỉnh Viện Đa Minh</title>
    <link rel="stylesheet" href="../css/dashboard_registrators.css">
</head>

<body>
    <div class="admin-navbar">
        <div class="admin-profile">
            <img src="../../assets/Logo-thinh-vien-01.jpg" alt="Admin Profile" class="admin-profile-pic">
            <div class="admin-info">
                <div class="admin-greeting">Hello, Admin Director</div>
                <?php
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                ?>
                <div class="admin-date"><?php echo (new DateTime())->format('Y-m-d H:i'); ?></div>

            </div>
        </div>
        <button class="logout-btn" onclick="window.location.href='logout.php'">Đăng xuất</button>
    </div>

    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="../../assets/Logo-thinh-vien-01.jpg" alt="Logo Thinh vien" width="100">
            </div>
            <div class="title-container">
                <h2>TỈNH DÒNG NỮ VƯƠNG CÁC THÁNH TỬ ĐẠO VIỆT NAM</h2>
                <h2>THỈNH VIỆN THÁNH GIOAN TÔNG ĐỒ</h2>
            </div>
        </div>

        <div class="main-title">
            <h1>DANH SÁCH NGƯỜI ĐĂNG KÝ</h1>
            <h2>THI TUYỂN ƠN GỌI ĐAMINH</h2>
        </div>

        <!-- Search and filter options -->
        <div class="search-form">
            <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên, giáo xứ, giáo phận..."
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="button" onclick="searchRegistrations()">Tìm kiếm</button>
        </div>

        <div class="filter-container">
            <select id="educationFilter" onchange="filterRegistrations()">
                <option value="">Tất cả trình độ học vấn</option>
                <option value="masters"
                    <?php echo (isset($_GET['education']) && $_GET['education'] == 'masters') ? 'selected' : ''; ?>>Thạc
                    sĩ</option>
                <option value="bachelor"
                    <?php echo (isset($_GET['education']) && $_GET['education'] == 'bachelor') ? 'selected' : ''; ?>>Đại
                    học</option>
                <option value="associate"
                    <?php echo (isset($_GET['education']) && $_GET['education'] == 'associate') ? 'selected' : ''; ?>>
                    Cao đẳng</option>
                <option value="highschool"
                    <?php echo (isset($_GET['education']) && $_GET['education'] == 'highschool') ? 'selected' : ''; ?>>
                    Phổ thông Trung học</option>
            </select>

            <select id="locationFilter" onchange="filterRegistrations()">
                <option value="">Tất cả địa điểm thi</option>
                <option value="da_minh"
                    <?php echo (isset($_GET['location']) && $_GET['location'] == 'da_minh') ? 'selected' : ''; ?>>Thỉnh
                    Viện Đa Minh</option>
                <option value="north"
                    <?php echo (isset($_GET['location']) && $_GET['location'] == 'north') ? 'selected' : ''; ?>>Miền Bắc
                </option>
                <option value="central"
                    <?php echo (isset($_GET['location']) && $_GET['location'] == 'central') ? 'selected' : ''; ?>>Miền
                    Trung</option>
            </select>

            <select id="aspirationFilter" onchange="filterRegistrations()">
                <option value="">Tất cả nguyện vọng</option>
                <option value="priest"
                    <?php echo (isset($_GET['aspiration']) && $_GET['aspiration'] == 'priest') ? 'selected' : ''; ?>>
                    Linh mục</option>
                <option value="monk"
                    <?php echo (isset($_GET['aspiration']) && $_GET['aspiration'] == 'monk') ? 'selected' : ''; ?>>Tu
                    huynh</option>
            </select>
        </div>

        <div class="export-container">
            <a href="export_registrations.php" class="export-button">Xuất Excel</a>
        </div>
        <div class="table-container">
            <table id="registrationTable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ và tên</th>
                        <th>Ngày sinh</th>
                        <th>Giáo xứ - Giáo phận</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Địa điểm thi</th>
                        <th>Ngày thi</th>
                        <th>Nguyện vọng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($candidates)) {
                        $count = $start_from + 1;
                        foreach ($candidates as $row) {
                            echo "<tr>";
                            echo "<td>" . $count . "</td>";
                            echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                            echo "<td>" . formatBirthDate($row['birth_day'], $row['birth_month'], $row['birth_year']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['parish']) . " - " . htmlspecialchars($row['diocese']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . getExamLocation($row['exam_location']) . "</td>";
                            echo "<td>" . getExamDate($row['exam_date']) . "</td>";
                            echo "<td>" . getAspiration($row['aspiration']) . "</td>";
                            echo "<td>
                                    <a href='view_registrator.php?id=" . $row['candidate_id'] . "' class='view-details'>Xem chi tiết</a>
                                    <a href='delete_registration.php?id=" . $row['candidate_id'] . "' class='delete-button'>Xóa</a>
                                </td>";
                            echo "</tr>";
                            $count++;
                        }
                    } else {
                        echo "<tr><td colspan='10'>Không có dữ liệu đăng ký</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php if($page > 1): ?>
            <a
                href="?page=1<?php echo isset($_GET['search']) ? '&search='.urlencode($_GET['search']) : ''; echo isset($_GET['education']) ? '&education='.urlencode($_GET['education']) : ''; echo isset($_GET['location']) ? '&location='.urlencode($_GET['location']) : ''; echo isset($_GET['aspiration']) ? '&aspiration='.urlencode($_GET['aspiration']) : ''; ?>">&laquo;</a>
            <a
                href="?page=<?php echo $page-1; ?><?php echo isset($_GET['search']) ? '&search='.urlencode($_GET['search']) : ''; echo isset($_GET['education']) ? '&education='.urlencode($_GET['education']) : ''; echo isset($_GET['location']) ? '&location='.urlencode($_GET['location']) : ''; echo isset($_GET['aspiration']) ? '&aspiration='.urlencode($_GET['aspiration']) : ''; ?>">&lsaquo;</a>
            <?php endif; ?>

            <?php
            $start_page = max(1, $page - 2);
            $end_page = min($total_pages, $page + 2);
            
            for($i = $start_page; $i <= $end_page; $i++): ?>
            <a href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search='.urlencode($_GET['search']) : ''; echo isset($_GET['education']) ? '&education='.urlencode($_GET['education']) : ''; echo isset($_GET['location']) ? '&location='.urlencode($_GET['location']) : ''; echo isset($_GET['aspiration']) ? '&aspiration='.urlencode($_GET['aspiration']) : ''; ?>"
                <?php echo ($i == $page) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if($page < $total_pages): ?>
            <a
                href="?page=<?php echo $page+1; ?><?php echo isset($_GET['search']) ? '&search='.urlencode($_GET['search']) : ''; echo isset($_GET['education']) ? '&education='.urlencode($_GET['education']) : ''; echo isset($_GET['location']) ? '&location='.urlencode($_GET['location']) : ''; echo isset($_GET['aspiration']) ? '&aspiration='.urlencode($_GET['aspiration']) : ''; ?>">&rsaquo;</a>
            <a
                href="?page=<?php echo $total_pages; ?><?php echo isset($_GET['search']) ? '&search='.urlencode($_GET['search']) : ''; echo isset($_GET['education']) ? '&education='.urlencode($_GET['education']) : ''; echo isset($_GET['location']) ? '&location='.urlencode($_GET['location']) : ''; echo isset($_GET['aspiration']) ? '&aspiration='.urlencode($_GET['aspiration']) : ''; ?>">&raquo;</a>
            <?php endif; ?>
        </div>
    </div>
    <div id="notificationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalMessage"></div>
        </div>
    </div>

    <!-- Modal xác nhận xóa -->
    <div id="confirmDeleteModal" class="modal">
        <div class="modal-content">
            <h3>Xác nhận xóa</h3>
            <p>Bạn có chắc chắn muốn xóa thông tin này không?</p>
            <div class="modal-buttons">
                <button id="confirmDelete" class="btn-confirm">Xác nhận</button>
                <button id="cancelDelete" class="btn-cancel">Hủy</button>
            </div>
        </div>
    </div>

    <script src="../js/dashboard_registrators.js"></script>
</body>

</html>