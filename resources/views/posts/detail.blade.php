@extends('layouts.dashboard')

@section('title')
    {{ trans('posts.title.detail') }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('detail_post', $post)}}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
       <div class="card">
          <div class="card-body">
            {{-- thumbnail --}}
            <div class="bg-secondary border">
               <h3 class="card-header bg-primary" style="color:rgb(255, 255, 255)">
                  {{ trans('posts.form_control.input.thumbnail.label') }} :
               </h3>
               <div class="card-body bg-light">
                  @if (file_exists(public_path($post->thumbnail)))
                <!-- thumbnail:true -->
                <div class="post-tumbnail" style="background-image: url('{{ $post->thumbnail }}');">
                </div>   
               @else
                <!-- thumbnail:false -->
                <svg class="img-fluid" width="100%" height="400" xmlns="http://www.w3.org/2000/svg"
                   preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                   <rect width="100%" height="100%" fill="#868e96"></rect>
                   <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#dee2e6" dy=".3em"
                      font-size="24">
                       {{ $post->thumbnail }}
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
                  {{ $post->title }}
               </h2>
             </div>
             {{-- end:titile --}}
             <!-- author -->
             <div class="border">
             <h3 class="card-header bg-primary" style="color:rgb(255, 255, 255)">
               {{ trans('posts.form_control.input.author.label') }} :
             </h3>
             <h2 class="card-body bg-light">
                {{ $post->author }}
             </h2>
             </div>
               <!-- description -->
             <div class="border">
               <h3 class="card-header bg-primary" style="color:rgb(255, 255, 255)">
                  {{ trans('posts.form_control.textarea.description.label') }} :
               </h3>
             <p class="card-body bg-light text-justify">
               {{ $post->description }}
             </p>
             </div>
             <!-- description:end -->
             <!-- categories -->
             <div class="border">
               <h3 class="card-header bg-primary" style="color:rgb(255, 255, 255)">
                  {{ trans('posts.form_control.input.category.label') }} :
               </h3>
             @foreach ($categories as $category)
             <span class="m-3 badge badge-primary">{{ $category->title }}</span>
             @endforeach
             </div>
             {{-- categories:end --}}
             <!-- content -->
             <div class="border">
               <h3 class="card-header bg-primary" style="color:rgb(255, 255, 255)">
                  {{ trans('posts.form_control.textarea.content.label') }} :
               </h3>
               <div class="py-1 card-body bg-light">
                  {!! $post->content !!}
               </div>
             </div>
             <!-- tags  -->
             <div class="my-2 border">
               <h3 class="card-header bg-primary" style="color:rgb(255, 255, 255)">
                  {{ trans('posts.form_control.select.tag.label') }} :
               </h3>
               @foreach ($tags as $tag)
               <span class="m-3 badge badge-info">#{{ $tag->title }}</span>
               @endforeach 
             </div>
             {{-- tags:end --}}
             <div class="d-flex justify-content-end">
                <a href="{{ route('posts.index') }}" class="btn btn-primary mx-1" role="button">
                   {{ trans('posts.button.back.value') }}
                </a>
             </div>
          </div>
       </div>
    </div>
 </div>

@endsection

@push('css-internal')
<style>
    .post-tumbnail {
     width: 100%;
     height: 400px;
     background-repeat: no-repeat;
     background-position: center;
     background-size: cover;
  }
  </style>
@endpush