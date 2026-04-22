<!-- Modern Chat Widget -->
<div id="chatWidget" class="chat-widget">
    <!-- Chat Toggle Button -->
    <button id="chatToggleBtn" class="chat-toggle-btn" aria-label="Toggle chat">
        <i class="bi bi-chat-dots-fill"></i>
        @if(config('services.gemini.enabled'))
            <span class="ai-badge">AI</span>
        @endif
    </button>
    
    <!-- Chat Window -->
    <div id="chatWindow" class="chat-window">
        <!-- Header -->
        <div class="chat-window-header">
            <div style="display: flex; align-items: center;">
                <div style="width: 32px; height: 32px; background: #0d6efd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                    <i class="bi bi-robot" style="color: white; font-size: 14px;"></i>
                </div>
                <div>
                    <h6 style="margin: 0; font-size: 14px; font-weight: 600;">
                        DailyDrive Assistant
                        @if(config('services.gemini.enabled'))
                            <span style="background: #ffc107; color: #000; padding: 2px 6px; border-radius: 8px; font-size: 10px; margin-left: 6px; font-weight: 600;">✨ AI</span>
                        @endif
                    </h6>
                    <small style="color: rgba(255,255,255,0.8); font-size: 12px;">Always here to help</small>
                </div>
            </div>
            <button id="chatCloseBtn" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <!-- Messages -->
        <div id="widgetChatMessages" class="chat-window-messages">
            <div class="welcome-message">
                <div style="text-align: center;">
                    <i class="bi bi-robot" style="font-size: 32px; color: #0d6efd; margin-bottom: 12px;"></i>
                    <p style="margin: 8px 0; line-height: 1.5;">
                        Hi! I'm your DailyDrive assistant
                        @if(config('services.gemini.enabled'))
                            powered by Google Gemini AI ✨
                        @endif
                        <br>How can I help you today?
                    </p>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; margin-top: 16px;">
                        <button class="btn btn-sm btn-outline-primary widget-quick-cmd" data-command="tasks today">
                            📝 Today's Tasks
                        </button>
                        <button class="btn btn-sm btn-outline-primary widget-quick-cmd" data-command="quote">
                            🌟 Quote
                        </button>
                        <button class="btn btn-sm btn-outline-primary widget-quick-cmd" data-command="goals">
                            🎯 Goals
                        </button>
                        <button class="btn btn-sm btn-outline-primary widget-quick-cmd" data-command="help">
                            ❓ Help
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Input -->
        <div class="chat-window-footer">
            <form id="widgetChatForm" class="chat-window-form">
                @csrf
                <input 
                    type="text" 
                    id="widgetMessageInput" 
                    class="chat-window-input" 
                    placeholder="@if(config('services.gemini.enabled'))Ask me anything...@else Type a message...@endif"
                    autocomplete="off"
                >
                <button type="submit" class="chat-window-send-btn">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const chatToggleBtn = document.getElementById('chatToggleBtn');
    const chatWindow = document.getElementById('chatWindow');
    const chatCloseBtn = document.getElementById('chatCloseBtn');
    const widgetChatForm = document.getElementById('widgetChatForm');
    const widgetMessageInput = document.getElementById('widgetMessageInput');
    const widgetChatMessages = document.getElementById('widgetChatMessages');
    const widgetQuickCmds = document.querySelectorAll('.widget-quick-cmd');
    
    let isTyping = false;
    
    // Toggle chat window
    chatToggleBtn.addEventListener('click', function() {
        const isVisible = chatWindow.classList.contains('visible');
        
        if (isVisible) {
            chatWindow.classList.remove('visible');
        } else {
            chatWindow.classList.add('visible');
            setTimeout(() => widgetMessageInput.focus(), 300); // Focus after animation
        }
    });
    
    // Close chat window
    chatCloseBtn.addEventListener('click', function() {
        chatWindow.classList.remove('visible');
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && chatWindow.classList.contains('visible')) {
            chatWindow.classList.remove('visible');
        }
    });
    
    // Add message to chat
    function addMessage(message, isUser = false, aiPowered = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `widget-message ${isUser ? 'user' : 'bot'}`;
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'widget-message-content';
        contentDiv.textContent = message;
        
        const timeDiv = document.createElement('div');
        timeDiv.className = 'widget-message-time';
        const timeText = new Date().toLocaleTimeString('en-US', { 
            hour: 'numeric', 
            minute: '2-digit', 
            hour12: true 
        });
        
        if (!isUser && aiPowered) {
            timeDiv.innerHTML = timeText + ' <span class="ai-indicator">✨ AI</span>';
        } else {
            timeDiv.textContent = timeText;
        }
        
        messageDiv.appendChild(contentDiv);
        messageDiv.appendChild(timeDiv);
        
        // Remove welcome message on first user message
        const welcomeMsg = widgetChatMessages.querySelector('.welcome-message');
        if (welcomeMsg && isUser) {
            welcomeMsg.style.opacity = '0';
            setTimeout(() => welcomeMsg.remove(), 300);
        }
        
        widgetChatMessages.appendChild(messageDiv);
        
        // Smooth scroll to bottom
        setTimeout(() => {
            widgetChatMessages.scrollTo({
                top: widgetChatMessages.scrollHeight,
                behavior: 'smooth'
            });
        }, 100);
    }
    
    // Show typing indicator
    function showTypingIndicator() {
        const existing = document.getElementById('typingIndicator');
        if (existing) return;
        
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typingIndicator';
        typingDiv.className = 'widget-message bot';
        typingDiv.innerHTML = `
            <div class="widget-message-content">
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        `;
        widgetChatMessages.appendChild(typingDiv);
        
        setTimeout(() => {
            widgetChatMessages.scrollTo({
                top: widgetChatMessages.scrollHeight,
                behavior: 'smooth'
            });
        }, 100);
    }
    
    // Remove typing indicator
    function hideTypingIndicator() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) {
            indicator.style.opacity = '0';
            setTimeout(() => indicator.remove(), 300);
        }
    }
    
    // Handle form submission
    widgetChatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = widgetMessageInput.value.trim();
        if (!message || isTyping) return;
        
        // Add user message
        addMessage(message, true);
        widgetMessageInput.value = '';
        isTyping = true;
        
        // Show typing indicator
        showTypingIndicator();
        
        try {
            const response = await fetch('{{ route("chat.message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });
            
            const data = await response.json();
            
            // Remove typing indicator
            hideTypingIndicator();
            
            if (data.success) {
                addMessage(data.response, false, data.ai_powered || false);
                
                // Add action links if present
                if (data.links && data.links.length > 0) {
                    setTimeout(() => {
                        const linksDiv = document.createElement('div');
                        linksDiv.className = 'widget-message bot';
                        linksDiv.innerHTML = `
                            <div class="widget-message-content">
                                ${data.links.map(link => 
                                    `<a href="${link.url}" style="display: inline-block; margin: 4px; padding: 6px 12px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 12px; text-decoration: none; color: #495057; font-size: 12px;">${link.text}</a>`
                                ).join('')}
                            </div>
                        `;
                        widgetChatMessages.appendChild(linksDiv);
                        
                        setTimeout(() => {
                            widgetChatMessages.scrollTo({
                                top: widgetChatMessages.scrollHeight,
                                behavior: 'smooth'
                            });
                        }, 100);
                    }, 500);
                }
            } else {
                addMessage('Sorry, something went wrong. Please try again.', false);
            }
        } catch (error) {
            console.error('Chat Error:', error);
            hideTypingIndicator();
            addMessage('Sorry, I encountered an error. Please try again.', false);
        } finally {
            isTyping = false;
            widgetMessageInput.focus();
        }
    });
    
    // Handle quick commands
    widgetQuickCmds.forEach(button => {
        button.addEventListener('click', function() {
            const command = this.dataset.command;
            widgetMessageInput.value = command;
            widgetMessageInput.focus();
            
            // Trigger form submission after a short delay
            setTimeout(() => {
                widgetChatForm.dispatchEvent(new Event('submit'));
            }, 100);
        });
    });
    
    // Auto-resize input
    widgetMessageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 80) + 'px';
    });
});
</script>
@endpush