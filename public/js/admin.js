// Image preview functionality
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var preview = $(input).siblings('.image-preview');
            if (preview.length === 0) {
                preview = $('<img class="image-preview">');
                $(input).after(preview);
            }
            preview.attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Initialize image preview
$(document).on('change', 'input[type="file"]', function() {
    readURL(this);
});

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

// Confirm delete
$(document).on('submit', 'form[data-confirm]', function(e) {
    if (!confirm($(this).data('confirm'))) {
        e.preventDefault();
    }
});

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    $('.alert').alert('close');
}, 5000);

// Active menu item
$(document).ready(function() {
    var currentUrl = window.location.pathname;
    $('.nav-link').each(function() {
        if ($(this).attr('href') === currentUrl) {
            $(this).addClass('active');
        }
    });
});

// Number format
function formatNumber(number) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
}

// Search functionality
$(document).ready(function() {
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#dataTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
}); 