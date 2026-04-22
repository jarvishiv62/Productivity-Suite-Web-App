<!-- GenZ Chat Widget -->
<div id="chatWidget" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
    <!-- Chat Toggle Button -->
    <button id="chatToggleBtn"
        style="width: 60px; height: 60px; border-radius: 50%; background: var(--primary-gradient); border: none; color: white; font-size: 28px; cursor: pointer; box-shadow: 0 8px 24px rgba(255, 0, 110, 0.4); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: flex; align-items: center; justify-content: center; position: relative;"
        aria-label="Toggle chat">
        🤖
        @if(config('services.gemini.enabled'))
            <span
                style="position: absolute; top: -4px; right: -4px; background: var(--neon-yellow); color: var(--bg-primary); font-size: 10px; padding: 4px 6px; border-radius: 8px; font-weight: 700; text-transform: uppercase;">AI</span>
        @endif
    </button>

    <!-- Chat Window -->
    <div id="chatWindow"
        style="position: absolute; bottom: 80px; right: 0; width: 400px; height: 520px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-xl); box-shadow: 0 24px 48px rgba(0, 0, 0, 0.6); display: none; flex-direction: column; overflow: hidden; backdrop-filter: blur(20px);">
        <!-- Header -->
        <div
            style="background: var(--primary-gradient); color: white; padding: var(--space-lg); display: flex; align-items: center; justify-content: space-between; border-radius: var(--radius-xl) var(--radius-xl) 0 0;">
            <div style="display: flex; align-items: center;">
                <div
                    style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: var(--space-md); backdrop-filter: blur(10px);">
                    🤖
                </div>
                <div>
                    <h6 style="margin: 0; font-size: 16px; font-weight: 700;">
                        DailyDrive Assistant
                        @if(config('services.gemini.enabled'))
                            <span
                                style="background: var(--neon-yellow); color: var(--bg-primary); padding: 2px 8px; border-radius: 8px; font-size: 10px; margin-left: var(--space-sm); font-weight: 700; text-transform: uppercase;">✨
                                AI</span>
                        @endif
                    </h6>
                    <small style="color: rgba(255,255,255,0.9); font-size: 12px; font-weight: 500;">Always here to
                        help</small>
                </div>
            </div>
            <button id="chatCloseBtn"
                style="background: rgba(255, 255, 255, 0.2); border: none; color: white; font-size: 20px; cursor: pointer; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: var(--transition-normal);"
                aria-label="Close">
                <i class="lucide-x"></i>
            </button>
        </div>

        <!-- Messages -->
        <div id="widgetChatMessages"
            style="flex: 1; padding: var(--space-lg); overflow-y: auto; background: var(--bg-secondary); scroll-behavior: smooth;">
            <div style="text-align: center; padding: var(--space-xl) var(--space-md);">
                <div
                    style="width: 64px; height: 64px; background: var(--secondary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md); box-shadow: var(--shadow-neon);">
                    🤖
                </div>
                <p style="margin: var(--space-md) 0; line-height: 1.6; color: var(--text-primary); font-weight: 500;">
                    🤖 Hi! I'm your DailyDrive assistant
                    @if(config('services.gemini.enabled'))
                        powered by Google Gemini AI ✨
                    @endif
                    <br>How can I help you today?
                </p>
                <div
                    style="display: flex; flex-wrap: wrap; gap: var(--space-sm); justify-content: center; margin-top: var(--space-lg);">
                    <button class="widget-quick-cmd" data-command="tasks today"
                        style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); cursor: pointer; transition: var(--transition-normal); font-size: 12px; font-weight: 600;">
                        📝 Today's Tasks
                    </button>
                    <button class="widget-quick-cmd" data-command="quote"
                        style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); cursor: pointer; transition: var(--transition-normal); font-size: 12px; font-weight: 600;">
                        💭 Get Motivated
                    </button>
                    <button class="widget-quick-cmd" data-command="goals"
                        style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); cursor: pointer; transition: var(--transition-normal); font-size: 12px; font-weight: 600;">
                        🎯 My Goals
                    </button>
                    <button class="widget-quick-cmd" data-command="progress"
                        style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); cursor: pointer; transition: var(--transition-normal); font-size: 12px; font-weight: 600;">
                        📊 Progress Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div style="padding: var(--space-lg); border-top: 1px solid var(--border-color); background: var(--bg-card);">
            <form id="widgetChatForm" style="display: flex; gap: var(--space-sm);">
                <input type="text" id="widgetChatInput" placeholder="Type your message..."
                    style="flex: 1; padding: var(--space-md); border: 1px solid var(--border-color); border-radius: var(--radius-lg); background: var(--bg-secondary); color: var(--text-primary); outline: none; font-size: 14px; transition: var(--transition-normal);" />
                <button type="submit"
                    style="padding: var(--space-md); background: var(--secondary-gradient); color: var(--bg-primary); border: none; border-radius: var(--radius-lg); cursor: pointer; font-size: 16px; transition: var(--transition-normal); display: flex; align-items: center; justify-content: center;">
                    <i class="lucide-send"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Chat Button Animations */
    #chatToggleBtn:hover {
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 12px 32px rgba(233, 30, 99, 0.4);
    }

    #chatToggleBtn:active {
        transform: scale(0.95);
    }

    #chatToggleBtn.glow {
        animation: chatGlow 2s ease-in-out infinite;
    }

    @keyframes chatGlow {

        0%,
        100% {
            box-shadow: 0 8px 24px rgba(255, 0, 110, 0.4);
        }

        50% {
            box-shadow: 0 8px 32px rgba(255, 0, 110, 0.8), 0 0 20px rgba(6, 255, 180, 0.4);
        }
    }

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

    /* Close Button Hover */
    #chatCloseBtn:hover {
        background: rgba(255, 255, 255, 0.3) !important;
        transform: rotate(90deg);
    }

    /* Quick Command Buttons */
    .widget-quick-cmd:hover {
        background: var(--primary-gradient) !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 0, 110, 0.3);
    }

    /* Input Focus Effects */
    #widgetChatInput:focus {
        border-color: var(--neon-cyan) !important;
        box-shadow: 0 0 0 3px rgba(6, 255, 180, 0.1);
    }

    /* Send Button Hover */
    #widgetChatForm button:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 16px rgba(6, 255, 180, 0.4);
    }

    #widgetChatForm button:active {
        transform: scale(0.95);
    }

    /* Message Styles */
    .widget-message {
        margin-bottom: var(--space-md);
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
        padding: var(--space-sm) var(--space-md);
        border-radius: var(--radius-lg);
        max-width: 85%;
        word-wrap: break-word;
        white-space: pre-wrap;
        line-height: 1.5;
        font-size: 14px;
    }

    .widget-message.user .widget-message-content {
        background: var(--primary-gradient);
        color: white;
        border-bottom-right-radius: var(--radius-sm);
    }

    .widget-message.bot .widget-message-content {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-bottom-left-radius: var(--radius-sm);
    }

    .widget-message-time {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: var(--space-xs);
        opacity: 0.7;
    }

    /* Typing Indicator */
    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: var(--space-sm) 0;
    }

    .typing-indicator span {
        width: 8px;
        height: 8px;
        background: var(--neon-cyan);
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

        0%,
        80%,
        100% {
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
        background: var(--neon-purple);
        border-radius: var(--radius-full);
    }

    #widgetChatMessages::-webkit-scrollbar-thumb:hover {
        background: var(--neon-pink);
    }

    /* Mobile Responsiveness */
    @media (max-width: 480px) {
        #chatWidget {
            bottom: 15px !important;
            right: 15px !important;
        }

        #chatToggleBtn {
            width: 50px !important;
            height: 50px !important;
            font-size: 20px !important;
        }

        #chatWindow {
            width: calc(100vw - 30px) !important;
            height: 70vh !important;
            right: -15px !important;
        }
    }
</style>

<script>
    // Chat Widget Functionality
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Chat widget initializing...');

        const chatToggleBtn = document.getElementById('chatToggleBtn');
        const chatWindow = document.getElementById('chatWindow');
        const chatCloseBtn = document.getElementById('chatCloseBtn');
        const chatForm = document.getElementById('widgetChatForm');
        const chatInput = document.getElementById('widgetChatInput');
        const chatMessages = document.getElementById('widgetChatMessages');

        console.log('Chat elements found:', {
            chatToggleBtn: !!chatToggleBtn,
            chatWindow: !!chatWindow,
            chatCloseBtn: !!chatCloseBtn,
            chatForm: !!chatForm,
            chatInput: !!chatInput,
            chatMessages: !!chatMessages
        });

        // Toggle chat window
        chatToggleBtn?.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Chat toggle button clicked');
            chatWindow.classList.toggle('show');
            if (chatWindow.classList.contains('show')) {
                chatInput.focus();
                console.log('Chat window opened');
            } else {
                console.log('Chat window closed');
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
                console.log('Chat window closed by clicking outside');
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
        const welcomeMessage = chatMessages.querySelector('.welcome-message');
        if (welcomeMessage) {
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