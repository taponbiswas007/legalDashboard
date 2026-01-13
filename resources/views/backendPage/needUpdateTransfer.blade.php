<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <!-- Breadcrumb Section -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Need Update Transfer Case
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold">Need Update Transfer Cases</h4>

                    <div>
                        <!-- Filter Button -->
                        <button class="btn btn-outline-primary me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#filterCanvas">
                            <i class="fa fa-filter"></i> Filter
                        </button>

                        <!-- Export Buttons -->
                        <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}" class="btn btn-success">
                            <i class="fa fa-file-excel"></i> Excel
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="btn btn-danger">
                            <i class="fa fa-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>

                <div class="table_container">
                    <table id="caseTable">
                        <thead>
                            <tr>
                                <th>S/L No</th>
                                <th>File number</th>
                                <th>On behalf of</th>
                                <th>Branch</th>
                                <th>Loan A/C Or Member Or CIN </th>
                                <th>Name of the parties</th>
                                <th>Court Name</th>
                                <th>Case Number</th>
                                <th>Section</th>
                                <th>Mobile Number</th>
                                <th>Legal Notice Date</th>
                                <th>Filing / Received Date</th>
                                <th>Previous Date</th>
                                <th>Previous Step</th>
                                <th>Next Step</th>
                                <th>Next Hearing Date</th>
                                <th>Documents</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($needUpdateTransfers as $index => $case)
                                <tr>
                                    <td class="text-center">
                                        {{ $index + 1 + ($needUpdateTransfers->currentPage() - 1) * $needUpdateTransfers->perPage() }}
                                    </td>
                                    <td class="filenumber">{{ $case->file_number }}</td>
                                    <td>{{ $case->addclient->name }}</td>
                                    <td>{{ optional($case->clientbranch)->name ?? '' }}</td>
                                    <td>{{ $case->loan_account_acquest_cin ?? '' }}</td>
                                    <td>{{ $case->name_of_parties }}</td>
                                    <td>{{ optional($case->court)->name ?? '—' }}</td>
                                    <td class="casenumber">{{ $case->case_number }}</td>
                                    <td class="section">{{ $case->section }}</td>
                                    <td>{{ $case->addclient->number }}</td>
                                    <td class="legal-date">
                                        {{ \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') }}</td>
                                    <td class="received-date">
                                        {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : 'N/A' }}
                                    </td>
                                    <td class="prev-date">
                                        {{ \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') }}</td>
                                    <td>{{ $case->previous_step }}</td>
                                    <td>{{ $case->next_step }}</td>
                                    <td class="next-date">
                                        {{ \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') }}</td>
                                    <td>
                                        @if ($case->legal_notice)
                                            <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('legalnotice.lndownload', $case->id) }}"
                                                    class="text-primary">
                                                    Legal notice <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('legalnotice.lndelete', $case->id) }}', 'Legal Notice')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div><br>
                                        @endif
                                        @if ($case->plaints)
                                            <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('plaints.pldownload', $case->id) }}"
                                                    class="text-primary">
                                                    Plaints <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('plaints.pldelete', $case->id) }}', 'Plaints')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div><br>
                                        @endif
                                        @if ($case->others_documents)
                                            <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('otherdocuments.othddownload', $case->id) }}"
                                                    class="text-primary">
                                                    Other Documents <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('otherdocuments.othddelete', $case->id) }}', 'Other Documents')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (!$case->legal_notice && !$case->plaints && !$case->others_documents)
                                            <span class="text-muted">No files</span>
                                        @endif
                                    </td>
                                    <td>
                                        {!! $case->status == 1 ? '<span class="running">Running</span>' : '<span class="dismiss">Dismiss</span>' !!}
                                    </td>
                                    <td>
                                        <!-- <a class="btn btn-outline-primary" href="{{ route('addcase.edit', Crypt::encrypt($case->id)) }}">Edit</a> -->
                                        <button class="btn btn-outline-primary btn-sm"
                                            onclick="openEditModal({{ $case->id }})">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="17">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($needUpdateTransfers->hasPages() || $needUpdateTransfers->total() > 0)
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center mt-4 gap-3">

                        {{-- Per Page Selector --}}
                        <form method="GET" action="{{ route('needUpdateTransfer') }}"
                            class="d-flex align-items-center gap-2">
                            {{-- Preserve filters during per-page change --}}
                            @foreach (request()->except('per_page', 'page') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach

                            <label for="per_page" class="text-muted mb-0">Show</label>
                            <select name="per_page" id="per_page" class="form-select form-select-sm w-auto"
                                onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="text-muted ms-2">Entries per page</span>
                        </form>

                        {{-- Pagination Info --}}
                        <!-- <div class="text-muted">
                        Showing {{ $needUpdateTransfers->firstItem() ?? 0 }} to
                        {{ $needUpdateTransfers->lastItem() ?? 0 }} of
                        {{ $needUpdateTransfers->total() }} entries
                    </div> -->

                        {{-- Pagination Links --}}
                        <div>
                            {{ $needUpdateTransfers->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif


                <!-- Offcanvas Filter Panel -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="filterCanvas">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Filter Cases</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form method="GET" action="{{ route('needUpdateTransfer') }}" id="filterForm">
                            <!-- Client Name Searchable Dropdown -->
                            <div class="mb-3 position-relative">
                                <label class="form-label">Client Name</label>
                                <input type="text" id="filter_client_name" class="form-control"
                                    placeholder="Search client..."
                                    value="{{ request('client_id') ? $clients->firstWhere('id', request('client_id'))->name ?? '' : '' }}"
                                    autocomplete="off" readonly>
                                <input type="hidden" name="client_id" id="filter_client_id_hidden"
                                    value="{{ request('client_id') }}">

                                <div id="filterClientDropdown" class="dropdown-menu w-100"
                                    style="max-height: 250px; overflow-y: auto;">
                                    <div class="p-2">
                                        <input type="text" id="filterClientSearch"
                                            class="form-control form-control-sm" placeholder="Search...">
                                    </div>
                                    <div id="filterClientList" class="list-group list-group-flush"
                                        style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($clients as $client)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                onclick="selectFilterClient('{{ $client->id }}', '{{ $client->name }}')">
                                                {{ $client->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">File Number</label>
                                <input type="text" name="file_number" class="form-control"
                                    value="{{ request('file_number') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Case Number</label>
                                <input type="text" name="case_number" class="form-control"
                                    value="{{ request('case_number') }}">
                            </div>

                            <!-- Court Name Searchable Dropdown -->
                            <div class="mb-3 position-relative">
                                <label class="form-label">Court Name</label>
                                <input type="text" id="filter_court_name" class="form-control"
                                    placeholder="Search court..."
                                    value="{{ request('court_id') ? $courts->firstWhere('id', request('court_id'))->name ?? '' : '' }}"
                                    autocomplete="off" readonly>
                                <input type="hidden" name="court_id" id="filter_court_id_hidden"
                                    value="{{ request('court_id') }}">

                                <div id="filterCourtDropdown" class="dropdown-menu w-100"
                                    style="max-height: 250px; overflow-y: auto;">
                                    <div class="p-2">
                                        <input type="text" id="filterCourtSearch"
                                            class="form-control form-control-sm" placeholder="Search...">
                                    </div>
                                    <div id="filterCourtList" class="list-group list-group-flush"
                                        style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($courts as $court)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                onclick="selectFilterCourt('{{ $court->id }}', '{{ $court->name }}')">
                                                {{ $court->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Section Searchable Dropdown -->
                            <div class="mb-3 position-relative">
                                <label class="form-label">Section</label>
                                <input type="text" id="filter_section" class="form-control"
                                    placeholder="Search section..." value="{{ request('section') }}"
                                    autocomplete="off">
                                <input type="hidden" name="section" id="filter_section_hidden"
                                    value="{{ request('section') }}">

                                <div id="filterSectionDropdown" class="dropdown-menu w-100"
                                    style="max-height: 250px; overflow-y: auto;">
                                    <div class="p-2">
                                        <input type="text" id="filterSectionSearch"
                                            class="form-control form-control-sm" placeholder="Search...">
                                    </div>
                                    <div id="filterSectionList" class="list-group list-group-flush"
                                        style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($sections as $section)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                onclick="selectFilterSection('{{ $section }}')">
                                                {{ $section }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date" class="form-control"
                                    value="{{ request('from_date') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" class="form-control"
                                    value="{{ request('to_date') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                                <a href="{{ route('needUpdateTransfer') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Update Modal -->
    <div class="modal fade" id="editCaseModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Case</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editCaseModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let isModalOpening = false;

        function openEditModal(id) {
            // Prevent multiple clicks
            if (isModalOpening) {
                return;
            }

            isModalOpening = true;

            fetch(`/addcase/${id}/edit-modal`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('editCaseModalBody').innerHTML = html;

                    const modalElement = document.getElementById('editCaseModal');
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();

                    // Reset flag when modal is closed
                    modalElement.addEventListener('hidden.bs.modal', function() {
                        isModalOpening = false;
                    }, {
                        once: true
                    });

                    // Initialize modal JS
                    setTimeout(() => {
                        if (typeof initEditCaseModalJS === 'function') {
                            initEditCaseModalJS();
                        }
                    }, 100);
                })
                .catch(error => {
                    console.error('Error loading modal:', error);
                    isModalOpening = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load the form. Please try again.'
                    });
                });
        }
    </script>

    <script>
        document.addEventListener('submit', function(e) {
            if (e.target.id === 'updateCaseForm') {
                e.preventDefault();

                const form = e.target;
                const submitBtn = form.querySelector('#saveButton');
                const originalBtnText = submitBtn.innerHTML;

                // Disable button and show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

                const id = form.querySelector('[name="case_id"]').value;

                fetch(`/addcase/${id}/ajax-update`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-HTTP-Method-Override': 'PUT',
                            'Accept': 'application/json'
                        },
                        body: new FormData(form)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) {
                            throw new Error(data.message || 'Update failed');
                        }
                        return data;
                    })
                    .then(data => {
                        // Close modal
                        const modalElement = document.getElementById('editCaseModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) {
                            modal.hide();
                        }

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'Case updated successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Re-enable button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;

                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update case. Please try again.'
                        });
                    });
            }
        });
    </script>
    <script>
        /** =======================
         * Main JS for Edit Case Modal
         * ======================= */
        function initEditCaseModalJS() {

            // =======================
            // CLIENT → BRANCH FILTER
            // =======================
            const selectedClientId = document.getElementById('client_id')?.value;

            // Helper function to filter branches
            window.filterBranchesByClient = function(clientId) {
                const branchButtons = document.querySelectorAll('#branchList button');

                if (!clientId) {
                    branchButtons.forEach(button => button.style.display = 'block');
                    return;
                }

                branchButtons.forEach(button => {
                    const buttonClientId = button.getAttribute('data-client-id');
                    button.style.display = (buttonClientId === clientId) ? 'block' : 'none';
                });
            }

            // Filter branches on initialization
            if (selectedClientId) {
                filterBranchesByClient(selectedClientId);
            }

            // =======================
            // CLIENT DROPDOWN
            // =======================
            const partyInput = document.getElementById('party_name');
            const clientDropdown = document.getElementById('clientDropdown');
            const clientSearch = document.getElementById('clientSearch');
            const clientList = document.getElementById('clientList');

            if (partyInput) {
                partyInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Hide other dropdowns
                    document.getElementById('branchDropdown')?.classList.remove('show');
                    document.getElementById('courtDropdown')?.classList.remove('show');
                    // Show client dropdown
                    clientDropdown.classList.add('show');
                    setTimeout(() => clientSearch?.focus(), 100);
                });
            }

            // Client search filter
            if (clientSearch) {
                clientSearch.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    clientList.querySelectorAll('.list-group-item').forEach(btn => {
                        btn.style.display = btn.textContent.toLowerCase().includes(term) ? 'block' : 'none';
                    });
                });
            }

            // =======================
            // BRANCH DROPDOWN
            // =======================
            const branchInput = document.getElementById('branch_name');
            const branchDropdown = document.getElementById('branchDropdown');
            const branchSearch = document.getElementById('branchSearch');
            const branchList = document.getElementById('branchList');

            if (branchInput) {
                branchInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Hide other dropdowns
                    clientDropdown?.classList.remove('show');
                    document.getElementById('courtDropdown')?.classList.remove('show');
                    // Show branch dropdown
                    branchDropdown.classList.add('show');
                    setTimeout(() => branchSearch?.focus(), 100);
                });
            }

            // Branch search filter
            if (branchSearch) {
                branchSearch.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    branchList.querySelectorAll('.list-group-item').forEach(btn => {
                        // Only filter visible branches (after client filter)
                        const isVisibleByClient = btn.style.display !== 'none';
                        if (isVisibleByClient) {
                            btn.style.display = btn.textContent.toLowerCase().includes(term) ? 'block' :
                                'none';
                        }
                    });
                });
            }

            // =======================
            // COURT DROPDOWN
            // =======================
            const courtInput = document.getElementById('court_input');
            const courtDropdown = document.getElementById('courtDropdown');
            const courtSearch = document.getElementById('courtSearch');
            const courtList = document.getElementById('courtList');

            if (courtInput) {
                courtInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Hide other dropdowns
                    clientDropdown?.classList.remove('show');
                    branchDropdown?.classList.remove('show');
                    // Show court dropdown
                    courtDropdown.classList.add('show');
                    setTimeout(() => courtSearch?.focus(), 100);
                });
            }

            // Court search filter
            if (courtSearch) {
                courtSearch.addEventListener('input', () => {
                    const filter = courtSearch.value.toLowerCase();
                    courtList.querySelectorAll('button').forEach(btn => {
                        btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'block' :
                            'none';
                    });
                });
            }

            // =======================
            // CLOSE DROPDOWNS ON OUTSIDE CLICK
            // =======================
            document.addEventListener('click', function(e) {
                const dropdowns = [clientDropdown, branchDropdown, courtDropdown];
                const inputs = [partyInput, branchInput, courtInput];

                dropdowns.forEach((dropdown, index) => {
                    if (dropdown && inputs[index]) {
                        if (!inputs[index].contains(e.target) && !dropdown.contains(e.target)) {
                            dropdown.classList.remove('show');
                        }
                    }
                });
            });

            // =======================
            // SELECT FUNCTIONS
            // =======================
            window.selectClient = function(id, name) {
                document.getElementById('client_id').value = id;
                document.getElementById('party_name').value = name;
                filterBranchesByClient(id);
                clientDropdown.classList.remove('show');
            }

            window.selectBranch = function(branchId, branchName) {
                document.getElementById('branch_id').value = branchId;
                document.getElementById('branch_name').value = branchName;
                branchDropdown.classList.remove('show');
            }

            window.selectCourt = function(id, name) {
                document.getElementById('court_id').value = id;
                document.getElementById('court_input').value = name;
                courtDropdown.classList.remove('show');
            }

            // =======================
            // ADD NEW LINKS
            // =======================
            window.addNewClient = function() {
                clientDropdown.classList.remove('show');
                window.location.href = "{{ route('addclient.create') }}";
            }

            window.addNewBranch = function() {
                branchDropdown.classList.remove('show');
                window.location.href = "{{ route('client.branch.page') }}";
            }

            window.addNewCourt = function() {
                courtDropdown.classList.remove('show');
                window.location.href = '/courts/create';
            }
        }
    </script>

    <script>
        /** =======================
         * Filter Panel Searchable Dropdowns
         * ======================= */
        document.addEventListener('DOMContentLoaded', function() {

            // =======================
            // CLIENT FILTER DROPDOWN
            // =======================
            const filterClientInput = document.getElementById('filter_client_name');
            const filterClientDropdown = document.getElementById('filterClientDropdown');
            const filterClientSearch = document.getElementById('filterClientSearch');
            const filterClientList = document.getElementById('filterClientList');

            if (filterClientInput) {
                filterClientInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Hide other filter dropdowns
                    document.getElementById('filterCourtDropdown')?.classList.remove('show');
                    document.getElementById('filterSectionDropdown')?.classList.remove('show');
                    // Show client dropdown
                    filterClientDropdown.classList.add('show');
                    setTimeout(() => filterClientSearch?.focus(), 100);
                });
            }

            // Client search filter
            if (filterClientSearch) {
                filterClientSearch.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    filterClientList.querySelectorAll('.list-group-item').forEach(btn => {
                        btn.style.display = btn.textContent.toLowerCase().includes(term) ? 'block' :
                            'none';
                    });
                });
            }

            // =======================
            // COURT FILTER DROPDOWN
            // =======================
            const filterCourtInput = document.getElementById('filter_court_name');
            const filterCourtDropdown = document.getElementById('filterCourtDropdown');
            const filterCourtSearch = document.getElementById('filterCourtSearch');
            const filterCourtList = document.getElementById('filterCourtList');

            if (filterCourtInput) {
                filterCourtInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Hide other filter dropdowns
                    document.getElementById('filterClientDropdown')?.classList.remove('show');
                    document.getElementById('filterSectionDropdown')?.classList.remove('show');
                    // Show court dropdown
                    filterCourtDropdown.classList.add('show');
                    setTimeout(() => filterCourtSearch?.focus(), 100);
                });
            }

            // Court search filter
            if (filterCourtSearch) {
                filterCourtSearch.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    filterCourtList.querySelectorAll('.list-group-item').forEach(btn => {
                        btn.style.display = btn.textContent.toLowerCase().includes(term) ? 'block' :
                            'none';
                    });
                });
            }

            // =======================
            // SECTION FILTER DROPDOWN
            // =======================
            const filterSectionInput = document.getElementById('filter_section');
            const filterSectionDropdown = document.getElementById('filterSectionDropdown');
            const filterSectionSearch = document.getElementById('filterSectionSearch');
            const filterSectionList = document.getElementById('filterSectionList');

            if (filterSectionInput) {
                filterSectionInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Hide other filter dropdowns
                    document.getElementById('filterClientDropdown')?.classList.remove('show');
                    document.getElementById('filterCourtDropdown')?.classList.remove('show');
                    // Show section dropdown
                    filterSectionDropdown.classList.add('show');
                    setTimeout(() => filterSectionSearch?.focus(), 100);
                });
            }

            // Section search filter
            if (filterSectionSearch) {
                filterSectionSearch.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    filterSectionList.querySelectorAll('.list-group-item').forEach(btn => {
                        btn.style.display = btn.textContent.toLowerCase().includes(term) ? 'block' :
                            'none';
                    });
                });
            }

            // =======================
            // CLOSE DROPDOWNS ON OUTSIDE CLICK
            // =======================
            document.addEventListener('click', function(e) {
                const filterDropdowns = [filterClientDropdown, filterCourtDropdown, filterSectionDropdown];
                const filterInputs = [filterClientInput, filterCourtInput, filterSectionInput];

                filterDropdowns.forEach((dropdown, index) => {
                    if (dropdown && filterInputs[index]) {
                        if (!filterInputs[index].contains(e.target) && !dropdown.contains(e
                                .target)) {
                            dropdown.classList.remove('show');
                        }
                    }
                });
            });
        });

        // =======================
        // SELECT FUNCTIONS FOR FILTER
        // =======================
        window.selectFilterClient = function(id, name) {
            document.getElementById('filter_client_id_hidden').value = id;
            document.getElementById('filter_client_name').value = name;
            document.getElementById('filterClientDropdown').classList.remove('show');
        }

        window.selectFilterCourt = function(id, name) {
            document.getElementById('filter_court_id_hidden').value = id;
            document.getElementById('filter_court_name').value = name;
            document.getElementById('filterCourtDropdown').classList.remove('show');
        }

        window.selectFilterSection = function(section) {
            document.getElementById('filter_section').value = section;
            document.getElementById('filter_section_hidden').value = section;
            document.getElementById('filterSectionDropdown').classList.remove('show');
        }

        // Delete file with SweetAlert confirmation
        window.deleteFile = function(deleteUrl, fileType) {
            Swal.fire({
                title: 'আপনি কি নিশ্চিত?',
                text: `আপনি ${fileType} ফাইলটি মুছতে চান?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'হ্যাঁ, মুছুন!',
                cancelButtonText: 'বাতিল'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'মুছে ফেলা হয়েছে!',
                                    text: data.message,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'ত্রুটি!',
                                    text: data.message || 'ফাইল মুছতে সমস্যা হয়েছে।',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'ত্রুটি!',
                                text: 'সার্ভার সমস্যা হয়েছে।',
                                icon: 'error'
                            });
                        });
                }
            });
        }
    </script>

</x-app-layout>
