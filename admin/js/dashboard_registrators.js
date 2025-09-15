function searchRegistrations() {
    const input = document.getElementById('searchInput');
    const searchValue = input.value;

    // Lấy các giá trị bộ lọc hiện tại
    const educationFilter = document.getElementById('educationFilter').value;
    const locationFilter = document.getElementById('locationFilter').value;
    const aspirationFilter = document.getElementById('aspirationFilter').value;

    // Tạo URL với tham số tìm kiếm và giữ lại các bộ lọc
    let url = 'dashboard_registrators.php?page=1';

    if (searchValue) {
        url += '&search=' + encodeURIComponent(searchValue);
    }

    if (educationFilter) {
        url += '&education=' + encodeURIComponent(educationFilter);
    }

    if (locationFilter) {
        url += '&location=' + encodeURIComponent(locationFilter);
    }

    if (aspirationFilter) {
        url += '&aspiration=' + encodeURIComponent(aspirationFilter);
    }

    window.location.href = url;
}

function filterRegistrations() {
    const searchValue = document.getElementById('searchInput').value;
    const educationFilter = document.getElementById('educationFilter').value;
    const locationFilter = document.getElementById('locationFilter').value;
    const aspirationFilter = document.getElementById('aspirationFilter').value;

    // Tạo URL với các tham số lọc
    let url = 'dashboard_registrators.php?page=1';

    if (searchValue) {
        url += '&search=' + encodeURIComponent(searchValue);
    }

    if (educationFilter) {
        url += '&education=' + encodeURIComponent(educationFilter);
    }

    if (locationFilter) {
        url += '&location=' + encodeURIComponent(locationFilter);
    }

    if (aspirationFilter) {
        url += '&aspiration=' + encodeURIComponent(aspirationFilter);
    }

    window.location.href = url;
}

function formatEducation(education) {
    const educationMap = {
        'masters': 'Thạc sĩ',
        'bachelor': 'Đại học',
        'associate': 'Cao đẳng',
        'highschool': 'Phổ thông Trung học'
    };

    return educationMap[education] || education;
}

function getExamLocation(location) {
    const locationMap = {
        'da_minh': 'Thỉnh Viện Đa Minh',
        'north': 'Miền Bắc',
        'central': 'Miền Trung'
    };

    return locationMap[location] || location;
}

// Xử lý phân trang và duy trì các tham số
function updatePaginationLinks() {
    const paginationLinks = document.querySelectorAll('.pagination a');
    const searchValue = document.getElementById('searchInput').value;
    const educationFilter = document.getElementById('educationFilter').value;
    const locationFilter = document.getElementById('locationFilter').value;
    const aspirationFilter = document.getElementById('aspirationFilter').value;

    paginationLinks.forEach(function(link) {
        let href = link.getAttribute('href');

        // Thêm các tham số vào link phân trang
        if (searchValue && !href.includes('search=')) {
            href += '&search=' + encodeURIComponent(searchValue);
        }

        if (educationFilter && !href.includes('education=')) {
            href += '&education=' + encodeURIComponent(educationFilter);
        }

        if (locationFilter && !href.includes('location=')) {
            href += '&location=' + encodeURIComponent(locationFilter);
        }

        if (aspirationFilter && !href.includes('aspiration=')) {
            href += '&aspiration=' + encodeURIComponent(aspirationFilter);
        }

        link.setAttribute('href', href);
    });
}

// Xử lý xác nhận xóa
document.addEventListener('DOMContentLoaded', function() {
    var confirmModal = document.getElementById('confirmDeleteModal');

    // Thêm event listener cho phím Enter ở ô tìm kiếm
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchRegistrations();
        }
    });

    // Xác nhận trước khi xóa
    var deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            confirmModal.style.display = 'block';

            var confirmBtn = document.getElementById('confirmDelete');
            var cancelBtn = document.getElementById('cancelDelete');
            var deleteUrl = this.getAttribute('href');

            confirmBtn.onclick = function() {
                window.location.href = deleteUrl;
                confirmModal.style.display = 'none';
            }

            cancelBtn.onclick = function() {
                confirmModal.style.display = 'none';
            }

            // Đóng modal khi nhấp ra ngoài modal
            window.onclick = function(event) {
                if (event.target == confirmModal) {
                    confirmModal.style.display = 'none';
                }
            }
        });
    });

    // Cập nhật các link phân trang với các tham số lọc và tìm kiếm
    updatePaginationLinks();
});