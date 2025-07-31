<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all regions from the database
        $regions = Region::orderBy('name', 'asc')->get();


        return view('admin.regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|unique:regions,name',
            'code' => 'nullable|unique:regions,code',
        ]);

        // Create a new region
        $region = Region::create($request->all());

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('World region created: ' . $region->name. ', Id:'.$region->id, 'create', auth()->user()->id);

        // Redirect back with success message
        return redirect()->route('regions.index')->with('success', 'Region created successfully.');
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
        // Find the region by ID
        $region = Region::findOrFail($id);
        if (!$region) {
            abort(404);
        }

        // Return the edit view with the region data
        return view('admin.regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|unique:regions,name,' . $id,
            'code' => 'nullable|unique:regions,code,' . $id,
        ]);

        // Find the region by ID and update it
        $region = Region::findOrFail($id);
        $region->update($request->all());

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('World region updated: ' . $region->name. ', Id:'.$region->id, 'create', auth()->user()->id);

        // Redirect back with success message
        return redirect()->route('regions.index')->with('success', 'Region updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the region by ID
        $region = Region::findOrFail($id);

        // Delete the region
        $region->delete();

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('World region deleted: ' . $region->name. ', Id:'.$region->id, 'create', auth()->user()->id);
        // Redirect back with success message
        return redirect()->route('regions.index')->with('success', 'Region deleted successfully.');
    }
}
