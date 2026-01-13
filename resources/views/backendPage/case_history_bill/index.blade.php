<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-primary fw-bold">
                                <i class="fa-solid fa-filter me-2"></i>Billing Case Filter
                            </h4>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="clearAllData()">
                                    <i class="fa-solid fa-arrow-rotate-right me-1"></i>Clear All
                                </button>
                                <button class="btn btn-primary btn-sm" type="submit" form="filterForm">
                                    <i class="fa-solid fa-filter me-1"></i>Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- FILTER FORM -->
                        <form method="GET" action="{{ route('casehistory.bill.index') }}" id="filterForm">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Client Name</label>
                                    <div class="dropdown position-relative">
                                        <input type="hidden" name="client_id" id="client_id"
                                            value="{{ request('client_id') }}">
                                        <input type="text" id="clientSearchInput"
                                            class="form-control border shadow-sm" placeholder="Search client..."
                                            autocomplete="off">
                                        <span class="position-absolute top-50 end-0 translate-middle-y me-2 text-muted">
                                            <i class="fa-solid fa-angle-down"></i>
                                        </span>
                                        <div class="dropdown-menu w-100 mt-1 p-0 border shadow-sm" id="clientDropdown"
                                            style="max-height:200px; overflow-y:auto; display: none;">
                                            @foreach ($clients as $client)
                                                <button class="dropdown-item client-item py-2"
                                                    data-id="{{ $client->id }}" data-name="{{ $client->name }}"
                                                    data-branches="{{ $client->branches->pluck('id')->implode(',') }}">
                                                    <i class="fa-regular fa-address-card me-2"></i>{{ $client->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Branch</label>
                                    <div class="dropdown position-relative">
                                        <input type="hidden" name="branch_id" id="branch_id"
                                            value="{{ request('branch_id') }}">
                                        <input type="text" id="branchSearchInput"
                                            class="form-control border shadow-sm" placeholder="Search branch..."
                                            autocomplete="off" disabled>
                                        <span class="position-absolute top-50 end-0 translate-middle-y me-2 text-muted">
                                            <i class="fa-solid fa-angle-down"></i>
                                        </span>
                                        <div class="dropdown-menu w-100 mt-1 p-0 border shadow-sm" id="branchDropdown"
                                            style="max-height:200px; overflow-y:auto; display: none;">
                                            @foreach ($branches as $branch)
                                                <button class="dropdown-item branch-item py-2"
                                                    data-id="{{ $branch->id }}" data-name="{{ $branch->name }}"
                                                    data-client-id="{{ $branch->client_id }}">
                                                    <i class="fa-regular fa-address-card me-2"></i>{{ $branch->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">From Date</label>
                                    <div class="input-group">
                                        <input type="date" name="from_date" value="{{ request('from_date') }}"
                                            class="form-control border shadow-sm" id="from_date">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">To Date</label>
                                    <div class="input-group">
                                        <input type="date" name="to_date" value="{{ request('to_date') }}"
                                            class="form-control border shadow-sm" id="to_date">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESULTS TABLE -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary fw-bold">
                                <i class="bi bi-table me-2"></i>Make Invoice
                            </h5>
                            <div class="form-group mb-3">
                                <label>Invoice Number</label>
                                <input type="text" class="form-control" value="{{ $nextInvoiceNo }}" readonly>
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-3 border fw-semibold text-muted">#</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">On behalf Of</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Branch</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Loan A/C or Member or CIN
                                        </th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Name Of the Parties</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Case Number & Court Name
                                        </th>
                                        <!-- <th class="py-3 px-3 border fw-semibold text-muted">Hearing Date</th> -->
                                        <th class="py-3 px-3 border fw-semibold text-muted">Prev. Date & Step</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Next Date & Step</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Step</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $item)
                                        <tr class="border-bottom">
                                            <td class="py-3 px-3">{{ $loop->iteration }}</td>
                                            <td class="py-3 px-3">
                                                <span class="fw-medium">{{ $item->client->name ?? '' }}</span>
                                            </td>
                                            <td class="py-3 px-3">{{ $item->clientbranch->name ?? '' }}</td>
                                            <td class="py-3 px-3">{{ $item->loan_account_acquest_cin ?? '' }}</td>
                                            <td class="py-3 px-3">{{ $item->name_of_parties ?? '' }}</td>
                                            <td class="py-3 px-3">
                                                <span class="badge bg-primary">{{ $item->case_number }}</span>
                                                <br>
                                                <span class="text-muted">{{ $item->court->name ?? '' }}</span>
                                            </td>
                                            <!-- <td>
                                        @if ($item->previous_date)
<span class="badge bg-light text-dark">
                                                {{ date('d/m/Y', strtotime($item->previous_date)) }}
                                            </span>
@endif
                                    </td> -->

                                            <td class="py-3 px-3">
                                                @if ($item->previous_date)
                                                    <span class="badge bg-light text-dark">
                                                        {{ date('d/m/Y', strtotime($item->previous_date)) }}
                                                    </span> <br>
                                                    <span class="badge bg-primary">
                                                        {{ $item->previous_step }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-3">
                                                @if ($item->next_hearing_date)
                                                    <span class="badge bg-light text-dark">
                                                        {{ date('d/m/Y', strtotime($item->next_hearing_date)) }}
                                                    </span>
                                                @endif <br>
                                                @if ($item->next_step)
                                                    <span class="badge bg-primary">
                                                        {{ $item->next_step }}
                                                    </span>
                                                @endif

                                            </td>
                                            <td class="py-3 px-3">
                                                <div class="step-wrapper" data-case-id="{{ $item->case_number }}"
                                                    data-case-db-id="{{ $item->id }}"
                                                    data-hearing-date="{{ $item->previous_date }}">
                                                    <div class="step-rows mb-2"></div>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary add-step-btn"
                                                        data-case-id="{{ $item->case_number }}"
                                                        data-case-db-id="{{ $item->id }}">
                                                        <i class="fa-solid fa-plus me-1"></i>Add Step
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HIDDEN TEMPLATE -->
        <div id="step-template" class="d-none">
            <div class="step-row d-flex gap-2 mt-2 align-items-center">
                <input type="text" class="form-control form-control-sm border shadow-sm step-name"
                    placeholder="Step Name">
                <input type="number" class="form-control form-control-sm border shadow-sm step-rate"
                    placeholder="Rate">
                <button type="button" class="btn btn-outline-danger btn-sm remove-step-btn">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>

        <!-- SUMMARY -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary fw-bold">
                            <i class="fa-solid fa-receipt me-2"></i>Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 pb-4">
                                <h1 class="py-3 fw-semibold text-muted">
                                    Total Amount
                                </h1>
                                <p class="mt-3"><span id="totalAmount" class="fw-bold fs-5 text-success">0</span>
                                    BDT</p>
                                <h1 class="pt-3 fw-semibold text-muted">
                                    Total (In Words)
                                </h1>
                                <p class="mt-3"><span id="totalInWords" class="fst-italic text-muted">Zero taka
                                        only</span></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Job Title</label>
                                <input type="text" name="jobtitle" class="form-control border shadow-sm"
                                    placeholder="Enter Job Title" id="jobtitle">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" name="address" class="form-control border shadow-sm"
                                    placeholder="Enter Address" id="address">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Subject</label>
                                <input type="text" name="subject" class="form-control border shadow-sm"
                                    placeholder="Enter Subject" id="subject">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PDF BUTTON -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <!-- PDF FORM -->
                    <form action="{{ route('casehistory.bill.store') }}" method="POST" id="pdfForm">
                        @csrf
                        <input type="hidden" name="steps_data" id="stepsData">
                        <input type="hidden" name="jobtitle_data" id="jobtitleData">
                        <input type="hidden" name="address_data" id="addressData">
                        <input type="hidden" name="subject_data" id="subjectData">

                        <!-- unique IDs for PDF form -->
                        <input type="hidden" name="client_id" id="pdf_client_id">
                        <input type="hidden" name="branch_id" id="pdf_branch_id">
                        <input type="hidden" name="from_date" id="pdf_from_date">
                        <input type="hidden" name="to_date" id="pdf_to_date">

                        <button class="btn btn-success px-4" type="submit">
                            <i class="fa-regular fa-file-pdf me-2"></i>Generate Bill
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 12px;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .form-control,
        .input-group-text {
            border-radius: 8px;
        }

        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        .badge {
            border-radius: 6px;
            font-weight: 500;
        }

        .step-row input {
            border-radius: 6px;
            min-width: 140px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
    </style>

    <script>
        // Local Storage Keys
        const STORAGE_KEYS = {
            FILTER_DATA: 'bill_filter_data',
            STEPS_DATA: 'bill_steps_data',
            SUMMARY_DATA: 'bill_summary_data'
        };

        /* --------------------------
            LOCAL STORAGE FUNCTIONS
        --------------------------- */
        function saveFilterData() {
            const filterData = {
                client_id: document.getElementById('client_id').value,
                client_name: document.getElementById('clientSearchInput').value,
                branch_id: document.getElementById('branch_id').value,
                branch_name: document.getElementById('branchSearchInput').value,
                from_date: document.getElementById('from_date').value,
                to_date: document.getElementById('to_date').value
            };
            localStorage.setItem(STORAGE_KEYS.FILTER_DATA, JSON.stringify(filterData));
        }

        function saveStepsData() {
            const stepsData = [];
            document.querySelectorAll('.step-wrapper').forEach(wrapper => {
                const caseNumber = wrapper.dataset.caseId;
                const caseDbId = wrapper.dataset.caseDbId;
                const hearingDate = wrapper.dataset.hearingDate || '';

                const steps = [];
                wrapper.querySelectorAll('.step-row').forEach(row => {
                    const name = row.querySelector('.step-name').value.trim();
                    const rate = row.querySelector('.step-rate').value.trim();
                    if (name !== "") {
                        steps.push({
                            name: name,
                            rate: rate === "" ? "0" : rate
                        });
                    }
                });

                if (steps.length > 0) {
                    stepsData.push({
                        case_number: caseNumber,
                        case_db_id: caseDbId,
                        hearing_date: hearingDate,
                        steps: steps
                    });
                }
            });

            localStorage.setItem(STORAGE_KEYS.STEPS_DATA, JSON.stringify(stepsData));
        }

        function saveSummaryData() {
            const summaryData = {
                jobtitle: document.getElementById('jobtitle').value,
                address: document.getElementById('address').value,
                subject: document.getElementById('subject').value,
                total_amount: document.getElementById('totalAmount').textContent
            };
            localStorage.setItem(STORAGE_KEYS.SUMMARY_DATA, JSON.stringify(summaryData));
        }

        function loadSavedData() {
            // Load filter data
            const savedFilterData = localStorage.getItem(STORAGE_KEYS.FILTER_DATA);
            if (savedFilterData) {
                const filterData = JSON.parse(savedFilterData);
                document.getElementById('client_id').value = filterData.client_id;
                document.getElementById('clientSearchInput').value = filterData.client_name;
                document.getElementById('branch_id').value = filterData.branch_id;
                document.getElementById('branchSearchInput').value = filterData.branch_name;
                document.getElementById('from_date').value = filterData.from_date;
                document.getElementById('to_date').value = filterData.to_date;

                // Enable branch search if client is selected
                if (filterData.client_id) {
                    document.getElementById('branchSearchInput').disabled = false;
                    filterBranchesByClient(filterData.client_id);
                }
            }

            // Load summary data
            const savedSummaryData = localStorage.getItem(STORAGE_KEYS.SUMMARY_DATA);
            if (savedSummaryData) {
                const summaryData = JSON.parse(savedSummaryData);
                document.getElementById('jobtitle').value = summaryData.jobtitle || '';
                document.getElementById('address').value = summaryData.address || '';
                document.getElementById('subject').value = summaryData.subject || '';
            }

            // Steps data will be loaded after page renders
        }

        function restoreStepsData() {
            const savedStepsData = localStorage.getItem(STORAGE_KEYS.STEPS_DATA);
            if (savedStepsData) {
                const stepsData = JSON.parse(savedStepsData);

                stepsData.forEach(caseData => {
                    const wrapper = document.querySelector(`.step-wrapper[data-case-id="${caseData.case_number}"]`);
                    if (wrapper) {
                        const stepRows = wrapper.querySelector('.step-rows');
                        caseData.steps.forEach(step => {
                            const template = document.querySelector("#step-template .step-row").cloneNode(
                                true);
                            template.querySelector('.step-name').value = step.name;
                            template.querySelector('.step-rate').value = step.rate;
                            stepRows.appendChild(template);

                            // Attach event listeners
                            template.querySelector('.step-rate').addEventListener('input', calculateTotal);
                            template.querySelector('.remove-step-btn').addEventListener('click',
                                function() {
                                    this.closest('.step-row').remove();
                                    calculateTotal();
                                    saveStepsData();
                                });
                        });
                    }
                });

                calculateTotal();
            }
        }

        function clearAllData() {
            if (confirm('Are you sure you want to clear all saved data? This will remove all filters and steps.')) {
                localStorage.removeItem(STORAGE_KEYS.FILTER_DATA);
                localStorage.removeItem(STORAGE_KEYS.STEPS_DATA);
                localStorage.removeItem(STORAGE_KEYS.SUMMARY_DATA);
                window.location.href = '{{ route('casehistory.bill.index') }}';
            }
        }

        /* ================================
            CLIENT → BRANCH FILTER SYSTEM
        ================================= */

        const clientSearchInput = document.getElementById('clientSearchInput');
        const clientDropdown = document.getElementById('clientDropdown');
        const hiddenClientId = document.getElementById('client_id');
        const branchSearchInput = document.getElementById('branchSearchInput');
        const branchDropdown = document.getElementById('branchDropdown');
        const hiddenBranchId = document.getElementById('branch_id');

        const clientOptions = document.querySelectorAll(".client-item");
        const branchOptions = document.querySelectorAll(".branch-item");

        /* ---------- CLIENT SELECT ---------- */
        clientOptions.forEach(option => {
            option.addEventListener("click", function() {

                const clientId = this.dataset.id || "";
                const clientName = this.dataset.name || this.innerText;

                // set client
                clientSearchInput.value = clientName;
                hiddenClientId.value = clientId;

                // reset branch
                branchSearchInput.value = "";
                hiddenBranchId.value = "";

                // filter branch list
                filterBranches(clientId);

                // hide client dropdown
                clientDropdown.style.display = 'none';

                // show branch dropdown if branches exist
                const visibleBranches = document.querySelectorAll('.branch-item[data-client-id="' +
                    clientId + '"]');
                if (visibleBranches.length > 0) {
                    branchDropdown.style.display = 'block';
                }

                saveFilterData();
            });
        });

        /* ---------- BRANCH DROPDOWN OPEN ---------- */
        branchSearchInput.addEventListener("click", function() {
            const clientId = hiddenClientId.value;
            if (clientId) {
                filterBranches(clientId);
            }
        });

        /* ---------- BRANCH SELECT ---------- */
        branchOptions.forEach(option => {
            option.addEventListener("click", function() {

                branchSearchInput.value = this.dataset.name || this.innerText;
                hiddenBranchId.value = this.dataset.id || "";

                branchDropdown.style.display = 'none';
                saveFilterData();
            });
        });

        /* ---------- FILTER FUNCTION ---------- */
        function filterBranches(clientId) {
            branchOptions.forEach(option => {

                const optionClientId = option.dataset.clientId;

                // no client → show all
                if (!clientId) {
                    option.style.display = "";
                }
                // matched client
                else if (optionClientId == clientId) {
                    option.style.display = "";
                }
                // hide others
                else {
                    option.style.display = "none";
                }
            });
        }

        /* --------------------------
            CLIENT SEARCH DROPDOWN
        --------------------------- */

        // Client dropdown functionality
        clientSearchInput.addEventListener('focus', () => {
            clientDropdown.style.display = 'block';
        });

        clientSearchInput.addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            document.querySelectorAll('.client-item').forEach(item => {
                item.style.display = item.dataset.name.toLowerCase().includes(filter) ? "block" : "none";
            });
        });

        // Branch dropdown functionality
        branchSearchInput.addEventListener('focus', () => {
            if (!branchSearchInput.disabled) {
                branchDropdown.style.display = 'block';
            }
        });

        branchSearchInput.addEventListener('input', function() {
            if (branchSearchInput.disabled) return;

            let filter = this.value.toLowerCase();
            document.querySelectorAll('.branch-item').forEach(item => {
                const isVisible = item.dataset.name.toLowerCase().includes(filter);
                item.style.display = isVisible ? "block" : "none";
            });
        });

        document.querySelectorAll('.branch-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                hiddenBranchId.value = this.dataset.id;
                branchSearchInput.value = this.dataset.name;
                branchDropdown.style.display = 'none';
                saveFilterData();
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!clientSearchInput.contains(e.target) && !clientDropdown.contains(e.target)) {
                clientDropdown.style.display = 'none';
            }
            if (!branchSearchInput.contains(e.target) && !branchDropdown.contains(e.target)) {
                branchDropdown.style.display = 'none';
            }
        });

        // Save filter data on date change
        document.getElementById('from_date').addEventListener('change', saveFilterData);
        document.getElementById('to_date').addEventListener('change', saveFilterData);

        /* --------------------------
            ADD / REMOVE STEP ROWS
        --------------------------- */
        document.addEventListener("DOMContentLoaded", function() {
            // Load saved data when page loads
            loadSavedData();

            // Restore steps after a short delay to ensure page is rendered
            setTimeout(restoreStepsData, 100);

            document.querySelectorAll(".add-step-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    let wrapper = this.closest(".step-wrapper").querySelector(".step-rows");
                    let template = document.querySelector("#step-template .step-row").cloneNode(
                        true);
                    wrapper.appendChild(template);

                    // Attach calculator to new rate input
                    template.querySelector(".step-rate").addEventListener("input", function() {
                        calculateTotal();
                        saveStepsData();
                    });

                    // Attach remove button functionality
                    template.querySelector(".remove-step-btn").addEventListener("click",
                        function() {
                            this.closest(".step-row").remove();
                            calculateTotal();
                            saveStepsData();
                        });

                    // Save steps on name input
                    template.querySelector(".step-name").addEventListener("input", saveStepsData);

                    calculateTotal();
                    saveStepsData();
                });
            });

            document.addEventListener("click", function(e) {
                if (e.target.closest(".remove-step-btn")) {
                    e.target.closest(".step-row").remove();
                    calculateTotal();
                    saveStepsData();
                }
            });
        });

        /* --------------------------
            NUMBER TO WORDS (IMPROVED)
        --------------------------- */
        function numberToWords(num) {
            const a = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
                'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
            ];
            const b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

            if (num === 0) return "zero";

            function convert(n) {
                if (n < 20) return a[n];
                if (n < 100) return b[Math.floor(n / 10)] + " " + a[n % 10];
                if (n < 1000) return a[Math.floor(n / 100)] + " hundred " + convert(n % 100);
                return "";
            }

            let words = "";

            if (num >= 10000000) {
                words += convert(Math.floor(num / 10000000)) + " crore ";
                num %= 10000000;
            }
            if (num >= 100000) {
                words += convert(Math.floor(num / 100000)) + " lakh ";
                num %= 100000;
            }
            if (num >= 1000) {
                words += convert(Math.floor(num / 1000)) + " thousand ";
                num %= 1000;
            }
            if (num > 0) words += convert(num);

            return words.trim().replace(/\s+/g, " ");
        }

        /* --------------------------
            TOTAL CALCULATION
        --------------------------- */
        function calculateTotal() {
            let total = 0;

            document.querySelectorAll('.step-rate').forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            document.getElementById('totalAmount').innerHTML = total.toLocaleString();
            document.getElementById('totalInWords').innerHTML =
                total > 0 ? numberToWords(total) + " taka only" : "Zero taka only";

            saveSummaryData();
        }

        // Save summary data on input
        document.getElementById('jobtitle').addEventListener('input', saveSummaryData);
        document.getElementById('address').addEventListener('input', saveSummaryData);
        document.getElementById('subject').addEventListener('input', saveSummaryData);

        /* --------------------------
            SEND DATA TO PDF FORM
        --------------------------- */
        document.getElementById('pdfForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Disable button to prevent multiple clicks
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Generating Bill...';

            // Steps - Array based solution to handle duplicate case numbers
            let allSteps = [];
            let hasValidSteps = false;
            let stepCounter = 0;

            document.querySelectorAll('.step-wrapper').forEach(wrapper => {
                let caseNumber = wrapper.dataset.caseId;
                let caseDbId = wrapper.dataset.caseDbId;
                let hearingDate = wrapper.dataset.hearingDate || '';

                wrapper.querySelectorAll('.step-row').forEach(row => {
                    let name = row.querySelector('.step-name').value.trim();
                    let rate = row.querySelector('.step-rate').value.trim();

                    if (name !== "") {
                        allSteps.push({
                            case_number: caseNumber,
                            case_db_id: caseDbId,
                            hearing_date: hearingDate,
                            name: name,
                            rate: rate === "" ? "0" : rate,
                            row_index: stepCounter
                        });
                        hasValidSteps = true;
                        stepCounter++;
                    }
                });
            });

            // Validate if steps exist
            if (!hasValidSteps) {
                alert('Please add at least one step before generating bill.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-regular fa-file-pdf me-2"></i>Generate Bill';
                return;
            }

            document.getElementById('stepsData').value = JSON.stringify(allSteps);

            // Job info
            document.getElementById('jobtitleData').value = document.getElementById('jobtitle').value.trim();
            document.getElementById('addressData').value = document.getElementById('address').value.trim();
            document.getElementById('subjectData').value = document.getElementById('subject').value.trim();

            // Filter form data
            let filterClient = document.getElementById('client_id').value || '';
            let filterBranch = document.getElementById('branch_id').value || '';
            let filterFromDate = document.getElementById('from_date').value || '';
            let filterToDate = document.getElementById('to_date').value || '';

            // Assign to PDF form hidden inputs
            document.getElementById('pdf_client_id').value = filterClient;
            document.getElementById('pdf_branch_id').value = filterBranch;
            document.getElementById('pdf_from_date').value = filterFromDate;
            document.getElementById('pdf_to_date').value = filterToDate;

            // Show confirmation with step count
            const uniqueCases = [...new Set(allSteps.map(step => step.case_number))];
            const confirmationMessage = `You are about to generate bill for:\n\n` +
                `- Total Steps: ${allSteps.length}\n` +
                `- Unique Cases: ${uniqueCases.length}\n` +
                `- Cases: ${uniqueCases.join(', ')}\n\n` +
                `Continue?`;

            if (!confirm(confirmationMessage)) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-regular fa-file-pdf me-2"></i>Generate Bill';
                return;
            }

            // Clear local storage after successful bill generation
            localStorage.removeItem(STORAGE_KEYS.FILTER_DATA);
            localStorage.removeItem(STORAGE_KEYS.STEPS_DATA);
            localStorage.removeItem(STORAGE_KEYS.SUMMARY_DATA);

            // Submit form after a small delay to ensure button state is updated
            setTimeout(() => {
                this.submit();
            }, 1000);
        });

        // Success message display
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showToast('success', '{{ session('success') }}');
            @endif

            @if (session('error'))
                showToast('error', '{{ session('error') }}');
            @endif

            @if (session('warning'))
                showToast('warning', '{{ session('warning') }}');
            @endif
        });

        function showToast(type, message) {
            // Simple alert or use your preferred toast library
            const alertClass = type === 'success' ? 'alert-success' :
                type === 'error' ? 'alert-danger' : 'alert-warning';

            // Create toast element
            const toast = document.createElement('div');
            toast.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                <strong>${type.toUpperCase()}:</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 5000);
        }
    </script>
</x-app-layout>
