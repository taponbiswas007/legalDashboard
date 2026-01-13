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
                            <a href="{{ route('notifications.all') }}" class="text-decoration-none text-dark">
                                Notifications
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Subscriber Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-envelope"></i> Newsletter Subscriber
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <!-- Subscriber Info -->
                        <div class="text-center mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-envelope text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="fw-bold">{{ $subscriber->email }}</h4>
                            <p class="text-muted mb-0">
                                <i class="far fa-clock"></i>
                                Subscribed {{ $subscriber->created_at->timezone('Asia/Dhaka')->diffForHumans() }}
                            </p>
                            <small class="text-muted">
                                {{ $subscriber->created_at->timezone('Asia/Dhaka')->format('F d, Y \a\t h:i A') }}
                            </small>
                        </div>

                        <!-- Status -->
                        <div class="alert alert-info" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2 fs-5"></i>
                                <div>
                                    <strong>Status:</strong>
                                    @if ($subscriber->read_at)
                                        <span class="badge bg-success ms-2">Read</span>
                                        <small class="d-block text-muted mt-1">
                                            Viewed {{ $subscriber->read_at->timezone('Asia/Dhaka')->diffForHumans() }}
                                        </small>
                                    @else
                                        <span class="badge bg-warning ms-2">New</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Email Details Card -->
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-body">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-info-circle"></i> Subscription Details
                                </h6>
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="fw-bold" style="width: 140px;">Email Address:</td>
                                        <td>
                                            <a href="mailto:{{ $subscriber->email }}" class="text-decoration-none">
                                                {{ $subscriber->email }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Subscriber ID:</td>
                                        <td>#{{ $subscriber->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">IP Address:</td>
                                        <td>{{ $subscriber->ip_address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">User Agent:</td>
                                        <td><small>{{ $subscriber->user_agent ?? 'N/A' }}</small></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <a href="{{ route('notifications.all') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Notifications
                            </a>
                            <a href="mailto:{{ $subscriber->email }}" class="btn btn-primary">
                                <i class="fas fa-envelope"></i> Send Email
                            </a>
                            <button type="button" class="btn btn-danger"
                                onclick="confirmDelete({{ $subscriber->id }})">
                                <i class="fas fa-trash"></i> Delete Subscriber
                            </button>
                        </div>

                        <!-- Delete Form (Hidden) -->
                        <form id="delete-form-{{ $subscriber->id }}"
                            action="{{ route('subscribers.destroy', $subscriber->id) }}" method="POST" class="d-none">
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
            function confirmDelete(subscriberId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This subscriber will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + subscriberId).submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
