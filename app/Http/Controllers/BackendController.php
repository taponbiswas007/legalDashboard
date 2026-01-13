<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Addcase;
use App\Models\AddcaseHistory;
use App\Models\LegalNotice;
use App\Models\Note;
use Carbon\Carbon;
use App\Exports\NeedUpdateTransferExport;
use App\Exports\NeedUpdateCasesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Addclient;
use App\Models\Court;

class BackendController extends Controller
{

    // Controller - DashboardController.php
    public function dashboard(Request $request)
    {
        $timezone = "Asia/Dhaka";
        $today = Carbon::now($timezone)->startOfDay();

        // Total Cases Count
        $totalCases = Addcase::count();

        // Active Cases (Cases with status not closed/completed)
        $activeCases = Addcase::where('status', '!=', 0)
            ->where('status', '!=', 'Closed')
            ->where('status', '!=', 'Completed')
            ->count();

        // Today's hearings
        $todaysHearings = Addcase::whereDate("next_hearing_date", "=", $today)
            ->where("status", "!=", 0)
            ->count();

        // Total Clients
        $totalClients = Addclient::count();

        // Today's cases for table - WITHOUT client relationship for now
        $addcases = Addcase::whereDate("next_hearing_date", "=", $today)
            ->where("status", "!=", 0)
            ->orderByRaw('CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)')
            ->get();

        // Tomorrow's cases - WITHOUT client relationship for now
        $tomorrow = Carbon::now($timezone)->addDay()->startOfDay();
        $tomorrowCases = Addcase::whereDate("next_hearing_date", "=", $tomorrow)
            ->where("status", "!=", 0)
            ->orderByRaw('CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)')
            ->paginate(5, ["*"], "tomorrow_page");

        // Recent Notes
        $recentNotes = Note::latest()->take(5)->get();

        // Case Status Distribution
        $caseStatusDistribution = Addcase::where('status', '!=', 0)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        // Upcoming hearings (next 7 days) - WITHOUT client relationship for now
        $upcomingHearings = Addcase::whereDate("next_hearing_date", ">=", $today)
            ->whereDate("next_hearing_date", "<=", $today->copy()->addDays(7))
            ->where("status", "!=", 0)
            ->orderBy('next_hearing_date')
            ->take(5)
            ->get();

        // Need update cases with filters - WITHOUT client relationship for now
        $needupdateQuery = Addcase::whereDate("next_hearing_date", "<=", $today)
            ->where("status", "!=", 0)
            ->where(function ($query) {
                $query
                    ->where("next_step", "not like", "%transfer%")
                    ->orWhereNull("next_step");
            });

        // Apply filters
        if ($request->filled("client_id")) {
            $needupdateQuery->where("client_id", $request->client_id);
        }

        if ($request->filled("file_number")) {
            $needupdateQuery->where("file_number", "like", "%" . $request->file_number . "%");
        }

        if ($request->filled("case_number")) {
            $needupdateQuery->where("case_number", "like", "%" . $request->case_number . "%");
        }

        if ($request->filled("court_name")) {
            $needupdateQuery->where("court_name", "like", "%" . $request->court_name . "%");
        }

        if ($request->filled("section")) {
            $needupdateQuery->where("section", "like", "%" . $request->section . "%");
        }

        if ($request->filled("from_date")) {
            $needupdateQuery->whereDate("next_hearing_date", ">=", $request->from_date);
        }

        if ($request->filled("to_date")) {
            $needupdateQuery->whereDate("next_hearing_date", "<=", $request->to_date);
        }

        if ($request->filled("status")) {
            $needupdateQuery->where("status", $request->status);
        }

        $needupdateaddcases = $needupdateQuery
            ->orderByRaw('CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)')
            ->paginate(5, ["*"], "update_page");

        $clients = Addclient::orderBy("name")->get();
        $courts = Court::all();

        $needupdatecount = Addcase::whereDate("next_hearing_date", "<=", $today)
            ->where("status", "!=", 0)
            ->count();

        return view(
            "dashboard",
            compact(
                "totalCases",
                "activeCases",
                "todaysHearings",
                "totalClients",
                "addcases",
                "tomorrowCases",
                "recentNotes",
                "caseStatusDistribution",
                "upcomingHearings",
                "needupdateaddcases",
                "clients",
                "courts",
                "needupdatecount",
            )
        );
    }

