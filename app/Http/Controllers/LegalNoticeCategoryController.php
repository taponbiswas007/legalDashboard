<?php

namespace App\Http\Controllers;

use App\Models\LegalNoticeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LegalNoticeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legalNoticeCategories = LegalNoticeCategory::paginate(10);

        return view ('backendPage.legalnoticecategories.index', compact ('legalNoticeCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('backendPage.legalnoticecategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
        ]);

        $legalNoticeCategory = LegalNoticeCategory::create($validateData);

        return redirect () -> route('legalnoticecategories.index')->with('success', 'Legal Notice Category Create Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $decryptedId = Crypt::decrypt($id);
        $legalNoticeCategory = LegalNoticeCategory::findOrFail($decryptedId);
        return view ('backendPage.legalnoticecategories.show', compact ('legalNoticeCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptedId = Crypt::decrypt($id);
        $legalNoticeCategory = LegalNoticeCategory::findOrFail($decryptedId);
        return view ('backendPage.legalnoticecategories.edit', compact ('legalNoticeCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       // 1. ডেটা ভ্যালিডেট করুন
    $validatedData = $request->validate([
        "name" => "required|string|max:255",
        "description" => "nullable|string",
    ]);

    // 2. ID ব্যবহার করে ম্যানুয়ালি মডেলটি খুঁজে নিন
    $legalNoticeCategory = LegalNoticeCategory::findOrFail($id);

    // 3. ডেটা আপডেট করুন
    $legalNoticeCategory->update($validatedData);
       

        return redirect () -> route('legalnoticecategories.index')->with('success', 'Legal Notice Category Update Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LegalNoticeCategory $legalNoticeCategory)
    {
        $legalNoticeCategory->delete();
        return redirect()->route('backendPage.legalnoticecategories.index')->with('success', 'Legal Notice Category deleted successfully');
    }
}
