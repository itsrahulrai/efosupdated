<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') </title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="EFOS Edumarketers Pvt Ltd">

    <meta property="og:title"
        content="@yield('og_title', trim($__env->yieldContent('title')))">

    <meta property="og:description"
        content="@yield('og_description', trim($__env->yieldContent('meta_description')))">

    <meta property="og:url"
        content="@yield('og_url', url()->current())">

    <meta property="og:image"
        content="@yield('og_image', asset('assets/images/share/job-share.jpg'))">

    <meta property="og:image:secure_url"
        content="@yield('og_image', asset('assets/images/share/job-share.jpg'))">

    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">

    <!-- Twitter (WhatsApp also reads this sometimes) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', trim($__env->yieldContent('title')))">
    <meta name="twitter:description" content="@yield('twitter_description', trim($__env->yieldContent('meta_description')))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('assets/images/share/job-share.jpg'))">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Favicon img -->
    <link rel="shortcut icon" href="{{ static_asset('assets/images/favicon.png') }}">
    <!-- Bootstarp min css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/bootstrap.min.css') }}">
    <!-- Mean menu css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/meanmenu.css') }}">
    <!-- All min css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/all.min.css') }}">
    <!-- Swiper bundle min css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/swiper-bundle.min.css') }}">
    <!-- Magnigic popup css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/magnific-popup.css') }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/animate.css') }}">
    <!-- Nice select css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/nice-select.css') }}">
    <!-- Style css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/style.css') }}">
     <link rel="stylesheet" href="{{ static_asset('assets/css/lesson.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
.floating-call,
.floating-whatsapp {
    position: fixed;
    bottom: 20px;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 26px;
    z-index: 9999;
    animation: pulse 1.5s infinite;
    text-decoration: none;
}
/* Call - Left */
.floating-call {
    left: 45px;
    background: #0d6efd; /* blue */
}

/* WhatsApp - Right */
.floating-whatsapp {
    right: 45px;
    background: #25d366; /* whatsapp green */
}
/* Pulse Animation */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(0,0,0,0.3);
    }
    70% {
        box-shadow: 0 0 0 15px rgba(0,0,0,0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(0,0,0,0);
    }
}
/* Slightly bigger on mobile */
@media (max-width: 768px) {
    .floating-call,
    .floating-whatsapp {
        width: 60px;
        height: 60px;
        font-size: 28px;
    }
}

</style>

@stack('style')
</head>

<body>


    <!-- Header Start -->
    @include('frontend.include.header')
    <!-- Header End -->

    @yield('content')
    <!-- Footer area start here -->
    @include('frontend.include.footer')
    <!-- Footer area end here -->

    <!-- Back to top area start here -->
    <div class="scroll-up">
        <svg class="scroll-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Back to top area end here -->





    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Jquery 3. 7. 1 Min Js -->
    <script src="{{ static_asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap min Js -->
    <script src="{{ static_asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- Mean menu Js -->
    <script src="{{ static_asset('assets/js/meanmenu.js') }}"></script>
    <!-- Swiper bundle min Js -->
    <script src="{{ static_asset('assets/js/swiper-bundle.min.js') }}"></script>
    <!-- Counterup min Js -->
    <script src="{{ static_asset('assets/js/jquery.counterup.min.js') }}"></script>
    <!-- Wow min Js -->
    <script src="{{ static_asset('assets/js/wow.min.js') }}"></script>
    <!-- Magnific popup min Js -->
    <script src="{{ static_asset('assets/js/magnific-popup.min.js') }}"></script>
    <!-- Nice select min Js -->
    <script src="{{ static_asset('assets/js/nice-select.min.js') }}"></script>
    <!-- Parallax Js -->
    <script src="{{ static_asset('assets/js/parallax.js') }}"></script>
    <!-- Waypoints Js -->
    <script src="{{ static_asset('assets/js/jquery.waypoints.js') }}"></script>
    <!-- Script Js -->
    <script src="{{ static_asset('assets/js/script.js') }}"></script>

    <script src="{{ static_asset('assets/js/main-script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif
        
        
          {{-- VALIDATION ERRORS --}}
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif
    </script>

    <script>
        /* ==================================
   GLOBAL loadJobs FUNCTION
================================== */
        window.loadJobs = function(page = 1) {

            if (typeof $ === 'undefined') {
                console.error('jQuery not loaded');
                return;
            }

            let baseUrl = (typeof currentCategorySlug !== 'undefined' && currentCategorySlug) ?
                "{{ url('opportunity-highlights') }}/" + currentCategorySlug :
                "{{ route('opportunity-highlights') }}";

            $.ajax({
                url: baseUrl,
                type: 'GET',
                data: {
                    search: $('#jobSearch').val(),
                    category_id: $('#category_id').val(),
                    sub_category_id: $('#sub_category_id').val(),
                    date_posted: $('input[name="datePosted"]:checked').val(),
                    page: page
                },
                success: function(res) {

                    // Update job list
                    $('#jobsContainer').html(res);

                    // 🔗 UPDATE URL (NO RELOAD)
                    let keyword = $('#jobSearch').val().trim();
                    let url = new URL(window.location.href);

                    if (keyword) {
                        url.searchParams.set('search', keyword);
                    } else {
                        url.searchParams.delete('search');
                    }

                    // Optional: reset page to 1
                    url.searchParams.set('page', page);

                    window.history.replaceState(null, '', url.toString());
                }
            });
        };
    </script>




<!-- CALL BUTTON (LEFT) -->
<a href="tel:9403890820" class="floating-call" title="Call Now">
    <i class="fa-solid fa-phone"></i>
</a>

<!-- WHATSAPP BUTTON (RIGHT) -->
<a href="https://wa.me/919403890820" target="_blank" class="floating-whatsapp" title="WhatsApp Chat">
    <i class="fa-brands fa-whatsapp"></i>
</a>

    @stack('script')


   
</body>

</html>