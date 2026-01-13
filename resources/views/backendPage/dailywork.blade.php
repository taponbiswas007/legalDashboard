<x-app-layout>
    <div class="py-3 body_area">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-body">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-4" id="caseTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="today-tab" data-bs-toggle="tab" data-bs-target="#today"
                            type="button" role="tab" aria-controls="today" aria-selected="true">
                            Today Case ({{ $addcases->total() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tomorrow-tab" data-bs-toggle="tab" data-bs-target="#tomorrow"
                            type="button" role="tab" aria-controls="tomorrow" aria-selected="false">
                            Tomorrow Case ({{ $tomorrowCases->total() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="update-tab" data-bs-toggle="tab" data-bs-target="#update"
                            type="button" role="tab" aria-controls="update" aria-selected="false">
                            Need Update ({{ $needupdateaddcases->total() }})
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="caseTabsContent">

                    <!-- Today Cases Tab -->
                    <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">
                        <div class="py-4 d-sm-flex justify-content-between align-items-center">
                            <h1 class="mb-4 mb-sm-0">Today Case ({{ $addcases->total() }})</h1>
                            <div>
                                <a class="btn btn-primary" href="{{ route('todayPrintcase') }}">
                                    Print Today Case
                                </a>
                            </div>
                        </div>
                        <div class="table_container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>S/L No</th>
                                        <th>File number</th>
                                        <th>On behalf of</th>
                                        <th>Branch</th>
                                        <th>Loan A/C Or Member Or CIN </th>
                                        <th>Mobile Number</th>
                                        <th>Name of the parties</th>
                                        <th>Court Name</th>
                                        <th>Case Number</th>
                                        <th>Legal Notice Date</th>
                                        <th>Filing / Received Date</th>
                                        <th>Previous Date</th>
                                        <th>Previous Step</th>
                                        <th>Next Hearing Date</th>
                                        <th>Next Step</th>
                                        <th>Documents</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="caseTable">
                                    @forelse ($addcases as $index => $case)
                                        <tr>
                                            <td>{{ $index + 1 + ($addcases->currentPage() - 1) * $addcases->perPage() }}
                                            </td>
                                            <td>{{ $case->file_number }}</td>
                                            <td>{{ $case->addclient->name }}</td>
                                            <td>{{ optional($case->clientbranch)->name }}</td>
                                            <td>{{ $case->loan_account_acquest_cin }}</td>
                                            <td>{{ $case->addclient->number }}</td>
                                            <td>{{ $case->name_of_parties }}</td>
                                            <td> {{ optional($case->court)->name ?? '—' }}</td>
                                            <td>{{ $case->case_number }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') }}
                                            </td>
                                            <td>
                                                {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') }}
                                            </td>
                                            <td>{{ $case->previous_step }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') }}
                                            </td>
                                            <td>{{ $case->next_step }}</td>
                                            <td>
                                                @if ($case->legal_notice)
                                                    <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                        <a href="{{ route('legalnotice.lndownload', $case->id) }}">
                                                            Legal notice <i class="fa-solid fa-download"></i>
                                                        </a>
                                                        <button
                                                            onclick="deleteFile('{{ route('legalnotice.lndelete', $case->id) }}', 'Legal Notice')"
                                                            class="btn btn-sm btn-danger py-0 px-1">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <br>
                                                @endif
                                                @if ($case->plaints)
                                                    <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                        <a href="{{ route('plaints.pldownload', $case->id) }}">
                                                            Plaints <i class="fa-solid fa-download"></i>
                                                        </a>
                                                        <button
                                                            onclick="deleteFile('{{ route('plaints.pldelete', $case->id) }}', 'Plaints')"
                                                            class="btn btn-sm btn-danger py-0 px-1">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <br>
                                                @endif
                                                @if ($case->others_documents)
                                                    <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                        <a
                                                            href="{{ route('otherdocuments.othddownload', $case->id) }}">
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
                                                <!-- <a class="btn btn-outline-primary"
                                            href="{{ route('addcase.edit', Crypt::encrypt($case->id)) }}">Edit</a> -->
                                                <button class="btn btn-outline-primary btn-sm"
                                                    onclick="openEditModal({{ $case->id }})">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="16">No cases for today</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination for Today Cases -->
                            @if ($addcases->hasPages())
                                <div class="mt-3">
                                    {{ $addcases->withQueryString()->fragment('today')->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tomorrow Cases Tab -->
                    <div class="tab-pane fade" id="tomorrow" role="tabpanel" aria-labelledby="tomorrow-tab">
                        <div class="py-4 d-sm-flex justify-content-between align-items-center">
                            <h1 class="mb-4 mb-sm-0">Tomorrow Case ({{ $tomorrowCases->total() }})</h1>
                            <div>
                                <a class="btn btn-primary" href="{{ route('tomorrowPrintCase') }}">
                                    Print Tomorrow Case
                                </a>
                            </div>
                        </div>
                        <div class="table_container">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/L No</th>
                                        <th>File number</th>
                                        <th>On behalf of</th>
                                        <th>Branch</th>
                                        <th>Loan A/C Or Member Or CIN </th>
                                        <th>Mobile Number</th>
                                        <th>Name of the parties</th>
                                        <th>Court Name</th>
                                        <th>Case Number</th>
                                        <th>Legal Notice Date</th>
                                        <th>Filing / Received Date</th>
                                        <th>Previous Date</th>
                                        <th>Previous Step</th>
                                        <th>Next Hearing Date</th>
                                        <th>Next Step</th>
                                        <th>Documents</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody id="caseTable">
                                    @forelse ($tomorrowCases as $index => $case)
                                        <tr>
                                            {{-- ✅ Serial number calculation --}}
                                            <td>{{ $index + 1 + ($tomorrowCases->currentPage() - 1) * $tomorrowCases->perPage() }}
                                            </td>
                                            <td>{{ $case->file_number }}</td>
                                            <td>{{ $case->addclient->name }}</td>
                                            <td>{{ optional($case->clientbranch)->name }}</td>
                                            <td>{{ $case->loan_account_acquest_cin }}</td>
                                            <td>{{ $case->addclient->number }}</td>
                                            <td>{{ $case->name_of_parties }}</td>
                                            <td> {{ optional($case->court)->name ?? '—' }}</td>
                                            <td>{{ $case->case_number }}</td>
                                            <td>{{ \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') }}
                                            </td>
                                            <td>{{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') }}</td>
                                            <td>{{ $case->previous_step }}</td>
                                            <td>{{ \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') }}
                                            </td>
                                            <td>{{ $case->next_step }}</td>
                                            <td>
                                                @if ($case->legal_notice)
                                                    <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                        <a href="{{ route('legalnotice.lndownload', $case->id) }}">
                                                            Legal notice <i class="fa-solid fa-download"></i>
                                                        </a>
                                                        <button
                                                            onclick="deleteFile('{{ route('legalnotice.lndelete', $case->id) }}', 'Legal Notice')"
                                                            class="btn btn-sm btn-danger py-0 px-1">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <br>
                                                @endif
                                                @if ($case->plaints)
                                                    <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                        <a href="{{ route('plaints.pldownload', $case->id) }}">
                                                            Plaints <i class="fa-solid fa-download"></i>
                                                        </a>
                                                        <button
                                                            onclick="deleteFile('{{ route('plaints.pldelete', $case->id) }}', 'Plaints')"
                                                            class="btn btn-sm btn-danger py-0 px-1">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <br>
                                                @endif
                                                @if ($case->others_documents)
                                                    <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                        <a
                                                            href="{{ route('otherdocuments.othddownload', $case->id) }}">
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
                                            <td class="text-center" colspan="16">No cases for tomorrow</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- ✅ Proper Pagination --}}
                            @if ($tomorrowCases->hasPages())
                                <div class="mt-3">
                                    {{ $tomorrowCases->withQueryString()->fragment('tomorrow')->links('pagination::bootstrap-5') }}
                                </div>
                            @endif

                        </div>
                    </div>

                    <!-- Need Update Tab -->
                    <div class="tab-pane fade" id="update" role="tabpanel" aria-labelledby="update-tab">
                        <div class="py-4 d-sm-flex justify-content-between align-items-center">
                            <h1 class="mb-4 mb-sm-0">Need update next hearing date
                                ({{ $needupdateaddcases->total() }})
                            </h1>
                            <div>
                                <!-- Filter Button -->
                                <button class="btn btn-outline-primary me-2 d-none" data-bs-toggle="offcanvas"
                                    data-bs-target="#filterCanvas">
                                    <i class="fa fa-filter"></i> Filter
                                </button>

                                <!-- Export Buttons -->
                                <a href="{{ route('exportNeedUpdateExcel', request()->query()) }}"
                                    class="btn btn-success">
                                    <i class="fa fa-file-excel"></i> Excel
                                </a>
                                <a href="{{ route('exportneedUpdatePdfPaginated', request()->query()) }}"
                                    class="btn btn-danger">
                                    <i class="fa fa-file-pdf"></i> PDF
                                </a>
                            </div>
                        </div>

                        <!-- Active Filters Display -->
                        @if (request()->anyFilled([
                                'client_name',
                                'file_number',
                                'case_number',
                                'court_name',
                                'section',
                                'from_date',
                                'to_date',
                                'status',
                            ]))
                            <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                <strong>Active Filters:</strong>
                                @foreach (request()->all() as $key => $value)
                                    @if (
                                        $value &&
                                            in_array($key, [
                                                'client_name',
                                                'file_number',
                                                'case_number',
                                                'court_name',
                                                'section',
                                                'from_date',
                                                'to_date',
                                                'status',
                                            ]))
                                        <span
                                            class="badge bg-primary me-2">{{ ucfirst(str_replace('_', ' ', $key)) }}:
                                            {{ $value }}</span>
                                    @endif
                                @endforeach
                                <a href="{{ route('dashboard') }}#update"
                                    class="btn btn-sm btn-outline-danger ms-2">Clear All</a>
                            </div>
                        @endif

                        <div class="table_container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>S/L No</th>
                                        <th>File number</th>
                                        <th>On behalf of</th>
                                        <th>Branch</th>
                                        <th>Loan A/C Or Member Or CIN </th>
                                        <th>Mobile Number</th>
                                        <th>Name of the parties</th>
                                        <th>Court Name</th>
                                        <th>Case Number</th>
                                        <th>Legal Notice Date</th>
                                        <th>Filing / Received Date</th>
                                        <th>Previous Date</th>
                                        <th>Previous Step</th>
                                        <th>Next Hearing Date</th>
                                        <th>Next Step</th>
                                        <th>Documents</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="caseTable">
                                    @forelse ($needupdateaddcases as $index => $case)
                                        <tr>
                                            <td>{{ $index + 1 + ($needupdateaddcases->currentPage() - 1) * $needupdateaddcases->perPage() }}
                                            </td>
                                            <td>{{ $case->file_number }}</td>
                                            <td>{{ $case->addclient->name ?? 'N/A' }}</td>
                                            <td>{{ optional($case->clientbranch)->name ?? '' }}</td>
                                            <td>{{ $case->loan_account_acquest_cin ?? '' }}</td>
                                            <td>{{ $case->addclient->number ?? 'N/A' }}</td>
                                            <td>{{ $case->name_of_parties }}</td>
                                            <td> {{ optional($case->court)->name ?? '—' }}</td>
                                            <td>{{ $case->case_number }}</td>
                                            <td>{{ $case->legal_notice_date ? \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>{{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>{{ $case->previous_date ? \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>{{ $case->previous_step }}</td>
                                            <td>{{ $case->next_hearing_date ? \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>{{ $case->next_step }}</td>
                                            <td>
                                                @if ($case->legal_notice)
                                                    <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                        <a href="{{ route('legalnotice.lndownload', $case->id) }}">
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
                                                    <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                        <a href="{{ route('plaints.pldownload', $case->id) }}">
                                                            Plaints <i class="fa-solid fa-download"></i>
                                                        </a>
                                                        <button
                                                            onclick="deleteFile('{{ route('plaints.pldelete', $case->id) }}', 'Plaints')"
                                                            class="btn btn-sm btn-danger py-0 px-1">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                                @if ($case->other_documents)
                                                    <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                        <a
                                                            href="{{ route('otherdocuments.othddownload', $case->id) }}">
                                                            Other Documents <i class="fa-solid fa-download"></i>
                                                        </a>
                                                        <button
                                                            onclick="deleteFile('{{ route('otherdocuments.othddelete', $case->id) }}', 'Other Documents')"
                                                            class="btn btn-sm btn-danger py-0 px-1">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                {!! $case->status == 1
                                                    ? '<span class="badge bg-success">Running</span>'
                                                    : '<span class="badge bg-secondary">Closed</span>' !!}
                                            </td>
                                            <td>
                                                <!-- <a class="btn btn-outline-primary btn-sm" href="{{ route('addcase.edit', Crypt::encrypt($case->id)) }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a> -->
                                                <button class="btn btn-outline-primary btn-sm"
                                                    onclick="openEditModal({{ $case->id }})">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>


                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center text-muted py-4" colspan="16">
                                                <i class="fa fa-inbox fa-2x mb-2"></i><br>
                                                No cases need update
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            @if ($needupdateaddcases->hasPages())
                                <div class="mt-3">
                                    {{ $needupdateaddcases->withQueryString()->fragment('update')->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>



                </div>
            </div>

            <!-- Offcanvas Filter Panel -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="filterCanvas">
                <div class="offcanvas-header bg-dark text-white">
                    <h5 class="offcanvas-title">Filter Need Update Cases</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <form method="GET" action="{{ route('dashboard') }}#update">
                        <div class="mb-3">
                            <label class="form-label">Client Name</label>
                            <div class="position-relative">
                                <!-- Hidden select for form submission -->
                                <select name="client_id" id="clientSelect" class="form-select"
                                    style="display: none;">
                                    <option value="">-- All Clients --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Searchable Dropdown -->
                                <div class="dropdown">
                                    <input type="text" class="form-control rounded" id="clientSearch"
                                        placeholder="Type to search clients..."
                                        value="{{ request('client_id') ? $clients->where('id', request('client_id'))->first()->name ?? '' : '' }}"
                                        data-bs-toggle="dropdown" autocomplete="off">

                                    <div class="dropdown-menu shadow-lg w-100 p-2" id="clientDropdown">
                                        <input type="text" class="form-control form-control-sm mb-2 rounded"
                                            id="clientSearchInput" placeholder="Type to search..."
                                            autocomplete="off">

                                        <div class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;" id="clientList">
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
                                                    @if ($client->number)
                                                        <small class="text-muted ms-2">({{ $client->number }})</small>
                                                    @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Selected client display -->
                                <div id="selectedClient" class="mt-1 small text-muted" style="display: none;">
                                    Selected: <span id="selectedClientName"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Number</label>
                            <input type="text" name="file_number" class="form-control rounded"
                                value="{{ request('file_number') }}" placeholder="File number...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Case Number</label>
                            <input type="text" name="case_number" class="form-control rounded"
                                value="{{ request('case_number') }}" placeholder="Case number...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Court Name</label>
                            <input type="text" name="court_name" class="form-control rounded"
                                value="{{ request('court_name') }}" placeholder="Court name...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Section</label>
                            <input type="text" name="section" class="form-control rounded"
                                value="{{ request('section') }}" placeholder="Section...">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">From Date</label>
                                    <input type="date" name="from_date" class="form-control rounded"
                                        value="{{ request('from_date') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">To Date</label>
                                    <input type="date" name="to_date" class="form-control rounded"
                                        value="{{ request('to_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select rounded">
                                <option value="">All Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Running
                                </option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Closed
                                </option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i> Apply Filter
                            </button>
                            <a href="{{ route('dashboard') }}#update" class="btn btn-outline-danger">
                                <i class="fa fa-refresh"></i> Reset Filter
                            </a>
                        </div>
                    </form>
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
                document.addEventListener('DOMContentLoaded', function() {
                    // Store active tab in sessionStorage
                    const caseTabs = document.getElementById('caseTabs');
                    const storedTab = sessionStorage.getItem('activeCaseTab');

                    if (storedTab) {
                        const tabButton = document.querySelector(`[aria-controls="${storedTab}"]`);
                        if (tabButton) {
                            const tab = new bootstrap.Tab(tabButton);
                            tab.show();
                        }
                    }

                    // Update stored tab when a tab is shown
                    caseTabs.addEventListener('show.bs.tab', function(event) {
                        const activeTab = event.target.getAttribute('aria-controls');
                        sessionStorage.setItem('activeCaseTab', activeTab);
                    });

                    // Update pagination links to preserve tab
                    const currentTab = sessionStorage.getItem('activeCaseTab') || 'today';
                    const paginationLinks = document.querySelectorAll('.pagination a');

                    paginationLinks.forEach(link => {
                        const url = new URL(link.href);
                        url.searchParams.set('tab', currentTab);
                        link.href = url.toString();
                    });
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    initializeClientDropdown();
                });

                function initializeClientDropdown() {
                    const clientSearch = document.getElementById('clientSearch');
                    const clientSearchInput = document.getElementById('clientSearchInput');
                    const clientOptions = document.querySelectorAll('.client-option');
                    const clientSelect = document.getElementById('clientSelect');
                    const selectedClient = document.getElementById('selectedClient');
                    const selectedClientName = document.getElementById('selectedClientName');

                    if (clientSearch) {
                        const clientDropdown = new bootstrap.Dropdown(clientSearch);

                        // Real-time search in dropdown
                        clientSearchInput.addEventListener('input', function() {
                            const term = this.value.toLowerCase().trim();
                            clientOptions.forEach(option => {
                                const text = option.textContent.toLowerCase();
                                option.style.display = text.includes(term) ? 'block' : 'none';
                            });
                        });

                        // Client option selection
                        clientOptions.forEach(option => {
                            option.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const name = this.getAttribute('data-name') || this.textContent;

                                // Update search input
                                clientSearch.value = name;

                                // Update hidden select
                                clientSelect.value = value;

                                // Show selected client
                                if (value) {
                                    selectedClientName.textContent = name;
                                    selectedClient.style.display = 'block';
                                } else {
                                    selectedClient.style.display = 'none';
                                }

                                // Close dropdown
                                clientDropdown.hide();

                                // Clear search input in dropdown
                                clientSearchInput.value = '';

                                // Show all options again
                                clientOptions.forEach(opt => opt.style.display = 'block');
                            });
                        });

                        // Show dropdown and focus on search input
                        clientSearch.addEventListener('shown.bs.dropdown', function() {
                            setTimeout(() => {
                                clientSearchInput.focus();
                            }, 100);
                        });

                        // Clear selection when input is cleared
                        clientSearch.addEventListener('input', function() {
                            if (this.value === '') {
                                clientSelect.value = '';
                                selectedClient.style.display = 'none';

                                // Reset all options to visible
                                clientOptions.forEach(opt => opt.style.display = 'block');
                            }
                        });

                        // Initialize selected client display
                        const selectedOption = document.querySelector('.client-option[data-selected="true"]');
                        if (selectedOption) {
                            const name = selectedOption.getAttribute('data-name') || selectedOption.textContent;
                            selectedClientName.textContent = name;
                            selectedClient.style.display = 'block';
                        }
                    }
                }
            </script>

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

        </div>
</x-app-layout>
