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
                                Courts
                            </li>
                        </ol>
                    </nav>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#importCourtModal" class="btn btn-success">
                            <i class="fa-solid fa-file-import"></i> Import Excel
                        </button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createCourtModal" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Add Court
                        </button>
                          <a href="{{route('court_types.index')}}"  class="btn btn-secondary">
                            <i class="fa-solid fa-plus"></i> Add Court Category
                        </a>
                         <a href="{{ route('courts.export') }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Court Modal -->
        <div class="modal fade" id="createCourtModal" tabindex="-1" aria-labelledby="createCourtModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createCourtModalLabel">Create Court</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createCourtForm">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form_group position-relative">
                                        <label class="select_form_label" for="court_type_id_create">Court Category *</label>
                                        <input type="hidden" id="court_type_id_create" name="court_type_id">

                                        <!-- Main input (styled by your CSS) -->
                                        <input type="text"
                                            id="court_type_input_create"
                                            class="form-control"
                                            placeholder="Select court type"
                                            readonly
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            required>

                                        <!-- Bootstrap dropdown -->
                                        <div class="dropdown-menu shadow w-100 p-2" id="courtTypeDropdownCreate">
                                            <!-- Search inside dropdown -->
                                            <input type="text"
                                                    class="form-control form-control-sm mb-2"
                                                    id="courtTypeSearchCreate"
                                                    placeholder="Search court types...">

                                            <!-- List -->
                                            <div id="courtTypeListCreate"
                                                class="list-group list-group-flush"
                                                style="max-height: 200px; overflow-y: auto;">
                                                @foreach ($courtTypes as $courtType)
                                               <button type="button"
                                                    class="list-group-item list-group-item-action"
                                                    data-id="{{ $courtType->id }}"
                                                    onclick="selectCourtTypeCreate('{{ $courtType->id }}', `{{ addslashes($courtType->district) }} - {{ addslashes($courtType->court_type) }}`)">
                                                {{ $courtType->district }} - {{ $courtType->court_type }}
                                                </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="error court_type_id_error text-danger small"></div>
                                </div>
                                <div class="col-12">
                                    <div class="form_group">
                                        <input type="text" name="name" id="courtName" value="{{ old('name') }}" placeholder="Court Name" required>
                                        <label class="form_label" for="courtName">Court Name *</label>
                                    </div>
                                    <div class="error name_error text-danger small"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveCourtBtn">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Court Modal -->
        <div class="modal fade" id="editCourtModal" tabindex="-1" aria-labelledby="editCourtModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editCourtModalLabel">Edit Court</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editCourtForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editCourtId" name="id">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form_group position-relative">
                                        <label class="select_form_label" for="court_type_id_edit">Court Category *</label>
                                        <input type="hidden" id="court_type_id_edit" name="court_type_id">

                                        <!-- Main input (styled by your CSS) -->
                                        <input type="text"
                                            id="court_type_input_edit"
                                            class="form-control"
                                            placeholder="Select court type"
                                            readonly
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            required>

                                        <!-- Bootstrap dropdown -->
                                        <div class="dropdown-menu shadow w-100 p-2" id="courtTypeDropdownEdit">
                                            <!-- Search inside dropdown -->
                                            <input type="text"
                                                    class="form-control form-control-sm mb-2"
                                                    id="courtTypeSearchEdit"
                                                    placeholder="Search court types...">

                                            <!-- List -->
                                            <div id="courtTypeListEdit"
                                                class="list-group list-group-flush"
                                                style="max-height: 200px; overflow-y: auto;">
                                                <!-- Dynamic content will be loaded -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="error edit_court_type_id_error text-danger small"></div>
                                </div>
                                <div class="col-12">
                                    <div class="form_group">
                                        <input type="text" name="name" id="editCourtName" placeholder="Court Name" required>
                                        <label class="form_label" for="editCourtName">Court Name *</label>
                                    </div>
                                    <div class="error edit_name_error text-danger small"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateCourtBtn">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Import Court Modal -->
        <div class="modal fade" id="importCourtModal" tabindex="-1" aria-labelledby="importCourtModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="importCourtModalLabel">Import Courts from Excel</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="importCourtForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form_group position-relative">
                                        <label class="select_form_label" for="court_type_id_import">Court Category *</label>
                                        <input type="hidden" id="court_type_id_import" name="court_type_id">

                                        <!-- Main input (styled by your CSS) -->
                                        <input type="text"
                                            id="court_type_input_import"
                                            class="form-control"
                                            placeholder="Select court type"
                                            readonly
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            required>

                                        <!-- Bootstrap dropdown -->
                                        <div class="dropdown-menu shadow w-100 p-2" id="courtTypeDropdownImport">
                                            <!-- Search inside dropdown -->
                                            <input type="text"
                                                    class="form-control form-control-sm mb-2"
                                                    id="courtTypeSearchImport"
                                                    placeholder="Search court types...">

                                            <!-- List -->
                                            <div id="courtTypeListImport"
                                                class="list-group list-group-flush"
                                                style="max-height: 200px; overflow-y: auto;">
                                                @foreach ($courtTypes as $courtType)
                                               <button type="button"
                                                        class="list-group-item list-group-item-action"
                                                        data-id="{{ $courtType->id }}"
                                                        onclick="selectCourtTypeImport(`{{ $courtType->id }}`, `{{ $courtType->district }} - {{ $courtType->court_type }}`)">
                                                    {{ $courtType->district }} - {{ $courtType->court_type }}
                                                </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="error import_court_type_id_error text-danger small"></div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Excel File *</label>
                                    <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required>
                                    <div class="form-text">Supported formats: .xlsx, .xls, .csv</div>
                                    <div class="error excel_file_error text-danger small"></div>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <h6>Excel Format (Only name column needed):</h6>
                                        <table class="table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Dhaka Judge Court 1</td>
                                                </tr>
                                                <tr>
                                                    <td>Dhaka Judge Court 2</td>
                                                </tr>
                                                <tr>
                                                    <td>Dhaka Judge Court 3</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="importCourtBtn">Import</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteCourtModal" tabindex="-1" aria-labelledby="deleteCourtModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteCourtModalLabel">Delete Court</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this court?</p>
                        <input type="hidden" id="deleteCourtId">
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
                    <table class="table w-full" id="courtsTable">
                        <thead>
                            <tr>
                                <th>S/L No</th>
                                <th>District</th>
                                <th>Court Type</th>
                                <th>Court Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courts as $index => $court)
                            <tr id="courtRow_{{ $court->id }}">
                                <td>
                                      {{ $courts->firstItem() ? $courts->firstItem() + $index : $index + 1 }}
                                </td>
                                <td>{{ $court->courtType->district }}</td>
                                <td>{{ $court->courtType->court_type }}</td>
                                <td>{{ $court->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $court->id }}">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $court->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($courts->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No courts found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                {{$courts->Links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    $(document).ready(function() {
        // Initialize dropdown functionality for all modals
        initializeCourtTypeDropdown('create');
        initializeCourtTypeDropdown('edit');
        initializeCourtTypeDropdown('import');

        // Save court
        $('#saveCourtBtn').click(function(e) {
            e.preventDefault();
            createCourt();
        });

        // Update court
        $('#updateCourtBtn').click(function(e) {
            e.preventDefault();
            updateCourt();
        });

        // Import court
        $('#importCourtBtn').click(function(e) {
            e.preventDefault();
            importCourt();
        });

        // Delete court
        $('#confirmDeleteBtn').click(function(e) {
            e.preventDefault();
            deleteCourt();
        });

        // Edit button click
        $(document).on('click', '.edit-btn', function() {
            var courtId = $(this).data('id');
            editCourt(courtId);
        });

        // Delete button click
        $(document).on('click', '.delete-btn', function() {
            var courtId = $(this).data('id');
            $('#deleteCourtId').val(courtId);
            $('#deleteCourtModal').modal('show');
        });

        // Clear form when create modal is closed
        $('#createCourtModal').on('hidden.bs.modal', function () {
            $('#createCourtForm')[0].reset();
            $('#court_type_id_create').val('');
            $('#court_type_input_create').val('');
            $('.error').text('');
        });

        // Clear form when edit modal is closed
        $('#editCourtModal').on('hidden.bs.modal', function () {
            $('.error').text('');
        });

        // Clear form when import modal is closed
        $('#importCourtModal').on('hidden.bs.modal', function () {
            $('#importCourtForm')[0].reset();
            $('#court_type_id_import').val('');
            $('#court_type_input_import').val('');
            $('.error').text('');
        });
    });

    // Initialize court type dropdown functionality
    function initializeCourtTypeDropdown(type) {
        const input = document.getElementById(`court_type_input_${type}`);
        const searchInput = document.getElementById(`courtTypeSearch${type.charAt(0).toUpperCase() + type.slice(1)}`);
        const list = document.getElementById(`courtTypeList${type.charAt(0).toUpperCase() + type.slice(1)}`);
        const courtTypes = {{ Js::from($courtTypes) }};

        // Live search filtering
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const term = this.value.toLowerCase();
                const buttons = list.querySelectorAll('.list-group-item');
                buttons.forEach(btn => {
                    const text = btn.textContent.toLowerCase();
                    btn.style.display = text.includes(term) ? 'block' : 'none';
                });
            });
        }

        // Initialize dropdown
        if (input) {
            new bootstrap.Dropdown(input, { autoClose: true });

            // Focus search when dropdown opens
            input.addEventListener('click', () => {
                setTimeout(() => {
                    if (searchInput) searchInput.focus();
                }, 150);
            });
        }
    }

    // Select court type for create modal
    function selectCourtTypeCreate(id, name) {
        document.getElementById('court_type_id_create').value = id;
        document.getElementById('court_type_input_create').value = name;
        const bsDropdown = bootstrap.Dropdown.getInstance(document.getElementById('court_type_input_create'));
        bsDropdown.hide();
    }

    // Select court type for edit modal
    function selectCourtTypeEdit(id, name) {
        document.getElementById('court_type_id_edit').value = id;
        document.getElementById('court_type_input_edit').value = name;
        const bsDropdown = bootstrap.Dropdown.getInstance(document.getElementById('court_type_input_edit'));
        bsDropdown.hide();
    }

    // Select court type for import modal
    function selectCourtTypeImport(id, name) {
        document.getElementById('court_type_id_import').value = id;
        document.getElementById('court_type_input_import').value = name;
        const bsDropdown = bootstrap.Dropdown.getInstance(document.getElementById('court_type_input_import'));
        bsDropdown.hide();
    }

    // Create court
    function createCourt() {
        // Clear previous errors
        $('.error').text('');

        // Validate court type selection
        if (!$('#court_type_id_create').val()) {
            $('.court_type_id_error').text('Please select a court type.');
            return;
        }

        var formData = $('#createCourtForm').serialize();

        $.ajax({
            url: "{{ route('courts.store') }}",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#createCourtModal').modal('hide');
                    $('#createCourtForm')[0].reset();
                    $('#court_type_id_create').val('');
                    $('#court_type_input_create').val('');
                    
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
                    showError('An error occurred while creating court');
                }
            }
        });
    }

    // Edit court - fetch data
    // Simple Edit Court Function
