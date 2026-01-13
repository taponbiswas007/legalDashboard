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
                                All Notifications
                            </li>
                        </ol>
                    </nav>
                    <button id="markAllRead" class="btn btn-primary">
                        <i class="fas fa-check-double"></i> Mark All as Read
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                @if ($allNotifications->isEmpty())
                    <div class="text-center py-5">
                        <i class="far fa-bell-slash text-muted" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 text-muted">No notifications yet</h5>
                        <p class="text-muted">You'll see notifications here when subscribers or job applications arrive.
                        </p>
                    </div>
                @else
                    <div class="notifications-container">
                        @foreach ($allNotifications as $notification)
                            <div class="notification-card {{ $notification['read_at'] ? 'read' : 'unread' }} mb-3">
                                <a href="{{ $notification['route'] }}" class="text-decoration-none">
                                    <div class="d-flex align-items-start gap-3 p-3 border rounded">
                                        <div
                                            class="notification-icon-large bg-{{ $notification['color'] }} bg-opacity-10 rounded-circle p-3 flex-shrink-0">
                                            <i
                                                class="fas {{ $notification['icon'] }} text-{{ $notification['color'] }} fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0 fw-bold">{{ $notification['title'] }}</h6>
                                                @if (!$notification['read_at'])
                                                    <span class="badge bg-danger rounded-pill">New</span>
                                                @endif
                                            </div>
                                            <p class="mb-2 text-muted">{{ $notification['content'] }}</p>
                                            <small class="text-muted">
                                                <i class="far fa-clock"></i>
                                                {{ $notification['created_at']->timezone('Asia/Dhaka')->format('M d, Y \a\t h:i A') }}
                                                ({{ $notification['created_at']->timezone('Asia/Dhaka')->diffForHumans() }})
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('markAllRead').addEventListener('click', function() {
                fetch('{{ route('notifications.markAllRead') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: data.message,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });

                            // Remove "New" badges and unread styling
                            document.querySelectorAll('.notification-card.unread').forEach(card => {
                                card.classList.remove('unread');
                                card.classList.add('read');
                                const badge = card.querySelector('.badge');
                                if (badge) badge.remove();
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to mark notifications as read',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .notification-card.unread {
                background-color: #e7f3ff;
                border-left: 4px solid #0d6efd !important;
            }

            .notification-card.read {
                opacity: 0.8;
            }

            .notification-card:hover {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
                transition: all 0.3s ease;
            }

            .notification-icon-large {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        </style>
    @endpush
</x-app-layout>
