<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Need Update Transfer Cases</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <h3>Need Update Transfer Cases</h3>
    <table>
        <thead>
            <tr>
                <th>S/L No</th>
                <th>File number</th>
                <th>On behalf of</th>
                <th>Branch</th>
                <th>Loan A/C Or Member Or CIN </th>
                <th>Name of the parties</th>
                <th>Court Name</th>
                <th>Case Number</th>
                <th>Section</th>
                <th>Next Hearing Date</th>
                <th>Next Step</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cases as $case)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $case->file_number }}</td>
                    <td>{{ $case->client_name }}</td>
                    <td>{{ optional($case->clientbranch)->name ?? '' }}</td>
                    <td>{{ $case->loan_account_acquest_cin ?? '' }}</td>
                    <td>{{ $case->name_of_parties }}</td>
                    <td>{{ $case->court->name }}</td>
                    <td>{{ $case->case_number }}</td>
                    <td>{{ $case->section }}</td>
                    <td>{{ \Carbon\Carbon::parse($case->next_hearing_date)->format('d M Y') }}</td>
                    <td>{{ $case->next_step }}</td>
                    <td>
                        {!! $case->status == 1 ? '<span class="running">Running</span>' : '<span class="dismiss">Dismiss</span>' !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
