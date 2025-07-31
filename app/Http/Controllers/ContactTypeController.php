<?php

namespace App\Http\Controllers;

use App\Models\ContactType;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactTypes = ContactType::orderBy('name', 'asc')->get();
        return view('admin.contacttypes.index', compact('contactTypes'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contact_types,name',
        ]);

        $contactType = ContactType::create($request->all());

         // Log the creation of the Contact Type
         $logController = new LogController();
         $logController->storeLog('Contact Type created: ' . $contactType->name. ', Id:'.$contactType->id, 'create', auth()->user()->id);

        return redirect()->route('contacttypes.index')->with('success', 'Contact Type created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contactType = ContactType::findOrFail($id);
        return view('admin.contacttypes.edit', compact('contactType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contact_types,name,' . $id,
        ]);

        $contactType = ContactType::findOrFail($id);
        $contactType->update($request->all());

        // Log the update of the Contact Type
        $logController = new LogController();
        $logController->storeLog('Contact Type updated: ' . $contactType->name. ', Id:'.$contactType->id, 'update', auth()->user()->id);

        return redirect()->route('contacttypes.index')->with('success', 'Contact Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contactType = ContactType::findOrFail($id);
        $contactType->delete();

        // Log the deletion of the Contact Type
        $logController = new LogController();
        $logController->storeLog('Contact Type deleted: ' . $contactType->name. ', Id:'.$contactType->id, 'delete', auth()->user()->id);

        return redirect()->route('contacttypes.index')->with('success', 'Contact Type deleted successfully.');
    }
}
