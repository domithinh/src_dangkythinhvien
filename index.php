<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phiếu đăng ký - Thỉnh viện Đa Minh</title>
    <meta name="description" content="Phiếu đăng ký thi tuyển sinh ơn gọi Đa Minh">
    <link rel="stylesheet" href="./user/css/style.css">
</head>

<body>
    <div class="form-container">
        <header class="header">
            <div class="logo">
                <img src="./assets/Logo-thinh-vien-01.jpg" alt="Logo Thỉnh viện">
            </div>
            <div class="institution-info">
                <h2>TỈNH DÒNG NỮ VƯƠNG CÁC THÁNH TỬ ĐẠO VIỆT NAM</h2>
                <h2>THỈNH VIỆN THÁNH GIOAN TÔNG ĐỒ</h2>
                <address>
                    <p>70/1 Tổ 1, Kp. Bình Dương 3, P. An Bình, Tp. Dĩ An, T. Bình Dương.</p>
                    <p>Điện thoại: 0985188795 | Email: thinhviendaminh@gmail.com</p>
                    <p>Website: http://www.thinhviendaminh.net</p>
                </address>
            </div>
        </header>

        <div class="main-title">
            <h1>Phiếu đăng ký</h1>
            <h2>Thi tuyển sinh ơn gọi Đa Minh</h2>
        </div>

        <form action="./user/backend/process_data.php" method="post">
            <!-- Thông tin cá nhân -->
            <section class="form-section personal-info">
                <div class="form-item">
                    <label class="label" for="fullname">1.</label>
                    <div class="content">
                        <label for="fullname">Tên thánh, họ và tên gọi:</label>
                        <input type="text" id="fullname" name="fullname" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">2.</label>
                    <div class="content">
                        <label>Sinh ngày</label>
                        <div class="date-input">
                            <input type="text" id="day" name="day" maxlength="2" required>
                            <span>tháng</span>
                            <input type="text" id="month" name="month" maxlength="2" required>
                            <span>năm</span>
                            <input type="text" id="year" name="year" maxlength="4" required>
                            <span>, tại</span>
                            <input type="text" id="birthplace" name="birthplace" required>
                        </div>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">3.</label>
                    <div class="content">
                        <label for="parish">Thuộc Giáo xứ:</label>
                        <input type="text" id="parish" name="parish" required>
                        <label for="diocese">Giáo phận:</label>
                        <input type="text" id="diocese" name="diocese" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">4.</label>
                    <div class="content">
                        <span>Trình độ học vấn <i>(chọn văn bằng cao nhất)</i>:</span>
                    </div>
                </div>

                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="radio" id="masters" name="education" value="masters">
                        <label for="masters">Thạc sĩ</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="radio" id="bachelor" name="education" value="bachelor">
                        <label for="bachelor">Đại học</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="radio" id="associate" name="education" value="associate">
                        <label for="associate">Cao đẳng</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="radio" id="highschool" name="education" value="highschool">
                        <label for="highschool">Phổ thông Trung học</label>
                    </div>
                    <div class="checkbox-item">
                        <label for="graduationYear">Năm tốt nghiệp:</label>
                        <input type="text" id="graduationYear" name="graduationYear" maxlength="4">
                    </div>
                </div>

                <div class="form-item major-field">
                    <div class="content">
                        <label for="major">Chuyên ngành:</label>
                        <input type="text" id="major" name="major">
                    </div>
                </div>

                <div class="form-item certificate-language">
                    <div class="content">
                        <span>Đã có chứng chỉ</span>
                        <div class="certificate-group">
                            <div class="certificate-item">
                                <input type="checkbox" id="ielts" name="certificate[]" value="ielts">
                                <label for="ielts">IELTS:</label>
                                <input type="text" id="ielts_score" name="ielts_score" aria-label="Điểm IELTS">
                            </div>
                            <div class="certificate-item">
                                <input type="checkbox" id="toefl" name="certificate[]" value="toefl">
                                <label for="toefl">TOEFL:</label>
                                <input type="text" id="toefl_score" name="toefl_score" aria-label="Điểm TOEFL">
                            </div>
                            <div class="certificate-item">
                                <input type="checkbox" id="toeic" name="certificate[]" value="toeic">
                                <label for="toeic">TOEIC:</label>
                                <input type="text" id="toeic_score" name="toeic_score" aria-label="Điểm TOEIC">
                            </div>
                            <div class="certificate-item">
                                <input type="checkbox" id="other" name="certificate[]" value="other">
                                <label for="other">chuyên ngành khác</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">5.</label>
                    <div class="content">
                        <label for="permanent_address">Địa chỉ thường trú <i>(gia đình)</i>:</label>
                        <input type="text" id="permanent_address" name="permanent_address" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">6.</label>
                    <div class="content">
                        <label for="contact_address">Địa chỉ liên lạc <i>(nơi đang cư trú)</i>:</label>
                        <input type="text" id="contact_address" name="contact_address" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">7.</label>
                    <div class="content">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        <label for="phone">Điện thoại:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">8.</label>
                    <div class="content">
                        <label for="previous_vocation">Đã tìm hiểu ơn gọi giáo phận hoặc dòng tu khác <i>(nếu
                                có)</i>:</label>
                        <input type="text" id="previous_vocation" name="previous_vocation">
                    </div>
                </div>

                <div class="form-item">
                    <div class="content indented">
                        <label for="previous_vocation_time">Thời gian đã tìm hiểu:</label>
                        <input type="text" id="previous_vocation_time" name="previous_vocation_time">
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">9.</label>
                    <div class="content">
                        <label for="referrer">Người giới thiệu tìm hiểu ơn gọi Đa Minh:</label>
                        <input type="text" id="referrer" name="referrer">
                    </div>
                </div>

                <div class="form-item">
                    <div class="content indented">
                        <span><i>hoặc</i></span>
                        <div class="checkbox-item">
                            <input type="checkbox" id="self_discovery" name="referral" value="self">
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
                    <div class="checkbox-item-exam">
                        <input type="radio" id="location_da_minh" name="exam_location" value="da_minh">
                        <label for="location_da_minh"><b>Thỉnh Viện Đa Minh</b></label>
                    </div>
                    <div class="checkbox-item-exam">
                        <input type="radio" id="location_north" name="exam_location" value="north">
                        <label for="location_north"><b>Miền Bắc</b></label>
                    </div>
                    <div class="checkbox-item-exam">
                        <input type="radio" id="location_central" name="exam_location" value="central">
                        <label for="location_central"><b>Miền Trung</b></label>
                    </div>
                </div>

                <div class="form-item">
                    <div class="content indented">
                        <span>Ba môn dự thi bắt buộc:</span>
                    </div>
                </div>

                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="subject_catechism" name="subject[]" value="catechism" checked
                            disabled>
                        <label for="subject_religion"><b>Giáo lý</b></label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="subject_vietnamese" name="subject[]" value="vietnamese" checked
                            disabled>
                        <label for="subject_vietnamese"><b>Việt Văn</b></label>
                    </div>
                    <div class="language-choice">
                        <div class="checkbox-item">
                            <input type="radio" id="subject_english" name="language" value="english">
                            <label for="subject_english"><b>Anh Văn</b></label>
                        </div>
                        <span class="or-text"><i>hoặc</i></span>
                        <div class="checkbox-item">
                            <input type="radio" id="subject_french" name="language" value="french">
                            <label for="subject_french"><b>Pháp Văn</b></label>
                        </div>
                        <p class="note"><i>(chọn một trong hai sinh ngữ để thi)</i></p>
                    </div>
                </div>
                <div class="form-item">
                    <div class="content indented">
                        <span>Chọn ngày thi:</span>
                    </div>
                </div>
                <div class="checkbox-group">
                    <div class="checkbox-item-exam">
                        <input type="radio" id="exam_date_one" name="exam_date" value="2025-06-09" required>
                        <label for="exam_date_one"><b>09/06/2025</b></label>
                    </div>
                    <p class="note"><i>hoặc</i></p>
                    <div class="checkbox-item-exam">
                        <input type="radio" id="exam_date_two" name="exam_date" value="2025-06-23">
                        <label for="exam_date_two"><b>23/06/2025</b></label>
                    </div>
                </div>


                <div class="form-item">
                    <label class="label">11.</label>
                    <div class="content">
                        <span>Nguyện vọng là tu sĩ Đa Minh:</span>
                        <div class="aspiration-choices">
                            <input type="radio" id="aspiration_priest" name="aspiration" value="priest" required>
                            <label for="aspiration_priest"><b>Linh mục</b></label>
                            <span class="or-text"><i>hoặc</i></span>
                            <input type="radio" id="aspiration_monk" name="aspiration" value="monk">
                            <label for="aspiration_monk"><b>Tu huynh</b></label>
                        </div>
                    </div>
                </div>
            </section>

            <h3 class="section-header">Thông tin về gia đình và giáo xứ</h3>

            <section class="form-section family-info">
                <div class="form-item">
                    <label class="label">1.</label>
                    <div class="content">
                        <label for="father_name">Tên Thánh, họ và tên cha:</label>
                        <input type="text" id="father_name" name="father_name">
                        <label for="father_birth_year">năm sinh:</label>
                        <input type="text" id="father_birth_year" name="father_birth_year" maxlength="4">
                        <label for="father_occupation">nghề nghiệp:</label>
                        <input type="text" id="father_occupation" name="father_occupation">
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">2.</label>
                    <div class="content">
                        <label for="mother_name">Tên Thánh, họ và tên mẹ:</label>
                        <input type="text" id="mother_name" name="mother_name">
                        <label for="mother_birth_year">năm sinh:</label>
                        <input type="text" id="mother_birth_year" name="mother_birth_year" maxlength="4">
                        <label for="mother_occupation">nghề nghiệp:</label>
                        <input type="text" id="mother_occupation" name="mother_occupation">
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">3.</label>
                    <div class="content">
                        <label for="family_parish">Thuộc Giáo xứ:</label>
                        <input type="text" id="family_parish" name="family_parish">
                        <label for="family_diocese">Giáo phận:</label>
                        <input type="text" id="family_diocese" name="family_diocese">
                    </div>
                </div>

                <div class="form-item">
                    <label class="label">4.</label>
                    <div class="content">
                        <label for="parish_priest">Linh mục Chánh xứ:</label>
                        <input type="text" id="parish_priest" name="parish_priest">
                    </div>
                </div>
            </section>
            <div class="g-recaptcha" data-sitekey="6Ld0agQrAAAAANvFLFdjz-r11bIrRirDbAKcUwri"></div>
            <button type="submit" class="submit-btn">Đăng ký</button>
        </form>
        <!-- Load Google reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="./user/js/script.js"></script>
</body>

</html>