<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('messages.all') }}" class="text-decoration-none text-dark">
                                Messages
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Message Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-message"></i> Contact Message from {{ $message->name }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <!-- Sender Avatar & Name -->
                        <div class="text-center mb-4">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <span class="fw-bold text-info fs-2">
                                    {{ strtoupper(substr($message->name, 0, 1)) . strtoupper(substr(strstr($message->name, ' '), 1, 1)) }}
                                </span>
                            </div>
                            <h4 class="fw-bold">{{ $message->name }}</h4>
                            <p class="text-muted mb-0">
                                <i class="far fa-clock"></i>
                                Received {{ $message->created_at->timezone('Asia/Dhaka')->diffForHumans() }}
                            </p>
                            <small class="text-muted">
                                {{ $message->created_at->timezone('Asia/Dhaka')->format('F d, Y \a\t h:i A') }}
                            </small>
                        </div>

                        <!-- Contact Information -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <h6 class="text-primary fw-bold mb-3">
                                            <i class="fas fa-user"></i> Contact Information
                                        </h6>
                                        <table class="table table-borderless mb-0">
                                            <tr>
                                                <td class="fw-bold" style="width: 100px;">Name:</td>
                                                <td>{{ $message->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Phone:</td>
                                                <td>
                                                    <a href="tel:{{ $message->number }}" class="text-decoration-none">
                                                        <i class="fas fa-phone text-success"></i> {{ $message->number }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Email:</td>
                                                <td>
                                                    <a href="mailto:{{ $message->email }}"
                                                        class="text-decoration-none">
                                                        <i class="fas fa-envelope text-primary"></i>
                                                        {{ $message->email }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <h6 class="text-primary fw-bold mb-3">
                                            <i class="fas fa-info-circle"></i> Message Status
                                        </h6>
                                        <table class="table table-borderless mb-0">
                                            <tr>
                                                <td class="fw-bold" style="width: 100px;">Status:</td>
                                                <td>
                                                    @if ($message->read)
                                                        <span class="badge bg-success">Read</span>
                                                    @else
                                                        <span class="badge bg-warning">Unread</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Message ID:</td>
                                                <td>#{{ $message->id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Received:</td>
                                                <td>{{ $message->created_at->timezone('Asia/Dhaka')->format('M d, Y h:i A') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-body">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-comment-dots"></i> Message Content
                                </h6>
                                <div class="bg-white p-4 rounded border">
                                    <p class="mb-0" style="white-space: pre-wrap; line-height: 1.8;">
                                        {{ $message->message }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Notes (Optional) -->
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-body">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-sticky-note"></i> Admin Notes
                                </h6>
                                <form action="{{ route('messages.updateNotes', $message->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="admin_notes" class="form-control mb-2" rows="3"
                                        placeholder="Add internal notes about this message...">{{ $message->admin_notes ?? '' }}</textarea>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-save"></i> Save Notes
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Quick Action Buttons -->
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <a href="{{ route('messages.all') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Messages
                            </a>
                            <a href="mailto:{{ $message->email }}" class="btn btn-primary">
                                <i class="fas fa-envelope"></i> Reply via Email
                            </a>
                            <a href="tel:{{ $message->number }}" class="btn btn-success">
                                <i class="fas fa-phone"></i> Call {{ $message->name }}
                            </a>
                            <a href="https://wa.me/88{{ $message->number }}" target="_blank" class="btn btn-success">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $message->id }})">
                                <i class="fas fa-trash"></i> Delete Message
                            </button>
                        </div>

                        <!-- Delete Form (Hidden) -->
                        <form id="delete-form-{{ $message->id }}"
                            action="{{ route('messages.destroy', $message->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(messageId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This message will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + messageId).submit();
                    }
                });
            }

            @if (session('success'))
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: '{{ session('success') }}',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush
</x-app-layout>
