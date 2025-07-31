<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use Illuminate\Http\Request;

class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all business types from the database
        $businessTypes = BusinessType::orderBy('name', 'asc')->get();
        return view('admin.businesstypes.index', compact('businessTypes'));
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:business_types,name',
        ]);

        // Create a new business type record in the database
        $businessType = BusinessType::create($validatedData);

        // Log the creation of the business type
        $logController = new LogController();
        $logController->storeLog('Business Type created: ' . $businessType->name. ', ID:'.$businessType->id, 'create', auth()->user()->id);

        // Redirect back with a success message
        return redirect()->route('businesstypes.index')->with('success', 'Business Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $businessType = BusinessType::findOrFail($id);
        // Show the form for editing the specified business type
        return view('admin.businesstypes.edit', compact('businessType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $businessType = BusinessType::findOrFail($id);
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:business_types,name,' . $businessType->id,
        ]);

        // Update the business type record in the database
        $businessType->update($validatedData);

        // Log the update of the business type
        $logController = new LogController();
        $logController->storeLog('Business Type updated: ' . $businessType->name . ', Id:' . $businessType->id, 'update', auth()->user()->id);

        // Redirect back with a success message
        return redirect()->route('businesstypes.index')->with('success', 'Business Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $businessType = BusinessType::findOrFail($id);
        // Delete the specified business type record from the database
        $businessType->delete();

        // Log the deletion of the business type
        $logController = new LogController();
        $logController->storeLog('Business Type deleted: ' . $businessType->name . ', Id:' . $businessType->id, 'delete', auth()->user()->id);

        // Redirect back with a success message
        return redirect()->route('businesstypes.index')->with('success', 'Business Type deleted successfully.');
    }
}
