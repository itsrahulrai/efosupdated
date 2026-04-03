@extends('frontend.layout.layout')
@section('title', 'Mentorship Program | Book Expert Mentors | EFOS Edumarketers Pvt Ltd')
@section('meta_description',
    'Connect with expert mentors at EFOS. Book 1-to-1 mentorship sessions for career guidance,
    interview preparation, skills development and professional growth.')
@section('meta_keywords',
    'mentorship program, expert mentors, career mentorship, online mentoring, career guidance
    mentor, skill development mentor, interview mentor')
@section('meta_robots', 'index, follow')
@section('canonical', url('mentorship'))

@push('style')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Premium color palette with E72434 */
            --primary: #E72434;
            --primary-light: #FFE8EB;
            --primary-dark: #C41C28;
            --accent: #1A1A1A;
            --accent-light: #F5F5F5;
            --dark: #0F1419;
            --dark-secondary: #1E2329;
            --light: #FFFFFF;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --success: #10B981;
            --success-light: #D1FAE5;
        }

        html,
        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
            background: var(--gray-50);
            color: var(--dark);
            line-height: 1.6;
            letter-spacing: 0.3px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ===== BANNER SECTION ===== */
        /* Banner styling removed - customize as needed */

        /* ===== MENTOR DETAILS SECTION ===== */
        .mentor-details-section {
            padding: 80px 0;
            background: var(--gray-50);
        }

        .mentor-layout {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 50px;
            align-items: start;
        }

        /* ===== LEFT SIDEBAR ===== */
        .mentor-sidebar {
            position: sticky;
            top: 40px;
        }

        /* Profile Card */
        .profile-card {
            margin-bottom: 32px;
        }

        .mentor-img {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 16px;
            object-fit: cover;
            margin-bottom: 24px;
            display: block;
            box-shadow: 0 25px 70px rgba(231, 36, 52, 0.18), 0 0 1px rgba(0, 0, 0, 0.1);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
        }

        .mentor-img::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .mentor-img:hover {
            transform: scale(1.03) translateY(-6px);
            box-shadow: 0 35px 90px rgba(231, 36, 52, 0.25), 0 0 1px rgba(0, 0, 0, 0.1);
        }

        .mentor-name {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .mentor-role {
            font-size: 12px;
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
            display: inline-block;
            padding: 8px 14px;
            background: var(--primary-light);
            border-radius: 6px;
            border: 1px solid rgba(231, 36, 52, 0.2);
        }

        /* Mentor Meta */
        .mentor-meta {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 20px 0;
            border-top: 1px solid var(--gray-200);
            border-bottom: 1px solid var(--gray-200);
            margin-bottom: 28px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--gray-600);
        }

        .meta-item strong {
            color: var(--dark);
            font-weight: 600;
        }

        .meta-item::before {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
        }

        /* Price Section */
        .price-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--light);
            padding: 32px 28px;
            border-radius: 16px;
            margin-bottom: 24px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(231, 36, 52, 0.25);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .price-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            animation: pulse-gradient 4s ease-in-out infinite;
        }

        @keyframes pulse-gradient {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.1); opacity: 0.9; }
        }

        .price {
            font-size: 48px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .price-subtext {
            font-size: 13px;
            opacity: 0.98;
            font-weight: 600;
            position: relative;
            z-index: 1;
            letter-spacing: 0.5px;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 32px;
        }

        .btn {
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        /* Book Session Button */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--light);
            box-shadow: 0 12px 32px rgba(231, 36, 52, 0.3);
            font-weight: 700;
            letter-spacing: 0.4px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, transparent 100%);
            border-radius: 10px;
            pointer-events: none;
        }

        .btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 48px rgba(231, 36, 52, 0.42);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        /* Message Button */
        .btn-secondary {
            background: var(--light);
            border: 2px solid var(--gray-200);
            color: var(--dark);
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(231, 36, 52, 0.15);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .stat-box {
            background: var(--light);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--gray-200);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            position: relative;
        }

        .stat-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 12px 12px 0 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-box:hover::before {
            opacity: 1;
        }

        .stat-number {
            font-size: 26px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--gray-600);
            font-weight: 600;
            line-height: 1.4;
            letter-spacing: 0.3px;
        }

        /* ===== RIGHT CONTENT ===== */
        .mentor-main {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        /* Content Cards */
        .content-card {
            background: var(--light);
            padding: 36px;
            border-radius: 16px;
            border: 1px solid var(--gray-200);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideUp 0.6s ease forwards;
            opacity: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: visible;
        }

        .content-card:nth-child(1) { animation-delay: 0.1s; }
        .content-card:nth-child(2) { animation-delay: 0.2s; }
        .content-card:nth-child(3) { animation-delay: 0.3s; }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-card:hover {
            border-color: var(--primary);
            box-shadow: 0 16px 48px rgba(231, 36, 52, 0.14);
            transform: translateY(-6px);
        }

        .content-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(231, 36, 52, 0.02) 0%, transparent 100%);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .content-card:hover::before {
            opacity: 1;
        }

        /* Card Title */
        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.3px;
        }

        .card-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 2px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(231, 36, 52, 0.25);
        }

        /* Card Text */
        .card-text {
            font-size: 15px;
            color: var(--gray-600);
            line-height: 1.8;
            margin-bottom: 20px;
        }

        /* About Section */
        .about-text {
            font-size: 15px;
            line-height: 1.8;
            color: var(--gray-600);
        }

        /* Skills/Tags */
        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .skill-tag {
            display: inline-block;
            background: var(--gray-100);
            color: var(--dark);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid var(--gray-200);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
            letter-spacing: 0.3px;
        }

        .skill-tag:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(231, 36, 52, 0.18);
        }

        /* Time Slots */
        .slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 12px;
            margin-top: 24px;
            margin-bottom: 28px;
        }

        .slot {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px 12px;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-600);
            background: var(--light);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.3px;
        }

        .slot:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(231, 36, 52, 0.22);
        }

        .slot.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--light);
            border-color: var(--primary);
            box-shadow: 0 8px 20px rgba(231, 36, 52, 0.35);
            font-weight: 700;
        }

        /* Days Selector */
        .days-selector {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--gray-200);
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .days-selector::-webkit-scrollbar {
            height: 4px;
        }

        .days-selector::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 10px;
        }

        .days-selector::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        .day-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            background: var(--light);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            flex-shrink: 0;
            position: relative;
        }

        .day-btn .day-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--dark);
            display: block;
            margin-bottom: 4px;
            letter-spacing: 0.3px;
        }

        .day-btn .day-date {
            font-size: 11px;
            color: var(--gray-500);
            font-weight: 600;
        }

        .day-btn:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(231, 36, 52, 0.15);
        }

        .day-btn.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-color: var(--primary);
            color: var(--light);
            box-shadow: 0 8px 20px rgba(231, 36, 52, 0.3);
        }

        .day-btn.active .day-name,
        .day-btn.active .day-date {
            color: var(--light);
        }

        /* Animation for slot visibility */
        .slot.show-slot {
            animation: slideInSlot 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes slideInSlot {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Booking Section */
        .booking-section {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 2px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .selected-time-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
            min-width: 200px;
        }

        .info-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: var(--dark);
            letter-spacing: 0.3px;
        }

        /* Book Button */
        .btn-book-session {
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--light);
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 12px 32px rgba(231, 36, 52, 0.3);
            letter-spacing: 0.4px;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }

        .btn-book-session::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, transparent 100%);
            border-radius: 10px;
            pointer-events: none;
        }

        .btn-book-session:not(:disabled):hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 48px rgba(231, 36, 52, 0.42);
        }

        .btn-book-session:not(:disabled):active {
            transform: translateY(-1px);
        }

        .btn-book-session:disabled {
            background: linear-gradient(135deg, var(--gray-400) 0%, var(--gray-500) 100%);
            cursor: not-allowed;
            opacity: 0.6;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-book-session i {
            font-size: 16px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .mentor-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .mentor-sidebar {
                position: static;
            }

            .banner-inner__content h1 {
                font-size: 42px;
            }
        }

        @media (max-width: 640px) {
            .mentor-details-section {
                padding: 60px 0;
            }

            .banner-inner-area {
                padding: 70px 0;
            }

            .banner-inner__content h1 {
                font-size: 32px;
                margin-bottom: 20px;
            }

            .mentor-name {
                font-size: 24px;
            }

            .content-card {
                padding: 24px;
            }

            .card-title {
                font-size: 16px;
                margin-bottom: 18px;
            }

            .slots-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .days-selector {
                gap: 8px;
                margin-bottom: 20px;
            }

            .day-btn {
                padding: 10px 14px;
                font-size: 12px;
            }

            .day-btn .day-name {
                font-size: 11px;
                margin-bottom: 2px;
            }

            .day-btn .day-date {
                font-size: 10px;
            }

            .booking-section {
                flex-direction: column;
                align-items: stretch;
                gap: 14px;
            }

            .selected-time-info {
                min-width: 100%;
            }

            .btn-book-session {
                width: 100%;
                padding: 16px 24px;
                font-size: 16px;
            }

            .container {
                padding: 0 16px;
            }

            .btn-group {
                gap: 10px;
            }

            .btn {
                padding: 12px 16px;
                font-size: 14px;
            }
        }
    </style>
@endpush

@section('content')

    <main>
        <!-- Banner -->
        <section class="banner-inner-area">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>Mentorship</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Mentorship</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Mentor Details -->
        <section class="mentor-details-section">
            <div class="container">
                <div class="mentor-layout">

                    <!-- LEFT SIDEBAR -->
                    <div class="mentor-sidebar">

                        <!-- Profile -->
                        <div class="profile-card">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=400&fit=crop"
                                alt="Rida Louiss" class="mentor-img">
                            <div class="mentor-name">Rida Louiss</div>
                            <div class="mentor-role">Senior Product Mentor</div>
                        </div>

                        <!-- Meta Info -->
                        <div class="mentor-meta">
                            <div class="meta-item">
                                <span><strong>London</strong>, United Kingdom</span>
                            </div>
                            <div class="meta-item">
                                <span><strong>Verified</strong> Mentor</span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="price-section">
                            <div class="price">₹56</div>
                            <div class="price-subtext">40 min session</div>
                        </div>

                        <!-- Buttons -->
                        <div class="btn-group">
                            <button class="btn btn-secondary">Send Message</button>
                        </div>
                        
                        <!-- Stats -->
                        <div class="stats-grid">
                            <div class="stat-box">
                                <div class="stat-number">10+</div>
                                <div class="stat-label">Years of Experience</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-number">500+</div>
                                <div class="stat-label">Sessions Completed</div>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT CONTENT -->
                    <div class="mentor-main">

                        <!-- About -->
                        <div class="content-card">
                            <div class="card-title">About Mentor</div>
                            <p class="about-text">
                                I am a Senior Product Designer with over a decade of experience in building user-centric
                                digital products. I've worked with leading tech companies and startups to transform ideas
                                into successful products that impact millions of users. My passion is helping the next
                                generation of designers achieve their career goals.
                            </p>
                        </div>

                        <!-- Expertise -->
                        <div class="content-card">
                            <div class="card-title">Mentorship Expertise</div>
                            <div class="skills-container">
                                <div class="skill-tag">Product Strategy</div>
                                <div class="skill-tag">Career Growth</div>
                                <div class="skill-tag">UX Design</div>
                                <div class="skill-tag">Portfolio Review</div>
                                <div class="skill-tag">Interview Prep</div>
                                <div class="skill-tag">Team Leadership</div>
                                <div class="skill-tag">User Research</div>
                                <div class="skill-tag">Design Systems</div>
                            </div>
                        </div>

                        <!-- Available Slots -->
                        <div class="content-card">
                            <div class="card-title">Available Time Slots</div>
                            <p class="card-text">Select a day and time that works best for you</p>
                            
                            <!-- Day Selector -->
                            <div class="days-selector">
                                <button class="day-btn active" data-day="0">
                                    <span class="day-name">Monday</span>
                                    <span class="day-date">Jan 6</span>
                                </button>
                                <button class="day-btn" data-day="1">
                                    <span class="day-name">Tuesday</span>
                                    <span class="day-date">Jan 7</span>
                                </button>
                                <button class="day-btn" data-day="2">
                                    <span class="day-name">Wednesday</span>
                                    <span class="day-date">Jan 8</span>
                                </button>
                                <button class="day-btn" data-day="3">
                                    <span class="day-name">Thursday</span>
                                    <span class="day-date">Jan 9</span>
                                </button>
                                <button class="day-btn" data-day="4">
                                    <span class="day-name">Friday</span>
                                    <span class="day-date">Jan 10</span>
                                </button>
                            </div>

                            <!-- Time Slots -->
                            <div class="slots-grid" id="slotsContainer">
                                <div class="slot" data-day="0">10:00 AM</div>
                                <div class="slot" data-day="0">10:30 AM</div>
                                <div class="slot" data-day="0">11:00 AM</div>
                                <div class="slot" data-day="0">11:30 AM</div>
                                <div class="slot" data-day="0">12:00 PM</div>
                                <div class="slot" data-day="0">2:00 PM</div>
                                <div class="slot" data-day="0">2:30 PM</div>
                                <div class="slot" data-day="0">3:00 PM</div>

                                <div class="slot" data-day="1" style="display:none;">9:00 AM</div>
                                <div class="slot" data-day="1" style="display:none;">9:30 AM</div>
                                <div class="slot" data-day="1" style="display:none;">10:00 AM</div>
                                <div class="slot" data-day="1" style="display:none;">10:30 AM</div>
                                <div class="slot" data-day="1" style="display:none;">1:00 PM</div>
                                <div class="slot" data-day="1" style="display:none;">1:30 PM</div>
                                <div class="slot" data-day="1" style="display:none;">3:00 PM</div>
                                <div class="slot" data-day="1" style="display:none;">3:30 PM</div>

                                <div class="slot" data-day="2" style="display:none;">10:00 AM</div>
                                <div class="slot" data-day="2" style="display:none;">11:00 AM</div>
                                <div class="slot" data-day="2" style="display:none;">12:00 PM</div>
                                <div class="slot" data-day="2" style="display:none;">2:00 PM</div>
                                <div class="slot" data-day="2" style="display:none;">2:30 PM</div>
                                <div class="slot" data-day="2" style="display:none;">3:00 PM</div>
                                <div class="slot" data-day="2" style="display:none;">4:00 PM</div>
                                <div class="slot" data-day="2" style="display:none;">4:30 PM</div>

                                <div class="slot" data-day="3" style="display:none;">9:30 AM</div>
                                <div class="slot" data-day="3" style="display:none;">10:00 AM</div>
                                <div class="slot" data-day="3" style="display:none;">10:30 AM</div>
                                <div class="slot" data-day="3" style="display:none;">11:00 AM</div>
                                <div class="slot" data-day="3" style="display:none;">2:30 PM</div>
                                <div class="slot" data-day="3" style="display:none;">3:00 PM</div>
                                <div class="slot" data-day="3" style="display:none;">3:30 PM</div>
                                <div class="slot" data-day="3" style="display:none;">4:00 PM</div>

                                <div class="slot" data-day="4" style="display:none;">10:00 AM</div>
                                <div class="slot" data-day="4" style="display:none;">10:30 AM</div>
                                <div class="slot" data-day="4" style="display:none;">11:30 AM</div>
                                <div class="slot" data-day="4" style="display:none;">1:00 PM</div>
                                <div class="slot" data-day="4" style="display:none;">1:30 PM</div>
                                <div class="slot" data-day="4" style="display:none;">2:00 PM</div>
                                <div class="slot" data-day="4" style="display:none;">3:00 PM</div>
                                <div class="slot" data-day="4" style="display:none;">3:30 PM</div>
                            </div>

                            <!-- Selected Time Display & Book Button -->
                            <div class="booking-section">
                                <div class="selected-time-info">
                                    <span class="info-label">Selected Time:</span>
                                    <span class="info-value" id="selectedTimeDisplay">No time selected</span>
                                </div>
                                <button class="btn-book-session" id="bookBtn" disabled>
                                    <i class="fa-solid fa-calendar-check"></i>
                                    Book a Session
                                </button>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const dayBtns = document.querySelectorAll('.day-btn');
                                const slots = document.querySelectorAll('.slot');
                                const bookBtn = document.getElementById('bookBtn');
                                const selectedTimeDisplay = document.getElementById('selectedTimeDisplay');
                                const dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                                const dayDates = ['Jan 6', 'Jan 7', 'Jan 8', 'Jan 9', 'Jan 10'];
                                
                                let selectedDay = 0;
                                let selectedTime = null;

                                dayBtns.forEach(btn => {
                                    btn.addEventListener('click', function() {
                                        const day = parseInt(this.dataset.day);
                                        selectedDay = day;
                                        selectedTime = null;

                                        // Update active button
                                        dayBtns.forEach(b => b.classList.remove('active'));
                                        this.classList.add('active');

                                        // Show/hide slots with animation
                                        slots.forEach(slot => {
                                            const slotDay = parseInt(slot.dataset.day);
                                            if (slotDay === day) {
                                                slot.style.display = 'flex';
                                                slot.classList.add('show-slot');
                                                slot.classList.remove('active');
                                            } else {
                                                slot.style.display = 'none';
                                                slot.classList.remove('show-slot');
                                            }
                                        });

                                        // Reset display
                                        updateSelectedTimeDisplay();
                                    });
                                });

                                // Slot selection
                                slots.forEach(slot => {
                                    slot.addEventListener('click', function() {
                                        // Only select if visible (for current day)
                                        if (this.style.display !== 'none') {
                                            // Remove active from other slots
                                            slots.forEach(s => s.classList.remove('active'));
                                            // Add active to clicked slot
                                            this.classList.add('active');
                                            
                                            selectedTime = this.textContent.trim();
                                            updateSelectedTimeDisplay();
                                        }
                                    });
                                });

                                function updateSelectedTimeDisplay() {
                                    if (selectedTime) {
                                        selectedTimeDisplay.textContent = `${dayNames[selectedDay]}, ${dayDates[selectedDay]} at ${selectedTime}`;
                                        bookBtn.disabled = false;
                                    } else {
                                        selectedTimeDisplay.textContent = 'No time selected';
                                        bookBtn.disabled = true;
                                    }
                                }

                                // Book button click
                                bookBtn.addEventListener('click', function() {
                                    if (selectedTime) {
                                        const bookingDetails = {
                                            day: dayNames[selectedDay],
                                            date: dayDates[selectedDay],
                                            time: selectedTime,
                                            mentor: 'Rida Louiss'
                                        };
                                        
                                        // Show confirmation
                                        alert(`Session Booked!\n\nMentor: ${bookingDetails.mentor}\nDate: ${bookingDetails.day}, ${bookingDetails.date}\nTime: ${bookingDetails.time}\n\nYou will receive a confirmation email shortly.`);
                                        
                                        // Here you can submit to backend
                                        console.log('Booking Details:', bookingDetails);
                                        
                                        // Example: Send to backend
                                        // fetch('/api/bookings', {
                                        //     method: 'POST',
                                        //     headers: {'Content-Type': 'application/json'},
                                        //     body: JSON.stringify(bookingDetails)
                                        // });
                                    }
                                });
                            });
                        </script>

                    </div>

                </div>
            </div>
        </section>

    </main>

@endsection