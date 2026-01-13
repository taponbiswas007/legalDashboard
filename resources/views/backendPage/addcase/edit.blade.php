<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                    <!-- Breadcrumb Section -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                    <i class="fa-solid fa-house"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Update case information
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('addcase.index') }}" class="btn btn-primary addBtn">
                        Show Case list
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                <div class="add_case_area">
                    <style>
                        /* Hide next_hearing_wrap when status checkbox is unchecked */
                        #status_checkbox:not(:checked)~.row #next_hearing_wrap {
                            display: none !important;
                        }

                        /* Hide next_step area when transfer checkbox is checked */
                        #transfer_checkbox_hidden:checked~.row #next_step_wrap {
                            display: none !important;
                        }

                        /* Custom checkbox styling - unchecked state */
                        .custom-checkbox-box {
                            border-color: #cbd5e1 !important;
                            background-color: white !important;
                        }

                        .custom-checkbox-check {
                            opacity: 0 !important;
                            transform: scale(0) !important;
                        }

                        .check_form_group {
                            border-left: 4px solid #ef4444 !important;
                        }

                        .status-running {
                            opacity: 0.6 !important;
                        }

                        .status-disposal {
                            opacity: 1 !important;
                        }

                        /* Checked state styling */
                        #status_checkbox:checked~.row .check_form_group {
                            border-left-color: #10b981 !important;
                        }

                        #status_checkbox:checked~.row .check_form_group .custom-checkbox-box {
                            border-color: #10b981 !important;
                            background-color: #10b981 !important;
                        }

                        #status_checkbox:checked~.row .check_form_group .custom-checkbox-check {
                            opacity: 1 !important;
                            transform: scale(1) !important;
                        }

                        #status_checkbox:checked~.row .check_form_group .status-running {
                            opacity: 1 !important;
                        }

                        #status_checkbox:checked~.row .check_form_group .status-disposal {
                            opacity: 0.6 !important;
                        }

                        .case_status {
                            display: block !important;
                        }

                        #status_checkbox:checked~.row .check_form_group .case_status {
                            display: none !important;
                        }

                        #transfer_checkbox:checked~.row #next_step_wrap {
                            display: none !important;
                        }

                        /* Styling for disabled transfer checkbox */
                        #transfer_checkbox_visible:disabled {
                            opacity: 0.5 !important;
                            cursor: not-allowed !important;
                        }

                        #transfer_checkbox_visible:disabled+label {
                            opacity: 0.5 !important;
                            cursor: not-allowed !important;
                        }
                    </style>
                    <form id="dataSubmit-form" action="{{ route('addcase.update', $addcase->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        {{-- Status checkbox moved here for CSS sibling selector to work --}}
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" id="status_checkbox"
                            {{ $addcase->status == 1 ? 'checked' : '' }} style="display:none;">

                        {{-- Transfer checkbox moved here for CSS sibling selector to work --}}
                        <input type="checkbox" name="transfer_checkbox" id="transfer_checkbox" style="display:none;">

                        <div class="row g-4">
                            <div class="col-12">
                                <div class="check_form_group p-2"
                                    style="
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                        border-radius: 12px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                        border: 1px solid #e2e8f0;
                        transition: all 0.3s ease;
                    ">
                                    {{-- Visual label for hidden checkbox --}}
                                    <label for="status_checkbox" class="d-flex align-items-center"
                                        style="
                            cursor: pointer;
                            user-select: none;
                            padding: 8px 12px;
                            border-radius: 8px;
                            transition: background-color 0.2s;
                        ">
                                        <span class="custom-checkbox-box me-3"
                                            style="
                                position: relative;
                                width: 28px;
                                height: 28px;
                                border-radius: 6px;
                                background: white;
                                border: 2px solid #cbd5e1;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                transition: all 0.3s ease;
                            ">
                                            <span class="custom-checkbox-check"
                                                style="
                                    opacity: 0;
                                    transform: scale(0);
                                    transition: all 0.3s ease;
                                    color: white;
                                    font-size: 16px;
                                    font-weight: bold;
                                ">
                                                ✓
                                            </span>
                                        </span>
                                        <span
                                            style="
                                font-weight: 600;
                                font-size: 1.1rem;
                                color: #334155;
                            ">Case
                                            Status</span>

                                        <!-- Hidden actual checkbox -->
                                        <input type="checkbox" id="status_checkbox" style="display: none;">
                                    </label>

                                    <div class="mt-3 d-flex flex-column flex-md-row justify-content-md-between"
                                        style="
                            gap: 1rem;
                            padding: 12px 16px;
                            background: white;
                            border-radius: 8px;
                            border-left: 4px solid #cbd5e1;
                        ">
                                        <div class=" status-running"
                                            style="
                                display: flex;
                                align-items: center;
                                gap: 8px;
                            ">
                                            <span
                                                style="
                                    display: inline-block;
                                    width: 12px;
                                    height: 12px;
                                    border-radius: 50%;
                                    background: #10b981;
                                "></span>
                                            <span style="color: #475569; font-weight: 500;">Checked = Case is
                                                Running</span>
                                        </div>

                                        <div class=" status-disposal"
                                            style="
                                display: flex;
                                align-items: center;
                                flex-wrap: wrap;
                                gap: 8px;
                            ">
                                            <div class="d-flex justify-content-start gap-2 align-items-center">
                                                <span
                                                    style="
                                    flex-shrink: 0;
                                    width: 12px;
                                    height: 12px;
                                    border-radius: 50%;
                                    background: #ef4444;
                                "></span>
                                                <span style="color: #475569; font-weight: 500;flex-shrink: 0;">Unchecked
                                                    = Case is
                                                    Disposal</span>
                                            </div>
                                            <select class="form-select case_status w-100 rounded" name="case_status"
                                                id="case_status" style="min-width: 200px">
                                                <option value="Withdraw">Withdraw</option>
                                                <option value="Judgement">Judgement</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="checkbox" id="transfer_checkbox_visible" style="margin-right: 5px;"
                                        onchange="handleTransferCheckbox(this)">
                                    <label for="transfer_checkbox_visible" class="mb-0 text-nowrap text-danger"
                                        style="cursor: pointer;">Case Transfer</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group position-relative">
                                    <label class="select_form_label" for="client_id">On behalf Of</label>
                                    <input type="hidden" id="client_id" name="client_id"
                                        value="{{ $addcase->client_id }}">

                                    <!-- Main input -->
                                    <input type="text" id="party_name" class="form-control"
                                        placeholder="Select or type a party name" readonly data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        value="{{ optional($addclients->where('id', $addcase->client_id)->first())->name ?? '' }}">

                                    <!-- Bootstrap dropdown -->
                                    <div class="dropdown-menu shadow w-100 p-2" id="clientDropdown">
                                        <!-- Search input -->
                                        <input type="text" class="form-control form-control-sm mb-2"
                                            id="clientSearch" placeholder="Search clients...">

                                        <!-- List of clients -->
                                        <div id="clientList" class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($addclients as $addclient)
                                                <button type="button" class="list-group-item list-group-item-action"
                                                    data-id="{{ $addclient->id }}"
                                                    onclick="selectClient('{{ $addclient->id }}', '{{ $addclient->name }}')">
                                                    {{ $addclient->name }}
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
                                </div>

                                @error('client_id')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group ">
                                    <input type="text" name="file_number" id="file_name"
                                        placeholder="File number" value="{{ $addcase->file_number }}">
                                    <label class="form_label" for="">File number</label>
                                </div>
                                @error('file_number')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <h1 class=" d-none"
                                    style="font-size: 12px;
                            color: #000000;">
                                    File Number: <br> <span
                                        style="color: rgb(21, 0, 255); font-weight: 500; font-size: 15px">
                                        {{ $addcase->file_number }}</span>
                                </h1>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group ">
                                    <label class="select_form_label" for="name_of_parties">Name of the parties</label>
                                    <input list="parties" name="name_of_parties" id="name_of_parties"
                                        placeholder="Select or type a party name"
                                        value="{{ $addcase->name_of_parties }}" />

                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group position-relative">
                                    <label class="select_form_label" for="branch_id">Branch</label>
                                    <input type="hidden" id="branch_id" name="branch_id"
                                        value="{{ $addcase->branch_id }}">

                                    <!-- Main input -->
                                    <input type="text" id="branch_name" class="form-control"
                                        placeholder="Select or type a Branch" readonly data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        value="{{ optional($clientbranches->where('id', $addcase->branch_id)->first())->name ?? '' }}">

                                    <!-- Bootstrap dropdown -->
                                    <div class="dropdown-menu shadow w-100 p-2" id="branchDropdown">
                                        <!-- Search input -->
                                        <input type="text" class="form-control form-control-sm mb-2"
                                            id="branchSearch" placeholder="Search branch...">

                                        <!-- List of clients -->
                                        <!-- Your current HTML is correct -->
                                        <div id="branchList" class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($clientbranches as $clientbranch)
                                                <button type="button" class="list-group-item list-group-item-action"
                                                    data-id="{{ $clientbranch->id }}"
                                                    data-client-id="{{ $clientbranch->client_id }}"
                                                    onclick="selectBranch('{{ $clientbranch->id }}', '{{ $clientbranch->name }}')">
                                                    {{ $clientbranch->name }}
                                                </button>
                                            @endforeach
                                        </div>

                                        <div class="dropdown-divider"></div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                onclick="addNewBranch()">
                                                <i class="fa-solid fa-user-plus me-1"></i> Add New Branch
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @error('branch_id')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group ">
                                    <label class="select_form_label" for="loan_account_acquest_cin">
                                        Loan A/C OR Member OR CIN
                                    </label>
                                    <input name="loan_account_acquest_cin" id="loan_account_acquest_cin"
                                        placeholder="Loan A/C OR Member OR CIN"
                                        value="{{ $addcase->loan_account_acquest_cin }}" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group position-relative">
                                    <label class="select_form_label" for="court_id">Court Name</label>
                                    <input type="hidden" id="court_id" name="court_id"
                                        value="{{ $addcase->court_id }}">

                                    <!-- Main input -->
                                    <input type="text" id="court_input" class="form-control"
                                        placeholder="Select or type a court name" autocomplete="off"
                                        value="{{ optional($courts->where('id', $addcase->court_id)->first())->name ?? '' }}">

                                    <!-- Dropdown -->
                                    <div class="dropdown-menu shadow w-100 p-2" id="courtDropdown">
                                        <!-- Search input -->
                                        <input type="text" class="form-control form-control-sm mb-2"
                                            id="courtSearch" placeholder="Search courts...">

                                        <!-- List of courts -->
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

                                        <div class="dropdown-divider"></div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                onclick="addNewCourt()">
                                                <i class="fa-solid fa-plus me-1"></i> Add New Court
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @error('court_id')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>



                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group ">
                                    <input type="date" name="legal_notice_date" id="legal_notice_date"
                                        value="{{ $addcase->legal_notice_date ? $addcase->legal_notice_date->format('Y-m-d') : '' }}"
                                        placeholder="legal notice date">
                                    <label class="form_label" for="">Legal Notice Date</label>
                                </div>
                                @error('legal_notice_date')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group ">
                                    <input type="date" name="filing_or_received_date" id="filing_or_received_date"
                                        value="{{ $addcase->filing_or_received_date ? $addcase->filing_or_received_date->format('Y-m-d') : '' }}"
                                        placeholder="Filing or received date">
                                    <label class="form_label" for="">Filing or received date</label>
                                </div>
                                @error('filing_or_received_date')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" id="case_number" value="{{ $addcase->case_number }}"
                                        name="case_number" placeholder="Case Number">
                                    <label class="form_label" for="">Case Number</label>
                                </div>
                                @error('case_number')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" id="section" value="{{ $addcase->section }}"
                                        name="section" placeholder="Section">
                                    <label class="form_label" for="">Section</label>
                                </div>
                                @error('section')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-none">
                                <div class="form_group">
                                    <input type="date" name="previous_date" id="previous_date"
                                        value="{{ $addcase->previous_date }}" placeholder="Previous Date">
                                    <label class="form_label" for="">Previous Date</label>
                                </div>
                                @error('previous_date')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-none">
                                <div class="form_group">
                                    <input type="text" id="previous_step" value="{{ $addcase->previous_step }}"
                                        name="previous_step" placeholder="Previous Step">
                                    <label class="form_label" for="">Previous Step</label>
                                </div>
                                @error('previous_step')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>




                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3" id="next_hearing_wrap">
                                <div class="d-flex justify-content-between align-items-center flex-column">
                                    <div class="form_group w-100">

                                        <input type="date" id="next_hearing_date" name="next_hearing_date"
                                            value="{{ $addcase->next_hearing_date ? $addcase->next_hearing_date->format('Y-m-d') : '' }}"
                                            placeholder="Next Hearing Date">
                                        <label class="form_label" for="">Next Hearing Date</label>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <label for="nh_checkbox" class="mb-0 ms-2 text-nowrap text-danger">Enable
                                            History Insert</label>
                                        <input type="checkbox" class="ms-2 rounded" name="nh_checkbox"
                                            id="nh_checkbox" checked>
                                    </div>
                                </div>

                                @error('next_hearing_date')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3" id="next_step_wrap">
                                <div class="d-flex justify-content-between align-items-center flex-column">
                                    <div class="form_group w-100">
                                        <input type="text" id="next_step" value="{{ $addcase->next_step }}"
                                            name="next_step" placeholder="Next Step">
                                        <label class="form_label" for="">Next Step</label>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <label for="n_a_checkbox" class="mb-0 ms-2 text-nowrap text-danger">Set
                                            Previous Step</label>
                                        <input type="checkbox" class="ms-2 rounded" name="n_a_checkbox"
                                            id="n_a_checkbox" checked>
                                    </div>

                                </div>

                                @error('next_step')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="file" id="legal_notice" name="legal_notice"
                                        placeholder="Legal notice">
                                    <label class="form_label" for=""> Legal notice</label>
                                </div>
                                @error('legal_notice')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="file" id="plaints" name="plaints" placeholder=" 	Plaints">
                                    <label class="form_label" for=""> Plaints</label>
                                </div>
                                @error('plaints')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="file" id="others_documents" name="others_documents"
                                        placeholder=" 	Others Documents">
                                    <label class="form_label" for=""> Others Documents</label>
                                </div>
                                @error('others_documents')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <!-- <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="check_form_group">
                                <input class="" type="checkbox" name="status"
                                    {{ $addcase->status == 1 ? 'checked' : '' }}>
                                <p>Checked =Case is Running <br> unchecked = Case is disposal</p>
                            </div>
                        </div> -->

                        </div>
                        <button type="button" id="saveButton" class="mt-6 save btn btn-primary">Update</button>
                    </form>

                </div>

                <!-- File upload and edit hearing date modal -->
                <div id="updateModal" style="display: none;">
                    <form id="updateCaseForm">
                        <label for="nextHearingDate">Next Hearing Date:</label>
                        <input type="date" id="nextHearingDate" name="nextHearingDate" required>

                        <label for="caseFile">Upload Case File:</label>
                        <input type="file" id="caseFile" name="caseFile" required>

                        <button type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <script>
        // Initialize transfer checkbox state based on case status on page load
        document.addEventListener('DOMContentLoaded', function() {
            const statusCheckbox = document.getElementById('status_checkbox');
            const transferCheckboxVisible = document.getElementById('transfer_checkbox_visible');

            // If status is unchecked (disposal case), disable transfer checkbox
            if (!statusCheckbox.checked) {
                transferCheckboxVisible.disabled = true;
            }
        });

        // Handle transfer checkbox with confirmation
        function handleTransferCheckbox(checkbox) {
            if (checkbox.checked) {
                // Show confirmation when transfer is being enabled
                Swal.fire({
                    title: 'Confirm Case Transfer',
                    html: '<p style="font-size: 15px;">Are you sure you want to transfer this case to another court?</p><p style="color: #666; font-size: 13px;">This action will mark the case as transferred.</p>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Transfer it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enable transfer
                        document.getElementById('transfer_checkbox').checked = true;
                        Swal.fire({
                            title: 'Transfer Confirmed',
                            text: 'This case will be transferred upon update.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        // Revert the checkbox
                        checkbox.checked = false;
                        document.getElementById('transfer_checkbox').checked = false;
                    }
                });
            } else {
                document.getElementById('transfer_checkbox').checked = false;
            }
        }

        // Handle status checkbox (disposal) with confirmation
        document.getElementById('status_checkbox').addEventListener('change', function() {
            if (!this.checked) {
                // Show confirmation when unchecking (marking as disposal)
                Swal.fire({
                    title: 'Confirm Case Disposal',
                    html: '<p style="font-size: 15px;">Are you sure this case is finished?</p><p style="color: #666; font-size: 13px;">Once a case is marked as disposed, it will no longer be considered as an active case and cannot be reversed.</p>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Mark as Disposed',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Keep the checkbox unchecked (disposal)
                        // Disable transfer checkbox for disposed cases
                        document.getElementById('transfer_checkbox_visible').disabled = true;
                        document.getElementById('transfer_checkbox_visible').checked = false;
                        document.getElementById('transfer_checkbox').checked = false;

                        Swal.fire({
                            title: 'Case Disposed',
                            text: 'This case has been marked as disposed. Case transfer option has been disabled.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        // Revert the checkbox back to checked
                        this.checked = true;
                    }
                });
            } else {
                // When checking (marking as running), enable transfer checkbox
                document.getElementById('transfer_checkbox_visible').disabled = false;
            }
        });

        document.getElementById('saveButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default button action

            Swal.fire({
                title: "Update Case Information",
                html: '<p style="font-size: 15px;">Do you want to save the changes to this case?</p>',
                icon: "question",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes, Update it!",
                denyButtonText: `Don't Update`,
                confirmButtonColor: '#3085d6',
                denyButtonColor: '#6b7280',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the form
                    document.getElementById('dataSubmit-form').submit();
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        });
    </script>
    <script>
        // Function to filter branches based on selected client
        function filterBranchesByClient(clientId) {
            const branchButtons = document.querySelectorAll('#branchList button');
            console.log('Filtering branches for client:', clientId);

            // Show all branches if no client selected
            if (!clientId) {
                branchButtons.forEach(button => {
                    button.style.display = 'block';
                });
                return;
            }

            // Hide all, then show only matching client branches
            branchButtons.forEach(button => {
                const buttonClientId = button.getAttribute('data-client-id');
                console.log('Branch:', button.textContent, 'Client ID:', buttonClientId);

                if (buttonClientId === clientId) {
                    button.style.display = 'block';
                } else {
                    button.style.display = 'none';
                }
            });
        }

        // Modified selectClient function
        function selectClient(clientId, clientName) {
            document.getElementById('client_id').value = clientId;
            document.getElementById('party_name').value = clientName;

            // Filter branches
            filterBranchesByClient(clientId);

            // Close dropdown
            const dropdown = bootstrap.Dropdown.getInstance(document.getElementById('clientDropdown'));
            if (dropdown) {
                dropdown.hide();
            }
        }

        // Existing selectBranch function
        function selectBranch(branchId, branchName) {
            document.getElementById('branch_id').value = branchId;
            document.getElementById('branch_name').value = branchName;

            const dropdown = bootstrap.Dropdown.getInstance(document.getElementById('branchDropdown'));
            if (dropdown) {
                dropdown.hide();
            }
        }

        // Initialize on page load - THIS IS THE KEY FIX
        document.addEventListener('DOMContentLoaded', function() {
            // Get the currently selected client ID from the hidden input
            const selectedClientId = document.getElementById('client_id').value;
            console.log('Page loaded with client ID:', selectedClientId);

            // If there's a selected client, filter branches accordingly
            if (selectedClientId) {
                filterBranchesByClient(selectedClientId);
            }
        });
    </script>

    <script>
        const partyInput = document.getElementById('party_name');
        const searchInput = document.getElementById('clientSearch');
        const clientList = document.getElementById('clientList');
        const clients = {{ Js::from($addclients) }};

        // Live search filter
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            const buttons = clientList.querySelectorAll('.list-group-item');
            buttons.forEach(btn => {
                const name = btn.textContent.toLowerCase();
                btn.style.display = name.includes(term) ? 'block' : 'none';
            });
        });

        // Select client - UPDATED VERSION
        function selectClient(id, name) {
            document.getElementById('client_id').value = id;
            partyInput.value = name;

            // Filter branches when client is selected
            filterBranchesByClient(id);

            const bsDropdown = bootstrap.Dropdown.getInstance(partyInput);
            if (bsDropdown) {
                bsDropdown.hide();
            }
        }

        // Add new client (redirect or modal)
        function addNewClient() {
            const bsDropdown = bootstrap.Dropdown.getInstance(partyInput);
            if (bsDropdown) {
                bsDropdown.hide();
            }
            window.location.href = "{{ route('addclient.create') }}";
        }

        // Initialize Bootstrap dropdown
        new bootstrap.Dropdown(partyInput, {
            autoClose: true
        });

        // Focus search when dropdown opens
        partyInput.addEventListener('click', () => {
            setTimeout(() => searchInput.focus(), 150);
        });
    </script>

    <script>
        const branchInput = document.getElementById('branch_name');
        const branchsearchInput = document.getElementById('branchSearch');
        const branchList = document.getElementById('branchList');
        const branchs = {{ Js::from($clientbranches) }};

        // Live search filter - UPDATED VERSION
        branchsearchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            const buttons = branchList.querySelectorAll('.list-group-item');
            buttons.forEach(btn => {
                // Only search through visible branches (after client filter)
                if (btn.style.display !== 'none') {
                    const name = btn.textContent.toLowerCase();
                    btn.style.display = name.includes(term) ? 'block' : 'none';
                }
            });
        });

        // Select branch function - already defined above

        // Add new branch (redirect or modal)
        function addNewBranch() {
            const bsDropdown = bootstrap.Dropdown.getInstance(branchInput);
            if (bsDropdown) {
                bsDropdown.hide();
            }
            window.location.href = "{{ route('client.branch.page') }}";
        }

        // Initialize Bootstrap dropdown
        new bootstrap.Dropdown(branchInput, {
            autoClose: true
        });

        // Focus search when dropdown opens
        branchInput.addEventListener('click', () => {
            setTimeout(() => branchsearchInput.focus(), 150);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const courtInput = document.getElementById('court_input');
            const courtDropdown = document.getElementById('courtDropdown');
            const courtSearch = document.getElementById('courtSearch');
            const courtList = document.getElementById('courtList');
            const courtIdInput = document.getElementById('court_id');

            // Open dropdown when clicking input
            courtInput.addEventListener('click', () => {
                courtDropdown.classList.add('show');
                courtSearch.focus();
            });

            // Filter courts in real-time
            courtSearch.addEventListener('input', () => {
                const filter = courtSearch.value.toLowerCase();
                courtList.querySelectorAll('button').forEach(btn => {
                    btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'block' :
                        'none';
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!courtInput.contains(e.target) && !courtDropdown.contains(e.target)) {
                    courtDropdown.classList.remove('show');
                }
            });
        });

        // Function to select a court
        function selectCourt(id, name) {
            document.getElementById('court_input').value = name;
            document.getElementById('court_id').value = id;
            document.getElementById('courtDropdown').classList.remove('show');
        }

        // Optional: function to add a new court
        function addNewCourt() {
            // Example: redirect to court create page
            window.location.href = '/courts/create';
        }
    </script>


</x-app-layout>