function editCourt(id) {
    $.ajax({
        url: '/courts/' + id,
        type: "GET",
        dataType: "json",
        success: function(response) {
            $('#editCourtId').val(response.id);
            $('#editCourtName').val(response.name);
            
            // Simple approach - use existing court types directly
            const courtTypes = {{ Js::from($courtTypes) }};
            const courtTypeListEdit = document.getElementById('courtTypeListEdit');
            
            // Clear existing list
            courtTypeListEdit.innerHTML = '';
            
            // Populate with court types
            courtTypes.forEach(courtType => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'list-group-item list-group-item-action';
                button.setAttribute('data-id', courtType.id);
                button.textContent = courtType.district + ' - ' + courtType.court_type;
                button.onclick = function() {
                    selectCourtTypeEdit(courtType.id, courtType.district + ' - ' + courtType.court_type);
                };
                courtTypeListEdit.appendChild(button);
            });
            
            // Set current selection
            $('#court_type_id_edit').val(response.court_type_id);
            $('#court_type_input_edit').val(response.court_type.district + ' - ' + response.court_type.court_type);
            
            // Re-initialize search functionality
            initializeEditSearch();
            
            $('#editCourtModal').modal('show');
        },
        error: function(xhr) {
            showError('Failed to load court data');
        }
    });
}

