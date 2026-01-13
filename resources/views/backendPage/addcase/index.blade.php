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
                            All Cases
                        </li>
                    </ol>
                </nav>

                <!-- <form action="{{ route('addcase.updateByExcel') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label>Select Excel file</label>
                    <input type="file" name="file" required>

                    <button type="submit">Update</button>
                </form> -->

            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                <h1 class="mb-3">Case list</h1>

                <!-- Top controls -->
                <div class="d-flex justify-content-between gap-3 flex-wrap mb-3 align-items-center">
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <a href="{{ route('cases.export.excel', request()->all()) }}" class="btn btn-success">
                            <i class="fas fa-file-excel me-2"></i> Export Excel
                        </a>
                        <a href="{{ route('cases.export.pdf', request()->all()) }}" class="btn btn-danger">
                            <i class="fas fa-file-pdf me-2"></i> Export PDF
                        </a>

                        <!-- Filter Button for Mobile -->
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#filterOffcanvas">
                            <i class="fas fa-filter me-2"></i> Filter
                        </button>
                    </div>

                    <!-- Per-page controls -->
                    <div class="d-flex gap-2 align-items-stretch">
                        <label class="mb-0 mt-1 me-1">Per Page</label>
                        <select id="perPageSelect" class="form-select h-100" style="width: auto;">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <input id="perPageCustom" type="number" min="1" max="1000" placeholder="Custom"
                            class="form-control h-100 rounded" style="width: 100px;">
                        <button id="perPageApply" class="btn btn-sm btn-outline-primary">Apply</button>

                        <!-- Customize button quick access -->
                        <button id="openCustomizeModal" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#columnCustomizeModal" title="Customize columns">
                            <i class="fas fa-sliders-h"></i>
                        </button>
                    </div>
                </div>

                <!-- Offcanvas Filter -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas"
                    aria-labelledby="filterOffcanvasLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filter Cases</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form method="GET" action="{{ route('addcase.index') }}" class="row g-3" id="filterForm">
                            <!-- keep existing inputs; per_page will be handled via JS so not necessary here -->
                            <div class="col-12">
                                <input type="text" name="file_number" value="{{ request('file_number') }}"
                                    class="form-control rounded" placeholder="File Number">
                            </div>


                            <div class="col-12 position-relative">
                                <input type="hidden" name="client_id" id="client_id"
                                    value="{{ request('client_id') }}">
                                <input type="text" id="client_input" class="form-control rounded"
                                    placeholder="On Behalf of" autocomplete="off" data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                <div class="dropdown-menu shadow w-100 p-2" id="clientDropdown">
                                    <input type="text" class="form-control rounded mb-2" id="clientSearch"
                                        placeholder="Search clients...">
                                    <div id="clientList" class="list-group list-group-flush"
                                        style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($clients as $client)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                data-id="{{ $client->id }}"
                                                onclick="selectClient('{{ $client->id }}','{{ addslashes($client->name) }}')">
                                                {{ $client->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 position-relative">
                                <input type="hidden" name="branch_id" id="branch_id"
                                    value="{{ request('branch_id') }}">
                                <input type="text" id="branch_input" class="form-control rounded"
                                    placeholder="Branch Name" autocomplete="off" data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                <div class="dropdown-menu shadow w-100 p-2" id="branchDropdown">
                                    <input type="text" class="form-control rounded mb-2" id="branchSearch"
                                        placeholder="Search branch...">
                                    <div id="branchList" class="list-group list-group-flush"
                                        style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($branches as $branch)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                data-id="{{ $branch->id }}"
                                                data-client-id="{{ $branch->client_id }}"
                                                onclick="selectBranch('{{ $branch->id }}','{{ addslashes($branch->name) }}')">
                                                {{ $branch->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <input type="text" name="name_of_parties"
                                    value="{{ request('name_of_parties') }}" class="form-control rounded"
                                    placeholder="Name of Parties">
                            </div>
                            <div class="col-12">
                                <input type="text" name="case_number" value="{{ request('case_number') }}"
                                    class="form-control rounded" placeholder="Case Number">
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Filing Or Received Date</label> <br>
                                <input type="date" name="filing_or_received_date"
                                    value="{{ request('filing_or_received_date') }}" class="form-control rounded"
                                    placeholder="Filing Date">
                            </div>
                            <div class="col-12 position-relative mt-2">
                                <input type="hidden" name="court_id" id="court_id"
                                    value="{{ request('court_id') }}">
                                <input type="text" id="court_input" class="form-control rounded"
                                    placeholder="Court Name" autocomplete="off" data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                <div class="dropdown-menu shadow w-100 p-2" id="courtDropdown">
                                    <input type="text" class="form-control form-control-sm mb-2" id="courtSearch"
                                        placeholder="Search courts...">
                                    <div id="courtList" class="list-group list-group-flush"
                                        style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($courts as $court)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                data-id="{{ $court->id }}"
                                                onclick="selectCourt('{{ $court->id }}','{{ $court->name }}')">
                                                {{ $court->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <select name="status" class="form-select rounded">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Running
                                    </option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Dismiss
                                    </option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Next Hearing Date</label>
                                <div class="d-flex gap-2">
                                    <input type="date" name="next_hearing_date_from"
                                        value="{{ request('next_hearing_date_from') }}" class="form-control rounded"
                                        placeholder="From">
                                    <input type="date" name="next_hearing_date_to"
                                        value="{{ request('next_hearing_date_to') }}" class="form-control rounded"
                                        placeholder="To">
                                </div>
                            </div>
                            <div class="col-12 d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary w-50">Filter</button>
                                <a href="{{ route('addcase.index') }}" class="btn btn-secondary w-50">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Toasts -->
                @if (session('success') || session('error'))
                    <script>
                        Swal.fire({
                            toast: true,
                            icon: '{{ session('success') ? 'success' : 'error' }}',
                            title: '{{ session('success') ?? session('error') }}',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    </script>
                @endif

                <!-- Table container -->
                <div class="table_container">
                    <table id="casesTable">
                        <thead>
                            <tr id="casesTableHead">
                                <th data-col="sl_no" class="col-sl_no">
                                    S/L No
                                    <i class="fa-solid fa-lock ms-1" title="locked"></i>
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true"
                                        draggable="false">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="file_number" class="col-file_number">
                                    File number
                                    <i class="fa-solid fa-lock ms-1" title="locked"></i>
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true"
                                        draggable="false">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="on_behalf_of" class="col-on_behalf_of">
                                    On behalf of
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>
                                <th data-col="branch" class="col-branch">
                                    Branch
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>
                                <th data-col="loan_account_acquest_cin" class="col-loan_account_acquest_cin">
                                    Loan A/C OR Member OR CIN
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="mobile_number" class="col-mobile_number">
                                    Mobile Number
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="name_of_parties" class="col-name_of_parties">
                                    Name of the parties
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="court_name" class="col-court_name">
                                    Court Name
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="case_number" class="col-case_number">
                                    Case Number
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="section" class="col-section">
                                    Section
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="legal_notice_date" class="col-legal_notice_date">
                                    Legal Notice Date
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="filing_or_received_date" class="col-filing_or_received_date">
                                    Filing OR Received Date
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="previous_date" class="col-previous_date">
                                    Previous Date
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="previous_step" class="col-previous_step">
                                    Previous Step
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="next_hearing_date" class="col-next_hearing_date">
                                    Next Hearing Date
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="next_step" class="col-next_step">
                                    Next Step
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="documents" class="col-documents">
                                    Documents
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="status" class="col-status">
                                    Status
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>

                                <th data-col="actions" class="col-actions">
                                    Actions
                                    <button class="btn btn-sm btn-link handle-btn" aria-hidden="true">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="caseTableBody">
                            @php
                                $totalCols = 17; // keep in sync with header count
                            @endphp

                            @forelse ($cases as $index => $case)
                                <tr data-id="{{ $case->id }}">
                                    <td data-col="sl_no">
                                        {{ $cases->firstItem() ? $cases->firstItem() + $index : $index + 1 }}
                                    </td>
                                    <td data-col="file_number" class="filenumber">{{ $case->file_number }}</td>
                                    <td data-col="on_behalf_of" class="onBehaftof">
                                        {{ optional($case->addclient)->name }}</td>
                                    <td data-col="branch" class="branch">{{ optional($case->clientbranch)->name }}
                                    </td>
                                    <td data-col="loan_account_acquest_cin" class="loan_account_acquest_cin">
                                        {{ $case->loan_account_acquest_cin }}</td>
                                    <td data-col="mobile_number" class="clientNumber">
                                        {{ optional($case->addclient)->number }}</td>
                                    <td data-col="name_of_parties" class="nameOfParties">{{ $case->name_of_parties }}
                                    </td>
                                    <td data-col="court_name" class="courtName">
                                        {{ optional($case->court)->name ?? '—' }}</td>
                                    <td data-col="case_number" class="casenumber">{{ $case->case_number }}</td>
                                    <td data-col="section" class="section">{{ $case->section }}</td>
                                    <td data-col="legal_notice_date" class="legal-date">
                                        {{ $case->legal_notice_date ? \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') : '—' }}
                                    </td>
                                    <td data-col="filing_or_received_date" class="received-date">
                                        {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : '—' }}
                                    </td>
                                    <td data-col="previous_date" class="prev-date">
                                        {{ $case->previous_date ? \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') : '—' }}
                                    </td>
                                    <td data-col="previous_step" class="prevStep">{{ $case->previous_step }}</td>
                                    <td data-col="next_hearing_date" class="next-date">
                                        {{ $case->next_hearing_date ? \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') : '—' }}
                                    </td>
                                    <td data-col="next_step" class="nextStep">{{ $case->next_step }}</td>
                                    <td data-col="documents">
                                        @if ($case->legal_notice)
                                            <div class="d-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('legalnotice.lndownload', $case->id) }}"
                                                    class="text-primary">
                                                    Legal notice <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('legalnotice.lndelete', $case->id) }}', 'Legal Notice')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if ($case->plaints)
                                            <div class="d-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('plaints.pldownload', $case->id) }}"
                                                    class="text-primary">
                                                    Plaints <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('plaints.pldelete', $case->id) }}', 'Plaints')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if ($case->others_documents)
                                            <div class="d-flex gap-1 align-items-center mb-1">
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
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td data-col="status">
                                        @if ($case->status == 1)
                                            <span class="badge bg-success">Running</span>
                                        @else
                                            <span class="badge bg-danger">Dismiss</span>
                                        @endif
                                    </td>
                                    <td data-col="actions">
                                        <a class="btn btn-outline-primary btn-sm"
                                            href="{{ route('addcase.edit', Crypt::encrypt($case->id)) }}">Edit</a>
                                        <a class="btn btn-outline-primary btn-sm"
                                            href="{{ route('addcase.show', Crypt::encrypt($case->id)) }}">Show</a>

                                        {{-- <form id="delete-form-{{ $case->id }}"
                                            action="{{ route('addcase.destroy', $case->id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-700 confirmDelete"
                                                data-id="{{ $case->id }}"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="{{ $totalCols }}">No data here</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Delete confirmation script (kept as before) -->
                    <script>
                        document.querySelectorAll('.confirmDelete').forEach(function(button) {
                            button.addEventListener('click', function(event) {
                                event.preventDefault();
                                const herocontentId = this.getAttribute('data-id');
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('delete-form-' + herocontentId).submit();
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Your file has been deleted.",
                                            icon: "success"
                                        });
                                    }
                                });
                            });
                        });
                    </script>
                </div>

                {{-- Pagination Links --}}
                <div class="mt-3 d-flex justify-content-end">
                    {{ $cases->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Column Customize Modal -->
    <div class="modal fade" id="columnCustomizeModal" tabindex="-1" aria-labelledby="columnCustomizeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="columnCustomizeModalLabel">Customize Table Columns</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <input type="checkbox" id="selectAllCols"> <label for="selectAllCols">Select all</label>
                        </div>
                        <div>
                            <button id="resetTableSettings" class="btn btn-sm btn-outline-danger">Reset</button>
                        </div>
                    </div>

                    <form id="columnsForm" class="row g-2">
                        <!-- We'll render checkboxes via JS to ensure sync with data-col list -->
                        <div id="columnsCheckboxList" class="col-12"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles for drag handle -->
    <style>
        .handle-btn {
            cursor: grab;
            border: none;
            padding: 0 6px;
            color: #6c757d;
        }

        .handle-btn:active {
            cursor: grabbing;
        }

        th.dragging {
            opacity: 0.5;
            outline: 2px dashed #007bff;
        }

        th.placeholder {
            background: rgba(0, 0, 0, 0.04);
            border-left: 2px dashed #ccc;
        }

        td.hidden,
        th.hidden {
            display: none !important;
        }

        /* ensure touch-friendly */
        #casesTable th,
        #casesTable td {
            vertical-align: middle;
        }
    </style>

    <!-- Table behavior JS (vanilla) -->
    <script>
        (function() {
            // --- Configuration ---
            const STORAGE_KEY = 'cases_table_settings';
            const lockedColumns = ['sl_no', 'file_number'];
            const defaultOrder = [
                'sl_no', 'file_number', 'on_behalf_of', 'branch', 'loan_account_acquest_cin', 'mobile_number',
                'name_of_parties', 'court_name',
                'case_number', 'section', 'legal_notice_date', 'filing_or_received_date', 'previous_date',
                'previous_step', 'next_hearing_date', 'next_step', 'documents', 'status', 'actions'
            ];

            // --- Helpers ---
            const qs = (selector, root = document) => root.querySelector(selector);
            const qsa = (selector, root = document) => Array.from(root.querySelectorAll(selector));

            function readSettings() {
                const raw = localStorage.getItem(STORAGE_KEY);
                if (!raw) return null;
                try {
                    return JSON.parse(raw);
                } catch (e) {
                    return null;
                }
            }

            function saveSettings(settings) {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(settings));
            }

            // Ensure settings shaped well
            function normalizeSettings(s) {
                if (!s) s = {};
                if (!Array.isArray(s.order)) s.order = defaultOrder.slice();
                if (!s.columns || typeof s.columns !== 'object') s.columns = {};

                defaultOrder.forEach(key => {
                    if (!s.columns[key]) s.columns[key] = {
                        visible: true,
                        locked: lockedColumns.includes(key)
                    };
                    else {
                        s.columns[key].locked = lockedColumns.includes(key);
                        if (typeof s.columns[key].visible !== 'boolean') s.columns[key].visible = true;
                    }
                });

                s.order = s.order.filter(k => defaultOrder.includes(k));

                lockedColumns.reverse().forEach(k => {
                    const idx = s.order.indexOf(k);
                    if (idx !== 0) {
                        if (idx > -1) s.order.splice(idx, 1);
                        s.order.unshift(k);
                    }
                });

                defaultOrder.forEach(k => {
                    if (!s.order.includes(k)) s.order.push(k);
                });

                return s;
            }

            // --- DOM utilities for column show/hide & reorder ---
            function getThByCol(key) {
                return qs(`#casesTable thead th[data-col="${key}"]`);
            }

            function getTdsByCol(key) {
                return qsa(`#casesTable tbody tr td[data-col="${key}"]`);
            }

            function applyVisibility(settings) {
                defaultOrder.forEach(col => {
                    const visible = settings.columns[col].visible;
                    const th = getThByCol(col);
                    if (th) th.classList.toggle('hidden', !visible);
                    const tds = getTdsByCol(col);
                    tds.forEach(td => td.classList.toggle('hidden', !visible));
                });
            }

            function applyOrder(settings) {
                const theadRow = qs('#casesTable thead tr');
                const tbodyRows = qsa('#casesTable tbody tr');
                const newHead = document.createDocumentFragment();

                settings.order.forEach(col => {
                    const th = getThByCol(col);
                    if (th) newHead.appendChild(th);
                });

                theadRow.innerHTML = '';
                theadRow.appendChild(newHead);

                tbodyRows.forEach(tr => {
                    const frag = document.createDocumentFragment();
                    settings.order.forEach(col => {
                        const td = tr.querySelector(`td[data-col="${col}"]`);
                        if (td) frag.appendChild(td);
                    });
                    tr.innerHTML = '';
                    tr.appendChild(frag);
                });
            }

            // --- Enhanced Drag and Drop Implementation ---
            function enableDragReorder(settings) {
                const table = qs('#casesTable');
                const thead = qs('#casesTable thead');
                const ths = qsa('#casesTable thead th');

                let dragTh = null;
                let dragIndex = -1;
                let dragOffset = {
                    x: 0,
                    y: 0
                };
                let ghostTh = null;
                let isDragging = false;

                ths.forEach((th, index) => {
                    const col = th.getAttribute('data-col');
                    const handleBtn = th.querySelector('.handle-btn');

                    if (lockedColumns.includes(col)) {
                        if (handleBtn) {
                            handleBtn.style.visibility = 'hidden';
                            handleBtn.style.cursor = 'not-allowed';
                        }
                        return;
                    }

                    if (handleBtn) {
                        handleBtn.addEventListener('mousedown', (e) => startDrag(e, th));
                        handleBtn.addEventListener('touchstart', (e) => startDrag(e, th), {
                            passive: false
                        });
                    }
                });

                function startDrag(e, th) {
                    e.preventDefault();
                    const col = th.getAttribute('data-col');

                    if (lockedColumns.includes(col)) return;

                    dragTh = th;
                    dragIndex = settings.order.indexOf(col);
                    isDragging = true;

                    // Calculate mouse/touch offset relative to the th
                    const rect = th.getBoundingClientRect();
                    const clientX = e.clientX || (e.touches && e.touches[0].clientX);
                    const clientY = e.clientY || (e.touches && e.touches[0].clientY);

                    dragOffset.x = clientX - rect.left;
                    dragOffset.y = clientY - rect.top;

                    // Create ghost element
                    createGhostTh(th);

                    // Add dragging class
                    th.classList.add('dragging');
                    document.body.classList.add('dragging-active');

                    document.addEventListener('mousemove', onDrag);
                    document.addEventListener('touchmove', onDrag, {
                        passive: false
                    });
                    document.addEventListener('mouseup', stopDrag);
                    document.addEventListener('touchend', stopDrag);
                }

                function createGhostTh(originalTh) {
                    ghostTh = originalTh.cloneNode(true);
                    ghostTh.classList.add('ghost-element');
                    ghostTh.style.width = originalTh.offsetWidth + 'px';
                    ghostTh.style.height = originalTh.offsetHeight + 'px';
                    ghostTh.style.position = 'fixed';
                    ghostTh.style.zIndex = '10000';
                    ghostTh.style.opacity = '0.8';
                    ghostTh.style.pointerEvents = 'none';
                    ghostTh.style.background = '#007bff';
                    ghostTh.style.color = 'white';
                    ghostTh.style.border = '2px dashed #fff';
                    ghostTh.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
                    ghostTh.style.transform = 'rotate(5deg)';

                    document.body.appendChild(ghostTh);
                }

                function updateGhostPosition(x, y) {
                    if (!ghostTh) return;
                    ghostTh.style.left = (x - dragOffset.x) + 'px';
                    ghostTh.style.top = (y - dragOffset.y) + 'px';
                }

                function onDrag(e) {
                    if (!isDragging || !dragTh) return;

                    e.preventDefault();
                    const clientX = e.clientX || (e.touches && e.touches[0].clientX);
                    const clientY = e.clientY || (e.touches && e.touches[0].clientY);

                    if (!clientX) return;

                    // Update ghost position
                    updateGhostPosition(clientX, clientY);

                    // Find the target position
                    const ths = qsa('#casesTable thead th:not(.dragging)');
                    let targetTh = null;
                    let minDistance = Infinity;

                    ths.forEach(th => {
                        if (th === dragTh) return;

                        const rect = th.getBoundingClientRect();
                        const thCenter = rect.left + rect.width / 2;

                        // Calculate distance from cursor to column center
                        const distance = Math.abs(clientX - thCenter);

                        if (distance < minDistance && clientX > rect.left && clientX < rect.right) {
                            minDistance = distance;
                            targetTh = th;
                        }
                    });

                    // Update visual indicators
                    updateDropIndicators(targetTh);
                }

                function updateDropIndicators(targetTh) {
                    // Remove all existing indicators
                    qsa('.drop-indicator-before', thead).forEach(el => el.remove());
                    qsa('.drop-indicator-after', thead).forEach(el => el.remove());
                    qsa('.drop-target', thead).forEach(el => el.classList.remove('drop-target'));

                    if (!targetTh) return;

                    const rect = targetTh.getBoundingClientRect();
                    const targetCenter = rect.left + rect.width / 2;
                    const ghostRect = ghostTh.getBoundingClientRect();
                    const ghostCenter = ghostRect.left + ghostRect.width / 2;

                    // Determine if we should drop before or after based on cursor position
                    if (ghostCenter < targetCenter) {
                        // Drop before
                        createDropIndicator(targetTh, 'before');
                        targetTh.classList.add('drop-target');
                    } else {
                        // Drop after
                        createDropIndicator(targetTh, 'after');
                        targetTh.classList.add('drop-target');
                    }
                }

                function createDropIndicator(targetTh, position) {
                    const indicator = document.createElement('div');
                    indicator.className = `drop-indicator-${position}`;
                    indicator.style.position = 'absolute';
                    indicator.style.height = targetTh.offsetHeight + 'px';
                    indicator.style.width = '4px';
                    indicator.style.background = '#007bff';
                    indicator.style.zIndex = '9999';

                    const rect = targetTh.getBoundingClientRect();
                    const tableRect = table.getBoundingClientRect();

                    if (position === 'before') {
                        indicator.style.left = (rect.left - tableRect.left - 2) + 'px';
                    } else {
                        indicator.style.left = (rect.right - tableRect.left - 2) + 'px';
                    }

                    indicator.style.top = (rect.top - tableRect.top) + 'px';

                    thead.style.position = 'relative';
                    thead.appendChild(indicator);
                }

                function stopDrag() {
                    if (!isDragging) return;

                    const targetTh = qs('.drop-target');
                    const beforeIndicator = qs('.drop-indicator-before', thead);
                    const afterIndicator = qs('.drop-indicator-after', thead);

                    if (dragTh && targetTh) {
                        const targetCol = targetTh.getAttribute('data-col');
                        const dragCol = dragTh.getAttribute('data-col');
                        const targetIndex = settings.order.indexOf(targetCol);

                        let newIndex;
                        if (beforeIndicator) {
                            // Insert before target
                            newIndex = targetIndex;
                        } else if (afterIndicator) {
                            // Insert after target
                            newIndex = targetIndex + 1;
                        } else {
                            newIndex = targetIndex;
                        }

                        // Adjust for the fact that we're removing the drag element first
                        if (newIndex > dragIndex) {
                            newIndex--;
                        }

                        if (newIndex !== dragIndex) {
                            // Update order in settings
                            settings.order.splice(dragIndex, 1);
                            settings.order.splice(newIndex, 0, dragCol);

                            applyOrder(settings);
                            saveSettings(settings);
                        }
                    }

                    // Cleanup
                    cleanupDrag();
                }

                function cleanupDrag() {
                    if (dragTh) {
                        dragTh.classList.remove('dragging');
                        dragTh = null;
                    }

                    if (ghostTh) {
                        ghostTh.remove();
                        ghostTh = null;
                    }

                    // Remove all indicators
                    qsa('.drop-indicator-before', thead).forEach(el => el.remove());
                    qsa('.drop-indicator-after', thead).forEach(el => el.remove());
                    qsa('.drop-target', thead).forEach(el => el.classList.remove('drop-target'));

                    document.body.classList.remove('dragging-active');
                    isDragging = false;

                    document.removeEventListener('mousemove', onDrag);
                    document.removeEventListener('touchmove', onDrag);
                    document.removeEventListener('mouseup', stopDrag);
                    document.removeEventListener('touchend', stopDrag);
                }

                // Handle drag end on window blur (safety)
                window.addEventListener('blur', cleanupDrag);
            }

            // Build modal checkbox list from defaultOrder
            function renderColumnCheckboxes(settings) {
                const container = qs('#columnsCheckboxList');
                container.innerHTML = '';
                defaultOrder.forEach(key => {
                    const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    const id = `colchk_${key}`;
                    const checked = settings.columns[key].visible ? 'checked' : '';
                    const disabled = settings.columns[key].locked ? 'disabled' : '';
                    const lockHtml = settings.columns[key].locked ?
                        ' <i class="fa-solid fa-lock ms-1" title="locked"></i>' : '';
                    const html = `
                <div class="form-check">
                    <input class="form-check-input colCheckbox" type="checkbox" value="${key}" id="${id}" ${checked} ${disabled} data-col="${key}">
                    <label class="form-check-label" for="${id}">${label} ${lockHtml}</label>
                </div>
            `;
                    container.insertAdjacentHTML('beforeend', html);
                });

                const allNonLocked = defaultOrder.filter(k => !settings.columns[k].locked);
                const checkedNonLocked = allNonLocked.filter(k => settings.columns[k].visible).length;
                qs('#selectAllCols').checked = (checkedNonLocked === allNonLocked.length);
            }

            // Attach events for checkboxes
            function hookupCheckboxes(settings) {
                qsa('.colCheckbox').forEach(cb => {
                    cb.addEventListener('change', function() {
                        const key = this.getAttribute('data-col');
                        settings.columns[key].visible = this.checked;
                        applyVisibility(settings);
                        saveSettings(settings);

                        const allNonLocked = defaultOrder.filter(k => !settings.columns[k].locked);
                        const checkedNonLocked = allNonLocked.filter(k => settings.columns[k].visible)
                            .length;
                        qs('#selectAllCols').checked = (checkedNonLocked === allNonLocked.length);
                    });
                });

                qs('#selectAllCols').addEventListener('change', function() {
                    const to = this.checked;
                    defaultOrder.forEach(k => {
                        if (!settings.columns[k].locked) {
                            settings.columns[k].visible = to;
                            const cb = qs(`#colchk_${k}`);
                            if (cb) cb.checked = to;
                        }
                    });
                    applyVisibility(settings);
                    saveSettings(settings);
                });

                qs('#resetTableSettings').addEventListener('click', function() {
                    if (!confirm('Reset table settings to default?')) return;
                    localStorage.removeItem(STORAGE_KEY);
                    location.reload();
                });
            }

            // --- Per-page control ---
            function initPerPage(settings) {
                const perPageSelect = qs('#perPageSelect');
                const perPageCustom = qs('#perPageCustom');
                const perPageApply = qs('#perPageApply');

                const urlParams = new URLSearchParams(window.location.search);
                const urlPer = urlParams.get('per_page');
                if (urlPer) {
                    perPageSelect.value = urlPer;
                    perPageCustom.value = '';
                    settings.perPage = parseInt(urlPer, 10);
                    saveSettings(settings);
                } else if (settings.perPage) {
                    if (['10', '20', '30', '50', '100'].includes(String(settings.perPage))) {
                        perPageSelect.value = settings.perPage;
                        perPageCustom.value = '';
                    } else {
                        perPageSelect.value = '';
                        perPageCustom.value = settings.perPage;
                    }
                }

                perPageApply.addEventListener('click', function() {
                    let value = perPageCustom.value ? parseInt(perPageCustom.value, 10) : parseInt(perPageSelect
                        .value, 10);
                    if (!value || value <= 0) {
                        alert('Please enter a valid per-page number');
                        return;
                    }
                    if (value > 1000) value = 1000;

                    const params = new URLSearchParams(window.location.search);
                    params.set('per_page', value);
                    params.set('page', 1);

                    settings.perPage = value;
                    saveSettings(settings);
                    window.location.search = params.toString();
                });

                perPageSelect.addEventListener('change', function() {
                    if (!this.value) return;
                    perPageCustom.value = '';
                    perPageApply.click();
                });
            }

            // --- Init ---
            function init() {
                let settings = readSettings();
                settings = normalizeSettings(settings);

                renderColumnCheckboxes(settings);
                hookupCheckboxes(settings);

                applyOrder(settings);
                applyVisibility(settings);

                enableDragReorder(settings);

                initPerPage(settings);

                saveSettings(settings);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

        })();
    </script>
    <!--
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- CLIENT ---
        const clientInput = document.getElementById('client_input');
        const clientDropdown = document.getElementById('clientDropdown');
        const clientSearch = document.getElementById('clientSearch');
        const clientList = document.getElementById('clientList');
        const clientIdInput = document.getElementById('client_id');

        // Open dropdown on click
        clientInput.addEventListener('click', () => {
            clientDropdown.classList.add('show');
            clientSearch.focus();
        });

        // Filter as user types
        clientSearch.addEventListener('input', () => {
            const filter = clientSearch.value.toLowerCase();
            clientList.querySelectorAll('button').forEach(btn => {
                btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'block' :
                    'none';
            });
        });


        // --- Branch ---
        const branchInput = document.getElementById('branch_input');
        const branchDropdown = document.getElementById('branchDropdown');
        const branchSearch = document.getElementById('branchSearch');
        const branchList = document.getElementById('branchList');
        const branchIdInput = document.getElementById('branch_id');

        // Open dropdown on click
        branchInput.addEventListener('click', () => {
            branchDropdown.classList.add('show');
            branchSearch.focus();
        });

        // Filter as user types
        branchSearch.addEventListener('input', () => {
            const filter = branchSearch.value.toLowerCase();
            branchList.querySelectorAll('button').forEach(btn => {
                btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'block' :
                    'none';
            });
        });

        // --- COURT ---
        const courtInput = document.getElementById('court_input');
        const courtDropdown = document.getElementById('courtDropdown');
        const courtSearch = document.getElementById('courtSearch');
        const courtList = document.getElementById('courtList');
        const courtIdInput = document.getElementById('court_id');

        courtInput.addEventListener('click', () => {
            courtDropdown.classList.add('show');
            courtSearch.focus();
        });

        courtSearch.addEventListener('input', () => {
            const filter = courtSearch.value.toLowerCase();
            courtList.querySelectorAll('button').forEach(btn => {
                btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'block' :
                    'none';
            });
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', function(e) {
            if (!clientInput.contains(e.target) && !clientDropdown.contains(e.target)) {
                clientDropdown.classList.remove('show');
            }
            if (!branchInput.contains(e.target) && !branchDropdown.contains(e.target)) {
                branchDropdown.classList.remove('show');
            }
            if (!courtInput.contains(e.target) && !courtDropdown.contains(e.target)) {
                courtDropdown.classList.remove('show');
            }
        });
    });

    // --- Select Functions ---
    function selectClient(id, name) {
        document.getElementById('client_input').value = name;
        document.getElementById('client_id').value = id;
        document.getElementById('clientDropdown').classList.remove('show');
    }

    function selectBranch(id, name) {
        document.getElementById('branch_input').value = name;
        document.getElementById('branch_id').value = id;
        document.getElementById('branchDropdown').classList.remove('show');
    }

    function selectCourt(id, name) {
        document.getElementById('court_input').value = name;
        document.getElementById('court_id').value = id;
        document.getElementById('courtDropdown').classList.remove('show');
    }
</script> -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store all branches for filtering
            const allBranches = [];
            document.querySelectorAll('#branchList button').forEach(btn => {
                allBranches.push({
                    id: btn.getAttribute('data-id'),
                    name: btn.textContent.trim(),
                    clientId: btn.getAttribute('data-client-id') || null,
                    element: btn
                });
            });

            // --- CLIENT ---
            const clientInput = document.getElementById('client_input');
            const clientDropdown = document.getElementById('clientDropdown');
            const clientSearch = document.getElementById('clientSearch');
            const clientList = document.getElementById('clientList');
            const clientIdInput = document.getElementById('client_id');

            // Open dropdown on click
            clientInput.addEventListener('click', () => {
                clientDropdown.classList.add('show');
                clientSearch.focus();
            });

            // Filter as user types
            clientSearch.addEventListener('input', () => {
                const filter = clientSearch.value.toLowerCase();
                clientList.querySelectorAll('button').forEach(btn => {
                    btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'block' :
                        'none';
                });
            });

            // --- BRANCH ---
            const branchInput = document.getElementById('branch_input');
            const branchDropdown = document.getElementById('branchDropdown');
            const branchSearch = document.getElementById('branchSearch');
            const branchList = document.getElementById('branchList');
            const branchIdInput = document.getElementById('branch_id');

            // Open dropdown on click
            branchInput.addEventListener('click', () => {
                branchDropdown.classList.add('show');
                branchSearch.focus();
            });

            // Filter as user types
            branchSearch.addEventListener('input', () => {
                const filter = branchSearch.value.toLowerCase();
                const clientId = clientIdInput.value;

                allBranches.forEach(branch => {
                    const matchesSearch = branch.name.toLowerCase().includes(filter);
                    const matchesClient = !clientId || branch.clientId == clientId;

                    branch.element.style.display = (matchesSearch && matchesClient) ? 'block' :
                        'none';
                });
            });

            // --- COURT ---
            const courtInput = document.getElementById('court_input');
            const courtDropdown = document.getElementById('courtDropdown');
            const courtSearch = document.getElementById('courtSearch');
            const courtList = document.getElementById('courtList');
            const courtIdInput = document.getElementById('court_id');

            courtInput.addEventListener('click', () => {
                courtDropdown.classList.add('show');
                courtSearch.focus();
            });

            courtSearch.addEventListener('input', () => {
                const filter = courtSearch.value.toLowerCase();
                courtList.querySelectorAll('button').forEach(btn => {
                    btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'block' :
                        'none';
                });
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', function(e) {
                if (!clientInput.contains(e.target) && !clientDropdown.contains(e.target)) {
                    clientDropdown.classList.remove('show');
                }
                if (!branchInput.contains(e.target) && !branchDropdown.contains(e.target)) {
                    branchDropdown.classList.remove('show');
                }
                if (!courtInput.contains(e.target) && !courtDropdown.contains(e.target)) {
                    courtDropdown.classList.remove('show');
                }
            });
        });

        // --- Select Functions ---
        function selectClient(id, name) {
            document.getElementById('client_input').value = name;
            document.getElementById('client_id').value = id;
            document.getElementById('clientDropdown').classList.remove('show');

            // Filter branches for selected client
            filterBranchesByClient(id);

            // Clear branch if it doesn't belong to selected client
            const selectedBranchId = document.getElementById('branch_id').value;
            if (selectedBranchId) {
                const selectedBranch = document.querySelector(`#branchList button[data-id="${selectedBranchId}"]`);
                if (selectedBranch && selectedBranch.getAttribute('data-client-id') != id) {
                    clearBranch();
                }
            }
        }

        function selectBranch(id, name) {
            document.getElementById('branch_input').value = name;
            document.getElementById('branch_id').value = id;
            document.getElementById('branchDropdown').classList.remove('show');
        }

        function selectCourt(id, name) {
            document.getElementById('court_input').value = name;
            document.getElementById('court_id').value = id;
            document.getElementById('courtDropdown').classList.remove('show');
        }

        function clearBranch() {
            document.getElementById('branch_input').value = '';
            document.getElementById('branch_id').value = '';
        }

        function filterBranchesByClient(clientId) {
            const branchList = document.getElementById('branchList');
            const branchSearch = document.getElementById('branchSearch');
            const branchInput = document.getElementById('branch_input');

            // Clear branch search and input
            branchSearch.value = '';

            // If no client selected, show all branches
            if (!clientId) {
                branchList.querySelectorAll('button').forEach(btn => {
                    btn.style.display = 'block';
                });
                return;
            }

            // Filter branches by client
            branchList.querySelectorAll('button').forEach(btn => {
                const branchClientId = btn.getAttribute('data-client-id');
                if (branchClientId == clientId) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });
        }

        // Initialize on page load if client is pre-selected
        document.addEventListener('DOMContentLoaded', function() {
            const clientId = document.getElementById('client_id').value;
            if (clientId) {
                filterBranchesByClient(clientId);
            }
        });

        function deleteFile(url, fileName) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete ${fileName}? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.message
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while deleting the file.'
                            });
                        });
                }
            });
        }
    </script>


</x-app-layout>
