<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Approval;

class ManagerApprovalController extends Controller
{
    // List all pending addclient requests for the logged-in manager
    public function pendingAddclients()
    {
        $pendingAddclients = Approval::where('manager_id', Auth::id())
            ->where('model_type', 'Addclient')
            ->where('action_type', 'create')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();
        return view('manager.approvals.pending_addclients', compact('pendingAddclients'));
    }
}
