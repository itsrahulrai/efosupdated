@extends('frontend.layout.layout')
@section('title', $seo['title'])
@section('meta_description', $seo['description'])
@section('meta_keywords', $seo['keywords'])
@section('meta_robots', $seo['robots'])
@section('canonical', $seo['canonical'])

@php
    $ogImage = $blog->image ? url(static_asset($blog->image)) : asset('assets/images/share/job-share.jpg');
@endphp

@section('og_title', $seo['title'])
@section('og_description', $seo['description'])
@section('og_url', url()->current())
@section('og_image', $ogImage)

@section('twitter_title', $seo['title'])
@section('twitter_description', $seo['description'])
@section('twitter_image', $ogImage)


@section('content')

    <main>
        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                        EFOS.in Blog
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>EFOS.in Blog</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Banner area end here -->
        <!-- Blog area start here -->
        <section class="blog-detals-area pt-120 pb-120">
            <div class="container">
                <div class="row">

                    <!-- CONTENT -->
                    <div class="col-lg-8 order-1">
                        <div class="blog-details__item-left">

                            <div class="image">
                                <img src="{{ static_asset($blog->image) }}" alt="{{ $blog->name }}">
                            </div>

                            <ul class="info mt-40 pb-20 bor-bottom">
                                <li>By {{ $blog->author ?? 'Admin' }}</li>
                                <li>{{ $blog->created_at->format('d M, Y') }}</li>
                            </ul>

                            <h2 class="mt-4">{{ $blog->name }}</h2>

                            <div class="description mt-3">
                                {!! $blog->content !!}
                            </div>

                        </div>
                    </div>

                    <!-- SIDEBAR -->
                    <div class="col-lg-4 order-2">
                        <div class="blog-details__item-right">

                            <!-- Recent Posts -->
                            <div class="item resent-post mb-4 order-2 order-lg-1">
                                <h3>Recent Posts</h3>
                                <ul>
                                    @forelse($recentBlogs as $post)
                                        <li>
                                            <img src="{{ static_asset($post->image) }}"
                                                style="width:80px;height:60px;object-fit:cover;">

                                            <div>
                                                <span class="fs-14">
                                                    {{ $post->created_at->format('d M, Y') }}
                                                </span>

                                                <h5>
                                                    <a href="{{ route('career-updates.details', $post->slug) }}">
                                                        {{ Str::limit($post->name, 45) }}
                                                    </a>
                                                </h5>
                                            </div>
                                        </li>
                                    @empty
                                        <li>No recent posts</li>
                                    @endforelse
                                </ul>
                            </div>

                            <!-- Categories -->
                            <div class="item category mb-4 order-3 order-lg-2">
                                <h3>Categories</h3>
                                <ul>
                                    @forelse($jobcategories as $cat)
                                        <li>
                                            <a href="{{ url('career-updates?category=' . $cat->slug) }}">
                                                <span>{{ $cat->name }}</span>
                                                <span>({{ $cat->blogs_count }})</span>
                                            </a>
                                        </li>
                                    @empty
                                        <li>No categories found</li>
                                    @endforelse
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>



            </div>
            </div>
        </section>
        <!-- Blog area end here -->
    </main>

@endsection
