<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center gap-3 flex-column flex-sm-row">
                    <!-- Breadcrumb Section -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                    <i class="fa-solid fa-house"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Legal Notice Bill
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0 mb-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-file-invoice me-2"></i>
                    Make Legal Notice Bills
                </h4>
                <button type="button" class="btn btn-light btn-sm" id="printPdf">
                    <i class="fas fa-file-pdf me-1"></i> Generate PDF
                </button>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('legalnotice.bill') }}" class="mb-4">
                    <div class="row g-3">
                        <!-- Client Dropdown with Search -->
                        <div class="col-md-3">
                            <label class="form-label">Client Name</label>
                            <div class="position-relative">
                                <select name="client_id" class="form-select" id="clientSelect" style="display: none;">
                                    <option value="">-- All Clients --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="dropdown">
                                    <input type="text" class="form-control rounded" id="clientSearch"
                                        placeholder="Search or select client..." data-bs-toggle="dropdown"
                                        value="{{ request('client_id') ? $clients->where('id', request('client_id'))->first()->name ?? '' : '' }}">

                                    <div class="dropdown-menu w-100 p-2 shadow-lg" id="clientDropdown">
                                        <input type="text" class="form-control rounded form-control-sm mb-2"
                                            id="clientSearchInput" placeholder="Type to search...">
                                        <div class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;">
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
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Branch Dropdown with Search -->
                        <div class="col-md-3">
                            <label class="form-label">Branch</label>
                            <div class="position-relative">
                                <select name="branch" class="form-select" id="branchSelect" style="display:none;">
                                    <option value="">-- All Branch --</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="dropdown">
                                    <input type="text" class="form-control rounded" id="branchSearch"
                                        placeholder="Search or select branch..." data-bs-toggle="dropdown"
                                        value="{{ request('branch') ? $branches->where('id', request('branch'))->first()->name ?? '' : '' }}">

                                    <div class="dropdown-menu w-100 p-2 shadow-lg" id="branchDropdown">
                                        <input type="text" class="form-control rounded form-control-sm mb-2"
                                            id="branchSearchInput" placeholder="Type to search...">

                                        <div class="list-group list-group-flush"
                                            style="max-height:200px; overflow-y:auto;">
                                            <button type="button"
                                                class="list-group-item list-group-item-action branch-option"
                                                data-value="">
                                                -- All Branch --
                                            </button>

                                            @foreach ($branches as $branch)
                                                {{-- <button type="button"
                                                    class="list-group-item list-group-item-action branch-option"
                                                    data-value="{{ $branch->id }}" data-name="{{ $branch->name }}"
                                                    data-client-id="{{ $branch->client_id }}">
                                                    {{ $branch->name }}
                                                </button> --}}
                                                <button type="button"
                                                    class="list-group-item list-group-item-action branch-option"
                                                    data-value="{{ $branch->id }}" data-name="{{ $branch->name }}"
                                                    data-client-id="{{ $branch->client_id }}">
                                                    {{ $branch->name }}
                                                </button>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loan Account / ACQUEST / CIN -->
                        <div class="col-md-3">
                            <label class="form-label">Loan A/C OR Member OR CIN</label>
                            <input type="text" name="loan_account_acquest_cin" class="form-control rounded"
                                placeholder="Enter A/C or CIN..." value="{{ request('loan_account_acquest_cin') }}">
                        </div>

                        <!-- Category Dropdown with Search -->
                        <div class="col-md-3">
                            <label class="form-label">Section</label>
                            <div class="position-relative">
                                <select name="category_id" class="form-select" id="categorySelect"
                                    style="display: none;">
                                    <option value="">-- All Categories --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="dropdown">
                                    <input type="text" class="form-control rounded" id="categorySearch"
                                        placeholder="Search or select category..." data-bs-toggle="dropdown"
                                        value="{{ request('category_id') ? $categories->where('id', request('category_id'))->first()->name ?? '' : '' }}">

                                    <div class="dropdown-menu w-100 p-2 shadow-lg" id="categoryDropdown">
                                        <input type="text" class="form-control rounded form-control-sm mb-2"
                                            id="categorySearchInput" placeholder="Type to search...">
                                        <div class="list-group list-group-flush"
                                            style="max-height: 200px; overflow-y: auto;">
                                            <button type="button"
                                                class="list-group-item list-group-item-action category-option"
                                                data-value="">
                                                -- All Categories --
                                            </button>
                                            @foreach ($categories as $cat)
                                                <button type="button"
                                                    class="list-group-item list-group-item-action category-option"
                                                    data-value="{{ $cat->id }}" data-name="{{ $cat->name }}"
                                                    {{ request('category_id') == $cat->id ? 'data-selected="true"' : '' }}>
                                                    {{ $cat->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date From</label>
                            <input type="date" name="date_from" class="form-control rounded"
                                value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date To</label>
                            <input type="date" name="date_to" class="form-control rounded"
                                value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="Running" {{ request('status') == 'Running' ? 'selected' : '' }}>Running
                                </option>
                                <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done
                                </option>
                                <option value="Reject" {{ request('status') == 'Reject' ? 'selected' : '' }}>Reject
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filter Bills
                            </button>
                            <a href="{{ route('legalnotice.bill') }}" class="btn btn-secondary">
                                <i class="fas fa-refresh me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Custom Fields Section -->
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    Client Information for Bill
                </h4>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="form_group">
                            <input type="text" name="jobTitle" id="jobTitle" placeholder="Job Title"
                                class="custom-field">
                            <label class="form_label" for="jobTitle">Job Title</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_group">
                            <input type="text" name="address" id="address" placeholder="Address"
                                class="custom-field">
                            <label class="form_label" for="address">Address</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_group">
                            <input type="text" name="subject" id="subject" placeholder="Subject"
                                class="custom-field">
                            <label class="form_label" for="subject">Subject</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Bill List -->
                            <form id="billForm">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="50">#</th>
                                                <th>File Info</th>
                                                <th>Acquest & Section</th>
                                                <th>Legal Notice Date</th>
                                                <th>Status</th>
                                                <th width="150">Amount (Tk.)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($legalnotices as $index => $notice)
                                                <tr class="bill-row">
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>
                                                        <strong>Name:
                                                            {{ $notice->client?->name ?? 'N/A' }}</strong><br>
                                                        <strong>Branch:
                                                            {{ $notice->clientbranch?->name ?? 'N/A' }}</strong><br>
                                                    </td>
                                                    <td>
                                                        <strong>Acquest:</strong> {{ $notice->name ?? 'N/A' }}<br>
                                                        <strong>Section:</strong>
                                                        {{ $notice->category?->name ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if ($notice->legal_notice_date)
                                                            <strong>Legal Notice Date:</strong>
                                                            {{ \Carbon\Carbon::parse($notice->legal_notice_date)->format('d M, Y') }}<br>
                                                        @endif
                                                        @if ($notice->comments)
                                                            <strong>Comments:</strong>
                                                            {{ Str::limit($notice->comments ?? '', 50) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $notice->status == 'Done' ? 'success' : ($notice->status == 'Reject' ? 'danger' : 'warning') }}">
                                                            {{ $notice->status ?? 'Unknown' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Tk.</span>
                                                            <input type="number" class="form-control amount-input"
                                                                name="amounts[{{ $notice->id }}]" value="0"
                                                                min="0" step="0.01"
                                                                data-id="{{ $notice->id }}" placeholder="0.00">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
                                                        <div class="empty-state">
                                                            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                                                            <h5 class="text-muted">No Bills Found</h5>
                                                            <p class="text-muted">No legal notice bills match your
                                                                filter criteria.</p>
                                                            <a href="{{ route('legalnotice.bill') }}"
                                                                class="btn btn-primary">
                                                                <i class="fas fa-refresh me-1"></i> Clear Filters
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Total Calculation -->
                                @if ($legalnotices->count() > 0)
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="card-title">Summary</h6>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small>Total Bills:
                                                                <strong>{{ $legalnotices->count() }}</strong></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <small>Running:
                                                                <strong>{{ $legalnotices->where('status', 'Running')->count() }}</strong></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <small>Done:
                                                                <strong>{{ $legalnotices->where('status', 'Done')->count() }}</strong></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <small>Rejected:
                                                                <strong>{{ $legalnotices->where('status', 'Reject')->count() }}</strong></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-success text-white">
                                                <div class="card-body text-center">
                                                    <h6 class="card-title">Total Amount</h6>
                                                    <h3 id="totalAmount">৳ 0.00</h3>
                                                    <small id="totalInWords">Zero Taka Only</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Debug function
        function debug(message) {
            console.log('DEBUG:', message);
        }

        // Simple number to words converter
        function numberToWords(number) {
            debug('Converting number to words: ' + number);

            if (number === 0) return 'Zero Taka Only';

            const units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
            const teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen',
                'Nineteen'
            ];
            const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

            function convertHundreds(num) {
                let result = '';

                if (num >= 100) {
                    result += units[Math.floor(num / 100)] + ' Hundred ';
                    num %= 100;
                }

                if (num >= 20) {
                    result += tens[Math.floor(num / 10)] + ' ';
                    num %= 10;
                }

                if (num >= 10) {
                    result += teens[num - 10] + ' ';
                    num = 0;
                }

                if (num > 0) {
                    result += units[num] + ' ';
                }

                return result.trim();
            }

            function convertNumber(num) {
                if (num === 0) return 'Zero';

                let result = '';

                if (num >= 10000000) {
                    result += convertHundreds(Math.floor(num / 10000000)) + ' Crore ';
                    num %= 10000000;
                }

                if (num >= 100000) {
                    result += convertHundreds(Math.floor(num / 100000)) + ' Lakh ';
                    num %= 100000;
                }

                if (num >= 1000) {
                    result += convertHundreds(Math.floor(num / 1000)) + ' Thousand ';
                    num %= 1000;
                }

                result += convertHundreds(num);

                return result.trim();
            }

            const taka = Math.floor(number);
            const poisha = Math.round((number - taka) * 100);

            let words = '';

            if (taka > 0) {
                words += convertNumber(taka) + ' Taka';
            }

            if (poisha > 0) {
                if (words !== '') words += ' and ';
                words += convertNumber(poisha) + ' Poisha';
            }

            return words + ' Only';
        }

        // Calculate total function
        function calculateTotal() {
            let total = 0;
            let inputCount = 0;

            $('.amount-input').each(function() {
                const value = parseFloat($(this).val()) || 0;
                total += value;
                inputCount++;
                debug('Input ' + inputCount + ': ' + value);
            });

            debug('Total calculated: ' + total);

            $('#totalAmount').text('৳ ' + total.toLocaleString('en-BD', {
                minimumFractionDigits: 2
            }));
            $('#totalInWords').text(numberToWords(total));
        }

        // Amount input change event
        $(document).on('input', '.amount-input', function() {
            debug('Amount input changed: ' + $(this).val());
            calculateTotal();
        });

        // PDF print function with custom fields
        $('#printPdf').click(function() {
            debug('PDF button clicked');

            const amounts = {};
            let hasAmount = false;

            // Collect all amounts
            $('.amount-input').each(function() {
                const id = $(this).data('id');
                const value = parseFloat($(this).val()) || 0;
                amounts[id] = value;

                if (value > 0) {
                    hasAmount = true;
                }

                debug('Amount for ID ' + id + ': ' + value);
            });

            // Check if any amount is entered
            if (!hasAmount) {
                alert('Please enter amounts for at least one bill before generating PDF.');
                return;
            }

            // Collect custom fields
            const customFields = {
                jobTitle: $('#jobTitle').val(),
                address: $('#address').val(),
                subject: $('#subject').val()
            };

            // Show loading
            const originalText = $('#printPdf').html();
            $('#printPdf').html('<i class="fas fa-spinner fa-spin me-1"></i> Generating...').prop('disabled', true);

            // AJAX request to generate PDF
            $.ajax({
                url: '{{ route('legalnotice.generateBillPdf') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    amounts: amounts,
                    customFields: customFields,
                    filters: {
                        client_id: '{{ request('client_id') }}',
                        category_id: '{{ request('category_id') }}',
                        date_from: '{{ request('date_from') }}',
                        date_to: '{{ request('date_to') }}',
                        status: '{{ request('status') }}'
                    }
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    debug('PDF generated successfully');

                    // Download PDF
                    const blob = new Blob([response], {
                        type: 'application/pdf'
                    });
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'legal-notice-bills-{{ date('Y-m-d') }}.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);

                    // Restore button
                    $('#printPdf').html(originalText).prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    debug('PDF generation failed: ' + error);
                    alert('PDF generation failed. Please check console for details.');
                    console.error('PDF Error:', xhr.responseText);

                    // Restore button
                    $('#printPdf').html(originalText).prop('disabled', false);
                }
            });
        });

        // Filter form auto submit
        $(document).on('change', 'select[name="client_id"], select[name="category_id"], select[name="status"]', function() {
            $(this).closest('form').submit();
        });

        // Initialize on document ready
        $(document).ready(function() {
            debug('Document ready');
            calculateTotal();
            initializeDropdowns();

            // 🔥 NEW: Auto-fill prices if page loaded with filters applied
            const clientId = document.getElementById("clientSelect").value;
            const categoryId = document.getElementById("categorySelect").value;
            if (clientId && categoryId) {
                autoFillPricesByClientAndCategory();
            }

            // Test the number to words function
            console.log('Test numberToWords(123.45):', numberToWords(123.45));
            console.log('Test numberToWords(0):', numberToWords(0));
            console.log('Test numberToWords(1000):', numberToWords(1000));
        });

        function initializeDropdowns() {
            // Client Dropdown
            const clientSearch = document.getElementById('clientSearch');
            const clientSearchInput = document.getElementById('clientSearchInput');
            const clientOptions = document.querySelectorAll('.client-option');
            const clientSelect = document.getElementById('clientSelect');

            if (clientSearch) {
                const clientDropdown = new bootstrap.Dropdown(clientSearch);

                clientSearchInput.addEventListener('input', function() {
                    const term = this.value.toLowerCase().trim();
                    clientOptions.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(term) ? 'block' : 'none';
                    });
                });

                clientOptions.forEach(option => {
                    option.addEventListener('click', function() {

                        const value = this.getAttribute('data-value');
                        const name = this.getAttribute('data-name') || this.textContent;

                        clientSearch.value = name;
                        clientSelect.value = value;
                        clientDropdown.hide();

                        // 🔥 NEW: Filter branches by selected client
                        filterBranchesByClient(value);
                    });
                });


                clientSearch.addEventListener('shown.bs.dropdown', function() {
                    setTimeout(() => {
                        clientSearchInput.focus();
                    }, 100);
                });
            }

            // Category Dropdown
            const categorySearch = document.getElementById('categorySearch');
            const categorySearchInput = document.getElementById('categorySearchInput');
            const categoryOptions = document.querySelectorAll('.category-option');
            const categorySelect = document.getElementById('categorySelect');

            if (categorySearch) {
                const categoryDropdown = new bootstrap.Dropdown(categorySearch);

                categorySearchInput.addEventListener('input', function() {
                    const term = this.value.toLowerCase().trim();
                    categoryOptions.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(term) ? 'block' : 'none';
                    });
                });

                categoryOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        const name = this.getAttribute('data-name') || this.textContent;

                        categorySearch.value = name;
                        categorySelect.value = value;
                        categoryDropdown.hide();

                        // 🔥 NEW: Auto-fill prices when category is selected
                        autoFillPricesByClientAndCategory();
                    });
                });

                categorySearch.addEventListener('shown.bs.dropdown', function() {
                    setTimeout(() => {
                        categorySearchInput.focus();
                    }, 100);
                });
            }
        }

        // ================================
        // CLIENT → BRANCH FILTER SYSTEM
        // ================================

        const clientSearch = document.getElementById("clientSearch");
        const clientSelect = document.getElementById("clientSelect");
        const branchSearch = document.getElementById("branchSearch");
        const branchSelect = document.getElementById("branchSelect");

        const clientOptions = document.querySelectorAll(".client-option");
        const branchOptions = document.querySelectorAll(".branch-option");

        /* ---------- CLIENT SELECT ---------- */
        clientOptions.forEach(option => {
            option.addEventListener("click", function() {

                const clientId = this.dataset.value || "";
                const clientName = this.dataset.name || this.innerText;

                // set client
                clientSearch.value = clientName;
                clientSelect.value = clientId;

                // reset branch
                branchSearch.value = "";
                branchSelect.value = "";

                // filter branch list
                filterBranches(clientId);
            });
        });

        /* ---------- BRANCH DROPDOWN OPEN ---------- */
        branchSearch.addEventListener("click", function() {
            const clientId = clientSelect.value;
            filterBranches(clientId);
        });

        /* ---------- BRANCH SELECT ---------- */
        branchOptions.forEach(option => {
            option.addEventListener("click", function() {

                branchSearch.value =
                    this.dataset.name || this.innerText;

                branchSelect.value =
                    this.dataset.value || "";
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

        // Branch Dropdown Search
        document.querySelectorAll(".branch-option").forEach(option => {
            option.addEventListener("click", function() {
                document.getElementById("branchSearch").value = this.dataset.name || "";
                document.getElementById("branchSelect").value = this.dataset.value || "";
                document.getElementById("branchDropdown").classList.remove("show");
            });
        });

        // search inside dropdown
        document.getElementById("branchSearchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            document.querySelectorAll(".branch-option").forEach(option => {
                let text = option.innerText.toLowerCase();
                option.style.display = text.includes(filter) ? "" : "none";
            });
        });

        // === Filter Branch List by Selected Client ===
        function filterBranchesByClient(clientId) {
            document.querySelectorAll('.branch-option').forEach(option => {
                let optionClientId = option.dataset.clientId;

                // If no client selected → show all branches
                if (!clientId) {
                    option.style.display = "";
                }
                // Show only branch of selected client
                else if (optionClientId == clientId) {
                    option.style.display = "";
                } else {
                    option.style.display = "none";
                }
            });

            // Reset branch input after filtering
            document.getElementById("branchSearch").value = "";
            document.getElementById("branchSelect").value = "";

            // 🔥 NEW: Auto-fill prices when client is selected
            autoFillPricesByClientAndCategory();
        }

        // === Auto-fill prices from pricing table ===
        function autoFillPricesByClientAndCategory() {
            const clientId = document.getElementById("clientSelect").value;
            const categoryId = document.getElementById("categorySelect").value;

            if (!clientId || !categoryId) {
                debug('Missing client_id or category_id for price lookup');
                return;
            }

            debug('Fetching price for client: ' + clientId + ', category: ' + categoryId);

            // Call API to get price
            fetch('{{ route('legalnotice.pricing.getPrice') }}?client_id=' + clientId + '&category_id=' + categoryId)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.price !== null) {
                        debug('Price found: ' + data.price);

                        // Auto-fill all amount inputs with the price
                        document.querySelectorAll('.amount-input').forEach(input => {
                            // Only fill if the input is still at default value (0)
                            if (parseFloat(input.value) === 0) {
                                input.value = parseFloat(data.price).toFixed(2);
                                debug('Auto-filled amount: ' + data.price);
                            }
                        });

                        // Recalculate total
                        calculateTotal();
                    } else {
                        debug('No pricing found for this combination');
                    }
                })
                .catch(error => {
                    debug('Error fetching price: ' + error);
                    console.error('Price fetch error:', error);
                });
        }

        // 🔥 NEW: Listen to category selection to trigger auto-fill
        document.addEventListener('categorySelected', function() {
            autoFillPricesByClientAndCategory();
        });
    </script>

    <style>
        .amount-input {
            text-align: right;
            font-weight: bold;
        }

        .bill-row:hover {
            background-color: #f8f9fa;
        }

        #totalAmount {
            font-weight: bold;
            margin-bottom: 5px;
        }

        #totalInWords {
            font-size: 0.9em;
            opacity: 0.9;
        }

        .input-group-sm .form-control {
            padding: 0.25rem 0.5rem;
        }

        /* Loading state for PDF button */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Custom form styling */
        .form_group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form_group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            background: #fff;
            transition: all 0.3s ease;
        }

        .form_group input:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .form_label {
            position: absolute;
            top: -0.5rem;
            left: 0.75rem;
            background: #fff;
            padding: 0 0.25rem;
            font-size: 0.875rem;
            color: #6c757d;
            transition: all 0.3s ease;
        }
    </style>
</x-app-layout>
