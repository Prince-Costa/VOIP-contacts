<?php

namespace App\Http\Controllers;

use App\Models\DomainStatus;
use Illuminate\Http\Request;

class DomainStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $domainStatuses = DomainStatus::all();

        return view('admin.domain_statuses.index', compact('domainStatuses'));
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
        ]);

        $domainStatus = DomainStatus::create($request->all());

         // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('Domain Status created: ' . $domainStatus->name. ', Id:'.$domainStatus->id, 'create', auth()->user()->id);

        return redirect()->route('domain_statuses.index')->with('success', 'Domain Status created successfully.');

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
        $DomainStatus = DomainStatus::findOrFail($id);

        if (!$DomainStatus) {
            abort(404);
        }

        return view('admin.domain_statuses.edit', compact('DomainStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $DomainStatus = DomainStatus::findOrFail($id);
        $DomainStatus->update($request->all());

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('Domain Status updated: ' . $DomainStatus->name. ', Id:'.$DomainStatus->id, 'create', auth()->user()->id);

        return redirect()->route('domain_statuses.index')->with('success', 'Domain Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $DomainStatus = DomainStatus::findOrFail($id);
        
        if (!$DomainStatus) {
            abort(404);
        }

        $DomainStatus->delete();

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('Domain Status deleted: ' . $DomainStatus->name. ', Id:'.$DomainStatus->id, 'create', auth()->user()->id);

        return redirect()->route('domain_statuses.index')->with('success', 'Domain Status deleted successfully.');
    }
}
