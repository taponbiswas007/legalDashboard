<?php

namespace App\Http\Controllers;

use App\Models\LegalNoticePricing;
use App\Models\Addclient;
use App\Models\LegalNoticeCategory;
use Illuminate\Http\Request;

class LegalNoticePricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LegalNoticePricing::with(['client', 'category']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhere('price', 'LIKE', "%{$search}%");
        }

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $pricings = $query->paginate(15);
        $clients = Addclient::orderBy('name')->get();
        $categories = LegalNoticeCategory::orderBy('name')->get();

        return view('backendPage.legalnotice.pricing.index', compact('pricings', 'clients', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Addclient::orderBy('name')->get();
        $categories = LegalNoticeCategory::orderBy('name')->get();

        return view('backendPage.legalnotice.pricing.create', compact('clients', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:addclients,id',
            'category_id' => 'required|exists:legal_notice_categories,id',
            'price' => 'required|numeric|min:0|max:99999999.99',
        ], [
            'client_id.required' => 'Please select a client.',
            'client_id.exists' => 'The selected client is invalid.',
            'category_id.required' => 'Please select a section/category.',
            'category_id.exists' => 'The selected category is invalid.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
        ]);

        // Check if pricing already exists for this client-category combo
        $exists = LegalNoticePricing::where('client_id', $validated['client_id'])
            ->where('category_id', $validated['category_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Pricing already exists for this Client and Section combination. Please update the existing one.');
        }

        LegalNoticePricing::create($validated);

        return redirect()->route('legalnotice.pricing.index')
            ->with('success', 'Pricing created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LegalNoticePricing $pricing)
    {
        $clients = Addclient::orderBy('name')->get();
        $categories = LegalNoticeCategory::orderBy('name')->get();

        return view('backendPage.legalnotice.pricing.edit', compact('pricing', 'clients', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LegalNoticePricing $pricing)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:addclients,id',
            'category_id' => 'required|exists:legal_notice_categories,id',
            'price' => 'required|numeric|min:0|max:99999999.99',
        ]);

        // Check if another pricing with same combo exists
        $exists = LegalNoticePricing::where('client_id', $validated['client_id'])
            ->where('category_id', $validated['category_id'])
            ->where('id', '!=', $pricing->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This Client and Section combination is already assigned to another pricing.');
        }

        $pricing->update($validated);

        return redirect()->route('legalnotice.pricing.index')
            ->with('success', 'Pricing updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LegalNoticePricing $pricing)
    {
        $clientName = $pricing->client?->name ?? 'Unknown';
        $categoryName = $pricing->category?->name ?? 'Unknown';

        $pricing->delete();

        return redirect()->route('legalnotice.pricing.index')
            ->with('success', "Pricing for {$clientName} - {$categoryName} deleted successfully!");
    }

    /**
     * API endpoint to get price by client_id and category_id
     * Used for auto-filling amount in bill form
     */
    public function getPriceByClientAndCategory(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:addclients,id',
            'category_id' => 'required|exists:legal_notice_categories,id',
        ]);

        $pricing = LegalNoticePricing::where('client_id', $request->client_id)
            ->where('category_id', $request->category_id)
            ->first();

        if ($pricing) {
            return response()->json([
                'success' => true,
                'price' => $pricing->price,
            ]);
        }

        return response()->json([
            'success' => false,
            'price' => null,
            'message' => 'No pricing found for this combination.',
        ], 404);
    }
}
