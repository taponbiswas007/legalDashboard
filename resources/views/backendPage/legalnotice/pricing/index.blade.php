<x-app-layout>
    <div class="py-4 px-1 body_area">
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
                                Legal Notice Pricing
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0 mb-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-tags me-2"></i>
                    Manage Legal Notice Pricing
                </h4>
                <a href="{{ route('legalnotice.pricing.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Add New Pricing
                </a>
            </div>
            <div class="card-body">
                <!-- Display Messages -->
                @if ($message = session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($message = session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter Form -->
                <form method="GET" action="{{ route('legalnotice.pricing.index') }}" class="mb-4">
                    <div class="row g-3">
                        <!-- Client Dropdown with Search -->
                        <div class="col-md-3">
                            <label class="form-label">Client Name</label>
                            <div class="position-relative">
                                <select name="client_id" class="form-select" id="clientSelect" style="display: none;">
                                    <option value="">-- All Clients --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="dropdown">
                                    <input type="text" class="form-control rounded" id="clientSearch"
                                        placeholder="Search or select client..." data-bs-toggle="dropdown"
                                        value="{{ request('client_id') ? $clients->where('id', request('client_id'))->first()->name ?? '' : '' }}">

                                    <div class="dropdown-menu w-100 p-2 shadow-lg" id="clientDropdown">
                                        <input type="text" class="form-control rounded form-control-sm mb-2"
                                            id="clientSearchInput" placeholder="Type to search...">
                                        <div class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;">
                                            <button type="button"
                                                class="list-group-item list-group-item-action client-option"
                                                data-value="">
                                                -- All Clients --
                                            </button>
                                            @foreach ($clients as $client)
                                                <button type="button"
                                                    class="list-group-item list-group-item-action client-option"
                                                    data-value="{{ $client->id }}" data-name="{{ $client->name }}"
                                                    {{ request('client_id') == $client->id ? 'data-selected="true"' : '' }}>
                                                    {{ $client->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Dropdown with Search -->
                        <div class="col-md-3">
                            <label class="form-label">Section</label>
                            <div class="position-relative">
                                <select name="category_id" class="form-select" id="categorySelect"
                                    style="display: none;">
                                    <option value="">-- All Sections --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="dropdown">
                                    <input type="text" class="form-control rounded" id="categorySearch"
                                        placeholder="Search or select section..." data-bs-toggle="dropdown"
                                        value="{{ request('category_id') ? $categories->where('id', request('category_id'))->first()->name ?? '' : '' }}">

                                    <div class="dropdown-menu w-100 p-2 shadow-lg" id="categoryDropdown">
                                        <input type="text" class="form-control rounded form-control-sm mb-2"
                                            id="categorySearchInput" placeholder="Type to search...">
                                        <div class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;">
                                            <button type="button"
                                                class="list-group-item list-group-item-action category-option"
                                                data-value="">
                                                -- All Sections --
                                            </button>
                                            @foreach ($categories as $category)
                                                <button type="button"
                                                    class="list-group-item list-group-item-action category-option"
                                                    data-value="{{ $category->id }}" data-name="{{ $category->name }}"
                                                    {{ request('category_id') == $category->id ? 'data-selected="true"' : '' }}>
                                                    {{ $category->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search Price</label>
                            <input type="text" name="search" class="form-control rounded form-control-sm"
                                placeholder="Search..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="{{ route('legalnotice.pricing.index') }}" class="btn btn-secondary">
                                <i class="fas fa-refresh me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Pricing Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Client Name</th>
                                <th>Section</th>
                                <th width="150">Price (Tk.)</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pricings as $index => $pricing)
                                <tr>
                                    <td class="text-center">
                                        {{ ($pricings->currentPage() - 1) * $pricings->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <strong>{{ $pricing->client?->name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $pricing->category?->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-start">
                                        <span class="badge bg-success">
                                            ৳ {{ number_format($pricing->price, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm text-nowrap" role="group">
                                            <a href="{{ route('legalnotice.pricing.edit', $pricing->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST"
                                                action="{{ route('legalnotice.pricing.destroy', $pricing->id) }}"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger delete-btn"
                                                    data-client="{{ $pricing->client?->name ?? 'N/A' }}"
                                                    data-category="{{ $pricing->category?->name ?? 'N/A' }}"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Pricing Found</h5>
                                            <p class="text-muted">Create a new pricing to get started.</p>
                                            <a href="{{ route('legalnotice.pricing.create') }}"
                                                class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i> Add New Pricing
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($pricings->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $pricings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeDropdowns();
        });

        function initializeDropdowns() {
            // Client Dropdown
            const clientSearch = document.getElementById('clientSearch');
            const clientSearchInput = document.getElementById('clientSearchInput');
            const clientOptions = document.querySelectorAll('.client-option');
            const clientSelect = document.getElementById('clientSelect');

            if (clientSearch) {
                const clientDropdown = new bootstrap.Dropdown(clientSearch);

                // Filter on search input
                clientSearchInput.addEventListener('input', function() {
                    const term = this.value.toLowerCase().trim();
                    clientOptions.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(term) ? 'block' : 'none';
                    });
                });

                // Select option on click
                clientOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        const name = this.getAttribute('data-name') || this.textContent.trim();

                        clientSearch.value = name;
                        clientSelect.value = value;
                        clientDropdown.hide();
                    });
                });

                // Focus search input when dropdown opens
                clientSearch.addEventListener('shown.bs.dropdown', function() {
                    setTimeout(() => {
                        clientSearchInput.focus();
                    }, 100);
                });
            }

            // Category Dropdown
            const categorySearch = document.getElementById('categorySearch');
            const categorySearchInput = document.getElementById('categorySearchInput');
            const categoryOptions = document.querySelectorAll('.category-option');
            const categorySelect = document.getElementById('categorySelect');

            if (categorySearch) {
                const categoryDropdown = new bootstrap.Dropdown(categorySearch);

                // Filter on search input
                categorySearchInput.addEventListener('input', function() {
                    const term = this.value.toLowerCase().trim();
                    categoryOptions.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(term) ? 'block' : 'none';
                    });
                });

                // Select option on click
                categoryOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        const name = this.getAttribute('data-name') || this.textContent.trim();

                        categorySearch.value = name;
                        categorySelect.value = value;
                        categoryDropdown.hide();
                    });
                });

                // Focus search input when dropdown opens
                categorySearch.addEventListener('shown.bs.dropdown', function() {
                    setTimeout(() => {
                        categorySearchInput.focus();
                    }, 100);
                });
            }
        }

        // Delete confirmation with SweetAlert
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                const clientName = this.getAttribute('data-client');
                const categoryName = this.getAttribute('data-category');

                Swal.fire({
                    title: 'Are you sure?',
                    html: `You are about to delete pricing for:<br><strong>${clientName}</strong> - <strong>${categoryName}</strong>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
