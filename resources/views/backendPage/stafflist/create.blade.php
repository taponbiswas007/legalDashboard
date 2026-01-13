<x-app-layout>
    <div class="py-4 px-1 body_area">
         <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <!-- Breadcrumb Section -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-house"></i> Dashboard
                            </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                            Add Staff
                            </li>
                        </ol>
                    </nav>
                     <a href="{{ route('stafflist.index') }}" class="btn btn-primary addBtn">
                        View Staff list
                    </a>
                </div>
                
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                  <div class="add_case_area">
                    <form id="dataSubmit-form" action="{{ route('stafflist.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        placeholder="Name">
                                    <label class="form_label" for="">Name</label>
                                </div>
                                @error('name')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" name="number" id="number" value="{{ old('number') }}"
                                        placeholder="Mobile number">
                                    <label class="form_label" for="">Mobile number</label>
                                </div>
                                @error('number')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        placeholder="Email">
                                    <label class="form_label" for="">Email</label>
                                </div>
                                @error('email')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}"
                                        placeholder="whatsapp">
                                    <label class="form_label" for="">Whats app number</label>
                                </div>
                                @error('whatsapp')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" name="qualification" id="qualification"
                                        value="{{ old('qualification') }}" placeholder="Qualification">
                                    <label class="form_label" for="">Educational Qualification</label>
                                </div>
                                @error('qualification')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" name="possition" id="possition" value="{{ old('possition') }}"
                                        placeholder="possition">
                                    <label class="form_label" for="">Possition</label>
                                </div>
                                @error('possition')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                                        placeholder="Address">
                                    <label class="form_label" for="">Address</label>
                                </div>
                                @error('address')
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
                                    <p>Checked = Running <br> unchecked = Disposal</p>
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
        </div>

      



    </div>
</x-app-layout>
