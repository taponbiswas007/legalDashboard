<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <!-- Breadcrumb Section -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Today updated
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                <div class="table_container">
                    <table>
                        <thead>
                            <tr>
                                <th>S/L No</th>
                                <th>Update Date and Time</th>
                                <th>File number</th>
                                <th>On behalf of</th>
                                <th>Branch</th>
                                <th>Loan A/C OR Member OR CIN</th>
                                <th>Mobile Number</th>
                                <th>Name of the parties</th>
                                <th>Court Name</th>
                                <th>Case Number</th>
                                <th>Section</th>
                                <th>Legal Notice Date</th>
                                <th>Filing / Received Date</th>
                                <th>Previous Date</th>
                                <th>Previous Step</th>
                                <th>Next Hearing Date</th>
                                <th>Next Step</th>
                                <th>Documents</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="caseTable">
                            @forelse ($todayUpdateds as $index => $case)
                                <tr>
                                    <td class="text-center">
                                        {{ $index + 1 + ($todayUpdateds->currentPage() - 1) * $todayUpdateds->perPage() }}
                                    </td>
                                    <td class="update-datetime">
                                        {{ \Carbon\Carbon::parse($case->updated_at)->format('d-M-Y h:i A') }}</td>
                                    <td class="filenumber">{{ $case->file_number }}</td>
                                    <td>{{ $case->addclient->name }}</td>
                                    <td>{{ optional($case->clientbranch)->name }}</td>
                                    <td>{{ $case->loan_account_acquest_cin }}</td>
                                    <td>{{ $case->addclient->number }}</td>
                                    <td>{{ $case->name_of_parties }}</td>
                                    <td>{{ $case->court->name }}</td>
                                    <td class="casenumber">{{ $case->case_number }}</td>
                                    <td class="section">{{ $case->section }}</td>
                                    <td class="legal-date">
                                        {{ \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') }}</td>
                                    <td class="received-date">
                                        {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : 'N/A' }}
                                    </td>
                                    <td class="prev-date">
                                        {{ \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') }}
                                    </td>
                                    <td>{{ $case->previous_step }}</td>
                                    <td class="next-date">
                                        {{ \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') }}</td>
                                    <td>{{ $case->next_step }}</td>
                                    <td>
                                        @if ($case->legal_notice)
                                            <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('legalnotice.lndownload', $case->id) }}"
                                                    class="text-primary">
                                                    Legal notice <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('legalnotice.lndelete', $case->id) }}', 'Legal Notice')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div><br>
                                        @endif
                                        @if ($case->plaints)
                                            <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('plaints.pldownload', $case->id) }}"
                                                    class="text-primary">
                                                    Plaints <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('plaints.pldelete', $case->id) }}', 'Plaints')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div><br>
                                        @endif
                                        @if ($case->others_documents)
                                            <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('otherdocuments.othddownload', $case->id) }}"
                                                    class="text-primary">
                                                    Other Documents <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('otherdocuments.othddelete', $case->id) }}', 'Other Documents')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (!$case->legal_notice && !$case->plaints && !$case->others_documents)
                                            <span class="text-muted">No files</span>
                                        @endif
                                    </td>
                                    <td>
                                        {!! $case->status == 1 ? '<span class="running">Running</span>' : '<span class="dismiss">Dismiss</span>' !!}

                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary"
                                            href="{{ route('addcase.edit', Crypt::encrypt($case->id)) }}">Edit</a>
                                        {{-- <form id="delete-form-{{ $case->id }}"
                                            action="{{ route('addcase.destroy', $case->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-700 confirmDelete"
                                                data-id="{{ $case->id }}"><i class="fa-solid fa-trash"></i></button>
                                        </form> --}}

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="19">No data here</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if ($todayUpdateds->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $todayUpdateds->firstItem() ?? 0 }} to {{ $todayUpdateds->lastItem() ?? 0 }} of
                            {{ $todayUpdateds->total() }} entries
                        </div>
                        <div>
                            {{ $todayUpdateds->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function deleteFile(url, fileName) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete ${fileName}? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.message
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while deleting the file.'
                            });
                        });
                }
            });
        }
    </script>
</x-app-layout>
