<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <div class="container-fluid py-4">
        <!-- Welcome Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card bg-gradient-primary rounded-3 p-4 text-white shadow">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="h4 mb-2">
                                <i class="fas fa-gavel me-2"></i>
                                Welcome to Our Law Firm Dashboard
                            </h2>
                          <p class="mb-0 opacity-75">
                            <span id="current-date">
                                {{-- প্রাথমিক তারিখ কার্বন দিয়ে লোড হবে, পরে জাভাস্ক্রিপ্ট আপডেট করবে --}}
                                {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
                            </span>
                            <i class="fas fa-clock me-1"></i>
                            <span id="current-time">
                                {{ \Carbon\Carbon::now()->format('h:i:s A') }}
                            </span>
                        </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="stats-badge bg-white text-black bg-opacity-20 rounded-pill px-3 py-2 d-inline-block">
                                <i class="fas fa-chart-line me-1"></i>
                                {{ $totalCases }} Total Cases
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card metric-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="metric-icon bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="fas fa-gavel text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Cases</h6>
                                <h3 class="mb-0 text-dark">{{ $totalCases }}</h3>
                                <small class="text-success">
                                    <i class="fas fa-chart-line me-1"></i>
                                    All Matters
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card metric-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="metric-icon bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="fas fa-balance-scale text-success fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Active Cases</h6>
                                <h3 class="mb-0 text-dark">{{ $activeCases }}</h3>
                                <small class="text-info">
                                    <i class="fas fa-spinner me-1"></i>
                                    In Progress
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card metric-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="metric-icon bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="fas fa-calendar-day text-warning fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Today's Hearings</h6>
                                <h3 class="mb-0 text-dark">{{ $todaysHearings }}</h3>
                                <small class="text-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    Scheduled
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card metric-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="metric-icon bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="fas fa-calendar-day text-danger fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-danger mb-1">Need Update</h6>
                                <h3 class="mb-0 text-danger">{{ $needupdatecount }}</h3>
                                <small class="text-danger">
                                    <i class="fas fa-clock me-1"></i>
                                    Scheduled
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-xl-3 col-md-6 mb-4">
                <div class="card metric-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="metric-icon bg-info bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="fas fa-user-tie text-info fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Clients</h6>
                                <h3 class="mb-0 text-dark">{{ $totalClients }}</h3>
                                <small class="text-primary">
                                    <i class="fas fa-users me-1"></i>
                                    Active Clients
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-12">
                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-bolt text-primary me-2"></i>
                            Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="action-grid">
                            <a href="{{ route('addcase.create') }}" class="action-card bg-primary text-white rounded-3 p-3 text-center text-decoration-none">
                                <i class="fas fa-plus fa-2x mb-2"></i>
                                <h6 class="mb-0">New Case File</h6>
                            </a>
                            <a href="{{ route('addclient.create') }}" class="action-card bg-info text-white rounded-3 p-3 text-center text-decoration-none">
                                <i class="fas fa-user-plus fa-2x mb-2"></i>
                                <h6 class="mb-0">Add Client</h6>
                            </a>
                            <a href="{{ route('notes.create') }}" class="action-card bg-success text-white rounded-3 p-3 text-center text-decoration-none">
                                <i class="fas fa-sticky-note fa-2x mb-2"></i>
                                <h6 class="mb-0">Add Note</h6>
                            </a>
                            <a href="{{ route('dashboard.daily_work') }}" class="action-card bg-warning text-white rounded-3 p-3 text-center text-decoration-none">
                                <i class="fas fa-calendar fa-2x mb-2"></i>
                                <h6 class="mb-0">Court Calendar</h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-xl-8 col-lg-7">
                <!-- Today's Court Schedule -->
               <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-gavel text-danger me-2"></i>
                            Today's Court Schedule
                        </h5>
                        <span class="badge bg-danger bg-opacity-10 text-danger">
                            {{ $addcases->count() }} {{ $addcases->count() == 1 ? 'Hearing' : 'Hearings' }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-0 overflow-y-auto" style="max-height: 750px">
                    @forelse($addcases as $index => $case)
                    <div class="hearing-item p-3 p-md-4 border-bottom position-relative">
                        <!-- Mobile layout -->
                        <div class="d-md-none">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="file-icon bg-primary bg-opacity-10 rounded-2 p-2 me-2">
                                        <i class="fas fa-file-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark">{{ $case->file_number }}</h6>
                                        @php
                                            $client = $clients->where('id', $case->client_id)->first();
                                        @endphp
                                        <small class="text-muted">{{ $client->name ?? 'N/A' }}</small>
                                    </div>
                                </div>
                                @if($case->next_hearing_date)
                                <div class="time-slot bg-warning bg-opacity-10 rounded-2 p-2 text-center">
                                    <div class="h6 mb-0 text-warning">
                                        {{ \Carbon\Carbon::parse($case->next_hearing_date)->format('h:i A') }}
                                    </div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($case->next_hearing_date)->diffForHumans() }}
                                    </small>
                                </div>
                                @endif
                            </div>
                            
                            <h6 class="mb-2 text-dark">{{ $case->name_of_parties }}</h6>
                            
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="court-tag bg-light rounded-pill px-2 py-1 text-dark small">
                                    <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                                    {{ optional($case->court)->name ?? '—' }}
                                </span>
                                <span class="court-tag bg-light rounded-pill px-2 py-1 text-dark small">
                                    Step: {{ $case->next_step }}
                                </span>
                            </div>
                            
                            @if($case->case_number)
                            <small class="text-muted">Case #: {{ $case->case_number }}</small>
                            @endif
                        </div>
                        
                        <!-- Desktop layout -->
                        <div class="d-none d-md-block">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="file-icon bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="fas fa-file-alt text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-dark">{{ $case->file_number }}</h6>
                                            @php
                                                $client = $clients->where('id', $case->client_id)->first();
                                            @endphp
                                            <h6 class="mb-1 text-dark">{{ $client->name ?? 'N/A' }}</h6>
                                            <span class="court-tag text-dark">
                                                <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                                                {{ optional($case->court)->name ?? '—' }}
                                            </span>
                                            <br>
                                            @if($case->case_number)
                                            <small class="text-muted">{{ $case->case_number }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1 text-dark">{{ $case->name_of_parties }}</h6>
                                    <span class="court-tag bg-light rounded-pill px-3 py-1 text-dark">
                                        Step: {{ $case->next_step }}
                                    </span>
                                </div>
                                <div class="col-md-2 text-center">
                                    @if($case->next_hearing_date)
                                    <div class="time-slot bg-warning bg-opacity-10 rounded-2 p-2 d-inline-block">
                                        <div class="h6 mb-0 text-warning">
                                            {{ \Carbon\Carbon::parse($case->next_hearing_date)->format('h:i A') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($case->next_hearing_date)->diffForHumans() }}
                                        </small>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="{{ route('addcase.show', Crypt::encrypt($case->id)) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <div class="empty-state-icon mb-3">
                            <i class="fas fa-calendar-times fa-3x text-muted"></i>
                        </div>
                        <h5 class="text-muted">No hearings scheduled for today</h5>
                        <p class="text-muted">Take this opportunity to prepare for upcoming cases.</p>
                        <button class="btn btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i> Schedule a Hearing
                        </button>
                    </div>
                    @endforelse
                </div>
                
                @if($addcases->count() > 0)
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Last updated: {{ now()->format('h:i A') }}
                        </small>
                        <a href="{{ route('todayPrintcase') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-print me-1"></i> Print Schedule
                        </a>
                    </div>
                </div>
                @endif
            </div>

            </div>

            <!-- Right Column -->
            <div class="col-xl-4 col-lg-5">
                

                <!-- Recent Notes -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-dark">
                                <i class="fas fa-sticky-note text-info me-2"></i>
                                Recent Notes
                            </h5>
                            <a href="{{ route('notes.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-list me-1"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="notes-feed">
                            @forelse($recentNotes as $note)
                            <div class="note-item mb-3 p-3 border rounded-2">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 text-dark fw-bold fs-6">{{ Str::limit($note->title, 35) }}</h6>
                                    <div class="status-container">
                                        <!-- Custom Status Badge -->
                                        <div class="status-badge {{ strtolower($note->status) }}-status" 
                                                data-id="{{ $note->id }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#statusModal">
                                            <i class="status-icon 
                                                {{ $note->status == 'Pending' ? 'fa-solid fa-clock' : 
                                                    ($note->status == 'Done' ? 'fa-solid fa-check' : 'fa-solid fa-xmark') }}"></i>
                                            <span class="status-text">{{ $note->status }}</span>
                                            <i class="fa-solid fa-chevron-down ms-1 dropdown-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-muted small mb-2">{{ Str::limit(strip_tags($note->description), 70) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $note->created_at->diffForHumans() }}
                                    </small>
                                    <div class="btn-group" role="group">
                                            <!-- Show Button -->
                                            <button class="btn btn-info btn-sm show-btn"
                                                data-id="{{ $note->id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#showModal">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <button class="btn btn-warning btn-sm edit-btn"
                                                data-id="{{ $note->id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $note->id }}"
                                                data-title="{{ $note->title }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-sticky-note fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No recent notes</p>
                            </div>
                            @endforelse
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
                    <h5 class="modal-title" id="showModalLabel">Note Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Title</label>
                            <p id="show_title" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <p id="show_status" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description</label>
                            <div id="show_description" class="border p-3 rounded bg-light"></div>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control rounded" id="edit_title" required>
                            </div>

                            <div class="col-12">
                                <label class="fw-bold fs-5">Write your Note here</label>
                                <!-- Changed ID to avoid conflict -->
                                <textarea class="descriptionarea w-100" name="description" id="edit_description" cols="30" rows="10"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" id="edit_status" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Done">Done</option>
                                    <option value="Reject">Reject</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Case Modal -->
    <div class="modal fade" id="updateCaseModal" tabindex="-1" aria-labelledby="updateCaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-white border-0">
                    <h5 class="modal-title" id="updateCaseModalLabel">
                        <i class="fas fa-edit me-2"></i>
                        Update Case Hearing
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateCaseForm">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Case File Number</label>
                            <input type="text" class="form-control border-0 bg-light" id="modalFileNumber" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="next_hearing_date" class="form-label fw-bold text-dark">Next Hearing Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control border-0 bg-light" id="next_hearing_date" name="next_hearing_date" required>
                            <div class="form-text text-muted">Select the next court hearing date</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="next_step" class="form-label fw-bold text-dark">Next Step <span class="text-danger">*</span></label>
                            <textarea class="form-control border-0 bg-light" id="next_step" name="next_step" rows="3" placeholder="Enter the next legal step or action required..." required></textarea>
                            <div class="form-text text-muted">Describe what needs to be done next</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>
                            Update Case
                        </button>
                    </div>
                </form>
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
                        <div class="status-option pending-option" data-status="Pending">
                            <div class="status-indicator pending-indicator"></div>
                            <i class="fa-solid fa-clock status-option-icon"></i>
                            <span class="status-option-text">Pending</span>
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


    <script>
        // Same JavaScript code as before for the modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const updateCaseModal = new bootstrap.Modal(document.getElementById('updateCaseModal'));
            const updateCaseForm = document.getElementById('updateCaseForm');
            let currentCaseId = '';

            document.querySelectorAll('.update-case-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentCaseId = this.getAttribute('data-case-id');
                    const fileNumber = this.getAttribute('data-file-number');
                    const currentDate = this.getAttribute('data-current-date');
                    const currentStep = this.getAttribute('data-current-step');

                    document.getElementById('modalFileNumber').value = fileNumber;
                    document.getElementById('next_hearing_date').value = currentDate;
                    document.getElementById('next_step').value = currentStep;
                    updateCaseModal.show();
                });
            });

            updateCaseForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                submitBtn.disabled = true;

                fetch(`/cases/${currentCaseId}/update-hearing`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            updateCaseModal.hide();
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update case. Please try again.'
                    });
                })
                .finally(() => {
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                });
            });

            document.getElementById('updateCaseModal').addEventListener('hidden.bs.modal', function() {
                updateCaseForm.reset();
                currentCaseId = '';
            });

            const today = new Date().toISOString().split('T')[0];
            document.getElementById('next_hearing_date').min = today;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status Change Modal
            const statusModal = document.getElementById('statusModal');
            let currentNoteId = null;

            // Status badge click
            document.querySelectorAll('.status-badge').forEach(badge => {
                badge.addEventListener('click', function() {
                    currentNoteId = this.getAttribute('data-id');
                });
            });

            // Status option selection
            document.querySelectorAll('.status-option').forEach(option => {
                option.addEventListener('click', function() {
                    const newStatus = this.getAttribute('data-status');
                    
                    if (!currentNoteId) return;

                    // Update via AJAX
                    fetch(`/notes/${currentNoteId}/status`, {
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
                            const badge = document.querySelector(`.status-badge[data-id="${currentNoteId}"]`);
                            
                            // Remove existing status classes
                            badge.classList.remove('pending-status', 'done-status', 'reject-status');
                            // Add new status class
                            badge.classList.add(`${newStatus.toLowerCase()}-status`);
                            
                            // Update icon and text
                            const iconClass = newStatus === 'Pending' ? 'fa-solid fa-clock' : 
                                            newStatus === 'Done' ? 'fa-solid fa-check' : 'fa-solid fa-xmark';
                            badge.innerHTML = `<i class="status-icon ${iconClass}"></i>
                                            <span class="status-text">${newStatus}</span>
                                            <i class="fa-solid fa-chevron-down ms-1 dropdown-arrow"></i>`;
                            
                            // Hide modal
                            bootstrap.Modal.getInstance(statusModal).hide();
                            
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
                const noteId = button.getAttribute('data-id');
                
                fetch(`/notes/${noteId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const note = data.note;
                            
                            // Populate show modal fields
                            document.getElementById('show_title').textContent = note.title;
                            document.getElementById('show_status').textContent = note.status;
                            document.getElementById('show_description').innerHTML = note.description;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load note data!'
                        });
                    });
            });

            // Edit Modal with TinyMCE initialization
            const editModal = document.getElementById('editModal');
            const editForm = document.getElementById('editForm');
            let editTinyMCEInitialized = false;

            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const noteId = button.getAttribute('data-id');

                // Initialize TinyMCE for edit modal if not already initialized
                if (!editTinyMCEInitialized) {
                    tinymce.init({
                        selector: '#edit_description',
                        height: 300,
                        menubar: false,
                        plugins: [
                            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                            'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                        ],
                        toolbar: 'undo redo | blocks | bold italic underline | ' +
                            'alignleft aligncenter alignright alignjustify | ' +
                            'bullist numlist outdent indent | removeformat | help',
                        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                    });
                    editTinyMCEInitialized = true;
                }

                fetch(`/notes/${noteId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const note = data.note;

                            document.getElementById('edit_title').value = note.title;
                            
                            // Set content in TinyMCE editor
                            if (tinymce.get('edit_description')) {
                                tinymce.get('edit_description').setContent(note.description);
                            } else {
                                // Fallback: set textarea value directly
                                document.getElementById('edit_description').value = note.description;
                            }
                            
                            document.getElementById('edit_status').value = note.status;
                            editForm.action = `/notes/${noteId}`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load note data!'
                        });
                    });
            });

            // Edit Form submit with TinyMCE
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Make sure TinyMCE content is saved to textarea
                if (tinymce.get('edit_description')) {
                    tinymce.triggerSave();
                }

                const formData = new FormData(this);
                const noteId = this.action.split('/').pop();

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(editModal);
                        modal.hide();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
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
                            text: data.message || 'Failed to update note!'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update note!'
                    });
                });
            });

            // Clean up TinyMCE when modal is closed
            editModal.addEventListener('hidden.bs.modal', function() {
                if (tinymce.get('edit_description')) {
                    tinymce.get('edit_description').setContent('');
                }
            });

            // Delete Button
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let id = this.getAttribute('data-id');
                    let title = this.getAttribute('data-title');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You want to delete "${title}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, Delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Use fetch API for delete
                            fetch(`/notes/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    return response.json();
                                }
                                throw new Error('Delete failed');
                            })
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Note deleted successfully.',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    throw new Error('Delete failed');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to delete note!'
                                });
                            });
                        }
                    });
                });
            });
        });
    </script>
    <script>
    function updateClock() {
        // একটি নতুন JavaScript Date অবজেক্ট তৈরি করুন
        const now = new Date();

        // 1. তারিখ ফরম্যাট
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateString = now.toLocaleDateString('en-US', options); // 'l, F j, Y' এর মতো

        // 2. সময় ফরম্যাট (সেকেন্ড সহ)
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
        const timeString = now.toLocaleTimeString('en-US', timeOptions); // 'h:i:s A' এর মতো

        // HTML এলিমেন্টগুলিতে নতুন মান সেট করুন
        document.getElementById('current-date').textContent = dateString;
        document.getElementById('current-time').textContent = timeString;
    }

    // প্রতি 1000 মিলিসেকেন্ডে (1 সেকেন্ডে) একবার updateClock ফাংশনটি চালান
    setInterval(updateClock, 1000);

    // পেজ লোড হওয়ার সাথে সাথে একবার ঘড়ি চালু করুন
    updateClock();
</script>
</x-app-layout>