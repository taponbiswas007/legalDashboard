<?php

namespace App\Http\Controllers;

use App\Models\Stafflist;
use Illuminate\Http\Request;

class StafflistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $stafflists = Stafflist::all();
        return view('backendPage/stafflist.index', compact('stafflists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backendPage/stafflist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'email' => 'required|email|unique:stafflists',
            'whatsapp' => 'required',
            'address' => 'required',
            'qualification' => 'nullable',
            'possition' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable'
        ]);
        $stafflist = new Stafflist();
        $stafflist->name = $request->name;
        $stafflist->number = $request->number;
        $stafflist->email = $request->email;
        $stafflist->whatsapp = $request->whatsapp;
        $stafflist->address = $request->address;
        $stafflist->qualification = $request->qualification;
        $stafflist->possition = $request->possition;
        $stafflist->status = $request->status == true ? 1 : 0;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // $image->move(public_path('images'), $imageName);
            $image->move('images/', $imageName);
            $stafflist->image = $imageName;
        }
        $stafflist->save();
        return redirect()->route('stafflist.index')->with('success', 'Stafflist created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stafflist $stafflist)
    {

        return view('backendPage/stafflist.show', compact('stafflist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stafflist $stafflist)
    {

        return view('backendPage/stafflist.edit', compact('stafflist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stafflist $stafflist)
    {

        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'email' => 'required|email',
            'whatsapp' => 'required',
            'address' => 'required',
            'qualification' => 'nullable',
            'possition' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable'
        ]);
        $stafflist->name = $request->name;
        $stafflist->number = $request->number;
        $stafflist->email = $request->email;
        $stafflist->whatsapp = $request->whatsapp;
        $stafflist->address = $request->address;
        $stafflist->qualification = $request->qualification;
        $stafflist->possition = $request->possition;
        $stafflist->status = $request->status == true ? 1 : 0;

        if ($request->hasFile('image')) {
            // Check if the old image exists and delete it
            if ($stafflist->image && file_exists('images/' . $stafflist->image)) {
                unlink('images/' . $stafflist->image);
            }

            // Upload the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images/', $imageName);

            // Save the new image name
            $stafflist->image = $imageName;
        }

        // Save all data
        $stafflist->save();

        return redirect()->route('stafflist.index')->with('success', 'Stafflist updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stafflist $stafflist)
    {

        if ($stafflist->image && file_exists('images/' . $stafflist->image)) {
            unlink('images/' . $stafflist->image);
        }
        $stafflist->delete();
        return redirect()->route('stafflist.index')->with('success', 'Stafflist deleted successfully');
    }
}