    public function dailywork(Request $request)
    {
        $timezone = "Asia/Dhaka";
        $today = Carbon::now($timezone)->startOfDay();

        // Today's cases
        $addcases = Addcase::whereDate("next_hearing_date", "=", $today)
            ->where("status", "!=", 0)
            ->orderByRaw(
                'CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)'
            )
            ->paginate(10, ["*"], "today_page");

        // Tomorrow's cases
        $tomorrow = Carbon::now($timezone)
            ->addDay()
            ->startOfDay();
        $tomorrowCases = Addcase::whereDate("next_hearing_date", "=", $tomorrow)
            ->where("status", "!=", 0)
            ->orderByRaw(
                'CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)'
            )
            ->paginate(10, ["*"], "tomorrow_page");

        $clients = Addclient::orderBy("name")->get();
        // Need update cases with filters
        $needupdateQuery = Addcase::whereDate("next_hearing_date", "<=", $today)
            ->where("status", "!=", 0)
            ->where(function ($query) {
                $query
                    ->where("addcases.next_step", "not like", "%transfer%")
                    ->orWhereNull("addcases.next_step");
            });

        // Apply filters
        if ($request->filled("client_id")) {
            $needupdateQuery->where("client_id", $request->client_id);
        }

        if ($request->filled("file_number")) {
            $needupdateQuery->where(
                "file_number",
                "like",
                "%" . $request->file_number . "%"
            );
        }

        if ($request->filled("case_number")) {
            $needupdateQuery->where(
                "case_number",
                "like",
                "%" . $request->case_number . "%"
            );
        }

        if ($request->filled("court_name")) {
            $needupdateQuery->where(
                "court_name",
                "like",
                "%" . $request->court_name . "%"
            );
        }

        if ($request->filled("section")) {
            $needupdateQuery->where(
                "section",
                "like",
                "%" . $request->section . "%"
            );
        }

        if ($request->filled("from_date")) {
            $needupdateQuery->whereDate(
                "next_hearing_date",
                ">=",
                $request->from_date
            );
        }

        if ($request->filled("to_date")) {
            $needupdateQuery->whereDate(
                "next_hearing_date",
                "<=",
                $request->to_date
            );
        }

        if ($request->filled("status")) {
            $needupdateQuery->where("status", $request->status);
        }

        // $needupdateaddcases = $needupdateQuery
        //     ->orderByRaw(
        //         'CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)'
        //     )
        //     ->paginate(10, ["*"], "update_page");
        $needupdateaddcases = $needupdateQuery
            ->orderBy('next_hearing_date', 'asc') // পুরোনো তারিখ আগে
            ->paginate(10, ['*'], 'update_page');


        return view(
            "backendPage.dailywork",
            compact(
                "addcases",
                "tomorrowCases",
                "needupdateaddcases",
                "clients"
            )
        );
    }

    // PDF Export with Chunk
    public function exportneedUpdatePdfPaginated(Request $request)
    {
        $timezone = "Asia/Dhaka";
        $today = Carbon::now($timezone)->startOfDay();

        $query = Addcase::whereDate("next_hearing_date", "<=", $today)
            ->where("status", "!=", 0)
            ->where(function ($q) {
                $q->where("next_step", "not like", "%transfer%")->orWhereNull(
                    "next_step"
                );
            })
            ->with("addclient");

        // Apply the same filters
        if ($request->filled("client_id")) {
            $query->where("client_id", $request->client_id);
        }

        if ($request->filled("file_number")) {
            $query->where(
                "file_number",
                "like",
                "%" . $request->file_number . "%"
            );
        }

        if ($request->filled("case_number")) {
            $query->where(
                "case_number",
                "like",
                "%" . $request->case_number . "%"
            );
        }

        if ($request->filled("court_name")) {
            $query->where(
                "court_name",
                "like",
                "%" . $request->court_name . "%"
            );
        }

        if ($request->filled("section")) {
            $query->where("section", "like", "%" . $request->section . "%");
        }

        if ($request->filled("from_date")) {
            $query->whereDate("next_hearing_date", ">=", $request->from_date);
        }

        if ($request->filled("to_date")) {
            $query->whereDate("next_hearing_date", "<=", $request->to_date);
        }

        if ($request->filled("status")) {
            $query->where("status", $request->status);
        }

        $cases = $query
            ->orderByRaw(
                'CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)'
            )
            ->get();

        // Use chunk for large datasets
        $pdf = PDF::loadView(
            "backendPage.pdf.need_update_cases_pdf",
            compact("cases")
        )
            ->setPaper("legal", "landscape")
            ->setOption("enable-local-file-access", true)
            ->setOption("isHtml5ParserEnabled", true)
            ->setOption("isRemoteEnabled", true);

        return $pdf->download("need-update-cases-" . date("Y-m-d") . ".pdf");
    }

    // Excel Export
    public function exportNeedUpdateExcel(Request $request)
    {
        return Excel::download(
            new NeedUpdateCasesExport($request),
            "need-update-cases-" . date("Y-m-d") . ".xlsx"
        );
    }

