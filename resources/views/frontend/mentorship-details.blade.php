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

            0%,
            100% {
                transform: scale(1);
                opacity: 0.6;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.9;
            }
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

        .content-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .content-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .content-card:nth-child(3) {
            animation-delay: 0.3s;
        }

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

        /* duration  */
        .duration-selector {
            display: flex;
            gap: 14px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        /* button */
        .duration-btn {
            padding: 5px 5px;
            border-radius: 10px;
            border: 1px solid #eee;
            background: #fff;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: .25s;
            min-width: 110px;
            text-align: center;
            position: relative;

            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* duration text */
        .duration-time {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        /* price */
        .price-text {
            font-size: 13px;
            font-weight: 600;
            color: #E72434;
            opacity: 1;
        }

        /* hover effect */
        .duration-btn:hover {
            border-color: #E72434;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(231, 36, 52, 0.15);
        }

        /* active button */
        .duration-btn.active {
            background: #E72434;
            border-color: #E72434;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(231, 36, 52, 0.25);
        }

        /* active price */
        .duration-btn.active .price-text {
            color: #fff;
        }

        /* mobile */
        @media(max-width:576px) {

            .duration-btn {
                flex: 1 1 45%;
            }

        }



        .slot.available {
            background: #ECFDF5;
            border-color: #10B981;
            color: #059669;
        }

        .slot.booked {
            background: #f3f4f6;
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
            position: relative;
        }

        .slot.booked::after {
            content: "Booked";
            font-size: 10px;
            position: absolute;
            bottom: 4px;
            right: 6px;
            color: #9ca3af;
        }

        .slot.active {
            background: #E72434;
            border-color: #E72434;
            color: #fff;
        }

        /* payment  */
        .payment-summary {

            background: #fff;

            border: 1px solid #eee;

            padding: 18px;

            border-radius: 12px;

            margin-bottom: 15px;

            width: 100%;

        }

        .summary-title {

            font-weight: 700;

            margin-bottom: 10px;

            font-size: 15px;

        }

        .summary-row {

            display: flex;

            justify-content: space-between;

            font-size: 14px;

            margin-bottom: 6px;

        }

        .summary-row.total {

            border-top: 1px solid #eee;

            padding-top: 8px;

            font-weight: 700;

            font-size: 15px;

            color: #E72434;

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
                            <img src="{{ static_asset($mentor->profile_photo) }}" alt="Rida Louiss" class="mentor-img">
                            <div class="mentor-name">{{ $mentor->name }}</div>
                            <div class="mentor-role">{{ $mentor->category->name }}</div>
                        </div>

                        <!-- Meta Info -->
                        <div class="mentor-meta">
                            <div class="meta-item">
                                <span><strong></strong>{{ $mentor->city }}, {{ $mentor->state }}</span>
                            </div>
                            <div class="meta-item">
                                <span><strong>Verified</strong> Mentor</span>
                            </div>
                        </div>

                        <!-- Price -->
                        @php
                            $firstDuration = array_key_first($availabilitySlots);

                            $defaultPrice = optional(
                                $mentor->sessionPrices->where('duration_minutes', $firstDuration)->first(),
                            )->discount_price;
                        @endphp

                        <div class="price-section">
                            <div class="price" id="mainPrice">
                                ₹ {{ rtrim(rtrim(number_format($defaultPrice, 2), '0'), '.') }}
                            </div>

                            <div class="price-subtext" id="mainDuration">
                                {{ $firstDuration }} min session
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="btn-group">
                            <button class="btn btn-secondary">Send Message</button>
                        </div>

                        <!-- Stats -->
                        <div class="stats-grid">
                            <div class="stat-box">
                                <div class="stat-number">{{ $mentor->experience }}</div>
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
                                {!! $mentor->bio !!}
                            </p>
                        </div>

                        <!-- Expertise -->
                        <div class="content-card">
                            <div class="card-title">Mentorship Expertise</div>
                            <div class="skills-container">
                                @foreach (explode(',', $mentor->skills) as $skill)
                                    <div class="skill-tag">{{ trim($skill) }}</div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Available Slots -->
                        <div class="content-card">
                            <div class="card-title">Book Your Preferred Time</div>
                            <p class="card-text">Pick a duration, choose a day, and select a time slot</p>

                            <div class="duration-selector">

                                @foreach ($availabilitySlots as $duration => $days)
                                    @php
                                        $price = optional(
                                            $mentor->sessionPrices->where('duration_minutes', $duration)->first(),
                                        )->discount_price;
                                    @endphp

                                    <button class="duration-btn {{ $loop->first ? 'active' : '' }}"
                                        data-duration="{{ $duration }}">

                                        <div class="duration-time">
                                            {{ $duration }} min
                                        </div>

                                        <span class="price-text">
                                            ₹ {{ rtrim(rtrim(number_format($price, 2), '0'), '.') }}
                                        </span>

                                    </button>
                                @endforeach

                            </div>


                            <!-- Day Selector -->
                            <div class="days-selector">

                                @foreach ($availabilitySlots as $duration => $days)
                                    @if ($loop->first)
                                        @foreach ($days as $day => $slots)
                                            <button class="day-btn {{ $loop->first ? 'active' : '' }}"
                                                data-day="{{ $loop->index }}">

                                                {{ ucfirst($day) }}

                                            </button>
                                        @endforeach
                                    @endif
                                @endforeach

                            </div>
                            <!-- Time Slots -->

                            <div class="slots-grid">

                                @foreach ($availabilitySlots as $duration => $days)
                                    @foreach ($days as $day => $slots)
                                        @foreach ($slots as $slot)
                                            @php
                                                $isBooked = in_array($slot, $bookedSlots[$day] ?? []);
                                            @endphp

                                            <div class="slot
                                                {{ $isBooked ? 'booked' : 'available' }}"
                                                data-duration="{{ $duration }}" data-day="{{ $loop->parent->index }}"
                                                style="{{ $loop->parent->first && $loop->parent->parent->first ? '' : 'display:none' }}">

                                                {{ $slot }}

                                            </div>
                                        @endforeach
                                    @endforeach
                                @endforeach

                            </div>

                            <!-- Selected Time Display & Book Button -->
                            <div class="booking-section">

                                <div class="selected-time-info">
                                    <span class="info-label">Selected Time:</span>
                                    <span class="info-value" id="selectedTimeDisplay">No time selected</span>
                                </div>

                                <div class="payment-summary">

                                    <div class="summary-title">
                                        Payment Details
                                    </div>

                                    <div class="summary-row">
                                        <span>Session</span>
                                        <span id="summaryDuration">--</span>
                                    </div>

                                    <div class="summary-row">
                                        <span>Date</span>
                                        <span id="summaryDay">--</span>
                                    </div>

                                    <div class="summary-row">
                                        <span>Time</span>
                                        <span id="summaryTime">--</span>
                                    </div>

                                    <div class="summary-row total">
                                        <span>Total</span>
                                        <span id="summaryPrice">₹0</span>
                                    </div>

                                </div>
                                <input type="hidden" id="mentor_id" value="{{ $mentor->id }}">
                                <input type="hidden" id="session_price_id">
                                <input type="hidden" id="final_price">
                                <button class="btn-book-session" id="bookBtn" disabled>
                                    <i class="fa-solid fa-calendar-check"></i>
                                    Book a Session
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

    </main>

@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let activeDuration =
                document.querySelector(".duration-btn").dataset.duration;

            let activeDay = 0;

            let selectedSlot = null;

            const durationBtns =
                document.querySelectorAll(".duration-btn");

            const dayBtns =
                document.querySelectorAll(".day-btn");

            const slots =
                document.querySelectorAll(".slot");

            const selectedText =
                document.getElementById("selectedTimeDisplay");

            const bookBtn =
                document.getElementById("bookBtn");

            const summaryDuration =
                document.getElementById("summaryDuration");

            const summaryDay =
                document.getElementById("summaryDay");

            const summaryTime =
                document.getElementById("summaryTime");

            const summaryPrice =
                document.getElementById("summaryPrice");


            /* duration change */

            durationBtns.forEach(btn => {

                btn.addEventListener("click", function() {

                    durationBtns.forEach(b =>
                        b.classList.remove("active")
                    );

                    this.classList.add("active");

                    activeDuration = this.dataset.duration;

                    let priceElement =
                        this.querySelector(".price-text");

                    summaryPrice.innerText =
                        priceElement.innerText;

                    summaryDuration.innerText =
                        activeDuration + " minutes";

                    selectedSlot = null;

                    selectedText.innerText =
                        "No time selected";

                    bookBtn.disabled = true;

                    filterSlots();

                });

            });


            /* day change */

            dayBtns.forEach(btn => {

                btn.addEventListener("click", function() {

                    dayBtns.forEach(b =>
                        b.classList.remove("active")
                    );

                    this.classList.add("active");

                    activeDay = this.dataset.day;

                    selectedSlot = null;

                    selectedText.innerText =
                        "No time selected";

                    bookBtn.disabled = true;

                    filterSlots();

                });

            });


            /* slot select */

            slots.forEach(slot => {

                slot.addEventListener("click", function() {

                    if (
                        !this.classList.contains("booked") &&
                        this.style.display !== "none"
                    ) {

                        slots.forEach(s =>
                            s.classList.remove("active")
                        );

                        this.classList.add("active");

                        selectedSlot = this.innerText;

                        selectedText.innerText =
                            selectedSlot +
                            " (" + activeDuration + " min)";

                        summaryTime.innerText =
                            selectedSlot;

                        summaryDay.innerText =
                            document.querySelector(".day-btn.active").innerText;

                        summaryDuration.innerText =
                            activeDuration + " minutes";

                        let priceElement =
                            document.querySelector(
                                '.duration-btn.active .price-text'
                            );

                        summaryPrice.innerText =
                            priceElement.innerText;

                        bookBtn.disabled = false;

                    }

                });

            });

            function filterSlots() {

                slots.forEach(slot => {

                    if (
                        slot.dataset.duration == activeDuration &&
                        slot.dataset.day == activeDay
                    ) {
                        slot.style.display = "flex";
                    } else {
                        slot.style.display = "none";
                    }

                });

            }

            /* AJAX booking */

            bookBtn.addEventListener("click", function() {

                fetch("{{ route('book.session') }}", {

                        method: "POST",

                        credentials: "same-origin",

                        headers: {

                            "Content-Type": "application/json",

                            "Accept": "application/json",

                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")

                        },

                        body: JSON.stringify({

                            mentor_id: document.getElementById("mentor_id").value,

                            duration: activeDuration,

                            day: document
                                .querySelector(".day-btn.active")
                                .innerText
                                .toLowerCase(),

                            time: selectedSlot

                        })

                    })

                    .then(async response => {
                        if (response.status === 401) {
                            fetch("/set-intended-url");
                            window.location.href = "{{ route('student.login') }}";
                            return;
                        }

                        let data = await response.json();
                        if (data.status) {

                            toastr.success("Redirecting to payment...");

                            /* disable selected slot immediately */

                            document
                                .querySelectorAll(".slot.active")
                                .forEach(slot => {
                                    slot.classList.remove("active");
                                    slot.classList.add("booked");

                                });

                            /* redirect to payment */

                            window.location.href =
                                "{{ route('mentor.payment.initiate') }}?booking_id=" + data.booking_id;

                        } else {
                            toastr.error(data.message);
                        }

                    })

                    .catch(error => {
                        toastr.error("Something went wrong");
                    });

            });
        });
    </script>
@endpush
