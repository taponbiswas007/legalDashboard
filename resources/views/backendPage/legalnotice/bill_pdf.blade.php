<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Legal Notice Bill - SK. SHARIF & ASSOCIATES</title>
    <style>
        /* Page Margins - Adjusted */
        @page {
            margin: 0cm 0.8cm 0cm 0.8cm;
            /* Reduced top margin, increased side margins */
            size: A4 portrait;
        }

        /* Watermark Logo */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.06;
            /* Reduced opacity */
            z-index: -1;
            pointer-events: none;
        }

        .watermark img {
            width: 600px;
            /* Reduced size */
            height: 600px;
        }

        /* Header - Adjusted Position */
        .pdf-header {
            position: fixed;
            top: 0.1cm;
            /* Reduced from -2.2cm */
            left: 0.3cm;
            right: 0.3cm;
            text-align: center;
            border-bottom: 2px solid #1a3a5f;
            padding-bottom: 0.1cm;
            /* Reduced padding */
            background: white;
            z-index: 1000;
        }

        /* Footer - Adjusted Position */
        .pdf-footer {
            position: fixed;
            bottom: 0cm;
            /* Adjusted */
            left: 0.3cm;
            right: 0.3cm;
            text-align: center;
            font-size: 8px;
            color: #666;
            background: white;
            z-index: 1000;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            /* Reduced base font size */
            line-height: 1.2;
            color: #333;
            margin: 0;
            padding: 3.3cm 0 3.4cm 0;

        }

        .container {
            padding: 0cm 0.3cm;
            /* Reduced side padding */
        }

        .firm-name {
            font-size: 45px;
            /* Reduced from 50px */
            line-height: 1.2;
            font-weight: bold;
            color: #73a366ff;
            margin-bottom: 0.05cm;
        }

        .head-of-chamber {
            font-size: 16px;
            /* Reduced from 20px */
            font-weight: bold;
            color: #1a3a5f;
            margin-bottom: 0.05cm;
            text-align: center;
        }

        .contact-info {
            width: 100%;
            margin: 0.1cm 0;
            /* Reduced margin */
        }

        .contact-info td {
            vertical-align: top;
            padding: 0.05cm 0.1cm;
            /* Reduced padding */
            font-size: 8px;
            /* Reduced font size */
        }

        .contact-title {
            font-weight: bold;
            color: #1a3a5f;
            font-size: 10px;
            /* Reduced from 14px */
            text-decoration: underline;
        }

        .contact-subtitle {
            font-size: 9px;
            /* Reduced from 11px */
            line-height: 1.1;
        }

        .document-title {
            text-align: end;
            font-size: 14px;
            /* Reduced from 16px */
            font-weight: bold;
            margin: 0.2cm 0;
            /* Reduced margin */
        }

        .client-info {
            margin: 0 0 0.2cm 0;
            /* Reduced margin */
            padding: 0.2cm;
            /* Reduced padding */
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            line-height: 1.3;
            font-size: 10px;
            height: 100px;
        }

        table.bill-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0.2cm 0;
            /* Reduced margin */
            font-size: 9px;
            /* Reduced font size */
        }

        table.bill-table th {
            background-color: #1a3a5f83;
            color: white;
            padding: 0.1cm 0.05cm;
            /* Reduced padding */
            text-align: left;
            border: 1px solid #ddd;
            font-size: 9px;
        }

        table.bill-table td {
            padding: 0.1cm 0.05cm;
            /* Reduced padding */
            border: 1px solid #ddd;
            font-size: 9px;
        }

        .payment-section {
            margin: 3px 0;
            /* Reduced margin */
            padding: 3px;
            /* Reduced padding */
            padding-top: 0px;
            border-radius: 5px;
            border-left: 3px solid #1a3a5f;
        }

        .payment-section h4 {
            color: #1a3a5f;
            margin-bottom: 3px;
            font-size: 10px;
            /* Reduced font size */
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }

        .payment-detail {
            margin-bottom: 3px;
            font-size: 8px;
            /* Reduced font size */
            line-height: 1.2;
        }

        .signature-area {
            margin-top: 0.5cm;
            /* Reduced margin */
            text-align: right;
            font-size: 9px;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            width: 150px;
            /* Reduced width */
            margin-left: auto;
            margin-bottom: 0.05cm;
        }

        /* Compact table for header */
        .simple-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7px;
            /* Further reduced */
            margin-top: 0.1cm;
        }

        .simple-table td {
            padding: 0.02cm;
            /* Further reduced */
            vertical-align: top;
            line-height: 1.1;
        }

        /* Ensure content doesn't overlap */
        .content-wrapper {
            position: relative;
            z-index: 1;
            padding-top: 0.2cm;
        }

        /* Note section adjustments */
        .note-section {
            margin-top: 8px;
            padding: 6px;
            background: #fff3cd;
            border-radius: 3px;
            border-left: 3px solid #ffc107;
            font-size: 8px;
        }
    </style>