    public function exportNextHearingPdfPaginated()
    {
        $today = Carbon::today();

        $cases = Addcase::whereDate("next_hearing_date", "<=", $today)
            ->where("status", "!=", 0)
            ->where(function ($query) {
                $query
                    ->where("addcases.next_step", "not like", "%transfer%")
                    ->orWhereNull("addcases.next_step");
            })
            ->get();

        // প্রতি পেজে কয়টা রো থাকবে সেট করুন
        $chunks = $cases->chunk(50); // ৫০টা কেস প্রতি পেজে

        $pdf = Pdf::loadView(
            "backendPage.addcase.export_pdf_paginated",
            compact("chunks")
        )
            ->setPaper("legal", "landscape")
            ->setOptions([
                "isHtml5ParserEnabled" => true,
                "isRemoteEnabled" => true,
            ]);

        return $pdf->download(
            "Next-Hearing-Cases-" . now()->format("d-m-Y") . ".pdf"
        );
    }

    // Today case print
    public function todayPrintcase()
    {
        // Set timezone
        $timezone = "Asia/Dhaka";

        // Get today's date
        $today = Carbon::now($timezone)->toDateString();

        // Fetch cases for today
        $addcases = Addcase::whereDate("next_hearing_date", "=", $today)
            ->where("status", "!=", 0)
            ->with("addclient")
            ->orderByRaw("CAST(file_number AS UNSIGNED) ASC")
            ->get();

        // Split into chunks (for large PDF, e.g., 50 per page)
        $chunks = $addcases->chunk(50);

        // Generate PDF
        $pdf = Pdf::loadView(
            "backendPage.todayPrintcasePdf",
            compact("chunks", "today")
        )
            ->setPaper("legal", "landscape")
            ->setOptions([
                "isHtml5ParserEnabled" => true,
                "isRemoteEnabled" => true,
                "defaultFont" => "DejaVu Sans",
            ]);

        return $pdf->download(
            "Today-Hearing-Cases-" . now()->format("d-m-Y") . ".pdf"
        );
    }

    // Tomorrow case print
    public function tomorrowPrintCase()
    {
        // Set timezone
        $timezone = "Asia/Dhaka";

        // Tomorrow's date
        $tomorrow = Carbon::now($timezone)
            ->addDay()
            ->toDateString();

        // Fetch cases for tomorrow
        $tomorrowCases = Addcase::whereDate("next_hearing_date", "=", $tomorrow)
            ->where("status", "!=", 0)
            ->with("addclient")
            ->orderByRaw("CAST(file_number AS UNSIGNED) ASC")
            ->get();

        // Split into chunks for large data (e.g., 50 per page)
        $chunks = $tomorrowCases->chunk(50);

        // Generate PDF
        $pdf = Pdf::loadView(
            "backendPage.tomorrowPrintCasePdf",
            compact("chunks", "tomorrow")
        )
            ->setPaper("legal", "landscape")
            ->setOptions([
                "isHtml5ParserEnabled" => true,
                "isRemoteEnabled" => true,
                "defaultFont" => "DejaVu Sans",
            ]);

        return $pdf->download(
            "Tomorrow-Hearing-Cases-" . now()->format("d-m-Y") . ".pdf"
        );
    }

    // Today updated
    public function todayUpdated()
    {
        // Set the timezone to Asia/Dhaka
        $timezone = "Asia/Dhaka";

        // Get today's date in the specified timezone
        $today = Carbon::now($timezone)->startOfDay();

        // Base query
        $query = Addcase::whereDate("updated_at", "=", $today);

        // Set pagination limit
        $perPage = 10;

        // Get the filtered data with pagination and numeric sorting
        $todayUpdateds = $query
            ->orderByRaw(
                'CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)'
            )
            ->paginate($perPage)
            ->withQueryString();

        // Pass the data to the view
        return view("backendPage.todayUpdated", compact("todayUpdateds"));
    }

