<!-- Chat Widget -->
<div id="chatWidget" class="fixed bottom-5 right-5 z-[1000]">
    <!-- Chat Toggle Button -->
    <button id="chatToggleBtn"
        class="w-14 h-14 rounded-full bg-gradient-to-r from-neon-pink to-neon-purple border-none text-white text-2xl cursor-pointer shadow-lg shadow-neon-pink/40 transition-all duration-300 flex items-center justify-center relative hover:scale-105 hover:rotate-6 hover:shadow-xl hover:shadow-neon-pink/50 active:scale-95"
        aria-label="Toggle chat">
        <i class="lucide-bot"></i>
        @if(config('services.gemini.enabled'))
            <span class="absolute -top-1 -right-1 bg-neon-yellow text-bg-primary text-xs px-1.5 py-0.5 rounded-lg font-bold text-uppercase">
                AI
            </span>
        @endif
    </button>

    <!-- Chat Window -->
    <div id="chatWindow"
        class="absolute bottom-20 right-0 w-96 h-[520px] bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-2xl hidden flex-col overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-neon-pink to-neon-purple text-white p-4 flex items-center justify-between rounded-t-2xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="lucide-bot text-lg"></i>
                </div>
                <div>
                    <h6 class="text-base font-bold mb-0">
                        DailyDrive Assistant
                        @if(config('services.gemini.enabled'))
                            <span class="bg-neon-yellow text-bg-primary px-2 py-0.5 rounded-lg text-xs font-bold text-uppercase ml-2">
                                AI
                            </span>
                        @endif
                    </h6>
                    <small class="text-white/90 text-xs font-medium">Always here to help</small>
                </div>
            </div>
            <button id="chatCloseBtn"
                class="bg-white/20 border-none text-white text-lg cursor-pointer w-8 h-8 rounded-full flex items-center justify-center transition-all duration-200 hover:bg-white/30 hover:rotate-90"
                aria-label="Close">
                <i class="lucide-x"></i>
            </button>
        </div>

        <!-- Messages -->
        <div id="widgetChatMessages"
            class="flex-1 p-4 overflow-y-auto bg-bg-secondary/50 scroll-smooth">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-gradient-to-br from-neon-green to-neon-blue rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-neon-green/30">
                    <i class="lucide-bot text-2xl text-white"></i>
                </div>
                <p class="text-text-primary font-medium mb-0 leading-relaxed">
                    🤖 Hi! I'm your DailyDrive assistant
                    @if(config('services.gemini.enabled'))
                        powered by Google Gemini AI ✨
                    @endif
                    <br>How can I help you today?
                </p>
                <div class="flex flex-wrap gap-2 justify-center mt-4">
                    <button class="widget-quick-cmd px-3 py-2 bg-bg-tertiary border border-border-color text-text-primary rounded-lg cursor-pointer transition-all duration-200 text-xs font-semibold hover:bg-gradient-to-r hover:from-neon-pink hover:to-neon-purple hover:text-white hover:scale-105 hover:shadow-lg" data-command="tasks today">
                        📝 Today's Tasks
                    </button>
                    <button class="widget-quick-cmd px-3 py-2 bg-bg-tertiary border border-border-color text-text-primary rounded-lg cursor-pointer transition-all duration-200 text-xs font-semibold hover:bg-gradient-to-r hover:from-neon-pink hover:to-neon-purple hover:text-white hover:scale-105 hover:shadow-lg" data-command="quote">
                        💭 Get Motivated
                    </button>
                    <button class="widget-quick-cmd px-3 py-2 bg-bg-tertiary border border-border-color text-text-primary rounded-lg cursor-pointer transition-all duration-200 text-xs font-semibold hover:bg-gradient-to-r hover:from-neon-pink hover:to-neon-purple hover:text-white hover:scale-105 hover:shadow-lg" data-command="goals">
                        🎯 My Goals
                    </button>
                    <button class="widget-quick-cmd px-3 py-2 bg-bg-tertiary border border-border-color text-text-primary rounded-lg cursor-pointer transition-all duration-200 text-xs font-semibold hover:bg-gradient-to-r hover:from-neon-pink hover:to-neon-purple hover:text-white hover:scale-105 hover:shadow-lg" data-command="progress">
                        📊 Progress Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t border-border-color bg-bg-card/80">
            <form id="widgetChatForm" class="flex gap-2">
                <input type="text" id="widgetChatInput" placeholder="Type your message..."
                    class="flex-1 px-3 py-2 border border-border-color rounded-lg bg-bg-secondary/80 text-text-primary placeholder-text-muted outline-none text-sm transition-all duration-200 focus:border-neon-cyan focus:ring-2 focus:ring-neon-cyan/50" />
                <button type="submit"
                    class="px-3 py-2 bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary border-none rounded-lg cursor-pointer text-base transition-all duration-200 flex items-center justify-center hover:scale-105 hover:shadow-lg hover:shadow-neon-green/40 active:scale-95">
                    <i class="lucide-send"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Chat Window Animations */
    #chatWindow {
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    #chatWindow.show {
        display: flex !important;
        animation: slideUpChat 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 1 !important;
        visibility: visible !important;
    }

    @keyframes slideUpChat {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Message Styles */
    .widget-message {
        margin-bottom: 1rem;
        animation: messageSlideIn 0.3s ease;
    }

    @keyframes messageSlideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .widget-message.user {
        text-align: right;
    }

    .widget-message.bot {
        text-align: left;
    }

    .widget-message-content {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        max-width: 85%;
        word-wrap: break-word;
        white-space: pre-wrap;
        line-height: 1.5;
        font-size: 14px;
    }

    .widget-message.user .widget-message-content {
        background: linear-gradient(135deg, #e91e63 0%, #9c27b0 100%);
        color: white;
        border-bottom-right-radius: 0.25rem;
    }

    .widget-message.bot .widget-message-content {
        background: #2f2f4e;
        color: #f5f5f5;
        border: 1px solid #2f2f4e;
        border-bottom-left-radius: 0.25rem;
    }

    .widget-message-time {
        font-size: 11px;
        color: #64748b;
        margin-top: 0.25rem;
        opacity: 0.7;
    }

    /* Typing Indicator */
    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 0.5rem 0;
    }

    .typing-indicator span {
        width: 8px;
        height: 8px;
        background: #00bcd4;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out;
    }

    .typing-indicator span:nth-child(1) {
        animation-delay: -0.32s;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: -0.16s;
    }

    @keyframes typing {
        0%, 80%, 100% {
            transform: scale(0.8);
            opacity: 0.5;
        }
        40% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Scrollbar Styling */
    #widgetChatMessages::-webkit-scrollbar {
        width: 6px;
    }

    #widgetChatMessages::-webkit-scrollbar-track {
        background: transparent;
    }

    #widgetChatMessages::-webkit-scrollbar-thumb {
        background: #9c27b0;
        border-radius: 9999px;
    }

    #widgetChatMessages::-webkit-scrollbar-thumb:hover {
        background: #e91e63;
    }

    /* Chat Button Glow Animation */
    #chatToggleBtn.glow {
        animation: chatGlow 2s ease-in-out infinite;
    }

    @keyframes chatGlow {
        0%, 100% {
            box-shadow: 0 8px 24px rgba(233, 30, 99, 0.4);
        }
        50% {
            box-shadow: 0 8px 32px rgba(233, 30, 99, 0.8), 0 0 20px rgba(6, 255, 180, 0.4);
        }
    }

    /* Mobile Responsiveness */
    @media (max-width: 480px) {
        #chatWidget {
            bottom: 4rem !important;
            right: 1rem !important;
        }

        #chatToggleBtn {
            width: 3rem !important;
            height: 3rem !important;
            font-size: 1.25rem !important;
        }

        #chatWindow {
            width: calc(100vw - 2rem) !important;
            height: 70vh !important;
            right: -1rem !important;
        }
    }
