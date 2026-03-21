@extends('frontend.layout.layout')
@section('title', 'News & Events  | EFOS Edumarketers Pvt Ltd')
@section('meta_description',
    'EFOS Edumarketers Pvt Ltd offers expert career guidance, counselling, and skill
    development support to help students choose the right career path for a successful future.')
@section('meta_keywords',
    'career guidance, EFOS Edumarketers, career counselling, student counselling, skill
    development, education services, career planning, career support')
@section('meta_robots', 'index, follow')
@section('canonical', url('https://efos.in/'))
@section('content')

    <main>

        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                        News & Events
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>News & Events  </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Banner area end here -->

  <section class="blogs-area pt-120 pb-120">
    <div class="container">
        <div class="row g-4">

            @forelse ($newsEvents as $event)
                <div class="col-xl-4 col-md-6">
                    <div class="blog__item p-4">

                        {{-- IMAGE --}}
                        <div class="blog__image mb-3">
                            <img
                                src="{{ static_asset($event->images->first()->image ?? 'assets/images/blog/blog-image1.jpg') }}"
                                alt="{{ $event->heading }}"
                                style="width:100%; height:220px; object-fit:cover;">
                        </div>

                       <div class="blog__content">

                            {{-- TITLE --}}
                            <h3 class="mb-2">
                                {{ $event->heading }}
                            </h3>

                            {{-- SHORT DESCRIPTION --}}
                            <p class="short-desc">
                                {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 100) }}
                            </p>

                            {{-- FULL DESCRIPTION (HIDDEN) --}}
                            <p class="full-desc d-none">
                                {!! $event->description !!}
                            </p>

                            {{-- READ MORE --}}
                            <a href="javascript:void(0)"
                            class="mt-15 read-more-btn"
                            onclick="toggleDescription(this)">
                                Read More <i class="fa-regular fa-arrow-right-long"></i>
                            </a>

                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <h4>No News / Events Found</h4>
                </div>
            @endforelse

        </div>
    </div>
</section>



    </main>

@endsection

@push('script')
    <script>
function toggleDescription(el) {
    const content = el.closest('.blog__content');
    const shortDesc = content.querySelector('.short-desc');
    const fullDesc = content.querySelector('.full-desc');

    if (fullDesc.classList.contains('d-none')) {
        shortDesc.classList.add('d-none');
        fullDesc.classList.remove('d-none');
        el.innerHTML = 'Show Less <i class="fa-regular fa-arrow-up-long"></i>';
    } else {
        fullDesc.classList.add('d-none');
        shortDesc.classList.remove('d-none');
        el.innerHTML = 'Read More <i class="fa-regular fa-arrow-right-long"></i>';
    }
}
</script>

@endpush