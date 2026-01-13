<x-app-layout>
    <div class="py-4 px-1 body_area">
        <!-- Header Section -->
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center gap-3 flex-column flex-sm-row">
                    <!-- Breadcrumb Section -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                    <i class="fa-solid fa-house"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Add Note
                            </li>
                        </ol>
                    </nav>
                    <div>
                        <a href="{{ route('notes.index') }}" class="btn btn-primary">
                            View Note list
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                 <div class="add_case_area">
                    <form id="dataSubmit-form" action="{{ route('notes.store') }}" method="POST">
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

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form_group">
                                    <label class=" fw-bold fs-5" for="">Write your Note here</label>
                                    <textarea class=" descriptionarea w-100 overflow-x-auto" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <label class="form_label bg-white" style=" top: -10px;">Status</label>
                                    <select name="status" class="">
                                        <option value="Pending" {{ old('status')=='Pending'?'selected':'' }}>Pending</option>
                                        <option value="Done" {{ old('status')=='Done'?'selected':'' }}>Done</option>
                                        <option value="Reject" {{ old('status')=='Reject'?'selected':'' }}>Reject</option>
                                    </select>
                                    @error('status')<p class="m-2 text-danger">{{ $message }}</p>@enderror
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
                                denyButtonText: "Don't save",
                                cancelButtonText: "Cancel"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('dataSubmit-form').submit();
                                } else if (result.isDenied) {
                                    Swal.fire("Changes are not saved", "", "info");
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
       
    </div>
</x-app-layout>