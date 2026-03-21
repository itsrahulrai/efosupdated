@extends('frontend.layout.layout')

@section('title', 'Page Not Found | EFOS')

@section('content')
<main>

    <section class="pt-120 pb-120 error-area">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <div class="col-lg-7 text-center">

                    {{-- BIG 404 --}}
                    <h1 class="error-code mb-3">404</h1>

                    {{-- TITLE --}}
                    <h2 class="mb-3 fw-bold">Oops! Page Not Found</h2>

                    {{-- DESCRIPTION --}}
                    <p class="mb-4 text-muted">
                        Sorry, the page you’re looking for doesn’t exist, was removed,
                        or the link is broken. Let’s get you back on track.
                    </p>

                    {{-- ACTIONS --}}
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                       <a href="{{ route('opportunity-highlights') }}" class="btn btn-danger px-4">
                            <i class="fa fa-briefcase me-1"></i> Explore Opportunities
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </section>

</main>

{{-- INLINE STYLES (You can move to CSS file later) --}}
<style>
    .error-area {
        min-height: 70vh;
        display: flex;
        align-items: center;
    }

    .error-code {
        font-size: 140px;
        font-weight: 800;
        color: #E72635;
        line-height: 1;
    }

    @media (max-width: 576px) {
        .error-code {
            font-size: 100px;
        }
    }
</style>

@endsection
