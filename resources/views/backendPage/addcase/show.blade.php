<x-app-layout>
    <div class="py-6 px-2 body_area">
        <!-- Header Section -->
        <div class="card border-0 shadow-lg mb-6">
            <div class="card-body bg-gradient-primary text-white rounded-lg">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="fw-bold mb-2">Case File Details</h1>
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-alt me-2"></i>
                                <span class="fs-5">File Number: <strong>{{ $file_number }}</strong></span>
                            </div>
                            @if ($case && $case->next_hearing_date)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-day me-2"></i>
                                    <span class="fs-6">Next Hearing:
                                        <strong>{{ \Carbon\Carbon::parse($case->next_hearing_date)->format('d M Y') }}</strong>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="status-badge">
                            @if ($case)
                                {!! $case->status == 1
                                    ? '<span class="badge bg-success fs-6 px-3 py-2"><i class="fas fa-play-circle me-1"></i>Running</span>'
                                    : '<span class="badge bg-secondary fs-6 px-3 py-2"><i class="fas fa-stop-circle me-1"></i>Dismissed</span>' !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Current Case Details -->
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <h3 class="card-title mb-2 mb-md-0">
                                <i class="fas fa-chart-line text-primary me-2"></i>
                                Current Case Status
                            </h3>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-sync-alt me-1"></i>Last Updated:
                                {{ $case ? \Carbon\Carbon::parse($case->updated_at)->format('M d, Y h:i A') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="case-details-mobile">
                            @if ($case)
                                <!-- Mobile View - Stacked Layout -->
                                <div class="d-block d-md-none">
                                    <div class="case-detail-item p-3 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-hashtag text-primary me-2"></i>
                                            <strong class="text-muted">File Number</strong>
                                        </div>
                                        <span class="badge bg-primary text-white fs-6">{{ $case->file_number }}</span>
                                    </div>

                                    <div class="case-detail-item p-3 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-user text-primary me-2"></i>
                                            <strong class="text-muted">Client Information</strong>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="client-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 35px; height: 35px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $case->addclient->name ?? 'N/A' }}</div>
                                                <small class="text-muted"><span class="fw-bold">Mobile:</span>
                                                    {{ $case->addclient->number ?? 'N/A' }}</small>
                                                @if ($case->branch_id && $case->clientbranch)
                                                    <small class="text-muted"><span class="fw-bold">Branch:</span>
                                                        {{ $case->clientbranch->name }}</small>
                                                @endif
                                                @if ($case->loan_account_acquest_cin && $case->loan_account_acquest_cin)
                                                    <small class="text-muted"><span class="fw-bold">Loan A/C / Acquest
                                                            CIN:</span> {{ $case->loan_account_acquest_cin }}</small>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    <div class="case-detail-item p-3 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-users text-primary me-2"></i>
                                            <strong class="text-muted">Parties Involved</strong>
                                        </div>
                                        <div class="parties-text">
                                            {{ $case->name_of_parties }}
                                        </div>
                                    </div>

                                    <div class="case-detail-item p-3 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-building text-primary me-2"></i>
                                            <strong class="text-muted">Branch & Account</strong>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <span class="badge bg-info text-white w-fit">
                                                <i class="fas fa-code-branch me-1"></i>{{ $case->branch }}
                                            </span>
                                            <span class="badge bg-warning text-dark w-fit">
                                                <i
                                                    class="fas fa-file-invoice-dollar me-1"></i>{{ $case->loan_account_acquest_cin }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="case-detail-item p-3 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-gavel text-primary me-2"></i>
                                            <strong class="text-muted">Court Details</strong>
                                        </div>
                                        <div class="court-details">
                                            <div class="mb-2">
                                                <strong>Court:</strong>
                                                <span
                                                    class="text-dark">{{ optional($case->court)->name ?? '—' }}</span>
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <div>
                                                    <strong>Case No:</strong>
                                                    <span
                                                        class="badge bg-secondary ms-1">{{ $case->case_number }}</span>
                                                </div>
                                                <div>
                                                    <strong>Section:</strong>
                                                    <span
                                                        class="badge bg-light text-dark ms-1">{{ $case->section ?? '—' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="case-detail-item p-3 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-calendar text-primary me-2"></i>
                                            <strong class="text-muted">Important Dates</strong>
                                        </div>
                                        <div class="d-flex flex-column gap-3">
                                            <div class="date-card p-2 border rounded">
                                                <small class="text-muted d-block">Legal Notice Date</small>
                                                <strong>{{ $case->legal_notice_date ? \Carbon\Carbon::parse($case->legal_notice_date)->format('d M Y') : '—' }}</strong>
                                            </div>
                                            <div class="date-card p-2 border rounded">
                                                <small class="text-muted d-block">Filing Date</small>
                                                <strong>{{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d M Y') : '—' }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="case-detail-item p-3 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-balance-scale text-primary me-2"></i>
                                            <strong class="text-muted">Hearing Schedule</strong>
                                        </div>
                                        <div class="d-flex flex-column gap-3">
                                            <div class="hearing-card p-2 border rounded">
                                                <small class="text-muted d-block">Previous Hearing</small>
                                                <div class="fw-bold">
                                                    {{ $case->previous_date ? \Carbon\Carbon::parse($case->previous_date)->format('d M Y') : '—' }}
                                                </div>
                                                @if ($case->previous_step)
                                                    <small
                                                        class="text-muted mt-1">{{ Str::limit($case->previous_step, 50) }}</small>
                                                @endif
                                            </div>
                                            <div class="hearing-card p-2 border rounded bg-light-warning">
                                                <small class="text-muted d-block">Next Hearing</small>
                                                <div class="fw-bold text-primary">
                                                    {{ $case->next_hearing_date ? \Carbon\Carbon::parse($case->next_hearing_date)->format('d M Y') : '—' }}
                                                </div>
                                                @if ($case->next_step)
                                                    <small
                                                        class="text-muted mt-1">{{ Str::limit($case->next_step, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="case-detail-item p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-file-pdf text-primary me-2"></i>
                                            <strong class="text-muted">Documents</strong>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            @if ($case->legal_notice)
                                                <a href="{{ route('legalnotice.lndownload', $case->id) }}"
                                                    class="btn btn-outline-primary btn-sm document-btn w-100 text-start">
                                                    <i class="fas fa-download me-2"></i>Legal Notice
                                                </a>
                                            @endif
                                            @if ($case->plaints)
                                                <a href="{{ route('plaints.pldownload', $case->id) }}"
                                                    class="btn btn-outline-success btn-sm document-btn w-100 text-start">
                                                    <i class="fas fa-download me-2"></i>Plaints
                                                </a>
                                            @endif
                                            @if ($case->others_documents)
                                                <a href="{{ route('otherdocuments.othddownload', $case->id) }}"
                                                    class="btn btn-outline-info btn-sm document-btn w-100 text-start">
                                                    <i class="fas fa-download me-2"></i>Other Documents
                                                </a>
                                            @endif
                                            @if (!$case->legal_notice && !$case->plaints && !$case->others_documents)
                                                <span class="text-muted text-center">
                                                    <i class="fas fa-times-circle me-1"></i>No documents available
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Desktop View - Table Layout -->
                                <div class="d-none d-md-block px-2">
                                    <div class="table-responsive">
                                        <table class="table destopview table-hover mb-0 ">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="170">Field</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="fw-semibold text-muted">
                                                        <i class="fas fa-hashtag me-1"></i>File Number
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-primary text-white fs-6">{{ $case->file_number }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">
                                                        <i class="fas fa-user me-1"></i>Client
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="client-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                                style="width: 35px; height: 35px;">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold">
                                                                    {{ $case->addclient->name ?? 'N/A' }}</div>
                                                                <small class="text-muted"><span
                                                                        class="fw-bold">Mobile:</span>
                                                                    {{ $case->addclient->number ?? 'N/A' }}</small>
                                                                @if ($case->branch_id && $case->clientbranch)
                                                                    <small class="text-muted"><span
                                                                            class="fw-bold">Branch:</span>
                                                                        {{ $case->clientbranch->name }}</small>
                                                                @endif
                                                                @if ($case->loan_account_acquest_cin && $case->loan_account_acquest_cin)
                                                                    <small class="text-muted"><span
                                                                            class="fw-bold">Loan A/C / Acquest
                                                                            CIN:</span>
                                                                        {{ $case->loan_account_acquest_cin }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">
                                                        <i class="fas fa-users me-1"></i>Parties
                                                    </td>
                                                    <td>
                                                        <div class="parties-text">
                                                            {{ $case->name_of_parties }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">
                                                        <i class="fas fa-building me-1"></i>Branch & Account
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2 flex-wrap">
                                                            <span class="badge bg-info text-white">
                                                                <i
                                                                    class="fas fa-code-branch me-1"></i>{{ $case->branch }}
                                                            </span>
                                                            <span class="badge bg-warning text-dark">
                                                                <i
                                                                    class="fas fa-file-invoice-dollar me-1"></i>{{ $case->loan_account_acquest_cin }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">
                                                        <i class="fas fa-gavel me-1"></i>Court Details
                                                    </td>
                                                    <td>
                                                        <div class="court-details">
                                                            <div class="mb-1">
                                                                <strong>Court:</strong>
                                                                <span
                                                                    class="text-dark">{{ optional($case->court)->name ?? '—' }}</span>
                                                            </div>
                                                            <div class="d-flex gap-3 flex-wrap">
                                                                <span>
                                                                    <strong>Case No:</strong>
                                                                    <span
                                                                        class="badge bg-secondary">{{ $case->case_number }}</span>
                                                                </span>
                                                                <span>
                                                                    <strong>Section:</strong>
                                                                    <span
                                                                        class="badge bg-light text-dark">{{ $case->section ?? '—' }}</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">
                                                        <i class="fas fa-calendar me-1"></i>Important Dates
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <div class="">
                                                                <div class="date-card p-2 border rounded">
                                                                    <small class="text-muted d-block">Legal
                                                                        Notice</small>
                                                                    <strong>{{ $case->legal_notice_date ? \Carbon\Carbon::parse($case->legal_notice_date)->format('d M Y') : '—' }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="">
                                                                <div class="date-card p-2 border rounded">
                                                                    <small class="text-muted d-block">Filing
                                                                        Date</small>
                                                                    <strong>{{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d M Y') : '—' }}</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">
                                                        <i class="fas fa-balance-scale me-1"></i>Hearing Schedule
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <div class="">
                                                                <div class="hearing-card p-2 border rounded">
                                                                    <small class="text-muted d-block">Previous
                                                                        Hearing</small>
                                                                    <div class="fw-bold">
                                                                        {{ $case->previous_date ? \Carbon\Carbon::parse($case->previous_date)->format('d M Y') : '—' }}
                                                                    </div>
                                                                    @if ($case->previous_step)
                                                                        <small
                                                                            class="text-muted">{{ Str::limit($case->previous_step, 50) }}</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="">
                                                                <div
                                                                    class="hearing-card p-2 border rounded bg-light-warning">
                                                                    <small class="text-muted d-block">Next
                                                                        Hearing</small>
                                                                    <div class="fw-bold text-primary">
                                                                        {{ $case->next_hearing_date ? \Carbon\Carbon::parse($case->next_hearing_date)->format('d M Y') : '—' }}
                                                                    </div>
                                                                    @if ($case->next_step)
                                                                        <small
                                                                            class="text-muted">{{ Str::limit($case->next_step, 50) }}</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">
                                                        <i class="fas fa-file-pdf me-1"></i>Documents
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            @if ($case->legal_notice)
                                                                <a href="{{ route('legalnotice.lndownload', $case->id) }}"
                                                                    class="btn btn-outline-primary btn-sm document-btn">
                                                                    <i class="fas fa-download me-1"></i>Legal Notice
                                                                </a>
                                                            @endif
                                                            @if ($case->plaints)
                                                                <a href="{{ route('plaints.pldownload', $case->id) }}"
                                                                    class="btn btn-outline-success btn-sm document-btn">
                                                                    <i class="fas fa-download me-1"></i>Plaints
                                                                </a>
                                                            @endif
                                                            @if ($case->others_documents)
                                                                <a href="{{ route('otherdocuments.othddownload', $case->id) }}"
                                                                    class="btn btn-outline-info btn-sm document-btn">
                                                                    <i class="fas fa-download me-1"></i>Other Documents
                                                                </a>
                                                            @endif
                                                            @if (!$case->legal_notice && !$case->plaints && !$case->others_documents)
                                                                <span class="text-muted">
                                                                    <i class="fas fa-times-circle me-1"></i>No
                                                                    documents available
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                                    <p class="text-muted">No current case data found</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats & Actions Sidebar -->
            <div class="col-xl-4">
                <!-- Case Statistics -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-pie text-primary me-2"></i>
                            Case Overview
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="stats-grid">
                            <div class="stat-item text-center p-3 border rounded bg-light-primary">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-history fa-2x text-primary"></i>
                                </div>
                                <h3 class="stat-value fw-bold text-primary">{{ $historicalCases->count() }}</h3>
                                <p class="stat-label text-muted mb-0">History Records</p>
                            </div>
                            <div class="stat-item text-center p-3 border rounded bg-light-success">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-calendar-check fa-2x text-success"></i>
                                </div>
                                <h3 class="stat-value fw-bold text-success">
                                    @if ($case && $case->next_hearing_date)
                                        {{ \Carbon\Carbon::parse($case->next_hearing_date)->diffForHumans() }}
                                    @else
                                        —
                                    @endif
                                </h3>
                                <p class="stat-label text-muted mb-0">Next Hearing</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt text-warning me-2"></i>
                            Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <!-- <a href="{{ route('addcase.edit', Crypt::encrypt($case->id)) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Update Case
                            </a> -->
                            <button class="btn btn-primary btn-sm" onclick="openEditModal({{ $case->id }})">
                                <i class="fa fa-edit"></i> Update Case
                            </button>
                            <a href="{{ route('addcase.print', Crypt::encrypt($case->id)) }}" target="_blank"
                                class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-print me-1"></i>Print Summary
                            </a>
                            <button class="btn btn-outline-info btn-sm">
                                <i class="fas fa-share-alt me-1"></i>Share Case
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Client Information -->
                @if ($case && $case->addclient)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-tie text-primary me-2"></i>
                                Client Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="client-info">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="client-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $case->addclient->name }}</h6>
                                        <small class="text-muted">Primary Client</small>
                                    </div>
                                </div>
                                <div class="client-details">
                                    <div class="detail-item mb-2">
                                        <i class="fas fa-phone text-muted me-2"></i>
                                        <span>{{ $case->addclient->number ?? 'N/A' }}</span>
                                    </div>
                                    <div class="detail-item mb-2">
                                        <i class="fas fa-envelope text-muted me-2"></i>
                                        <span>{{ $case->addclient->email ?? 'N/A' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                        <span>{{ $case->addclient->address ?? 'Address not provided' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Case History Timeline (Latest First) -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-stream text-primary me-2"></i>
                    Case History Timeline
                </h3>
                <span class="badge bg-primary">
                    {{ $historicalCases->count() }} Updates
                </span>
            </div>
            <div class="card-body">
                @if ($historicalCases->count() > 0)
                    <div class="timeline">
                        @foreach ($historicalCases->sortByDesc('created_at') as $history)
                            <div class="timeline-item {{ $loop->first ? 'current' : '' }}">
                                <div class="timeline-marker">
                                    @if ($loop->first)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="fas fa-circle"></i>
                                    @endif
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1">
                                            @if ($loop->first)
                                                <i class="fas fa-clock text-warning me-1"></i>Latest Update
                                            @else
                                                <i class="fas fa-history text-muted me-1"></i>Case Update
                                            @endif
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <small class="text-muted me-3">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($history->created_at)->format('d M Y') }}
                                                at {{ \Carbon\Carbon::parse($history->created_at)->format('h:i A') }}
                                            </small>
                                            <!-- Edit Button -->
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary border-0 edit-history-btn me-2"
                                                data-history-id="{{ $history->id }}"
                                                title="Edit this history record">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Delete Button -->
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger border-0 delete-history-btn"
                                                data-history-id="{{ $history->id }}"
                                                data-file-number="{{ $file_number }}"
                                                title="Delete this history record">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="timeline-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-group mb-2">
                                                    <strong>Branch & Loan A/C OR Member OR CIN:</strong>
                                                    <span
                                                        class="text-dark">{{ optional($history->clientbranch)->name ?? '' }}</span>
                                                    <span
                                                        class="text-dark">{{ $history->loan_account_acquest_cin }}</span>
                                                </div>
                                                <div class="info-group mb-2">
                                                    <strong>Court:</strong>
                                                    <span
                                                        class="text-dark">{{ optional($history->court)->name ?? '—' }}</span>
                                                </div>
                                                <div class="info-group mb-2">
                                                    <strong>Case No:</strong>
                                                    <span
                                                        class="badge bg-secondary">{{ $history->case_number }}</span>
                                                </div>
                                                <div class="info-group">
                                                    <strong>Section:</strong>
                                                    <span
                                                        class="badge bg-light text-dark">{{ $history->section ?? '—' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-group mb-2">
                                                    <strong>Previous Date:</strong>
                                                    <span class="text-dark">
                                                        {{ $history->previous_date ? \Carbon\Carbon::parse($history->previous_date)->format('d M Y') : '—' }}
                                                    </span>
                                                </div>
                                                <div class="info-group mb-2">
                                                    <strong>Next Hearing:</strong>
                                                    <span class="fw-bold text-primary">
                                                        {{ $history->next_hearing_date ? \Carbon\Carbon::parse($history->next_hearing_date)->format('d M Y') : '—' }}
                                                    </span>
                                                </div>
                                                <div class="info-group">
                                                    <strong>Status:</strong>
                                                    <span
                                                        class="badge {{ $history->status == 1 ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $history->status == 1 ? 'Running' : 'Dismissed' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($history->previous_step || $history->next_step)
                                            <div class="steps-info mt-3 p-2 bg-light rounded">
                                                <div class="row">
                                                    @if ($history->previous_step)
                                                        <div class="col-md-6">
                                                            <small class="text-muted d-block">Previous Step:</small>
                                                            <span
                                                                class="text-dark">{{ $history->previous_step }}</span>
                                                        </div>
                                                    @endif
                                                    @if ($history->next_step)
                                                        <div class="col-md-6">
                                                            <small class="text-muted d-block">Next Step:</small>
                                                            <span class="text-dark">{{ $history->next_step }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        @if ($history->legal_notice || $history->plaints || $history->others_documents)
                                            <div class="timeline-documents mt-3">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="fas fa-paperclip me-1"></i>Attached Documents:
                                                </small>
                                                <div class="d-flex gap-1 flex-wrap">
                                                    @if ($history->legal_notice)
                                                        <a href="{{ route('legalnotice.olndownload', $history->id) }}"
                                                            class="btn btn-xs btn-outline-primary">
                                                            <i class="fas fa-download me-1"></i>Legal Notice
                                                        </a>
                                                    @endif
                                                    @if ($history->plaints)
                                                        <a href="{{ route('plaints.opldownload', $history->id) }}"
                                                            class="btn btn-xs btn-outline-success">
                                                            <i class="fas fa-download me-1"></i>Plaints
                                                        </a>
                                                    @endif
                                                    @if ($history->others_documents)
                                                        <a href="{{ route('otherdocuments.oothddownload', $history->id) }}"
                                                            class="btn btn-xs btn-outline-info">
                                                            <i class="fas fa-download me-1"></i>Other Documents
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Case History</h5>
                        <p class="text-muted">This case doesn't have any historical records yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit History Modal -->
    <div class="modal fade" id="editHistoryModal" tabindex="-1" aria-labelledby="editHistoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
            style="max-width: unset !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHistoryModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit History Record
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editHistoryModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                        <p class="mt-2 text-muted">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteHistoryModal" tabindex="-1" aria-labelledby="deleteHistoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger" id="deleteHistoryModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this history record?</p>
                    <p class="text-muted small">This action cannot be undone. The history record will be permanently
                        removed.</p>
                    <div class="alert alert-warning small">
                        <i class="fas fa-info-circle me-1"></i>
                        Note: This will only delete the history record, not the current case data.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteHistoryForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i>Delete History Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Success/Error Message Script -->
    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                icon: 'error',
                title: '{{ session('error') }}',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                icon: 'success',
                title: '{{ session('success') }}',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @endif

    <script>
        // Edit history record functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Handle edit button clicks
            document.querySelectorAll('.edit-history-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const historyId = this.getAttribute('data-history-id');
                    openEditHistoryModal(historyId);
                });
            });

            // Optional: Add hover effect to edit buttons
            document.querySelectorAll('.edit-history-btn').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-primary');
                });

                button.addEventListener('mouseleave', function() {
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-outline-primary');
                });
            });
        });

        // Open edit history modal
        function openEditHistoryModal(historyId) {
            fetch(`/addcase/history/${historyId}/edit`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('editHistoryModalBody').innerHTML = html;
                    const modalElement = document.getElementById('editHistoryModal');
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();

                    // Initialize modal JS
                    setTimeout(() => {
                        if (typeof initEditHistoryModalJS === 'function') {
                            initEditHistoryModalJS();
                        }
                    }, 100);
                })
                .catch(error => {
                    console.error('Error loading modal:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load the form. Please try again.'
                    });
                });
        }

        // Handle edit history form submission
        document.addEventListener('submit', function(e) {
            if (e.target.id === 'updateHistoryForm') {
                e.preventDefault();

                const form = e.target;
                const submitBtn = form.querySelector('#saveHistoryButton');
                const originalBtnText = submitBtn.innerHTML;

                // Disable button and show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

                const historyId = form.querySelector('[name="history_id"]').value;

                fetch(`/addcase/history/${historyId}/update`, {
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
                        const modalElement = document.getElementById('editHistoryModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) {
                            modal.hide();
                        }

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'History record updated successfully!',
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
                            text: error.message || 'Failed to update history record. Please try again.'
                        });
                    });
            }
        });

        // Delete history record functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete button clicks
            document.querySelectorAll('.delete-history-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const historyId = this.getAttribute('data-history-id');
                    const fileNumber = this.getAttribute('data-file-number');

                    // Set up the modal
                    const modal = new bootstrap.Modal(document.getElementById(
                        'deleteHistoryModal'));

                    // Set form action
                    const deleteForm = document.getElementById('deleteHistoryForm');
                    deleteForm.action =
                        `/addcase/history/${historyId}/delete?file_number=${fileNumber}`;

                    // Show modal
                    modal.show();
                });
            });

            // Optional: Add hover effect to delete buttons
            document.querySelectorAll('.delete-history-btn').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.classList.remove('btn-outline-danger');
                    this.classList.add('btn-danger');
                });

                button.addEventListener('mouseleave', function() {
                    this.classList.remove('btn-danger');
                    this.classList.add('btn-outline-danger');
                });
            });
        });
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
    </script>

    <script>
        /** =======================
         * Edit History Modal JS
         * ======================= */
        function initEditHistoryModalJS() {
            // =======================
            // CLIENT → BRANCH FILTER
            // =======================
            const selectedClientId = document.getElementById('history_client_id')?.value;

            // Helper function to filter branches
            window.filterHistoryBranchesByClient = function(clientId) {
                const branchButtons = document.querySelectorAll('#historyBranchList button');

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
                filterHistoryBranchesByClient(selectedClientId);
            }

            // =======================
            // CLIENT DROPDOWN
            // =======================
            const clientInput = document.getElementById('history_client_name');
            const clientDropdown = document.getElementById('historyClientDropdown');
            const clientSearch = document.getElementById('historyClientSearch');
            const clientList = document.getElementById('historyClientList');

            if (clientInput) {
                clientInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                    document.getElementById('historyBranchDropdown')?.classList.remove('show');
                    document.getElementById('historyCourtDropdown')?.classList.remove('show');
                    clientDropdown.classList.add('show');
                    setTimeout(() => clientSearch?.focus(), 100);
                });
            }

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
            const branchInput = document.getElementById('history_branch_name');
            const branchDropdown = document.getElementById('historyBranchDropdown');
            const branchSearch = document.getElementById('historyBranchSearch');
            const branchList = document.getElementById('historyBranchList');

            if (branchInput) {
                branchInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                    clientDropdown?.classList.remove('show');
                    document.getElementById('historyCourtDropdown')?.classList.remove('show');
                    branchDropdown.classList.add('show');
                    setTimeout(() => branchSearch?.focus(), 100);
                });
            }

            if (branchSearch) {
                branchSearch.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    branchList.querySelectorAll('.list-group-item').forEach(btn => {
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
            const courtInput = document.getElementById('history_court_name');
            const courtDropdown = document.getElementById('historyCourtDropdown');
            const courtSearch = document.getElementById('historyCourtSearch');
            const courtList = document.getElementById('historyCourtList');

            if (courtInput) {
                courtInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                    clientDropdown?.classList.remove('show');
                    branchDropdown?.classList.remove('show');
                    courtDropdown.classList.add('show');
                    setTimeout(() => courtSearch?.focus(), 100);
                });
            }

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
                const inputs = [clientInput, branchInput, courtInput];

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
            window.selectHistoryClient = function(id, name) {
                document.getElementById('history_client_id').value = id;
                document.getElementById('history_client_name').value = name;
                filterHistoryBranchesByClient(id);
                clientDropdown.classList.remove('show');
            }

            window.selectHistoryBranch = function(branchId, branchName) {
                document.getElementById('history_branch_id').value = branchId;
                document.getElementById('history_branch_name').value = branchName;
                branchDropdown.classList.remove('show');
            }

            window.selectHistoryCourt = function(id, name) {
                document.getElementById('history_court_id').value = id;
                document.getElementById('history_court_name').value = name;
                courtDropdown.classList.remove('show');
            }
        }
    </script>

</x-app-layout>
