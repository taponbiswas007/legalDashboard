<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="py-4 d-flex justify-content-between align-items-center">
            <h1>Our Trusted Client</h1>
            <a href="{{ route('trustedclient.index') }}" class="btn btn-primary addBtn">
                Back to list
            </a>
        </div>

        <div class="add_case_area">

            <h2><span class=" fw-blod fs-5">Image:</span> <br>
                <img style="height: 200px; width:150px; border-radius:10px" src="{{ asset($trustedclient->image) }}"
                    alt="">
            </h2>
            <br>
            <h2>Status: <br>
                {!! $trustedclient->status == 1 ? '<span class="running">Visible</span>' : '<span class="dismiss">hidden</span>' !!}
            </h2>

        </div>



    </div>
</x-app-layout>
