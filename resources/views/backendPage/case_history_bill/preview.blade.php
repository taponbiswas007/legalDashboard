<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-primary fw-bold">
                                <i class="fa-solid fa-eye me-2"></i>Bill Preview
                            </h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('bill.edit', $bill->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('casehistory.bill.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fa-solid fa-arrow-left me-1"></i>Back to Bill Generator
                                </a>
                               <button class="btn btn-success btn-sm" onclick="generatePDF()">
                                    <i class="fa-regular fa-file-pdf me-1"></i>Download PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                       <div class="row mb-4">
                            <!-- Bill Details Column -->
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <h5 class="fw-bold text-muted pb-2">Bill Details</h5>
                                <div class="">
                                    <table class="">
                                        <tr>
                                            <td class="fw-semibold pb-1" style="width: 150px;">Invoice Number:</td>
                                            <td>{{ $bill->invoice_number }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold pb-1" style="width: 150px;">Client:</td>
                                            <td>{{ $bill->client->name ?? 'N/A' }}</td>
                                        </tr>
                                        @if($bill->branch_id)
                                            <tr>
                                                <td class="fw-semibold pb-1">Branch:</td>
                                                <td>{{ $bill->clientbranch?->name ?? ' ' }}</td>
                                            </tr>
                                            @endif

                                        <tr>
                                            <td class="fw-semibold pb-1" style="width: 150px;">Period:</td>
                                            <td>
                                                {{ $bill->from_date ? \Carbon\Carbon::parse($bill->from_date)->format('d/m/Y') : 'N/A' }} 
                                                - 
                                                {{ $bill->to_date ? \Carbon\Carbon::parse($bill->to_date)->format('d/m/Y') : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold pb-1" style="width: 150px;">Job Title:</td>
                                            <td>{{ $bill->jobtitle ?? 'N/A' }}</td>
                                        </tr>
                                        <!-- Additional Information -->
                                        @if($bill->address || $bill->subject)
                                        @if($bill->address)
                                            <tr>
                                                <td class="fw-semibold pb-1" style="width: 150px;">Address:</td>
                                                <td>{{ $bill->address }}</td>
                                            </tr>
                                            @endif
                                            @if($bill->subject)
                                            <tr>
                                                <td class="fw-semibold pb-1" style="width: 150px;">Subject:</td>
                                                <td>{{ $bill->subject }}</td>
                                            </tr>
                                            @endif
                                        @endif
                                    </table>
                                </div>
                            </div>
                            
                            
                            <!-- Summary Column -->
                            <div class="col-12 col-md-6">
                                <h5 class="fw-bold text-muted pb-2">Summary</h5>
                                <div >
                                    <table >
                                        <tr>
                                            <td class="fw-semibold pb-1" style="width: 150px;">Total Amount:</td>
                                            <td class="fw-bold fs-5 text-success">
                                                {{ number_format($bill->total_amount, 2) }} BDT
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold pb-1" style="width: 150px;">Total in Words:</td>
                                            <td class="fst-italic text-muted text-capitalize" id="totalInWords">
                                                <!-- JavaScript will populate this -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold" style="width: 150px;">Generated Date:</td>
                                            <td>{{ $bill->created_at->format('d/m/Y h:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Steps Details Grouped by Case Number and Hearing Date -->
                        <h5 class="fw-bold text-muted mb-3">Bill Steps (Grouped by Case & Hearing Date)</h5>
                        <div class="table-responsive">
                          <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="fw-semibold">#</th>
                                    <!-- Conditional Columns -->
                                    @php
                                        $showBranch = false;
                                        $nameOfParties = false;
                                        $showLoanAccount = false;
                                        $showPreviousDate = false;
                                        $showPreviousStep = false;
                                        $showNextDate = false;
                                        $showNextStep = false;
                                        
                                        // Check which columns have data
                                        foreach ($bill->steps as $step) {
                                            if ($step->caseDetails) {
                                                if ($step->caseDetails->branch_id) $showBranch = true;
                                                if ($step->caseDetails->name_of_parties) $nameOfParties = true;
                                                if ($step->caseDetails->loan_account_acquest_cin) $showLoanAccount = true;
                                                if ($step->caseDetails->previous_date) $showPreviousDate = true;
                                                if ($step->caseDetails->previous_step) $showPreviousStep = true;
                                                if ($step->caseDetails->next_hearing_date) $showNextDate = true;
                                                if ($step->caseDetails->next_step) $showNextStep = true;
                                            }
                                        }
                                    @endphp
                                    
                                    @if($showBranch)
                                        <th class="fw-semibold">Branch</th>
                                    @endif
                                    
                                    @if($showLoanAccount)
                                        <th class="fw-semibold">Loan A/C or Member or CIN</th>
                                    @endif
                                    
                                    <th class="fw-semibold">Court Name & Case Number</th>
                                    @if($nameOfParties)
                                        <th class="fw-semibold">Name of Parties</th>
                                    @endif
                                    @if($showPreviousDate || $showPreviousStep)
                                        <th class="fw-semibold">Date & Legal Step</th>
                                    @endif
                                    
                                    @if($showNextDate || $showNextStep)
                                        <th class="fw-semibold">Next Date & Legal Step</th>
                                    @endif
                                    
                                    <th class="fw-semibold">Purpose & Amount</th>
                                    <th class="fw-semibold text-end">Sub Total (BDT)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Group steps by case number and hearing date
                                    $groupedSteps = [];
                                    foreach ($bill->steps as $step) {
                                        $key = $step->case_number . '_' . ($step->hearing_date ?? 'no_date');
                                        if (!isset($groupedSteps[$key])) {
                                            $groupedSteps[$key] = [
                                                'case_number' => $step->case_number,
                                                'hearing_date' => $step->hearing_date,
                                                'case_details' => $step->caseDetails,
                                                'steps' => [],
                                                'sub_total' => 0
                                            ];
                                        }
                                        $groupedSteps[$key]['steps'][] = $step;
                                        $groupedSteps[$key]['sub_total'] += $step->rate;
                                    }
                                    
                                    $groupIndex = 1;
                                @endphp

                                @foreach($groupedSteps as $group)
                                    <tr>
                                        <td>{{ $groupIndex++ }}</td>
                                        
                                        <!-- Branch Column -->
                                        @if($showBranch)
                                            <td>
                                               @if($group['case_details']?->clientbranch?->name)
                                                    {{ $group['case_details']->clientbranch->name }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif

                                            </td>
                                        @endif
                                        
                                        <!-- Loan Account Column -->
                                        @if($showLoanAccount)
                                            <td>
                                                @if($group['case_details'] && $group['case_details']->loan_account_acquest_cin)
                                                    {{ $group['case_details']->loan_account_acquest_cin }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endif
                                        
                                        <!-- court name and Case Number Column -->
                                        <td>
                                            @if($group['case_details'] && $group['case_details']->court)
                                                    {{ $group['case_details']?->court?->name ?? '-' }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif <br>
                                                {{ $group['case_number'] }}
                                        </td>
                                        
                                         <!-- namr of parties Column -->
                                        @if($nameOfParties)
                                            <td>
                                                @if($group['case_details'] && $group['case_details']->name_of_parties)
                                                    {{ $group['case_details']->name_of_parties }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endif
                                        
                                        <!-- Previous Legal Step Column -->
                                        @if($showPreviousDate || $showPreviousStep)
                                            <td>
                                                @if($group['case_details'] && $group['case_details']->previous_date)
                                                    <span class="badge bg-info text-dark">
                                                        {{ \Carbon\Carbon::parse($group['case_details']->previous_date)->format('d/m/Y') }}
                                                    </span>
                                                @endif
                                                
                                                @if($group['case_details'] && $group['case_details']->previous_step)
                                                    <div class="mt-1">
                                                        <span class="badge bg-primary">{{ $group['case_details']->previous_step }}</span>
                                                    </div>
                                                @endif
                                                
                                                @if(!$group['case_details'] || (!$group['case_details']->previous_date && !$group['case_details']->previous_step))
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endif
                                        
                                        <!-- Next Legal Step Column -->
                                        @if($showNextDate || $showNextStep)
                                            <td>
                                                @if($group['case_details'] && $group['case_details']->next_hearing_date)
                                                    <span class="badge bg-info text-dark">
                                                        {{ \Carbon\Carbon::parse($group['case_details']->next_hearing_date)->format('d/m/Y') }}
                                                    </span>
                                                @endif
                                                
                                                @if($group['case_details'] && $group['case_details']->next_step)
                                                    <div class="mt-1">
                                                        <span class="badge bg-primary">{{ $group['case_details']->next_step }}</span>
                                                    </div>
                                                @endif
                                                
                                                @if(!$group['case_details'] || (!$group['case_details']->next_hearing_date && !$group['case_details']->next_step))
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endif
                                        
                                        <!-- Steps & Amount Column -->
                                        <td>
                                            <div class="steps-list">
                                                @foreach($group['steps'] as $step)
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="step-name">{{ $step->step_name }}</span>
                                                        <span class="step-amount text-muted ms-3">
                                                            {{ number_format($step->rate, 2) }} BDT
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        
                                        <!-- Sub Total Column -->
                                        <td class="text-end fw-bold">
                                            {{ number_format($group['sub_total'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    @php
                                        $colspan = 1; // # column
                                        if ($showBranch) $colspan++;
                                        if ($nameOfParties) $colspan++;
                                        if ($showLoanAccount) $colspan++;
                                        $colspan++; // Case Number column
                                        if ($showPreviousDate || $showPreviousStep) $colspan++;
                                        if ($showNextDate || $showNextStep) $colspan++;
                                        $colspan++; // Purpose & Amount column
                                    @endphp
                                    
                                    <td colspan="{{ $colspan }}" class="fw-bold text-end">Grand Total:</td>
                                    <td class="fw-bold text-end">
                                        @php
                                            $grandTotal = $bill->total_amount;
                                            if (!$grandTotal || $grandTotal == 0) {
                                                $grandTotal = $bill->steps->sum('rate');
                                            }
                                        @endphp
                                        {{ number_format($grandTotal, 2) }} BDT
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>

                        <!-- Alternative: Detailed View (যদি প্রয়োজন হয়) -->
                        <div class="mt-4">
                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#detailedView">
                                <i class="fa-solid fa-list me-1"></i>Show Detailed View
                            </button>
                            
                            <div class="collapse mt-3" id="detailedView">
                                <h6 class="fw-bold text-muted mb-3">Detailed Steps</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Case Number</th>
                                                <th>Hearing Date</th>
                                                <th>Step Name</th>
                                                <th class="text-end">Rate (BDT)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bill->steps as $index => $step)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $step->case_number }}</td>
                                                    <td>
                                                        @if($step->hearing_date)
                                                            {{ \Carbon\Carbon::parse($step->hearing_date)->format('d/m/Y') }}
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $step->step_name }}</td>
                                                    <td class="text-end">{{ number_format($step->rate, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 12px;
        }
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #d4d4d4;
        }
         .table td{
             border: 1px solid #d4d4d4;
         }
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        .steps-list {
            font-size: 0.9rem;
        }
        .step-name {
            flex: 1;
        }
        .step-amount {
            min-width: 80px;
            text-align: right;
        }
        .badge {
            font-size: 0.75rem;
        }
    </style>

    <script>
        // Number to Words Function
        function numberToWords(num) {
            const a = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
                'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
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

        // Set total in words on page load
        document.addEventListener('DOMContentLoaded', function() {
            const totalAmount = {{ $bill->total_amount }};
            const words = numberToWords(totalAmount) + " taka only";
            document.getElementById('totalInWords').textContent = words;
            
            // Auto-hide success message after 5 seconds
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 5000);
            }
        });

        // PDF Generation Function
        function generatePDF() {
            const btn = event.target;
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Generating PDF...';
            
            window.location.href = "{{ route('bill.pdf.download', $bill->id) }}";
            
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }, 3000);
        }
    </script>

    <script>
        // PDF Generation Function
        function generatePDF() {
            const btn = event.target;
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Generating PDF...';
            
            window.location.href = "{{ route('bill.pdf.download', $bill->id) }}";
            
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }, 3000);
        }
    </script>
</x-app-layout>