</head>

<body>
    <!-- Watermark Logo -->
    <div class="watermark">
        @php
            $logoPath = public_path('backend_assets/images/logo.png');
            if (file_exists($logoPath)) {
                $logo = base64_encode(file_get_contents($logoPath));
                echo '<img src="data:image/png;base64,' . $logo . '" alt="SK. SHARIF & ASSOCIATES Logo">';
            } else {
                echo '<div style="width: 500px; height: 500px; background: #1a3a5f; color: white; display: flex; align-items: center; justify-content: center; font-size: 40px; text-align: center; opacity: 0.06; transform: rotate(-45deg);">SK. SHARIF & ASSOCIATES</div>';
            }
        @endphp
    </div>

    <!-- Header -->
    <div class="pdf-header">
        <div class="firm-name">SK. SHARIF & ASSOCIATES</div>

        <div class="header-contact">
            <table class="simple-table">
                <tr>
                    <td style="width: 27%;">
                        <div class="contact-title">HIGH COURT CHAMBER:</div>
                        <div class="contact-subtitle">Room No. 412 (Main Building)</div>
                        <div class="contact-subtitle">Supreme Court Bar Association Building</div>
                        <div class="contact-subtitle">Shahbagh, Dhaka- 1100</div>
                        <div class="contact-subtitle">Mobile: 01911-866819</div>
                    </td>
                    <td style="width: 46%;">
                        <div class="head-of-chamber">SK. Shariful Islam</div>
                        <div style="text-align:center; color:#00A038; font-size: 9px">Head of Chamber</div>
                        <div style="text-align:center; color:#00A038; font-size: 9px">Advocate, Supreme Court of
                            Bangladesh</div>
                        <div style="text-align:center; font-size: 9px">Email: sksharifnassociates2002@gmail.com</div>
                    </td>
                    <td style="width: 27%;">
                        <div class="contact-title">JUDGE COURT CHAMBER:</div>
                        <div class="contact-subtitle">Haque Mention, 41/42, Court House Street</div>
                        <div class="contact-subtitle">Room No. 301, Kotwali, Dhaka</div>
                        <div class="contact-subtitle">Mobile: 018960-71040</div>
                        <div class="contact-subtitle">Mobile: 01896-227169</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="pdf-footer">
        <table style="width: 100%;">
            <tr>
                <td colspan="7">
                    <div class="payment-section">
                        <h4>Payment Information</h4>

                        <table style="width: 100%; font-size: 8px;">
                            <tr>
                                <td style="border: none; vertical-align: top;">
                                    <strong>Bank Transfer:</strong><br>
                                    A/C Name: SK. SHARIFUL ISLAM<br>
                                    BBPLC: 1541202728235001<br>
                                    DBBL: 105.101.182525
                                </td>
                                <td style="border: none; vertical-align: top;">
                                    <strong>Mobile Banking:</strong><br>
                                    Bkash: 01710-884561<br>
                                    Cash: Accepted
                                </td>
                                <td style="border: none; vertical-align: top;">
                                    <strong>Verification:</strong><br>
                                    NID: 5017975216754<br>
                                    TIN: 159596771516
                                </td>
                                <td style="border: none; vertical-align: top;">
                                    <!-- Signature Section -->
                                    <div class="signature-area">
                                        <div class="signature-line"></div>
                                        <div><strong>SK. SHARIF & ASSOCIATES</strong></div>
                                        <div>Authorized Signature</div>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <div class="note-section">
                            <strong>Note:</strong> Please make payment promptly and share transaction details for
                            confirmation.
                        </div>
                    </div>
                </td>
            </tr>
        </table>



        <p style="margin: 0 0; font-size: 8px;">
            This is a computer-generated document | Page [[page]] of [[totalPages]]
        </p>
        <p style="margin: 0 0; font-size: 8px;">
            SK. SHARIF & ASSOCIATES | Supreme Court of Bangladesh | Generated: {{ date('d/m/Y H:i') }}
        </p>
    </div>

    <div class="container">
        <div class="content-wrapper">
            <!-- Client Information Section -->
            <div class="client-info">
                <p style="text-align: right ; margin: 0px; font-size: 11px"> Date: {{ date('d/m/Y') }}</p>
                <p style="text-transform: capitalize">
                    To,<br>
                    @if (!empty($customFields['jobTitle']))
                        {{ $customFields['jobTitle'] }},<br>
                    @endif

                    @if ($legalnotices->count() > 0)
                        @php
                            $firstNotice = $legalnotices->first();
                        @endphp
                        @if (!empty($firstNotice->client) && !empty($firstNotice->client->name))
                            {{ $firstNotice->client->name }},<br>
                        @endif
                    @endif

                    @php
                        // Initialize address variable
                        $address = null;

                        // Get custom address if provided
                        if (!empty($customFields['address'])) {
                            $address = trim($customFields['address']);
                        }

                        // Fallback: pull address from client (addclients table) when custom address is missing or empty
                        if (empty($address) && isset($firstNotice)) {
                            if ($firstNotice && $firstNotice->client) {
                                // Try different address fields
                                $address = $firstNotice->client->address;
                                if (empty($address)) {
                                    $address = $firstNotice->client->full_address ?? null;
                                }
                                if (empty($address)) {
                                    $address = $firstNotice->client->present_address ?? null;
                                }
                            }
                        }
                    @endphp

                    @if (!empty($address))
                        {{ $address }}<br>
                    @endif

                    <br>

                    @if (!empty($customFields['subject']))
                        <strong>Subject:</strong> {{ $customFields['subject'] }}
                    @endif
                </p>
            </div>

            <!-- Bill Details Table -->
            <table class="bill-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">
                            <!-- @php
                                $hasBranch = $legalnotices->contains('branch_id', '!=', null);
                                $hasLoanAccount = $legalnotices->contains('loan_account_acquest_cin', '!=', null);

                                if ($hasBranch && $hasLoanAccount) {
                                    echo 'BRANCH / LOAN A/C';
                                } elseif ($hasBranch) {
                                    echo 'BRANCH';
                                } else {
                                    echo 'LOAN A/C or Member or CIN';
                                }
                            @endphp -->
                            BRANCH
                        </th>
                        <th style="width: 17%;">
                            LOAN A/C or Member or CIN
                        </th>
                        <th style="width: 16%;">NAME OF ACQUEST</th>
                        <th style="width: 12%;">Section</th>
                        <th style="width: 20%;">DATE OF LEGAL NOTICE</th>
                        <th style="width: 10%;" class="text-right">Amount (Tk.)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 0;
                    @endphp
                    @forelse($legalnotices as $notice)
                        @if (($notice->bill_amount ?? 0) > 0)
                            @php
                                $counter++;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $counter }}</td>
                                <td>
                                    @if ($notice->branch_id)
                                        {{ $notice->clientbranch->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($notice->loan_account_acquest_cin)
                                        {{ $notice->loan_account_acquest_cin ?? ' ' }}
                                    @endif
                                </td>
                                <td>{{ $notice->name }}</td>
                                <td>{{ $notice->category->name ?? ' ' }}</td>
                                <td>{{ \Carbon\Carbon::parse($notice->legal_notice_date)->format('d/m/Y') }}</td>
                                <td class="text-right">{{ number_format($notice->bill_amount, 2) }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No legal notice bills found</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="6" class="text-right"><strong>Total Amount:</strong></td>
                        <td class="text-right"><strong>TK {{ number_format($totalAmount, 2) }}</strong></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="7" class="text-center">
                            <strong>In Words:
                                {{ \App\Http\Controllers\LegalNoticeController::numberToWords($totalAmount) }}</strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>
