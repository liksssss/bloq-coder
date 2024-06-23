@extends('layouts.blog')

@section('title')
    {{ trans('blog.title.categories') }}
@endsection

@section('content')
    <h2 class="my-3">
        {{ trans('blog.title.categories') }}
    </h2>

    <!-- Breadcrumb:start -->
    {{ Breadcrumbs::render('blog_categories') }}
    <!-- Breadcrumb:end -->

    <!-- List category -->
    <div class="row">
        @forelse ($categories as $category)
            <div class="col-lg-4 col-sm-6 portfolio-item">
                <div class="card h-100">
                    @if ($category->thumbnail)
                        <img class="card-img-top" src="{{ asset($category->thumbnail) }}" alt="{{ $category->title }}">
                    @else
                        <img class="img-fluid rounded" src="http://placehold.it/750x300" alt="{{ $category->title }}">
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{{ route('blog.posts.category', ['slug' => $category->slug]) }}">
                                {{ $category->title }}
                            </a>
                        </h4>
                        <p class="card-text">
                            {{ $category->description }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <h3 class="text-center">
                    {{ trans('blog.no_data.categories') }}
                </h3>
            </div>
        @endforelse
    </div>
    <!-- List category -->

    <!-- Pagination -->
    @if ($categories->hasPages())
        <div class="row">
            <div class="col">
                {{ $categories->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    @endif
    <!-- Pagination -->
@endsection
