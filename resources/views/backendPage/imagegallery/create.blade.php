<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="py-4 d-flex justify-content-between align-items-center">
            <h1>Add Image</h1>
            <a href="{{ route('imagegallery.index') }}" class="btn btn-primary addBtn">
                View All
            </a>
        </div>

        <div class="add_case_area">
            <form id="dataSubmit-form" action="{{ route('imagegallery.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form_group">
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                placeholder="title">
                            <label class="form_label" for="">Title</label>
                        </div>
                        @error('title')
                            <p class="m-2 text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form_group">
                            <input type="file" name="image" id="image" value="{{ old('image') }}"
                                placeholder="image">
                            <label class="form_label" for="">Image</label>
                        </div>
                        @error('image')
                            <p class="m-2 text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="">
                            <label for="status" class="">
                                Status
                            </label>
                            <br>
                            <input class="" type="checkbox" name="status" checked>
                            <p>Checked = Vissible <br> unchecked = Hidden</p>
                        </div>
                    </div>



                </div>

                <button type="button" id="saveButton" class="mt-6 save btn btn-primary">Save</button>
            </form>

            <script>
                document.getElementById('saveButton').addEventListener('click', function(event) {
                    Swal.fire({
                        title: "Do you want to save?",
                        icon: "question",
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Save",
                        denyButtonText: `Don't save`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Proceed with form submission
                            Swal.fire("Saved!", "", "success").then(() => {
                                document.getElementById('dataSubmit-form').submit();
                            });
                        }
                    });
                });
            </script>
        </div>



    </div>
</x-app-layout>
