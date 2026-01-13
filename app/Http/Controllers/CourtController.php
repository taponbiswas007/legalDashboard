<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\CourtType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\CourtsImport;
use App\Exports\CourtsExport;
use Maatwebsite\Excel\Facades\Excel;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courts = Court::with('courtType')->paginate(10);
        $courtTypes = CourtType::all();
        return view('backendPage.courts.index', compact('courts', 'courtTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'court_type_id' => 'required|exists:court_types,id',
            'name' => 'required|string|max:255|unique:courts,name,NULL,id,court_type_id,' . $request->court_type_id,
        ], [
            'name.unique' => 'This court name already exists for the selected court type.',
            'court_type_id.required' => 'Please select a court type.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Court::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Court created successfully!',
            'redirect' => route('courts.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Court $court)
    {
        return response()->json($court->load('courtType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Court $court)
    {
        $validator = Validator::make($request->all(), [
            'court_type_id' => 'required|exists:court_types,id',
            'name' => 'required|string|max:255|unique:courts,name,' . $court->id . ',id,court_type_id,' . $request->court_type_id,
        ], [
            'name.unique' => 'This court name already exists for the selected court type.',
            'court_type_id.required' => 'Please select a court type.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $court->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Court updated successfully!',
            'redirect' => route('courts.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Court $court)
    {
        $court->delete();

        return response()->json([
            'success' => true,
            'message' => 'Court deleted successfully!',
            'redirect' => route('courts.index')
        ]);
    }

    /**
     * Import courts from Excel
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'court_type_id' => 'required|exists:court_types,id',
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            Excel::import(new CourtsImport($request->court_type_id), $request->file('excel_file'));
            
            return response()->json([
                'success' => true,
                'message' => 'Courts imported successfully!',
                'redirect' => route('courts.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['excel_file' => ['Error importing file: ' . $e->getMessage()]]
            ], 422);
        }
    }

    /**
     * Get court types for select2
     */
    public function getCourtTypes(Request $request)
    {
        $search = $request->get('search');
        
        $courtTypes = CourtType::when($search, function($query) use ($search) {
            $query->where('district', 'like', "%{$search}%")
                  ->orWhere('court_type', 'like', "%{$search}%");
        })->get();

        return response()->json([
            'results' => $courtTypes->map(function($type) {
                return [
                    'id' => $type->id,
                    'text' => $type->district . ' - ' . $type->court_type
                ];
            })
        ]);
    }

     public function courtexport() 
    {
        try {
            return Excel::download(new CourtsExport(), 'courts_' . date('Y_m_d_His') . '.xlsx');
        } catch (\Exception $e) {
            // For debugging, check what error you get
            dd($e->getMessage());
        }
    }
}