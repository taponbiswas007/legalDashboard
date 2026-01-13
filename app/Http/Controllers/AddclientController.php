<?php

namespace App\Http\Controllers;

use App\Models\Addclient;
use App\Models\Addcase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Exports\ClientCasesExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class AddclientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addclients = Addclient::all();
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
                Rule::unique('addclients'), // Ensure email is unique
            ],
            'number' => [
                'nullable',
                'numeric',
                Rule::unique('addclients'), // Ensure number is unique
            ],
            'address' => 'nullable',
            'status' => 'nullable',
        ], [
            'email.unique' => 'This email is already in use.', // Custom error message
            'number.unique' => 'This number is already in use.', // Custom error message
        ]);






        $addclients = new Addclient();
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
        $addclient = AddClient::findOrFail($decryptedId);

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
        // Decrypt the encrypted ID
        $decryptedId = Crypt::decrypt($id);

        // Find the client using the decrypted ID
        $addclient = AddClient::findOrFail($decryptedId);

        return view('backendPage.addclient.edit', compact('addclient'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Addclient $addclient)
    {

        $request->validate([
            'name' => 'required',
            'email' => [
                'nullable',
                'email',
                Rule::unique('addclients')->ignore($addclient->id), // Ensure email is unique, ignoring the current client
            ],
            'number' => [
                'nullable',
                'numeric',
                Rule::unique('addclients')->ignore($addclient->id), // Ensure number is unique, ignoring the current client
            ],
            'address' => 'nullable',
            'status' => 'nullable',
        ], [
            'email.unique' => 'This email is already in use.', // Custom error message
            'number.unique' => 'This number is already in use.', // Custom error message
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

        $addclient->delete();
        return redirect()->route('addclient.index')->with('success', 'Client deleted successfully');
    }

    public function exportClientExcel(Request $request, $id)
{
    $decryptedId = Crypt::decrypt($id);
    $addclient = AddClient::findOrFail($decryptedId);

    $tab = $request->get('tab', 'running');

    return Excel::download(
        new ClientCasesExport($decryptedId, $request->all() + ['tab' => $tab]),
        'client_' . $addclient->name . '_' . $tab . '_cases.xlsx'
    );
}


   public function exportClientPdf(Request $request, $id)
    {
        $decryptedId = Crypt::decrypt($id);
        $addclient = AddClient::findOrFail($decryptedId);

        // Start base query
        $query = Addcase::where('client_id', $decryptedId);

        // Text filters
        foreach (['file_number','name_of_parties','court_name','case_number','section'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, 'like', "%{$request->$field}%");
            }
        }

        // Date filters
        foreach (['legal_notice_date','filing_or_received_date','previous_date','next_hearing_date'] as $dateField) {
            if ($request->filled($dateField)) {
                $query->whereDate($dateField, $request->$dateField);
            }
        }

        // Determine tab (running or disposal)
        $tab = $request->get('tab', 'running');

        $cases = $query->where('status', $tab === 'disposal' ? 0 : 1)->get();

        // Generate PDF
        $pdf = PDF::loadView('backendPage.addclient.exports.client_cases_pdf', [
            'addclient' => $addclient,
            'cases' => $cases,
            'tab' => $tab
        ])->setPaper('legal', 'landscape');

        // Clean filename for spaces or special chars
        $fileName = 'client_' . Str::slug($addclient->name, '_') . '_' . $tab . '_cases.pdf';
        return $pdf->download($fileName);
    }

}
