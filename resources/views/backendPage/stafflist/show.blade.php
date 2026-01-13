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
                            Staff Information
                            </li>
                        </ol>
                    </nav>
                      <a href="{{ route('stafflist.index') }}" class="btn btn-primary addBtn">
                        Back to list
                    </a>
                </div>
            </div>
        </div>

      <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="row g-0 align-items-center">
            <!-- Profile Image -->
            <div class="col-md-4 text-center bg-light p-4">
                <img src="{{ asset('images/' . $stafflist->image) }}" 
                    alt="{{ $stafflist->name ?? 'Staff Image' }}"
                    class="img-fluid rounded-3 shadow-sm"
                    style="max-height: 220px; object-fit: cover;">
                <h5 class="mt-3 mb-0 fw-bold">{{ $stafflist->possition }}</h5>
                <span class="badge {{ $stafflist->status == 1 ? 'bg-success' : 'bg-danger' }} mt-2">
                    {{ $stafflist->status == 1 ? 'Visible' : 'Hidden' }}
                </span>
            </div>

            <!-- Staff Information -->
            <div class="col-md-8 p-4">
                <h3 class="fw-semibold text-primary mb-3">{{ $stafflist->name ?? 'Staff Details' }}</h3>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <p class="mb-1 fw-bold text-muted">📞 Mobile Number:</p>
                        <p class="mb-3">{{ $stafflist->number }}</p>
                    </div>

                    <div class="col-sm-6">
                        <p class="mb-1 fw-bold text-muted">💬 WhatsApp Number:</p>
                        <p class="mb-3">{{ $stafflist->whatsapp }}</p>
                    </div>

                    <div class="col-sm-6">
                        <p class="mb-1 fw-bold text-muted">✉️ Email Address:</p>
                        <p class="mb-3">{{ $stafflist->email }}</p>
                    </div>

                    <div class="col-sm-6">
                        <p class="mb-1 fw-bold text-muted">🎓 Educational Qualifications:</p>
                        <p class="mb-3">{{ $stafflist->qualification }}</p>
                    </div>

                    <div class="col-12">
                        <p class="mb-1 fw-bold text-muted">📍 Address:</p>
                        <p class="mb-0">{{ $stafflist->address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
