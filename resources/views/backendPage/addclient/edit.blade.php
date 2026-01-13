<x-app-layout>
    <div class="py-4 px-1 body_area">
          <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                     <!-- Breadcrumb Section -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-house"></i> Dashboard
                            </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                          Update Client name
                            </li>
                        </ol>
                    </nav>
                       <a href="{{ route('addclient.index') }}" class="btn btn-primary addBtn">
                     Back
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                 <div class="add_case_area">
            <form id="dataSubmit-form" action="{{ route('addclient.update', $addclient->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form_group">
                            <input type="text" name="name" id="name" value="{{ $addclient->name }}"
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
                            <input type="text" name="number" id="number" value="{{ $addclient->number }}"
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
                            <input type="email" name="email" id="email" value="{{ $addclient->email }}"
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
                            <input type="text" name="address" id="address" value="{{ $addclient->address }}"
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
                        <div class="">
                            <label for="status" class="">
                                Status
                            </label>
                            <br>
                            <input class="" type="checkbox" name="status"
                                {{ $addclient->status == 1 ? 'checked' : '' }}>
                            <p>Checked = Running <br> unchecked = Disposal</p>
                        </div>
                    </div>



                </div>

                <button type="button" id="saveButton" class="mt-6 save btn btn-primary">Save</button>
            </form>

            <script>
                document.getElementById('saveButton').addEventListener('click', function(event) {
                    Swal.fire({
                        title: "Do you want to Update?",
                        icon: "question",
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Update",
                        denyButtonText: `Don't Update`
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
