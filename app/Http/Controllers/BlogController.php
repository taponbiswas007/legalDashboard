<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('backendPage.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('backendPage.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'content' => 'required',
            'status' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->category = $request->category;
        $blog->content = $request->content;
        $blog->status = $request->status == true ? 1 : 0;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            //$image->move(public_path('images'), $imageName);
              $image->move('images/', $imageName);
            $blog->image = $imageName;
        }
        $blog->save();
        return redirect()->route('blog.index')->with('success', 'Blog created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('backendPage.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('backendPage.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'content' => 'required',
            'status' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $blog->title = $request->title;
        $blog->category = $request->category;
        $blog->content = $request->content;
        $blog->status = $request->status == true ? 1 : 0;
        if ($request->hasFile('image')) {
            
             if ($blog->image && file_exists('images/' . $blog->image)) {
                unlink('images/' . $blog->image);
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
           // $image->move(public_path('images'), $imageName);
             $image->move('images/', $imageName);
            $blog->image = $imageName;
        }
        $blog->save();
        return redirect()->route('blog.index')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
          if ($blog->image && file_exists('images/' . $blog->image)) {
                unlink('images/' . $blog->image);
            }
        return redirect()->route('blog.index')->with('success', 'Blog deleted successfully.');
    }
}
