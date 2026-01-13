<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Client Cases - {{ $addclient->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2, h3, h4 {
            margin: 5px 0;
            text-align: center;
        }
        .client-info {
            margin-bottom: 20px;
            border: 1px solid #666;
            padding: 10px;
            border-radius: 5px;
        }
        .client-info h3 {
            text-align: left;
            margin-bottom: 8px;
        }
        .client-info p {
            margin: 0;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f1f1f1;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <h2>Client Case Report</h2>

    <!-- Client Info -->
    <div class="client-info">
        <h3>{{ $addclient->name }}</h3>
        <p><strong>Mobile:</strong> {{ $addclient->number ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $addclient->email ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $addclient->address ?? 'N/A' }}</p>
    </div>

    <!-- Table Title -->
    <h4>{{ ucfirst($tab) }} Cases</h4>

    <!-- Cases Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>File No</th>
                <th>Name of Parties</th>
                <th>Court Name</th>
                <th>Case Number</th>
                <th>Section</th>
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
            @forelse($cases as $i => $case)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $case->file_number }}</td>
                    <td>{{ $case->name_of_parties }}</td>
                    <td>{{ $case->court_name }}</td>
                    <td>{{ $case->case_number }}</td>
                    <td>{{ $case->section }}</td>
                    <td> {{ $case->legal_notice_date ? \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') : '—' }}</td>
                    <td> {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : '—' }}</td>
                    <td>  {{ $case->previous_date ? \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') : '—' }}</td>
                    <td>{{ $case->previous_step }}</td>
                    <td> {{ $case->next_hearing_date ? \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') : '—' }}</td>
                    <td>{{ $case->next_step }}</td>
               
                    <td>{{ $tab === 'disposal' ? 'Disposal' : 'Running' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">No {{ $tab }} cases found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="text-align:center; font-size:10px; color:#777; margin-top:30px;">
        Generated on {{ now()->format('d M, Y h:i A') }}
    </p>
</body>
</html>
