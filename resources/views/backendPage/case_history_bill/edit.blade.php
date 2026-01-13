<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-primary fw-bold">
                                <i class="fa-solid fa-edit me-2"></i>Edit Bill - {{ $bill->invoice_number }}
                            </h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('bill.preview', $bill->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye me-1"></i>Preview
                                </a>
                                <a href="{{ route('case_bill.list') }}" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-arrow-left me-1"></i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- BILL INFO -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Invoice Number</label>
                                <input type="text" class="form-control" value="{{ $bill->invoice_number }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Client</label>
                                <input type="text" class="form-control" value="{{ $bill->client->name ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Branch</label>
                                <input type="text" class="form-control"
                                    value="{{ $bill->clientbranch->name ?? 'N/A' }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Bill Date</label>
                                <input type="text" class="form-control"
                                    value="{{ $bill->created_at->format('d-M-Y') }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESULTS TABLE -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary fw-bold">
                            <i class="bi bi-table me-2"></i>Edit Bill Steps
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-3 border fw-semibold text-muted">#</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Client</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Branch / Loan A/C</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Hearing Date</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Case Number</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Court</th>
                                        <th class="py-3 px-3 border fw-semibold text-muted">Step</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($caseHistories) && count($caseHistories))
                                        @php
                                            // Group case histories by case_number AND hearing_date
                                            $groupedCases = [];
                                            foreach ($caseHistories as $item) {
                                                $key = $item->case_number . '_' . ($item->previous_date ?? 'no_date');
                                                if (!isset($groupedCases[$key])) {
                                                    $groupedCases[$key] = [
                                                        'case_number' => $item->case_number,
                                                        'hearing_date' => $item->previous_date,
                                                        'items' => [],
                                                    ];
                                                }
                                                $groupedCases[$key]['items'][] = $item;
                                            }
                                        @endphp

                                        @foreach ($groupedCases as $groupKey => $group)
                                            @php
                                                $firstItem = $group['items'][0];
                                                $existingSteps = $bill->billSteps ?? $bill->steps;
                                                // Get steps for this specific case number AND hearing date
                                                $stepsForThisCase = $existingSteps
                                                    ->where('case_number', $group['case_number'])
                                                    ->where('hearing_date', $group['hearing_date']);
                                            @endphp

                                            <tr class="border-bottom">
                                                <td class="py-3 px-3">{{ $loop->iteration }}</td>
                                                <td class="py-3 px-3">
                                                    <span class="fw-medium">{{ $firstItem->client->name ?? '' }}</span>
                                                </td>
                                                <td class="py-3 px-3">
                                                    {{ $firstItem->branch ?? $firstItem->loan_account_acquest_cin }}
                                                </td>
                                                <td class="py-3 px-3">
                                                    @if ($group['hearing_date'] && $group['hearing_date'] != 'no_date')
                                                        <span class="badge bg-light text-dark">
                                                            {{ date('d/m/Y', strtotime($group['hearing_date'])) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">No Date</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-3">
                                                    <span class="badge bg-primary">{{ $group['case_number'] }}</span>
                                                </td>
                                                <td class="py-3 px-3">
                                                    {{ $firstItem->court->name ?? '' }}
                                                </td>
                                                <td class="py-3 px-3">
                                                    <div class="step-wrapper"
                                                        data-case-id="{{ $group['case_number'] }}"
                                                        data-case-db-id="{{ $firstItem->id }}"
                                                        data-hearing-date="{{ $group['hearing_date'] }}">
                                                        <div class="step-rows mb-2">
                                                            <!-- Load existing steps for this specific case and hearing date -->
                                                            @foreach ($stepsForThisCase as $step)
                                                                <div
                                                                    class="step-row d-flex gap-2 mt-2 align-items-center">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm border shadow-sm step-name"
                                                                        placeholder="Step Name"
                                                                        value="{{ $step->step_name }}">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm border shadow-sm step-rate"
                                                                        placeholder="Rate" value="{{ $step->rate }}">
                                                                    <button type="button"
                                                                        class="btn btn-outline-danger btn-sm remove-step-btn">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-primary add-step-btn"
                                                            data-case-id="{{ $group['case_number'] }}"
                                                            data-case-db-id="{{ $firstItem->id }}">
                                                            <i class="fa-solid fa-plus me-1"></i>Add Step
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                No case histories found for this bill.
                                            </td>
                                        </tr>
                                    @endif
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
                                <p class="mt-3"><span id="totalAmount"
                                        class="fw-bold fs-5 text-success">{{ number_format($bill->total_amount, 2) }}</span>
                                    BDT</p>
                                <h1 class="pt-3 fw-semibold text-muted">
                                    Total (In Words)
                                </h1>
                                <p class="mt-3"><span id="totalInWords" class="fst-italic text-muted">
                                        @php
                                            echo $bill->total_amount > 0
                                                ? \App\Helpers\NumberHelper::numberToWords((int) $bill->total_amount) .
                                                    ' taka only'
                                                : 'Zero taka only';
                                        @endphp
                                    </span></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Job Title</label>
                                <input type="text" name="jobtitle" class="form-control border shadow-sm"
                                    placeholder="Enter Job Title" id="jobtitle" value="{{ $bill->jobtitle }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" name="address" class="form-control border shadow-sm"
                                    placeholder="Enter Address" id="address" value="{{ $bill->address }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Subject</label>
                                <input type="text" name="subject" class="form-control border shadow-sm"
                                    placeholder="Enter Subject" id="subject" value="{{ $bill->subject }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- UPDATE BUTTON -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('case_bill.list') }}" class="btn btn-secondary px-4">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </a>
                    <!-- UPDATE FORM -->
                    <form action="{{ route('bill.update', $bill->id) }}" method="POST" id="updateForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="steps_data" id="stepsData">
                        <input type="hidden" name="jobtitle_data" id="jobtitleData">
                        <input type="hidden" name="address_data" id="addressData">
                        <input type="hidden" name="subject_data" id="subjectData">

                        <button class="btn btn-success px-4" type="submit" id="updateBtn">
                            <i class="fa-solid fa-save me-2"></i>Update Bill
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
            border: 1px solid #d4d4d4;
        }

        .table th {
            border: 1px solid #d4d4d4;
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

        .swal2-popup {
            border-radius: 12px;
        }
    </style>

    <script>
        /* --------------------------
                NUMBER TO WORDS (JAVASCRIPT VERSION)
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
            ADD / REMOVE STEP ROWS
        --------------------------- */
        document.addEventListener("DOMContentLoaded", function() {
            // Calculate initial total
            calculateTotal();

            document.querySelectorAll(".add-step-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    let wrapper = this.closest(".step-wrapper").querySelector(".step-rows");
                    let template = document.querySelector("#step-template .step-row").cloneNode(
                        true);
                    wrapper.appendChild(template);

                    // Attach calculator to new rate input
                    template.querySelector(".step-rate").addEventListener("input", calculateTotal);

                    // Attach remove button functionality
                    template.querySelector(".remove-step-btn").addEventListener("click",
                function() {
                        this.closest(".step-row").remove();
                        calculateTotal();
                    });

                    calculateTotal();
                });
            });

            // Attach event listeners to existing step inputs
            document.querySelectorAll('.step-rate').forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            document.addEventListener("click", function(e) {
                if (e.target.closest(".remove-step-btn")) {
                    e.target.closest(".step-row").remove();
                    calculateTotal();
                }
            });
        });

        /* --------------------------
            TOTAL CALCULATION
        --------------------------- */
        function calculateTotal() {
            let total = 0;

            document.querySelectorAll('.step-rate').forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            // Update total amount display
            document.getElementById('totalAmount').textContent = total.toLocaleString();

            // Update total in words
            document.getElementById('totalInWords').textContent =
                total > 0 ? numberToWords(total) + " taka only" : "Zero taka only";
        }

        /* --------------------------
            SEND DATA TO UPDATE FORM WITH SWEETALERT2
        --------------------------- */
        document.getElementById('updateForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Collect steps data
            let allSteps = [];
            let hasValidSteps = false;

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
                            rate: rate === "" ? "0" : rate
                        });
                        hasValidSteps = true;
                    }
                });
            });

            // Validate if steps exist
            if (!hasValidSteps) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Steps Found',
                    text: 'Please add at least one step before updating bill.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Set form data
            document.getElementById('stepsData').value = JSON.stringify(allSteps);
            document.getElementById('jobtitleData').value = document.getElementById('jobtitle').value.trim();
            document.getElementById('addressData').value = document.getElementById('address').value.trim();
            document.getElementById('subjectData').value = document.getElementById('subject').value.trim();

            // Prepare confirmation data
            const uniqueCases = [...new Set(allSteps.map(step => step.case_number))];
            const totalAmount = allSteps.reduce((sum, step) => sum + parseFloat(step.rate || 0), 0);

            // Show beautiful confirmation modal
            Swal.fire({
                title: '<strong>Confirm Bill Update</strong>',
                icon: 'question',
                html: `
                    <div class="text-start">
                        <div class="mb-3">
                            <h6 class="fw-bold text-primary">Bill Summary:</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Total Steps:</small>
                                    <div class="fw-semibold">${allSteps.length}</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Unique Cases:</small>
                                    <div class="fw-semibold">${uniqueCases.length}</div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <small class="text-muted">Total Amount:</small>
                                    <div class="fw-bold text-success">${totalAmount.toLocaleString()} BDT</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Invoice No:</small>
                                    <div class="fw-semibold">{{ $bill->invoice_number }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold text-primary">Case Details:</h6>
                            <div class="bg-light p-2 rounded small">
                                ${uniqueCases.map(caseNum => `
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="badge bg-primary">${caseNum}</span>
                                            <span class="text-muted">
                                                ${allSteps.filter(step => step.case_number === caseNum).length} steps
                                            </span>
                                        </div>
                                    `).join('')}
                            </div>
                        </div>

                        <div class="alert alert-warning small mb-0">
                            <i class="fa-solid fa-exclamation-triangle me-1"></i>
                            Are you sure you want to update this bill? This action cannot be undone.
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="fa-solid fa-save me-1"></i> Yes, Update Bill',
                cancelButtonText: '<i class="fa-solid fa-times me-1"></i> Cancel',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    const updateBtn = document.getElementById('updateBtn');
                    const originalText = updateBtn.innerHTML;
                    updateBtn.disabled = true;
                    updateBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Updating...';

                    // Submit form after short delay
                    setTimeout(() => {
                        this.submit();
                    }, 1000);

                    // Show processing message
                    Swal.fire({
                        title: 'Updating Bill',
                        text: 'Please wait while we update your bill...',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            });
        });

        /* --------------------------
            SUCCESS/ERROR MESSAGES WITH SWEETALERT2
        --------------------------- */
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#28a745',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545'
                });
            @endif

            @if (session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: '{{ session('warning') }}',
                    confirmButtonColor: '#ffc107'
                });
            @endif
        });

        /* --------------------------
            STEP VALIDATION
        --------------------------- */
        function validateSteps() {
            let hasErrors = false;
            let errorMessages = [];

            document.querySelectorAll('.step-wrapper').forEach(wrapper => {
                let hasSteps = false;
                wrapper.querySelectorAll('.step-row').forEach(row => {
                    let name = row.querySelector('.step-name').value.trim();
                    let rate = row.querySelector('.step-rate').value.trim();

                    if (name !== "") {
                        hasSteps = true;
                        if (!rate || parseFloat(rate) <= 0) {
                            hasErrors = true;
                            errorMessages.push(`Please enter a valid rate for step: "${name}"`);
                        }
                    }
                });

                if (!hasSteps) {
                    const caseNumber = wrapper.dataset.caseId;
                    errorMessages.push(`Case ${caseNumber}: Please add at least one step`);
                    hasErrors = true;
                }
            });

            if (hasErrors) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `
                        <div class="text-start">
                            <p>Please fix the following issues:</p>
                            <ul class="small">
                                ${errorMessages.map(msg => `<li>${msg}</li>`).join('')}
                            </ul>
                        </div>
                    `,
                    confirmButtonColor: '#dc3545'
                });
            }

            return !hasErrors;
        }
    </script>
</x-app-layout>
