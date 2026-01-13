<div class="d-flex justify-content-end mb-2">
    <form method="GET" class="d-flex align-items-center gap-2">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <label class="me-2 text-nowrap">Per Page:</label>
        <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
            @foreach ([5, 10, 20, 50, 100] as $num)
                <option value="{{ $num }}" {{ $perPage == $num ? 'selected' : '' }}>{{ $num }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<div class="table_container table-responsive">
    <table id="caseTable" class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>S/L No</th>
                <th>File number</th>
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
        <tbody>
            @forelse ($cases as $index => $case)
                <tr>
                    <td class="text-center">{{ $index + 1 + ($cases->currentPage() - 1) * $cases->perPage() }}</td>
                    <td>{{ $case->file_number }}</td>
                    <td>{{ $case->name_of_parties }}</td>
                    <td>{{ optional($case->court)->name ?? '—' }}</td>
                    <td>{{ $case->case_number }}</td>
                    <td>{{ $case->section }}</td>
                    <td> {{ $case->legal_notice_date ? \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') : '—' }}
                    </td>
                    <td> {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : '—' }}
                    </td>
                    <td> {{ $case->previous_date ? \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') : '—' }}
                    </td>
                    <td>{{ $case->previous_step }}</td>
                    <td> {{ $case->next_hearing_date ? \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') : '—' }}
                    </td>
                    <td>{{ $case->next_step }}</td>
                    <td>
                        <div class="d-flex flex-column gap-1">
                            @if ($case->legal_notice)
                                <div class="d-inline-flex gap-1 align-items-center">
                                    <a href="{{ route('legalnotice.lndownload', $case->id) }}">Legal notice <i
                                            class="fa-solid fa-download"></i></a>
                                    <button
                                        onclick="deleteFile('{{ route('legalnotice.lndelete', $case->id) }}', 'Legal Notice')"
                                        class="btn btn-sm btn-danger py-0 px-1">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                            @if ($case->plaints)
                                <div class="d-inline-flex gap-1 align-items-center">
                                    <a href="{{ route('plaints.pldownload', $case->id) }}">Plaints <i
                                            class="fa-solid fa-download"></i></a>
                                    <button
                                        onclick="deleteFile('{{ route('plaints.pldelete', $case->id) }}', 'Plaints')"
                                        class="btn btn-sm btn-danger py-0 px-1">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                            @if ($case->others_documents)
                                <div class="d-inline-flex gap-1 align-items-center">
                                    <a href="{{ route('otherdocuments.othddownload', $case->id) }}">Other Docs <i
                                            class="fa-solid fa-download"></i></a>
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
                        </div>
                    </td>
                    <td>{!! $case->status == 1
                        ? '<span class="badge bg-success">Running</span>'
                        : '<span class="badge bg-danger">Dismiss</span>' !!}</td>
                    <td>
                        <a class="btn btn-outline-primary btn-sm"
                            href="{{ route('addcase.edit', Crypt::encrypt($case->id)) }}">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="15" class="text-center text-muted">No data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center">
    <div>
        Showing {{ $cases->firstItem() }} to {{ $cases->lastItem() }} of {{ $cases->total() }} entries
    </div>
    <div>
        {{ $cases->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
