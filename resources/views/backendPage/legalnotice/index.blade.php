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
                            Legal Notice List
                            </li>
                        </ol>
                    </nav>
                    <div>
                        <a href="{{ route('legalnotice.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add New
                        </a>

                        <button class="btn btn-secondary" data-bs-toggle="offcanvas"
                            data-bs-target="#filterCanvas">
                            <i class="fa fa-filter"></i> Filter
                        </button>

                        <!-- Export Dropdown -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fa fa-download"></i> Export
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('legalnotice.export.pdf') }}{{ request()->getQueryString() ? '?' . http_build_query(request()->query()) : '' }}">
                                        <i class="fa fa-file-pdf text-danger"></i> PDF
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('legalnotice.export.excel') }}{{ request()->getQueryString() ? '?' . http_build_query(request()->query()) : '' }}">
                                        <i class="fa fa-file-excel text-success"></i> Excel
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>

    <!-- Active Filters Display -->
    @if(request()->anyFilled(['client_id', 'branch_id', 'category_id', 'date_from', 'date_to', 'status']))
    <div class="card border-info mb-3">
        <div class="card-body py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Active Filters:</strong>
                    @if(request('client_id'))
                        <span class="badge bg-primary me-2">Client: {{ $clients->where('id', request('client_id'))->first()->name ?? 'N/A' }}</span>
                    @endif
                    @if(request('branch_id'))
                        <span class="badge bg-primary me-2">Branch: {{ $branches->where('id', request('branch_id'))->first()->name ?? 'N/A' }}</span>
                    @endif
                    @if(request('category_id'))
                        <span class="badge bg-primary me-2">Category: {{ $categories->where('id', request('category_id'))->first()->name ?? 'N/A' }}</span>
                    @endif
                    @if(request('date_from'))
                        <span class="badge bg-info me-2">From: {{ request('date_from') }}</span>
                    @endif
                    @if(request('date_to'))
                        <span class="badge bg-info me-2">To: {{ request('date_to') }}</span>
                    @endif
                    @if(request('status'))
                        <span class="badge bg-warning me-2">Status: {{ request('status') }}</span>
                    @endif
                </div>
                <a href="{{ route('legalnotice.index') }}" class="btn btn-sm btn-outline-danger">
                    <i class="fa fa-times"></i> Clear All
                </a>
            </div>
        </div>
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
                            <th>Date</th>
                            <th>On Behalf Of</th>
                            <th>Branch</th>
                            <th>Loan A/C OR Member OR CIN</th>
                            <th>Section</th>
                            <th>Name Of Acquest</th>
                            <th>Notice Date</th>
                            <th>Dateline</th>
                            <th>Comments</th>
                            <th>Status</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($legalnotices as $key => $notice)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                     {{ $notice->created_at ? \Carbon\Carbon::parse($notice->created_at)->format('d-M-Y') : '—' }}
                                </td>
                                <td>{{ $notice->client->name ?? '' }}</td>
                                <td>{{ $notice->clientbranch->name ?? 'N/A' }}</td>
                                <td>{{ $notice->loan_account_acquest_cin ?? 'N/A' }}</td>
                                <td>{{ $notice->category->name ?? 'N/A' }}</td>
                                <td>{{ $notice->name }}</td>
                                <td>
                                     {{ $notice->legal_notice_date ? \Carbon\Carbon::parse($notice->legal_notice_date)->format('d-M-Y') : '—' }}
                                </td>
                                <td>
                                      {{ $notice->dateline_for_filing ? \Carbon\Carbon::parse($notice->dateline_for_filing)->format('d-M-Y') : '—' }}
                                </td>
                                <td>{{ Str::limit($notice->comments, 50) }}</td>
                                <td>
                                    <div class="status-container">
                                        <select class="form-select form-select-sm status-select" 
                                            data-id="{{ $notice->id }}" 
                                            style="display: none;">
                                            <option value="Running" {{ $notice->status == 'Running' ? 'selected' : '' }}>Running</option>
                                            <option value="Done" {{ $notice->status == 'Done' ? 'selected' : '' }}>Done</option>
                                            <option value="Reject" {{ $notice->status == 'Reject' ? 'selected' : '' }}>Reject</option>
                                        </select>
                                        
                                        <!-- Custom Status Badge (No Dropdown) -->
                                        <div class="status-badge {{ $notice->status }}-status" data-id="{{ $notice->id }}">
                                            <i class="status-icon {{ $notice->status == 'Running' ? 'fa-solid fa-play' : ($notice->status == 'Done' ? 'fa-solid fa-check' : 'fa-solid fa-xmark') }}"></i>
                                            <span class="status-text">{{ $notice->status }}</span>
                                            <i class="fa-solid fa-chevron-down ms-1 dropdown-arrow"></i>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <button class="btn btn-info btn-sm show-btn"
                                        data-id="{{ $notice->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#showModal">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button class="btn btn-warning btn-sm edit-btn"
                                        data-id="{{ $notice->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger btn-sm delete-btn"
                                        data-id="{{ $notice->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <form id="delete-form-{{ $notice->id }}"
                                        action="{{ route('legalnotice.destroy', $notice->id) }}"
                                        method="POST">
                                        @csrf 
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted">
                                    No legal notices found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $legalnotices->links('pagination::bootstrap-5') }}
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
                    <div class="status-option running-option" data-status="Running">
                        <div class="status-indicator running-indicator"></div>
                        <i class="fa-solid fa-play status-option-icon"></i>
                        <span class="status-option-text">Running</span>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="showModalLabel">Legal Notice Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Client Name</label>
                        <p id="show_client_name" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Branch</label>
                        <p id="show_branch" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Loan A/C / Acquest CIN</label>
                        <p id="show_loan_account_acquest_cin" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Category</label>
                        <p id="show_category_name" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Legal Notice Date</label>
                        <p id="show_legal_notice_date" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Name</label>
                        <p id="show_name" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Dateline for Filing</label>
                        <p id="show_dateline_for_filing" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <p id="show_status" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Comments</label>
                        <p id="show_comments" class="form-control-plaintext"></p>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Legal Notice</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Client with Searchable Dropdown -->
                        <div class="col-md-6">
                            <label class="form-label">Client Name</label>
                            <div class="position-relative">
                                <select name="client_id" class="form-select" id="edit_client_id" style="display: none;" required>
                                    <option value="">Select Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                
                                <div class="dropdown">
                                    <input type="text" class="form-control" id="edit_client_search" 
                                        placeholder="Search or select client..." 
                                        data-bs-toggle="dropdown">
                                    
                                    <div class="dropdown-menu shadow-lg w-100 p-2" id="editClientDropdown">
                                        <input type="text" class="form-control rounded form-control-sm mb-2" 
                                            id="edit_client_search_input" placeholder="Type to search...">
                                        <div class="list-group list-group-flush" style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($clients as $client)
                                                <button type="button" class="list-group-item list-group-item-action edit-client-option" 
                                                    data-value="{{ $client->id }}" 
                                                    data-name="{{ $client->name }}">
                                                    {{ $client->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                          <!-- Branch with Searchable Dropdown -->
                        <div class="col-md-6">
                            <label class="form-label">Branch</label>
                            <div class="position-relative">
                                <select name="branch_id" class="form-select" id="edit_branch_id" style="display: none;">
                                    <option value="">Select Branch (Optional)</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                
                                <div class="dropdown">
                                    <input type="text" class="form-control" id="edit_branch_search" 
                                        placeholder="Search or select branch..." 
                                        data-bs-toggle="dropdown">
                                    
                                    <div class="dropdown-menu w-100 shadow p-2" id="editBranchDropdown">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <input type="text" class="form-control rounded form-control-sm" 
                                                id="edit_branch_search_input" placeholder="Type to search...">
                                            <button type="button" class="btn btn-outline-secondary btn-sm ms-2" id="edit_clear_branch_btn" title="Clear Branch">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="list-group list-group-flush" style="max-height: 200px; overflow-y: auto;">
                                            <button type="button" class="list-group-item list-group-item-action edit-branch-option" data-value="">
                                                -- No Branch --
                                            </button>
                                           @foreach ($branches as $branch)
                                                <button type="button" 
                                                    class="list-group-item list-group-item-action edit-branch-option"
                                                    data-value="{{ $branch->id }}"
                                                    data-name="{{ $branch->name }}"
                                                    data-client-id="{{ $branch->client_id }}">
                                                    {{ $branch->name }}
                                                </button>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                          <!-- loan_account_acquest_cin -->
                        <div class="col-md-6">
                            <label class="form-label">Loan A/C / Acquest CIN</label>
                            <input type="text" name="loan_account_acquest_cin" class="form-control rounded" id="edit_loan_account_acquest_cin">
                        </div>

                        <!-- Category with Searchable Dropdown -->
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <div class="position-relative">
                                <select name="notice_category_id" class="form-select" id="edit_category_id" style="display: none;" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                
                                <div class="dropdown">
                                    <input type="text" class="form-control" id="edit_category_search" 
                                        placeholder="Search or select category..." 
                                        data-bs-toggle="dropdown">
                                    
                                    <div class="dropdown-menu w-100 shadow p-2" id="editCategoryDropdown">
                                        <input type="text" class="form-control rounded form-control-sm mb-2" 
                                            id="edit_category_search_input" placeholder="Type to search...">
                                        <div class="list-group list-group-flush" style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($categories as $category)
                                                <button type="button" class="list-group-item list-group-item-action edit-category-option" 
                                                    data-value="{{ $category->id }}" 
                                                    data-name="{{ $category->name }}">
                                                    {{ $category->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Legal Notice Date -->
                        <div class="col-md-6">
                            <label class="form-label">Legal Notice Date</label>
                            <input type="date" name="legal_notice_date" class="form-control rounded" id="edit_legal_notice_date" required>
                        </div>

                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control rounded" id="edit_name" required>
                        </div>

                        <!-- Dateline for Filing -->
                        <div class="col-md-6">
                            <label class="form-label">Dateline for Filing</label>
                            <input type="date" name="dateline_for_filing" class="form-control rounded" id="edit_dateline_for_filing">
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" id="edit_status" required>
                                <option value="Running">Running</option>
                                <option value="Done">Done</option>
                                <option value="Reject">Reject</option>
                            </select>
                        </div>

                        <!-- Comments -->
                        <div class="col-12">
                            <label class="form-label">Comments</label>
                            <textarea name="comments" class="form-control" id="edit_comments" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Legal Notice</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================
     OFFCANVAS FILTER SECTION
============================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filterCanvas">
    <div class="offcanvas-header bg-dark text-white">
        <h5 class="offcanvas-title">Filter Legal Notices</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form action="{{ route('legalnotice.index') }}" method="GET" id="filterForm">
           <div class="mb-3">
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
                            placeholder="Search or select client..." 
                            data-bs-toggle="dropdown" 
                            value="{{ request('client_id') ? $clients->where('id', request('client_id'))->first()->name ?? '' : '' }}">
                        
                        <div class="dropdown-menu w-100 p-2 shadow-lg" id="clientDropdown">
                            <input type="text" class="form-control rounded form-control-sm mb-2" 
                                id="clientSearchInput" placeholder="Type to search...">
                            <div class="list-group list-group-flush" style="max-height: 200px; overflow-y: auto;">
                                <button type="button" class="list-group-item list-group-item-action client-option" data-value="">
                                    -- All Clients --
                                </button>
                                @foreach ($clients as $client)
                                    <button type="button" class="list-group-item list-group-item-action client-option" 
                                        data-value="{{ $client->id }}" 
                                        data-name="{{ $client->name }}"
                                        {{ request('client_id') == $client->id ? 'data-selected="true"' : '' }}>
                                        {{ $client->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branch Dropdown with Search -->
            <div class="mb-3">
                <label class="form-label">Branch</label>
                <div class="position-relative">
                    <select name="branch_id" class="form-select" id="branchSelect" style="display:none;">
                        <option value="">-- All Branches --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" 
                                {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="dropdown">
                        <input type="text" class="form-control rounded" id="branchSearch"
                            placeholder="Search or select branch..."
                            data-bs-toggle="dropdown"
                            value="{{ request('branch_id') ? $branches->where('id', request('branch_id'))->first()->name ?? '' : '' }}">

                        <div class="dropdown-menu w-100 p-2 shadow-lg" id="branchDropdown">
                            <input type="text" class="form-control rounded form-control-sm mb-2"
                                id="branchSearchInput" placeholder="Type to search...">

                            <div class="list-group list-group-flush" style="max-height:200px; overflow-y:auto;">
                                <button type="button" class="list-group-item list-group-item-action branch-option" 
                                    data-value="">
                                    -- All Branches --
                                </button>

                                @foreach($branches as $branch)
                                    <button type="button" 
                                        class="list-group-item list-group-item-action branch-option"
                                        data-value="{{ $branch->id }}"
                                        data-name="{{ $branch->name }}"
                                        data-client-id="{{ $branch->client_id }}"
                                        {{ request('branch_id') == $branch->id ? 'data-selected="true"' : '' }}>
                                        {{ $branch->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Account / ACQUEST / CIN -->
            <div class="mb-3">
                <label class="form-label">Loan A/C - ACQUEST - CIN</label>
                <input type="text" name="loan_account_acquest_cin" class="form-control rounded"
                    placeholder="Enter A/C or CIN..."
                    value="{{ request('loan_account_acquest_cin') }}">
            </div>

           <!-- Category Dropdown -->
            <div class="mb-3">
                <label class="form-label">Category</label>
                <div class="position-relative">
                    <select name="category_id" class="form-select" id="categorySelect" style="display:none;">
                        <option value="">-- All Categories --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="dropdown">
                        <input type="text" class="form-control rounded" id="categorySearch"
                            placeholder="Search or select category..."
                            data-bs-toggle="dropdown"
                            value="{{ request('category_id') ? $categories->where('id', request('category_id'))->first()->name ?? '' : '' }}">

                        <div class="dropdown-menu w-100 p-2 shadow-lg" id="categoryDropdown">
                            <input type="text" class="form-control rounded form-control-sm mb-2"
                                id="categorySearchInput" placeholder="Type to search...">

                            <div class="list-group list-group-flush" style="max-height:200px; overflow-y:auto;">
                                <button type="button" class="list-group-item list-group-item-action category-option" 
                                    data-value="">
                                    -- All Categories --
                                </button>

                                @foreach($categories as $category)
                                    <button type="button" 
                                        class="list-group-item list-group-item-action category-option"
                                        data-value="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        {{ request('category_id') == $category->id ? 'data-selected="true"' : '' }}>
                                        {{ $category->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date Range -->
            <div class="mb-3">
                <label class="form-label">Legal Notice Date (From)</label>
                <input type="date" name="date_from" class="form-control rounded"
                    value="{{ request('date_from') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Legal Notice Date (To)</label>
                <input type="date" name="date_to" class="form-control rounded"
                    value="{{ request('date_to') }}">
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select rounded">
                    <option value="">-- All Status --</option>
                    <option value="Running" {{ request('status') == 'Running' ? 'selected' : '' }}>Running</option>
                    <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                    <option value="Reject" {{ request('status') == 'Reject' ? 'selected' : '' }}>Reject</option>
                </select>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-search"></i> Apply Filter
                </button>
                
                <button type="button" id="resetFilter" class="btn btn-outline-danger">
                    <i class="fa fa-refresh"></i> Reset Filter
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DELETE CONFIRMATION - Fixed
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let id = this.getAttribute('data-id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This legal notice will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Use fetch API for delete
                        fetch(`/legalnotice/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Legal notice deleted successfully.',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to delete notice!'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete notice!'
                            });
                        });
                    }
                });
            });
        });

        // Status Change
        document.querySelectorAll('.status-badge').forEach(badge => {
            badge.addEventListener('click', function() {
                const noticeId = this.getAttribute('data-id');
                const currentStatus = this.classList[1].replace('-status', '');
                
                // Store current notice ID for modal
                document.getElementById('statusModal').setAttribute('data-notice-id', noticeId);
                document.getElementById('statusModal').setAttribute('data-current-status', currentStatus);
                
                // Show modal
                const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
                statusModal.show();
            });
        });

        // Status Option Selection
        document.querySelectorAll('.status-option').forEach(option => {
            option.addEventListener('click', function() {
                const newStatus = this.getAttribute('data-status');
                const modal = document.getElementById('statusModal');
                const noticeId = modal.getAttribute('data-notice-id');
                const currentStatus = modal.getAttribute('data-current-status');
                
                // Update via AJAX
                fetch(`/legalnotice/${noticeId}/status`, {
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
                        const badge = document.querySelector(`.status-badge[data-id="${noticeId}"]`);
                        badge.className = `status-badge ${newStatus}-status`;
                        
                        const iconClass = newStatus == 'Running' ? 'fa-solid fa-play' : 
                                        newStatus == 'Done' ? 'fa-solid fa-check' : 'fa-solid fa-xmark';
                        badge.innerHTML = `<i class="status-icon ${iconClass}"></i>
                                        <span class="status-text">${newStatus}</span>
                                        <i class="fa-solid fa-chevron-down ms-1 dropdown-arrow"></i>`;
                        
                        // Update hidden select
                        const statusSelect = badge.closest('.status-container').querySelector('.status-select');
                        statusSelect.value = newStatus;
                        
                        // Hide modal
                        bootstrap.Modal.getInstance(modal).hide();
                        
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
            const noticeId = button.getAttribute('data-id');
            
            fetch(`/legalnotice/${noticeId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notice = data.notice;
                        
                        // Populate show modal fields
                        document.getElementById('show_client_name').textContent = notice.client?.name || 'N/A';
                        document.getElementById('show_branch').textContent = notice.branch?.name || 'N/A';
                        document.getElementById('show_loan_account_acquest_cin').textContent = notice.loan_account_acquest_cin || 'N/A';
                        document.getElementById('show_category_name').textContent = notice.category?.name || 'N/A';
                        document.getElementById('show_legal_notice_date').textContent = notice.legal_notice_date;
                        document.getElementById('show_name').textContent = notice.name;
                        document.getElementById('show_dateline_for_filing').textContent = notice.dateline_for_filing || 'N/A';
                        document.getElementById('show_status').textContent = notice.status;
                        document.getElementById('show_comments').textContent = notice.comments || 'N/A';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load notice data!'
                    });
                });
        });

        // Edit Modal - FIXED VERSION
        const editModal = document.getElementById('editModal');
        const editForm = document.getElementById('editForm');
        
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const noticeId = button.getAttribute('data-id');
            
            console.log('Edit modal opening for notice ID:', noticeId);
            
            // Fetch notice data
            fetch(`/legalnotice/${noticeId}/edit`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Edit data received:', data);
                    
                    if (data.success && data.notice) {
                        const notice = data.notice;
                        
                        // Populate form fields - DEBUGGING
                        console.log('Populating form with:', {
                            client_id: notice.client_id,
                            client_name: notice.client?.name,
                            branch_id: notice.branch_id,
                            branch_name: notice.branch?.name,
                            category_id: notice.notice_category_id,
                            category_name: notice.category?.name,
                            loan_account: notice.loan_account_acquest_cin,
                            legal_date: notice.legal_notice_date,
                            name: notice.name,
                            dateline: notice.dateline_for_filing,
                            status: notice.status,
                            comments: notice.comments
                        });
                        
                        // Client
                        document.getElementById('edit_client_search').value = notice.client?.name || '';
                        document.getElementById('edit_client_id').value = notice.client_id || '';

                        // Branch
                        document.getElementById('edit_branch_search').value = notice.clientbranch?.name || '';
                        document.getElementById('edit_branch_id').value = notice.branch_id || '';
                        
                        // Loan Account
                        document.getElementById('edit_loan_account_acquest_cin').value = notice.loan_account_acquest_cin || '';
                        
                        // Category
                        document.getElementById('edit_category_search').value = notice.category?.name || '';
                        document.getElementById('edit_category_id').value = notice.notice_category_id || '';
                        
                        // Other fields
                        document.getElementById('edit_legal_notice_date').value = notice.legal_notice_date || '';
                        document.getElementById('edit_name').value = notice.name || '';
                        document.getElementById('edit_dateline_for_filing').value = notice.dateline_for_filing || '';
                        document.getElementById('edit_status').value = notice.status || 'Running';
                        document.getElementById('edit_comments').value = notice.comments || '';
                        
                        // Update form action
                        editForm.action = `/legalnotice/${noticeId}`;
                        
                        console.log('Form populated successfully');
                    } else {
                        console.error('No notice data found:', data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'No notice data found!'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching edit data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load notice data for editing!'
                    });
                });
        });

        // Edit Form Submit - FIXED VERSION
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const noticeId = this.action.split('/').pop();
            
            console.log('Submitting form for notice ID:', noticeId);
            console.log('Form data:', Object.fromEntries(formData));
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT'
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
                console.log('Update response:', data);
                if (data.success) {
                    // Hide modal first
                    const modal = bootstrap.Modal.getInstance(editModal);
                    modal.hide();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'Legal notice updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Reload page after success
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Update failed');
                }
            })
            .catch(error => {
                console.error('Error updating notice:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message || 'Failed to update notice!'
                });
            });
        });

        // Filter Reset
        document.getElementById('resetFilter').addEventListener('click', function() {
            document.getElementById('filterForm').reset();
            document.getElementById('clientSearch').value = '';
            document.getElementById('branchSearch').value = '';
            document.getElementById('categorySearch').value = '';
            document.getElementById('clientSelect').value = '';
            document.getElementById('branchSelect').value = '';
            document.getElementById('categorySelect').value = '';
            window.location.href = "{{ route('legalnotice.index') }}";
        });

        // Initialize all dropdown functionality
        initializeDropdowns();
        initializeEditDropdowns();
    });

   

    function initializeEditDropdowns() {
        // Edit Client Dropdown
        const editClientSearch = document.getElementById('edit_client_search');
        const editClientSearchInput = document.getElementById('edit_client_search_input');
        const editClientOptions = document.querySelectorAll('.edit-client-option');
        const editClientSelect = document.getElementById('edit_client_id');

        if (editClientSearch) {
            const editClientDropdown = new bootstrap.Dropdown(editClientSearch);
            
            editClientSearchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                editClientOptions.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(term) ? 'block' : 'none';
                });
            });

           // Edit Client Dropdown
            editClientOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const name = this.getAttribute('data-name') || this.textContent;

                    editClientSearch.value = name;
                    editClientSelect.value = value;
                    editClientDropdown.hide();

                    // ⭐ FILTER BRANCHES FOR THIS CLIENT ⭐
                    filterEditBranchesByClient(value);
                });
            });


            editClientSearch.addEventListener('shown.bs.dropdown', function() {
                setTimeout(() => {
                    editClientSearchInput.focus();
                }, 100);
            });
        }

        // Edit Branch Dropdown
        const editBranchSearch = document.getElementById('edit_branch_search');
        const editBranchSearchInput = document.getElementById('edit_branch_search_input');
        const editBranchOptions = document.querySelectorAll('.edit-branch-option');
        const editBranchSelect = document.getElementById('edit_branch_id');
        const editClearBranchBtn = document.getElementById('edit_clear_branch_btn');

        if (editBranchSearch) {
            const editBranchDropdown = new bootstrap.Dropdown(editBranchSearch);
            
            editBranchSearchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                editBranchOptions.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(term) ? 'block' : 'none';
                });
            });

            editBranchOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const name = this.getAttribute('data-name') || this.textContent;
                    
                    editBranchSearch.value = name;
                    editBranchSelect.value = value;
                    editBranchDropdown.hide();
                });
            });

            // Clear branch selection
            if (editClearBranchBtn) {
                editClearBranchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    editBranchSearch.value = '';
                    editBranchSelect.value = '';
                    editBranchDropdown.hide();
                });
            }

            editBranchSearch.addEventListener('shown.bs.dropdown', function() {
                setTimeout(() => {
                    editBranchSearchInput.focus();
                }, 100);
            });
        }

        // Edit Category Dropdown
        const editCategorySearch = document.getElementById('edit_category_search');
        const editCategorySearchInput = document.getElementById('edit_category_search_input');
        const editCategoryOptions = document.querySelectorAll('.edit-category-option');
        const editCategorySelect = document.getElementById('edit_category_id');

        if (editCategorySearch) {
            const editCategoryDropdown = new bootstrap.Dropdown(editCategorySearch);
            
            editCategorySearchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                editCategoryOptions.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(term) ? 'block' : 'none';
                });
            });

            editCategoryOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const name = this.getAttribute('data-name') || this.textContent;
                    
                    editCategorySearch.value = name;
                    editCategorySelect.value = value;
                    editCategoryDropdown.hide();
                });
            });

            editCategorySearch.addEventListener('shown.bs.dropdown', function() {
                setTimeout(() => {
                    editCategorySearchInput.focus();
                }, 100);
            });
        }
    }

    // --- AUTO FILTER BRANCHES BASED ON SELECTED CLIENT (EDIT MODAL) ---
