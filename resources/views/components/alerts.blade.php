@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="alert-heading mb-3">
                    <i class="fas fa-exclamation-circle"></i> Validation Errors
                </h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li class="mb-2">
                            <strong>{{ $error }}</strong>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="alert-heading">
                    <i class="fas fa-check-circle"></i> Success
                </h5>
                <p class="mb-0">{{ $message }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="alert-heading">
                    <i class="fas fa-times-circle"></i> Error
                </h5>
                <p class="mb-0">{{ $message }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="alert-heading">
                    <i class="fas fa-exclamation-triangle"></i> Warning
                </h5>
                <p class="mb-0">{{ $message }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="alert-heading">
                    <i class="fas fa-info-circle"></i> Info
                </h5>
                <p class="mb-0">{{ $message }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

<style>
    .alert {
        border-left: 5px solid;
        border-radius: 0.5rem;
        animation: slideIn 0.3s ease-in-out;
    }

    .alert-danger {
        border-left-color: #dc3545;
        background-color: #f8d7da;
        color: #721c24;
    }

    .alert-success {
        border-left-color: #28a745;
        background-color: #d4edda;
        color: #155724;
    }

    .alert-warning {
        border-left-color: #ffc107;
        background-color: #fff3cd;
        color: #856404;
    }

    .alert-info {
        border-left-color: #17a2b8;
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .alert h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .alert ul {
        padding-left: 1.5rem;
        list-style-type: none;
    }

    .alert ul li:before {
        content: "✓ ";
        font-weight: bold;
        margin-right: 0.5rem;
    }

    .alert-danger ul li:before {
        content: "✗ ";
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .alert {
            font-size: 0.9rem;
        }

        .alert h5 {
            font-size: 1rem;
        }
    }
</style>
