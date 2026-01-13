<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card border-0 shadow mb-3">
            <div class="card-body">
                <h1 class=" fw-bold fs-5 text-center">File Number: <span
                        style="color:rgb(4, 4, 118);">{{ $file_number }}</span></h1>
            </div>
        </div>

        <div class="card border-0 shadow mb-3">
            <div class="card-body">
                <!-- Display current cases -->
                <h2 class=" pb-3 fw-bold fs-5">Present status</h2>

                <div class="table_container">
                    <table>
                        <thead>
                            <tr>

                                <th>File number</th>
                                <th>On behalf of</th>
                                <th>Mobile Number</th>
                                <th>Name of the parties</th>
                                <th>Branch</th>
                                <th>Loan/Acquest A/C</th>
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

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cases as  $case)
                                <tr>

                                    <td>{{ $case->file_number }}</td>
                                    <td>{{ $case->addclient->name }}</td>
                                    <td>{{ $case->branch }}</td>
                                    <td>{{ $case->loan_account_acquest_cin }}</td>
                                    <td>{{ $case->addclient->number }}</td>
                                    <td>{{ $case->name_of_parties }}</td>
                                    <td>{{ optional($case->court)->name ?? '—' }}</td>
                                    <td>{{ $case->case_number }}</td>
                                    <td>{{ $case->section }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') }}</td>
                                    <td>
                                        {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') }}
                                    </td>
                                    <td>{{ $case->previous_step }}</td>
                                    <td>
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

                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="15">No data here</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
                @if (session('error'))
                    <script>
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: '{{ session('error') }}',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                    </script>
                @endif
            </div>
        </div>
        <div class="card border-0 shadow">
            <div class="card-body">
                <!-- Display historical cases -->
                <h2 class=" pb-3 fw-bold fs-5">Full history of this case</h2>

                <div class="table_container">
                    <table>
                        <thead>
                            <tr>
                                <th>S/L No</th>
                                <th>Data update Date & Time</th>
                                <th>Branch</th>
                                <th>Loan/Acquest A/C</th>
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

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historicalCases as $history)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d-M-Y h:i a') }}</td>
                                    <td>{{ $history->branch }}</td>
                                    <td>{{ $history->loan_account_acquest_cin }}</td>
                                    <td>{{ optional($history->court)->name ?? '—' }}</td>
                                    <td>{{ $history->case_number }}</td>
                                    <td>{{ $history->section }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($history->legal_notice_date)->format('d-M-Y') }}</td>
                                    <td>
                                        {{ $history->filing_or_received_date ? \Carbon\Carbon::parse($history->filing_or_received_date)->format('d-M-Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($history->previous_date)->format('d-M-Y') }}
                                    </td>
                                    <td>{{ $history->previous_step }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($history->next_hearing_date)->format('d-M-Y') }}</td>
                                    <td>{{ $history->next_step }}</td>
                                    <td>
                                        @if ($history->legal_notice)
                                            <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('legalnotice.olndownload', $history->id) }}"
                                                    class="text-primary">
                                                    Legal notice <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('legalnotice.olndelete', $history->id) }}', 'Legal Notice')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div><br>
                                        @endif
                                        @if ($history->plaints)
                                            <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('plaints.opldownload', $history->id) }}"
                                                    class="text-primary">
                                                    Plaints <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('plaints.opldelete', $history->id) }}', 'Plaints')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div><br>
                                        @endif
                                        @if ($history->others_documents)
                                            <div class="d-inline-flex gap-1 align-items-center mb-1">
                                                <a href="{{ route('otherdocuments.oothddownload', $history->id) }}"
                                                    class="text-primary">
                                                    Other Documents <i class="fa-solid fa-download"></i>
                                                </a>
                                                <button
                                                    onclick="deleteFile('{{ route('otherdocuments.oothddelete', $history->id) }}', 'Other Documents')"
                                                    class="btn btn-sm btn-danger py-0 px-1">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (!$history->legal_notice && !$history->plaints && !$history->others_documents)
                                            <span class="text-muted">No files</span>
                                        @endif
                                    </td>
                                    <td>
                                        {!! $history->status == 1 ? '<span class="running">Running</span>' : '<span class="dismiss">Dismiss</span>' !!}

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="15">No data here</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
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
