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
                                Create a case details
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('addcase.index') }}" class="btn btn-primary addBtn">
                        View Case list
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                <div class="add_case_area">
                    <form id="dataSubmit-form" action="{{ route('addcase.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Validation Errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row g-4">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" name="file_number" id="file_name" placeholder="File number"
                                        value="{{ old('file_number') }}">
                                    <label class="form_label" for="">File Number</label>
                                </div>
                                @error('file_number')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group position-relative">
                                    <label class="select_form_label" for="client_id">On Behalf Of</label>
                                    <input type="hidden" id="client_id" name="client_id">

                                    <!-- Main input (styled by your CSS) -->
                                    <input type="text" id="party_name" class="form-control"
                                        placeholder="Select or type a party name" readonly data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                    <!-- Bootstrap dropdown -->
                                    <div class="dropdown-menu shadow w-100 p-2" id="clientDropdown">
                                        <!-- Search inside dropdown -->
                                        <input type="text" class="form-control form-control-sm mb-2"
                                            id="clientSearch" placeholder="Search clients...">

                                        <!-- List -->
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
                                <div class="form_group position-relative">
                                    <label class="select_form_label" for="branch_id">Branch</label>
                                    <input type="hidden" id="branch_id" name="branch_id">

                                    <!-- Main input (styled by your CSS) -->
                                    <input type="text" id="branch_name" class="form-control"
                                        placeholder="Select or type a Branch Name" readonly data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                    <!-- Bootstrap dropdown -->
                                    <div class="dropdown-menu shadow w-100 p-2" id="branchDropdown">
                                        <!-- Search inside dropdown -->
                                        <input type="text" class="form-control form-control-sm mb-2"
                                            id="branchSearch" placeholder="Search branch...">

                                        <!-- List -->
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
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" id="loan_account_acquest_cin"
                                        value="{{ old('loan_account_acquest_cin') }}" name="loan_account_acquest_cin"
                                        placeholder="Loan A/C OR Member OR CIN">
                                    <label class="form_label" for="">Loan A/C OR Member OR CIN</label>
                                </div>

                                @error('loan_account_acquest_cin')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" id="name_of_parties" value="{{ old('name_of_parties') }}"
                                        name="name_of_parties" placeholder=" 	name of the parties">
                                    <label class="form_label" for=""> Name of the Parties</label>
                                </div>

                                @error('name_of_parties')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>
                            {{-- <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form_group">
                            <input type="text" placeholder="Mobile number">
                            <label class="form_label" for="">Mobile Number</label>
                        </div>
                    </div> --}}

                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group position-relative">
                                    <label class="select_form_label" for="court_id">Court Name</label>
                                    <input type="hidden" id="court_id" name="court_id">

                                    <!-- Main input -->
                                    <input type="text" id="court_name" class="form-control"
                                        placeholder="Select or type a court name" readonly data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                    <!-- Bootstrap dropdown -->
                                    <div class="dropdown-menu shadow w-100 p-2" id="courtDropdown">
                                        <!-- Search inside dropdown -->
                                        <input type="text" class="form-control form-control-sm mb-2"
                                            id="courtSearch" placeholder="Search courts...">

                                        <!-- List -->
                                        <div id="courtList" class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($courts as $court)
                                                <button type="button" class="list-group-item list-group-item-action"
                                                    data-id="{{ $court->id }}"
                                                    onclick="selectCourt('{{ $court->id }}', '{{ $court->name }}')">
                                                    {{ $court->name }}
                                                </button>
                                            @endforeach
                                        </div>

                                        <div class="dropdown-divider"></div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                onclick="addNewCourt()">
                                                <i class="fa-solid fa-user-plus me-1"></i> Add New Court
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @error('court_id')
                                    <!-- সংশোধিত -->
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" id="case_number" value="{{ old('case_number') }}"
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
                                    <input type="text" id="section" value="{{ old('section') }}"
                                        name="section" placeholder="Section">
                                    <label class="form_label" for="">Section</label>
                                </div>
                                @error('section')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="date" id="legal_notice_date"
                                        value="{{ old('legal_notice_date') }}" name="legal_notice_date"
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
                                <div class="form_group">
                                    <input type="date" id="filing_or_received_date"
                                        value="{{ old('filing_or_received_date') }}" name="filing_or_received_date"
                                        placeholder="filing or received date">
                                    <label class="form_label" for="">Filing or Received date</label>
                                </div>
                                @error('filing_or_received_date')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form_group">
                            <input type="date" name="previous_date" id="previous_date"
                                value="{{ old('previous_date') }}" placeholder="Previous Date">
                            <label class="form_label" for="">Previous Date</label>
                        </div>
                        @error('previous_date')
    <p class="m-2 text-danger">
                                                {{ $message }}
                                            </p>
