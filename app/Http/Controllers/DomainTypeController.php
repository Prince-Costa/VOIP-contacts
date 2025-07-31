<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\DomainType;
use Illuminate\Http\Request;

class DomainTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $domainTypes = DomainType::all();

        return view('admin.domain_types.index', compact('domainTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $domainType = DomainType::create($request->all());

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('Domain type created: ' . $domainType->name. ', Id:'.$domainType->id, 'create', auth()->user()->id);

        return redirect()->route('domain_types.index')->with('success', 'Domain Type created successfully.');

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
        $domainType = DomainType::findOrFail($id);

        if (!$domainType) {
            abort(404);
        }

        return view('admin.domain_types.edit', compact('domainType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $domainType = DomainType::findOrFail($id);
        $domainType->update($request->all());

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('Domain type updated: ' . $domainType->name. ', Id:'.$domainType->id, 'create', auth()->user()->id);

        return redirect()->route('domain_types.index')->with('success', 'Domain Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $domainType = DomainType::findOrFail($id);

        if (!$domainType) {
            abort(404);
        }

        $domainType->delete();

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('Domain type deleted: ' . $domainType->name. ', Id:'.$domainType->id, 'create', auth()->user()->id);

        return redirect()->route('domain_types.index')->with('success', 'Domain Type deleted successfully.');
    }
}