    public function needUpdateTransfer(Request $request)
    {
        // Base query
        $query = Addcase::join(
            "addclients",
            "addcases.client_id",
            "=",
            "addclients.id"
        )
            ->where("addcases.next_step", "like", "%transfer%")
            ->select("addcases.*", "addclients.name as client_name");

        // ✅ Filters (exact match to your filter form)
        if ($request->filled("client_id")) {
            $query->where("addcases.client_id", $request->client_id);
        }

        if ($request->filled("file_number")) {
            $query->where(
                "addcases.file_number",
                "like",
                "%" . $request->file_number . "%"
            );
        }

        if ($request->filled("case_number")) {
            $query->where(
                "addcases.case_number",
                "like",
                "%" . $request->case_number . "%"
            );
        }

        if ($request->filled("court_id")) {
            $query->where("addcases.court_id", $request->court_id);
        }

        if ($request->filled("section")) {
            $query->where(
                "addcases.section",
                "like",
                "%" . $request->section . "%"
            );
        }

        if ($request->filled("from_date") && $request->filled("to_date")) {
            $query->whereBetween("addcases.next_hearing_date", [
                $request->from_date,
                $request->to_date,
            ]);
        }

        if ($request->filled("status")) {
            $query->where("addcases.status", $request->status);
        }

        // ✅ Export full filtered data (ignore pagination)
        if ($request->has("export")) {
            $exportCases = $query
                ->orderByRaw(
                    'CAST(SUBSTRING_INDEX(addcases.file_number, "-", -1) AS UNSIGNED)'
                )
                ->get();

            if ($request->export === "excel") {
                return Excel::download(
                    new NeedUpdateTransferExport($exportCases),
                    "need_update_transfer_cases.xlsx"
                );
            }

            if ($request->export === "pdf") {
                $pdf = PDF::loadView(
                    "backendPage.pdf.need_update_transfer_pdf",
                    [
                        "cases" => $exportCases,
                    ]
                )->setPaper("legal", "landscape");

                return $pdf->download("need_update_transfer_cases.pdf");
            }
        }

        // ✅ Paginate for normal view
        $perPage = $request->get("per_page", 10);
        $needUpdateTransfers = $query
            ->orderByRaw(
                'CAST(SUBSTRING_INDEX(addcases.file_number, "-", -1) AS UNSIGNED)'
            )
            ->paginate($perPage)
            ->withQueryString();

        // ✅ Get data for filter dropdowns
        $clients = Addclient::orderBy('name')->get();
        $courts = Court::orderBy('name')->get();
        $sections = Addcase::whereNotNull('section')
            ->where('section', '!=', '')
            ->distinct()
            ->pluck('section')
            ->sort()
            ->values();

        return view(
            "backendPage.needUpdateTransfer",
            compact("needUpdateTransfers", "clients", "courts", "sections")
        );
    }

    // public function needUpdateTransfer()

    public function transfercasePrint()
    {
        // Get records where case_number contains either "CR" or "GR"
        $transfercasePrints = Addcase::where(
            "next_step",
            "like",
            "%transfer%"
        )->get();

        // Pass the data to the view
        return view(
            "backendPage.transfercasePrint",
            compact("transfercasePrints")
        );
    }

    // case history
    // In AddcaseController.php

    public function caseHistory($file_number)
    {
        // Retrieve current cases based on case_number
        $cases = Addcase::where("file_number", $file_number)->get();

        // Retrieve historical cases from AddcaseHistory based on case_number
        $historicalCases = AddcaseHistory::where(
            "file_number",
            $file_number
        )->get();
        $courts = Court::all();
        $clients = Addclient::all();

        // Pass the cases and historical cases to the view, and use $case_number instead of $file_number
        return view(
            "backendPage.show_by_file_number",
            compact("cases", "historicalCases", "file_number", "courts", "clients")
        );
    }

    public function updateCaseHearing(Request $request, $id)
    {
        try {
            $caseId = Crypt::decrypt($id);
            $case = Addcase::findOrFail($caseId);

            $request->validate([
                'next_hearing_date' => 'required|date',
                'next_step' => 'required|string|max:255'
            ]);

            $case->update([
                'previous_date' => $case->next_hearing_date,
                'previous_step' => $case->next_step,
                'next_hearing_date' => $request->next_hearing_date,
                'next_step' => $request->next_step
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Case updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update case!'
            ], 500);
        }
    }

    /**
     * Show all notifications page
     */
    public function allNotifications()
    {
        $subscribers = \App\Models\Subscriber::orderBy('created_at', 'desc')->get();
        $jobApplications = \App\Models\JobApplication::with('job')->orderBy('created_at', 'desc')->get();

        // Combine and sort all notifications
        $allNotifications = collect([
            ...$subscribers->map(fn($s) => [
                'type' => 'subscriber',
                'id' => $s->id,
                'title' => 'New Subscriber',
                'content' => $s->email,
                'icon' => 'fa-envelope',
                'color' => 'primary',
                'route' => route('showSubscriber', $s->id),
                'created_at' => $s->created_at,
                'read_at' => $s->read_at
            ]),
            ...$jobApplications->map(fn($j) => [
                'type' => 'job_application',
                'id' => $j->id,
                'title' => 'New Job Application',
                'content' => $j->name . ' applied for ' . $j->job->title,
                'icon' => 'fa-briefcase',
                'color' => 'success',
                'route' => route('job.applications.show', $j->id),
                'created_at' => $j->created_at,
                'read_at' => $j->read_at
            ])
        ])->sortByDesc('created_at');

        return view('backendPage.notifications.all', compact('allNotifications'));
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsRead()
    {
        \App\Models\Subscriber::whereNull('read_at')->update([
            'read_at' => now(),
            'read' => true
        ]);

        \App\Models\JobApplication::whereNull('read_at')->update([
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }
}
