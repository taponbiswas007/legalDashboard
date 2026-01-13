<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Case Bill Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        
        .header .subtitle {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 5px;
        }
        
        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .company-info h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 20px;
        }
        
        .company-info p {
            margin: 5px 0;
            color: #7f8c8d;
        }
        
        .bill-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 25px;
        }
        
        .bill-info h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #2c3e50;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .bill-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }
        
        .bill-item strong {
            color: #2c3e50;
            min-width: 120px;
            display: inline-block;
        }
        
        .table-container {
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            border: 1px solid #34495e;
        }
        
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .summary {
            background: #e8f4fd;
            border: 1px solid #b6d7e8;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-style: italic;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .total-row {
            background-color: #2c3e50 !important;
            color: white;
            font-weight: bold;
        }
        
        .amount-cell {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="company-info">
        <h2>{{ config('app.name', 'Law Firm Management System') }}</h2>
        <p>Case Bill Report</p>
    </div>

    <div class="header">
        <h1>CASE BILL INVOICE</h1>
        <div class="subtitle">
            Generated on: {{ date('F d, Y h:i A') }}
        </div>
    </div>

    <!-- Bill Details Section -->
    <div class="bill-info">
        <h3>BILL INFORMATION</h3>
        <div class="bill-details">
            @if(isset($job_title) && $job_title)
                <div class="bill-item">
                    <strong>Job Title:</strong> {{ $job_title }}
                </div>
            @endif
            
            @if(isset($address) && $address)
                <div class="bill-item">
                    <strong>Address:</strong> {{ $address }}
                </div>
            @endif
            
            @if(isset($subject) && $subject)
                <div class="bill-item">
                    <strong>Subject:</strong> {{ $subject }}
                </div>
            @endif
            
            <div class="bill-item">
                <strong>Total Items:</strong> {{ count($billableItems) }}
            </div>
            
            @if(isset($totalAmount))
                <div class="bill-item">
                    <strong>Total Amount:</strong> Tk {{ number_format($totalAmount, 2) }}
                </div>
            @endif
        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary">
        <strong>Report Summary: </strong>
        Total {{ count($billableItems) }} billable item(s) 
        @if(isset($totalAmount) && $totalAmount > 0)
            | Total Amount: Tk {{ number_format($totalAmount, 2) }}
        @endif
    </div>

    <!-- Main Table -->
    <div class="table-container">
        @if(count($billableItems) > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">SL</th>
                    <th width="12%">File No</th>
                    <th width="15%">Client Name</th>
                    <th width="10%">Branch</th>
                    <th width="12%">Loan Account</th>
                    <th width="12%">Case Number</th>
                    <th width="12%">Court Name</th>
                    <th width="10%">Hearing Date</th>
                    <th width="12%">Description</th>
                    <th width="10%">Amount (Tk)</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $grandTotal = 0;
                @endphp
                
                @foreach($billableItems as $key => $item)
                    @php
                        $amount = $item['amount'] ?? 0;
                        $grandTotal += $amount;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $item['file_number'] }}</td>
                        <td>{{ $item['client_name'] }}</td>
                        <td>{{ $item['branch'] }}</td>
                        <td>{{ $item['loan_account'] }}</td>
                        <td>{{ $item['case_number'] }}</td>
                        <td>{{ $item['court_name'] }}</td>
                        <td class="text-center">
                            @if(!empty($item['previous_date']))
                                {{ date('d-M-Y', strtotime($item['previous_date'])) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ Str::limit($item['previous_step'] ?? 'N/A', 30) }}</td>
                        <td class="amount-cell">
                            @if($amount > 0)
                                {{ number_format($amount, 2) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr class="total-row">
                    <td colspan="9" class="text-right"><strong>Grand Total:</strong></td>
                    <td class="amount-cell"><strong>Tk {{ number_format($grandTotal, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>

        @else
        <div class="no-data">
            <h3>No Billable Items Found</h3>
            <p>No items with amount specified for billing.</p>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>This is an auto-generated case bill invoice from {{ config('app.name', 'Law Firm Management System') }}</p>
        <p>Page 1 of 1 | Generated by: System</p>
    </div>

</body>
</html>