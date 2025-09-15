document.addEventListener('DOMContentLoaded', function() {
    // Lấy reference đến form
    const form = document.querySelector('form');

    // Xử lý các trường ngày tháng năm
    const dayInput = document.getElementById('day');
    const monthInput = document.getElementById('month');
    const yearInput = document.getElementById('year');

    // Đảm bảo chỉ nhập số cho các trường ngày tháng năm
    const numericInputs = [dayInput, monthInput, yearInput,
        document.getElementById('graduationYear'),
        document.getElementById('father_birth_year'),
        document.getElementById('mother_birth_year')
    ];

    numericInputs.forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
    });

    // Tự động focus vào trường tiếp theo khi nhập đủ ký tự
    dayInput.addEventListener('input', function() {
        if (this.value.length >= 2) {
            monthInput.focus();
        }
    });

    monthInput.addEventListener('input', function() {
        if (this.value.length >= 2) {
            yearInput.focus();
        }
    });

    // Xử lý các trường chứng chỉ
    const certificateCheckboxes = document.querySelectorAll('input[name="certificate[]"]');
    const certificateScores = [
        document.getElementById('ielts_score'),
        document.getElementById('toefl_score'),
        document.getElementById('toeic_score')
    ];

    // Chỉ cho phép nhập điểm khi checkbox tương ứng được chọn
    certificateCheckboxes.forEach((checkbox, index) => {
        if (checkbox && index < 3) { // Chỉ xử lý 3 checkbox đầu tiên (IELTS, TOEFL, TOEIC)
            checkbox.addEventListener('change', function() {
                if (certificateScores[index]) {
                    certificateScores[index].disabled = !this.checked;
                    if (!this.checked) {
                        certificateScores[index].value = '';
                    } else {
                        certificateScores[index].focus();
                    }
                }
            });

            // Khởi tạo ban đầu
            if (certificateScores[index]) {
                certificateScores[index].disabled = !checkbox.checked;
            }
        }
    });

    // Xử lý radio button của Nguyện vọng
    const aspirationOptions = document.querySelectorAll('input[name="aspiration"]');

    // Xử lý radio button của Địa điểm thi
    const examLocationOptions = document.querySelectorAll('input[name="exam_location"]');

    // Xử lý radio button của Ngày thi
    const examDateOptions = document.querySelectorAll('input[name="exam_date"]');

    // Xử lý sự kiện cho các radio button ngày thi
    examDateOptions.forEach(option => {
        option.addEventListener('change', function() {
            // Bỏ class error nếu đã chọn ngày thi
            const examDateGroup = this.closest('.checkbox-group');
            if (examDateGroup) {
                examDateGroup.classList.remove('error');
            }
        });
    });

    // Xử lý checkbox "tự tìm hiểu"
    const selfDiscoveryCheckbox = document.getElementById('self_discovery');
    const referrerInput = document.getElementById('referrer');

    if (selfDiscoveryCheckbox && referrerInput) {
        selfDiscoveryCheckbox.addEventListener('change', function() {
            referrerInput.disabled = this.checked;
            if (this.checked) {
                referrerInput.value = '';
            } else {
                referrerInput.focus();
            }
        });
    }

    // Hiển thị/ẩn trường Chuyên ngành dựa trên trình độ học vấn
    // Hiển thị/ẩn trường Chuyên ngành dựa trên trình độ học vấn
    const educationOptions = document.querySelectorAll('input[name="education"]');
    const majorField = document.querySelector('.major-field');
    const majorInput = document.getElementById('major');
    const graduationYearInput = document.getElementById('graduationYear');

    educationOptions.forEach(option => {
        option.addEventListener('change', function() {
            // Hiển thị trường chuyên ngành chỉ khi chọn Thạc sĩ, Đại học hoặc Cao đẳng
            if (this.value === 'masters' || this.value === 'bachelor' || this.value === 'associate') {
                majorField.style.display = 'flex';
                majorInput.required = true;
            } else {
                majorField.style.display = 'none';
                majorInput.required = false;
                majorInput.value = '';
            }

            // Tự động focus vào năm tốt nghiệp khi chọn trình độ học vấn
            if (graduationYearInput) {
                graduationYearInput.focus();
            }
        });
    });


    // Lấy reference đến các trường thông tin của bố mẹ
    const fatherNameInput = document.getElementById('father_name');
    const motherNameInput = document.getElementById('mother_name');
    const fatherBirthYearInput = document.getElementById('father_birth_year');
    const motherBirthYearInput = document.getElementById('mother_birth_year');

    // Kiểm tra và xử lý thông tin của bố
    if (fatherNameInput) {
        fatherNameInput.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
    }

    // Kiểm tra và xử lý thông tin của mẹ
    if (motherNameInput) {
        motherNameInput.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
    }

    if (fatherBirthYearInput) {
        fatherBirthYearInput.addEventListener('blur', function() {
            // Kiểm tra năm sinh hợp lệ (không quá trẻ hoặc quá già)
            const year = parseInt(this.value);
            const currentYear = new Date().getFullYear();
            if (year > currentYear - 18 || year < currentYear - 100) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
    }

    if (motherBirthYearInput) {
        motherBirthYearInput.addEventListener('blur', function() {
            // Kiểm tra năm sinh hợp lệ (không quá trẻ hoặc quá già)
            const year = parseInt(this.value);
            const currentYear = new Date().getFullYear();
            if (year > currentYear - 18 || year < currentYear - 100) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
    }

    // Tự động điền giáo xứ của gia đình nếu trường địa chỉ thường trú có chứa tên giáo xứ
    const permanentAddressInput = document.getElementById('permanent_address');

    if (permanentAddressInput && familyParishInput) {
        permanentAddressInput.addEventListener('blur', function() {
            // Kiểm tra xem trong địa chỉ có chứa "Giáo xứ" hoặc "GX" không
            const addressText = this.value.toLowerCase();
            if ((addressText.includes('giáo xứ') || addressText.includes('gx')) && !familyParishInput.value) {
                // Tìm tên giáo xứ trong địa chỉ
                let match = addressText.match(/giáo xứ\s+([^,]+)/i);
                if (!match) {
                    match = addressText.match(/gx\s+([^,]+)/i);
                }

                if (match && match[1]) {
                    const suggestion = match[1].trim();
                    if (confirm(`Phát hiện Giáo xứ "${suggestion}" trong địa chỉ. Bạn có muốn điền thông tin này vào trường Giáo xứ gia đình không?`)) {
                        familyParishInput.value = suggestion.charAt(0).toUpperCase() + suggestion.slice(1);
                    }
                }
            }
        });
    }

    // Xác nhận trước khi gửi form
    form.addEventListener('submit', function(event) {
        // Kiểm tra các trường bắt buộc
        const requiredFields = form.querySelectorAll('[required]');
        let allFilled = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                allFilled = false;
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        });

        // Kiểm tra đã chọn ngôn ngữ thi
        const languageSelected = document.querySelector('input[name="language"]:checked');
        if (!languageSelected) {
            allFilled = false;
            document.querySelector('.language-choice').classList.add('error');
        } else {
            document.querySelector('.language-choice').classList.remove('error');
        }

        // Kiểm tra đã chọn địa điểm thi
        const locationSelected = document.querySelector('input[name="exam_location"]:checked');
        if (!locationSelected) {
            allFilled = false;
            document.querySelector('.checkbox-group').classList.add('error');
        } else {
            document.querySelector('.checkbox-group').classList.remove('error');
        }

        // Kiểm tra đã chọn ngày thi
        const dateSelected = document.querySelector('input[name="exam_date"]:checked');
        const examDateGroup = document.querySelector('.checkbox-group:has(input[name="exam_date"])');

        if (!dateSelected) {
            if (examDateGroup) {
                examDateGroup.classList.add('error');
            }
            allFilled = false;
            alert('Vui lòng chọn ngày thi.');
        } else {
            if (examDateGroup) {
                examDateGroup.classList.remove('error');
            }
        }

        // Kiểm tra định dạng email
        const emailInput = document.getElementById('email');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput.value && !emailPattern.test(emailInput.value)) {
            allFilled = false;
            emailInput.classList.add('error');
            alert('Vui lòng nhập đúng định dạng email.');
        }

        // Kiểm tra định dạng ngày tháng
        if (dayInput.value && (parseInt(dayInput.value) < 1 || parseInt(dayInput.value) > 31)) {
            allFilled = false;
            dayInput.classList.add('error');
            alert('Vui lòng nhập ngày hợp lệ (1-31).');
        }

        if (monthInput.value && (parseInt(monthInput.value) < 1 || parseInt(monthInput.value) > 12)) {
            allFilled = false;
            monthInput.classList.add('error');
            alert('Vui lòng nhập tháng hợp lệ (1-12).');
        }

        if (yearInput.value && (yearInput.value.length !== 4 || parseInt(yearInput.value) < 1950 || parseInt(yearInput.value) > new Date().getFullYear())) {
            allFilled = false;
            yearInput.classList.add('error');
            alert('Vui lòng nhập năm sinh hợp lệ.');
        }

        // Kiểm tra thông tin cha
        if (fatherNameInput && !fatherNameInput.value.trim()) {
            allFilled = false;
            fatherNameInput.classList.add('error');
            alert('Vui lòng nhập tên của cha.');
        }

        // Kiểm tra thông tin mẹ
        if (motherNameInput && !motherNameInput.value.trim()) {
            allFilled = false;
            motherNameInput.classList.add('error');
            alert('Vui lòng nhập tên của mẹ.');
        }

        // Kiểm tra năm sinh của bố
        if (fatherBirthYearInput && fatherBirthYearInput.value) {
            const fatherYear = parseInt(fatherBirthYearInput.value);
            const currentYear = new Date().getFullYear();
            if (fatherYear > currentYear - 18 || fatherYear < currentYear - 100) {
                allFilled = false;
                fatherBirthYearInput.classList.add('error');
                alert('Năm sinh của cha không hợp lệ.');
            }
        }

        // Kiểm tra năm sinh của mẹ
        if (motherBirthYearInput && motherBirthYearInput.value) {
            const motherYear = parseInt(motherBirthYearInput.value);
            const currentYear = new Date().getFullYear();
            if (motherYear > currentYear - 18 || motherYear < currentYear - 100) {
                allFilled = false;
                motherBirthYearInput.classList.add('error');
                alert('Năm sinh của mẹ không hợp lệ.');
            }
        }

        // Ngăn gửi form nếu có lỗi
        if (!allFilled) {
            event.preventDefault();
            alert('Vui lòng điền đầy đủ thông tin bắt buộc và sửa các lỗi.');
            window.scrollTo(0, 0);
        } else {
            // Xác nhận trước khi gửi
            if (!confirm('Bạn đã kiểm tra kỹ thông tin và muốn gửi đơn đăng ký?')) {
                event.preventDefault();
            }
        }
    });

    // Hiển thị hướng dẫn khi focus vào các trường
    const formInputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"]');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.classList.remove('focused');

            // Kiểm tra và hiển thị lỗi khi rời khỏi trường bắt buộc
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
    });
});