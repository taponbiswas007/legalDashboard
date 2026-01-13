<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="py-4 d-flex justify-content-between align-items-center">
            <h1>{{ $imagegallery->Title }}</h1>
            <a href="{{ route('imagegallery.index') }}" class="btn btn-primary addBtn">
                Back to list
            </a>
        </div>

        <div class="add_case_area">
            <h2><span class=" fw-blod fs-5">Title:</span> <br>
                {{ $imagegallery->title }}
            </h2>
            <br>

            <h2><span class=" fw-blod fs-5">Image:</span> <br>
                <img style="height: 200px; width:150px; border-radius:10px"
                    src="{{ asset('images/' . $imagegallery->image) }}" alt="">
            </h2>
            <br>
            <h2>Status: <br>
                {!! $imagegallery->status == 1 ? '<span class="running">Visible</span>' : '<span class="dismiss">hidden</span>' !!}
            </h2>

        </div>



    </div>
</x-app-layout>
