@extends('frontend.layout.layout')

@section('title', $page->meta_title ?? $page->name . ' | EFOS Edumarketers Pvt Ltd')

@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)
@section('meta_robots', 'index, follow')
@section('canonical', $page->canonical_url ?? url()->current())

@php
    $ogTitle = $page->name;

    $ogDescription = Str::limit(
        strip_tags($page->description),
        160
    );
@endphp

@section('og_title', $ogTitle)
@section('og_description', $ogDescription)

@section('content')

<main>

    <!-- Banner area start here -->
    <section class="banner-inner-area sub-bg bg-image">
        <div class="container">
            <div class="banner-inner__content">
                <h1>{{ $page->name }}</h1>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><i class="fa-regular fa-angle-right"></i></li>
                    <li>{{ $page->name }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Banner area end here -->

    <!-- Page Content -->
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="content-area">
                {!! $page->description !!}
            </div>
        </div>
    </section>

</main>

@endsection
