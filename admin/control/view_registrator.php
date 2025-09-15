<?php
    session_start();

    require_once '../../include/global.php';

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: display_registrations.php");
        exit();
    }
    
    $id = intval($_GET['id']);

    try {
        // Connect to database using MySQLi
        $mysqli = connectDB();
        
        // Fetch candidate data
        $stmt = $mysqli->prepare("SELECT * FROM candidates WHERE candidate_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $candidate = $result->fetch_assoc();
        
        if (!$candidate) {
            throw new Exception("Không tìm thấy thông tin người đăng ký");
        }
        
    } catch (mysqli_sql_exception $e) {
        die("Lỗi database: " . $e->getMessage());
    } catch (Exception $e) {
        die("Lỗi: " . $e->getMessage());
    }

    function getEducation($education) {
        $educationMap = [
            'masters' => 'Thạc sĩ',
            'bachelor' => 'Đại học',
            'associate' => 'Cao đẳng',
            'highschool' => 'Phổ thông Trung học'
        ];
        
        return $educationMap[$education] ?? $education;
    }
    
    function formatBirthDate($day, $month, $year) {
        return sprintf("%02d/%02d/%04d", $day, $month, $year);
    }
    
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
    
    function getExamLocation($location) {
        $locationMap = [
            'da_minh' => 'Thỉnh Viện Đa Minh',
            'north' => 'Miền Bắc',
            'central' => 'Miền Trung'
        ];
        
        return $locationMap[$location] ?? $location;
    }
    
    function getAspirationChoice($aspiration) {
        $aspirationMap = [
            'priest' => 'Linh mục',
            'monk'   => 'Tu huynh'
        ];

        return $aspirationMap[$aspiration] ?? $aspiration;
    }

    function getLanguageChoice($language) {
        $languageMap = [
            'english' => 'Anh Văn',
            'french'  => 'Pháp Văn'
        ];
        return $languageMap[$language] ?? $language;
    }
   
    function getExamDate($exam_date) {
        $examDateMap = [
            '2025-06-09' => '09/06/2025',
            '2025-06-23' => '23/06/2025'
        ];
        
        return $exam_date ? ($examDateMap[$exam_date] ?? 'Chưa xác định') : 'Chưa chọn';
    }

    function formatReferral($candidate) {
        if (!empty($candidate['referrer'])) {
            return $candidate['referrer'];
        } else if ($candidate['is_self_discovery']) {
            return 'Tự tìm hiểu';
        }
        return 'Không có thông tin';
    }

    function getCurrentDate() {
        // Set locale to Vietnamese
        setlocale(LC_TIME, 'vi_VN', 'vi', 'vn_VN', 'vn');
        
        $day = date('d');
        $month = date('m');
        $year = date('Y');
        
        return "ngày $day tháng $month năm $year";
    }    
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phiếu đăng ký - Thỉnh viện Đa Minh</title>
    <meta name="description" content="Phiếu đăng ký thi tuyển sinh ơn gọi Đa Minh">
    <link rel="stylesheet" href="../css/view_registrator.css">
</head>
<body>
    <div class="form-container">
        <header class="header">
            <div class="logo">
                <img src="../../assets/Logo-thinh-vien-01.jpg" alt="Logo Thỉnh viện">
            </div>
            <div class="institution-info">
                <h2>TỈNH DÒNG NỮ VƯƠNG CÁC THÁNH TỬ ĐẠO VIỆT NAM</h2>
                <h2>THỈNH VIỆN THÁNH GIOAN TÔNG ĐỒ</h2>
                <address>
                    <p>70/1 Tổ 1, Kp. Bình Dương 3, P. An Bình, Tp. Dĩ An, T. Bình Dương.</p>
                    <p>Điện thoại: (08) 38 97 79 62 | Email: thinhviendaminh@gmail.com</p>
                    <p>Website: http://www.thinhviendaminh.net</p>
                </address>
            </div>
        </header>

        <div class="main-title">
            <h1>Phiếu đăng ký</h1>
            <h2>Thi tuyển sinh ơn gọi Đa Minh</h2>
        </div>

        <form action="edit_registrator.php" method="post">
            <input type="hidden" name="candidate_id" value="<?php echo $id; ?>">
            <!-- Thông tin cá nhân -->
            <section class="form-section personal-info">
                <div class="form-item">
                    <label class="label" for="fullname">1.</label>
                    <div class="content">
                        <label for="fullname">Tên thánh, họ và tên gọi:</label>
                        <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($candidate['fullname']); ?>" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">2.</label>
                    <div class="content">
                        <label>Sinh ngày</label>
                        <div class="date-input">
                            <input type="text" id="day" name="day" value="<?php echo sprintf("%02d", $candidate['birth_day']); ?>" maxlength="2" required>
                            <span>tháng</span>
                            <input type="text" id="month" name="month" value="<?php echo sprintf("%02d", $candidate['birth_month']); ?>" maxlength="2" required>
                            <span>năm</span>
                            <input type="text" id="year" name="year" value="<?php echo $candidate['birth_year']; ?>" maxlength="4" required>
                            <span>, tại</span>
                            <input type="text" id="birthplace" name="birthplace" value="<?php echo htmlspecialchars($candidate['birthplace']); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">3.</label>
                    <div class="content">
                        <label for="parish">Thuộc Giáo xứ:</label>
                        <input type="text" id="parish" name="parish" value="<?php echo htmlspecialchars($candidate['parish']); ?>" required>
                        <label for="diocese">Giáo phận:</label>
                        <input type="text" id="diocese" name="diocese" value="<?php echo htmlspecialchars($candidate['diocese']); ?>" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">4.</label>
                    <div class="content">
                        <span>Trình độ học vấn <i>(chọn văn bằng cao nhất)</i>:</span>
                    </div>
                </div>

                <div class="checkbox-group">
                    <?php 
                    $educationOptions = ['masters', 'bachelor', 'associate', 'highschool'];
                    foreach ($educationOptions as $option): ?>
                        <div class="checkbox-item">
                            <input type="radio" id="<?php echo $option; ?>" name="education" 
                                   value="<?php echo $option; ?>" 
                                   <?php echo ($candidate['education_level'] == $option) ? 'checked' : ''; ?>>
                            <label for="<?php echo $option; ?>"><?php echo getEducation($option); ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="checkbox-item">
                        <label for="graduationYear">Năm tốt nghiệp:</label>
                        <input type="text" id="graduationYear" name="graduationYear" 
                               value="<?php echo $candidate['graduation_year'] ?? ''; ?>" maxlength="4">
                    </div>
                </div>

                <div class="form-item major-field">
                    <div class="content">
                        <label for="major">Chuyên ngành:</label>
                        <input type="text" id="major" name="major" 
                               value="<?php echo htmlspecialchars($candidate['major'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-item certificate-language">
                    <div class="content">
                        <span>Đã có chứng chỉ</span>
                        <div class="certificate-group">
                            <div class="certificate-item">
                                <input type="checkbox" id="ielts" name="certificate[]" value="ielts" 
                                       <?php echo $candidate['ielts_certificate'] ? 'checked' : ''; ?>>
                                <label for="ielts">IELTS:</label>
                                <input type="text" id="ielts_score" name="ielts_score" 
                                       value="<?php echo htmlspecialchars($candidate['ielts_score'] ?? ''); ?>" 
                                       aria-label="Điểm IELTS">
                            </div>
                            <div class="certificate-item">
                                <input type="checkbox" id="toefl" name="certificate[]" value="toefl" 
                                       <?php echo $candidate['toefl_certificate'] ? 'checked' : ''; ?>>
                                <label for="toefl">TOEFL:</label>
                                <input type="text" id="toefl_score" name="toefl_score" 
                                       value="<?php echo htmlspecialchars($candidate['toefl_score'] ?? ''); ?>" 
                                       aria-label="Điểm TOEFL">
                            </div>
                            <div class="certificate-item">
                                <input type="checkbox" id="toeic" name="certificate[]" value="toeic" 
                                       <?php echo $candidate['toeic_certificate'] ? 'checked' : ''; ?>>
                                <label for="toeic">TOEIC:</label>
                                <input type="text" id="toeic_score" name="toeic_score" 
                                       value="<?php echo htmlspecialchars($candidate['toeic_score'] ?? ''); ?>" 
                                       aria-label="Điểm TOEIC">
                            </div>
                            <div class="certificate-item">
                                <input type="checkbox" id="other" name="certificate[]" value="other" 
                                       <?php echo $candidate['other_certificate'] ? 'checked' : ''; ?>>
                                <label for="other">chuyên ngành khác</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">5.</label>
                    <div class="content">
                        <label for="permanent_address">Địa chỉ thường trú <i>(gia đình)</i>:</label>
                        <input type="text" id="permanent_address" name="permanent_address" 
                               value="<?php echo htmlspecialchars($candidate['permanent_address']); ?>" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">6.</label>
                    <div class="content">
                        <label for="contact_address">Địa chỉ liên lạc <i>(nơi đang cư trú)</i>:</label>
                        <input type="text" id="contact_address" name="contact_address" 
                               value="<?php echo htmlspecialchars($candidate['contact_address']); ?>" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">7.</label>
                    <div class="content">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($candidate['email']); ?>" required>
                        <label for="phone">Điện thoại:</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($candidate['phone']); ?>" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">8.</label>
                    <div class="content">
                        <label for="previous_vocation">Đã tìm hiểu ơn gọi giáo phận hoặc dòng tu khác <i>(nếu có)</i>:</label>
                        <input type="text" id="previous_vocation" name="previous_vocation" 
                               value="<?php echo htmlspecialchars($candidate['previous_vocation'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-item">
                    <div class="content indented">
                        <label for="previous_vocation_time">Thời gian đã tìm hiểu:</label>
                        <input type="text" id="previous_vocation_time" name="previous_vocation_time" 
                               value="<?php echo htmlspecialchars($candidate['previous_vocation_time'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">9.</label>
                    <div class="content">
                        <label for="referrer">Người giới thiệu tìm hiểu ơn gọi Đa Minh:</label>
                        <input type="text" id="referrer" name="referrer" 
                               value="<?php echo htmlspecialchars(formatReferral($candidate)); ?>">
                    </div>
                </div>

                <div class="form-item">
                    <div class="content indented">
                        <span><i>hoặc</i></span>
                        <div class="checkbox-item">
                            <input type="checkbox" id="self_discovery" name="referral" value="self" 
                                   <?php echo $candidate['is_self_discovery'] ? 'checked' : ''; ?>>
                            <label for="self_discovery">tự tìm hiểu</label>
                        </div>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">10.</label>
                    <div class="content">
                        <span>Đăng ký dự thi tại:</span>
                    </div>
                </div>

                <div class="checkbox-group">
                    <?php 
                    $examLocations = ['da_minh', 'north', 'central'];
                    foreach ($examLocations as $location): ?>
                        <div class="checkbox-item-exam">
                            <input type="radio" id="location_<?php echo $location; ?>" name="exam_location" 
                                   value="<?php echo $location; ?>" 
                                   <?php echo ($candidate['exam_location'] == $location) ? 'checked' : ''; ?>>
                            <label for="location_<?php echo $location; ?>">
                                <b><?php echo getExamLocation($location); ?></b>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="form-item">
                    <div class="content indented">
                        <span>Ba môn dự thi bắt buộc:</span>
                    </div>
                </div>

                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="subject_catechism" name="subject[]" value="catechism" 
                               checked disabled>
                        <label for="subject_religion"><b>Giáo lý</b></label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="subject_vietnamese" name="subject[]" value="vietnamese" 
                               checked disabled>
                        <label for="subject_vietnamese"><b>Việt Văn</b></label>
                    </div>
                    <div class="language-choice">
                        <?php 
                        $languages = ['english', 'french'];
                        foreach ($languages as $language): ?>
                            <div class="checkbox-item">
                                <input type="radio" id="subject_<?php echo $language; ?>" name="language" 
                                       value="<?php echo $language; ?>" 
                                       <?php echo ($candidate['language_choice'] == $language) ? 'checked' : ''; ?>>
                                <label for="subject_<?php echo $language; ?>"><b><?php echo getLanguageChoice($language); ?></b></label>
                            </div>
                        <?php endforeach; ?>
                        <span class="or-text"><i>hoặc</i></span>
                        <p class="note"><i>(chọn một trong hai sinh ngữ để thi)</i></p>
                    </div>
                </div>

                <div class="form-item">
                    <div class="content indented">
                        <span>Chọn ngày thi:</span>
                    </div>
                </div>
                <div class="checkbox-group">
                    <?php 
                    $examDates = ['2025-06-09', '2025-06-23'];
                    foreach ($examDates as $date): ?>
                        <div class="checkbox-item-exam">
                            <input type="radio" id="exam_date_<?php echo str_replace('-', '_', $date); ?>" 
                                   name="exam_date" value="<?php echo $date; ?>" 
                                   <?php echo ($candidate['exam_date'] == $date) ? 'checked' : ''; ?> 
                                   required>
                            <label for="exam_date_<?php echo str_replace('-', '_', $date); ?>">
                                <b><?php echo getExamDate($date); ?></b>
                            </label>
                        </div>
                        <?php if ($date !== end($examDates)): ?>
                            <p class="note"><i>hoặc</i></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="form-item">
                    <label class="label">11.</label>
                    <div class="content">
                        <span>Nguyện vọng là tu sĩ Đa Minh:</span>
                        <div class="aspiration-choices">
                            <?php 
                            $aspirations = ['priest', 'monk'];
                            foreach ($aspirations as $aspiration): ?>
                                <input type="radio" id="aspiration_<?php echo $aspiration; ?>" 
                                       name="aspiration" value="<?php echo $aspiration; ?>" 
                                       <?php echo ($candidate['aspiration'] == $aspiration) ? 'checked' : ''; ?> 
                                       required>
                                <label for="aspiration_<?php echo $aspiration; ?>">
                                    <b><?php echo getAspirationChoice($aspiration); ?></b>
                                </label>
                                <?php if ($aspiration !== end($aspirations)): ?>
                                    <span class="or-text"><i>hoặc</i></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>

            <h3 class="section-header">Thông tin về gia đình và giáo xứ</h3>

            <section class="form-section family-info">
                <div class="form-item">
                    <label class="label">1.</label>
                    <div class="content">
                        <label for="father_name">Tên cha:</label>
                        <input type="text" id="father_name" name="father_name" 
                               value="<?php echo htmlspecialchars($candidate['father_name'] ?? ''); ?>">
                        <label for="father_birth_year">năm sinh:</label>
                        <input type="text" id="father_birth_year" name="father_birth_year" 
                               value="<?php echo $candidate['father_birth_year'] ?? ''; ?>" maxlength="4">
                        <label for="father_occupation">nghề nghiệp:</label>
                        <input type="text" id="father_occupation" name="father_occupation" 
                               value="<?php echo htmlspecialchars($candidate['father_occupation'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">2.</label>
                    <div class="content">
                        <label for="mother_name">Tên mẹ:</label>
                        <input type="text" id="mother_name" name="mother_name" 
                               value="<?php echo htmlspecialchars($candidate['mother_name'] ?? ''); ?>">
                        <label for="mother_birth_year">năm sinh:</label>
                        <input type="text" id="mother_birth_year" name="mother_birth_year" 
                               value="<?php echo $candidate['mother_birth_year'] ?? ''; ?>" maxlength="4">
                        <label for="mother_occupation">nghề nghiệp:</label>
                        <input type="text" id="mother_occupation" name="mother_occupation" 
                               value="<?php echo htmlspecialchars($candidate['mother_occupation'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">3.</label>
                    <div class="content">
                        <label for="family_parish">Thuộc Giáo xứ:</label>
                        <input type="text" id="family_parish" name="family_parish" 
                               value="<?php echo htmlspecialchars($candidate['family_parish'] ?? ''); ?>">
                        <label for="family_diocese">Giáo phận:</label>
                        <input type="text" id="family_diocese" name="family_diocese" 
                               value="<?php echo htmlspecialchars($candidate['family_diocese'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">4.</label>
                    <div class="content">
                        <label for="parish_priest">Linh mục Chánh xứ:</label>
                        <input type="text" id="parish_priest" name="parish_priest" 
                               value="<?php echo htmlspecialchars($candidate['parish_priest'] ?? ''); ?>">
                    </div>
                </div>
            </section>

            <div class="form-actions">
                <button type="button" class="submit-btn" onclick="window.location.href='dashboard_registrators.php'">Quay lại</button>
                <button type="submit" class="submit-btn">Lưu thay đổi</button>
            </div>
        </form>
    </div>

    <script src="../js/view_registrator.js"></script>
</body>
</html>