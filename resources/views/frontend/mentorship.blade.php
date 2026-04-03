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
        :root {
            --primary-color: #E72939;
            --dark-color: #181818;
            --gray-light: #f5f5f5;
            --gray-medium: #999;
            --white: #ffffff;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mentors-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #f9f9f9 0%, #ffffff 100%);
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeInUp 0.8s ease-out;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--gray-medium);
            font-weight: 400;
        }

        .mentors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            animation: fadeIn 0.8s ease-out 0.2s both;
        }

        .mentor-card {
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .mentor-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(231, 41, 57, 0.15);
            border-color: rgba(231, 41, 57, 0.1);
        }

        /* image wrapper */

        .mentor-card__image-wrapper {
            position: relative;
            height: 260px;
            border-radius: 12px;
            overflow: hidden;
            background: #f5f5f5;
        }
        /* mentor image */
        .mentor-card__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.4s;
        }
        
        /* vertical experience strip */
        .mentor-card__experience {
            position: absolute;
            left: 0;
            top: 20px;
            bottom: 20px;
            width: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg,
                    #E72939,
                    #181818);

            color: #fff;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            border-radius: 0 8px 8px 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* hover zoom */
        .mentor-card:hover .mentor-card__image {
            transform: scale(1.05);
        }
        .mentor-card:hover .mentor-card__image {
            transform: scale(1.05);
        }
        .mentor-card__badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--primary-color);
            color: var(--white);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(231, 41, 57, 0.3);
        }
        .mentor-card__content {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .mentor-card__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            margin-bottom: 12px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        .rating {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stars {
            color: var(--primary-color);
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        .rating-count {
            font-size: 0.85rem;
            color: var(--gray-medium);
        }

        .experience {
            font-size: 0.85rem;
            color: var(--dark-color);
            font-weight: 600;
        }
        .mentor-card__bio {
            font-size: 0.95rem;
            color: #666;
            line-height: 1.6;
            margin: 12px 0;
            flex-grow: 1;
        }
        .tag {
            display: inline-block;
            background: rgba(231, 41, 57, 0.08);
            color: var(--primary-color);
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: var(--transition);
        }
        .tag:hover {
            background: rgba(231, 41, 57, 0.15);
        }
        .mentor-card__btn {
            width: 100%;
            padding: 12px 24px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: auto;
        }
        .mentor-card__btn:hover {
            background: var(--dark-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(24, 24, 24, 0.3);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);}

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section-header h2 {
                font-size: 2rem;
            }

            .mentors-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .mentor-card__image-wrapper {
                height: 240px;
            }

            .mentor-card__name {
                font-size: 1.2rem;
            }

            .mentor-card__content {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .mentors-section {
                padding: 40px 0;
            }

            .section-header h2 {
                font-size: 1.7rem;
            }

            .section-header p {
                font-size: 1rem;
            }

            .mentor-card__image-wrapper {
                height: 200px;
            }

            .mentor-card__meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .mentor-card__btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        /* header */
        .mentor-card__header {
            margin-bottom: 12px;
        }

        /* mentor name */

        .mentor-card__name{
        font-family:'Poppins', sans-serif;
        font-size:22px;
        font-weight:700;
        color:#181818;
        margin-bottom:6px;
        letter-spacing:-0.2px;
        line-height:1.35;
        transition:.3s;
        }
        /* role row */
        .mentor-card__role {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 13px;
        }

        /* title */
        .mentor-card__title {
            color: #E72939;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        /* company */
        .mentor-card__company {
            color: #777;
            font-weight: 500;
        }

        /* divider dot */
        .mentor-divider {
            color: #ccc;
            font-size: 12px;
        }
    </style>
@endpush
@section('content')

    <main>
        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                        Mentorship
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Mentorship</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Mentor Cards Section -->
        <section class="mentors-section">
            <div class="container">
                <div class="section-header">
                    <h2>Meet Our Expert Mentors</h2>
                    <p>Learn from industry professionals with years of experience</p>
                </div>

                <div class="mentors-grid">

                    @foreach ($mentors as $mentor)
                        <div class="mentor-card">

                            <!-- image -->
                            <div class="mentor-card__image-wrapper">
                                <img src="{{ static_asset($mentor->profile_photo ?? 'assets/images/default-user.png') }}"
                                    alt="{{ $mentor->name }}" class="mentor-card__image">
                                <div class="mentor-card__experience">
                                    {{ $mentor->experience ?? ' ' }}
                                </div>
                            </div>
                            <!-- content -->
                            <div class="mentor-card__content">
                                <!-- header -->
                                <div class="mentor-card__header">
                                    <h3 class="mentor-card__name">
                                        {{ $mentor->name }}
                                    </h3>
                                    <div class="mentor-card__role">
                                        <span class="mentor-card__title">
                                            {{ $mentor->category->name ?? ' ' }}
                                        </span>
                                        

                                    </div>

                                </div>


                                <!-- bio -->
                                <p class="mentor-card__bio">

                                    {{ $mentor->bio ?? 'Expert mentor helping students achieve career success.' }}

                                </p>


                                <!-- button -->
                                <button class="mentor-card__btn">

                                    Book Session →

                                </button>


                            </div>

                        </div>
                    @endforeach

                </div>
            </div>
        </section>

    </main>


@endsection