@enderror
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form_group">
                            <input type="text" id="previous_step" value="{{ old('previous_step') }}"
                                name="previous_step" placeholder="Previous Step">
                            <label class="form_label" for="">Previous Step</label>
                        </div>
                        @error('previous_step')
    <p class="m-2 text-danger">
                                                {{ $message }}
                                            </p>
@enderror
                    </div> -->




                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="date" id="next_hearing_date"
                                        value="{{ old('next_hearing_date') }}" name="next_hearing_date"
                                        placeholder="Next Hearing Date">
                                    <label class="form_label" for=""> Next Hearing Date</label>
                                </div>
                                @error('next_hearing_date')
                                    <p class="m-2 text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form_group">
                                    <input type="text" id="next_step" value="{{ old('next_step') }}"
                                        name="next_step" placeholder="Next Step">
                                    <label class="form_label" for=""> Next Step</label>
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
                                    <label class="form_label" for=""> Legal Notice</label>
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
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="check_form_group">
                                    <br>
                                    <input class="" type="checkbox" name="status" value="1" checked>
                                    <p>Checked = Active <br> Unchecked = Disposal</p>
                                </div>
                            </div>

                        </div>
                        <button type="button" id="saveButton" class="mt-6 save btn btn-primary">Save</button>
                    </form>

                    <script>
                        document.getElementById('saveButton').addEventListener('click', function(event) {
                            event.preventDefault(); // Prevent default button action

                            Swal.fire({
                                title: "Do you want to save the case?",
                                icon: "question",
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: "Yes, Save it!",
                                denyButtonText: `Don't save`
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Show loading
                                    Swal.fire({
                                        title: 'Saving...',
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

    @push('scripts')
        <script>
            const courtInput = document.getElementById('court_name');
            const searchCourtInput = document.getElementById('courtSearch');
            const courtList = document.getElementById('courtList');
            const courts = {{ Js::from($courts) }};

            // Live search filtering for courts
            searchCourtInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                const buttons = courtList.querySelectorAll('.list-group-item');
                buttons.forEach(btn => {
                    const name = btn.textContent.toLowerCase();
                    btn.style.display = name.includes(term) ? 'block' : 'none';
                });
            });

            // Select court from dropdown - আলাদা ফাংশন
            function selectCourt(id, name) {
                document.getElementById('court_id').value = id;
                courtInput.value = name; // courtInput ব্যবহার করুন
                const bsDropdown = bootstrap.Dropdown.getInstance(courtInput);
                bsDropdown.hide();
            }

            // Add new court
            function addNewCourt() {
                const bsDropdown = bootstrap.Dropdown.getInstance(courtInput);
                bsDropdown.hide();
                window.location.href = "{{ route('courts.index') }}";
            }

            // Initialize dropdown
            new bootstrap.Dropdown(courtInput, {
                autoClose: true
            });

            // Focus search when dropdown opens
            courtInput.addEventListener('click', () => {
                setTimeout(() => searchCourtInput.focus(), 150);
            });
        </script>
        <script>
            const partyInput = document.getElementById('party_name');
            const searchInput = document.getElementById('clientSearch');
            const clientList = document.getElementById('clientList');
            const clients = {{ Js::from($addclients) }};

            // Live search filtering for clients
            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                const buttons = clientList.querySelectorAll('.list-group-item');
                buttons.forEach(btn => {
                    const name = btn.textContent.toLowerCase();
                    btn.style.display = name.includes(term) ? 'block' : 'none';
                });
            });

            // Select client from dropdown - আলাদা ফাংশন
            function selectClient(id, name) {
                document.getElementById('client_id').value = id;
                partyInput.value = name;
                const bsDropdown = bootstrap.Dropdown.getInstance(partyInput);
                bsDropdown.hide();
            }

            // Add new client
            function addNewClient() {
                const bsDropdown = bootstrap.Dropdown.getInstance(partyInput);
                bsDropdown.hide();
                window.location.href = "{{ route('addclient.create') }}";
            }

            // Initialize dropdown
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
            const branches = {{ Js::from($clientbranches) }};

            // Live search filtering for clients
            branchsearchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                const buttons = branchList.querySelectorAll('.list-group-item');
                buttons.forEach(btn => {
                    const name = btn.textContent.toLowerCase();
                    btn.style.display = name.includes(term) ? 'block' : 'none';
                });
            });

            // Select client from dropdown - আলাদা ফাংশন
            function selectBranch(id, name) {
                document.getElementById('branch_id').value = id;
                branchInput.value = name;
                const bsDropdown = bootstrap.Dropdown.getInstance(branchInput);
                bsDropdown.hide();
            }

            // Add new client
            function addNewBranch() {
                const bsDropdown = bootstrap.Dropdown.getInstance(branchInput);
                bsDropdown.hide();
                window.location.href = "{{ route('client.branch.page') }}";
            }

            // Initialize dropdown
            new bootstrap.Dropdown(branchInput, {
                autoClose: true
            });

            // Focus search when dropdown opens
            branchInput.addEventListener('click', () => {
                setTimeout(() => branchsearchInput.focus(), 150);
            });
        </script>
        <script>
            // Function to filter branches based on selected client
            function filterBranchesByClient(clientId) {
                // Get all branch buttons
                const branchButtons = document.querySelectorAll('#branchList button');

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
                // You'll need to add data-client-id attribute to your branch buttons
                const clientBranches = document.querySelectorAll(`#branchList button[data-client-id="${clientId}"]`);
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
                document.getElementById('branch_id').value = '';
                document.getElementById('branch_name').value = '';
            }

            // Modified selectClient function
            function selectClient(clientId, clientName) {
                // Set the hidden input and display input
                document.getElementById('client_id').value = clientId;
                document.getElementById('party_name').value = clientName;

                // Close the dropdown
                const dropdown = new bootstrap.Dropdown(document.getElementById('clientDropdown'));
                dropdown.hide();

                // Filter branches based on selected client
                filterBranchesByClient(clientId);
            }

            // Modified selectBranch function (no changes needed here)
            function selectBranch(branchId, branchName) {
                document.getElementById('branch_id').value = branchId;
                document.getElementById('branch_name').value = branchName;

                const dropdown = new bootstrap.Dropdown(document.getElementById('branchDropdown'));
                dropdown.hide();
            }

            // Clear branch filter when client is cleared
            function clearClientSelection() {
                document.getElementById('client_id').value = '';
                document.getElementById('party_name').value = '';
                filterBranchesByClient(null);
            }

            // Add event listener for client search to maintain functionality
            document.getElementById('clientSearch').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const clientButtons = document.querySelectorAll('#clientList button');

                clientButtons.forEach(button => {
                    const clientName = button.textContent.toLowerCase();
                    if (clientName.includes(searchTerm)) {
                        button.style.display = 'block';
                    } else {
                        button.style.display = 'none';
                    }
                });
            });

            // Add event listener for branch search (modified to work with filtered branches)
            document.getElementById('branchSearch').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const branchButtons = document.querySelectorAll('#branchList button');

                branchButtons.forEach(button => {
                    if (button.style.display !== 'none') { // Only search visible branches
                        const branchName = button.textContent.toLowerCase();
                        if (branchName.includes(searchTerm)) {
                            button.style.display = 'block';
                        } else {
                            button.style.display = 'none';
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