function filterEditBranchesByClient(clientId) {
    const branchOptions = document.querySelectorAll('.edit-branch-option');

    branchOptions.forEach(option => {
        const optionClientId = option.getAttribute('data-client-id');

        if (!clientId || optionClientId === clientId) {
            option.style.display = "block";
        } else {
            option.style.display = "none";
        }
    });

    // Clear previously selected branch
    document.getElementById('edit_branch_search').value = "";
    document.getElementById('edit_branch_id').value = "";
}

</script>
<script>
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
                const name = this.getAttribute('data-name') || this.textContent;
                
                clientSearch.value = name;
                clientSelect.value = value;
                clientDropdown.hide();
                
                // Filter branches when client is selected
                filterBranchesByClient(value);
            });
        });

        clientSearch.addEventListener('shown.bs.dropdown', function() {
            setTimeout(() => {
                clientSearchInput.focus();
                clientSearchInput.value = '';
                // Show all options when dropdown opens
                clientOptions.forEach(option => {
                    option.style.display = 'block';
                });
            }, 100);
        });

        // Clear filter when input is cleared
        clientSearch.addEventListener('input', function() {
            if (!this.value.trim()) {
                clientSelect.value = '';
                // Show all branches when no client selected
                filterBranchesByClient('');
            }
        });
    }

    // Branch Dropdown
    const branchSearch = document.getElementById('branchSearch');
    const branchSearchInput = document.getElementById('branchSearchInput');
    const branchOptions = document.querySelectorAll('.branch-option');
    const branchSelect = document.getElementById('branchSelect');

    if (branchSearch) {
        const branchDropdown = new bootstrap.Dropdown(branchSearch);
        
        branchSearchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();
            const clientId = clientSelect ? clientSelect.value : '';
            
            branchOptions.forEach(option => {
                const text = option.textContent.toLowerCase();
                const branchClientId = option.getAttribute('data-client-id');
                
                // Check if matches search AND belongs to selected client (or no client selected)
                const matchesSearch = text.includes(term);
                const matchesClient = !clientId || !branchClientId || branchClientId === clientId;
                
                option.style.display = (matchesSearch && matchesClient) ? 'block' : 'none';
            });
        });

        branchOptions.forEach(option => {
            option.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                const name = this.getAttribute('data-name') || this.textContent;
                
                branchSearch.value = name;
                branchSelect.value = value;
                branchDropdown.hide();
            });
        });

        branchSearch.addEventListener('shown.bs.dropdown', function() {
            setTimeout(() => {
                branchSearchInput.focus();
                branchSearchInput.value = '';
                // Filter branches when dropdown opens
                filterBranchesByClient(clientSelect ? clientSelect.value : '');
            }, 100);
        });
    }

    // Category Dropdown (unchanged from original)
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
                const name = this.getAttribute('data-name') || this.textContent;
                
                categorySearch.value = name;
                categorySelect.value = value;
                categoryDropdown.hide();
            });
        });

        categorySearch.addEventListener('shown.bs.dropdown', function() {
            setTimeout(() => {
                categorySearchInput.focus();
                categorySearchInput.value = '';
                // Show all options when dropdown opens
                categoryOptions.forEach(option => {
                    option.style.display = 'block';
                });
            }, 100);
        });
    }

    // Function to filter branches by selected client
    function filterBranchesByClient(clientId) {
        if (!branchOptions || branchOptions.length === 0) return;
        
        branchOptions.forEach(option => {
            const branchClientId = option.getAttribute('data-client-id');
            
            // If no client selected, show all branches
            if (!clientId) {
                option.style.display = 'block';
                return;
            }
            
            // Show only branches belonging to selected client
            if (branchClientId === clientId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
        
        // Clear branch selection if it doesn't belong to selected client
        const selectedBranchId = branchSelect ? branchSelect.value : '';
        if (selectedBranchId && clientId) {
            const selectedBranch = Array.from(branchOptions).find(
                option => option.getAttribute('data-value') === selectedBranchId
            );
            
            if (selectedBranch && selectedBranch.getAttribute('data-client-id') !== clientId) {
                if (branchSearch) branchSearch.value = '';
                if (branchSelect) branchSelect.value = '';
            }
        }
        
        // Clear branch search input
        if (branchSearchInput) {
            branchSearchInput.value = '';
        }
    }
    
    // Initialize branches filter on page load if client is pre-selected
    if (clientSelect && clientSelect.value) {
        filterBranchesByClient(clientSelect.value);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeDropdowns();
});
</script>
</x-app-layout>