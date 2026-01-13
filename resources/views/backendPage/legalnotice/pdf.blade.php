<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Legal Notice Report</title>
    <style>
        @page {
            margin: 20px;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            color: #333;
            margin: 0;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #2c3e50;
        }
        
        .header .subtitle {
            font-size: 11px;
            color: #7f8c8d;
            margin-top: 3px;
        }
        
        .filter-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .filter-info h3 {
            margin: 0 0 8px 0;
            font-size: 11px;
            color: #2c3e50;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }
        
        .filter-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 8px;
        }
        
        .filter-item {
            margin-bottom: 4px;
        }
        
        .filter-item strong {
            color: #2c3e50;
            min-width: 100px;
            display: inline-block;
        }
        
        .table-container {
            margin-top: 15px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            table-layout: fixed;
        }
        
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            padding: 6px 4px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 9px;
            word-wrap: break-word;
        }
        
        td {
            padding: 5px 3px;
            border: 1px solid #ddd;
            font-size: 9px;
            vertical-align: top;
            word-wrap: break-word;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        
        .summary {
            background: #e8f4fd;
            border: 1px solid #b6d7e8;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 12px;
            font-size: 10px;
        }
        
        .no-data {
            text-align: center;
            padding: 30px;
            color: #7f8c8d;
            font-style: italic;
        }
        
        /* Text truncation for long content */
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Column specific styles */
        .col-sl { width: 4%; }
        .col-client { width: 18%; }
        .col-branch { width: 15%; }
        .col-account { width: 15%; }
        .col-acquest { width: 18%; }
        .col-section { width: 10%; }
        .col-notice-date { width: 10%; }
        .col-filing-date { width: 10%; }
        .col-comments { width: 15%; }
        
        /* For multi-line content */
        .multiline {
            white-space: pre-line;
            max-height: 30px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LEGAL NOTICE REPORT</h1>
        <div class="subtitle">
            Generated on: {{ date('F d, Y h:i A') }}
        </div>
    </div>

    <!-- Filter Information Section -->
    <div class="filter-info">
        <h3>REPORT CRITERIA</h3>
        <div class="filter-details">
            @php
                $hasClientFilter = request('client_id') && $clients->where('id', request('client_id'))->first();
                $hasCategoryFilter = request('category_id') && $categories->where('id', request('category_id'))->first();
                $hasDateFilter = request('date_from') || request('date_to');
                $hasStatusFilter = request('status');
                $hasFilters = $hasClientFilter || $hasCategoryFilter || $hasDateFilter || $hasStatusFilter;
            @endphp
            
            @if($hasClientFilter)
                <div class="filter-item">
                    <strong>Client Name:</strong> 
                    {{ $clients->where('id', request('client_id'))->first()->name }}
                </div>
            @endif
            
            @if($hasCategoryFilter)
                <div class="filter-item">
                    <strong>Category:</strong> 
                    {{ $categories->where('id', request('category_id'))->first()->name }}
                </div>
            @endif
            
            @if($hasDateFilter)
                <div class="filter-item">
                    <strong>Date Range:</strong> 
                    {{ request('date_from') ? date('d-M-Y', strtotime(request('date_from'))) : 'Start' }} 
                    to 
                    {{ request('date_to') ? date('d-M-Y', strtotime(request('date_to'))) : 'End' }}
                </div>
            @endif
            
            @if($hasStatusFilter)
                <div class="filter-item">
                    <strong>Status:</strong> {{ request('status') }}
                </div>
            @endif
            
            @if(!$hasFilters)
                <div class="filter-item">
                    <strong>Criteria:</strong> All Legal Notices
                </div>
            @endif
        </div>
    </div>

    <!-- Summary Information -->
    <div class="summary">
        <strong>Report Summary:</strong> 
        Total {{ $legalnotices->count() }} legal notice(s) found
        @if($hasStatusFilter)
            with status "{{ request('status') }}"
        @endif
        @if($hasDateFilter)
            between {{ request('date_from') ? date('d-M-Y', strtotime(request('date_from'))) : 'start' }} and {{ request('date_to') ? date('d-M-Y', strtotime(request('date_to'))) : 'end' }}
        @endif
    </div>

    <!-- Main Data Table -->
    <div class="table-container">
        @if($legalnotices->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-sl">SL</th>
                        <th class="col-client">On Behalf Of</th>
                        <th class="col-branch">Branch</th>
                        <th class="col-account">Loan AC / Member / CIN</th>
                        <th class="col-acquest">Name of Acquest</th>
                        <th class="col-section">Section</th>
                        <th class="col-notice-date">Notice Date</th>
                        <th class="col-filing-date">Filing Date Line</th>
                        <th class="col-comments">Comments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($legalnotices as $key => $notice)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="truncate" title="{{ $notice->client->name ?? '' }}">
                                {{ $notice->client->name ?? '—' }}
                            </td>
                            <td class="truncate" title="{{ $notice->clientbranch->name ?? 'N/A' }}">
                                {{ $notice->clientbranch->name ?? 'N/A' }}
                            </td>
                            <td class="truncate" title="{{ $notice->loan_account_acquest_cin ?? 'N/A' }}">
                                {{ $notice->loan_account_acquest_cin ?? 'N/A' }}
                            </td>
                            <td class="truncate" title="{{ $notice->name ?? '' }}">
                                {{ $notice->name ?? '—' }}
                            </td>
                            <td class="truncate" title="{{ $notice->category->name ?? 'N/A' }}">
                                {{ $notice->category->name ?? 'N/A' }}
                            </td>
                            <td>
                                @if($notice->legal_notice_date)
                                    {{ \Carbon\Carbon::parse($notice->legal_notice_date)->format('d-M-Y') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                @if($notice->dateline_for_filing)
                                    {{ \Carbon\Carbon::parse($notice->dateline_for_filing)->format('d-M-Y') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="multiline" title="{{ $notice->comments ?? '' }}">
                                {{ $notice->comments ? Str::limit($notice->comments, 50) : '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <h3>No Data Found</h3>
                <p>No legal notices match the selected criteria.</p>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>This is an auto-generated legal notice report from {{ config('app.name', 'Legal Management System') }}</p>
        <p>Page 1 of 1 | Generated by: {{ Auth::user()->name ?? 'System Administrator' }}</p>
    </div>
</body>
</html>