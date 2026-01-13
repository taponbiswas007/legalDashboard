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
                            <li class="breadcrumb-item">
                                <a href="{{ route('legalnotice.bills.index') }}" class="text-decoration-none text-dark">
                                    Legal Notice Bills
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Bill #{{ $bill->bill_number ?? $bill->id }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0 mb-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Edit Legal Notice Bill
                </h4>
                <div>
                    <span class="badge bg-light text-dark me-2">
                        Bill #: {{ $bill->bill_number ?? 'N/A' }}
                    </span>
                    <span class="badge bg-light text-dark">
                        Date: {{ \Carbon\Carbon::parse($bill->bill_date)->format('d M, Y') }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>There were some problems with your input:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('legalnotice.bills.update', $bill->id) }}" method="POST" id="editBillForm">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Section -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Client Name</label>
                                <input type="text" class="form-control rounded bg-light"
                                    value="{{ $bill->client->name ?? 'N/A' }}" disabled>
                                <input type="hidden" name="client_id" value="{{ $bill->client_id }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Branch</label>
                                <input type="text" class="form-control rounded bg-light"
                                    value="{{ $bill->branch->name ?? 'N/A' }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Bill Date <span class="text-danger">*</span></label>
                                <input type="date" name="bill_date" class="form-control rounded"
                                    value="{{ $bill->bill_date->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Fields Section (Matching your billing page) -->
                    <div class="card shadow rounded border-0 mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>
                                Client Information for Bill
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-4">
                                    <div class="form_group">
                                        <input type="text" name="job_title" id="jobTitle" placeholder="Job Title"
                                            class="custom-field"
                                            value="{{ old('job_title', $bill->custom_fields['jobTitle'] ?? '') }}">
                                        <label class="form_label" for="jobTitle">Job Title</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form_group">
                                        <input type="text" name="address" id="address" placeholder="Address"
                                            class="custom-field"
                                            value="{{ old('address', $bill->custom_fields['address'] ?? '') }}">
                                        <label class="form_label" for="address">Address</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form_group">
                                        <input type="text" name="subject" id="subject" placeholder="Subject"
                                            class="custom-field"
                                            value="{{ old('subject', $bill->custom_fields['subject'] ?? '') }}">
                                        <label class="form_label" for="subject">Subject</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bill Items Section -->
                    <div class="card shadow rounded border-0 mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>
                                Bill Items
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="billItemsTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Legal Notice Case</th>
                                            <th>Section</th>
                                            <th>Status</th>
                                            <th width="200">Amount (Tk.)</th>
                                            <th width="100">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="billItemsBody">
                                        @foreach ($bill->items as $index => $item)
                                            <tr class="bill-item-row" data-id="{{ $item->id }}">
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>Acquest:</strong>
                                                    {{ $item->legalnotice->name ?? 'N/A' }}<br>
                                                    <small class="text-muted">Case Ref:
                                                        {{ $item->legalnotice->case_reference ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    {{ $item->legalnotice->category->name ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $item->legalnotice->status == 'Done' ? 'success' : ($item->legalnotice->status == 'Reject' ? 'danger' : 'warning') }}">
                                                        {{ $item->legalnotice->status ?? 'Unknown' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Tk.</span>
                                                        <input type="number"
                                                            class="form-control amount-input item-amount"
                                                            name="items[{{ $item->id }}][amount]"
                                                            value="{{ number_format($item->amount, 2, '.', '') }}"
                                                            min="0" step="0.01" required>
                                                        <input type="hidden"
                                                            name="items[{{ $item->id }}][legalnotice_id]"
                                                            value="{{ $item->legalnotice_id }}">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm btn-remove-item"
                                                        title="Remove item">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-secondary">
                                            <td colspan="4" class="text-end fw-bold">Total Amount:</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">Tk.</span>
                                                    <input type="text" class="form-control bg-light fw-bold"
                                                        id="totalAmount" name="total_amount"
                                                        value="{{ number_format($bill->items->sum('amount'), 2, '.', '') }}"
                                                        readonly>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-end">
                                                <small id="totalInWords" class="text-muted">Zero Taka Only</small>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Add New Legal Notice to Bill -->
                            <div class="card border mt-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-plus me-2"></i>
                                        Add New Legal Notice to Bill
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <label class="form-label">Select Legal Notice</label>
                                            <select class="form-select rounded" id="newLegalNoticeSelect">
                                                <option value="">-- Select Legal Notice --</option>
                                                @foreach ($availableLegalNotices as $notice)
                                                    <option value="{{ $notice->id }}"
                                                        data-acquest="{{ $notice->name }}"
                                                        data-section="{{ $notice->category->name ?? '' }}"
                                                        data-status="{{ $notice->status }}"
                                                        data-price="{{ $notice->default_amount ?? 0 }}">
                                                        {{ $notice->name }} ({{ $notice->category->name ?? 'N/A' }}) -
                                                        {{ $notice->status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Amount (Tk.)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Tk.</span>
                                                <input type="number" class="form-control rounded" id="newItemAmount"
                                                    placeholder="0.00" step="0.01" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-success w-100" id="addNewItemBtn">
                                                <i class="fas fa-plus me-1"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Additional Notes</label>
                        <textarea name="notes" class="form-control rounded" rows="3"
                            placeholder="Any additional notes for this bill...">{{ old('notes', $bill->notes ?? '') }}</textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-4">
                        <div>
                            <a href="{{ route('legalnotice.bills.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Bills
                            </a>
                            {{-- <a href="{{ route('legalnotice.bills.show', $bill->id) }}" class="btn btn-info ms-2">
                                <i class="fas fa-eye me-1"></i> View Bill
                            </a> --}}
                        </div>
                        <div>
                            <button type="button" class="btn btn-warning me-2" id="previewPdf">
                                <i class="fas fa-file-pdf me-1"></i> Preview PDF
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Bill
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Calculate total on load
            calculateTotal();

            // Number to words converter (same as billing page)
            function numberToWords(number) {
                if (number === 0) return 'Zero Taka Only';

                const units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
                const teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen',
                    'Eighteen', 'Nineteen'
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
                $('.item-amount').each(function() {
                    const value = parseFloat($(this).val()) || 0;
                    total += value;
                });

                $('#totalAmount').val(total.toFixed(2));
                $('#totalInWords').text(numberToWords(total));
            }

            // Amount input change event
            $(document).on('input', '.item-amount', function() {
                calculateTotal();
            });

            // Remove item
            $(document).on('click', '.btn-remove-item', function() {
                if (confirm('Are you sure you want to remove this item?')) {
                    $(this).closest('tr').remove();
                    calculateTotal();
                    updateRowNumbers();
                }
            });

            // Update row numbers
            function updateRowNumbers() {
                $('#billItemsBody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }

            // Auto-fill amount when legal notice is selected
            $('#newLegalNoticeSelect').change(function() {
                const selectedOption = $(this).find('option:selected');
                const price = parseFloat(selectedOption.data('price')) || 0;
                $('#newItemAmount').val(price.toFixed(2));
            });

            // Add new item
            $('#addNewItemBtn').click(function() {
                const noticeSelect = $('#newLegalNoticeSelect');
                const noticeId = noticeSelect.val();
                const noticeText = noticeSelect.find('option:selected').text();
                const amount = $('#newItemAmount').val();

                if (!noticeId) {
                    alert('Please select a legal notice');
                    return;
                }

                if (!amount || parseFloat(amount) <= 0) {
                    alert('Please enter a valid amount');
                    return;
                }

                // Check if item already exists
                if ($(`input[name*="[legalnotice_id]"][value="${noticeId}"]`).length > 0) {
                    alert('This legal notice is already added to the bill');
                    return;
                }

                const rowCount = $('#billItemsBody tr').length + 1;
                const newRow = `
                    <tr class="bill-item-row">
                        <td class="text-center">${rowCount}</td>
                        <td>
                            <strong>Acquest:</strong> ${noticeText.split('(')[0].trim()}<br>
                            <small class="text-muted">Newly Added</small>
                        </td>
                        <td>${$('#newLegalNoticeSelect option:selected').data('section') || 'N/A'}</td>
                        <td>
                            <span class="badge bg-warning">
                                ${$('#newLegalNoticeSelect option:selected').data('status') || 'N/A'}
                            </span>
                        </td>
                        <td>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Tk.</span>
                                <input type="number" class="form-control amount-input item-amount"
                                       name="new_items[${rowCount}][amount]"
                                       value="${parseFloat(amount).toFixed(2)}"
                                       min="0" step="0.01" required>
                                <input type="hidden" name="new_items[${rowCount}][legalnotice_id]"
                                       value="${noticeId}">
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btn-remove-item"
                                    title="Remove item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#billItemsBody').append(newRow);

                // Reset form
                noticeSelect.val('');
                $('#newItemAmount').val('0.00');

                // Recalculate total
                calculateTotal();
            });

            // Preview PDF
            $('#previewPdf').click(function() {
                const form = $('#editBillForm');
                const originalAction = form.attr('action');
                const originalMethod = form.attr('method');

                // Change form to preview mode
                form.attr('action', '{{ route('legalnotice.bills.preview', $bill->id) }}');
                form.attr('method', 'GET');
                form.attr('target', '_blank');

                // Submit for preview
                form.submit();

                // Restore original form attributes
                setTimeout(() => {
                    form.attr('action', originalAction);
                    form.attr('method', originalMethod);
                    form.removeAttr('target');
                }, 100);
            });

            // Form validation
            $('#editBillForm').submit(function(e) {
                const itemCount = $('.bill-item-row').length;
                if (itemCount === 0) {
                    e.preventDefault();
                    alert('Please add at least one item to the bill');
                    return false;
                }

                const totalAmount = parseFloat($('#totalAmount').val()) || 0;
                if (totalAmount <= 0) {
                    e.preventDefault();
                    alert('Total amount must be greater than zero');
                    return false;
                }
            });
        });
    </script>

    <style>
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

        .amount-input {
            text-align: right;
            font-weight: bold;
        }

        .bill-item-row:hover {
            background-color: #f8f9fa;
        }

        #totalAmount {
            font-weight: bold;
        }

        #totalInWords {
            font-size: 0.9em;
            opacity: 0.9;
        }

        .input-group-sm .form-control {
            padding: 0.25rem 0.5rem;
        }

        .btn-remove-item {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
    </style>
</x-app-layout>
