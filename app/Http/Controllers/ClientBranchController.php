<?php

namespace App\Http\Controllers;

use App\Models\ClientBranch;
use App\Models\Addclient;
use Illuminate\Http\Request;

class ClientBranchController extends Controller
{

     public function clientbranchpage()
    {
        $clients = Addclient::get(); // বা Addclient::all()
        $clientbranches = ClientBranch::paginate(10);
        return view('backendPage.client_branch', compact('clients', 'clientbranches'));
    }
    
    public function index()
    {
        return response()->json(ClientBranch::with('client')->get());
    }

    // ⬇ নতুন branch create করা
    public function store(Request $request)
    {
        // ⬇ validation
        $request->validate([
            'client_id' => 'required|exists:addclients,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // ⬇ নতুন branch তৈরি
        $branch = ClientBranch::create($request->only('client_id', 'name', 'description'));

        return response()->json([
            'message' => 'Branch created successfully',
            'data' => $branch
        ], 201);
    }

    // ⬇ একটি branch দেখানো
    public function show(ClientBranch $clientBranch)
    {
        return response()->json($clientBranch);
    }

    // ⬇ branch update করা
    public function update(Request $request, ClientBranch $clientBranch)
    {
        // ⬇ validation
        $request->validate([
            'client_id' => 'required|exists:addclients,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // ⬇ update
        $clientBranch->update($request->only('client_id','name','description'));

        return response()->json([
            'message' => 'Branch updated successfully',
            'data' => $clientBranch
        ]);
    }

    // ⬇ branch delete করা
    public function destroy(ClientBranch $clientBranch)
    {
        $clientBranch->delete();

        return response()->json([
            'message' => 'Branch deleted successfully'
        ]);
    }

}
