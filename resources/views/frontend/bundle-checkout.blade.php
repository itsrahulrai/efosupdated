@extends('frontend.layout.layout')
@section('title', 'Checkout | EFOS Edumarketers Pvt Ltd')
@section('meta_description',
    'EFOS Edumarketers Pvt Ltd offers expert career guidance, counselling, and skill
    development support to help students choose the right career path for a successful future.')
@section('meta_keywords',
    'career guidance, EFOS Edumarketers, career counselling, student counselling, skill
    development, education services, career planning, career support')
@section('meta_robots', 'index, follow')
@section('canonical', url('https://efos.in/'))
@section('content')

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            --card-hover: 0 15px 50px rgba(0, 0, 0, 0.12);
        }


        .course-details-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-top: 50px;
        }

        .course-details-card:hover {
            box-shadow: var(--card-hover);
            transform: translateY(-2px);
        }

        .course-thumbnail {
            width: 180px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid #f8f9fa;
        }

        .course-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .course-description {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .feature-badge {
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-lifetime {
            background: linear-gradient(135deg, #e11d2e 0%, #ff4d5a 100%);
            color: #fff;
        }

        .badge-selfpaced {
            background: linear-gradient(135deg, #e11d2e 0%, #ff4d5a 100%);
            color: #fff;
        }

        .badge-certificate {
            background: linear-gradient(135deg, #e11d2e 0%, #ff4d5a 100%);
            color: #fff;
        }

        .benefits-card {
            border-radius: 16px;
            padding: 30px;
            border: none;
        }

        .benefit-item {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
            color: #2d3748;
        }

        .benefit-item:last-child {
            border-bottom: none;
        }

        .benefit-icon {
            width: 24px;
            height: 24px;
            background: var(--success-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 12px;
            flex-shrink: 0;
        }

        .order-summary-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            position: sticky;
            top: 100px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-top: 50px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 0.95rem;
        }

        .price-original {
            color: #6c757d;
        }

        .price-discount {
            color: #10b981;
            font-weight: 600;
        }

        .price-total {
            font-size: 1.2em;
            font-weight: 700;
            color: #1a1a1a;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
            margin: 20px 0;
        }

        .btn-checkout {
            background: linear-gradient(135deg, #e11d2e 0%, #ff4d5a 100%);

            border: none;
            padding: 16px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            color: #fff;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-checkout::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-checkout:hover::before {
            left: 100%;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(17, 153, 142, 0.4);
        }

        .security-badge {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            margin-top: 20px;
            border: 1px solid #e9ecef;
        }

        .payment-methods {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .payment-icon {
            background: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
        }

        .trust-indicators {
            display: flex;
            justify-content: space-around;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e9ecef;
        }

        .trust-item {
            text-align: center;
        }

        .trust-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e11d2e 0%, #ff4d5a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            color: #fff;
        }

        .trust-text {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
        }

        @media (max-width: 991px) {

            .order-summary-card {
                position: static;
                margin-top: 30px;
            }

            .course-thumbnail {
                width: 100%;
                height: 180px;
            }
        }
    </style>

    <main>

        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                        Checkout
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Banner area end here -->

        <!-- Checkout Content -->
        <section class="checkout-container pb-5">
            <div class="container">
                <div class="row g-4">

                    <!-- Left Column -->
                    <div class="col-lg-8">

                        <!-- Course Details -->
                        <div class="course-details-card p-4 mb-4">
                            <h4 class="fw-bold mb-4" style="color: #1a1a1a;">Your Selected Bundle</h4>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <img src="{{ static_asset($bundle->thumbnail ?? 'assets/images/course-default.jpg') }}"
                                        class="course-thumbnail w-100" alt="{{ $bundle->title }}">
                                </div>

                                <div class="col-md-8">
                                    <h5 class="course-title">{{ $bundle->title }}</h5>
                                    <p class="course-description">
                                        {{ Str::limit($bundle->short_description, 180) }}
                                    </p>
                                    <div class="mt-3">
                                        <span class="badge bg-danger">
                                            {{ $bundle->courses->count() }} Courses Included
                                        </span>

                                        <div class="mt-2">
                                            @foreach($bundle->courses as $course)
                                                <div class="small text-muted">
                                                    <i class="fa-solid fa-play me-1 text-danger"></i>
                                                    {{ $course->title }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 flex-wrap mt-3">
                                        <span class="feature-badge badge-lifetime">
                                            <i class="fa-solid fa-infinity"></i> Lifetime Access
                                        </span>
                                        <span class="feature-badge badge-selfpaced">
                                            <i class="fa-solid fa-clock"></i> Self-Paced
                                        </span>
                                        <span class="feature-badge badge-certificate">
                                            <i class="fa-solid fa-certificate"></i> Certificate
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Benefits Section -->
                        <div class="benefits-card">
                            <h5 class="fw-bold mb-4" style="color: #1a1a1a;">
                                <i class="fa-solid fa-gift me-2" style="color: #667eea;"></i>
                                Included with Your Purchase
                            </h5>

                            <div>
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <span>Complete course curriculum with all modules & lessons</span>
                                </div>

                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <span>Expert-designed learning path for maximum impact</span>
                                </div>


                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <span>Industry-recognized certificate upon completion</span>
                                </div>

                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <span>24/7 access to your personalized student dashboard</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <div class="order-summary-card p-4">

                            <h5 class="fw-bold mb-4" style="color: #1a1a1a;">Order Summary</h5>

                            <div class="price-row price-original">
                                <span>Course Price</span>
                                <span class="fw-semibold">₹{{ number_format($bundle->price) }}</span>
                            </div>

                            @if ($bundle->has_discount)
                                <div class="price-row price-discount">
                                    <span>
                                        <i class="fa-solid fa-tag me-1"></i> Special Discount
                                    </span>
                                    <span>- ₹{{ number_format($bundle->price - $bundle->discount_price) }}</span>
                                </div>
                            @endif

                            <div class="divider"></div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold" style="font-size: 1.1rem;">Total Amount</span>
                                <span class="price-total">₹ {{ number_format($bundle->discount_price ?? $bundle->price) }}</span>
                            </div>

                            <form method="POST" action="{{ route('bundle.payment.initiate', $bundle->id) }}">
                                @csrf
                                <button type="submit" class="btn-checkout">
                                    <i class="fa-solid fa-lock me-2"></i>
                                    Proceed to Payment
                                </button>
                            </form>


                            <div class="security-badge">
                                <i class="fa-solid fa-shield-halved text-success me-2"></i>
                                <span style="font-size: 0.85rem; color: #6c757d;">
                                    256-bit SSL Encrypted Payment
                                </span>
                            </div>


                            <div class="trust-indicators">
                                <div class="trust-item">
                                    <div class="trust-icon">
                                        <i class="fa-solid fa-bolt"></i>
                                    </div>
                                    <div class="trust-text">Instant<br>Access</div>
                                </div>

                                <div class="trust-item">
                                    <div class="trust-icon">
                                        <i class="fa-solid fa-infinity"></i>
                                    </div>
                                    <div class="trust-text">Lifetime<br>Validity</div>
                                </div>

                                <div class="trust-item">
                                    <div class="trust-icon">
                                        <i class="fa-solid fa-headset"></i>
                                    </div>
                                    <div class="trust-text">24/7<br>Support</div>
                                </div>
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
        // Add subtle animations on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.course-details-card, .benefits-card, .order-summary-card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '0';
                        entry.target.style.transform = 'translateY(20px)';
                        entry.target.style.transition = 'all 0.6s ease';

                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, 100);
                    }
                });
            }, {
                threshold: 0.1
            });

            cards.forEach(card => observer.observe(card));
        });
    </script>
@endpush
