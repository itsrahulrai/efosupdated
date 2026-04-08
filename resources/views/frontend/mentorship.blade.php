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

/* section */
.mentors-section {
    padding: 60px 0;
    background: linear-gradient(135deg, #f9f9f9 0%, #ffffff 100%);
}

/* header */
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
}

.section-header p {
    font-size: 1.1rem;
    color: var(--gray-medium);
}

/* GRID FIX */
.mentors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 380px));
    justify-content: start;
    gap: 30px;
}

/* card */
.mentor-card {
    background: var(--white);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0,0,0,0.07);
    transition: var(--transition);
    border: 1px solid rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    height: 100%;
    max-width: 380px;
    width: 100%;
}

.mentor-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 45px rgba(231,41,57,0.15);
}

/* image */
.mentor-card__image-wrapper {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: #eee;
}

.mentor-card__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .4s;
}

.mentor-card:hover .mentor-card__image {
    transform: scale(1.05);
}

/* experience strip */
.mentor-card__experience {
    position: absolute;
    left: 0;
    top: 20px;
    bottom: 20px;
    width: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(180deg,#E72939,#181818);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 1px;
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    border-radius: 0 8px 8px 0;
}

/* content */
.mentor-card__content {
    padding: 22px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

/* name */
.mentor-card__name {
    font-size: 20px;
    font-weight: 700;
    color: #181818;
    margin-bottom: 6px;
}

.mentor-card__name a {
    color: #181818;
    text-decoration: none;
}

/* category */
.mentor-card__role {
    font-size: 13px;
    margin-bottom: 10px;
}

.mentor-card__title {
    color: #E72939;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
}

/* bio */
.mentor-card__bio {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
    margin-bottom: 18px;
    flex-grow: 1;
}

/* button */
.mentor-card__btn {
    width: 100%;
    padding: 12px;
    background: #E72939;
    color: white;
    border-radius: 8px;
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: .3s;
}

.mentor-card__btn:hover {
    background: #181818;
}

/* animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* tablet */
@media(max-width:991px) {

    .mentors-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 340px));
    }

}

/* mobile */
@media(max-width:576px) {

    .section-header h2 {
        font-size: 1.8rem;
    }

    .mentors-grid {
        grid-template-columns: 1fr;
    }

    .mentor-card {
        max-width: 100%;
    }

    .mentor-card__image-wrapper {
        height: 220px;
    }

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
                                    {{ $mentor->experience ?? '0' }} Years of Experience
                                </div>
                            </div>
                            <!-- content -->
                            <div class="mentor-card__content">
                                <!-- header -->
                                <div class="mentor-card__header">
                                   <h3 class="mentor-card__name">
                                        <a href="{{ route('mentorship-details', $mentor->slug) }}">
                                            {{ $mentor->name }}
                                        </a>
                                    </h3>
                                    <div class="mentor-card__role">
                                        <span class="mentor-card__title">
                                            {{ $mentor->category->name ?? ' ' }}
                                        </span>

                                    </div>

                                </div>


                                <!-- bio -->
                                <p class="mentor-card__bio">

                                    {{ $mentor->shortbio ?? 'Expert mentor helping students achieve career success.' }}

                                </p>

                                <!-- button -->
                                <button class="mentor-card__btn"
                                onclick="window.location.href='{{ route('mentorship-details', $mentor->slug) }}'">
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
