<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Next Hearing Cases</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
     <img style="position:absolute;
        top: 50%;
        left: 50%;
        transform: translate( -50% , -50%);
        z-index:1;
        filter:opacity(0.07);
        opacity:0.07;
        "
                src="{{ asset('backend_assets/images/logo.png') }}" alt="">
                <div style="position: relative; z-index: 2">
                      <h1
                style="font-size: 20px;
            font-weight: 400;
            line-height: 14px;
            text-align: center;
            color: #22222299;
            text-wrap: nowrap;
           padding: 2px; text-wrap:nowrap;
            ">
                SK. SHARIF & ASSOCIATES</h1>
    @foreach($chunks as $chunk)
        <h2>Next Hearing Case List ({{ now()->format('d M Y') }})</h2>
        <table>
            <thead>
                <tr>
                    <th>S/L No</th>
                    <th>File number</th>
                    <th>On behalf of</th>
                    <th>Branch, Loan A/C, CIN</th>
                    <th>Mobile Number</th>
                    <th>Name of the parties</th>
                    <th>Court Name</th>
                    <th>Case Number</th>
                    <th>Legal Notice Date</th>
                    <th>Filing / Received Date</th>
                    <th>Previous Date</th>
                    <th>Previous Step</th>
                    <th>Next Hearing Date</th>
                    <th>Next Step</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chunk as $case)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $case->file_number }}</td>
                        <td>{{ $case->addclient->name }}</td>
                        @if($case->branch_id && $case->clientbranch)
                            <td>{{ $case->clientbranch->name }}</td>
                        @else
                            <td>{{ $case->loan_account_acquest_cin }}</td>
                        @endif
                        <td>{{ $case->addclient->number }}</td>
                        <td>{{ $case->name_of_parties }}</td>
                        <td>{{ optional($case->court)->name ?? '—' }}td>
                        <td>{{ $case->case_number }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') }}
                        </td>
                        <td>{{ $case->previous_step }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') }}</td>
                        <td>{{ $case->next_step }}</td>
                        <td>
                            {!! $case->status == 1 ? '<span class="running">Running</span>' : '<span class="dismiss">Dismiss</span>' !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</div>
</body>
</html>
