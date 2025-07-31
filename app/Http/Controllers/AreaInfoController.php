<?php

namespace App\Http\Controllers;

use App\Models\AreaInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AreaInfoImport;
use App\Exports\AreaInfosExport;
use Throwable;


class AreaInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaInfo::query();

            if ($request->has('name') && $request->name != '') {
                 $data->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->has('prefix') && $request->prefix != '') {
                $data->where('prefix', 'like', '%' . $request->prefix . '%');
            }


            $data = $data->orderBy('name', 'asc')->get();

            return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                return '<div class="d-flex gap-2">  
                            <a href="'.route('area_infos.show',$row->id).'" class="btn btn-sm btn-success text-white"><i class="fa fa-eye"></i></a>            
                            <a href="'.route('area_infos.edit',$row->id).'" class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></a>
                            <form action="'.route('area_infos.destroy', $row->id).'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this area info?\');">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>';
            })
            ->rawColumns(['action']) // only action needs to be raw HTML
            ->make(true);
        }


        return view('admin.area_infos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.area_infos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => 'required|string|max:255',
            'iso_code' => 'required|string|max:255',
            'remarks1' => 'nullable|string|max:255',
            'remarks2' => 'nullable|string|max:255',
        ]);

        // Assuming you have a model named AreaInfo
        $areaInfo = AreaInfo::create($validatedData);

        // Log the creation of the area info
        $logController = new LogController();
        $logController->storeLog('Area Informetion created: ' . $areaInfo->name. ', Id:'.$areaInfo->id, 'create', auth()->user()->id);

        return redirect()->route('area_infos.index')->with('success', 'Area informetion created successfully.');
    }

    /**
     * Show the form for importing area info.
     */

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,txt'
        ]);

        Excel::import(new AreaInfoImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }


    /**
     * Export area info to Excel.
     */
    public function export()
    {
        try {
            return Excel::download(new AreaInfosExport, 'area_infos.xlsx');
        } catch (Throwable $e) {
            dd('Export failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $areaInfo = AreaInfo::findOrFail($id);
        if(!$areaInfo){
            abort(400);
        }

        return view('admin.area_infos.show', compact('areaInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $areaInfo = AreaInfo::findOrFail($id);
        if(!$areaInfo){
            abort(400);
        }

        return view('admin.area_infos.edit', compact('areaInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => 'required|string|max:255',
            'iso_code' => 'required|string|max:255',
            'remarks1' => 'nullable|string|max:255',
            'remarks2' => 'nullable|string|max:255',
        ]);

        // Assuming you have a model named AreaInfo
        AreaInfo::where('id', $id)->update($validatedData);

        // Log the creation of the area info
        $logController = new LogController();
        $logController->storeLog('Area Informetion updated: ' . $request->name. ', Id:'.$id, 'update', auth()->user()->id);

        return redirect()->route('area_infos.index')->with('success', 'Area informetion updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $areaInfo = AreaInfo::findOrFail($id);
        if(!$areaInfo){
            abort(400);
        }
        
        $areaInfo->delete();

        // Log the deletion of the area info
        $logController = new LogController();
        $logController->storeLog('Area Informetion deleted: ' . $areaInfo->name. ', Id:'.$id, 'delete', auth()->user()->id);

        return redirect()->route('area_infos.index')->with('success', 'Area informetion deleted successfully.');
    }


    public function batchDestroy(Request $request)
    {
        $ids = $request->input('ids');

        // Validate input
        if (!$ids || !is_array($ids)) {
            return response()->json(['message' => 'Invalid request.'], 400);
        }

        // Delete the records
        AreaInfo::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Selected records deleted successfully.']);
    }
}
