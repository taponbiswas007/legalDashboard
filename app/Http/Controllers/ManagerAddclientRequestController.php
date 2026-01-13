<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Approval;

class ManagerAddclientRequestController extends Controller
{
    // List all addclient requests for this manager
    public function index()
    {
        $addclients = Approval::where('manager_id', Auth::user()->id)
            ->where('model_type', 'Addclient')
            ->orderByDesc('created_at')
            ->get();
        return view('manager.addclient.index', compact('addclients'));
    }
    // List all rejected addclient requests for this manager
    public function rejected()
    {
        $rejected = Approval::where('manager_id', Auth::user()->id)
            ->where('model_type', 'Addclient')
            ->where('status', 'rejected')
            ->orderByDesc('updated_at')
            ->get();
        return view('manager.addclient.rejected', compact('rejected'));
    }

    // Show edit form for a rejected request
    public function edit($id)
    {
        $approval = Approval::where('manager_id', Auth::user()->id)
            ->where('model_type', 'Addclient')
            ->where('status', 'rejected')
            ->findOrFail($id);
        $data = [];
        if (is_string($approval->new_data)) {
            $data = json_decode($approval->new_data, true);
        } elseif (is_array($approval->new_data)) {
            $data = $approval->new_data;
        }
        return view('manager.addclient.edit', compact('approval', 'data'));
    }

    // Update and resubmit a rejected request
    public function update(Request $request, $id)
    {
        $approval = Approval::where('manager_id', Auth::user()->id)
            ->where('model_type', 'Addclient')
            ->where('status', 'rejected')
            ->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'number' => 'required|string',
            'address' => 'required|string',
        ]);
        $approval->new_data = json_encode($request->only(['name', 'email', 'number', 'address']));
        $approval->status = 'pending';
        $approval->rejection_note = null;
        $approval->save();
        return redirect()->route('manager.addclient.requests')->with('success', 'Request resubmitted for approval.');
    }

    // Delete a rejected request
    public function destroy($id)
    {
        $approval = Approval::where('manager_id', Auth::user()->id)
            ->where('model_type', 'Addclient')
            ->where('status', 'rejected')
            ->findOrFail($id);
        $approval->delete();
        return redirect()->route('manager.addclient.rejected')->with('success', 'Rejected request deleted successfully.');
    }

    // Show form for manager to request a new client
    public function create()
    {
        return view('manager.addclient.create');
    }

    // Store the pending addclient request in approvals table
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'number' => 'required|string',
            'address' => 'required|string',
        ]);

        Approval::create([
            'user_id' => Auth::user()->parent_id, // Data owner
            'manager_id' => Auth::id(),
            'action_type' => 'create',
            'model_type' => 'Addclient',
            'model_id' => null,
            'old_data' => null,
            'new_data' => json_encode($request->only(['name', 'email', 'number', 'address'])),
            'status' => 'pending',
        ]);

        return redirect()->route('manager.company.dashboard')->with('success', 'Client creation request sent for approval.');
    }
}
