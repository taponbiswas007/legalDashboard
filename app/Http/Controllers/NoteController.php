<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::paginate(10);

        return view('backendPage.notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('backendPage.notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status'   => 'required|in:Pending,Done,Reject',
            ]);

            // Set default status to "Running" if not provided or empty
            $status = $request->status;
            if (empty($status)) {
                $status = 'Pending';
            }

             Note::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $status,
            ]);
        return redirect()->route('notes.index')->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     */

     public function update(Request $request, $id)
    {
        try {
            $note = Note::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required',
                'status' => 'required|in:Pending,Done,Reject',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $note->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note updated successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update note.'
            ], 500);
        }
    }

    // app/Http/Controllers/NoteController.php
    public function updateStatus(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $note->update(['status' => $request->status]);
        
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $note = Note::findOrFail($id);
        return response()->json(['success' => true, 'note' => $note]);
    }

    public function show($id)
    {
        $note = Note::findOrFail($id);
        return response()->json(['success' => true, 'note' => $note]);
    }

    /**
     * Remove the specified resource from storage.
     */
      public function destroy($id)
    {
        try {
            $note = Note::findOrFail($id);
            $note->delete();

            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Note.'
            ], 500);
        }
    }
}