</style>

<script>
    // Chat Widget Functionality
    document.addEventListener('DOMContentLoaded', function () {
        const chatToggleBtn = document.getElementById('chatToggleBtn');
        const chatWindow = document.getElementById('chatWindow');
        const chatCloseBtn = document.getElementById('chatCloseBtn');
        const chatForm = document.getElementById('widgetChatForm');
        const chatInput = document.getElementById('widgetChatInput');
        const chatMessages = document.getElementById('widgetChatMessages');

        // Toggle chat window
        chatToggleBtn?.addEventListener('click', function (e) {
            e.preventDefault();
            chatWindow.classList.toggle('show');
            if (chatWindow.classList.contains('show')) {
                chatInput.focus();
            }
        });

        // Close chat window
        chatCloseBtn?.addEventListener('click', function () {
            chatWindow.classList.remove('show');
        });

        // Close chat when clicking outside
        document.addEventListener('click', function (e) {
            if (!chatWindow.contains(e.target) && !chatToggleBtn.contains(e.target)) {
                chatWindow.classList.remove('show');
            }
        });

        // Handle form submission
        chatForm?.addEventListener('submit', function (e) {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            // Add user message
            addMessage(message, 'user');
            chatInput.value = '';

            // Show typing indicator
            showTypingIndicator();

            // Send to server
            sendChatMessage(message);
        });

        // Quick command buttons
        document.querySelectorAll('.widget-quick-cmd').forEach(btn => {
            btn.addEventListener('click', function () {
                const command = this.dataset.command;
                chatInput.value = getCommandText(command);
                chatInput.focus();
            });
        });

        // Add glow effect to chat button periodically
        setInterval(() => {
            chatToggleBtn?.classList.add('glow');
            setTimeout(() => {
                chatToggleBtn?.classList.remove('glow');
            }, 2000);
        }, 10000);
    });

    function addMessage(content, type) {
        const chatMessages = document.getElementById('widgetChatMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'widget-message ' + type;

        const time = new Date().toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });

        messageDiv.innerHTML = `
            <div class="widget-message-content">${content}</div>
            <div class="widget-message-time">${time}</div>
        `;

        // Remove welcome message if it exists
        const welcomeMessage = chatMessages.querySelector('.text-center');
        if (welcomeMessage && chatMessages.children.length > 1) {
            welcomeMessage.remove();
        }

        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTypingIndicator() {
        const chatMessages = document.getElementById('widgetChatMessages');
        const typingDiv = document.createElement('div');
        typingDiv.className = 'widget-message bot';
        typingDiv.id = 'typingIndicator';
        typingDiv.innerHTML = `
            <div class="typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        `;

        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function hideTypingIndicator() {
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    function getCommandText(command) {
        const commands = {
            'tasks today': 'Show me my tasks for today',
            'quote': 'Give me a motivational quote',
            'goals': 'What are my current goals?',
            'progress': 'Show me my progress report'
        };
        return commands[command] || command;
    }

    async function sendChatMessage(message) {
        try {
            const response = await fetch('/chat/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();

            hideTypingIndicator();

            if (data.success) {
                addMessage(data.response, 'bot');
            } else {
                addMessage('Sorry, I encountered an error. Please try again.', 'bot');
            }
        } catch (error) {
            hideTypingIndicator();
            addMessage('Connection error. Please check your internet connection.', 'bot');
        }
    }
</script>
