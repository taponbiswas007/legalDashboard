<?php



namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // Show all users in the approval dashboard
    public function userApprovalList()
    {
        $allUsers = User::all();
        return view('backendPage.superadmin.user-approval', compact('allUsers'));
    }

    // Approve a user
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->approved = true;
        $user->save();
        return redirect()->back()->with('success', 'User approved successfully.');
    }

    // Unapprove a user
    public function unapproveUser($id)
    {
        $user = User::findOrFail($id);
        $user->approved = false;
        $user->save();
        return redirect()->back()->with('success', 'User unapproved successfully.');
    }

    // Block a user (set approved to 0)
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->approved = false;
        $user->save();
        return redirect()->back()->with('success', 'User blocked successfully.');
    }

    // Unblock a user (set approved to 1)
    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->approved = true;
        $user->save();
        return redirect()->back()->with('success', 'User unblocked successfully.');
    }
}
