@extends('layouts.blog')

@section('title')
    {{ trans('blog.title.home') }}
@endsection

<!-- Header section with gradient background -->
<div class="header-section" style="background: linear-gradient(to right, #0074D9, #7FDBFF);">
    <div class="container py-5">
        <div class="row align-items-center">
            <!-- Column for search form -->
            <div class="col-lg-6">
                <div class="title-heading">
                    <div class="mt-4 pt-2 d-flex flex-column align-items-center">
                        <!-- Post search form:start -->
                        <form class="input-group my-1" action="{{ route('blog.search') }}" method="GET">
                            <input name="keyword" value="{{ request()->get('keyword') }}" type="search"
                                class="form-control"
                                placeholder="{{ trans('blog.form_control.input.search.placeholder') }}"
                                style="border-radius: 20px 0 0 20px;">
                            <div class="input-group-append">
                                <button class="btn bg-primary text-white" type="submit"
                                    style="border-radius: 0 20px 20px 0;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <!-- Post search form:end -->
                    </div>
                </div>
            </div>
            <!-- Column for title and description -->
            <div class="col-lg-6 text-white text-lg-right">
                <h1 class="heading mt-3 pt-5 py-2 title-dark">BLOQ CODER</h1>
                    <div class="d-flex justify-content-center">
                        <div class="align-items-center">
                            @if (Auth::check())
                                <a href="{{ route('service-desk.index') }}" class="btn btn-info btn-lg rounded-pill shadow mt-3">
                                    <i class="fas fa-question-circle mr-1"></i>
                                    <span>Service Desk</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-info btn-lg rounded-pill shadow mt-3">
                                    <i class="fas fa-question-circle mr-1"></i>
                                    <span>Service Desk</span>
                                </a>
                            @endif
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- End of gradient background and page title -->

<!-- SVG for bottom background -->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <defs>
        <linearGradient id="grad-blue" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" style="stop-color:#0074D9;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#7FDBFF;stop-opacity:1" />
        </linearGradient>
    </defs>
    <path fill="url(#grad-blue)" fill-opacity="1"
        d="M0,320L48,272C96,224,192,128,288,112C384,96,480,160,576,192C672,224,768,224,864,202.7C960,181,1056,139,1152,154.7C1248,171,1344,245,1392,282.7L1440,320L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z">
    </path>
</svg>

@section('content')
    <!-- Page title -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="my-5 text-center">
                    <span class="badge badge-info display-4">{{ trans('blog.title.latest_article') }}</span>
                </h2>
            </div>
        </div>
    </div>

    <style>
        .heading {
            font-size: 100px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .para-desc {
            font-size: 20px;
        }
        @media (max-width: 576px) {
            h2 .display-4 {
                font-size: 1.5rem;
                /* Smaller font size for extra small screens */
            }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            h2 .display-4 {
                font-size: 2rem;
                /* Medium font size for small screens */
            }
        }

        @media (min-width: 768px) and (max-width: 992px) {
            h2 .display-4 {
                font-size: 2.5rem;
                /* Larger font size for medium screens */
            }
        }

        @media (min-width: 992px) {
            h2 .display-4 {
                font-size: 3rem;
                /* Default font size for large screens */
            }
        }
    </style>

    <div class="row">
        <div class="col-lg-8">
            <!-- Post list:start -->
            @forelse ($latest_posts as $latest_post)
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Post thumbnail:start -->
                                @if (file_exists(public_path($latest_post->thumbnail)))
                                    <img class="card-img-top rounded lazyload"
                                        data-src="{{ asset($latest_post->thumbnail) }}" alt="{{ $latest_post->title }}"
                                        style="width: 100%; height: 200px; object-fit: contain;">
                                @else
                                    <img class="img-fluid rounded lazyload" data-src="http://placehold.it/750x300"
                                        alt="{{ $latest_post->title }}"
                                        style="width: 100%; height: 200px; object-fit: contain;">
                                @endif
                                <!-- Post thumbnail:end -->
                            </div>
                            <div class="col-lg-6">
                                <h4 class="card-title">{{ $latest_post->title }}</h4>
                                <p class="card-text">{{ Str::limit($latest_post->description, 150) }}</p>
                                <a href="{{ route('blog.posts.detail', ['slug' => $latest_post->slug]) }}"
                                    class="btn btn-primary">
                                    {{ trans('blog.button.read_more.value') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h3 class="text-center">
                    {{ trans('blog.no_data.posts') }}
                </h3>
            @endforelse
            <!-- Post list:end -->

            <!-- Pagination:start -->
            @if ($latest_posts->hasPages())
                <div class="row">
                    <div class="col">
                        {{ $latest_posts->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            @endif
            <!-- Pagination:end -->
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Popular posts in sidebar -->
            <div class="card mb-4 shadow-sm">
                <h4 class="card-header">{{ trans('blog.title.popular_posts') }}</h4>
                <div class="card-body">
                    @foreach ($popular_posts as $index => $post)
                        <div class="media mb-3 border-bottom pb-3">
                            <!-- Thumbnail -->
                            <img data-src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                                class="mr-3 rounded-circle lazyload" style="width: 80px; height: 80px; object-fit: cover;">
                            <noscript>
                                <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                                    class="mr-3 rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                            </noscript>
                            <div class="media-body">
                                <!-- Title -->
                                <h6 class="mt-0">
                                    <a
                                        href="{{ route('blog.posts.detail', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                                </h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async=""></script>
