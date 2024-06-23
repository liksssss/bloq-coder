@extends('layouts.dashboard')

@section('title')
    {{ trans('categories.title.detail') }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('detail_category_title', $category) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- thumbnail:start --}}
                    <div class="bg-primary border">
                        <h3 class="card-header bg-primary" style="color:rgb(255, 255, 255)">
                            {{ trans('posts.form_control.input.thumbnail.label') }} :
                        </h3>
                        <div class="card-body bg-light">
                             <!-- thumbnail:true -->
                            @if (file_exists(public_path($category->thumbnail)))
                            <div class="category-tumbnail" style="background-image: url('{{ asset($category->thumbnail) }}');">
                            </div>
                            @else
                            <!-- thumbnail:false -->
                            <svg class="img-fluid" width="100%" height="400" xmlns="http://www.w3.org/2000/svg"
                                preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                                <rect width="100%" height="100%" fill="#868e96"></rect>
                                <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#dee2e6"
                                    dy=".3em" font-size="24">
                                    {{ $category->title }}
                                </text>
                            </svg>
                           @endif
                        </div>
                    </div>
                    {{-- thumbnail:end --}}
                    <!-- title -->
                    <div class="border">
                        <h3 class="card-header bg-primary" style="color:rgb(255, 255, 255)">
                           {{ trans('posts.form_control.input.title.label') }} :
                        </h3>
                        <h2 class="card-body bg-light">
                           {{ $category->title }}
                        </h2>
                      </div>
                    <!-- description -->
                    <div class="border my-2">
                        <h3 class="card-header bg-primary" style="color:rgb(255, 255, 255)">
                           {{ trans('posts.form_control.textarea.description.label') }} :
                        </h3>
                      <p class="card-body bg-light text-justify">
                        {{ $category->description }}
                      </p>
                      </div>
                    {{-- descruption:end --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-primary mx-1" role="button">
                            {{ trans('categories.button.back.value') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css-internal')
    <style>
        .category-tumbnail {
            width: 100%;
            height: 400px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>
@endpush
