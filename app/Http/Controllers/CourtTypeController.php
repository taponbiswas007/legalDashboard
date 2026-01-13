<?php

namespace App\Http\Controllers;

use App\Models\CourtType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourtTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courtTypes = CourtType::all();
        return view('backendPage.court_types.index', compact('courtTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'district' => 'required|string|max:255|unique:court_types,district,NULL,id,court_type,' . $request->court_type,
            'court_type' => 'required|string|max:255',
        ], [
            'district.unique' => 'This district and court type combination already exists.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        CourtType::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Court type created successfully!',
            'redirect' => route('court_types.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourtType $courtType)
    {
        return response()->json($courtType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourtType $courtType)
    {
        $validator = Validator::make($request->all(), [
            'district' => 'required|string|max:255|unique:court_types,district,' . $courtType->id . ',id,court_type,' . $request->court_type,
            'court_type' => 'required|string|max:255',
        ], [
            'district.unique' => 'This district and court type combination already exists.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $courtType->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Court type updated successfully!',
            'redirect' => route('court_types.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourtType $courtType)
    {
        $courtType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Court type deleted successfully!',
            'redirect' => route('court_types.index')
        ]);
    }
}