// Initialize search for edit modal
function initializeEditSearch() {
    const searchInput = document.getElementById('courtTypeSearchEdit');
    const list = document.getElementById('courtTypeListEdit');
    
    if (searchInput && list) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            const buttons = list.querySelectorAll('.list-group-item');
            buttons.forEach(btn => {
                const text = btn.textContent.toLowerCase();
                btn.style.display = text.includes(term) ? 'block' : 'none';
            });
        });
    }
}

    // Update court
    function updateCourt() {
        // Clear previous errors
        $('.edit_error').text('');

        // Validate court type selection
        if (!$('#court_type_id_edit').val()) {
            $('.edit_court_type_id_error').text('Please select a court type.');
            return;
        }

        var courtId = $('#editCourtId').val();
        var formData = $('#editCourtForm').serialize();

        $.ajax({
            url: '/courts/' + courtId,
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#editCourtModal').modal('hide');
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
                    showError('An error occurred while updating court');
                }
            }
        });
    }

    // Import court
    function importCourt() {
        // Clear previous errors
        $('.error').text('');

        // Validate court type selection
        if (!$('#court_type_id_import').val()) {
            $('.import_court_type_id_error').text('Please select a court type.');
            return;
        }

        var formData = new FormData($('#importCourtForm')[0]);

        $.ajax({
            url: "{{ route('courts.import') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#importCourtModal').modal('hide');
                    $('#importCourtForm')[0].reset();
                    $('#court_type_id_import').val('');
                    $('#court_type_input_import').val('');
                    
                    showSuccessAndRedirect(response.message, response.redirect);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.import_' + key + '_error').text(value[0]);
                    });
                } else {
                    showError('An error occurred while importing courts');
                }
            }
        });
    }

    // Delete court
    function deleteCourt() {
        var courtId = $('#deleteCourtId').val();

        $.ajax({
            url: '/courts/' + courtId,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#deleteCourtModal').modal('hide');
                    showSuccessAndRedirect(response.message, response.redirect);
                }
            },
            error: function(xhr) {
                showError('An error occurred while deleting court');
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