// GenZ Dashboard Core JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializeGenZDashboard();
});

function initializeGenZDashboard() {
    // Initialize tab functionality
    initializeTabs();
    
    // Initialize task toggles
    initializeTaskToggles();
    
    // Initialize time displays
    initializeTimeDisplays();
    
    // Initialize animations
    initializeAnimations();
    
    // Initialize hover effects
    initializeHoverEffects();
}

// Tab Functionality
function initializeTabs() {
    const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('data-bs-target');
            const targetPane = document.querySelector(targetId);
            
            if (!targetPane) return;
            
            // Remove active class from all tabs and panes
            document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active', 'show'));
            
            // Add active class to clicked tab and corresponding pane
            this.classList.add('active');
            targetPane.classList.add('active', 'show');
        });
    });
}

// Task Toggle Functionality
function initializeTaskToggles() {
    const checkboxes = document.querySelectorAll('.task-checkbox');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskId = this.dataset.taskId;
            
            if (!taskId || !csrfToken) return;
            
            // Add loading state
            const taskItem = this.closest('.task-item');
            if (taskItem) {
                taskItem.classList.add('loading');
            }
            
            fetch(`/tasks/${taskId}/toggle`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success animation
                    if (taskItem) {
                        taskItem.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            taskItem.style.transform = 'scale(1)';
                        }, 200);
                    }
                    
                    // Reload after a short delay to show the animation
                    setTimeout(() => {
                        window.location.reload();
                    }, 300);
                } else {
                    throw new Error('Update failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked;
                
                // Remove loading state
                if (taskItem) {
                    taskItem.classList.remove('loading');
                }
                
                // Show error notification
                showNotification('Failed to update task status. Please try again.', 'error');
            });
        });
    });
}

// Time Display Updates
function initializeTimeDisplays() {
    updateCurrentTime();
    updateSidebarTime();
    
    // Update every minute
    setInterval(() => {
        updateCurrentTime();
        updateSidebarTime();
    }, 60000);
}

function updateCurrentTime() {
    const timeElement = document.getElementById('current-time');
    if (!timeElement) return;
    
    const now = new Date();
    const hours = now.getHours();
    const ampm = hours >= 12 ? 'PM' : 'AM';
    const displayHours = hours % 12 || 12;
    const minutes = now.getMinutes().toString().padStart(2, '0');
    
    timeElement.textContent = `${displayHours}:${minutes} ${ampm}`;
}

function updateSidebarTime() {
    const timeEl = document.getElementById('currentTime');
    const dateEl = document.getElementById('currentDate');
    
    if (!timeEl) return;
    
    const now = new Date();
    
    // Update time
    timeEl.textContent = now.toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
    
    // Update date if element exists
    if (dateEl) {
        dateEl.textContent = now.toLocaleDateString('en-US', { 
            weekday: 'long', 
            month: 'long', 
            day: 'numeric' 
        });
    }
    
    // Update task statuses for daily tasks
    updateTaskStatuses(now);
}

function updateTaskStatuses(now) {
    const currentTime = now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();
    
    const statusConfig = {
        ongoing: {
            class: 'task-ongoing',
            html: `
                <span class="badge bg-success pulse-animation">
                    <i class="lucide-play"></i> In Progress
                </span>`
        },
        upcoming: {
            class: 'task-upcoming',
            html: `
                <span class="badge bg-info">
                    <i class="lucide-clock"></i> Upcoming
                </span>`
        },
        past: {
            class: 'task-past',
            html: `
                <span class="badge bg-danger">
                    <i class="lucide-alert-triangle"></i> Missed
                </span>`
        }
    };
    
    document.querySelectorAll('.task-item').forEach(taskItem => {
        const startTime = taskItem.dataset.startTime;
        const endTime = taskItem.dataset.endTime;
        const statusBadge = taskItem.querySelector('.task-status-badge');
        
        if (!startTime || !endTime || !statusBadge) return;
        
        const [startH, startM] = startTime.split(':').map(Number);
        const [endH, endM] = endTime.split(':').map(Number);
        const startSeconds = startH * 3600 + startM * 60;
        const endSeconds = endH * 3600 + endM * 60;
        
        // Determine status
        let status;
        if (currentTime >= startSeconds && currentTime <= endSeconds) {
            status = 'ongoing';
        } else if (currentTime < startSeconds) {
            status = 'upcoming';
        } else {
            status = 'past';
        }
        
        // Update UI
        taskItem.className = taskItem.className
            .replace(/\b(task-ongoing|task-upcoming|task-past)\b/g, '')
            .trim();
        taskItem.classList.add(statusConfig[status].class);
        statusBadge.innerHTML = statusConfig[status].html;
    });
}

// Animation Initializations
function initializeAnimations() {
    // Add entrance animations to cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all cards
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        observer.observe(card);
    });
}

// Hover Effects
function initializeHoverEffects() {
    // Add glow effect to buttons on hover
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add parallax effect to quote cards
    document.querySelectorAll('.quote-card').forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
        });
    });
}

// Notification System
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="lucide-${getNotificationIcon(type)}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close">
            <i class="lucide-x"></i>
        </button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'error' ? 'var(--neon-orange)' : 'var(--secondary-gradient)'};
        color: var(--bg-primary);
        padding: var(--space-md);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-lg);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: var(--space-md);
        min-width: 300px;
        animation: slideInRight 0.3s ease;
    `;
    
    // Add to DOM
    document.body.appendChild(notification);
    
    // Add close functionality
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

function getNotificationIcon(type) {
    switch(type) {
        case 'error': return 'alert-circle';
        case 'success': return 'check-circle';
        case 'warning': return 'alert-triangle';
        default: return 'info';
    }
}

// Add CSS animations dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        flex: 1;
    }
    
    .notification-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: var(--space-xs);
        border-radius: var(--radius-sm);
        transition: var(--transition-fast);
    }
    
    .notification-close:hover {
        background: rgba(0, 0, 0, 0.1);
    }
`;
document.head.appendChild(style);

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Add smooth scroll behavior
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Initialize Lucide icons if available
if (typeof lucide !== 'undefined') {
    lucide.createIcons();
}
