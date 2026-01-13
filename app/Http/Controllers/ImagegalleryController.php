<?php

namespace App\Http\Controllers;

use App\Models\Imagegallery;
use Illuminate\Http\Request;

class ImagegalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imagegalleries = Imagegallery::all();
        return view('backendPage.imagegallery.index', compact('imagegalleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backendPage.imagegallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'status' => 'nullable'
        ]);
        $imagegalleries = new Imagegallery();
        $imagegalleries->title = $request->title;
        $imagegalleries->status = $request->status == true ? 1 : 0;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
           // $image->move(public_path('images'), $imageName);
            $image->move('images/', $imageName);
            $imagegalleries->image = $imageName;
        }
        $imagegalleries->save();
        return redirect()->route('imagegallery.index')->with('success', 'Imagegallery created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Imagegallery $imagegallery)
    {
        return view('backendPage.imagegallery.show', compact('imagegallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imagegallery $imagegallery)
    {
        return view('backendPage.imagegallery.edit', compact('imagegallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imagegallery $imagegallery)
    {
        $request->validate([
            'title' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'status' => 'nullable'
        ]);
        $imagegallery->title = $request->title;
        $imagegallery->status = $request->status == true ? 1 : 0;
        if ($request->hasFile('image')) {
           
             if ($imagegallery->image && file_exists('images/' . $imagegallery->image)) {
                unlink('images/' . $imagegallery->image);
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
           // $image->move(public_path('images'), $imageName);
            $image->move('images/', $imageName);
            $imagegallery->image = $imageName;
        }
        $imagegallery->save();
        return redirect()->route('imagegallery.index')->with('success', 'Imagegallery updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imagegallery $imagegallery)
    {
          if ($imagegallery->image && file_exists('images/' . $imagegallery->image)) {
                unlink('images/' . $imagegallery->image);
            }
        $imagegallery->delete();
        return redirect()->route('imagegallery.index')->with('success', 'Imagegallery deleted successfully.');
    }
}
