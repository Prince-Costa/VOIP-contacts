<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterconnectionType;

class InterconnectionTypeController extends Controller
{
    public function index()
    {
        // Fetch all interconnection types from the database
        $interconnectionTypes = InterconnectionType::orderBy('name', 'asc')->get();
        return view('admin.interconnections.index', compact('interconnectionTypes'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:interconnection_types,name',
        ]);

        // Create a new interconnection type record in the database
        $interconnectionType = InterconnectionType::create($validatedData);

        // Log the creation of the interconnection type
        $logController = new LogController();
        $logController->storeLog('Interconnection Type created: ' . $interconnectionType['name']. ', ID:'.$interconnectionType->id, 'create', auth()->user()->id);

        // Redirect back with a success message
        return redirect()->route('interconnections.index')->with('success', 'Interconnection Type created successfully.');
    }

    public function edit( $id)
    {
        $interconnectionType = InterconnectionType::findOrFail($id);
        // Show the form for editing the specified interconnection type
        return view('admin.interconnections.edit', compact('interconnectionType'));
    }

    public function update(Request $request, $id)
    {
        $interconnectionType = InterconnectionType::findOrFail($id);
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:interconnection_types,name,' . $interconnectionType->id,
        ]);

        // Update the interconnection type record in the database
        $interconnectionType->update($validatedData);

         // Log the creation of the interconnection type
         $logController = new LogController();
         $logController->storeLog('Interconnection Type updated: ' . $interconnectionType['name']. ', ID:'.$interconnectionType->id, 'update', auth()->user()->id);

        // Redirect back with a success message
        return redirect()->route('interconnections.index')->with('success', 'Interconnection Type updated successfully.');
    }

    public function destroy($id)
    {
        $interconnectionType = InterconnectionType::findOrFail($id);
        // Delete the specified interconnection type record from the database
        $interconnectionType->delete();

        // Log the deletion of the interconnection type
        $logController = new LogController();
        $logController->storeLog('Interconnection Type deleted: ' . $interconnectionType['name']. ', ID:'.$interconnectionType->id, 'delete', auth()->user()->id);

        // Redirect back with a success message
        return redirect()->route('interconnections.index')->with('success', 'Interconnection Type deleted successfully.');
    }
}
