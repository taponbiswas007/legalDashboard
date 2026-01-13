<form id="updateHistoryForm" method="POST">
    @csrf
    <input type="hidden" name="history_id" value="{{ $history->id }}">

    <div class="row g-3">
        <!-- Client Name (Searchable) -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">On Behalf Of <span class="text-danger">*</span></label>
            <div class="position-relative">
                <input type="hidden" name="client_id" id="history_client_id" value="{{ $history->client_id }}"
                    required>
                <input type="text" id="history_client_name" class="form-control rounded"
                    value="{{ $history->addclient->name ?? '' }}" placeholder="Search client..." autocomplete="off"
                    readonly>
                <div class="dropdown-menu border shadow-sm p-0" id="historyClientDropdown"
                    style="width: 100%; max-height: 300px; overflow-y: auto;">
                    <div class="p-2 border-bottom bg-light">
                        <input type="text" id="historyClientSearch" class="form-control rounded form-control "
                            placeholder="Type to search...">
                    </div>
                    <div class="list-group list-group-flush" id="historyClientList">
                        @foreach ($clients as $client)
                            <button type="button" class="list-group-item list-group-item-action"
                                onclick="selectHistoryClient({{ $client->id }}, '{{ $client->name }}')">
                                <i class="fas fa-user me-2"></i>{{ $client->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Branch (Searchable, filtered by client) -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Branch</label>
            <div class="position-relative">
                <input type="hidden" name="branch_id" id="history_branch_id" value="{{ $history->branch_id }}">
                <input type="text" id="history_branch_name" class="form-control rounded"
                    value="{{ $history->clientbranch->name ?? '' }}" placeholder="Search branch..." autocomplete="off"
                    readonly>
                <div class="dropdown-menu border shadow-sm p-0" id="historyBranchDropdown"
                    style="width: 100%; max-height: 300px; overflow-y: auto;">
                    <div class="p-2 border-bottom bg-light">
                        <input type="text" id="historyBranchSearch" class="form-control rounded form-control "
                            placeholder="Type to search...">
                    </div>
                    <div class="list-group list-group-flush" id="historyBranchList">
                        @foreach ($branches as $branch)
                            <button type="button" class="list-group-item list-group-item-action"
                                data-client-id="{{ $branch->client_id }}"
                                onclick="selectHistoryBranch({{ $branch->id }}, '{{ $branch->name }}')">
                                <i class="fas fa-code-branch me-2"></i>{{ $branch->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Account / Acquest CIN -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Loan A/C / Acquest CIN</label>
            <input type="text" name="loan_account_acquest_cin" class="form-control rounded"
                value="{{ $history->loan_account_acquest_cin }}">
        </div>

        <!-- Name of Parties -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Name of Parties</label>
            <input type="text" name="name_of_parties" class="form-control rounded"
                value="{{ $history->name_of_parties }}">
        </div>

        <!-- Court (Searchable) -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Court <span class="text-danger">*</span></label>
            <div class="position-relative">
                <input type="hidden" name="court_id" id="history_court_id" value="{{ $history->court_id }}" required>
                <input type="text" id="history_court_name" class="form-control rounded"
                    value="{{ $history->court->name ?? '' }}" placeholder="Search court..." autocomplete="off"
                    readonly>
                <div class="dropdown-menu border shadow-sm p-0" id="historyCourtDropdown"
                    style="width: 100%; max-height: 300px; overflow-y: auto;">
                    <div class="p-2 border-bottom bg-light">
                        <input type="text" id="historyCourtSearch" class="form-control rounded form-control "
                            placeholder="Type to search...">
                    </div>
                    <div class="list-group list-group-flush" id="historyCourtList">
                        @foreach ($courts as $court)
                            <button type="button" class="list-group-item list-group-item-action"
                                onclick="selectHistoryCourt({{ $court->id }}, '{{ $court->name }}')">
                                <i class="fas fa-gavel me-2"></i>{{ $court->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Case Number -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Case Number <span class="text-danger">*</span></label>
            <input type="text" name="case_number" class="form-control rounded"
                value="{{ $history->case_number }}" required>
        </div>

        <!-- Section -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Section</label>
            <input type="text" name="section" class="form-control rounded" value="{{ $history->section }}">
        </div>

        <!-- Previous Date -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Previous Date</label>
            <input type="date" name="previous_date" class="form-control rounded"
                value="{{ $history->previous_date && $history->previous_date != '0000-00-00' ? \Carbon\Carbon::parse($history->previous_date)->format('Y-m-d') : '' }}">
        </div>

        <!-- Next Hearing Date -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Next Hearing Date</label>
            <input type="date" name="next_hearing_date" class="form-control rounded"
                value="{{ $history->next_hearing_date && $history->next_hearing_date != '0000-00-00' ? \Carbon\Carbon::parse($history->next_hearing_date)->format('Y-m-d') : '' }}">
        </div>

        <!-- Previous Step -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Previous Step</label>
            <textarea name="previous_step" class="form-control rounded" rows="2">{{ $history->previous_step }}</textarea>
        </div>

        <!-- Next Step -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Next Step</label>
            <textarea name="next_step" class="form-control rounded" rows="2">{{ $history->next_step }}</textarea>
        </div>

        <!-- Status -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-control rounded">
                <option value="1" {{ $history->status == 1 ? 'selected' : '' }}>Running</option>
                <option value="0" {{ $history->status == 0 ? 'selected' : '' }}>Dismissed</option>
            </select>
        </div>

        <!-- Filing/Received Date -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Filing/Received Date</label>
            <input type="date" name="filing_or_received_date" class="form-control rounded"
                value="{{ $history->filing_or_received_date && $history->filing_or_received_date != '0000-00-00' ? \Carbon\Carbon::parse($history->filing_or_received_date)->format('Y-m-d') : '' }}">
        </div>

        <!-- Legal Notice Date -->
        <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Legal Notice Date</label>
            <input type="date" name="legal_notice_date" class="form-control rounded"
                value="{{ $history->legal_notice_date && $history->legal_notice_date != '0000-00-00' ? \Carbon\Carbon::parse($history->legal_notice_date)->format('Y-m-d') : '' }}">
        </div>
    </div>

    <div class="modal-footer border-0 mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancel
        </button>
        <button type="submit" class="btn btn-primary" id="saveHistoryButton">
            <i class="fas fa-save me-1"></i>Update History
        </button>
    </div>
</form>
