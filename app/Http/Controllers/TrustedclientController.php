<?php

namespace App\Http\Controllers;

use App\Models\Trustedclient;
use Illuminate\Http\Request;

class TrustedclientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trustedclients = Trustedclient::all();
        return view('backendPage.trustedclient.index', compact('trustedclients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backendPage.trustedclient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable',
        ]);
        $trustedclient = new Trustedclient();
        $trustedclient->status = $request->status == true ? 1 : 0;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images/', $imageName);
            $trustedclient->image = 'images/' . $imageName;
        }
        $trustedclient->save();
        return redirect()->route('trustedclient.index')->with('success', 'Trustedclient created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trustedclient $trustedclient)
    {
        return view('backendPage.trustedclient.show', compact('trustedclient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trustedclient $trustedclient)
    {
        return view('backendPage.trustedclient.edit', compact('trustedclient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trustedclient $trustedclient)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable',
        ]);
        $trustedclient->status = $request->status == true ? 1 : 0;
        if ($request->hasFile('image')) {
           
            if ($trustedclient->image && file_exists('images/' . $trustedclient->image)) {
                unlink('images/' . $trustedclient->image);
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images/', $imageName);
            $trustedclient->image = 'images/' . $imageName;
        }
        $trustedclient->save();
        return redirect()->route('trustedclient.index')->with('success', 'Trustedclient updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trustedclient $trustedclient)
    {
          if ($trustedclient->image && file_exists('images/' . $trustedclient->image)) {
                unlink('images/' . $trustedclient->image);
            }
        $trustedclient->delete();
       
        return redirect()->route('trustedclient.index')->with('success', 'Trustedclient deleted successfully');
    }
}
