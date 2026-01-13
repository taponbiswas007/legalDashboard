@extends('frontendLayouts.master')
@section('title', $blog->title . ' - Legal Blog | SK Sharif & Associates')
@section('meta_description', Str::limit(strip_tags($blog->content), 160))
@section('meta_keywords', $blog->category . ', legal blog, law, Bangladesh, ' . $blog->title)
@section('content')
    <!-- ==========Banner area start=========== -->
    <div class="banner">
        <div class="banner-content">
            <h1>{{ $blog->category }}</h1>
            <p>{{ $blog->title }}</p>

        </div>
    </div>
    <!-- ==========Banner area end=========== -->
    <div class="container">
        <div class="d-flex justify-content-end py-4">
            <div class="blog-meta">

                <span class="ms-2">Published: {{ $blog->created_at }}</span>

            </div>
        </div>

        <!-- Blog Image Box -->
        <div class="d-flex justify-content-center py-4">
            <div class="blog-image">
                <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->category }}" class="img-fluid rounded">
            </div>
        </div>

        <div class="py-4">
            {!! $blog->content !!}
        </div>
    </div>
@endsection
