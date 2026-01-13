<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bill #{{ $bill->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color:#222; }
        .header { display:flex; justify-content:space-between; margin-bottom:20px; }
        .table { width:100%; border-collapse: collapse; margin-top:10px; }
        .table th, .table td { border:1px solid #ddd; padding:8px; text-align:left; }
        .total { text-align:right; margin-top:20px; font-size:14px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h2>Billing</h2>
            <div>Client: {{ $bill->client->name ?? 'N/A' }}</div>
            <div>Branch: {{ $bill->branch ?? '-' }}</div>
        </div>
        <div>
            <div><strong>Bill ID:</strong> {{ $bill->id }}</div>
            <div><strong>Date:</strong> {{ $bill->created_at->format('d/m/Y') }}</div>
        </div>
    </div>

    <div>
        <strong>Job Title:</strong> {{ $bill->jobtitle ?? '-' }} <br>
        <strong>Address:</strong> {{ $bill->address ?? '-' }} <br>
        <strong>Subject:</strong> {{ $bill->subject ?? '-' }}
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Case ID</th>
                <th>Step Name</th>
                <th style="text-align:right">Rate (BDT)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->steps as $i => $step)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $step->case_id ?? '-' }}</td>
                <td>{{ $step->step_name }}</td>
                <td style="text-align:right">{{ number_format($step->rate, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <strong>Total: </strong> {{ number_format($bill->total_amount, 2) }} BDT
    </div>
</body>
</html>
