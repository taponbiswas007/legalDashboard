<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend_assets/img/logo.png') }}">
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bungee&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />


    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('backend_assets/css/styles.css') }}">
    <style>
        .handle-btn {
            cursor: grab;
            border: none;
            padding: 0 6px;
            color: #6c757d;
            transition: all 0.2s ease;
        }

        .handle-btn:active {
            cursor: grabbing;
            transform: scale(1.1);
        }

        th.dragging {
            opacity: 0.3;
            background: transparent !important;
        }

        .ghost-element {
            cursor: grabbing !important;
        }

        .drop-target {
            background: rgba(0, 123, 255, 0.1) !important;
            border: 2px dashed #007bff !important;
            transition: all 0.2s ease;
        }

        .drop-indicator-before,
        .drop-indicator-after {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.4;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.4;
            }
        }

        body.dragging-active {
            cursor: grabbing !important;
            user-select: none;
        }

        td.hidden,
        th.hidden {
            display: none !important;
        }

        #casesTable th,
        #casesTable td {
            vertical-align: middle;
            user-select: none;
            transition: all 0.2s ease;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>

<body>
    <div class="overflow-hidden full_wrapper">
        <div class="container-fluid px-0">
            <div class="dashboard_full_area">
                <!-- ================side bar area================ -->
                {{-- @livewire('navigation-menu') --}}

                <div x-data="{ open: false }" class="sidebar_area">
                    <nav id="sidebarMenu"
                        class="d-flex flex-column flex-shrink-0 p-3 bg-white text-dark vh-100 shadow-sm border-end">

                        <!-- Logo & Close Button -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <!-- Title -->
                            <a href="{{ route('dashboard') }}"
                                class="d-flex align-items-center text-dark text-decoration-none">
                                <div class="logo">
                                    <img src="{{ asset('backend_assets/images/logo.png') }}" alt="Logo"
                                        style="max-height: 40px;">
                                </div>
                                <span class="fw-semibold">SK.S Dashboard</span>
                            </a>
                            <button class=" border-0 text-secondary closeBtn d-lg-none">
                                <i class="fa-solid fa-xmark fs-5"></i>
                            </button>
                        </div>


                        <hr>

                        <!-- Nav Menu -->
                        <ul class="nav nav-pills flex-column mb-auto">

                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}"
                                    class="nav-link {{ request()->is('dashboard') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard
                                </a>
                            </li>

                            <!-- Communications Section -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Communications</li>

                            <!-- All Notifications -->
                            <li class="nav-item">
                                <a href="{{ route('notifications.all') }}"
                                    class="nav-link {{ request()->is('notifications/all') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-bell me-2 text-primary"></i> All Notifications
                                </a>
                            </li>

                            <!-- All Messages -->
                            <li class="nav-item">
                                <a href="{{ route('messages.all') }}"
                                    class="nav-link {{ request()->is('messages/all') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-envelope me-2 text-info"></i> All Messages
                                </a>
                            </li>

                            <!-- Note & Work Section -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Note & Work</li>

                            <!-- Add Note -->
                            <li class="nav-item">
                                <a href="{{ route('notes.create') }}"
                                    class="nav-link {{ request()->is('notes/create') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas  fa-file-contract me-2 text-success"></i> Add Notes
                                </a>
                            </li>

                            <!-- All Notes -->
                            <li class="nav-item">
                                <a href="{{ route('notes.index') }}"
                                    class="nav-link {{ request()->is('notes') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-sticky-note me-2 text-info"></i> All Notes
                                </a>
                            </li>

                            <!-- Daily Work -->
                            <li class="nav-item">
                                <a href="{{ route('dashboard.daily_work') }}"
                                    class="nav-link {{ request()->is('daily_work*') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-tasks me-2 text-warning"></i> Daily Works
                                </a>
                            </li>

                            <!-- Cases -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Cases</li>

                            <li>
                                <a href="{{ route('addcase.create') }}"
                                    class="nav-link {{ request()->is('addcase/create') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-folder-plus me-2 text-success"></i> Add Case
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('addcase.index') }}"
                                    class="nav-link {{ request()->is('addcase') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-folder-open me-2 text-info"></i> View Cases
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('needUpdateTransfer') }}"
                                    class="nav-link {{ request()->is('needUpdateTransfer') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-exchange-alt me-2 text-warning"></i> Need Update Transfer
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('todayUpdated') }}"
                                    class="nav-link {{ request()->is('todayUpdated') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-sync-alt me-2 text-info"></i> Today Updated Case
                                </a>
                            </li>

                            <!-- Legal Notice -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Legal Notice</li>

                            <li class="nav-item">
                                <a href="{{ route('legalnoticecategories.create') }}"
                                    class="nav-link {{ request()->is('legalnoticecategories/create') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-plus-circle me-2 text-success"></i>Add Section
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('legalnoticecategories.index') }}"
                                    class="nav-link {{ request()->is('legalnoticecategories') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-layer-group me-2 text-info"></i> All Section
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('legalnotice.create') }}"
                                    class="nav-link {{ request()->is('legalnotice/create') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-file-contract me-2 text-warning"></i> Add Legal Notice
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('legalnotice.index') }}"
                                    class="nav-link {{ request()->is('legalnotice') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-gavel me-2 text-primary"></i> All Legal Notices
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('legalnotice.pricing.index') }}"
                                    class="nav-link {{ request()->is('legalnotice/pricing') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-tags me-2 text-success"></i> Manage Pricing
                                </a>
                            </li>

                            <!-- Clients -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Clients</li>

                            @if (auth()->check() && auth()->user()->hasRole('user'))
                                <li>
                                    <a href="{{ route('addclient.create') }}"
                                        class="nav-link {{ request()->is('addclient/create') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-user-plus me-2 text-success"></i> Add Clients
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('client.branch.page') }}"
                                        class="nav-link {{ request()->is('addclient/create') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-user-plus me-2 text-success"></i> Client Branch
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('addclient.index') }}"
                                        class="nav-link {{ request()->is('addclient') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-users me-2 text-info"></i> View Clients
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('addclient.approvals') }}"
                                        class="nav-link {{ request()->is('addclient/approvals') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-user-check me-2 text-success"></i> Client Approvals
                                    </a>
                                </li>
                            @endif
                            @if (auth()->check() && auth()->user()->hasRole('manager'))
                                <li class="nav-item">
                                    <a href="{{ route('manager.addclient.request.create') }}"
                                        class="nav-link {{ request()->is('manager/addclient/request') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-user-plus me-2 text-success"></i> Request Add Client
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('manager.addclient.requests') }}"
                                        class="nav-link {{ request()->is('manager/addclient/requests') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-users me-2 text-info"></i> My Client Requests
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('manager.approvals.addclients') }}"
                                        class="nav-link {{ request()->is('manager/approvals/addclients') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-clock me-2 text-warning"></i> Pending Add Clients
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('manager.addclient.rejected') }}"
                                        class="nav-link {{ request()->is('manager/addclient/rejected') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-ban me-2 text-danger"></i> Rejected Client Requests
                                    </a>
                                </li>
                            @endif



                            <!-- courts -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Courts</li>
                            <li>
                                <a href="{{ route('courts.index') }}"
                                    class="nav-link {{ request()->is('courts') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-scale-balanced me-2 text-success"></i> Court List
                                </a>
                            </li>

                            <!-- Billing section -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Billing Section</li>
                            <li class="nav-item">
                                <a href="{{ route('legalnotice.bill') }}"
                                    class="nav-link {{ request()->is('legal-notice-bill') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-file-invoice me-2 text-warning"></i> Legal Notice Bill
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('legalnotice.bills.index') }}"
                                    class="nav-link {{ request()->routeIs('legalnotice.bills.*') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-file-invoice-dollar me-2 text-info"></i>
                                    Legal Notice Bill List
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('casehistory.bill.index') }}"
                                    class="nav-link {{ request()->is('case-history-bill') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-receipt me-2 text-warning"></i> Make Case Bill
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('case_bill.list') }}"
                                    class="nav-link {{ request()->is('case_bill/list') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-clipboard-list me-2 text-info"></i> Case Bill list
                                </a>
                            </li>

                            <!-- Staff -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Recruitment</li>

                            <li>
                                <a href="{{ route('jobs.index') }}"
                                    class="nav-link {{ request()->is('admin/jobs*') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-briefcase me-2 text-info"></i> Job Circulars
                                </a>
                            </li>

                            <!-- Staff -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Staff</li>

                            <li>
                                <a href="{{ route('stafflist.create') }}"
                                    class="nav-link {{ request()->is('stafflist/create') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-user-plus me-2 text-success"></i> Add Staff
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('stafflist.index') }}"
                                    class="nav-link {{ request()->is('stafflist') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-user-tie me-2 text-info"></i> View Staff
                                </a>
                            </li>

                            <!-- Media & Blogs -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">Media & Blogs</li>

                            <li>
                                <a href="{{ route('trustedclient.create') }}"
                                    class="nav-link {{ request()->is('trustedclient/create') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-award me-2 text-warning"></i> Add Trusted Client
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('trustedclient.index') }}"
                                    class="nav-link {{ request()->is('trustedclient') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-handshake me-2 text-success"></i> View Trusted Clients
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('blog.create') }}"
                                    class="nav-link {{ request()->is('blog/create') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-blog me-2 text-info"></i> Add Blog
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('imagegallery.index') }}"
                                    class="nav-link {{ request()->is('imagegallery') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-images me-2 text-primary"></i> Image Gallery
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('imagegallery.create') }}"
                                    class="nav-link {{ request()->is('imagegallery/create') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-upload me-2 text-success"></i> Upload Image
                                </a>
                            </li>

                            <!-- User Profile -->
                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="fw-bold text-uppercase small text-secondary px-2">{{ Auth::user()->name }}</li>
                            <li>
                                <a href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')"
                                    class="nav-link {{ request()->is('user/profile') ? 'active-link' : 'text-dark' }}">
                                    <i class="fas fa-user-cog me-2 text-secondary"></i> Profile
                                </a>
                            </li>

                            @if (auth()->user() && auth()->user()->role === 'user')
                                <li class="nav-item">
                                    <a href="{{ route('managers.index') }}"
                                        class="nav-link {{ request()->is('managers*') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-users-cog me-2 text-primary"></i> Manager Control
                                    </a>
                                </li>
                            @endif

                            @if (auth()->user() && auth()->user()->role === 'manager')
                                <li class="nav-item">
                                    <a href="{{ route('manager.addclient.request.create') }}"
                                        class="nav-link {{ request()->is('manager/addclient/request') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-user-plus me-2 text-success"></i> Request Add Client
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('manager.approvals.addclients') }}"
                                        class="nav-link {{ request()->is('manager/approvals/addclients') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-clock me-2 text-warning"></i> Pending Add Clients
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('manager.addclient.rejected') }}"
                                        class="nav-link {{ request()->is('manager/addclient/rejected') ? 'active-link' : 'text-dark' }}">
                                        <i class="fas fa-ban me-2 text-danger"></i> Rejected Client Requests
                                    </a>
                                </li>
                            @endif
                        </ul>

                        <hr class="my-2">

                        <!-- Logout -->
                        <div class="text-center small">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <a href="{{ route('logout') }}"
                                    class="text-decoration-none text-secondary fw-semibold"
                                    @click.prevent="$root.submit();"><i class="fas fa-right-from-bracket me-1"></i>
                                    Logout</a>
                            </form>
                        </div>
                    </nav>
                </div>

                <!-- =========== main area start============ -->
                <div class="main_body_area">
                    <!-- header area -->

                    <header class="p-2 gap-2 d-flex justify-content-between align-items-center position-relative">
                        <!-- Toggle bar -->
                        <div class="togglebar">
                            <button id="toggleBtn">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                        </div>

                        <!-- Normal Header Content -->
                        <div class="gap-2 profile d-flex justify-content-between align-items-center flex-grow-1"
                            id="normalHeader">
                            <div class="gap-3 d-flex justify-content-between align-items-center ms-auto">
                                <!-- Search icon -->
                                <button id="searchIconBtn" class="btn btn-light border-0">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>

                                <!-- Notification area -->
                                <div class="notification_area position-relative">
                                    <button class="notificationBtn">
                                        <i class="fa-regular fa-bell"></i>
                                    </button>
                                    @php
                                        $totalNotifications =
                                            ($subscribers->count() ?? 0) + ($jobApplications->count() ?? 0);
                                    @endphp
                                    @if ($totalNotifications > 0)
                                        <span class="notification-badge">{{ $totalNotifications }}</span>
                                    @endif
                                    <div class="msg_and_notify_area" id="ntfBox">
                                        <div class="notification-header px-3 py-2 border-bottom">
                                            <h6 class="mb-0 fw-bold">Notifications</h6>
                                        </div>
                                        <ul class="notification-list">
                                            @php
                                                $allNotifications = collect([
                                                    ...$subscribers->map(
                                                        fn($s) => [
                                                            'type' => 'subscriber',
                                                            'id' => $s->id,
                                                            'title' => 'New Subscriber',
                                                            'content' => $s->email,
                                                            'icon' => 'fa-envelope',
                                                            'color' => 'primary',
                                                            'route' => route('showSubscriber', $s->id),
                                                            'created_at' => $s->created_at,
                                                            'read_at' => $s->read_at ?? null,
                                                        ],
                                                    ),
                                                    ...$jobApplications->map(
                                                        fn($j) => [
                                                            'type' => 'job_application',
                                                            'id' => $j->id,
                                                            'title' => 'New Job Application',
                                                            'content' => $j->name . ' applied for ' . $j->job->title,
                                                            'icon' => 'fa-briefcase',
                                                            'color' => 'success',
                                                            'route' => route('job.applications.show', $j->id),
                                                            'created_at' => $j->created_at,
                                                            'read_at' => $j->read_at ?? null,
                                                        ],
                                                    ),
                                                ])
                                                    ->sortByDesc('created_at')
                                                    ->take(5);
                                            @endphp

                                            @forelse ($allNotifications as $notification)
                                                <li
                                                    class="notification-item {{ $notification['read_at'] ? 'read' : 'unread' }}">
                                                    <a class="d-flex align-items-start gap-3 p-3 text-decoration-none"
                                                        href="{{ $notification['route'] }}">
                                                        <div
                                                            class="notification-icon bg-{{ $notification['color'] }} bg-opacity-10 rounded-circle p-2 flex-shrink-0">
                                                            <i
                                                                class="fas {{ $notification['icon'] }} text-{{ $notification['color'] }}"></i>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <div
                                                                class="d-flex justify-content-between align-items-start mb-1">
                                                                <h6 class="mb-0 fw-semibold text-dark small">
                                                                    {{ $notification['title'] }}</h6>
                                                                @if (!$notification['read_at'])
                                                                    <span
                                                                        class="badge bg-danger rounded-pill ms-2">New</span>
                                                                @endif
                                                            </div>
                                                            <p class="mb-1 text-muted small text-truncate">
                                                                {{ $notification['content'] }}</p>
                                                            <small class="text-muted">
                                                                <i class="far fa-clock"></i>
                                                                {{ $notification['created_at']->timezone('Asia/Dhaka')->diffForHumans() }}
                                                            </small>
                                                        </div>
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="text-center py-4">
                                                    <i class="far fa-bell-slash text-muted fs-2 mb-2"></i>
                                                    <p class="text-muted mb-0">No notifications yet</p>
                                                </li>
                                            @endforelse
                                        </ul>
                                        <div class="notification-footer border-top">
                                            <a href="{{ route('notifications.all') }}"
                                                class="d-block text-center py-2 text-primary fw-semibold text-decoration-none">
                                                <i class="fas fa-list me-1"></i> View All Notifications @if ($totalNotifications > 0)
                                                    ({{ $totalNotifications }})
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message area -->
                                <div class="message_area position-relative">
                                    <button class="messageBtn">
                                        <i class="fa-regular fa-message"></i>
                                    </button>
                                    @if ($messages->count())
                                        <span class="notification-badge">{{ $messages->count() }}</span>
                                    @endif
                                    <div class="msg_and_notify_area" id="msgBox">
                                        <div class="notification-header px-3 py-2 border-bottom">
                                            <h6 class="mb-0 fw-bold">Messages</h6>
                                        </div>
                                        <ul class="notification-list">
                                            @forelse ($messages->take(5) as $message)
                                                <li
                                                    class="notification-item {{ $message->read ? 'read' : 'unread' }}">
                                                    <a class="d-flex align-items-start gap-3 p-3 text-decoration-none"
                                                        href="{{ route('showMessage', $message->id) }}">
                                                        <div
                                                            class="notification-icon bg-info bg-opacity-10 rounded-circle p-2 flex-shrink-0">
                                                            <span class="fw-bold text-info">
                                                                {{ strtoupper(substr($message->name, 0, 1)) . strtoupper(substr(strstr($message->name, ' '), 1, 1)) }}
                                                            </span>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <div
                                                                class="d-flex justify-content-between align-items-start mb-1">
                                                                <h6 class="mb-0 fw-semibold text-dark small">
                                                                    {{ $message->name }}</h6>
                                                                @if (!$message->read)
                                                                    <span
                                                                        class="badge bg-danger rounded-pill ms-2">New</span>
                                                                @endif
                                                            </div>
                                                            <p class="mb-1 text-muted small text-truncate">
                                                                {{ Str::limit($message->message, 50) }}</p>
                                                            <small class="text-muted">
                                                                <i class="far fa-clock"></i>
                                                                {{ $message->created_at->timezone('Asia/Dhaka')->diffForHumans() }}
                                                            </small>
                                                        </div>
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="text-center py-4">
                                                    <i class="far fa-envelope text-muted fs-2 mb-2"></i>
                                                    <p class="text-muted mb-0">No messages yet</p>
                                                </li>
                                            @endforelse
                                        </ul>
                                        <div class="notification-footer border-top">
                                            <a href="{{ route('messages.all') }}"
                                                class="d-block text-center py-2 text-primary fw-semibold text-decoration-none">
                                                <i class="fas fa-envelope-open-text me-1"></i> View All Messages
                                                @if ($messages->count() > 0)
                                                    ({{ $messages->count() }})
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile -->
                                <div class="logo">
                                    <img src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}">
                                </div>
                            </div>
                        </div>

                        <!-- Full-width Search Mode -->
                        <div id="fullSearchArea" class="w-100 position-absolute top-0 start-0 d-none bg-white p-2">
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" id="globalSearch" class="form-control flex-grow-1 rounded"
                                    placeholder="Search clients or cases...">
                                <button id="closeSearch" class="btn btn-light border-0">
                                    <i class="fa-solid fa-xmark fs-4"></i>
                                </button>
                            </div>
                            <div id="searchResults" class="dropdown-menu w-100"
                                style="max-height: 300px; overflow-y: auto;"></div>
                        </div>
                    </header>


                    <!-- Page Content -->
                    <main>
                        <div style="overflow-y: auto; height: calc(100vh - 110px)"
                            class="px-0 px-lg-2 dashboard_main_content">
                            {{ $slot }}
                        </div>

                    </main>
                    <footer class="footer-area ">
                        <p>Copyright © BSP Digital Solutions. All rights reserved. | Design by Tapon | Website powered
                            by
                            www.bspdigitalsolutions.com</p>
                    </footer>
                </div>
                <!-- ===========main area end============ -->
            </div>
        </div>
    </div>

    <!-- Real-time Toast Notifications Container (outside wrapper to avoid overflow hidden) -->
    <div id="toast-container"
        style="position: fixed !important; bottom: 20px; left: 20px; z-index: 99999 !important;"></div>


    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- font awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/js/all.min.js"></script>
    <script src="{{ asset('backend_assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/sh4hids/bijoy-to-unicode@master/bijoy-to-unicode.js"></script>
    {{-- text area --}}
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>

    @stack('modals')

    @livewireScripts
    <script>
        tinymce.init({
            selector: 'textarea#description', // CSS selector to target your textarea
            menubar: false, // Hide the menubar
            plugins: 'lists link image preview textcolor advlist fontsize table', // Ensure the fontsize plugin is included
            toolbar: ' undo redo | fontsize | styles | formatselect | fontselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |  table tableprops tablecellprops | link image | preview', // Move fontsizeselect to the front
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt', // Define font size options
            height: 180, // Set the height of the editor
            branding: false, // Remove "Powered by Tiny" branding
        });
        tinymce.init({
            selector: 'textarea#description',
            plugins: 'fontsize',
            toolbar: 'fontsizeselect',
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        });
    </script>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            let editor = tinymce.get('description');
            let content = editor.getContent({
                format: 'text'
            });

            let unicodeText = bijoyToUnicode(content);
            editor.setContent(unicodeText);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchIconBtn = document.getElementById("searchIconBtn");
            const fullSearchArea = document.getElementById("fullSearchArea");
            const normalHeader = document.getElementById("normalHeader");
            const closeSearch = document.getElementById("closeSearch");

            searchIconBtn.addEventListener("click", () => {
                normalHeader.classList.add("d-none");
                fullSearchArea.classList.remove("d-none");
            });

            closeSearch.addEventListener("click", () => {
                fullSearchArea.classList.add("d-none");
                normalHeader.classList.remove("d-none");
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('globalSearch');
            const dropdown = document.getElementById('searchResults');
            let timeout = null;

            input.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(timeout);

                if (query.length < 2) {
                    dropdown.classList.remove('show');
                    dropdown.innerHTML = '';
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`/global-search?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            dropdown.innerHTML = '';
                            let hasResults = false;

                            // ---------- CLIENT RESULTS ----------
                            if (data.clients && data.clients.length > 0) {
                                hasResults = true;
                                const header = document.createElement('h6');
                                header.classList.add('dropdown-header', 'text-muted');
                                header.textContent = 'Clients';
                                dropdown.appendChild(header);

                                data.clients.forEach(client => {
                                    const item = document.createElement('a');
                                    item.classList.add('dropdown-item');
                                    item.textContent = client.name;
                                    item.href =
                                        `/addclient/${client.encrypted_id}/show`;
                                    dropdown.appendChild(item);
                                });
                            }

                            // ---------- CASE RESULTS ----------
                            if (data.cases && data.cases.length > 0) {
                                hasResults = true;
                                const header = document.createElement('h6');
                                header.classList.add('dropdown-header', 'text-muted');
                                header.textContent = 'Cases';
                                dropdown.appendChild(header);

                                data.cases.forEach(c => {
                                    const item = document.createElement('a');
                                    item.classList.add('dropdown-item');
                                    item.innerHTML = `
                                        <strong>${c.file_number}</strong> — ${c.case_number || ''}<br>
                                        <small>${c.name_of_parties}</small>
                                    `;
                                    // ✅ FIXED: Use encrypted ID and correct route
                                    item.href = `/addcase/${c.encrypted_id}/show`;
                                    dropdown.appendChild(item);
                                });
                            }

                            if (hasResults) {
                                dropdown.classList.add('show');
                            } else {
                                dropdown.innerHTML =
                                    '<span class="dropdown-item text-muted">No results found</span>';
                                dropdown.classList.add('show');
                            }
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            dropdown.innerHTML =
                                '<span class="dropdown-item text-muted">Search failed</span>';
                            dropdown.classList.add('show');
                        });
                }, 300);
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("form").forEach(function(form) {
                form.addEventListener("submit", function() {
                    const submitButtons = form.querySelectorAll(
                        'button[type="submit"], input[type="submit"]');

                    submitButtons.forEach(function(button) {
                        button.disabled = true;
                        button.innerText =
                            "Processing..."; // চাইলে টেক্সট পরিবর্তন করতে পারো
                    });
                });
            });
        });
    </script>

    <!-- Initialize Edit Case Modal JS -->
    <script>
        function initEditCaseModalJS() {
            console.log('initEditCaseModalJS: Initializing modal form handlers');

            const statusCheckbox = document.getElementById('status_checkbox');
            const transferCheckboxVisible = document.getElementById('transfer_checkbox_visible');
            const saveButton = document.getElementById('saveButton');

            console.log('Status Checkbox:', statusCheckbox);
            console.log('Transfer Checkbox Visible:', transferCheckboxVisible);
            console.log('Save Button:', saveButton);

            if (!statusCheckbox || !transferCheckboxVisible || !saveButton) {
                console.error('initEditCaseModalJS: Required elements not found');
                return;
            }

            // Initialize transfer checkbox state
            if (!statusCheckbox.checked) {
                transferCheckboxVisible.disabled = true;
                console.log('Transfer checkbox disabled (disposal case)');
            }

            // Remove old listeners to prevent duplicates
            statusCheckbox.removeEventListener('change', handleStatusCheckboxChange);
            transferCheckboxVisible.removeEventListener('change', handleTransferCheckboxChange);
            saveButton.removeEventListener('click', handleSaveButtonClick);

            // Attach status checkbox listener
            statusCheckbox.addEventListener('change', handleStatusCheckboxChange);

            // Attach transfer checkbox listener
            transferCheckboxVisible.addEventListener('change', handleTransferCheckboxChange);

            // Attach save button listener
            saveButton.addEventListener('click', handleSaveButtonClick);

            // Initialize searchable dropdowns
            initializeModalDropdowns();

            // Filter branches by currently selected client (if any)
            const currentClientId = document.getElementById('client_id');
            if (currentClientId && currentClientId.value) {
                filterBranchesByClient(currentClientId.value);
            }

            console.log('initEditCaseModalJS: Event listeners attached successfully');
        }

        // Initialize modal dropdowns (client, branch, court)
        function initializeModalDropdowns() {
            console.log('Initializing modal dropdowns');

            // Client dropdown
            const partyName = document.getElementById('party_name');
            const clientDropdown = document.getElementById('clientDropdown');
            const clientSearch = document.getElementById('clientSearch');
            const clientList = document.getElementById('clientList');

            if (partyName && clientDropdown && clientSearch && clientList) {
                // Open dropdown
                partyName.addEventListener('click', () => {
                    clientDropdown.classList.add('show');
                    setTimeout(() => clientSearch.focus(), 100);
                });

                // Filter clients
                clientSearch.addEventListener('input', () => {
                    const filter = clientSearch.value.toLowerCase();
                    clientList.querySelectorAll('button').forEach(btn => {
                        btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'block' :
                            'none';
                    });
                });

                // Close on outside click
                document.addEventListener('click', function(e) {
                    if (!partyName.contains(e.target) && !clientDropdown.contains(e.target)) {
                        clientDropdown.classList.remove('show');
                    }
                });
            }

            // Branch dropdown
            const branchInput = document.getElementById('branch_name');
            const branchDropdown = document.getElementById('branchDropdown');
            const branchSearch = document.getElementById('branchSearch');
            const branchList = document.getElementById('branchList');

            if (branchInput && branchDropdown && branchSearch && branchList) {
                // Open dropdown
                branchInput.addEventListener('click', () => {
                    branchDropdown.classList.add('show');
                    setTimeout(() => branchSearch.focus(), 100);
                });

                // Filter branches - only search within visible (client-filtered) branches
                branchSearch.addEventListener('input', () => {
                    const filter = branchSearch.value.toLowerCase();
                    const selectedClientId = document.getElementById('client_id').value;

                    branchList.querySelectorAll('button').forEach(btn => {
                        const buttonClientId = btn.getAttribute('data-client-id');
                        const matchesSearch = btn.textContent.toLowerCase().includes(filter);
                        const matchesClient = !selectedClientId || buttonClientId === selectedClientId;

                        // Show only if matches both search and client filter
                        btn.style.display = (matchesSearch && matchesClient) ? 'block' : 'none';
                    });
                });

                // Close on outside click
                document.addEventListener('click', function(e) {
                    if (!branchInput.contains(e.target) && !branchDropdown.contains(e.target)) {
                        branchDropdown.classList.remove('show');
                    }
                });
            }

            // Court dropdown
            const courtInput = document.getElementById('court_input');
            const courtDropdown = document.getElementById('courtDropdown');
            const courtSearch = document.getElementById('courtSearch');
            const courtList = document.getElementById('courtList');

            if (courtInput && courtDropdown && courtSearch && courtList) {
                // Open dropdown
                courtInput.addEventListener('click', () => {
                    courtDropdown.classList.add('show');
                    setTimeout(() => courtSearch.focus(), 100);
                });

                // Filter courts
                courtSearch.addEventListener('input', () => {
                    const filter = courtSearch.value.toLowerCase();
                    courtList.querySelectorAll('button').forEach(btn => {
                        btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'block' :
                            'none';
                    });
                });

                // Close on outside click
                document.addEventListener('click', function(e) {
                    if (!courtInput.contains(e.target) && !courtDropdown.contains(e.target)) {
                        courtDropdown.classList.remove('show');
                    }
                });
            }

            console.log('Modal dropdowns initialized');
        }

        // Global functions for dropdown selections (called from inline onclick)
        // These work with MULTIPLE contexts (modal, index page, offcanvas, etc.)
        window.selectClient = function(id, name) {
            console.log('Global selectClient called:', id, name);

            // Try different input field IDs used across the project
            const inputFields = ['party_name', 'client_input', 'client_name'];
            const hiddenFields = ['client_id'];

            // Set the visible input
            for (const fieldId of inputFields) {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.value = name;
                    console.log('Set client name in:', fieldId);
                }
            }

            // Set the hidden ID field
            for (const fieldId of hiddenFields) {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.value = id;
                    console.log('Set client ID in:', fieldId);
                }
            }

            // Close dropdown (both Bootstrap and manual methods)
            const clientDropdown = document.getElementById('clientDropdown');
            if (clientDropdown) {
                clientDropdown.classList.remove('show');
            }

            // Try to close Bootstrap dropdown if initialized
            const clientNameInput = document.getElementById('client_name');
            if (clientNameInput && typeof bootstrap !== 'undefined') {
                const dropdown = bootstrap.Dropdown.getInstance(clientNameInput);
                if (dropdown) {
                    dropdown.hide();
                }
            }

            // Filter branches by selected client (works if function exists)
            if (typeof filterBranchesByClient === 'function') {
                filterBranchesByClient(id);
            } else if (typeof window.filterBranchesByClient === 'function') {
                window.filterBranchesByClient(id);
            }

            // Clear branch selection when client changes
            const branchInputs = ['branch_name', 'branch_input'];
            const branchHidden = ['branch_id'];

            for (const fieldId of branchInputs) {
                const field = document.getElementById(fieldId);
                if (field) field.value = '';
            }
            for (const fieldId of branchHidden) {
                const field = document.getElementById(fieldId);
                if (field) field.value = '';
            }
        };

        // Filter branches based on selected client
        function filterBranchesByClient(clientId) {
            console.log('Filtering branches for client:', clientId);
            const branchList = document.getElementById('branchList');
            if (!branchList) return;

            const branchButtons = branchList.querySelectorAll('button');
            let visibleCount = 0;

            branchButtons.forEach(button => {
                const buttonClientId = button.getAttribute('data-client-id');

                if (!clientId || buttonClientId === clientId) {
                    button.style.display = 'block';
                    visibleCount++;
                } else {
                    button.style.display = 'none';
                }
            });

            console.log(`Showing ${visibleCount} branches for client ${clientId}`);
        }

        window.selectBranch = function(id, name) {
            console.log('Global selectBranch called:', id, name);

            // Try different input field IDs used across the project
            const inputFields = ['branch_name', 'branch_input'];
            const hiddenFields = ['branch_id'];

            // Set the visible input
            for (const fieldId of inputFields) {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.value = name;
                    console.log('Set branch name in:', fieldId);
                }
            }

            // Set the hidden ID field
            for (const fieldId of hiddenFields) {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.value = id;
                    console.log('Set branch ID in:', fieldId);
                }
            }

            // Close dropdown (both methods)
            const branchDropdown = document.getElementById('branchDropdown');
            if (branchDropdown) {
                branchDropdown.classList.remove('show');
            }

            // Try to close Bootstrap dropdown if initialized
            const branchNameInput = document.getElementById('branch_name');
            if (branchNameInput && typeof bootstrap !== 'undefined') {
                const dropdown = bootstrap.Dropdown.getInstance(branchNameInput);
                if (dropdown) {
                    dropdown.hide();
                }
            }
        };

        window.selectCourt = function(id, name) {
            console.log('selectCourt called:', id, name);

            // Court input is consistent across project
            const courtInput = document.getElementById('court_input');
            const courtId = document.getElementById('court_id');

            if (courtInput) {
                courtInput.value = name;
                console.log('Set court name');
            }
            if (courtId) {
                courtId.value = id;
                console.log('Set court ID');
            }

            // Close dropdown
            const courtDropdown = document.getElementById('courtDropdown');
            if (courtDropdown) {
                courtDropdown.classList.remove('show');
            }
        };

        window.addNewClient = function() {
            const clientDropdown = document.getElementById('clientDropdown');
            if (clientDropdown) {
                clientDropdown.classList.remove('show');
            }
            window.location.href = '/addclient/create';
        };

        window.addNewBranch = function() {
            const branchDropdown = document.getElementById('branchDropdown');
            if (branchDropdown) {
                branchDropdown.classList.remove('show');
            }
            window.location.href = '/client-branches/create';
        };

        window.addNewCourt = function() {
            const courtDropdown = document.getElementById('courtDropdown');
            if (courtDropdown) {
                courtDropdown.classList.remove('show');
            }
            window.location.href = '/courts/create';
        };

        // Handle status checkbox change
        function handleStatusCheckboxChange() {
            console.log('Status checkbox changed:', this.checked);
            const statusCheckbox = this;
            const transferCheckboxVisible = document.getElementById('transfer_checkbox_visible');

            if (!this.checked) {
                // Show confirmation when unchecking (marking as disposal)
                Swal.fire({
                    title: 'Confirm Case Disposal',
                    html: '<p style="font-size: 15px;">Are you sure this case is finished?</p><p style="color: #666; font-size: 13px;">Once a case is marked as disposed, it will no longer be considered as an active case and cannot be reversed.</p>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Mark as Disposed',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Keep the checkbox unchecked (disposal)
                        // Disable transfer checkbox for disposed cases
                        if (transferCheckboxVisible) {
                            transferCheckboxVisible.disabled = true;
                            transferCheckboxVisible.checked = false;
                        }
                        const transferCheckbox = document.getElementById('transfer_checkbox');
                        if (transferCheckbox) {
                            transferCheckbox.checked = false;
                        }

                        Swal.fire({
                            title: 'Case Disposed',
                            text: 'This case has been marked as disposed. Case transfer option has been disabled.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        // Revert the checkbox back to checked
                        statusCheckbox.checked = true;
                    }
                });
            } else {
                // When checking (marking as running), enable transfer checkbox
                if (transferCheckboxVisible) {
                    transferCheckboxVisible.disabled = false;
                    console.log('Transfer checkbox enabled (running case)');
                }
            }
        }

        // Handle transfer checkbox change
        function handleTransferCheckboxChange() {
            console.log('Transfer checkbox changed:', this.checked);
            const transferCheckboxVisible = this;

            if (this.checked) {
                // Show confirmation when transfer is being enabled
                Swal.fire({
                    title: 'Confirm Case Transfer',
                    html: '<p style="font-size: 15px;">Are you sure you want to transfer this case to another court?</p><p style="color: #666; font-size: 13px;">This action will mark the case as transferred.</p>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Transfer it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enable transfer
                        const transferCheckbox = document.getElementById('transfer_checkbox');
                        if (transferCheckbox) {
                            transferCheckbox.checked = true;
                        }
                        Swal.fire({
                            title: 'Transfer Confirmed',
                            text: 'This case will be transferred upon update.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        // Revert the checkbox
                        transferCheckboxVisible.checked = false;
                        const transferCheckbox = document.getElementById('transfer_checkbox');
                        if (transferCheckbox) {
                            transferCheckbox.checked = false;
                        }
                    }
                });
            } else {
                const transferCheckbox = document.getElementById('transfer_checkbox');
                if (transferCheckbox) {
                    transferCheckbox.checked = false;
                }
            }
        }

        // Handle save button click
        function handleSaveButtonClick(event) {
            event.preventDefault();
            console.log('Save button clicked');

            Swal.fire({
                title: "Update Case Information",
                html: '<p style="font-size: 15px;">Do you want to save the changes to this case?</p>',
                icon: "question",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes, Update it!",
                denyButtonText: `Don't Update`,
                confirmButtonColor: '#3085d6',
                denyButtonColor: '#6b7280',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Trigger form submit event (not direct submit)
                    const form = document.getElementById('updateCaseForm');
                    if (form) {
                        // Create and dispatch a submit event that will be caught by the AJAX handler
                        const submitEvent = new Event('submit', {
                            bubbles: true,
                            cancelable: true
                        });
                        form.dispatchEvent(submitEvent);
                    }
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
