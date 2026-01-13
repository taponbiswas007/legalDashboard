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
                                Note List
                            </li>
                        </ol>
                    </nav>
                    <div>
                        <a href="{{ route('notes.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- TABLE -->
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="table_container">
                    <table class="table align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($notes as $key => $note)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $note->title }}</td>
                                   <!-- <td>{{ Str::limit(strip_tags($note->description), 50) }}</td> -->
                                   <td>
                                        {{ mb_strimwidth(strip_tags($note->description), 0, 50, '...', 'UTF-8') }}
                                    </td>





                                    <td>
                                        <div class="status-container">
                                            <!-- Custom Status Badge -->
                                            <div class="status-badge {{ strtolower($note->status) }}-status" 
                                                 data-id="{{ $note->id }}"
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#statusModal">
                                                <i class="status-icon 
                                                    {{ $note->status == 'Pending' ? 'fa-solid fa-clock' : 
                                                       ($note->status == 'Done' ? 'fa-solid fa-check' : 'fa-solid fa-xmark') }}"></i>
                                                <span class="status-text">{{ $note->status }}</span>
                                                <i class="fa-solid fa-chevron-down ms-1 dropdown-arrow"></i>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Show Button -->
                                            <button class="btn btn-info btn-sm show-btn"
                                                data-id="{{ $note->id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#showModal">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <button class="btn btn-warning btn-sm edit-btn"
                                                data-id="{{ $note->id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $note->id }}"
                                                data-title="{{ $note->title }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No notes found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $notes->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Status Change Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white py-2">
                    <h6 class="modal-title mb-0">
                        <i class="fa-solid fa-arrows-spin me-1"></i>
                        Change Status
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="status-options">
                        <div class="status-option pending-option" data-status="Pending">
                            <div class="status-indicator pending-indicator"></div>
                            <i class="fa-solid fa-clock status-option-icon"></i>
                            <span class="status-option-text">Pending</span>
                        </div>
                        
                        <div class="status-option done-option" data-status="Done">
                            <div class="status-indicator done-indicator"></div>
                            <i class="fa-solid fa-check status-option-icon"></i>
                            <span class="status-option-text">Done</span>
                        </div>
                        
                        <div class="status-option reject-option" data-status="Reject">
                            <div class="status-indicator reject-indicator"></div>
                            <i class="fa-solid fa-xmark status-option-icon"></i>
                            <span class="status-option-text">Reject</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Show Modal -->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-width: 100% !important">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="showModalLabel">Note Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Title</label>
                            <p id="show_title" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <p id="show_status" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description</label>
                            <div id="show_description" class="border p-3 rounded bg-light note_description_area" style="width: 100%; overflow-x: auto;"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-width: 100% !important">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control rounded" id="edit_title" required>
                            </div>

                            <div class="col-12">
                                <label class="fw-bold fs-5">Write your Note here</label>
                                <!-- Changed ID to avoid conflict -->
                                <textarea class="descriptionarea w-100 overflow-x-auto" name="description" id="edit_description" cols="30" rows="10"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" id="edit_status" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Done">Done</option>
                                    <option value="Reject">Reject</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .note_description_area table tbody td {
            border-style: solid !important;
            border-width: 1px !important;
            border-color: #000000;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status Change Modal
            const statusModal = document.getElementById('statusModal');
            let currentNoteId = null;

            // Status badge click
            document.querySelectorAll('.status-badge').forEach(badge => {
                badge.addEventListener('click', function() {
                    currentNoteId = this.getAttribute('data-id');
                });
            });

            // Status option selection
            document.querySelectorAll('.status-option').forEach(option => {
                option.addEventListener('click', function() {
                    const newStatus = this.getAttribute('data-status');
                    
                    if (!currentNoteId) return;

                    // Update via AJAX
                    fetch(`/notes/${currentNoteId}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the status badge
                            const badge = document.querySelector(`.status-badge[data-id="${currentNoteId}"]`);
                            
                            // Remove existing status classes
                            badge.classList.remove('pending-status', 'done-status', 'reject-status');
                            // Add new status class
                            badge.classList.add(`${newStatus.toLowerCase()}-status`);
                            
                            // Update icon and text
                            const iconClass = newStatus === 'Pending' ? 'fa-solid fa-clock' : 
                                            newStatus === 'Done' ? 'fa-solid fa-check' : 'fa-solid fa-xmark';
                            badge.innerHTML = `<i class="status-icon ${iconClass}"></i>
                                            <span class="status-text">${newStatus}</span>
                                            <i class="fa-solid fa-chevron-down ms-1 dropdown-arrow"></i>`;
                            
                            // Hide modal
                            bootstrap.Modal.getInstance(statusModal).hide();
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Status updated successfully!',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            throw new Error('Update failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to update status!'
                        });
                    });
                });
            });

            // Show Modal
            const showModal = document.getElementById('showModal');
            showModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const noteId = button.getAttribute('data-id');
                
                fetch(`/notes/${noteId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const note = data.note;
                            
                            // Populate show modal fields
                            document.getElementById('show_title').textContent = note.title;
                            document.getElementById('show_status').textContent = note.status;
                            document.getElementById('show_description').innerHTML = note.description;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load note data!'
                        });
                    });
            });

            // Edit Modal with TinyMCE initialization
            const editModal = document.getElementById('editModal');
            const editForm = document.getElementById('editForm');
            let editTinyMCEInitialized = false;

            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const noteId = button.getAttribute('data-id');

                // Initialize TinyMCE for edit modal if not already initialized
                // if (!editTinyMCEInitialized) {
                //     tinymce.init({
                //         selector: '#edit_description',
                //         height: 300,
                //         menubar: false,
                //         plugins: [
                //             'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                //             'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                //             'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount', 'table', 'textcolor'
                //         ],
                //         toolbar: 'undo redo | blocks | bold italic underline | ' +
                //             'alignleft aligncenter alignright alignjustify | ' +
                //             'bullist numlist outdent indent | removeformat | help | table tableprops tablecellprops | forecolor backcolor',
                //         content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                //     });
                //     editTinyMCEInitialized = true;
                // }
               if (!editTinyMCEInitialized) {
    tinymce.init({
        selector: '#edit_description',
        height: 300,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'textcolor', 'fontsize'
        ],
        toolbar: 'undo redo | formatselect | fontselect fontsize | bold italic underline | ' +
                'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ' +
                'link image | table | forecolor backcolor | removeformat | preview | help',
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
    editTinyMCEInitialized = true;
}


                fetch(`/notes/${noteId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const note = data.note;

                            document.getElementById('edit_title').value = note.title;
                            
                            // Set content in TinyMCE editor
                            if (tinymce.get('edit_description')) {
                                tinymce.get('edit_description').setContent(note.description);
                            } else {
                                // Fallback: set textarea value directly
                                document.getElementById('edit_description').value = note.description;
                            }
                            
                            document.getElementById('edit_status').value = note.status;
                            editForm.action = `/notes/${noteId}`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load note data!'
                        });
                    });
            });

            // Edit Form submit with TinyMCE
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Make sure TinyMCE content is saved to textarea
                if (tinymce.get('edit_description')) {
                    tinymce.triggerSave();
                }

                const formData = new FormData(this);
                const noteId = this.action.split('/').pop();

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(editModal);
                        modal.hide();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Failed to update note!'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update note!'
                    });
                });
            });

            // Clean up TinyMCE when modal is closed
            editModal.addEventListener('hidden.bs.modal', function() {
                if (tinymce.get('edit_description')) {
                    tinymce.get('edit_description').setContent('');
                }
            });

            // Delete Button
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let id = this.getAttribute('data-id');
                    let title = this.getAttribute('data-title');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You want to delete "${title}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, Delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Use fetch API for delete
                            fetch(`/notes/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    return response.json();
                                }
                                throw new Error('Delete failed');
                            })
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Note deleted successfully.',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    throw new Error('Delete failed');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to delete note!'
                                });
                            });
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>