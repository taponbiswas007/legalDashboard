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
                            Case bill List
                            </li>
                        </ol>
                    </nav>
                    <div>
                        <a href="{{ route('casehistory.bill.index') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Make Bill
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0 ">
            <div class="card-body">
                   <div class="table_container">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice Number</th>
                            <th>Date</th>
                            <th>On Behalf Of</th>
                            <th>Branch</th>
                            <th>From date</th>
                            <th>To Date</th>
                            <th>Total Amount</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bills as $bill)
                            <tr>
                                <td>{{ $bill->invoice_number }}</td>
                                <td>
                                     {{ $bill->created_at ? \Carbon\Carbon::parse($bill->created_at)->format('d-M-Y') : '—' }}
                                </td>
                                <td>{{ $bill->client->name ?? '' }}</td>
                                <td>{{ $bill->clientbranch->name ?? 'N/A' }}</td>
                                <td>
                                     {{ $bill->from_date ? \Carbon\Carbon::parse($bill->from_date)->format('d-M-Y') : '—' }}
                                </td>
                                <td>
                                      {{ $bill->to_date ? \Carbon\Carbon::parse($bill->to_date)->format('d-M-Y') : '—' }}
                                </td>
                               <td>
                                {{ $bill->total_amount }}
                               </td>

                              <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('bill.preview', $bill->id) }}" class="btn btn-info btn-sm show-btn" title="Preview">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger btn-sm delete-bill-btn" 
                                            data-bill-id="{{ $bill->id }}" 
                                            data-invoice-number="{{ $bill->invoice_number }}"
                                            data-client-name="{{ $bill->client->name ?? 'N/A' }}"
                                            data-total-amount="{{ number_format($bill->total_amount, 2) }}"
                                            title="Delete Bill">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    No bills found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $bills->links('pagination::bootstrap-5') }}
            </div>
            </div>
        </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBillModal" tabindex="-1" aria-labelledby="deleteBillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteBillModalLabel">
                    <i class="fa fa-exclamation-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to delete this bill?</p>
                <div class="alert alert-warning">
                    <strong>Invoice:</strong> <span id="deleteInvoiceNumber"></span><br>
                    <strong>Client:</strong> <span id="deleteClientName"></span><br>
                    <strong>Amount:</strong> <span id="deleteTotalAmount"></span> BDT
                </div>
                <p class="text-danger fw-semibold">
                    <i class="fa fa-warning me-1"></i>
                    This action cannot be undone. All bill steps and related data will be permanently deleted.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteBillForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash me-1"></i>Delete Bill
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    /* --------------------------
    BILL DELETE FUNCTIONALITY
--------------------------- */
document.addEventListener('DOMContentLoaded', function() {
    // Delete bill button click
    document.querySelectorAll('.delete-bill-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const billId = this.dataset.billId;
            const invoiceNumber = this.dataset.invoiceNumber;
            
            // Set modal content
            document.getElementById('deleteInvoiceNumber').textContent = invoiceNumber;
            
            // Get additional bill info (if available in data attributes)
            const clientName = this.dataset.clientName || 'N/A';
            const totalAmount = this.dataset.totalAmount || '0';
            
            document.getElementById('deleteClientName').textContent = clientName;
            document.getElementById('deleteTotalAmount').textContent = totalAmount;
            
            // Set form action
            document.getElementById('deleteBillForm').action = `/bill/${billId}`;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('deleteBillModal'));
            modal.show();
        });
    });
    
    // Success message display
    @if(session('success'))
        showToast('success', '{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showToast('error', '{{ session('error') }}');
    @endif
});
</script>
</x-app-layout>