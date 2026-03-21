<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results — LMS</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg: #0b0f1a;
            --surface: #131929;
            --surface2: #1a2236;
            --border: rgba(255, 255, 255, 0.07);
            --accent: #6c63ff;
            --accent2: #00d4aa;
            --text: #e8eaf0;
            --muted: #6b7a99;
            --success: #00d4aa;
            --danger: #ff4d6d;
            --warning: #ffa94d;
            --info: #4dabf7;

            --grade-aplus: #00d4aa;
            --grade-a: #51cf66;
            --grade-b: #4dabf7;
            --grade-c: #ffa94d;
            --grade-d: #ff8787;
            --grade-f: #ff4d6d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            min-height: 100vh;
            padding: 40px 20px;
        }

        /* ─── GRADE SYSTEM HEADER ─── */
        .grade-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .grade-header-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #ffa94d, #ff6b35);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 4px 16px rgba(255, 169, 77, 0.3);
        }

        .grade-header h5 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: var(--text);
            letter-spacing: 0.5px;
        }

        /* ─── GRADE CHIPS ─── */
        .grade-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 36px;
        }

        .grade-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .grade-chip:hover {
            transform: translateY(-1px);
        }

        .grade-chip .chip-letter {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 13px;
        }

        .grade-chip.aplus {
            background: rgba(0, 212, 170, 0.12);
            border-color: rgba(0, 212, 170, 0.3);
            color: #00d4aa;
        }

        .grade-chip.a {
            background: rgba(81, 207, 102, 0.12);
            border-color: rgba(81, 207, 102, 0.3);
            color: #51cf66;
        }

        .grade-chip.b {
            background: rgba(77, 171, 247, 0.12);
            border-color: rgba(77, 171, 247, 0.3);
            color: #4dabf7;
        }

        .grade-chip.c {
            background: rgba(255, 169, 77, 0.12);
            border-color: rgba(255, 169, 77, 0.3);
            color: #ffa94d;
        }

        .grade-chip.d {
            background: rgba(255, 135, 135, 0.12);
            border-color: rgba(255, 135, 135, 0.3);
            color: #ff8787;
        }

        .grade-chip.f {
            background: rgba(255, 77, 109, 0.12);
            border-color: rgba(255, 77, 109, 0.3);
            color: #ff4d6d;
        }

        /* ─── RESULT CARD ─── */
        .result-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.25s, box-shadow 0.25s;
            animation: slideUp 0.5s ease both;
        }

        .result-card:nth-child(2) {
            animation-delay: 0.05s;
        }

        .result-card:nth-child(3) {
            animation-delay: 0.10s;
        }

        .result-card:nth-child(4) {
            animation-delay: 0.15s;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .result-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(108, 99, 255, 0.3);
        }

        /* ─── CARD TOP ACCENT BAR ─── */
        .card-accent-bar {
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            width: 100%;
        }

        .card-accent-bar.fail {
            background: linear-gradient(90deg, #ff4d6d, #ff8787);
        }

        /* ─── CARD BODY ─── */
        .card-main {
            padding: 24px 28px;
        }

        .card-top-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }

        /* ─── LEFT ─── */
        .card-left {}

        .quiz-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 17px;
            color: var(--text);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .attempt-meta {
            font-size: 12.5px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .attempt-meta .dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--muted);
            opacity: 0.5;
        }

        .attempt-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(108, 99, 255, 0.15);
            border: 1px solid rgba(108, 99, 255, 0.25);
            color: #a5a0ff;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 500;
        }

        /* ─── RIGHT ─── */
        .card-right {
            text-align: right;
            flex-shrink: 0;
        }

        .score-display {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 26px;
            line-height: 1;
            background: linear-gradient(135deg, var(--text), var(--muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .score-display.pass-score {
            background: linear-gradient(135deg, var(--accent2), #51cf66);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .score-display.fail-score {
            background: linear-gradient(135deg, #ff4d6d, #ff8787);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .score-percent {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .badge-row {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
            margin-top: 8px;
        }

        .lms-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            font-family: 'Syne', sans-serif;
            text-transform: uppercase;
        }

        .lms-badge.grade-aplus {
            background: rgba(0, 212, 170, 0.15);
            color: #00d4aa;
            border: 1px solid rgba(0, 212, 170, 0.3);
        }

        .lms-badge.grade-a {
            background: rgba(81, 207, 102, 0.15);
            color: #51cf66;
            border: 1px solid rgba(81, 207, 102, 0.3);
        }

        .lms-badge.grade-b {
            background: rgba(77, 171, 247, 0.15);
            color: #4dabf7;
            border: 1px solid rgba(77, 171, 247, 0.3);
        }

        .lms-badge.grade-c {
            background: rgba(255, 169, 77, 0.15);
            color: #ffa94d;
            border: 1px solid rgba(255, 169, 77, 0.3);
        }

        .lms-badge.grade-d {
            background: rgba(255, 135, 135, 0.15);
            color: #ff8787;
            border: 1px solid rgba(255, 135, 135, 0.3);
        }

        .lms-badge.grade-f {
            background: rgba(255, 77, 109, 0.15);
            color: #ff4d6d;
            border: 1px solid rgba(255, 77, 109, 0.3);
        }

        .lms-badge.pass {
            background: rgba(0, 212, 170, 0.1);
            color: #00d4aa;
            border: 1px solid rgba(0, 212, 170, 0.2);
        }

        .lms-badge.fail {
            background: rgba(255, 77, 109, 0.1);
            color: #ff4d6d;
            border: 1px solid rgba(255, 77, 109, 0.2);
        }

        /* ─── PROGRESS BAR ─── */
        .progress-wrap {
            margin-top: 20px;
            position: relative;
        }

        .progress-track {
            height: 6px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50px;
            overflow: visible;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            border-radius: 50px;
            position: relative;
            transition: width 1s cubic-bezier(0.25, 1, 0.5, 1);
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            box-shadow: 0 0 10px rgba(108, 99, 255, 0.5);
        }

        .progress-fill.fail-fill {
            background: linear-gradient(90deg, #ff4d6d, #ff8787);
            box-shadow: 0 0 10px rgba(255, 77, 109, 0.4);
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 6px;
        }

        .progress-labels span {
            font-size: 11px;
            color: var(--muted);
        }

        /* ─── CARD FOOTER ─── */
        .card-footer-row {
            display: flex;
            justify-content: flex-end;
            padding: 14px 28px;
            border-top: 1px solid var(--border);
            background: rgba(0, 0, 0, 0.15);
        }

        .details-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid rgba(108, 99, 255, 0.35);
            background: rgba(108, 99, 255, 0.08);
            color: #a5a0ff;
            font-size: 13px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
        }

        .details-btn:hover {
            background: rgba(108, 99, 255, 0.18);
            border-color: rgba(108, 99, 255, 0.6);
            color: #fff;
            box-shadow: 0 0 20px rgba(108, 99, 255, 0.2);
        }

        .details-btn i {
            font-size: 11px;
            transition: transform 0.3s;
        }

        .details-btn.open i {
            transform: rotate(180deg);
        }

        /* ─── COLLAPSIBLE DETAILS ─── */
        .details-collapse {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .details-collapse.open {
            max-height: 2000px;
        }

        .details-inner {
            padding: 24px 28px;
            border-top: 1px solid var(--border);
            background: rgba(0, 0, 0, 0.12);
        }

        .details-title {
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 16px;
        }

        /* ─── QUESTION CARD ─── */
        .q-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 12px;
            transition: border-color 0.2s;
            position: relative;
            overflow: hidden;
        }

        .q-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            border-radius: 3px 0 0 3px;
        }

        .q-card.correct::before {
            background: var(--success);
        }

        .q-card.wrong::before {
            background: var(--danger);
        }

        .q-card:hover {
            border-color: rgba(255, 255, 255, 0.12);
        }

        .q-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }

        .q-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            font-family: 'Syne', sans-serif;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .q-card.correct .q-number {
            background: rgba(0, 212, 170, 0.15);
            color: var(--success);
        }

        .q-card.wrong .q-number {
            background: rgba(255, 77, 109, 0.15);
            color: var(--danger);
        }

        .q-text {
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            line-height: 1.5;
            flex: 1;
        }

        .q-marks {
            text-align: right;
            flex-shrink: 0;
        }

        .q-marks .mark-val {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 16px;
        }

        .q-marks .mark-label {
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .q-marks.earned .mark-val {
            color: var(--success);
        }

        .q-marks.zero .mark-val {
            color: var(--danger);
        }

        /* ─── ANSWER ROWS ─── */
        .answer-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-top: 6px;
        }

        .answer-row.your-correct {
            background: rgba(0, 212, 170, 0.08);
            border: 1px solid rgba(0, 212, 170, 0.2);
            color: var(--success);
        }

        .answer-row.your-wrong {
            background: rgba(255, 77, 109, 0.08);
            border: 1px solid rgba(255, 77, 109, 0.2);
            color: var(--danger);
        }

        .answer-row.correct-ans {
            background: rgba(0, 212, 170, 0.05);
            border: 1px dashed rgba(0, 212, 170, 0.25);
            color: var(--success);
        }

        .answer-row .ans-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            opacity: 0.7;
            min-width: 80px;
            font-family: 'Syne', sans-serif;
        }

        .answer-row .ans-icon {
            font-size: 12px;
            flex-shrink: 0;
        }

        /* ─── STATUS PILL ─── */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-top: 10px;
            font-family: 'Syne', sans-serif;
        }

        .status-pill.correct-pill {
            background: rgba(0, 212, 170, 0.15);
            color: var(--success);
            border: 1px solid rgba(0, 212, 170, 0.3);
        }

        .status-pill.wrong-pill {
            background: rgba(255, 77, 109, 0.15);
            color: var(--danger);
            border: 1px solid rgba(255, 77, 109, 0.3);
        }

        /* ─── EMPTY STATE ─── */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-icon {
            font-size: 48px;
            color: var(--muted);
            opacity: 0.3;
            margin-bottom: 16px;
        }

        .empty-state p {
            color: var(--muted);
            font-size: 15px;
        }

        /* ─── CONTAINER ─── */
        .lms-container {
            max-width: 820px;
            margin: 0 auto;
        }

        .section-heading {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 22px;
            margin-bottom: 6px;
            background: linear-gradient(135deg, var(--text), var(--muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-sub {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 28px;
        }
    </style>
</head>

<body>

    <div class="lms-container">

        <!-- Page Title -->
        <h2 class="section-heading">Quiz Results</h2>
        <p class="section-sub">Your performance across all quiz attempts</p>

        <!-- Grade System -->
        <div class="grade-header">
            <div class="grade-header-icon"><i class="fa-solid fa-ranking-star" style="color:#fff"></i></div>
            <h5>Grade System</h5>
        </div>

        <div class="grade-chips">
            <div class="grade-chip aplus"><span class="chip-letter">A+</span> Excellent · 90–100%</div>
            <div class="grade-chip a"><span class="chip-letter">A</span> Very Good · 80–89%</div>
            <div class="grade-chip b"><span class="chip-letter">B</span> Good · 70–79%</div>
            <div class="grade-chip c"><span class="chip-letter">C</span> Average · 60–69%</div>
            <div class="grade-chip d"><span class="chip-letter">D</span> Below Avg · 50–59%</div>
            <div class="grade-chip f"><span class="chip-letter">F</span> Fail · &lt;50%</div>
        </div>

        <!-- ═══ RESULT CARD 1 (Pass, A+) ═══ -->
        <div class="result-card" id="card1">
            <div class="card-accent-bar"></div>
            <div class="card-main">
                <div class="card-top-row">
                    <div class="card-left">
                        <div class="quiz-title">
                            <i class="fa-solid fa-brain" style="color:var(--accent);font-size:15px;"></i>
                            Introduction to Machine Learning
                        </div>
                        <div class="attempt-meta">
                            <span class="attempt-badge"><i class="fa-solid fa-rotate-right" style="font-size:9px;"></i>
                                Attempt #1</span>
                            <span class="dot"></span>
                            <span><i class="fa-regular fa-clock" style="margin-right:4px;"></i>14 Feb 2025, 10:30
                                AM</span>
                        </div>
                    </div>
                    <div class="card-right">
                        <div class="score-display pass-score">18 <span style="font-size:16px;opacity:0.6;">/ 20</span>
                        </div>
                        <div class="score-percent">90.00%</div>
                        <div class="badge-row">
                            <span class="lms-badge grade-aplus">A+</span>
                            <span class="lms-badge pass"><i class="fa-solid fa-check" style="font-size:9px;"></i>
                                Pass</span>
                        </div>
                    </div>
                </div>

                <div class="progress-wrap">
                    <div class="progress-track">
                        <div class="progress-fill" style="width:90%"></div>
                    </div>
                    <div class="progress-labels">
                        <span>0%</span>
                        <span style="color:var(--accent2);font-weight:600;">90%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>

            <div class="card-footer-row">
                <button class="details-btn" onclick="toggleDetails('d1', this)">
                    <i class="fa-solid fa-chevron-down"></i> View Details
                </button>
            </div>

            <div class="details-collapse" id="d1">
                <div class="details-inner">
                    <div class="details-title"><i class="fa-solid fa-list-ul me-1"></i> Question Breakdown</div>

                    <!-- Q1 correct -->
                    <div class="q-card correct">
                        <div class="q-header">
                            <span class="q-number">1</span>
                            <div class="q-text">What does the acronym "ML" stand for in the context of artificial
                                intelligence?</div>
                            <div class="q-marks earned">
                                <div class="mark-val">2/2</div>
                                <div class="mark-label">Marks</div>
                            </div>
                        </div>
                        <div class="answer-row your-correct">
                            <span class="ans-label">Your Answer</span>
                            <i class="fas fa-check-circle ans-icon"></i>
                            Machine Learning
                        </div>
                        <div><span class="status-pill correct-pill"><i class="fa-solid fa-circle-check"></i>
                                Correct</span></div>
                    </div>

                    <!-- Q2 wrong -->
                    <div class="q-card wrong">
                        <div class="q-header">
                            <span class="q-number">2</span>
                            <div class="q-text">Which algorithm is commonly used for classification in supervised
                                learning?</div>
                            <div class="q-marks zero">
                                <div class="mark-val">0/2</div>
                                <div class="mark-label">Marks</div>
                            </div>
                        </div>
                        <div class="answer-row your-wrong">
                            <span class="ans-label">Your Answer</span>
                            <i class="fas fa-times-circle ans-icon"></i>
                            K-Means Clustering
                        </div>
                        <div class="answer-row correct-ans">
                            <span class="ans-label">Correct</span>
                            <i class="fas fa-check-circle ans-icon"></i>
                            Decision Tree
                        </div>
                        <div><span class="status-pill wrong-pill"><i class="fa-solid fa-circle-xmark"></i> Wrong</span>
                        </div>
                    </div>

                    <!-- Q3 correct -->
                    <div class="q-card correct">
                        <div class="q-header">
                            <span class="q-number">3</span>
                            <div class="q-text">What type of learning does reinforcement learning fall under?</div>
                            <div class="q-marks earned">
                                <div class="mark-val">2/2</div>
                                <div class="mark-label">Marks</div>
                            </div>
                        </div>
                        <div class="answer-row your-correct">
                            <span class="ans-label">Your Answer</span>
                            <i class="fas fa-check-circle ans-icon"></i>
                            Agent-based reward learning
                        </div>
                        <div><span class="status-pill correct-pill"><i class="fa-solid fa-circle-check"></i>
                                Correct</span></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ═══ RESULT CARD 2 (Fail, F) ═══ -->
        <div class="result-card" id="card2">
            <div class="card-accent-bar fail"></div>
            <div class="card-main">
                <div class="card-top-row">
                    <div class="card-left">
                        <div class="quiz-title">
                            <i class="fa-solid fa-database" style="color:#ff4d6d;font-size:15px;"></i>
                            Database Management Systems
                        </div>
                        <div class="attempt-meta">
                            <span class="attempt-badge"><i class="fa-solid fa-rotate-right"
                                    style="font-size:9px;"></i> Attempt #2</span>
                            <span class="dot"></span>
                            <span><i class="fa-regular fa-clock" style="margin-right:4px;"></i>15 Feb 2025, 02:15
                                PM</span>
                        </div>
                    </div>
                    <div class="card-right">
                        <div class="score-display fail-score">8 <span style="font-size:16px;opacity:0.6;">/ 20</span>
                        </div>
                        <div class="score-percent">40.00%</div>
                        <div class="badge-row">
                            <span class="lms-badge grade-f">F</span>
                            <span class="lms-badge fail"><i class="fa-solid fa-xmark" style="font-size:9px;"></i>
                                Fail</span>
                        </div>
                    </div>
                </div>

                <div class="progress-wrap">
                    <div class="progress-track">
                        <div class="progress-fill fail-fill" style="width:40%"></div>
                    </div>
                    <div class="progress-labels">
                        <span>0%</span>
                        <span style="color:var(--danger);font-weight:600;">40%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>

            <div class="card-footer-row">
                <button class="details-btn" onclick="toggleDetails('d2', this)">
                    <i class="fa-solid fa-chevron-down"></i> View Details
                </button>
            </div>

            <div class="details-collapse" id="d2">
                <div class="details-inner">
                    <div class="details-title"><i class="fa-solid fa-list-ul me-1"></i> Question Breakdown</div>

                    <div class="q-card correct">
                        <div class="q-header">
                            <span class="q-number">1</span>
                            <div class="q-text">What does SQL stand for?</div>
                            <div class="q-marks earned">
                                <div class="mark-val">2/2</div>
                                <div class="mark-label">Marks</div>
                            </div>
                        </div>
                        <div class="answer-row your-correct">
                            <span class="ans-label">Your Answer</span>
                            <i class="fas fa-check-circle ans-icon"></i>
                            Structured Query Language
                        </div>
                        <div><span class="status-pill correct-pill"><i class="fa-solid fa-circle-check"></i>
                                Correct</span></div>
                    </div>

                    <div class="q-card wrong">
                        <div class="q-header">
                            <span class="q-number">2</span>
                            <div class="q-text">Which normal form eliminates transitive dependencies?</div>
                            <div class="q-marks zero">
                                <div class="mark-val">0/2</div>
                                <div class="mark-label">Marks</div>
                            </div>
                        </div>
                        <div class="answer-row your-wrong">
                            <span class="ans-label">Your Answer</span>
                            <i class="fas fa-times-circle ans-icon"></i>
                            2NF
                        </div>
                        <div class="answer-row correct-ans">
                            <span class="ans-label">Correct</span>
                            <i class="fas fa-check-circle ans-icon"></i>
                            3NF (Third Normal Form)
                        </div>
                        <div><span class="status-pill wrong-pill"><i class="fa-solid fa-circle-xmark"></i>
                                Wrong</span></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ═══ EMPTY STATE ═══ -->
        <!-- Uncomment to preview empty state:
  <div class="empty-state">
    <div class="empty-icon"><i class="fa-solid fa-clipboard-question"></i></div>
    <p>No quiz attempts found yet.</p>
  </div>
  -->

    </div>

    <script>
        function toggleDetails(id, btn) {
            const el = document.getElementById(id);
            const isOpen = el.classList.contains('open');
            el.classList.toggle('open', !isOpen);
            btn.classList.toggle('open', !isOpen);
            btn.innerHTML = isOpen ?
                '<i class="fa-solid fa-chevron-down"></i> View Details' :
                '<i class="fa-solid fa-chevron-up"></i> Hide Details';
        }
    </script>

</body>

</html>
