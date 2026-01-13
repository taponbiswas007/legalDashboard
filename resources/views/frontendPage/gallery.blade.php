@extends('frontendLayouts.master')

@section('title', 'Gallery')
@section('content')
<!-- ==========Banner area start=========== -->
        <div class="banner">
            <div class="banner-content">
              <h1>Gallery</h1>
              <p></p>
           
            </div>
          </div>
<!-- ==========Banner area end=========== -->

<div class="container my-5">
        <h1 class="text-center mb-4">Image Gallery</h1>
        <div class="gallery">
            @foreach ($imagegalleries->reverse() as  $imagegallery)
                        <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ asset('images/' . $imagegallery->image) }}">
                <img src="{{ asset('images/' . $imagegallery->image) }}" alt="Image 1">
            </div>
            @endforeach
            <!-- Example Images -->

            <!--<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600">-->
            <!--    <img src="https://via.placeholder.com/800x600" alt="Image 2">-->
            <!--</div>-->
            <!--<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600">-->
            <!--    <img src="https://via.placeholder.com/800x600" alt="Image 3">-->
            <!--</div>-->
            <!-- Add more images dynamically -->
        </div>
    </div>

    <!-- Modal for Image Popup -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

@endsection