<?php

namespace App\Http\Controllers;

use App\Models\Addcase;
use App\Models\Addclient;
use App\Models\Court;
use App\Models\ClientBranch;
use App\Models\AddcaseHistory;
use App\Http\Requests\StoreAddcaseRequest;
use App\Http\Requests\UpdateAddcaseRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Exports\CasesExport;
use App\Imports\AddcaseUpdateImport;
use Maatwebsite\Excel\Facades\Excel;

class AddcaseController extends Controller
{

    public function index(Request $request)
    {
        // Validate and sanitize input
        $validated = $request->validate([
            'file_number' => 'nullable|string|max:100',
            'client_id' => 'nullable|integer',
            'branch_id' => 'nullable|integer',
            'name_of_parties' => 'nullable|string|max:500',
            'case_number' => 'nullable|string|max:100',
            'filing_or_received_date' => 'nullable|date_format:Y-m-d',
            'court_id' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'legal_notice_date_from' => 'nullable|date_format:Y-m-d',
            'legal_notice_date_to' => 'nullable|date_format:Y-m-d',
            'next_hearing_date_from' => 'nullable|date_format:Y-m-d',
            'next_hearing_date_to' => 'nullable|date_format:Y-m-d',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = Addcase::query()->with(['addclient', 'court', 'clientbranch']);

        // Apply filters with explicit data validation
        if ($request->filled('file_number')) {
            $query->where('file_number', 'like', '%' . $validated['file_number'] . '%');
        }
        if ($request->filled('client_id')) {
            $query->where('client_id', $validated['client_id']);
        }
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $validated['branch_id']);
        }
        if ($request->filled('name_of_parties')) {
            $query->where('name_of_parties', 'like', '%' . $validated['name_of_parties'] . '%');
        }
        if ($request->filled('case_number')) {
            $query->where('case_number', 'like', '%' . $validated['case_number'] . '%');
        }
        if ($request->filled('court_id')) {
            $query->where('court_id', $validated['court_id']);
        }
        if ($request->filled('status')) {
            $query->where('status', $validated['status']);
        }
        if ($request->filled('legal_notice_date_from')) {
            $query->whereDate('legal_notice_date', '>=', $validated['legal_notice_date_from']);
        }
        if ($request->filled('legal_notice_date_to')) {
            $query->whereDate('legal_notice_date', '<=', $validated['legal_notice_date_to']);
        }
        if ($request->filled('next_hearing_date_from')) {
            $query->whereDate('next_hearing_date', '>=', $validated['next_hearing_date_from']);
        }
        if ($request->filled('next_hearing_date_to')) {
            $query->whereDate('next_hearing_date', '<=', $validated['next_hearing_date_to']);
        }

        // Optimized ordering
        $query->orderByRaw('CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)');

        // Per page handling with constraints
        $perPage = (int) ($validated['per_page'] ?? 15);
        $perPage = max(1, min(100, $perPage)); // Clamp between 1-100

        $cases = $query->paginate($perPage)->appends(request()->query());

        // Cache these lookups
        $courts = Cache::remember('courts_list', 3600, fn() => Court::all());
        $clients = Cache::remember('clients_list', 1800, fn() => Addclient::all());
        $branches = Cache::remember('branches_list', 3600, fn() => ClientBranch::all());

        return view('backendPage.addcase.index', compact('cases', 'courts', 'clients', 'branches'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courts = Court::all();
        $addclients = Addclient::all();
        $clientbranches = ClientBranch::all();
        return view('backendPage.addcase.create', compact('addclients', 'courts', 'clientbranches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddcaseRequest $request)
    {
        // Validated data comes from FormRequest
        $validated = $request->validated();

        // Create case with mass assignment
        $addcase = Addcase::create([
            'client_id' => $validated['client_id'],
            'file_number' => $validated['file_number'],
            'branch_id' => $validated['branch_id'] ?? null,
            'loan_account_acquest_cin' => $validated['loan_account_acquest_cin'] ?? null,
            'previous_date' => $validated['previous_date'] ?? null,
            'previous_step' => $validated['previous_step'] ?? null,
            'court_id' => $validated['court_id'],
            'case_number' => $validated['case_number'],
            'section' => $validated['section'] ?? null,
            'name_of_parties' => $validated['name_of_parties'],
            'legal_notice_date' => $validated['legal_notice_date'] ?? null,
            'filing_or_received_date' => $validated['filing_or_received_date'] ?? null,
            'next_hearing_date' => $validated['next_hearing_date'] ?? null,
            'next_step' => $validated['next_step'] ?? null,
            'status' => $validated['status'] ?? false,
        ]);

        // Handle file uploads
        if ($request->hasFile('legal_notice')) {
            $filename = $this->storeFile($request->file('legal_notice'), 'legal_notice');
            $addcase->update(['legal_notice' => $filename]);
        }

        if ($request->hasFile('plaints')) {
            $filename = $this->storeFile($request->file('plaints'), 'plaints');
            $addcase->update(['plaints' => $filename]);
        }

        if ($request->hasFile('others_documents')) {
            $filename = $this->storeFile($request->file('others_documents'), 'others_documents');
            $addcase->update(['others_documents' => $filename]);
        }

        return redirect()->route('addcase.index')
            ->with('success', 'Case created successfully!');
    }

    /**
     * Store file securely
     */
    private function storeFile($file, $directory)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path("uploads/$directory"), $filename);
        return $filename;
    }

    /**
     * Display the specified resource.
     */
    public function caseshow($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);

            // Retrieve current case based on ID
            $case = Addcase::findOrFail($decryptedId);

            // Get the file_number from the current case
            $file_number = $case->file_number;

            // Retrieve historical cases from AddcaseHistory based on file_number
            $historicalCases = AddcaseHistory::where("file_number", $file_number)->get();

            $courts = Court::all();
            $clients = Addclient::all();

            // Pass the case and historical cases to the view
            return view("backendPage.addcase.show", compact("case", "historicalCases", "file_number", "courts", "clients"));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid case ID');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Case not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function caseedit($id)
    {
        // Decrypt the encrypted ID
        $decryptedId = Crypt::decrypt($id);

        // Find the client using the decrypted ID
        $addcase = Addcase::findOrFail($decryptedId);
        $addclients = Addclient::all();
        $courts = Court::all();
        $clientbranches = ClientBranch::all();
        return view('backendPage.addcase.edit', compact('addcase', 'addclients', 'courts', 'clientbranches'));
    }


    public function update(Request $request, Addcase $addcase)
    {
        $request->validate([
            'client_id' => 'required|exists:addclients,id',
            'file_number' => 'required',
            'branch_id' => 'nullable|exists:client_branches,id',
            'loan_account_acquest_cin' => 'nullable',
            'case_number' => 'required',
            'court_id' => 'required|exists:courts,id',
            'section' => 'nullable',
            'name_of_parties' => 'required',
            'next_hearing_date' => 'nullable',
            'next_step' => 'nullable',
            'legal_notice_date' => 'nullable',
            'filing_or_received_date' => 'nullable',
            'legal_notice' => 'nullable|mimes:pdf,doc,docx,rtf,txt,jpeg,png,jpg,gif|max:2048',
            'plaints' => 'nullable|mimes:pdf,doc,docx,rtf,txt,jpeg,png,jpg,gif|max:2048',
            'others_documents' => 'nullable|mimes:pdf,doc,docx,rtf,txt,jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable', // 1 = running, 0 = disposal
            'nh_checkbox' => 'nullable',
            'n_a_checkbox' => 'nullable',
            'transfer_checkbox' => 'nullable',
            'case_status' => 'nullable|string', // disposal reason/status
        ]);

        /* ================= OLD VALUES ================= */
        $oldNextHearingDate = $addcase->next_hearing_date;
        $oldNextStep        = $addcase->next_step;

        /* ================= CHECKBOX ================= */
        $historyEnabled  = $request->has('nh_checkbox');   // hearing history
        $prevStepEnabled = $request->has('n_a_checkbox');  // previous step
        $transferEnabled = $request->has('transfer_checkbox');  // transfer step
        $isFinalCase     = ($request->status == 0);        // case disposal

        /* ================= HEARING DATE CHANGE ================= */
        // Normalize dates for proper comparison to avoid false positives
        $newDate = $request->filled('next_hearing_date') ? $request->next_hearing_date : null;
        $oldDate = $oldNextHearingDate;

        // Convert to comparable format (Y-m-d)
        if ($newDate) {
            $newDate = date('Y-m-d', strtotime($newDate));
        }
        if ($oldDate) {
            // Handle both string and Carbon date objects
            $oldDate = $oldDate instanceof \Carbon\Carbon ? $oldDate->format('Y-m-d') : date('Y-m-d', strtotime((string)$oldDate));
        }

        $nextDateChanged = $newDate !== null && $newDate !== $oldDate;

        /**
         * =========================================================
         * CASE 1: REGULAR HEARING UPDATE (Running Case)
         * =========================================================
         */
        if ($nextDateChanged && $historyEnabled && !$isFinalCase) {

            // Check if previous_date already exists for this case
            $duplicateCheck = AddcaseHistory::where('file_number', $addcase->file_number)
                ->where('previous_date', $oldNextHearingDate)
                ->exists();

            if ($duplicateCheck) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'This hearing date has already been recorded in history for this case. Cannot create duplicate history entry.');
            }

            AddcaseHistory::create([
                'client_id' => $addcase->client_id,
                'file_number' => $addcase->file_number,
                'branch_id' => $addcase->branch_id,
                'loan_account_acquest_cin' => $addcase->loan_account_acquest_cin,

                'previous_date' => $oldNextHearingDate,
                'previous_step' => $oldNextStep,

                'next_hearing_date' => $request->next_hearing_date,
                'next_step' => $request->next_step,

                'case_number' => $addcase->case_number,
                'court_id' => $addcase->court_id,
                'section' => $addcase->section,
                'name_of_parties' => $addcase->name_of_parties,
                'legal_notice_date' => $addcase->legal_notice_date,
                'filing_or_received_date' => $addcase->filing_or_received_date,
                'status' => $addcase->status,

                'legal_notice' => $addcase->legal_notice,
                'plaints' => $addcase->plaints,
                'others_documents' => $addcase->others_documents,

                'is_final' => false,
            ]);

            $addcase->previous_date = $oldNextHearingDate;
        }

        /**
         * =========================================================
         * CASE 2: FINAL / DISPOSAL CASE
         * =========================================================
         */
        if ($isFinalCase) {

            // Check if previous_date already exists for this case
            $duplicateCheck = AddcaseHistory::where('file_number', $addcase->file_number)
                ->where('previous_date', $oldNextHearingDate)
                ->exists();

            if ($duplicateCheck) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'This hearing date has already been recorded in history for this case. Cannot create duplicate history entry.');
            }

            AddcaseHistory::create([
                'client_id' => $addcase->client_id,
                'file_number' => $addcase->file_number,
                'branch_id' => $addcase->branch_id,
                'loan_account_acquest_cin' => $addcase->loan_account_acquest_cin,

                // 🔥 BILLABLE LAST HEARING
                'previous_date' => $oldNextHearingDate,
                'previous_step' => $oldNextStep,

                // ❌ no next hearing
                'next_hearing_date' => null,
                'next_step' => trim(($request->case_status ?? '') . ($request->next_step ? ' ' . $request->next_step : '')) ?: 'Case Disposal',

                'case_number' => $addcase->case_number,
                'court_id' => $addcase->court_id,
                'section' => $addcase->section,
                'name_of_parties' => $addcase->name_of_parties,

                'legal_notice_date' => $addcase->legal_notice_date,
                'filing_or_received_date' => $addcase->filing_or_received_date,
                'status' => 0,

                'legal_notice' => $addcase->legal_notice,
                'plaints' => $addcase->plaints,
                'others_documents' => $addcase->others_documents,

                // ✅ FINAL MARK
                'is_final' => true,
            ]);

            // main case update
            $addcase->next_hearing_date = null;
            $addcase->next_step = trim(($request->case_status ?? '') . ($request->next_step ? ' ' . $request->next_step : '')) ?: 'Case Disposal';
        }
        if ($transferEnabled) {

            // Check if previous_date already exists for this case
            $duplicateCheck = AddcaseHistory::where('file_number', $addcase->file_number)
                ->where('previous_date', $oldNextHearingDate)
                ->exists();

            if ($duplicateCheck) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'This hearing date has already been recorded in history for this case. Cannot create duplicate history entry.');
            }

            AddcaseHistory::create([
                'client_id' => $addcase->client_id,
                'file_number' => $addcase->file_number,
                'branch_id' => $addcase->branch_id,
                'loan_account_acquest_cin' => $addcase->loan_account_acquest_cin,

                // 🔥 BILLABLE LAST HEARING
                'previous_date' => $oldNextHearingDate,
                'previous_step' => $oldNextStep,

                // ❌ no next hearing
                'next_hearing_date' => null,
                'next_step' => 'Transfer',

                'case_number' => $addcase->case_number,
                'court_id' => $addcase->court_id,
                'section' => $addcase->section,
                'name_of_parties' => $addcase->name_of_parties,

                'legal_notice_date' => $addcase->legal_notice_date,
                'filing_or_received_date' => $addcase->filing_or_received_date,
                'status' => $addcase->status,

                'legal_notice' => $addcase->legal_notice,
                'plaints' => $addcase->plaints,
                'others_documents' => $addcase->others_documents,

                // ✅ FINAL MARK
                'is_final' => false,
            ]);

            // main case update
            $addcase->next_hearing_date = $oldNextHearingDate;
            $addcase->next_step = 'Transfer';
        }

        /* ================= PREVIOUS STEP ================= */
        if ($prevStepEnabled) {
            $addcase->previous_step = $oldNextStep;
        }

        /* ================= MAIN CASE UPDATE ================= */
        $addcase->client_id = $request->client_id;
        $addcase->file_number = $request->file_number;
        $addcase->branch_id = $request->branch_id;
        $addcase->loan_account_acquest_cin = $request->loan_account_acquest_cin;
        $addcase->case_number = $request->case_number;
        $addcase->court_id = $request->court_id;
        $addcase->section = $request->section;
        $addcase->name_of_parties = $request->name_of_parties;
        $addcase->legal_notice_date = $request->legal_notice_date;
        $addcase->filing_or_received_date = $request->filing_or_received_date;

        // Only update next_hearing_date and next_step if NOT a final case AND NOT a transfer
        if (!$isFinalCase && !$transferEnabled) {
            $addcase->next_hearing_date = $request->next_hearing_date;
            $addcase->next_step = $request->next_step;
        }
        // else: already set to null and 'Case Disposal' or 'Transfer' in the blocks above

        // For final case, combine case_status and next_step properly
        if ($isFinalCase) {
            $addcase->next_step = trim(($request->case_status ?? '') . ($request->next_step ? ' ' . $request->next_step : '')) ?: 'Case Disposal';
            $addcase->previous_date = $oldNextHearingDate;
        }

        // Handle previous_date when transfer is enabled
        if ($transferEnabled) {
            $addcase->previous_date = $oldNextHearingDate;
        }

        $addcase->status = $request->status ? 1 : 0;

        /* ================= FILE UPLOAD ================= */
        foreach (['legal_notice', 'plaints', 'others_documents'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/' . $field . '/', $filename);
                $addcase->$field = $filename;
            }
        }

        $addcase->save();

        return redirect()->route('addcase.index')
            ->with('success', 'Case updated successfully');
    }



    // AJAS UPDATE
    public function ajaxUpdate(Request $request, Addcase $addcase)
    {
        $request->validate([
            'client_id' => 'required|exists:addclients,id',
            'file_number' => 'required',
            'branch_id' => 'nullable|exists:client_branches,id',
            'loan_account_acquest_cin' => 'nullable',
            'case_number' => 'required',
            'court_id' => 'required|exists:courts,id',
            'section' => 'nullable',
            'name_of_parties' => 'required',
            'next_hearing_date' => 'nullable',
            'next_step' => 'nullable',
            'legal_notice_date' => 'nullable',
            'filing_or_received_date' => 'nullable',
            'legal_notice' => 'nullable|mimes:pdf,doc,docx,rtf,txt,jpeg,png,jpg,gif|max:2048',
            'plaints' => 'nullable|mimes:pdf,doc,docx,rtf,txt,jpeg,png,jpg,gif|max:2048',
            'others_documents' => 'nullable|mimes:pdf,doc,docx,rtf,txt,jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable', // 1 = running, 0 = disposal
            'nh_checkbox' => 'nullable',
            'n_a_checkbox' => 'nullable',
            'transfer_checkbox' => 'nullable',
            'case_status' => 'nullable|string', // disposal reason/status
        ]);

        /* ================= OLD VALUES ================= */
        $oldNextHearingDate = $addcase->next_hearing_date;
        $oldNextStep        = $addcase->next_step;

        /* ================= CHECKBOX ================= */
        $historyEnabled  = $request->has('nh_checkbox');   // hearing history
        $prevStepEnabled = $request->has('n_a_checkbox');  // previous step
        $transferEnabled = $request->has('transfer_checkbox');  // transfer step
        $isFinalCase     = ($request->status == 0);        // case disposal

        /* ================= HEARING DATE CHANGE ================= */
        // Normalize dates for proper comparison to avoid false positives
        $newDate = $request->filled('next_hearing_date') ? $request->next_hearing_date : null;
        $oldDate = $oldNextHearingDate;

        // Convert to comparable format (Y-m-d)
        if ($newDate) {
            $newDate = date('Y-m-d', strtotime($newDate));
        }
        if ($oldDate) {
            // Handle both string and Carbon date objects
            $oldDate = $oldDate instanceof \Carbon\Carbon ? $oldDate->format('Y-m-d') : date('Y-m-d', strtotime((string)$oldDate));
        }

        $nextDateChanged = $newDate !== null && $newDate !== $oldDate;

        /**
         * =========================================================
         * CASE 1: REGULAR HEARING UPDATE (Running Case)
         * =========================================================
         */
        if ($nextDateChanged && $historyEnabled && !$isFinalCase) {

            // Check if previous_date already exists for this case
            $duplicateCheck = AddcaseHistory::where('file_number', $addcase->file_number)
                ->where('previous_date', $oldNextHearingDate)
                ->exists();

            if ($duplicateCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'This hearing date has already been recorded in history for this case. Cannot create duplicate history entry.'
                ], 422);
            }

            AddcaseHistory::create([
                'client_id' => $addcase->client_id,
                'file_number' => $addcase->file_number,
                'branch_id' => $addcase->branch_id,
                'loan_account_acquest_cin' => $addcase->loan_account_acquest_cin,

                'previous_date' => $oldNextHearingDate,
                'previous_step' => $oldNextStep,

                'next_hearing_date' => $request->next_hearing_date,
                'next_step' => $request->next_step,

                'case_number' => $addcase->case_number,
                'court_id' => $addcase->court_id,
                'section' => $addcase->section,
                'name_of_parties' => $addcase->name_of_parties,
                'legal_notice_date' => $addcase->legal_notice_date,
                'filing_or_received_date' => $addcase->filing_or_received_date,
                'status' => $addcase->status,

                'legal_notice' => $addcase->legal_notice,
                'plaints' => $addcase->plaints,
                'others_documents' => $addcase->others_documents,

                'is_final' => false,
            ]);

            $addcase->previous_date = $oldNextHearingDate;
            // $addcase->previous_step = $oldNextStep;
        }

        /**
         * =========================================================
         * CASE 2: FINAL / DISPOSAL CASE
         * =========================================================
         */
        if ($isFinalCase) {

            // Check if previous_date already exists for this case
            $duplicateCheck = AddcaseHistory::where('file_number', $addcase->file_number)
                ->where('previous_date', $oldNextHearingDate)
                ->exists();

            if ($duplicateCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'This hearing date has already been recorded in history for this case. Cannot create duplicate history entry.'
                ], 422);
            }

            AddcaseHistory::create([
                'client_id' => $addcase->client_id,
                'file_number' => $addcase->file_number,
                'branch_id' => $addcase->branch_id,
                'loan_account_acquest_cin' => $addcase->loan_account_acquest_cin,

                // 🔥 BILLABLE LAST HEARING
                'previous_date' => $oldNextHearingDate,
                'previous_step' => $oldNextStep,

                // ❌ no next hearing
                'next_hearing_date' => null,
                'next_step' => trim(($request->case_status ?? '') . ($request->next_step ? ' ' . $request->next_step : '')) ?: 'Case Disposal',

                'case_number' => $addcase->case_number,
                'court_id' => $addcase->court_id,
                'section' => $addcase->section,
                'name_of_parties' => $addcase->name_of_parties,

                'legal_notice_date' => $addcase->legal_notice_date,
                'filing_or_received_date' => $addcase->filing_or_received_date,
                'status' => 0,

                'legal_notice' => $addcase->legal_notice,
                'plaints' => $addcase->plaints,
                'others_documents' => $addcase->others_documents,

                // ✅ FINAL MARK
                'is_final' => true,
            ]);

            // main case update
            $addcase->next_hearing_date = null;
            $addcase->next_step = trim(($request->case_status ?? '') . ($request->next_step ? ' ' . $request->next_step : '')) ?: 'Case Disposal';
        }
        if ($transferEnabled) {

            // Check if previous_date already exists for this case
            $duplicateCheck = AddcaseHistory::where('file_number', $addcase->file_number)
                ->where('previous_date', $oldNextHearingDate)
                ->exists();

            if ($duplicateCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'This hearing date has already been recorded in history for this case. Cannot create duplicate history entry.'
                ], 422);
            }

            AddcaseHistory::create([
                'client_id' => $addcase->client_id,
                'file_number' => $addcase->file_number,
                'branch_id' => $addcase->branch_id,
                'loan_account_acquest_cin' => $addcase->loan_account_acquest_cin,

                // 🔥 BILLABLE LAST HEARING
                'previous_date' => $oldNextHearingDate,
                'previous_step' => $oldNextStep,

                // ❌ no next hearing
                'next_hearing_date' => null,
                'next_step' => 'Transfer',

                'case_number' => $addcase->case_number,
                'court_id' => $addcase->court_id,
                'section' => $addcase->section,
                'name_of_parties' => $addcase->name_of_parties,

                'legal_notice_date' => $addcase->legal_notice_date,
                'filing_or_received_date' => $addcase->filing_or_received_date,
                'status' => $addcase->status,

                'legal_notice' => $addcase->legal_notice,
                'plaints' => $addcase->plaints,
                'others_documents' => $addcase->others_documents,

                // ✅ FINAL MARK
                'is_final' => false,
            ]);

            // main case update
            $addcase->next_hearing_date = $oldNextHearingDate;
            $addcase->next_step = 'Transfer';
        }

        /* ================= PREVIOUS STEP ================= */
        if ($prevStepEnabled) {
            $addcase->previous_step = $oldNextStep;
        }

        /* ================= MAIN CASE UPDATE ================= */
        $addcase->client_id = $request->client_id;
        $addcase->file_number = $request->file_number;
        $addcase->branch_id = $request->branch_id;
        $addcase->loan_account_acquest_cin = $request->loan_account_acquest_cin;
        $addcase->case_number = $request->case_number;
        $addcase->court_id = $request->court_id;
        $addcase->section = $request->section;
        $addcase->name_of_parties = $request->name_of_parties;
        $addcase->legal_notice_date = $request->legal_notice_date;
        $addcase->filing_or_received_date = $request->filing_or_received_date;

        // Only update next_hearing_date and next_step if NOT a final case AND NOT a transfer
        if (!$isFinalCase && !$transferEnabled) {
            $addcase->next_hearing_date = $request->next_hearing_date;
            $addcase->next_step = $request->next_step;
        }
        // For final case, combine case_status and next_step properly
        if ($isFinalCase) {
            $addcase->next_step = trim(($request->case_status ?? '') . ($request->next_step ? ' ' . $request->next_step : '')) ?: 'Case Disposal';
            $addcase->previous_date = $oldNextHearingDate;
        }
        // else: already set to 'Transfer' in the blocks above

        // Handle previous_date when transfer is enabled
        if ($transferEnabled) {
            $addcase->previous_date = $oldNextHearingDate;
        }

        $addcase->status = $request->status ? 1 : 0;

        /* ================= FILE UPLOAD ================= */
        foreach (['legal_notice', 'plaints', 'others_documents'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/' . $field . '/', $filename);
                $addcase->$field = $filename;
            }
        }

        $addcase->save();

        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully'
        ]);
    }
    public function editModal($id)
    {
        $addcase = Addcase::findOrFail($id);
        $addclients = Addclient::all();
        $clientbranches = ClientBranch::all();
        $courts = Court::all();

        return view('backendPage.addcase._edit-modal-body', compact(
            'addcase',
            'addclients',
            'clientbranches',
            'courts'
        ));
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addcase $addcase)
    {

        if ($addcase->legal_notice) {
            $path = '/home/skshqxpx/public_html/uploads/legal_notice/' . $addcase->legal_notice;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        if ($addcase->plaints) {
            $path = '/home/skshqxpx/public_html/uploads/plaints/' . $addcase->plaints;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        if ($addcase->others_documents) {
            $path = '/home/skshqxpx/public_html/uploads/others_documents/' . $addcase->others_documents;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $addcase->delete();
        return redirect()->route('addcase.index')->with('success', 'Case deleted successfully');
    }

    public function lndownload($id)
    {
        $addcase = Addcase::find($id);

        if (!$addcase) {
            return redirect()->back()->with('error', 'Case record not found.');
        }

        if (!$addcase->legal_notice) {
            return redirect()->back()->with('error', 'No legal notice file attached to this case.');
        }

        $path = public_path('uploads/legal_notice/' . $addcase->legal_notice);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Legal notice file not found on server.');
        }

        return response()->download($path);
    }

    public function pldownload($id)
    {
        $addcase = Addcase::find($id);

        if (!$addcase) {
            return redirect()->back()->with('error', 'Case record not found.');
        }

        if (!$addcase->plaints) {
            return redirect()->back()->with('error', 'No plaints file attached to this case.');
        }

        $path = public_path('uploads/plaints/' . $addcase->plaints);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Plaints file not found on server.');
        }

        return response()->download($path);
    }
    public function othddownload($id)
    {
        $addcase = Addcase::find($id);

        if (!$addcase) {
            return redirect()->back()->with('error', 'Case record not found.');
        }

        if (!$addcase->others_documents) {
            return redirect()->back()->with('error', 'No other documents file attached to this case.');
        }

        $path = public_path('uploads/others_documents/' . $addcase->others_documents);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Other documents file not found on server.');
        }

        return response()->download($path);
    }
    public function olndownload($id)
    {
        $oldcase = AddcaseHistory::find($id);

        if (!$oldcase) {
            return redirect()->back()->with('error', 'Case history record not found.');
        }

        if (!$oldcase->legal_notice) {
            return redirect()->back()->with('error', 'No legal notice file attached to this history record.');
        }

        $path = public_path('uploads/legal_notice/' . $oldcase->legal_notice);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Legal notice file not found on server.');
        }

        return response()->download($path);
    }
    public function opldownload($id)
    {
        $oldcase = AddcaseHistory::find($id);

        if (!$oldcase) {
            return redirect()->back()->with('error', 'Case history record not found.');
        }

        if (!$oldcase->plaints) {
            return redirect()->back()->with('error', 'No plaints file attached to this history record.');
        }

        $path = public_path('uploads/plaints/' . $oldcase->plaints);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Plaints file not found on server.');
        }

        return response()->download($path);
    }
    public function oothddownload($id)
    {
        $oldcase = AddcaseHistory::find($id);

        if (!$oldcase) {
            return redirect()->back()->with('error', 'Case history record not found.');
        }

        if (!$oldcase->others_documents) {
            return redirect()->back()->with('error', 'No other documents file attached to this history record.');
        }

        $path = public_path('uploads/others_documents/' . $oldcase->others_documents);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Other documents file not found on server.');
        }

        return response()->download($path);
    }

    // Delete Methods for Case Files
    public function lndelete($id)
    {
        $addcase = Addcase::find($id);

        if (!$addcase) {
            return response()->json(['success' => false, 'message' => 'Case record not found.'], 404);
        }

        if (!$addcase->legal_notice) {
            return response()->json(['success' => false, 'message' => 'No legal notice file attached.'], 404);
        }

        $path = public_path('uploads/legal_notice/' . $addcase->legal_notice);

        // Delete file from disk if exists
        if (file_exists($path)) {
            unlink($path);
        }

        // Update database - set field to null
        $addcase->legal_notice = null;
        $addcase->save();

        return response()->json(['success' => true, 'message' => 'Legal notice deleted successfully.']);
    }

    public function pldelete($id)
    {
        $addcase = Addcase::find($id);

        if (!$addcase) {
            return response()->json(['success' => false, 'message' => 'Case record not found.'], 404);
        }

        if (!$addcase->plaints) {
            return response()->json(['success' => false, 'message' => 'No plaints file attached.'], 404);
        }

        $path = public_path('uploads/plaints/' . $addcase->plaints);

        if (file_exists($path)) {
            unlink($path);
        }

        $addcase->plaints = null;
        $addcase->save();

        return response()->json(['success' => true, 'message' => 'Plaints file deleted successfully.']);
    }

    public function othddelete($id)
    {
        $addcase = Addcase::find($id);

        if (!$addcase) {
            return response()->json(['success' => false, 'message' => 'Case record not found.'], 404);
        }

        if (!$addcase->others_documents) {
            return response()->json(['success' => false, 'message' => 'No other documents file attached.'], 404);
        }

        $path = public_path('uploads/others_documents/' . $addcase->others_documents);

        if (file_exists($path)) {
            unlink($path);
        }

        $addcase->others_documents = null;
        $addcase->save();

        return response()->json(['success' => true, 'message' => 'Other documents deleted successfully.']);
    }

    // Delete Methods for Case History Files
    public function olndelete($id)
    {
        $oldcase = AddcaseHistory::find($id);

        if (!$oldcase) {
            return response()->json(['success' => false, 'message' => 'Case history record not found.'], 404);
        }

        if (!$oldcase->legal_notice) {
            return response()->json(['success' => false, 'message' => 'No legal notice file attached.'], 404);
        }

        $path = public_path('uploads/legal_notice/' . $oldcase->legal_notice);

        if (file_exists($path)) {
            unlink($path);
        }

        $oldcase->legal_notice = null;
        $oldcase->save();

        return response()->json(['success' => true, 'message' => 'Legal notice deleted successfully.']);
    }

    public function opldelete($id)
    {
        $oldcase = AddcaseHistory::find($id);

        if (!$oldcase) {
            return response()->json(['success' => false, 'message' => 'Case history record not found.'], 404);
        }

        if (!$oldcase->plaints) {
            return response()->json(['success' => false, 'message' => 'No plaints file attached.'], 404);
        }

        $path = public_path('uploads/plaints/' . $oldcase->plaints);

        if (file_exists($path)) {
            unlink($path);
        }

        $oldcase->plaints = null;
        $oldcase->save();

        return response()->json(['success' => true, 'message' => 'Plaints file deleted successfully.']);
    }

    public function oothddelete($id)
    {
        $oldcase = AddcaseHistory::find($id);

        if (!$oldcase) {
            return response()->json(['success' => false, 'message' => 'Case history record not found.'], 404);
        }

        if (!$oldcase->others_documents) {
            return response()->json(['success' => false, 'message' => 'No other documents file attached.'], 404);
        }

        $path = public_path('uploads/others_documents/' . $oldcase->others_documents);

        if (file_exists($path)) {
            unlink($path);
        }

        $oldcase->others_documents = null;
        $oldcase->save();

        return response()->json(['success' => true, 'message' => 'Other documents deleted successfully.']);
    }

    public function exportExcel()
    {
        return Excel::download(new CasesExport, 'cases.xlsx');
    }



    public function updateByExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new AddcaseUpdateImport, $request->file('file'));

        return back()->with('success', 'Addcase table updated successfully!');
    }


    public function printSummary($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);

            // Retrieve current case based on ID
            $case = Addcase::findOrFail($decryptedId);

            // Get the file_number from the current case
            $file_number = $case->file_number;

            // Retrieve historical cases from AddcaseHistory based on file_number
            $historicalCases = AddcaseHistory::where("file_number", $file_number)->get();

            return view('backendPage.addcase.print', compact('case', 'historicalCases', 'file_number'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Invalid case ID');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Case not found');
        }
    }

    public function deleteHistory($id, Request $request)
    {
        try {
            $history = AddcaseHistory::findOrFail($id);
            $history->delete();

            return redirect()->back()
                ->with('success', 'History record deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete history record: ' . $e->getMessage());
        }
    }

    public function editHistory($id)
    {
        try {
            $history = AddcaseHistory::with(['addclient', 'court', 'clientbranch'])->findOrFail($id);
            $clients = Addclient::select('id', 'name')->orderBy('name')->get();
            $branches = ClientBranch::all();
            $courts = Court::orderBy('name')->get();

            return view('backendPage.addcase.history-edit-form', compact('history', 'clients', 'branches', 'courts'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load history record: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateHistory(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'client_id' => 'required|exists:addclients,id',
                'branch_id' => 'nullable|exists:client_branches,id',
                'court_id' => 'required|exists:courts,id',
                'case_number' => 'required|string|max:255',
                'loan_account_acquest_cin' => 'nullable|string|max:255',
                'name_of_parties' => 'nullable|string',
                'section' => 'nullable|string|max:255',
                'previous_date' => 'nullable|date',
                'next_hearing_date' => 'nullable|date',
                'previous_step' => 'nullable|string',
                'next_step' => 'nullable|string',
                'status' => 'nullable|boolean',
                'filing_or_received_date' => 'nullable|date',
                'legal_notice_date' => 'nullable|date',
            ]);

            $history = AddcaseHistory::findOrFail($id);
            $fileNumber = $history->file_number;

            /*
        |--------------------------------------------------------------------------
        | STRICT Duplicate Check
        |--------------------------------------------------------------------------
        */

            // previous_date duplicate check
            if (!empty($validated['previous_date'])) {

                $existsPreviousDate = AddcaseHistory::where('file_number', $fileNumber)
                    ->where('id', '!=', $id)
                    ->whereDate('previous_date', $validated['previous_date'])
                    ->exists();

                if ($existsPreviousDate) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This Previous Date already exists for this case file.'
                    ], 422);
                }
            }

            // next_hearing_date duplicate check
            if (!empty($validated['next_hearing_date'])) {

                $existsNextDate = AddcaseHistory::where('file_number', $fileNumber)
                    ->where('id', '!=', $id)
                    ->whereDate('next_hearing_date', $validated['next_hearing_date'])
                    ->exists();

                if ($existsNextDate) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This Next Hearing Date already exists for this case file.'
                    ], 422);
                }
            }

            $history->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'History record updated successfully!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update history record: ' . $e->getMessage()
            ], 500);
        }
    }
}
