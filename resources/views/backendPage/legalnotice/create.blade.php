<x-app-layout>
    <div class="py-4 px-1 body_area">

        {{-- Breadcrumb & Back Button --}}
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body d-flex justify-content-between align-items-center gap-2 flex-wrap">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Create Legal Notice
                        </li>
                    </ol>
                </nav>
                <div>
                    <a href="{{ route('legalnotice.index') }}" class="btn btn-primary addBtn me-2">
                        View Legal Notices
                    </a>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-solid fa-file-excel me-1"></i> Import Excel
                    </button>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="card shadow rounded border-0">
            <div class="card-body">
                <form id="legalNoticeForm" action="{{ route('legalnotice.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">

                        {{-- Client --}}
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="form_group position-relative">
                                <label class="select_form_label" for="client_id">On behalf Of</label>
                                <input type="hidden" id="client_id" name="client_id" value="{{ old('client_id') }}">
                                <input type="text" id="client_name" class="form-control"
                                    placeholder="Select or type client" readonly data-bs-toggle="dropdown"
                                    aria-expanded="false" value="{{ old('client_name') }}">

                                <div class="dropdown-menu shadow w-100 p-2" id="clientDropdown">
                                    <input type="text" class="form-control form-control-sm mb-2" id="clientSearch"
                                        placeholder="Search clients...">
                                    <div id="clientList" class="list-group list-group-flush"
                                        style="max-height: 200px; overflow-y:auto;">
                                        @foreach ($clients as $client)
                                            <button type="button"
                                                class="list-group-item list-group-item-action client-item"
                                                data-id="{{ $client->id }}" data-name="{{ $client->name }}">
                                                {{ $client->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="addNewClient()">
                                            <i class="fa-solid fa-user-plus me-1"></i> Add New Client
                                        </button>
                                    </div>
                                </div>
                                @error('client_id')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Branch --}}
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="form_group position-relative">
                                <label class="select_form_label" for="branch_id">Branch</label>
                                <input type="hidden" id="branch_id" name="branch_id" value="{{ old('branch_id') }}">
                                <input type="text" id="branch_name" class="form-control"
                                    placeholder="Select branch (optional)" readonly data-bs-toggle="dropdown"
                                    aria-expanded="false" value="{{ old('branch_name') }}">

                                <div class="dropdown-menu shadow w-100 p-2" id="branchDropdown">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <input type="text" class="form-control form-control-sm" id="branchSearch"
                                            placeholder="Search branches...">
                                        <button type="button" class="btn btn-outline-secondary btn-sm ms-2"
                                            id="clearBranchBtn" title="Clear Branch">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    </div>
                                    <div id="branchList" class="list-group list-group-flush"
                                        style="max-height: 200px; overflow-y:auto;">
                                        @foreach ($branches as $branch)
                                            <button type="button"
                                                class="list-group-item list-group-item-action branch-item"
                                                data-id="{{ $branch->id }}" data-name="{{ $branch->name }}"
                                                data-client-id="{{ $branch->client_id }}">
                                                {{ $branch->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="addNewBranch()">
                                            <i class="fa-solid fa-plus me-1"></i> Add New Branch
                                        </button>
                                    </div>
                                </div>
                                @error('branch_id')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- loan_account_acquest_cin --}}
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="form_group">
                                <input type="text" name="loan_account_acquest_cin" id="loan_account_acquest_cin"
                                    value="{{ old('loan_account_acquest_cin') }}">
                                <label class="form_label">Loan A/C OR Member OR CIN</label>
                                @error('loan_account_acquest_cin')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        {{-- Notice Category --}}
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="form_group position-relative">
                                <label class="select_form_label" for="notice_category_id">Section</label>
                                <input type="hidden" id="notice_category_id" name="notice_category_id"
                                    value="{{ old('notice_category_id') }}">
                                <input type="text" id="category_name" class="form-control"
                                    placeholder="Select or type category" readonly data-bs-toggle="dropdown"
                                    aria-expanded="false" value="{{ old('category_name') }}">

                                <div class="dropdown-menu shadow w-100 p-2" id="categoryDropdown">
                                    <input type="text" class="form-control form-control-sm mb-2"
                                        id="categorySearch" placeholder="Search categories...">
                                    <div id="categoryList" class="list-group list-group-flush"
                                        style="max-height:200px; overflow-y:auto;">
                                        @foreach ($categories as $category)
                                            <button type="button"
                                                class="list-group-item list-group-item-action category-item"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                {{ $category->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="addNewCategory()">
                                            <i class="fa-solid fa-folder-plus me-1"></i> Add New Category
                                        </button>
                                    </div>
                                </div>
                                @error('notice_category_id')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Legal Notice Date --}}
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="form_group">
                                <input type="date" name="legal_notice_date" id="legal_notice_date"
                                    value="{{ old('legal_notice_date') }}">
                                <label class="form_label">Legal Notice Date</label>
                                @error('legal_notice_date')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="form_group">
                                <input type="text" name="name" value="{{ old('name') }}">
                                <label class="form_label">Name Of Acquest</label>
                                @error('name')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Dateline for Filing --}}
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="form_group">
                                <input type="date" name="dateline_for_filing"
                                    value="{{ old('dateline_for_filing') }}">
                                <label class="form_label">Dateline for Filing</label>
                                @error('dateline_for_filing')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Comments --}}
                        <div class="col-12">
                            <div class="form_group">
                                <textarea name="comments" rows="4" class="w-100 rounded" placeholder="Comments">{{ old('comments') }}</textarea>
                                <label class="form_label bg-white" style=" top: -10px;">Comments</label>
                                @error('comments')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="form_group">
                                <label class="form_label bg-white" style=" top: -10px;">Status</label>
                                <select name="status" class="">
                                    <option value="Running" {{ old('status') == 'Running' ? 'selected' : '' }}>Running
                                    </option>
                                    <option value="Done" {{ old('status') == 'Done' ? 'selected' : '' }}>Done
                                    </option>
                                    <option value="Reject" {{ old('status') == 'Reject' ? 'selected' : '' }}>Reject
                                    </option>
                                </select>

                                @error('status')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- Save Button --}}
                    <button type="button" id="saveButton" class="mt-4 btn btn-primary">Save</button>

                </form>

                {{-- Excel Import Modal --}}
                <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="importModalLabel">
                                    <i class="fa-solid fa-file-excel me-2"></i>Import Legal Notices from Excel
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Download Template --}}
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="fa-solid fa-download me-2"></i>Download Excel Template
                                    </h6>
                                    <p class="mb-2">Download the template file and fill in your data:</p>
                                    <a href="{{ route('legalnotice.downloadTemplate') }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-file-arrow-down me-1"></i> Download Template
                                    </a>
                                </div>

                                {{-- Excel Format Instructions --}}
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Excel Format Requirements (Only Data Columns)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning">
                                            <strong>Important:</strong> Client, Branch, and Category/Section are
                                            selected from the form above.
                                            Your Excel file should contain only the data columns listed below.
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="table-warning">
                                                    <tr>
                                                        <th>Column</th>
                                                        <th>Description</th>
                                                        <th>Required</th>
                                                        <th>Example</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Loan A/C, Acquest CIN</strong></td>
                                                        <td>Loan Account or CIN (optional)</td>
                                                        <td>Optional</td>
                                                        <td>LN-12345 / CIN-67890</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Name of Acquest</strong></td>
                                                        <td>Name of the case/acquest</td>
                                                        <td>Required</td>
                                                        <td>John Doe vs ABC Corporation</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Notice Date</strong></td>
                                                        <td>Legal notice date (YYYY-MM-DD)</td>
                                                        <td>Required</td>
                                                        <td>2024-01-15</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Dateline</strong></td>
                                                        <td>Filing deadline (YYYY-MM-DD)</td>
                                                        <td>Optional</td>
                                                        <td>2024-02-15</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Comments</strong></td>
                                                        <td>Additional comments</td>
                                                        <td>Optional</td>
                                                        <td>Case details and remarks</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td>Case status (Running/Done/Reject)</td>
                                                        <td>Optional</td>
                                                        <td>Running / Done / Reject</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="alert alert-info mt-3">
                                            <strong>How it works:</strong>
                                            <ol class="mb-0">
                                                <li>Select the <strong>Client</strong> from the dropdown above</li>
                                                <li>Select the <strong>Branch</strong> (optional) from the dropdown</li>
                                                <li>Select the <strong>Category/Section</strong> from the dropdown</li>
                                                <li>Download the template and fill in the data columns only</li>
                                                <li>Upload your completed Excel file</li>
                                                <li>The system will automatically apply the selected Client, Branch, and
                                                    Category to all imported records</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                {{-- Upload Form --}}
                                <form id="importForm" enctype="multipart/form-data">
                                    @csrf


                                    <!-- Client Selection with Search -->
                                    <div class="mb-3">
                                        <label class="form-label">Select Client</label>
                                        <div class="position-relative">
                                            <select name="client_id" class="form-select rounded"
                                                id="import_client_id" style="display: none;" required>
                                                <option value="">-- Select Client --</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                @endforeach
                                            </select>

                                            <div class="dropdown">
                                                <input type="text" class="form-control rounded"
                                                    id="importClientSearch" placeholder="Search or select client..."
                                                    data-bs-toggle="dropdown" autocomplete="off">

                                                <div class="dropdown-menu w-100 p-2 shadow-lg"
                                                    id="importClientDropdown">
                                                    <input type="text" class="form-control form-control-sm mb-2"
                                                        id="importClientSearchInput" placeholder="Type to search...">
                                                    <div class="list-group list-group-flush"
                                                        style="max-height: 200px; overflow-y: auto;">
                                                        @foreach ($clients as $client)
                                                            <button type="button"
                                                                class="list-group-item list-group-item-action import-client-option"
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

                                    <!-- Branch Selection with Search -->
                                    <div class="mb-3">
                                        <label class="form-label">Select Branch <small class="text-muted">(Optional -
                                                Auto-filtered by Client)</small></label>
                                        <div class="position-relative">
                                            <select name="branch_id" class="form-select rounded"
                                                id="import_branch_id" style="display: none;">
                                                <option value="">-- Select Branch (Optional) --</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}"
                                                        data-client-id="{{ $branch->client_id }}">
                                                        {{ $branch->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="dropdown">
                                                <input type="text" class="form-control rounded"
                                                    id="importBranchSearch"
                                                    placeholder="Search or select branch (optional)..."
                                                    data-bs-toggle="dropdown" autocomplete="off">

                                                <div class="dropdown-menu w-100 p-2 shadow-lg"
                                                    id="importBranchDropdown">
                                                    <input type="text" class="form-control form-control-sm mb-2"
                                                        id="importBranchSearchInput" placeholder="Type to search...">
                                                    <div class="list-group list-group-flush"
                                                        style="max-height: 200px; overflow-y: auto;"
                                                        id="importBranchList">
                                                        @foreach ($branches as $branch)
                                                            <button type="button"
                                                                class="list-group-item list-group-item-action import-branch-option"
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

                                    <!-- Category Selection with Search -->
                                    <div class="mb-3">
                                        <label class="form-label">Select Category/Section</label>
                                        <div class="position-relative">
                                            <select name="notice_category_id" class="form-select rounded"
                                                id="import_category_id" style="display: none;" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="dropdown">
                                                <input type="text" class="form-control rounded"
                                                    id="importCategorySearch"
                                                    placeholder="Search or select category..."
                                                    data-bs-toggle="dropdown" autocomplete="off">

                                                <div class="dropdown-menu w-100 p-2 shadow-lg"
                                                    id="importCategoryDropdown">
                                                    <input type="text" class="form-control form-control-sm mb-2"
                                                        id="importCategorySearchInput"
                                                        placeholder="Type to search...">
                                                    <div class="list-group list-group-flush"
                                                        style="max-height: 200px; overflow-y: auto;">
                                                        @foreach ($categories as $category)
                                                            <button type="button"
                                                                class="list-group-item list-group-item-action import-category-option"
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
                                    <div class="mb-3">
                                        <label for="excel_file" class="form-label">Select Excel File</label>
                                        <input type="file" class="form-control" id="excel_file" name="excel_file"
                                            accept=".xlsx,.xls,.csv" required>
                                        <div class="form-text">Supported formats: .xlsx, .xls, .csv (Max: 10MB)</div>
                                    </div>

                                    <div class="progress mb-3 d-none" id="uploadProgress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" style="width: 0%"></div>
                                    </div>

                                    <div id="importResult" class="d-none"></div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success" id="importButton">
                                    <i class="fa-solid fa-upload me-1"></i> Import Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- JS Scripts --}}
                <script>
                    // SweetAlert Save Confirmation
                    document.getElementById('saveButton').addEventListener('click', function() {
                        Swal.fire({
                            title: "Do you want to save?",
                            icon: "question",
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: "Save",
                            denyButtonText: `Don't save`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('legalNoticeForm').submit();
                            }
                        });
                    });

                    // Initialize dropdowns when DOM is loaded
                    document.addEventListener('DOMContentLoaded', function() {
                        initializeClientDropdown();
                        initializeBranchDropdown();
                        initializeCategoryDropdown();
                        initializeImportClientDropdown();
                        initializeImportBranchDropdown();
                        initializeImportCategoryDropdown();
                        initializeImportFunction();
                    });

                    // Client Dropdown Functions
                    function initializeClientDropdown() {
                        const clientInput = document.getElementById('client_name');
                        const clientSearch = document.getElementById('clientSearch');
                        const clientItems = document.querySelectorAll('.client-item');
                        let clientDropdown = null;

                        // Initialize Bootstrap dropdown
                        if (clientInput) {
                            clientDropdown = new bootstrap.Dropdown(clientInput);
                        }

                        // Search functionality
                        if (clientSearch) {
                            clientSearch.addEventListener('input', function() {
                                const term = this.value.toLowerCase().trim();
                                clientItems.forEach(item => {
                                    const text = item.textContent.toLowerCase();
                                    item.style.display = text.includes(term) ? 'block' : 'none';
                                });
                            });
                        }

                        // Add click event to client items
                        clientItems.forEach(item => {
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                const id = this.getAttribute('data-id');
                                const name = this.getAttribute('data-name');
                                // Use global function if available, fallback to local
                                if (window.selectClient) {
                                    window.selectClient(id, name);
                                } else {
                                    selectClient(id, name);
                                }
                            });
                        });

                        // Focus search when dropdown opens
                        if (clientInput) {
                            clientInput.addEventListener('shown.bs.dropdown', function() {
                                setTimeout(() => {
                                    if (clientSearch) clientSearch.focus();
                                }, 100);
                            });
                        }
                    }

                    function selectClient(id, name) {
                        document.getElementById('client_id').value = id;
                        document.getElementById('client_name').value = name;

                        // Hide dropdown
                        const clientInput = document.getElementById('client_name');
                        const dropdown = bootstrap.Dropdown.getInstance(clientInput);
                        if (dropdown) {
                            dropdown.hide();
                        }

                        // Filter branches based on selected client
                        filterBranchesByClient(id);
                    }

                    function addNewClient() {
                        const clientInput = document.getElementById('client_name');
                        const dropdown = bootstrap.Dropdown.getInstance(clientInput);
                        if (dropdown) {
                            dropdown.hide();
                        }
                        window.location.href = "{{ route('addclient.create') }}";
                    }

                    // Branch Dropdown Functions
                    function initializeBranchDropdown() {
                        const branchInput = document.getElementById('branch_name');
                        const branchSearch = document.getElementById('branchSearch');
                        const clearBranchBtn = document.getElementById('clearBranchBtn');
                        let branchDropdown = null;

                        // Initialize Bootstrap dropdown
                        if (branchInput) {
                            branchDropdown = new bootstrap.Dropdown(branchInput);
                        }

                        // Search functionality
                        if (branchSearch) {
                            branchSearch.addEventListener('input', function() {
                                const term = this.value.toLowerCase().trim();
                                const branchItems = document.querySelectorAll('.branch-item');
                                branchItems.forEach(item => {
                                    // Only search in visible branches
                                    if (item.style.display !== 'none') {
                                        const text = item.textContent.toLowerCase();
                                        if (text.includes(term)) {
                                            item.style.display = 'block';
                                        } else {
                                            item.style.display = 'none';
                                        }
                                    }
                                });
                            });
                        }

                        // Clear branch selection
                        if (clearBranchBtn) {
                            clearBranchBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                clearBranchSelection();
                            });
                        }

                        // Add click event to branch items
                        document.querySelectorAll('.branch-item').forEach(item => {
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                const id = this.getAttribute('data-id');
                                const name = this.getAttribute('data-name');
                                // Use global function if available, fallback to local
                                if (window.selectBranch) {
                                    window.selectBranch(id, name);
                                } else {
                                    selectBranch(id, name);
                                }
                            });
                        });

                        // Focus search when dropdown opens
                        if (branchInput) {
                            branchInput.addEventListener('shown.bs.dropdown', function() {
                                setTimeout(() => {
                                    if (branchSearch) branchSearch.focus();
                                }, 100);
                            });
                        }
                    }

                    // Function to filter branches based on selected client
                    function filterBranchesByClient(clientId) {
                        // Get all branch buttons
                        const branchButtons = document.querySelectorAll('#branchList .branch-item');

                        // First, show all branches if no client is selected
                        if (!clientId) {
                            branchButtons.forEach(button => {
                                button.style.display = 'block';
                            });
                            return;
                        }

                        // Hide all branches first
                        branchButtons.forEach(button => {
                            button.style.display = 'none';
                        });

                        // Show only branches that belong to the selected client
                        const clientBranches = document.querySelectorAll(`#branchList .branch-item[data-client-id="${clientId}"]`);
                        clientBranches.forEach(button => {
                            button.style.display = 'block';
                        });

                        // If no branches found for this client, show a message
                        if (clientBranches.length === 0) {
                            const noBranchMessage = document.createElement('div');
                            noBranchMessage.className = 'list-group-item text-muted text-center';
                            noBranchMessage.textContent = 'No branches found for this client';
                            noBranchMessage.id = 'noBranchMessage';

                            // Remove existing message if any
                            const existingMessage = document.getElementById('noBranchMessage');
                            if (existingMessage) {
                                existingMessage.remove();
                            }

                            document.getElementById('branchList').appendChild(noBranchMessage);
                        } else {
                            // Remove the no branches message if it exists
                            const noBranchMessage = document.getElementById('noBranchMessage');
                            if (noBranchMessage) {
                                noBranchMessage.remove();
                            }
                        }

                        // Clear branch selection when client changes
                        clearBranchSelection();
                    }

                    function selectBranch(id, name) {
                        document.getElementById('branch_id').value = id;
                        document.getElementById('branch_name').value = name;

                        // Hide dropdown
                        const branchInput = document.getElementById('branch_name');
                        const dropdown = bootstrap.Dropdown.getInstance(branchInput);
                        if (dropdown) {
                            dropdown.hide();
                        }
                    }

                    function clearBranchSelection() {
                        document.getElementById('branch_id').value = '';
                        document.getElementById('branch_name').value = '';

                        // Hide dropdown
                        const branchInput = document.getElementById('branch_name');
                        const dropdown = bootstrap.Dropdown.getInstance(branchInput);
                        if (dropdown) {
                            dropdown.hide();
                        }
                    }

                    function addNewBranch() {
                        const branchInput = document.getElementById('branch_name');
                        const dropdown = bootstrap.Dropdown.getInstance(branchInput);
                        if (dropdown) {
                            dropdown.hide();
                        }
                        // You can redirect to branch creation page or show a modal
                        window.location.href = "{{ route('client.branch.page') }}";
                    }

                    // Category Dropdown Functions
                    function initializeCategoryDropdown() {
                        const categoryInput = document.getElementById('category_name');
                        const categorySearch = document.getElementById('categorySearch');
                        const categoryItems = document.querySelectorAll('.category-item');
                        let categoryDropdown = null;

                        // Initialize Bootstrap dropdown
                        if (categoryInput) {
                            categoryDropdown = new bootstrap.Dropdown(categoryInput);
                        }

                        // Search functionality
                        if (categorySearch) {
                            categorySearch.addEventListener('input', function() {
                                const term = this.value.toLowerCase().trim();
                                categoryItems.forEach(item => {
                                    const text = item.textContent.toLowerCase();
                                    item.style.display = text.includes(term) ? 'block' : 'none';
                                });
                            });
                        }

                        // Add click event to category items
                        categoryItems.forEach(item => {
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                const id = this.getAttribute('data-id');
                                const name = this.getAttribute('data-name');
                                selectCategory(id, name);
                            });
                        });

                        // Focus search when dropdown opens
                        if (categoryInput) {
                            categoryInput.addEventListener('shown.bs.dropdown', function() {
                                setTimeout(() => {
                                    if (categorySearch) categorySearch.focus();
                                }, 100);
                            });
                        }
                    }

                    function selectCategory(id, name) {
                        document.getElementById('notice_category_id').value = id;
                        document.getElementById('category_name').value = name;

                        // Hide dropdown
                        const categoryInput = document.getElementById('category_name');
                        const dropdown = bootstrap.Dropdown.getInstance(categoryInput);
                        if (dropdown) {
                            dropdown.hide();
                        }
                    }

                    function addNewCategory() {
                        const categoryInput = document.getElementById('category_name');
                        const dropdown = bootstrap.Dropdown.getInstance(categoryInput);
                        if (dropdown) {
                            dropdown.hide();
                        }
                        window.location.href = "{{ route('legalnoticecategories.create') }}";
                    }

                    // Excel Import Functions
                    function initializeImportFunction() {
                        const importButton = document.getElementById('importButton');
                        const importForm = document.getElementById('importForm');
                        const progressBar = document.getElementById('uploadProgress');
                        const resultDiv = document.getElementById('importResult');

                        importButton.addEventListener('click', function() {
                            const fileInput = document.getElementById('excel_file');
                            const clientId = document.getElementById('import_client_id').value;
                            const categoryId = document.getElementById('import_category_id').value;

                            if (!fileInput.files.length) {
                                Swal.fire('Error', 'Please select an Excel file', 'error');
                                return;
                            }

                            if (!clientId || !categoryId) {
                                Swal.fire('Error', 'Please select both Client and Category', 'error');
                                return;
                            }

                            const formData = new FormData(importForm);

                            // Show progress bar
                            progressBar.classList.remove('d-none');
                            importButton.disabled = true;
                            importButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Importing...';

                            // AJAX request
                            $.ajax({
                                url: '{{ route('legalnotice.import') }}',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                xhr: function() {
                                    const xhr = new window.XMLHttpRequest();
                                    xhr.upload.addEventListener('progress', function(e) {
                                        if (e.lengthComputable) {
                                            const percent = Math.round((e.loaded / e.total) * 100);
                                            progressBar.querySelector('.progress-bar').style.width =
                                                percent + '%';
                                            progressBar.querySelector('.progress-bar').textContent =
                                                percent + '%';
                                        }
                                    });
                                    return xhr;
                                },
                                success: function(response) {
                                    progressBar.classList.add('d-none');
                                    importButton.disabled = false;
                                    importButton.innerHTML = '<i class="fa-solid fa-upload me-1"></i> Import Data';

                                    if (response.success) {
                                        resultDiv.className = 'alert alert-success';
                                        resultDiv.innerHTML = `
                                            <h6><i class="fa-solid fa-check-circle me-2"></i>Import Successful!</h6>
                                            <p>Total Records: ${response.total_records}</p>
                                            <p>Imported: ${response.imported_count}</p>
                                            ${response.skipped_count > 0 ? `<p>Skipped: ${response.skipped_count}</p>` : ''}
                                            ${response.errors && response.errors.length > 0 ? `
                                                                                                                                                                <div class="mt-2">
                                                                                                                                                                    <strong>Errors:</strong>
                                                                                                                                                                    <ul class="mb-0">
                                                                                                                                                                        ${response.errors.map(error => `<li>${error}</li>`).join('')}
                                                                                                                                                                    </ul>
                                                                                                                                                                </div>
                                                                                                                                                            ` : ''}
                                        `;
                                        resultDiv.classList.remove('d-none');

                                        Swal.fire('Success', 'Data imported successfully!', 'success');

                                        // Reset form after 3 seconds
                                        setTimeout(() => {
                                            importForm.reset();
                                            resultDiv.classList.add('d-none');
                                            $('#importModal').modal('hide');
                                        }, 3000);
                                    } else {
                                        resultDiv.className = 'alert alert-danger';
                                        resultDiv.innerHTML = `
                                            <h6><i class="fa-solid fa-exclamation-triangle me-2"></i>Import Failed!</h6>
                                            <p>${response.message}</p>
                                            ${response.errors ? `
                                                                                                                                                                <ul>
                                                                                                                                                                    ${response.errors.map(error => `<li>${error}</li>`).join('')}
                                                                                                                                                                </ul>
                                                                                                                                                            ` : ''}
                                        `;
                                        resultDiv.classList.remove('d-none');
                                        Swal.fire('Error', response.message, 'error');
                                    }
                                },
                                error: function(xhr) {
                                    progressBar.classList.add('d-none');
                                    importButton.disabled = false;
                                    importButton.innerHTML = '<i class="fa-solid fa-upload me-1"></i> Import Data';

                                    let errorMessage = 'Import failed. Please try again.';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }

                                    resultDiv.className = 'alert alert-danger';
                                    resultDiv.innerHTML = `<h6>Import Error</h6><p>${errorMessage}</p>`;
                                    resultDiv.classList.remove('d-none');

                                    Swal.fire('Error', errorMessage, 'error');
                                }
                            });
                        });
                    }

                    // Import Client Dropdown Functions
                    function initializeImportClientDropdown() {
                        const clientSelect = document.getElementById('import_client_id');
                        const clientInput = document.getElementById('importClientSearch');
                        const clientSearchInput = document.getElementById('importClientSearchInput');
                        const clientOptions = document.querySelectorAll('.import-client-option');

                        if (!clientInput) return;

                        // Search functionality
                        clientSearchInput.addEventListener('input', function() {
                            const term = this.value.toLowerCase().trim();
                            clientOptions.forEach(option => {
                                const text = option.textContent.toLowerCase();
                                option.style.display = text.includes(term) ? 'block' : 'none';
                            });
                        });

                        // Click event for client selection
                        clientOptions.forEach(option => {
                            option.addEventListener('click', function(e) {
                                e.preventDefault();
                                const value = this.getAttribute('data-value');
                                const name = this.getAttribute('data-name');

                                // Update hidden select
                                clientSelect.value = value;

                                // Update display input
                                clientInput.value = name;

                                // Close dropdown
                                const dropdown = bootstrap.Dropdown.getInstance(clientInput);
                                if (dropdown) dropdown.hide();

                                // Filter branches based on selected client
                                filterImportBranchesByClient(value);
                            });
                        });

                        // Auto focus search when dropdown opens
                        clientInput.addEventListener('shown.bs.dropdown', function() {
                            clientSearchInput.focus();
                            clientSearchInput.value = '';
                            clientOptions.forEach(opt => opt.style.display = 'block');
                        });

                        // Clear search when dropdown hidden
                        clientInput.addEventListener('hidden.bs.dropdown', function() {
                            clientSearchInput.value = '';
                        });
                    }

                    // Function to filter import branches based on selected client
                    function filterImportBranchesByClient(clientId) {
                        const branchOptions = document.querySelectorAll('.import-branch-option');
                        const branchInput = document.getElementById('importBranchSearch');
                        const branchSelect = document.getElementById('import_branch_id');

                        if (!clientId) {
                            // Show all branches if no client selected
                            branchOptions.forEach(option => {
                                option.style.display = 'block';
                            });
                            return;
                        }

                        // Hide all branches first
                        branchOptions.forEach(option => {
                            option.style.display = 'none';
                        });

                        // Show only branches belonging to selected client
                        const clientBranches = document.querySelectorAll(
                            `.import-branch-option[data-client-id="${clientId}"]`
                        );

                        clientBranches.forEach(option => {
                            option.style.display = 'block';
                        });

                        // Clear branch selection when client changes
                        branchSelect.value = '';
                        branchInput.value = '';

                        // Close dropdown if open
                        const dropdown = bootstrap.Dropdown.getInstance(branchInput);
                        if (dropdown) {
                            dropdown.hide();
                        }
                    }

                    // Import Branch Dropdown Functions
                    function initializeImportBranchDropdown() {
                        const branchSelect = document.getElementById('import_branch_id');
                        const branchInput = document.getElementById('importBranchSearch');
                        const branchSearchInput = document.getElementById('importBranchSearchInput');
                        const branchOptions = document.querySelectorAll('.import-branch-option');

                        if (!branchInput) return;

                        // Search functionality
                        branchSearchInput.addEventListener('input', function() {
                            const term = this.value.toLowerCase().trim();
                            branchOptions.forEach(option => {
                                // Only search in visible branches
                                if (option.style.display !== 'none') {
                                    const text = option.textContent.toLowerCase();
                                    option.style.display = text.includes(term) ? 'block' : 'none';
                                }
                            });
                        });

                        // Click event for branch selection
                        branchOptions.forEach(option => {
                            option.addEventListener('click', function(e) {
                                e.preventDefault();
                                const value = this.getAttribute('data-value');
                                const name = this.getAttribute('data-name');

                                // Update hidden select
                                branchSelect.value = value;

                                // Update display input
                                branchInput.value = name;

                                // Close dropdown
                                const dropdown = bootstrap.Dropdown.getInstance(branchInput);
                                if (dropdown) dropdown.hide();
                            });
                        });

                        // Auto focus search when dropdown opens
                        branchInput.addEventListener('shown.bs.dropdown', function() {
                            branchSearchInput.focus();
                            branchSearchInput.value = '';
                            branchOptions.forEach(opt => {
                                if (opt.style.display !== 'none') {
                                    opt.style.display = 'block';
                                }
                            });
                        });

                        // Clear search when dropdown hidden
                        branchInput.addEventListener('hidden.bs.dropdown', function() {
                            branchSearchInput.value = '';
                        });
                    }

                    // Import Category Dropdown Functions
                    function initializeImportCategoryDropdown() {
                        const categorySelect = document.getElementById('import_category_id');
                        const categoryInput = document.getElementById('importCategorySearch');
                        const categorySearchInput = document.getElementById('importCategorySearchInput');
                        const categoryOptions = document.querySelectorAll('.import-category-option');

                        if (!categoryInput) return;

                        // Search functionality
                        categorySearchInput.addEventListener('input', function() {
                            const term = this.value.toLowerCase().trim();
                            categoryOptions.forEach(option => {
                                const text = option.textContent.toLowerCase();
                                option.style.display = text.includes(term) ? 'block' : 'none';
                            });
                        });

                        // Click event for category selection
                        categoryOptions.forEach(option => {
                            option.addEventListener('click', function(e) {
                                e.preventDefault();
                                const value = this.getAttribute('data-value');
                                const name = this.getAttribute('data-name');

                                // Update hidden select
                                categorySelect.value = value;

                                // Update display input
                                categoryInput.value = name;

                                // Close dropdown
                                const dropdown = bootstrap.Dropdown.getInstance(categoryInput);
                                if (dropdown) dropdown.hide();
                            });
                        });

                        // Auto focus search when dropdown opens
                        categoryInput.addEventListener('shown.bs.dropdown', function() {
                            categorySearchInput.focus();
                            categorySearchInput.value = '';
                            categoryOptions.forEach(opt => opt.style.display = 'block');
                        });

                        // Clear search when dropdown hidden
                        categoryInput.addEventListener('hidden.bs.dropdown', function() {
                            categorySearchInput.value = '';
                        });
                    }
                </script>

            </div>
        </div>

    </div>
</x-app-layout>
