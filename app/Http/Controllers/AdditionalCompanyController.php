<?php

namespace App\Http\Controllers;

use App\Models\AdditionalCompanyName;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdditionalCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $additionalCompanyNames = AdditionalCompanyName::with('company')
            ->orderBy('name', 'asc')
            ->get()
            ->groupBy('company_id')
            ->map(function ($items, $companyId) {
                return [
                    'company_id' => $companyId,
                    'company' => $items->first()->company,
                    'names' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                        ];
                    })->all(),
                ];
            })
            ->values();

        
            return DataTables::of($additionalCompanyNames)
                ->addIndexColumn()

                ->addColumn('company', function ($row) {
                    return '<a href="' . route('companies.show', $row['company_id']) . '">' . $row['company']->name . '</a>';
                })

                ->addColumn('names', function ($row) {
                    return '<ol>' . implode('', array_map(function ($name) {
                            return '<li class="mb-2">' . e($name['name']) . 
                                ' <a href="'.route('additional_companies.edit',$name['id']).'" class="btn btn-info btn-sm" style="margin-left:5px;"><i class="fa fa-edit text-white"></i></a>' .
                                '<form action="' . route('additional_companies.destroy', $name['id']) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to remove this name?\');">' .
                                    csrf_field() .
                                    method_field('DELETE') .
                                    '<button type="submit" class="btn btn-danger btn-sm" style="margin-left:5px; color:red;"><i class="fa fa-trash text-white"></i></button>' .
                                '</form>' .
                                '</li>';
                        }, $row['names'])) . '</ol>';
                })
               
                ->rawColumns(['company','names'])
                ->make(true);
        }

        $companies = Company::pluck('name', 'id');

        return view('admin.companies.additional_names', compact('companies'));
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
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
        ]);
        
        AdditionalCompanyName::create($validatedData);

        return redirect()->route('companies.show', $validatedData['company_id'])
            ->with('success', 'Additional company name added successfully.');

    }


    public function addName(Request $request)
        {
            $validatedData = $request->validate([
                'company_id' => 'required|exists:companies,id',
                'name' => 'required|string|max:255',
            ]);
            
            AdditionalCompanyName::create($validatedData);

            return redirect()->back()->with('success', 'Additional company name added successfully.');

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
        $additionalName = AdditionalCompanyName::with('company')->findOrFail($id);
        if (!$additionalName) {
            return redirect()->route('companies.index')->with('error', 'Additional company name not found.');
        }
        $companies = Company::pluck('name', 'id');
        return view('admin.companies.edit_additional_name', compact('additionalName', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $additionalCompanyName = AdditionalCompanyName::findOrFail($id);
        $additionalCompanyName->update($validatedData);

        return redirect()->back()->with('success', 'Additional company name updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $additionalCompanyName = AdditionalCompanyName::findOrFail($id);
     
        $additionalCompanyName->delete();

        return redirect()->back()->with('success', 'Additional company name deleted successfully.');
    }
}
