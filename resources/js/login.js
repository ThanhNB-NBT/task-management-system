// ===== Login Page JavaScript =====

$(document).ready(function() {
    // Form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        var email = $('#email').val().trim();
        var password = $('#password').val().trim();
        var remember = $('#remember').is(':checked');
        
        // Validation
        if (!email || !password) {
            showAlert('Vui lòng nhập email và mật khẩu', 'danger');
            return;
        }
        
        if (!isValidEmail(email)) {
            showAlert('Email không hợp lệ', 'danger');
            return;
        }
        
        // Simulate login
        performLogin(email, password, remember);
    });
    
    // Enter key to submit
    $('#password').on('keypress', function(e) {
        if (e.which == 13) {
            $('#loginForm').submit();
        }
    });
});

// Validate email
function isValidEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Perform login
function performLogin(email, password, remember) {
    // Show loading state
    var $btn = $('button[type="submit"]');
    var originalText = $btn.html();
    $btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Đang đăng nhập...').prop('disabled', true);
    
    // Simulate API call
    setTimeout(function() {
        // Mock authentication
        var users = {
            'admin@example.com': { role: 'admin', name: 'Admin', password: 'admin123' },
            'leader@example.com': { role: 'leader', name: 'Trần Thị B', password: 'leader123' },
            'member@example.com': { role: 'member', name: 'Nguyễn Văn A', password: 'member123' }
        };
        
        if (users[email] && users[email].password === password) {
            // Login successful
            var user = {
                email: email,
                name: users[email].name,
                role: users[email].role,
                loginTime: new Date().toISOString()
            };
            
            // Save to localStorage
            localStorage.setItem('user', JSON.stringify(user));
            localStorage.setItem('token', 'mock_token_' + Date.now());
            
            if (remember) {
                localStorage.setItem('rememberEmail', email);
            }
            
            // Redirect based on role
            var redirectUrl = 'member-dashboard.html';
            if (user.role === 'admin') {
                redirectUrl = 'admin-dashboard.html';
            } else if (user.role === 'leader') {
                redirectUrl = 'leader-dashboard.html';
            }
            
            showAlert('Đăng nhập thành công! Đang chuyển hướng...', 'success');
            
            setTimeout(function() {
                window.location.href = redirectUrl;
            }, 1500);
        } else {
            // Login failed
            showAlert('Email hoặc mật khẩu không chính xác', 'danger');
            $btn.html(originalText).prop('disabled', false);
        }
    }, 1000);
}

// Show alert
function showAlert(message, type) {
    var alertClass = 'alert-' + type;
    var alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Remove existing alerts
    $('.alert').remove();
    
    // Add new alert
    $('#loginForm').before(alertHtml);
    
    // Auto dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut(function() {
            $(this).remove();
        });
    }, 5000);
}

// Check if user is already logged in
$(window).on('load', function() {
    var user = localStorage.getItem('user');
    if (user) {
        var userData = JSON.parse(user);
        var redirectUrl = 'member-dashboard.html';
        if (userData.role === 'admin') {
            redirectUrl = 'admin-dashboard.html';
        } else if (userData.role === 'leader') {
            redirectUrl = 'leader-dashboard.html';
        }
        window.location.href = redirectUrl;
    }
    
    // Check for remembered email
    var rememberEmail = localStorage.getItem('rememberEmail');
    if (rememberEmail) {
        $('#email').val(rememberEmail);
        $('#remember').prop('checked', true);
    }
});

// Demo credentials hint
console.log('Demo Credentials:');
console.log('Admin: admin@example.com / admin123');
console.log('Leader: leader@example.com / leader123');
console.log('Member: member@example.com / member123');
