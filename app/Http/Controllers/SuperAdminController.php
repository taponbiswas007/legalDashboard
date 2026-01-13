<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // Show pending users for approval
    public function userApprovalList()
    {
        $pendingUsers = User::where('approved', false)->get();
        return view('backendPage.superadmin.user-approval', compact('pendingUsers'));
    }

    // Approve a user
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->approved = true;
        $user->save();
        return redirect()->back()->with('success', 'User approved successfully.');
    }
}
