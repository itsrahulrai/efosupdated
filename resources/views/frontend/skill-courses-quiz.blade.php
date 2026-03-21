<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->course->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Favicon img -->
    <link rel="shortcut icon" href="{{ static_asset('assets/images/favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;900&family=Work+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        :root {
            --ink: #0f172a;
            --paper: #fafaf9;
            --accent: #fb923c;
            --success: #22c55e;
            --danger: #e11d48;
            --mark: #a855f7;
            --slate: #64748b;
            --border: #e2e8f0;
            --card: #ffffff;
        }

        .stat:nth-child(1)::before {
            background: #22c55e;
        }

        /* Answered */
        .stat:nth-child(2)::before {
            background: #f97316;
        }

        /* Not Answered */
        .stat:nth-child(3)::before {
            background: #a855f7;
        }

        /* Marked */
        .stat:nth-child(4)::before {
            background: #64748b;
        }

        /* Not Visited */


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Work Sans', sans-serif;
            background: var(--paper);
            color: var(--ink);
            overflow-x: hidden;
        }

        /* HEADER */
        .header {
            background: #fff;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid var(--accent);
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 35%;
            height: 4px;
            background: var(--success);
            animation: progress 3s ease-in-out infinite;
        }

        @keyframes progress {

            0%,
            100% {
                width: 35%;
            }

            50% {
                width: 65%;
            }
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .exam-title {
            background: #e11d48;
            color: white;
            padding: 12px 28px;
            border-radius: 6px;
            font-family: 'Archivo', sans-serif;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 0 #be123c;
            transform: translateY(-2px);
        }

        .quiz-title {
            display: inline-block;
            /* 👈 key line */
            background: #e11d48;
            color: #ffffff;
            padding: 8px 18px;
            /* smaller */
            border-radius: 6px;
            font-family: 'Archivo', sans-serif;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.4px;
            box-shadow: 0 3px 0 #be123c;
            transform: translateY(-2px);
            white-space: nowrap;
            /* keeps it tight */
            margin-bottom: 20px;
        }



        /* MAIN */
        .container {
            display: flex;
            padding: 32px 40px;
            gap: 32px;
            max-width: 1700px;
            margin: 0 auto;
        }

        /* QUESTION AREA */
        .question-area {
            flex: 1;
        }

        .q-card {
            background: var(--card);
            border-radius: 12px;
            padding: 42px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 8px 24px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border);
            position: relative;
        }

        .q-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 8px;
            height: 100%;
            background: linear-gradient(to bottom, var(--accent), var(--success));
            border-radius: 12px 0 0 12px;
        }

        .q-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .q-num {
            font-family: 'Archivo', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: var(--ink);
        }

        .q-marks {
            background: #dcfce7;
            color: #15803d;
            padding: 6px 18px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            border: 1.5px solid #22c55e;
        }

        .q-text {
            font-size: 17px;
            line-height: 1.75;
            margin-bottom: 28px;
            color: #334155;
        }

        .q-text strong {
            font-family: 'Archivo', sans-serif;
            font-weight: 700;
            color: var(--ink);
            font-size: 19px;
            display: block;
            margin-top: 16px;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .option {
            border: 2px solid var(--border);
            padding: 20px 22px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            gap: 16px;
            background: white;
        }

        .option:hover {
            border-color: var(--accent);
            background: #fff7ed;
            transform: translateX(6px);
        }

        .option.selected {
            border-color: var(--accent);
            background: #fffbeb;
            border-width: 2.5px;
        }

        .option input[type="radio"] {
            width: 22px;
            height: 22px;
            cursor: pointer;
            accent-color: var(--accent);
        }

        .option label {
            cursor: pointer;
            font-size: 16px;
            color: var(--ink);
            flex: 1;
            font-weight: 500;
        }

        /* SIDEBAR */
        .sidebar {
            width: 400px;
        }

        /* TIMER */
        .timer {
            background: var(--ink);
            padding: 28px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 28px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.2);
            border: 3px solid #1e293b;
        }

        .timer-label {
            font-family: 'Archivo', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
        }

        .timer-display {
            font-family: 'Archivo', sans-serif;
            font-size: 44px;
            font-weight: 900;
            color: white;
            letter-spacing: 3px;
        }

        .timer-display.warning {
            color: var(--accent);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        /* CANDIDATE DETAILS */
        /* CANDIDATE PROFILE CARD */
        .candidate-profile-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow:
                0 2px 4px rgba(0, 0, 0, 0.04),
                0 8px 20px rgba(0, 0, 0, 0.06);
            margin-bottom: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .candidate-profile-card:hover {
            box-shadow:
                0 4px 8px rgba(0, 0, 0, 0.06),
                0 12px 28px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
            border-color: rgba(251, 146, 60, 0.15);
        }

        /* PROFILE HEADER */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px solid #f3f4f6;
        }

        /* AVATAR */
        .profile-avatar {
            width: 60px;
            height: 60px;
            min-width: 60px;
            border-radius: 50%;
            overflow: hidden;
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
            padding: 2.5px;
            box-shadow:
                0 3px 10px rgba(251, 146, 60, 0.2),
                0 0 0 2px rgba(251, 146, 60, 0.08);
            transition: all 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow:
                0 4px 14px rgba(251, 146, 60, 0.3),
                0 0 0 2px rgba(251, 146, 60, 0.15);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ffffff;
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover img {
            transform: scale(1.08);
        }

        /* PROFILE INFO */
        .profile-info {
            flex: 1;
            min-width: 0;
        }

        .profile-main {
            display: flex;
            align-items: center;
        }

        .profile-name {
            font-family: 'Archivo', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-weight: 700;
            font-size: 17px;
            color: #111827;
            margin: 0;
            line-height: 1.3;
            letter-spacing: -0.01em;
        }

        /* PROFILE CONTACT */
        .profile-contact {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #4b5563;
            font-weight: 500;
            padding: 8px 12px;
            background: #f9fafb;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .contact-item:hover {
            background: #fff7ed;
            border-color: rgba(251, 146, 60, 0.2);
            transform: translateX(3px);
        }

        .contact-item i {
            color: #fb923c;
            font-size: 13px;
            width: 16px;
            text-align: center;
            flex-shrink: 0;
        }

        .contact-item span {
            word-break: break-word;
            line-height: 1.5;
        }

        /* RESPONSIVE */
        @media (max-width: 640px) {
            .candidate-profile-card {
                padding: 18px 16px;
                border-radius: 10px;
            }

            .profile-header {
                gap: 12px;
                margin-bottom: 14px;
                padding-bottom: 12px;
            }

            .profile-avatar {
                width: 55px;
                height: 55px;
                min-width: 55px;
            }

            .profile-name {
                font-size: 16px;
            }

            .contact-item {
                font-size: 12px;
                padding: 7px 10px;
            }

            .contact-item i {
                font-size: 12px;
                width: 14px;
            }
        }

        @media (max-width: 480px) {
            .candidate-profile-card {
                padding: 16px 14px;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .profile-avatar {
                width: 60px;
                height: 60px;
                min-width: 60px;
            }

            .profile-main {
                justify-content: center;
            }

            .profile-name {
                font-size: 15px;
            }

            .contact-item {
                justify-content: flex-start;
            }
        }

        /* PALETTE */
        .palette {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 8px 24px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border);
            margin-bottom: 28px;
        }

        .palette-title {
            font-family: 'Archivo', sans-serif;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 24px;
            color: var(--ink);
        }

        .palette-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
            margin-bottom: 28px;
        }

        .p-num {
            aspect-ratio: 1;
            border-radius: 8px;
            font-family: 'Archivo', sans-serif;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }

        .p-num:hover {
            transform: scale(1.12);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .p-answered {
            background: var(--success);
            color: white;
        }

        .p-not-answered {
            background: #cbd5e1;
            color: #475569;
        }

        .p-marked {
            background: var(--mark);
            color: white;
        }

        .p-not-visited {
            background: #f1f5f9;
            color: #94a3b8;
            border-color: var(--border);
        }

        .p-current {
            background: var(--accent);
            color: white;
            box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.2);
        }

        /* LEGEND */
        .legend {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .legend-dot {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            flex-shrink: 0;
        }

        /* STATS CONTAINER */
        .stats {
            background: #ffffff;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid var(--border);
            margin-top: 24px;
        }

        /* GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        /* STAT CARD */
        .stat {
            position: relative;
            background: #f9fafb;
            padding: 18px 16px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e5e7eb;
            transition: all 0.25s ease;
        }

        /* subtle hover */
        .stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        /* LEFT ACCENT BAR */
        .stat::before {
            content: "";
            position: absolute;
            left: 0;
            top: 12px;
            bottom: 12px;
            width: 4px;
            border-radius: 4px;
            background: var(--accent);
        }

        /* NUMBER */
        .stat-value {
            font-family: 'Archivo', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: var(--ink);
            line-height: 1;
        }

        /* LABEL */
        .stat-label {
            margin-top: 6px;
            font-size: 11px;
            color: var(--slate);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }


        /* FOOTER */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: #ffffff;
            border-top: 1px solid var(--border);
            gap: 40px;
        }

        .footer-left {
            display: flex;
            justify-content: space-between;
            /* LEFT vs RIGHT groups */
            align-items: center;
            gap: 24px;
            flex: 1;

        }


        .footer-actions-left,
        .footer-actions-right {
            display: flex;
            gap: 12px;

        }


        .btn {
            padding: 13px 30px;
            border-radius: 8px;
            font-family: 'Archivo', sans-serif;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:active::before {
            width: 300px;
            height: 300px;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-outline {
            background: white;
            border: 2.5px solid var(--border);
            color: var(--ink);
        }

        .btn-outline:hover {
            background: #f8fafc;
            border-color: var(--slate);
        }

        .btn-mark {
            background: var(--mark);
            color: white;
            box-shadow: 0 4px 0 #9333ea;
        }

        .btn-mark:hover {
            box-shadow: 0 6px 0 #9333ea;
        }

        .btn-prev {
            background: var(--slate);
            color: white;
            box-shadow: 0 4px 0 #475569;
        }

        .btn-prev:hover {
            box-shadow: 0 6px 0 #475569;
        }

        .btn-next {
            background: var(--accent);
            color: white;
            box-shadow: 0 4px 0 #ea580c;
            margin-right: 251px;

        }

        .btn-next:hover {
            box-shadow: 0 6px 0 #ea580c;
        }

        .btn-submit {
            background: var(--danger);
            color: white;
            box-shadow: 0 4px 0 #be123c;
            padding: 13px 36px;
        }

        .btn-submit:hover {
            box-shadow: 0 6px 0 #be123c;
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }
        }

        @media (max-width: 768px) {

            .header,
            .container,
            .footer {
                padding-left: 20px;
                padding-right: 20px;
            }

            .q-card {
                padding: 28px;
            }

            .footer {
                flex-direction: column;
                gap: 16px;
            }
        }

        .palette-divider {
            border: none;
            height: 2px;
            /* thicker for visibility */
            background-color: #000;
            /* change color as needed */
            margin: 24px 0;
        }


        /* QUESTION GUIDE / HINT */
        .question-guide {
            background: linear-gradient(120deg, #fef3c7 0%, #fff7e6 100%);
            border-left: 6px solid var(--accent);
            padding: 18px 22px;
            border-radius: 12px;
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            font-size: 14px;
            color: #78350f;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 20px;
        }

        .question-guide:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }

        /* Add a lightbulb icon on the left */
        .question-guide::before {
            content: "\f0eb";
            /* Font Awesome lightbulb icon */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 20px;
            color: var(--accent);
            margin-right: 12px;
        }

        /* Paragraph styling */
        .question-guide p {
            margin: 0;
            flex: 1;
            line-height: 1.6;
            font-weight: 500;
        }

        /* Button styling */
        .question-guide .btn-sm {
            padding: 8px 18px;
            font-size: 13px;
            border-radius: 8px;
            font-weight: 700;
            background: var(--accent);
            color: white;
            border: none;
            box-shadow: 0 4px 0 #ea580c;
            transition: all 0.2s;
        }

        .question-guide .btn-sm:hover {
            box-shadow: 0 6px 0 #ea580c;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <!-- HEADER -->
    <div class="header">
        <div class="brand">
            <img src="{{ static_asset('assets/images/logo/logo.jpg') }}" alt="logo" width="120" height="46">
        </div>
        <div class="exam-title">
            {{ $quiz->course->title }}
        </div>
    </div>




    <!-- MAIN -->
    <div class="container">


        <!-- QUESTION -->

        <div class="question-area">
            <!-- QUESTION INSTRUCTION / HINT -->
            <div class="question-guide">
                <p id="briefGuide">Please read the general instructions carefully before starting the exam.</p>
                <!-- Only triggers modal when clicked -->
                <button type="button" class="btn btn-outline btn-sm" data-bs-toggle="modal"
                    data-bs-target="#guideModal">
                    Read Full Guide
                </button>
            </div>





            <div class="q-card">
                <div class="quiz-title">{{ $quiz->title }}</div>


                <div class="q-header">
                    <div class="q-num" id="questionNumber">Question No. 1 of 40</div>
                    <div class="q-marks" id="questionMarks"></div>
                </div>

                <div class="q-text" id="questionText">
                    In the following question, choose the word which is <strong>opposite in meaning</strong> to the
                    given word.
                    <br><br>
                    <strong>DESPICABLE</strong>
                </div>

                <div class="options" id="optionsContainer">
                    <div class="option" onclick="selectOption(0)">
                        <input type="radio" name="answer" id="opt0">
                        <label for="opt0">Outbreak</label>
                    </div>
                    <div class="option" onclick="selectOption(1)">
                        <input type="radio" name="answer" id="opt1">
                        <label for="opt1">Escape</label>
                    </div>
                    <div class="option" onclick="selectOption(2)">
                        <input type="radio" name="answer" id="opt2">
                        <label for="opt2">Respectable</label>
                    </div>
                    <div class="option" onclick="selectOption(3)">
                        <input type="radio" name="answer" id="opt3">
                        <label for="opt3">Breakout</label>
                    </div>
                </div>


            </div>

            <div class="stats">
                <div class="stats-grid">
                    <div class="stat">
                        <div class="stat-value" id="statAnswered">0</div>
                        <div class="stat-label">Answered</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value" id="statNotAnswered">0</div>
                        <div class="stat-label">Not Answered</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value" id="statMarked">0</div>
                        <div class="stat-label">Marked</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value" id="statNotVisited">40</div>
                        <div class="stat-label">Not Visited</div>
                    </div>
                </div>


            </div>


        </div>



        <!-- SIDEBAR -->
        <div class="sidebar">

            <!-- TIMER -->
            <div class="timer">
                <div class="timer-label">⏱ TIME REMAINING</div>
                <div class="timer-display" id="timerDisplay">01:59:59</div>
            </div>

            <!-- CANDIDATE DETAILS -->
            @php
                $student = Auth::user()->student;
            @endphp

            <div class="candidate-profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="{{ $student && $student->photo ? static_asset($student->photo) : asset('assets/images/default-user.png') }}"
                            alt="Candidate Photo" id="candidatePhoto">
                    </div>

                    <div class="profile-info">
                        <div class="profile-main">
                            <h2 class="profile-name" id="candidateName">
                                {{ $student->name ?? Auth::user()->name }}
                            </h2>
                        </div>

                    </div>
                </div>

                <div class="profile-contact">
                    <div class="contact-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span>{{ $student->email ?? Auth::user()->email }}</span>
                    </div>

                    @if (!empty($student->phone))
                        <div class="contact-item">
                            <i class="fa-solid fa-phone"></i>
                            <span>{{ $student->phone }}</span>
                        </div>
                    @endif

                </div>
            </div>

            <!-- PALETTE -->
            <div class="palette">
                <div class="palette-title">Question Palette</div>

                <div class="palette-grid" id="paletteGrid">
                    <!-- Generated by JS -->

                </div>
                <hr class="palette-divider">

                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-dot p-answered"></div>
                        <span>Answered</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot p-not-answered"></div>
                        <span>Not Answered</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot p-marked"></div>
                        <span>Marked</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot p-not-visited"></div>
                        <span>Not Visited</span>
                    </div>
                </div>

            </div>



        </div>

    </div>
    <!-- FOOTER -->
    <div class="footer">
        <div class="footer-left">

            <!-- LEFT ACTIONS -->
            <div class="footer-actions-left">
                <button class="btn btn-mark" onclick="markForReview()">
                    <i class="fa-solid fa-star"></i>
                    Mark for Review
                </button>

                <button class="btn btn-outline" onclick="clearResponse()">
                    <i class="fa-solid fa-eraser"></i>
                    Clear Response
                </button>
            </div>

            <!-- RIGHT ACTIONS -->
            <div class="footer-actions-right">
                <button class="btn btn-prev" onclick="previousQuestion()">
                    <i class="fa-solid fa-arrow-left"></i>
                    Previous
                </button>

                <button class="btn btn-next" onclick="nextQuestion()">
                    Next
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>

        </div>

        <div class="footer-right">
            <button class="btn btn-submit" onclick="submitTest()">
                <i class="fa-solid fa-file-arrow-up"></i>
                Submit & Finish
            </button>
        </div>
    </div>




    <!-- Full Guide Modal -->

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const QUIZ_DURATION_MINUTES = {{ $quiz->duration_minutes }};
    </script>

    <script>
        // =====================
        // QUESTION DATA
        // =====================
        const questions = @json($questions);
        const TOTAL_QUESTIONS = questions.length;

        // =====================
        // STATE MANAGEMENT
        // =====================
        let currentQuestion = 0;
        let questionStates = new Array(TOTAL_QUESTIONS).fill('not-visited');
        let selectedAnswers = new Array(TOTAL_QUESTIONS).fill(null);
        let markedQuestions = new Array(TOTAL_QUESTIONS).fill(false);

        let timeRemaining = QUIZ_DURATION_MINUTES * 60;


        // =====================
        // INIT
        // =====================
        function init() {
            questionStates[0] = 'current';
            renderPalette();
            renderQuestion();
            updateTimerDisplay();
            startTimer();
            updateStats();

            document.getElementById('modalDuration').textContent = QUIZ_DURATION_MINUTES;
            document.getElementById('modalTotalQuestions').textContent = TOTAL_QUESTIONS;

        }

        // =====================
        // PALETTE
        // =====================
        function renderPalette() {
            const paletteGrid = document.getElementById('paletteGrid');
            paletteGrid.innerHTML = '';

            for (let i = 0; i < TOTAL_QUESTIONS; i++) {
                const btn = document.createElement('div');
                btn.className = `p-num ${getQuestionClass(i)}`;
                btn.textContent = i + 1;
                btn.onclick = () => jumpToQuestion(i);
                paletteGrid.appendChild(btn);
            }
        }

        function getQuestionClass(index) {
            if (index === currentQuestion) return 'p-current';
            if (markedQuestions[index]) return 'p-marked';
            if (selectedAnswers[index] !== null) return 'p-answered';
            if (questionStates[index] === 'not-answered') return 'p-not-answered';
            return 'p-not-visited';
        }

        // =====================
        // RENDER QUESTION
        // =====================
        function renderQuestion() {
            const q = questions[currentQuestion];

            document.getElementById('questionNumber').textContent =
                `Question No. ${currentQuestion + 1} of ${TOTAL_QUESTIONS}`;

            document.getElementById('questionText').innerHTML = q.text;

            // ✅ DYNAMIC MARKS
            document.getElementById('questionMarks').textContent = `+${q.marks} Marks`;

            const container = document.getElementById('optionsContainer');
            container.innerHTML = '';

            q.options.forEach((opt) => {
                const div = document.createElement('div');
                div.className = 'option';

                if (selectedAnswers[currentQuestion] === opt.id) {
                    div.classList.add('selected');
                }

                div.onclick = () => selectOption(opt.id);

                div.innerHTML = `
        <input type="radio" name="answer"
               ${selectedAnswers[currentQuestion] === opt.id ? 'checked' : ''}>
        <label>${opt.text}</label>
    `;

                container.appendChild(div);
            });

        }


        // =====================
        // ANSWER HANDLING
        // =====================
        function selectOption(optionId) {
            selectedAnswers[currentQuestion] = optionId;

            if (questionStates[currentQuestion] === 'not-visited' || questionStates[currentQuestion] === 'current') {
                questionStates[currentQuestion] = 'answered';
            }

            renderQuestion();
            renderPalette();
            updateStats();
        }


        function clearResponse() {
            selectedAnswers[currentQuestion] = null;
            markedQuestions[currentQuestion] = false;
            questionStates[currentQuestion] = 'not-answered';

            renderQuestion();
            renderPalette();
            updateStats();
        }

        function markForReview() {
            markedQuestions[currentQuestion] = !markedQuestions[currentQuestion];
            if (questionStates[currentQuestion] === 'not-visited') {
                questionStates[currentQuestion] = 'not-answered';
            }
            renderPalette();
            updateStats();
        }

        // =====================
        // NAVIGATION
        // =====================
        function nextQuestion() {
            if (currentQuestion < TOTAL_QUESTIONS - 1) {
                currentQuestion++;
                renderQuestion();
                renderPalette();
                updateStats();
            }
        }

        function previousQuestion() {
            if (currentQuestion > 0) {
                currentQuestion--;
                renderQuestion();
                renderPalette();
                updateStats();
            }
        }

        function jumpToQuestion(index) {
            currentQuestion = index;
            renderQuestion();
            renderPalette();
            updateStats();
        }

        // =====================
        // STATS
        // =====================
        function updateStats() {
            let answered = 0;
            let notAnswered = 0;
            let marked = 0;
            let notVisited = 0;

            for (let i = 0; i < TOTAL_QUESTIONS; i++) {
                if (markedQuestions[i]) marked++;
                else if (selectedAnswers[i] !== null) answered++;
                else if (questionStates[i] === 'not-answered') notAnswered++;
                else notVisited++;
            }

            document.getElementById('statAnswered').textContent = answered;
            document.getElementById('statNotAnswered').textContent = notAnswered;
            document.getElementById('statMarked').textContent = marked;
            document.getElementById('statNotVisited').textContent = notVisited;
        }

        // =====================
        // TIMER
        // =====================
        function startTimer() {
            timerInterval = setInterval(() => {
                timeRemaining--;
                updateTimerDisplay();

                if (timeRemaining === 300 && !warned) {
                    warned = true;
                    new bootstrap.Modal(
                        document.getElementById('timeWarningModal')
                    ).show();
                }

                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    finalSubmit('auto');
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const h = Math.floor(timeRemaining / 3600);
            const m = Math.floor((timeRemaining % 3600) / 60);
            const s = timeRemaining % 60;

            const display = `${pad(h)}:${pad(m)}:${pad(s)}`;
            const timerEl = document.getElementById('timerDisplay');
            timerEl.textContent = display;

            if (timeRemaining < 600) timerEl.classList.add('warning');
        }

        function pad(num) {
            return num.toString().padStart(2, '0');
        }

        // =====================
        // SUBMIT
        // =====================
        function submitTest() {
            new bootstrap.Modal(
                document.getElementById('submitConfirmModal')
            ).show();
        }


        function finalSubmit(type = 'manual') {

            // Close confirm modal
            const confirmModalEl = document.getElementById('submitConfirmModal');
            const confirmModal = bootstrap.Modal.getInstance(confirmModalEl);
            if (confirmModal) confirmModal.hide();

            clearInterval(timerInterval);

            fetch("{{ route('quiz.submit', $quiz->id) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        answers: selectedAnswers,
                        time_taken: (QUIZ_DURATION_MINUTES * 60) - timeRemaining,
                        submit_type: type
                    })
                })

                .then(async res => {
                    const data = await res.json();

                    // ❌ Already submitted → show MODAL
                    if (res.status === 409) {
                        showAlreadySubmittedModal();
                        return Promise.reject('already-submitted');
                    }

                    // ❌ Validation errors
                    if (res.status === 422 && data.errors) {
                        Object.values(data.errors).flat().forEach(msg => {
                            alert(msg); // or custom modal if you want
                        });
                        throw new Error("Validation failed");
                    }

                    // ❌ Other server errors
                    if (!res.ok) {
                        alert(data.message || "Something went wrong.");
                        throw new Error("Submission failed");
                    }

                    return data;
                })

                .then(data => {
                    showResultModal(data, type);
                    lockExamUI();
                })

                .catch(err => {
                    if (err === 'already-submitted') return;
                    console.error(err);
                });

        }


        let timerInterval;
        let warned = false;

        function startTimer() {
            timerInterval = setInterval(() => {
                timeRemaining--;
                updateTimerDisplay();

                // ⏰ 5-minute warning
                if (timeRemaining === 300 && !warned) {
                    warned = true;
                    new bootstrap.Modal(
                        document.getElementById('timeWarningModal'), {
                            backdrop: 'static',
                            keyboard: false
                        }
                    ).show();
                }

                // ⛔ Auto submit
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    finalSubmit('auto');
                }
            }, 1000);
        }


        window.onload = init;

        function showResultModal(data, type = 'manual') {

            document.getElementById('resultAnswered').textContent =
                data.answered_questions + ' / ' + data.total_questions;

            document.getElementById('resultTime').textContent =
                data.time_taken + ' seconds';



            document.getElementById('certificateMessage').innerHTML = '';

            if (data.certificate_generated) {

                document.getElementById('certificateMessage').innerHTML = `
            <div class="alert alert-success text-center">
                 Congratulations! Your Certificate has been generated successfully.
            </div>
        `;
            }

            // Change message for auto submit
            if (type === 'auto') {
                document.querySelector('#resultModal .modal-title').innerHTML =
                    '<i class="fa-solid fa-clock me-2"></i> Time Over – Auto Submitted';
            }

            new bootstrap.Modal(
                document.getElementById('resultModal'), {
                    backdrop: 'static',
                    keyboard: false
                }
            ).show();
        }


        function showAlreadySubmittedModal() {
            new bootstrap.Modal(
                document.getElementById('alreadySubmittedModal'), {
                    backdrop: 'static',
                    keyboard: false
                }
            ).show();

            lockExamUI();
        }


        function lockExamUI() {
            document.querySelectorAll('.option').forEach(opt => {
                opt.style.pointerEvents = 'none';
                opt.style.opacity = '0.6';
            });

            document.querySelectorAll('.btn-next, .btn-prev, .btn-mark').forEach(btn => {
                btn.disabled = true;
            });
        }
    </script>





    <!-- Full Guide Modal -->
    <!-- Full Guide Modal -->
    <div class="modal fade" id="guideModal" tabindex="-1" aria-labelledby="guideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content rounded-4 shadow">
                <!-- Modal Header -->
                <div class="modal-header bg-danger bg-opacity-25 border-0">
                    <h5 class="modal-title fw-bold  text-white" id="guideModalLabel">
                        <i class="fa-solid fa-book-open me-2 text-white"></i> General Instructions
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Exam Guidelines -->
                    <h6 class="fw-semibold mt-3 mb-3 mx-3">
                        <i class="fa-solid fa-list-check me-2"></i> Exam Guidelines:
                    </h6>
                    <ol class="ps-3 mb-4 mx-3">
                        <li class="mb-2">The total duration of the exam is <strong id="modalDuration">--</strong>
                            minutes.</li>
                        <li class="mb-2">The exam contains <strong id="modalTotalQuestions">--</strong> questions.
                        </li>
                        <li class="mb-2">Each question carries <strong>different marks</strong> as indicated.</li>
                        <li class="mb-2">There is <strong>no negative marking</strong> for incorrect answers.</li>
                        <li class="mb-2">Navigate using the <strong>Question Palette</strong> on the right.</li>
                        <li class="mb-2">Use <strong>"Mark for Review"</strong> to flag questions to revisit.</li>
                        <li class="mb-2">You can <strong>change your answers</strong> anytime before submission.</li>
                        <li class="mb-2">Click <strong>"Submit & Finish"</strong> when done.</li>
                        <li class="mb-2">The timer will automatically submit the test when time expires.</li>
                        <li class="mb-2">Ensure a stable internet connection throughout the exam.</li>
                    </ol>
                    <!-- Question Status Legend -->
                    <h6 class="fw-semibold mb-2"><i class="fa-solid fa-circle-info me-2"></i> Question Status Legend:
                    </h6>
                    <ul class="list-unstyled ps-3 my-3">
                        <li class="mb-2"><span class="badge rounded bg-success me-2">Answered</span> - You have
                            selected an answer</li>
                        <li class="mb-2"><span class="badge rounded bg-secondary me-2">Not Answered</span> - Visited
                            but not answered</li>
                        <li class="mb-2"><span class="badge rounded text-white"
                                style="background-color: #a855f7;">Marked</span> - Marked for review</li>
                        <li class="mb-2"><span class="badge rounded bg-light text-dark me-2">Not Visited</span> -
                            Not yet viewed</li>
                    </ul>

                    <!-- Important Alert -->
                    <div class="alert alert-warning d-flex align-items-start p-2 mt-3 small" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2 mt-1"></i>
                        <div>
                            <strong>Important:</strong> Once submitted, you cannot change your answers. Please review
                            carefully before submitting.
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary fw-semibold"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger fw-bold" data-bs-dismiss="modal">I
                        Understand</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Guide Modal -->




    <div class="modal fade" id="submitConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        Confirm Submission
                    </h5>
                </div>
                <div class="modal-body text-center">
                    <p class="fw-semibold mb-2">
                        Are you sure you want to submit the exam?
                    </p>
                    <p class="text-danger small">
                        ⚠ After submission, you cannot change your answers.
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-danger fw-bold" onclick="finalSubmit('manual')">
                        Yes, Submit
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="timeWarningModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 text-center">
                <div class="modal-body py-4">
                    <h5 class="fw-bold text-danger mb-2">
                        ⏰ Time Almost Over
                    </h5>
                    <p class="mb-0">
                        Only <strong>5 minutes</strong> remaining. Please review and submit.
                    </p>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="resultModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        Exam Submitted
                    </h5>
                </div>

                <div class="modal-body text-center p-4">
                    <div class="mb-3 fs-1 text-success">
                        🎉
                    </div>

                    <h5 class="fw-bold mb-2">Submission Successful</h5>

                    <p class="text-muted mb-3">
                        Your responses have been recorded.
                    </p>

                    <div class="border rounded-3 p-3 mb-3 bg-light">
                        <div class="fw-semibold">Answered Questions</div>
                        <div class="fs-4 fw-bold text-success" id="resultAnswered">0</div>

                        <div class="fw-semibold mt-2">Time Taken</div>
                        <div class="fw-bold text-primary" id="resultTime">0 sec</div>
                        <div id="certificateMessage"></div>
                    </div>

                    <a href="{{ route('student.dashboard') }}" class="btn btn-primary w-100 mb-2 fw-bold">
                        View Full Result
                    </a>


                    <button class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>



    <div class="modal fade" id="alreadySubmittedModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        Exam Already Submitted
                    </h5>
                </div>

                <div class="modal-body text-center p-4">
                    <div class="fs-1 mb-3">⚠️</div>

                    <p class="fw-semibold mb-2">
                        You have already submitted this exam.
                    </p>

                    <p class="text-muted small mb-3">
                        Multiple submissions are not allowed.
                    </p>

                    <a href="{{ route('student.dashboard') }}" class="btn btn-danger w-100 fw-bold mb-2">
                        Go to Dashboard
                    </a>

                    <button class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>


</body>

</html>
