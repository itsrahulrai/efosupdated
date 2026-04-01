<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        :root {
            --chat-green: #2a9d6a;
            --chat-green-light: #e8f5ee;
            --chat-bg: #f0eeeb;
            --chat-body-bg: #f5f2ee;
            --chat-white: #ffffff;
            --chat-border: #e5e7eb;
            --chat-muted: #9ca3af;
            --chat-text: #1a1a2e;
            --chat-radius: 1rem;
            --online-green: #22c55e;
        }

        * {
            box-sizing: border-box;
        }



        .chat-container {
            width: 100%;
            max-width: 1200px;
            height: 92vh;
            display: flex;
            gap: 1rem;
        }

        /* ── SIDEBAR ── */
        .chat-sidebar {
            width: 340px;
            flex-shrink: 0;
            background: var(--chat-white);
            border-radius: var(--chat-radius);
            border: 1px solid var(--chat-border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .04);
        }

        .sidebar-header {
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid var(--chat-border);
        }

        .sidebar-header h5 {
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: .75rem;
            color: var(--chat-text);
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: .85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--chat-muted);
            font-size: .85rem;
        }

        .search-box input {
            width: 100%;
            padding: .55rem .85rem .55rem 2.3rem;
            border-radius: .75rem;
            border: none;
            background: #f3f4f6;
            font-size: .82rem;
            color: var(--chat-text);
            outline: none;
            transition: box-shadow .2s;
        }

        .search-box input:focus {
            box-shadow: 0 0 0 2px rgba(42, 157, 106, .35);
        }

        .user-list {
            flex: 1;
            overflow-y: auto;
        }

        .user-list::-webkit-scrollbar {
            width: 4px;
        }

        .user-list::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .chat-user {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 1.25rem;
            cursor: pointer;
            transition: background .15s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .chat-user:hover {
            background: #f9fafb;
        }

        .chat-user.active {
            background: var(--chat-green-light);
        }

        .avatar-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .avatar-wrap img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
        }

        .online-dot {
            position: absolute;
            bottom: 1px;
            right: 1px;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: var(--online-green);
            border: 2px solid var(--chat-white);
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-info .name {
            font-weight: 600;
            font-size: .84rem;
            color: var(--chat-text);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-info .preview {
            font-size: .75rem;
            color: var(--chat-muted);
            margin: 2px 0 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-meta {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }

        .user-meta .time {
            font-size: .68rem;
            color: var(--chat-muted);
        }

        .unread-badge {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--chat-green);
            color: #fff;
            font-size: .65rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ── MAIN CHAT ── */
        .chat-main {
            flex: 1;
            min-width: 0;
            background: var(--chat-white);
            border-radius: var(--chat-radius);
            border: 1px solid var(--chat-border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .04);
        }

        .chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .75rem 1.25rem;
            border-bottom: 1px solid var(--chat-border);
            background: var(--chat-white);
        }

        .chat-header .left {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .chat-header .left img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .chat-header .left h6 {
            margin: 0;
            font-weight: 600;
            font-size: .88rem;
            color: var(--chat-text);
        }

        .chat-header .left small {
            font-size: .72rem;
        }

        .header-actions .btn {
            width: 36px;
            height: 36px;
            border-radius: .6rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--chat-muted);
            border: none;
            background: none;
            transition: background .15s, color .15s;
            padding: 0;
            font-size: 1rem;
        }

        .header-actions .btn:hover {
            background: #f3f4f6;
            color: var(--chat-text);
        }

        /* Messages */
        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 1.25rem 1.5rem;
            background: var(--chat-body-bg);
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }

        .chat-body::-webkit-scrollbar {
            width: 4px;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .msg-row {
            display: flex;
        }

        .msg-row.sent {
            justify-content: flex-end;
        }

        .msg-row.received {
            justify-content: flex-start;
        }

        .msg-bubble {
            max-width: 70%;
            padding: .65rem 1rem;
            border-radius: 1rem;
            font-size: .84rem;
            line-height: 1.5;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
        }

        .msg-row.sent .msg-bubble {
            background: var(--chat-green);
            color: #fff;
            border-bottom-right-radius: .35rem;
        }

        .msg-row.received .msg-bubble {
            background: var(--chat-white);
            color: var(--chat-text);
            border-bottom-left-radius: .35rem;
        }

        .msg-time {
            font-size: .62rem;
            margin-top: .25rem;
            text-align: right;
        }

        .msg-row.sent .msg-time {
            opacity: .7;
        }

        .msg-row.received .msg-time {
            color: var(--chat-muted);
        }

        /* Footer */
        .chat-footer {
            padding: .75rem 1rem;
            border-top: 1px solid var(--chat-border);
            background: var(--chat-white);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .chat-footer .icon-btn {
            width: 38px;
            height: 38px;
            border-radius: .6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: none;
            color: var(--chat-muted);
            font-size: 1.15rem;
            cursor: pointer;
            transition: background .15s, color .15s;
            flex-shrink: 0;
        }

        .chat-footer .icon-btn:hover {
            background: #f3f4f6;
            color: var(--chat-text);
        }

        .chat-footer input {
            flex: 1;
            padding: .6rem 1rem;
            border-radius: .75rem;
            border: none;
            background: #f3f4f6;
            font-size: .84rem;
            color: var(--chat-text);
            outline: none;
            transition: box-shadow .2s;
        }

        .chat-footer input:focus {
            box-shadow: 0 0 0 2px rgba(42, 157, 106, .35);
        }

        .send-btn {
            width: 40px;
            height: 40px;
            border-radius: .75rem;
            border: none;
            background: var(--chat-green);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            flex-shrink: 0;
            transition: opacity .15s;
        }

        .send-btn:hover {
            opacity: .88;
        }

        /* ── DATE DIVIDER ── */
        .date-divider {
            text-align: center;
            margin: .75rem 0;
        }

        .date-divider span {
            background: #e5e7eb;
            color: var(--chat-muted);
            font-size: .68rem;
            font-weight: 600;
            padding: .25rem .85rem;
            border-radius: .5rem;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .chat-container {
                flex-direction: column;
                height: 100vh;
                gap: 0;
            }

            .chat-sidebar {
                width: 100%;
                height: 45%;
                border-radius: var(--chat-radius) var(--chat-radius) 0 0;
            }

            .chat-main {
                border-radius: 0 0 var(--chat-radius) var(--chat-radius);
                flex: 1;
            }
        }
    </style>
</head>

<body>

    <div class="chat-container">

        <!-- ── SIDEBAR ── -->
        <div class="chat-sidebar">
            <div class="sidebar-header">
                <h5>Chats</h5>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search conversations..." id="searchInput" onkeyup="filterUsers()">
                </div>
            </div>
            <div class="user-list" id="userList">

                <button class="chat-user active" data-id="1" onclick="selectUser(this)">
                    <div class="avatar-wrap">
                        <img src="https://i.pravatar.cc/80?img=1" alt="Rahul Sharma">
                        <span class="online-dot"></span>
                    </div>
                    <div class="user-info">
                        <p class="name">Rahul Sharma</p>
                        <p class="preview">Need guidance for career</p>
                    </div>
                    <div class="user-meta">
                        <span class="time">09:30 AM</span>
                        <span class="unread-badge">2</span>
                    </div>
                </button>

                <button class="chat-user" data-id="2" onclick="selectUser(this)">
                    <div class="avatar-wrap">
                        <img src="https://i.pravatar.cc/80?img=2" alt="Amit Kumar">
                    </div>
                    <div class="user-info">
                        <p class="name">Amit Kumar</p>
                        <p class="preview">Hello mentor</p>
                    </div>
                    <div class="user-meta">
                        <span class="time">Yesterday</span>
                    </div>
                </button>

                <button class="chat-user" data-id="3" onclick="selectUser(this)">
                    <div class="avatar-wrap">
                        <img src="https://i.pravatar.cc/80?img=5" alt="Priya Patel">
                        <span class="online-dot"></span>
                    </div>
                    <div class="user-info">
                        <p class="name">Priya Patel</p>
                        <p class="preview">Thanks for the help! 🙏</p>
                    </div>
                    <div class="user-meta">
                        <span class="time">Yesterday</span>
                    </div>
                </button>

                <button class="chat-user" data-id="4" onclick="selectUser(this)">
                    <div class="avatar-wrap">
                        <img src="https://i.pravatar.cc/80?img=9" alt="Sneha Gupta">
                    </div>
                    <div class="user-info">
                        <p class="name">Sneha Gupta</p>
                        <p class="preview">Will check and revert</p>
                    </div>
                    <div class="user-meta">
                        <span class="time">Mon</span>
                    </div>
                </button>

                <button class="chat-user" data-id="5" onclick="selectUser(this)">
                    <div class="avatar-wrap">
                        <img src="https://i.pravatar.cc/80?img=3" alt="Vikram Singh">
                    </div>
                    <div class="user-info">
                        <p class="name">Vikram Singh</p>
                        <p class="preview">See you tomorrow!</p>
                    </div>
                    <div class="user-meta">
                        <span class="time">Mon</span>
                        <span class="unread-badge">1</span>
                    </div>
                </button>

                <button class="chat-user" data-id="6" onclick="selectUser(this)">
                    <div class="avatar-wrap">
                        <img src="https://i.pravatar.cc/80?img=10" alt="Deepika Rao">
                        <span class="online-dot"></span>
                    </div>
                    <div class="user-info">
                        <p class="name">Deepika Rao</p>
                        <p class="preview">Great session today</p>
                    </div>
                    <div class="user-meta">
                        <span class="time">Sun</span>
                    </div>
                </button>

            </div>
        </div>

        <!-- ── MAIN CHAT ── -->
        <div class="col-md-9">
            <div class="chat-main">

                <div class="chat-header">
                    <div class="left">
                        <div class="avatar-wrap">
                            <img src="https://i.pravatar.cc/80?img=1" alt="Rahul Sharma" id="headerAvatar">
                            <span class="online-dot" id="headerDot"></span>
                        </div>
                        <div>
                            <h6 id="headerName">Rahul Sharma</h6>
                            <small class="text-success" id="headerStatus">Online</small>
                        </div>
                    </div>
                    <div class="header-actions">
                        <button class="btn"><i class="bi bi-three-dots-vertical"></i></button>
                    </div>
                </div>

                <div class="chat-body" id="chatBody">
                    <div class="date-divider"><span>Today</span></div>

                    <div class="msg-row received">
                        <div class="msg-bubble">
                            Hello mentor 👋
                            <div class="msg-time">09:15 AM</div>
                        </div>
                    </div>

                    <div class="msg-row sent">
                        <div class="msg-bubble">
                            Hi Rahul! How can I help you today?
                            <div class="msg-time">09:18 AM</div>
                        </div>
                    </div>

                    <div class="msg-row received">
                        <div class="msg-bubble">
                            Need guidance for career. I'm confused between frontend and backend development.
                            <div class="msg-time">09:22 AM</div>
                        </div>
                    </div>

                    <div class="msg-row received">
                        <div class="msg-bubble">
                            I've been learning React for 2 months now and also started Node.js recently.
                            <div class="msg-time">09:23 AM</div>
                        </div>
                    </div>

                    <div class="msg-row sent">
                        <div class="msg-bubble">
                            That's a great question! Both paths have excellent opportunities. What do you enjoy more —
                            building visual interfaces or working with data and APIs?
                            <div class="msg-time">09:28 AM</div>
                        </div>
                    </div>

                    <div class="msg-row received">
                        <div class="msg-bubble">
                            I really enjoy building UIs and making things look beautiful ✨
                            <div class="msg-time">09:30 AM</div>
                        </div>
                    </div>
                </div>

                <div class="chat-footer">
                    <input type="file" id="fileInput" style="display:none" accept="image/*,application/pdf"
                        onchange="handleFileSelect(event)"><input type="file" id="fileInput" style="display:none"
                        accept="image/*,application/pdf" onchange="handleFileSelect(event)">
                    <button class="icon-btn" onclick="document.getElementById('fileInput').click()">

                        <i class="bi bi-paperclip"></i>

                    </button>
                    <input type="text" placeholder="Type a message..." id="msgInput"
                        onkeydown="if(event.key==='Enter')sendMessage()">
                    <button class="send-btn" onclick="sendMessage()"><i class="bi bi-send-fill"></i></button>
                </div>

            </div>
        </div>

    </div>

    <script>
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            const chatBody = document.getElementById('chatBody');
            const now = new Date();
            const time = now.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            let content = '';   
            if (file.type.startsWith('image/')) {
                const url = URL.createObjectURL(file);
                content = `<img src="${url}"
                style="max-width:200px;border-radius:8px">`;

            } else {
                content = `📄 ${file.name}`;
            }
            const row = document.createElement('div');
            row.className = 'msg-row sent';
                row.innerHTML = `
                <div class="msg-bubble">

                ${content}
                <div class="msg-time">${time}</div>
                </div>
                `;
            chatBody.appendChild(row);
            chatBody.scrollTop = chatBody.scrollHeight;

        }

        // Send message
        function sendMessage() {
            const input = document.getElementById('msgInput');
            const text = input.value.trim();
            if (!text) return;

            const chatBody = document.getElementById('chatBody');
            const now = new Date();
            const time = now.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            const row = document.createElement('div');
            row.className = 'msg-row sent';
            row.innerHTML = `<div class="msg-bubble">${text}<div class="msg-time">${time}</div></div>`;
            chatBody.appendChild(row);
            chatBody.scrollTop = chatBody.scrollHeight;
            input.value = '';
        }

        // Select user
        function selectUser(el) {
            document.querySelectorAll('.chat-user').forEach(u => u.classList.remove('active'));
            el.classList.add('active');

            const name = el.querySelector('.name').textContent;
            const img = el.querySelector('img').src;
            const hasDot = el.querySelector('.online-dot');

            document.getElementById('headerName').textContent = name;
            document.getElementById('headerAvatar').src = img;
            document.getElementById('headerDot').style.display = hasDot ? 'block' : 'none';
            document.getElementById('headerStatus').textContent = hasDot ? 'Online' : 'Offline';
            document.getElementById('headerStatus').className = hasDot ? 'text-success' : 'text-muted';

            // Remove unread badge
            const badge = el.querySelector('.unread-badge');
            if (badge) badge.remove();
        }

        // Search / filter
        function filterUsers() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.chat-user').forEach(u => {
                const name = u.querySelector('.name').textContent.toLowerCase();
                u.style.display = name.includes(q) ? '' : 'none';
            });
        }

        // Auto-scroll on load
        document.getElementById('chatBody').scrollTop = document.getElementById('chatBody').scrollHeight;
    </script>

</body>

</html>
