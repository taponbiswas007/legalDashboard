<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today case list</title>
    <!-- font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Prata&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="full_page_wrapper">
        <!-- header area -->
        <div class="header"
            style="height: 87px;
          width: 100%; display:flex; justify-content:space-between; align-items:center">
            <img style="width: 50px " src="{{ asset('backend_assets/images/logo.png') }}" alt="">
            <h1
                style="font-family: Poppins;
            font-size: 20px;
            font-weight: 400;
            line-height: 14px;
            text-align: center;
            color: #22222299;
            text-wrap: nowrap;
            width: 269px;
           padding: 2px; text-wrap:nowrap;
            ">
                SK. SHARIF & ASSOCIATES</h1>
        </div>
        <!-- body -->
        <div class="body_area" style="
        margin: 0 12px;
        position:relative;
        ">
            <!-- water_mark logo -->
            <img style="position:absolute;
        top: 50%;
        left: 50%;
        transform: translate( -50% , -50%);
        z-index:1;
        filter:opacity(0.07);
        "
                src="{{ asset('backend_assets/images/logo.png') }}" alt="">


            <!-- main content -->
            <div class="main_content" style="position: relative;
        z-index: 2">

                <!-- ========================Address details============================ -->



                <!-- title -->
                <table style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                    border:1px solid #000;

                    ">
                                S/L No</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                File number</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                On behalf of</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Mobile Number</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Name of the parties</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Court Name</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Case Number</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Section</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Legal Notice Date</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Filing / Received Date</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Previous Datete</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Previous Step</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Next Hearing Date</th>
                            <th
                                style="font-family: Poppins;
                    font-size: 10px;
                    font-weight: 600;
                    line-height: 14px;
                    text-align: center;
                    color: #000;
                   padding: 2px;
                      border:1px solid #000;
                    ">
                                Next Step</th>


                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($nexthearingcasePrints as $index => $case)
                            <tr>
                                <td
                                    style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222">
                                    {{ $index + 1 }}</td>
                                <td style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222"
                                    class="filenumber">{{ $case->file_number }}</td>
                                <td
                                    style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222">
                                    {{ $case->addclient->name }}</td>
                                <td
                                    style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222">
                                    {{ $case->addclient->number }}</td>
                                <td
                                    style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222">
                                    {{ $case->name_of_parties }}</td>
                                <td
                                    style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222">
                                    {{ $case->court_name }}</td>
                                <td style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222"
                                    class="casenumber">{{ $case->case_number }}</td>
                                <td style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222"
                                    class="section">{{ $case->section }}</td>
                                <td style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222"
                                    class="legal-date">
                                    {{ \Carbon\Carbon::parse($case->legal_notice_date)->format('d-M-Y') }}</td>
                                <td style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222"
                                    class="received-date">
                                    {{ $case->filing_or_received_date ? \Carbon\Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : 'N/A' }}
                                </td>
                                <td style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222"
                                    class="prev-date">
                                    {{ \Carbon\Carbon::parse($case->previous_date)->format('d-M-Y') }}
                                </td>
                                <td
                                    style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222">
                                    {{ $case->previous_step }}</td>
                                <td style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222"
                                    class="next-date">
                                    {{ \Carbon\Carbon::parse($case->next_hearing_date)->format('d-M-Y') }}</td>
                                <td
                                    style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222">
                                    {{ $case->next_step }}</td>



                            </tr>
                        @empty
                            <tr>
                                <td style="font-family: Manrope;
                    font-size: 10px;
                    font-weight: 500;
                    line-height: 20px;
                      border:1px solid #000;
                    text-align: center;

                   padding: 2px; text-wrap:nowrap;
                    color: #222222;
                    "
                                    colspan="13">No data here</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>




            </div>

        </div>

    </div>
</body>

</html>
