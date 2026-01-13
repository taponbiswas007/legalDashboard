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
                                Court Category
                            </li>
                        </ol>
                    </nav>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#createCategoryModal" class="btn btn-primary addBtn">
                        +Add Court Category
                    </button>
                </div>
            </div>
        </div>

        <!-- Create Court Type Modal -->
        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createCategoryModalLabel">Create Court Type</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createCourtTypeForm">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form_group">
                                        <input type="text" name="district" id="district" value="{{ old('district') }}" placeholder="District">
                                        <label class="form_label" for="district">District</label>
                                    </div>
                                    <div class="error district_error text-danger small"></div>
                                </div>
                                <div class="col-12">
                                    <div class="form_group">
                                        <input type="text" name="court_type" id="courtType" value="{{ old('court_type') }}" placeholder="Court Type">
                                        <label class="form_label" for="courtType">Court Category</label>
                                    </div>
                                    <div class="error court_type_error text-danger small"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveCourtTypeBtn">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Court Type Modal -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editCategoryModalLabel">Edit Court Type</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editCourtTypeForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editCourtTypeId" name="id">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form_group">
                                        <input type="text" name="district" id="editDistrict" placeholder="District">
                                        <label class="form_label" for="editDistrict">District</label>
                                    </div>
                                    <div class="error edit_district_error text-danger small"></div>
                                </div>
                                <div class="col-12">
                                    <div class="form_group">
                                        <input type="text" name="court_type" id="editCourtType" placeholder="Court Type">
                                        <label class="form_label" for="editCourtType">Court Category</label>
                                    </div>
                                    <div class="error edit_court_type_error text-danger small"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateCourtTypeBtn">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteCategoryModalLabel">Delete Court Type</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this court type?</p>
                        <input type="hidden" id="deleteCourtTypeId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                @if (session('success'))
                <script>
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        title: '{{ session('success') }}',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                </script>
                @endif

                <div class="table_container">
                    <table class="table w-full" id="courtTypesTable">
                        <thead>
                            <tr>
                                <th>S/L No</th>
                                <th>District</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courtTypes as $index => $courtType)
                            <tr id="courtTypeRow_{{ $courtType->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $courtType->district }}</td>
                                <td>{{ $courtType->court_type }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $courtType->id }}">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $courtType->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($courtTypes->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">No court types found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    $(document).ready(function() {
        // Load court types on page load
        // Table already loaded with server-side data

        // Save court type - form submit
        $('#saveCourtTypeBtn').click(function(e) {
            e.preventDefault();
            createCourtType();
        });

        // Update court type
        $('#updateCourtTypeBtn').click(function(e) {
            e.preventDefault();
            updateCourtType();
        });

        // Delete court type
        $('#confirmDeleteBtn').click(function(e) {
            e.preventDefault();
            deleteCourtType();
        });

        // Edit button click
        $(document).on('click', '.edit-btn', function() {
            var courtTypeId = $(this).data('id');
            editCourtType(courtTypeId);
        });

        // Delete button click
        $(document).on('click', '.delete-btn', function() {
            var courtTypeId = $(this).data('id');
            $('#deleteCourtTypeId').val(courtTypeId);
            $('#deleteCategoryModal').modal('show');
        });

        // Enter key to submit forms
        $('#createCategoryModal input, #editCategoryModal input').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                if ($(this).closest('#createCategoryModal').length) {
                    createCourtType();
                } else {
                    updateCourtType();
                }
            }
        });

        // Clear form when create modal is closed
        $('#createCategoryModal').on('hidden.bs.modal', function () {
            $('#createCourtTypeForm')[0].reset();
            $('.error').text('');
        });

        // Clear form when edit modal is closed
        $('#editCategoryModal').on('hidden.bs.modal', function () {
            $('.error').text('');
        });
    });

    // Create court type
    function createCourtType() {
        // Clear previous errors
        $('.error').text('');

        var formData = $('#createCourtTypeForm').serialize();

        $.ajax({
            url: "{{ route('court_types.store') }}",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#createCategoryModal').modal('hide');
                    $('#createCourtTypeForm')[0].reset();
                    
                    // Show success message and redirect
                    showSuccessAndRedirect(response.message, response.redirect);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    showError('An error occurred while creating court type');
                }
            }
        });
    }

    // Edit court type - fetch data
    function editCourtType(id) {
        $.ajax({
            url: '/court_types/' + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                $('#editCourtTypeId').val(response.id);
                $('#editDistrict').val(response.district);
                $('#editCourtType').val(response.court_type);
                $('#editCategoryModal').modal('show');
            },
            error: function(xhr) {
                showError('Failed to load court type data');
            }
        });
    }

    // Update court type
    function updateCourtType() {
        // Clear previous errors
        $('.edit_error').text('');

        var courtTypeId = $('#editCourtTypeId').val();
        var formData = $('#editCourtTypeForm').serialize();

        $.ajax({
            url: '/court_types/' + courtTypeId,
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#editCategoryModal').modal('hide');
                    
                    // Show success message and redirect
                    showSuccessAndRedirect(response.message, response.redirect);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.edit_' + key + '_error').text(value[0]);
                    });
                } else {
                    showError('An error occurred while updating court type');
                }
            }
        });
    }

    // Delete court type
    function deleteCourtType() {
        var courtTypeId = $('#deleteCourtTypeId').val();

        $.ajax({
            url: '/court_types/' + courtTypeId,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#deleteCategoryModal').modal('hide');
                    
                    // Show success message and redirect
                    showSuccessAndRedirect(response.message, response.redirect);
                }
            },
            error: function(xhr) {
                showError('An error occurred while deleting court type');
            }
        });
    }

    // Helper function to show success message and redirect
    function showSuccessAndRedirect(message, redirectUrl) {
        Swal.fire({
            toast: true,
            icon: 'success',
            title: message,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        }).then(() => {
            // Redirect after showing success message
            window.location.href = redirectUrl;
        });
    }

    // Helper function for error messages
    function showError(message) {
        Swal.fire({
            toast: true,
            icon: 'error',
            title: message,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    }
    </script>
    @endpush
</x-app-layout>