<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Summary - {{ $file_number }}</title>
    <style>
        @media print {
            @page {
                margin: 0.5in;
                size: letter;
            }
            
            body {
                font-family: 'Arial', sans-serif;
                font-size: 12px;
                line-height: 1.4;
                color: #000;
                background: white !important;
            }
            
            .no-print {
                display: none !important;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .print-header {
                border-bottom: 2px solid #333;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }
            
            .section {
                margin-bottom: 25px;
                page-break-inside: avoid;
            }
            
            .section-title {
                background: #f5f5f5;
                padding: 8px 12px;
                border-left: 4px solid #333;
                margin-bottom: 15px;
                font-weight: bold;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }
            
            table th {
                background: #f8f9fa;
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
                font-weight: bold;
            }
            
            table td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            
            .badge {
                padding: 3px 8px;
                border-radius: 3px;
                font-size: 10px;
                font-weight: bold;
            }
            
            .badge-success {
                background: #d4edda;
                color: #155724;
            }
            
            .badge-secondary {
                background: #e2e3e5;
                color: #383d41;
            }
            
            .text-primary { color: #000 !important; }
            .text-muted { color: #666 !important; }
            .fw-bold { font-weight: bold !important; }
        }
        
        .print-actions {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            opacity: 0.1;
            font-size: 48px;
            color: #000;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <!-- Print Actions (Only visible on screen) -->
    <div class="print-actions no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print me-1"></i>Print Now
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            <i class="fas fa-times me-1"></i>Close
        </button>
        <button onclick="downloadAsPDF()" class="btn btn-success">
            <i class="fas fa-download me-1"></i>Download PDF
        </button>
    </div>

    <!-- Watermark -->
    <div class="watermark no-print">
        CASE SUMMARY
    </div>

    <!-- Header Section -->
    <div class="print-header">
        <table width="100%">
            <tr>
                <td width="50%">
                    <h1 style="margin: 0; font-size: 24px; color: #333;">Case File Summary</h1>
                    <p style="margin: 5px 0 0 0; color: #666;">Generated on: {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }}</p>
                </td>
                <td width="50%" style="text-align: right;">
                    <h2 style="margin: 0; font-size: 20px; color: #333;">File Number: {{ $file_number }}</h2>
                    @if($case)
                    <p style="margin: 5px 0 0 0;">
                        Status: 
                        <span class="badge {{ $case->status == 1 ? 'badge-success' : 'badge-secondary' }}">
                            {{ $case->status == 1 ? 'RUNNING' : 'DISMISSED' }}
                        </span>
                    </p>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Current Case Details -->
    <div class="section">
        <div class="section-title">CURRENT CASE DETAILS</div>
        
        @if($case)
        <table>
            <tr>
                <th width="25%">Field</th>
                <th width="75%">Details</th>
            </tr>
            <tr>
                <td><strong>File Number</strong></td>
                <td>{{ $case->file_number }}</td>
            </tr>
            <tr>
                <td><strong>Client Name</strong></td>
                <td>{{ $case->addclient->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Contact Number</strong></td>
                <td>{{ $case->addclient->number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Parties Involved</strong></td>
                <td>{{ $case->name_of_parties }}</td>
            </tr>
            <tr>
                <td><strong>Branch & Account</strong></td>
                <td>
                    Branch: {{ $case->branch }} | 
                    Loan/Account: {{ $case->loan_account_acquest_cin }}
                </td>
            </tr>
            <tr>
                <td><strong>Court Details</strong></td>
                <td>
                    Court: {{ optional($case->court)->name ?? '—' }} | 
                    Case No: {{ $case->case_number }} | 
                    Section: {{ $case->section ?? '—' }}
                </td>
            </tr>
            <tr>
                <td><strong>Important Dates</strong></td>
                <td>
                    Legal Notice: {{ $case->legal_notice_date ? \Carbon\Carbon::parse($case->legal_notice_date)->format('d M Y') : '—' }} | 
                    Filing Date: {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d M Y') : '—' }}
                </td>
            </tr>
            <tr>
                <td><strong>Hearing Schedule</strong></td>
                <td>
                    Previous: {{ $case->previous_date ? \Carbon\Carbon::parse($case->previous_date)->format('d M Y') : '—' }} | 
                    Next: {{ $case->next_hearing_date ? \Carbon\Carbon::parse($case->next_hearing_date)->format('d M Y') : '—' }}
                </td>
            </tr>
            <tr>
                <td><strong>Case Steps</strong></td>
                <td>
                    Previous: {{ $case->previous_step ?? '—' }} | 
                    Next: {{ $case->next_step ?? '—' }}
                </td>
            </tr>
        </table>
        @else
        <p>No current case data available.</p>
        @endif
    </div>

    <!-- Case History -->
    <div class="section">
        <div class="section-title">CASE HISTORY TIMELINE</div>
        
        @if($historicalCases->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">Date</th>
                    <th width="20%">Court & Case</th>
                    <th width="15%">Hearing Dates</th>
                    <th width="25%">Steps</th>
                    <th width="10%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historicalCases->sortByDesc('created_at') as $history)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d M Y') }}</td>
                    <td>
                        <strong>Court:</strong> {{ optional($history->court)->name ?? '—' }}<br>
                        <strong>Case No:</strong> {{ $history->case_number }}
                    </td>
                    <td>
                        <strong>Prev:</strong> {{ $history->previous_date ? \Carbon\Carbon::parse($history->previous_date)->format('d M Y') : '—' }}<br>
                        <strong>Next:</strong> {{ $history->next_hearing_date ? \Carbon\Carbon::parse($history->next_hearing_date)->format('d M Y') : '—' }}
                    </td>
                    <td>
                        <strong>Prev Step:</strong> {{ Str::limit($history->previous_step ?? '—', 30) }}<br>
                        <strong>Next Step:</strong> {{ Str::limit($history->next_step ?? '—', 30) }}
                    </td>
                    <td>
                        <span class="badge {{ $history->status == 1 ? 'badge-success' : 'badge-secondary' }}">
                            {{ $history->status == 1 ? 'Running' : 'Dismissed' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No historical records available.</p>
        @endif
    </div>

    <!-- Documents Summary -->
    <div class="section">
        <div class="section-title">DOCUMENTS SUMMARY</div>
        
        @if($case && ($case->legal_notice || $case->plaints || $case->others_documents))
        <table>
            <tr>
                <th>Document Type</th>
                <th>Availability</th>
            </tr>
            <tr>
                <td>Legal Notice</td>
                <td>{{ $case->legal_notice ? 'Available' : 'Not Available' }}</td>
            </tr>
            <tr>
                <td>Plaints</td>
                <td>{{ $case->plaints ? 'Available' : 'Not Available' }}</td>
            </tr>
            <tr>
                <td>Other Documents</td>
                <td>{{ $case->others_documents ? 'Available' : 'Not Available' }}</td>
            </tr>
        </table>
        @else
        <p>No documents available for this case.</p>
        @endif
    </div>

    <!-- Footer -->
    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; color: #666;">
        <p>This is an auto-generated case summary from Legal Case Management System</p>
        <p>Page generated on: {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }}</p>
    </div>

    <script>
        function downloadAsPDF() {
            window.print();
        }
        
        // Auto-print if needed
        @if(request()->has('autoprint'))
        window.onload = function() {
            window.print();
        }
        @endif
        
        // Close window after print
        window.onafterprint = function() {
            // Optional: auto-close after printing
            // setTimeout(() => window.close(), 1000);
        };
    </script>
</body>
</html>