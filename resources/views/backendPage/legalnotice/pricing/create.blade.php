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
                            <li class="breadcrumb-item">
                                <a href="{{ route('legalnotice.pricing.index') }}"
                                    class="text-decoration-none text-dark">
                                    <i class="fas fa-tags"></i> Legal Notice Pricing
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create Pricing
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>
                    Add New Legal Notice Pricing
                </h4>
            </div>
            <div class="card-body">
                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Validation Errors
                        </h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('legalnotice.pricing.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <!-- Client Selection with Search -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Client Name <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <select name="client_id" class="form-select @error('client_id') is-invalid @enderror"
                                    id="clientSelect" style="display: none;" required>
                                    <option value="">-- Select Client --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="dropdown">
                                    <input type="text"
                                        class="form-control rounded @error('client_id') is-invalid @enderror"
                                        id="clientSearch" placeholder="Search or select client..."
                                        data-bs-toggle="dropdown" autocomplete="off"
                                        value="{{ old('client_id') ? $clients->where('id', old('client_id'))->first()->name ?? '' : '' }}">

                                    <div class="dropdown-menu w-100 p-2 shadow-lg" id="clientDropdown">
                                        <input type="text" class="form-control rounded form-control-sm mb-2"
                                            id="clientSearchInput" placeholder="Type to search...">
                                        <div class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($clients as $client)
                                                <button type="button"
                                                    class="list-group-item list-group-item-action client-option"
                                                    data-value="{{ $client->id }}" data-name="{{ $client->name }}">
                                                    {{ $client->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('client_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category Selection with Search -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Section <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <select name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" id="categorySelect"
                                    style="display: none;" required>
                                    <option value="">-- Select Section --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="dropdown">
                                    <input type="text"
                                        class="form-control rounded @error('category_id') is-invalid @enderror"
                                        id="categorySearch" placeholder="Search or select section..."
                                        data-bs-toggle="dropdown" autocomplete="off"
                                        value="{{ old('category_id') ? $categories->where('id', old('category_id'))->first()->name ?? '' : '' }}">

                                    <div class="dropdown-menu w-100 p-2 shadow-lg" id="categoryDropdown">
                                        <input type="text" class="form-control rounded form-control-sm mb-2"
                                            id="categorySearchInput" placeholder="Type to search...">
                                        <div class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($categories as $category)
                                                <button type="button"
                                                    class="list-group-item list-group-item-action category-option"
                                                    data-value="{{ $category->id }}"
                                                    data-name="{{ $category->name }}">
                                                    {{ $category->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price Input -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Price (Tk.) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" name="price"
                                    class="form-control rounded form-control-sm @error('price') is-invalid @enderror"
                                    placeholder="0.00" step="0.01" min="0" value="{{ old('price') }}"
                                    required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>
                            Create Pricing
                        </button>
                        <a href="{{ route('legalnotice.pricing.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Cancel
                        </a>
                    </div>
                </form>
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

                clientSearchInput.addEventListener('input', function() {
                    const term = this.value.toLowerCase().trim();
                    clientOptions.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(term) ? 'block' : 'none';
                    });
                });

                clientOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        const name = this.getAttribute('data-name');

                        clientSearch.value = name;
                        clientSelect.value = value;
                        clientDropdown.hide();
                    });
                });

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

                categorySearchInput.addEventListener('input', function() {
                    const term = this.value.toLowerCase().trim();
                    categoryOptions.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(term) ? 'block' : 'none';
                    });
                });

                categoryOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        const name = this.getAttribute('data-name');

                        categorySearch.value = name;
                        categorySelect.value = value;
                        categoryDropdown.hide();
                    });
                });

                categorySearch.addEventListener('shown.bs.dropdown', function() {
                    setTimeout(() => {
                        categorySearchInput.focus();
                    }, 100);
                });
            }
        }
    </script>
</x-app-layout>
