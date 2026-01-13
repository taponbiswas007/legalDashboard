<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Need Update Cases Report</title>
    <style>
        @page {
            margin: 20px;
            size: landscape;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
            color: #2c3e50;
        }

        .header .subtitle {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .info-section {
            margin-bottom: 15px;
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .info-item {
            flex: 1;
        }

        .info-label {
            font-weight: bold;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: auto;
        }

        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            padding: 6px 4px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 9px;
        }

        td {
            padding: 5px 3px;
            border: 1px solid #ddd;
            font-size: 8px;
            vertical-align: top;
            word-wrap: break-word;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .status-running {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .status-closed {
            background-color: #f8d7da;
            color: #721c24;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .page-break {
            page-break-before: always;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8px;
            color: #7f8c8d;
        }

        .total-count {
            background-color: #e9ecef;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        /* Compact styles for better fit */
        .compact-table th,
        .compact-table td {
            padding: 3px 2px;
            font-size: 7px;
        }

        .nowrap {
            white-space: nowrap;
        }

        .multiline {
            white-space: pre-line;
            max-width: 80px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Need Update Cases Report</h1>
        <div class="subtitle">
            Generated on: {{ \Carbon\Carbon::now()->format('d-M-Y h:i A') }}
        </div>
    </div>


    @if ($cases->count() > 0)
        <div class="total-count">
            Showing {{ $cases->count() }} cases that need next hearing date update
        </div>

        <!-- FIRST TABLE (Initial render) -->
        <table class="compact-table">
            <thead>
                <tr>
                    <th width="3%">SL</th>
                    <th width="8%">File No</th>
                    <th width="10%">Client</th>
                    <th width="8%">Branch</th>
                    <th width="8%">Loan A/C Or Member Or CIN </th>
                    <th width="8%">Mobile</th>
                    <th width="12%">Parties</th>
                    <th width="10%">Court</th>
                    <th width="8%">Case No</th>
                    <th width="6%">LN Date</th>
                    <th width="6%">Filing Date</th>
                    <th width="6%">Prev Date</th>
                    <th width="8%">Previous Step</th>
                    <th width="6%">Next Date</th>
                    <th width="8%">Next Step</th>
                    <th width="5%">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $pageCount = 1;
                    $itemsPerPage = 18;
                    $totalItems = $cases->count();
                @endphp

                @foreach ($cases as $index => $case)
                    @php
                        $serialNumber = $index + 1;
                        $isPageBreak = $index > 0 && $index % $itemsPerPage == 0;
                    @endphp

                    @if ($isPageBreak)
            </tbody>
        </table>

        <!-- PAGE BREAK AND NEW TABLE -->
        <div class="page-break"></div>
        <div class="header">
            <h1>Need Update Cases Report (Cont...)</h1>
            <div class="subtitle">Page {{ ++$pageCount }}</div>
        </div>

        <table class="compact-table">
            <thead>
                <tr>
                    <th width="3%">SL</th>
                    <th width="8%">File No</th>
                    <th width="10%">Client</th>
                    <th width="8%">Branch</th>
                    <th width="8%">Loan A/C Or Member Or CIN </th>
                    <th width="8%">Mobile</th>
                    <th width="12%">Parties</th>
                    <th width="10%">Court</th>
                    <th width="8%">Case No</th>
                    <th width="6%">LN Date</th>
                    <th width="6%">Filing Date</th>
                    <th width="6%">Prev Date</th>
                    <th width="8%">Previous Step</th>
                    <th width="6%">Next Date</th>
                    <th width="8%">Next Step</th>
                    <th width="5%">Status</th>
                </tr>
            </thead>
            <tbody>
    @endif

    <tr>
        <td class="text-center nowrap">{{ $serialNumber }}</td>
        <td class="nowrap">{{ $case->file_number }}</td>
        <td class="multiline" title="{{ $case->addclient->name ?? 'N/A' }}">
            {{ Str::limit($case->addclient->name ?? 'N/A', 20) }}
        </td>
        <td class="nowrap">{{ optional($case->clientbranch)->name ?? '' }}</td>
        <td class="nowrap">{{ $case->loan_account_acquest_cin ?? '' }}</td>
        <td class="nowrap">{{ $case->addclient->number ?? 'N/A' }}</td>
        <td class="multiline" title="{{ $case->name_of_parties }}">
            {{ Str::limit($case->name_of_parties, 25) }}
        </td>
        <td class="multiline" title="{{ $case->court->name }}">
            {{ $case->court->name }}
        </td>
        <td class="nowrap">{{ $case->case_number }}</td>
        <td class="nowrap">
            {{ $case->legal_notice_date ? \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') : 'N/A' }}
        </td>
        <td class="nowrap">
            {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : 'N/A' }}
        </td>
        <td class="nowrap">
            {{ $case->previous_date ? \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') : 'N/A' }}
        </td>
        <td class="multiline" title="{{ $case->previous_step }}">
            {{ Str::limit($case->previous_step, 30) }}
        </td>
        <td class="nowrap">
            {{ $case->next_hearing_date ? \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') : 'N/A' }}
        </td>
        <td class="multiline" title="{{ $case->next_step }}">
            {{ Str::limit($case->next_step, 30) }}
        </td>
        <td class="text-center">
            @if ($case->status == 1)
                <span class="status-running">Running</span>
            @else
                <span class="status-closed">Closed</span>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
    </table>

    <div class="footer">
        <div>Generated by: {{ Auth::user()->name ?? 'System' }}</div>
        <div>Law Firm Management System | {{ config('app.name', 'Laravel') }}</div>
        <div>Page <span class="page-number">1</span> of <span class="page-count">{{ $pageCount }}</span></div>
    </div>
@else
    <div class="text-center" style="padding: 40px; color: #7f8c8d;">
        <h3>No cases found that need update</h3>
        <p>All cases are up to date with their next hearing dates.</p>
    </div>
    @endif

    <script type="text/javascript">
        // Page numbering script
        var totalPages = {{ $pageCount ?? 1 }};
        document.querySelectorAll('.page-number').forEach(function(el) {
            el.textContent = '1';
        });
        document.querySelectorAll('.page-count').forEach(function(el) {
            el.textContent = totalPages;
        });
    </script>
</body>

</html>
