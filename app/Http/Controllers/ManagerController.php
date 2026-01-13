<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    // List all managers for the current user
    public function index()
    {
        $managers = User::where('role', 'manager')
            ->where('parent_id', Auth::id())
            ->get();
        return view('dashboard.managers.index', compact('managers'));
    }

    // Show form to create a new manager
    public function create()
    {
        return view('dashboard.managers.create');
    }

    // Store a new manager
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $manager = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'manager',
            'parent_id' => Auth::id(),
            'approved' => true, // or false if you want approval
        ]);

        return redirect()->route('managers.index')->with('success', 'Manager created successfully.');
    }

    // Show manager's company dashboard
    public function dashboard()
    {
        // Only allow access if logged in user is a manager
        $user = Auth::user();
        if ($user->role !== 'manager') {
            abort(403, 'Unauthorized');
        }
        // Get the parent user (company owner)
        $company = User::find($user->parent_id);
        // You can pass company data, managers, and any company-specific resources
        return view('dashboard.company.index', compact('company'));
    }

    // Optionally: Edit, Update, Delete methods can be added here
}
