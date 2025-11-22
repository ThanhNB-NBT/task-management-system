// ===== Main JavaScript ===== 

$(document).ready(function() {
    // Initialize tooltips and popovers
    initializeTooltips();
    
    // Form validation
    initializeFormValidation();
    
    // Event listeners
    setupEventListeners();
    
    // Initialize charts if needed
    initializeCharts();
});

// ===== Tooltips & Popovers =====
function initializeTooltips() {
    // Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// ===== Form Validation =====
function initializeFormValidation() {
    // Bootstrap form validation
    var forms = document.querySelectorAll('.needs-validation');
    
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}

// ===== Event Listeners =====
function setupEventListeners() {
    // Login form
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        
        if (email && password) {
            // Simulate login
            console.log('Login attempt:', email);
            // Redirect based on role (in real app, this would be from server)
            // window.location.href = 'member-dashboard.html';
            alert('Đăng nhập thành công!');
        }
    });
    
    // Filter buttons
    $('#statusFilter, #priorityFilter, #projectFilter, #searchInput').on('change keyup', function() {
        filterTasks();
    });
    
    // Modal events
    $('#createProjectModal, #editProjectModal, #createTaskModal').on('show.bs.modal', function() {
        // Reset form if needed
    });
    
    // Delete confirmations
    $('.btn-outline-danger').on('click', function(e) {
        if (!confirm('Bạn có chắc chắn muốn xóa?')) {
            e.preventDefault();
        }
    });
}

// ===== Filter Tasks =====
function filterTasks() {
    var status = $('#statusFilter').val();
    var priority = $('#priorityFilter').val();
    var project = $('#projectFilter').val();
    var search = $('#searchInput').val().toLowerCase();
    
    $('.task-item, .task-card').each(function() {
        var show = true;
        
        // Filter logic here
        if (status && !$(this).data('status').includes(status)) {
            show = false;
        }
        if (priority && !$(this).data('priority').includes(priority)) {
            show = false;
        }
        if (project && !$(this).data('project').includes(project)) {
            show = false;
        }
        if (search && !$(this).text().toLowerCase().includes(search)) {
            show = false;
        }
        
        $(this).toggle(show);
    });
}

// ===== Charts Initialization =====
function initializeCharts() {
    // Initialize any charts here
    // Example: Chart.js, ApexCharts, etc.
}

// ===== Utility Functions =====

// Format date
function formatDate(date) {
    var d = new Date(date);
    var month = '' + (d.getMonth() + 1);
    var day = '' + d.getDate();
    var year = d.getFullYear();
    
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    
    return [day, month, year].join('/');
}

// Format time
function formatTime(date) {
    var d = new Date(date);
    var hours = '' + d.getHours();
    var minutes = '' + d.getMinutes();
    
    if (hours.length < 2) hours = '0' + hours;
    if (minutes.length < 2) minutes = '0' + minutes;
    
    return [hours, minutes].join(':');
}

// Show notification
function showNotification(message, type = 'info') {
    var alertClass = 'alert-' + type;
    var alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').prepend(alertHtml);
    
    // Auto dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut(function() {
            $(this).remove();
        });
    }, 5000);
}

// Confirm action
function confirmAction(message) {
    return confirm(message);
}

// Get URL parameters
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// ===== API Calls (Mock) =====

// Get tasks
function getTasks(filters = {}) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                data: []
            });
        }, 500);
    });
}

// Create task
function createTask(taskData) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                message: 'Tạo công việc thành công'
            });
        }, 500);
    });
}

// Update task
function updateTask(taskId, taskData) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                message: 'Cập nhật công việc thành công'
            });
        }, 500);
    });
}

// Delete task
function deleteTask(taskId) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                message: 'Xóa công việc thành công'
            });
        }, 500);
    });
}

// Get projects
function getProjects(filters = {}) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                data: []
            });
        }, 500);
    });
}

// Create project
function createProject(projectData) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                message: 'Tạo dự án thành công'
            });
        }, 500);
    });
}

// Update project
function updateProject(projectId, projectData) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                message: 'Cập nhật dự án thành công'
            });
        }, 500);
    });
}

// Delete project
function deleteProject(projectId) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                message: 'Xóa dự án thành công'
            });
        }, 500);
    });
}

// Get users
function getUsers(filters = {}) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                data: []
            });
        }, 500);
    });
}

// Create user
function createUser(userData) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                message: 'Tạo user thành công'
            });
        }, 500);
    });
}

// Update user
function updateUser(userId, userData) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                message: 'Cập nhật user thành công'
            });
        }, 500);
    });
}

// Delete user
function deleteUser(userId) {
    return new Promise(function(resolve, reject) {
        // Mock API call
        setTimeout(function() {
            resolve({
                success: true,
                message: 'Xóa user thành công'
            });
        }, 500);
    });
}

// ===== Local Storage =====

// Save to localStorage
function saveToStorage(key, value) {
    localStorage.setItem(key, JSON.stringify(value));
}

// Get from localStorage
function getFromStorage(key) {
    var value = localStorage.getItem(key);
    return value ? JSON.parse(value) : null;
}

// Remove from localStorage
function removeFromStorage(key) {
    localStorage.removeItem(key);
}

// Clear localStorage
function clearStorage() {
    localStorage.clear();
}

// ===== Session Management =====

// Check if user is logged in
function isLoggedIn() {
    return getFromStorage('user') !== null;
}

// Get current user
function getCurrentUser() {
    return getFromStorage('user');
}

// Set current user
function setCurrentUser(user) {
    saveToStorage('user', user);
}

// Logout
function logout() {
    removeFromStorage('user');
    removeFromStorage('token');
    window.location.href = 'index.html';
}

// ===== Export Functions =====
window.formatDate = formatDate;
window.formatTime = formatTime;
window.showNotification = showNotification;
window.confirmAction = confirmAction;
window.getUrlParameter = getUrlParameter;
window.getTasks = getTasks;
window.createTask = createTask;
window.updateTask = updateTask;
window.deleteTask = deleteTask;
window.getProjects = getProjects;
window.createProject = createProject;
window.updateProject = updateProject;
window.deleteProject = deleteProject;
window.getUsers = getUsers;
window.createUser = createUser;
window.updateUser = updateUser;
window.deleteUser = deleteUser;
window.saveToStorage = saveToStorage;
window.getFromStorage = getFromStorage;
window.removeFromStorage = removeFromStorage;
window.clearStorage = clearStorage;
window.isLoggedIn = isLoggedIn;
window.getCurrentUser = getCurrentUser;
window.setCurrentUser = setCurrentUser;
window.logout = logout;
