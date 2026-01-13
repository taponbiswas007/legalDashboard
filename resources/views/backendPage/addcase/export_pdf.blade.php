<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cases PDF</title>
    <style>
        @page {
            margin: 90px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        header {
            position: fixed;
            top: -70px;
            left: 0;
            right: 0;
            height: 60px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        header img {
            height: 45px;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 25px;
            text-align: center;
            border-top: 1px solid #ddd;
            font-size: 10px;
        }

        footer .page-number:after {
            content: counter(page);
        }

        h2 {
            text-align: center;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            word-wrap: break-word;
            font-size: 9px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .page-break {
            page-break-after: always;
        }
        
        .sl-no {
            width: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('backend_assets/images/logo.png') }}" alt="Logo" style="height:50px;">
        <div style="font-size: 12px; font-weight: bold;">SK. SHARIF & ASSOCIATES</div>
    </header>

    <footer>
        <div>Page <span class="page-number"></span></div>
    </footer>

    <main>
        <h2>Cases List</h2>

        @foreach ($chunks as $chunkIndex => $chunk)
            @if($chunkIndex > 0)
                <div class="page-break"></div>
                <h2>Cases List (Continued - Page {{ $chunkIndex + 1 }})</h2>
            @endif

            <table>
                <thead>
                    <tr>
                        <th class="sl-no">S/L No</th>
                        <th>File Number</th>
                        <th>On Behalf Of</th>
                        <th>Branch</th>
                        <th>Loan A/C OR Member OR CIN</th>
                        <th>Client Number</th>
                        <th>Name of Parties</th>
                        <th>Court Name</th>
                        <th>Case Number</th>
                        <th>Section</th>
                        <th>Legal Notice Date</th>
                        <th>Filing OR Received Date</th>
                        <th>Previous Date</th>
                        <th>Previous Step</th>
                        <th>Next Hearing Date</th>
                        <th>Next Step</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chunk as $index => $case)
                        <tr>
                            <td class="sl-no">{{ $index + 1 }}</td>
                            <td>{{ $case->file_number }}</td>
                            <td>{{ $case->addclient->name ?? '' }}</td>
                            <td>
                                @if($case->branch_id && $case->clientbranch)
                                    {{ $case->clientbranch->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $case->loan_account_acquest_cin }}</td>
                            <td>{{ $case->addclient->number ?? '' }}</td>
                            <td>{{ $case->name_of_parties }}</td>
                            <td>{{ optional($case->court)->name ?? '—' }}</td>
                            <td>{{ $case->case_number }}</td>
                            <td>{{ $case->section }}</td>
                            <td>{{ $case->legal_notice_date ? \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') : '' }}</td>
                            <td>{{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : '' }}</td>
                            <td>{{ $case->previous_date ? \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') : '' }}</td>
                            <td>{{ $case->previous_step }}</td>
                            <td>{{ $case->next_hearing_date ? \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') : '' }}</td>
                            <td>{{ $case->next_step }}</td>
                            <td>{{ $case->status == 1 ? 'Running' : 'Dismissed' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if(!$loop->last)
                <div style="text-align: center; margin-top: 10px; font-size: 10px; font-style: italic;">
                    Continues on next page...
                </div>
            @endif
        @endforeach
    </main>
</body>
</html>