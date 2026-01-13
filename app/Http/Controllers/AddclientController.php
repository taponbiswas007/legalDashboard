<?php

namespace App\Http\Controllers;

use App\Models\Addclient;
use App\Models\Addcase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Exports\ClientCasesExport;
use App\Models\Approval;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class AddclientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addclients = Addclient::where('auth_id', Auth::user()->id)->get();
        return view('backendPage.addclient.index', [
            'addclients' => $addclients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('backendPage.addclient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => [
                'nullable',
                'email',
                Rule::unique('addclients')->where(function ($query) {
                    return $query->where('auth_id', Auth::user()->id);
                }),
            ],
            'number' => [
                'nullable',
                'numeric',
                Rule::unique('addclients')->where(function ($query) {
                    return $query->where('auth_id', Auth::user()->id);
                }),
            ],
            'address' => 'nullable',
            'status' => 'nullable',
        ], [
            'email.unique' => 'This email is already in use.',
            'number.unique' => 'This number is already in use.',
        ]);

        $addclients = new Addclient();
        $addclients->auth_id = Auth::user()->id;
        $addclients->name = $request->name;
        $addclients->email = $request->email;
        $addclients->number = $request->number;
        $addclients->address = $request->address;
        $addclients->status = $request->status == true ? 1 : 0;
        $addclients->save();

        return redirect()->route('addclient.index')->with('success', 'Client added successfully');
    }

    /**
     * Display the specified resource.
     */

    public function show(Request $request, $id)
    {
        $decryptedId = Crypt::decrypt($id);
        $addclient = Addclient::where('auth_id', Auth::user()->id)->findOrFail($decryptedId);
        $baseQuery = Addcase::where('client_id', $decryptedId);

        // 🔹 Filters
        if ($request->filled('file_number')) {
            $baseQuery->where('file_number', 'like', "%{$request->file_number}%");
        }
        if ($request->filled('name_of_parties')) {
            $baseQuery->where('name_of_parties', 'like', "%{$request->name_of_parties}%");
        }
        if ($request->filled('court_name')) {
            $baseQuery->where('court_name', 'like', "%{$request->court_name}%");
        }
        if ($request->filled('case_number')) {
            $baseQuery->where('case_number', 'like', "%{$request->case_number}%");
        }
        if ($request->filled('section')) {
            $baseQuery->where('section', 'like', "%{$request->section}%");
        }
        if ($request->filled('legal_notice_date')) {
            $baseQuery->whereDate('legal_notice_date', $request->legal_notice_date);
        }
        if ($request->filled('filing_or_received_date')) {
            $baseQuery->whereDate('filing_or_received_date', $request->filing_or_received_date);
        }
        if ($request->filled('previous_date')) {
            $baseQuery->whereDate('previous_date', $request->previous_date);
        }
        if ($request->filled('next_hearing_date')) {
            $baseQuery->whereDate('next_hearing_date', $request->next_hearing_date);
        }

        // 🔹 Per-page selector
        $perPage = $request->get('per_page', 10);

        // 🔹 Separate running and disposal cases
        $runningCases = (clone $baseQuery)->where('status', 1)->paginate($perPage, ['*'], 'running_page');
        $disposalCases = (clone $baseQuery)->where('status', 0)->paginate($perPage, ['*'], 'disposal_page');

        // 🔹 Preserve tab
        $activeTab = $request->get('tab', 'running');

        return view('backendPage.addclient.show', compact(
            'addclient',
            'runningCases',
            'disposalCases',
            'activeTab',
            'perPage'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptedId = Crypt::decrypt($id);
        $addclient = Addclient::where('auth_id', Auth::user()->id)->findOrFail($decryptedId);
        return view('backendPage.addclient.edit', compact('addclient'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Addclient $addclient)
    {
        if ($addclient->auth_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required',
            'email' => [
                'nullable',
                'email',
                Rule::unique('addclients')->ignore($addclient->id)->where(function ($query) {
                    return $query->where('auth_id', Auth::user()->id);
                }),
            ],
            'number' => [
                'nullable',
                'numeric',
                Rule::unique('addclients')->ignore($addclient->id)->where(function ($query) {
                    return $query->where('auth_id', Auth::user()->id);
                }),
            ],
            'address' => 'nullable',
            'status' => 'nullable',
        ], [
            'email.unique' => 'This email is already in use.',
            'number.unique' => 'This number is already in use.',
        ]);
        $addclient->name = $request->name;
        $addclient->email = $request->email;
        $addclient->number = $request->number;
        $addclient->address = $request->address;
        $addclient->status = $request->status == true ? 1 : 0;
        $addclient->save();
        return redirect()->route('addclient.index')->with('success', 'Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addclient $addclient)
    {
        if ($addclient->auth_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        $addclient->delete();
        return redirect()->route('addclient.index')->with('success', 'Client deleted successfully');
    }

    public function exportClientExcel(Request $request, $id)
    {
        $decryptedId = Crypt::decrypt($id);
        $addclient = Addclient::findOrFail($decryptedId);
        $tab = $request->get('tab', 'running');
        return Excel::download(
            new ClientCasesExport($decryptedId, $request->all() + ['tab' => $tab]),
            'client_' . $addclient->name . '_' . $tab . '_cases.xlsx'
        );
    }


    public function exportClientPdf(Request $request, $id)
    {
        $decryptedId = Crypt::decrypt($id);
        $addclient = Addclient::findOrFail($decryptedId);
        $query = Addcase::where('client_id', $decryptedId);

        // Text filters
        foreach (['file_number', 'name_of_parties', 'court_name', 'case_number', 'section'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, 'like', "%{$request->$field}%");
            }
        }

        // Date filters
        foreach (['legal_notice_date', 'filing_or_received_date', 'previous_date', 'next_hearing_date'] as $dateField) {
            if ($request->filled($dateField)) {
                $query->whereDate($dateField, $request->$dateField);
            }
        }

        // Determine tab (running or disposal)
        $tab = $request->get('tab', 'running');

        $cases = $query->where('status', $tab === 'disposal' ? 0 : 1)->get();

        // Generate PDF
        $pdf = Pdf::loadView('backendPage.addclient.exports.client_cases_pdf', [
            'addclient' => $addclient,
            'cases' => $cases,
            'tab' => $tab
        ])->setPaper('legal', 'landscape');

        // Clean filename for spaces or special chars
        $fileName = 'client_' . Str::slug($addclient->name, '_') . '_' . $tab . '_cases.pdf';
        return $pdf->download($fileName);
    }

    /**
     * Show pending addclient approvals for the user to finalize.
     */
    public function pendingApprovals()
    {
        $approvals = Approval::where('user_id', Auth::user()->id)
            ->where('model_type', 'Addclient')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();
        return view('backendPage.addclient.approvals', compact('approvals'));
    }

    /**
     * Finalize (approve) a pending addclient request.
     */
    public function finalizeApproval($approvalId)
    {
        $approval = Approval::findOrFail($approvalId);
        if ($approval->user_id !== Auth::user()->id || $approval->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }
        $data = json_decode($approval->new_data, true);
        $exists = Addclient::where('email', $data['email'])
            ->where('auth_id', Auth::user()->id)
            ->orWhere(function ($q) use ($data) {
                $q->where('number', $data['number'])->where('auth_id', Auth::user()->id);
            })->exists();
        if ($exists) {
            return redirect()->route('addclient.approvals')->with('error', 'A client with this email or number already exists for your account.');
        }
        $client = new Addclient($data);
        $client->auth_id = Auth::user()->id;
        $client->status = 1;
        $client->save();
        $approval->status = 'approved';
        $approval->model_id = $client->id;
        $approval->save();
        return redirect()->route('addclient.approvals')->with('success', 'Client approved and added successfully.');
    }

    /**
     * Reject a pending addclient request.
     */
    public function rejectApproval($approvalId)
    {
        $approval = Approval::findOrFail($approvalId);
        if ($approval->user_id !== Auth::user()->id || $approval->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }
        $approval->status = 'rejected';
        $approval->save();
        return redirect()->route('addclient.approvals')->with('success', 'Client request rejected.');
    }
}
