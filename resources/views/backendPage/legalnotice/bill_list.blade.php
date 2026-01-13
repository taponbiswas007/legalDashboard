<x-app-layout>
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm rounded mb-4 border-0">
                    <div class="card-header pb-0 d-flex align-items-center">
                        <h6 class="mb-0">Legal Notice Bill List</h6>
                        <a href="{{ route('legalnotice.bill') }}" class="btn btn-sm btn-primary ms-auto">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body">
                        {{-- Search Form --}}
                        <form method="GET">
                            <div class="row g-3">

                                {{-- Client Searchable Dropdown --}}
                                <div class="col-md-4 position-relative">
                                    <label class="form-label">Client</label>

                                    <input type="text" id="clientSearch" class="form-control rounded"
                                        placeholder="Search client..." autocomplete="off"
                                        value="{{ optional($clients->firstWhere('id', request('client_id')))->name }}">

                                    <input type="hidden" name="client_id" id="clientId"
                                        value="{{ request('client_id') }}">

                                    <div class="list-group position-absolute w-100 d-none" id="clientDropdown"
                                        style="max-height:200px; overflow:auto; z-index:1000;">
                                        @foreach ($clients as $client)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                data-id="{{ $client->id }}" data-name="{{ $client->name }}">
                                                {{ $client->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">From Date</label>
                                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                                        class="form-control rounded">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">To Date</label>
                                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                                        class="form-control rounded">
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-primary w-100">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="col-12">
                <div class="card shadow-sm rounded border-0">
                    <div class="card-body table-responsive">
                        @if (session('success'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: '{{ session('success') }}',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            </script>
                        @endif


                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Bill Date</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bills as $bill)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $bill->client->name ?? 'N/A' }}</td>
                                        <td>{{ $bill->bill_date->format('d-M-Y') }}</td>
                                        <td class="fw-bold">{{ number_format($bill->total_amount, 2) }}</td>
                                        <td>

                                            {{-- <a href="{{ route('legalnotice.bills.preview', $bill->id) }}"
                                                target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a> --}}

                                            {{-- <a href="{{ route('legalnotice.bills.download', $bill->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fa fa-download"></i>
                                            </a> --}}

                                            <form action="{{ route('legalnotice.bills.autopdf', $bill->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    title="Auto Generate PDF">
                                                    <i class="fa fa-file-pdf"></i> Auto PDF
                                                </button>
                                            </form>

                                            <a href="{{ route('legalnotice.bills.edit', $bill->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            {{-- SweetAlert Delete --}}
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-bill"
                                                data-url="{{ route('legalnotice.bills.delete', $bill->id) }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <form id="deleteBillForm" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No bills found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $bills->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const search = document.getElementById('clientSearch');
            const dropdown = document.getElementById('clientDropdown');
            const hiddenId = document.getElementById('clientId');

            search.addEventListener('focus', () => dropdown.classList.remove('d-none'));

            search.addEventListener('input', function() {
                const value = this.value.toLowerCase();
                dropdown.querySelectorAll('.list-group-item').forEach(item => {
                    item.style.display = item.dataset.name.toLowerCase().includes(value) ?
                        'block' :
                        'none';
                });
            });

            dropdown.addEventListener('click', function(e) {
                if (e.target.matches('.list-group-item')) {
                    search.value = e.target.dataset.name;
                    hiddenId.value = e.target.dataset.id;
                    dropdown.classList.add('d-none');
                }
            });

            document.addEventListener('click', function(e) {
                if (!search.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('d-none');
                }
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.btn-delete-bill').forEach(button => {
                button.addEventListener('click', function() {

                    const deleteUrl = this.dataset.url;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This bill will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById('deleteBillForm');
                            form.action = deleteUrl;
                            form.submit();
                        }
                    });

                });
            });

        });
    </script>


</x-app-layout>
