<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaBillingIncriment;
use Yajra\DataTables\Facades\DataTables;


class AreaBillingIncrimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaBillingIncriment::orderBy('destination_name', 'asc')->get();

            return DataTables::of($data)
            ->addIndexColumn()
            
        
            ->addColumn('action', function ($row) {
                return '<div class="d-flex gap-2">              
                            <a href="'.route('area_billing_incriments.edit',$row->id).'" class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></a>
                            <form action="'.route('area_billing_incriments.destroy', $row->id).'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this billing incriment?\');">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>';
            })
            ->rawColumns(['action','details','remarks']) // only action needs to be raw HTML
            ->make(true);
        }


        return view('admin.area_billing_incriments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.area_billing_incriments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'destination_name' => 'required|string|max:255',
            'breakouts' => 'required|string|max:255',
            'billing_incriment' => 'required|string|max:255',
            'refer' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['destination_name', 'breakouts', 'billing_incriment', 'refer']);

        // Assuming you have a model named AreaBillingIncriment
        $areaBillingIncriment = new AreaBillingIncriment($data);
        $areaBillingIncriment->save();

        // Log the creation of the new area billing increment
        $logController = new LogController();
        $logController->storeLog('Area Billing Increment Created: ' . $areaBillingIncriment->destination_name. ', ID:'.$areaBillingIncriment->id, 'create', auth()->user()->id);

        return redirect()->route('area_billing_incriments.index')->with('success', 'Area Billing Increment created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $areaBillingIncrement = AreaBillingIncriment::findOrFail($id);
        return view('admin.area_billing_incriments.edit', compact('areaBillingIncrement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'destination_name' => 'required|string|max:255',
            'breakouts' => 'required|string|max:255',
            'billing_incriment' => 'required|string|max:255',
            'refer' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['destination_name', 'breakouts', 'billing_incriment', 'refer']);

        // Assuming you have a model named AreaBillingIncriment
        $areaBillingIncriment = AreaBillingIncriment::findOrFail($id);
        $areaBillingIncriment->update($data);

        // Log the update of the area billing increment
        $logController = new LogController();
        $logController->storeLog('Area Billing Increment Updated: ' . $areaBillingIncriment->destination_name. ', Id:'.$areaBillingIncriment->id, 'update', auth()->user()->id);

        return redirect()->route('area_billing_incriments.index')->with('success', 'Area Billing Increment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $areaBillingIncriment = AreaBillingIncriment::findOrFail($id);
        $areaBillingIncriment->delete();

        // Log the deletion of the area billing increment
        $logController = new LogController();
        $logController->storeLog('Area Billing Increment Deleted: ' . $areaBillingIncriment->destination_name. ', Id:'.$areaBillingIncriment->id, 'delete', auth()->user()->id);

        return redirect()->route('area_billing_incriments.index')->with('success', 'Area Billing Increment deleted successfully.');
    }
}
