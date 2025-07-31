<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyChild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class ChildCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $groups = CompanyChild::get()->groupBy('parent_id');
        
            $formatted = [];
        
            foreach ($groups as $parentId => $childGroup) {
                $parent = $childGroup->first()->parent;
        
                $childHTML = '';
                $childCount = count($childGroup);
                $currentIndex = 0;

                foreach ($childGroup as $childItem) {
                    $currentIndex++;
                    $child = $childItem->child;
                    $childHTML .= '<div style="margin-bottom: 10px;">
                        <strong class="text-success">' . ($child->name ?? 'N/A') . '</strong><br>
                        <strong class="text-dark"> Domains: '
                        .collect($child->domains)->map(function($domain) {
                            $name = DB::table('domains')->where('id', $domain->domain_id)->value('name');
                            return '<span class="badge bg-secondary" style="margin-right:3px;">' . e($name) . '</span>';
                        })->implode(' ').
                        '</strong><br>
                        <strong class="text-primary">Based On: ' . ($child->basedOnCountry->name ?? '—') . '</strong><br>
                        <strong class="text-success">Operating On: ' . ($child->operatingOnCountry->name ?? '—') . '</strong><br>
                        <strong class="">Business Type: ' . ($child->businessType->name ?? '—') . '</strong><br>
                        <strong class="text-primary">Interconnection: ' . ($child->interConnectionType->name ?? '—') . '</strong><br>';
                
                    if ($child->tags->isNotEmpty()) {
                        foreach ($child->tags as $tag) {
                            $childHTML .= '<span style="font-size:12px; background-color:' . $tag->background_color . '; color:' . $tag->text_color . '; padding: 3px 3px; border-radius: 3px; margin-right: 3px; display: inline-block;">' . $tag->name . '</span>';
                        }
                    }
                
                    // 👇 Add action buttons here
                    $childHTML .= '<div class="mt-2 d-flex gap-2">
                        <a href="' . route('companies.show', $child->id) . '" class="btn btn-sm btn-success text-white" title="View"><i class="fa fa-eye"></i></a>
                        <a href="' . route('companies.edit', $child->id) . '" class="btn btn-sm btn-info text-white" title="Edit"><i class="fa fa-edit"></i></a>     
                        <form action="' . route('removeChild', ['parent_id' => $childItem->parent->id, 'child_company_id' => $child->id]) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this child company?\');" style="display: inline;">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm text-white"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>';
                
                    $childHTML .= '</div>'; // Close child block
                
                    if ($currentIndex < $childCount) {
                        $childHTML .= '<hr>';
                    }
                }
        
                $formatted[] = [
                    'parent_info' => '
                        <strong class="text-success">Name: ' . ($parent->name ?? 'N/A') . '</strong><br>
                        <strong class="text-dark"> Domains: '
                        .collect($parent->domains)->map(function($domain) {
                            $name = DB::table('domains')->where('id', $domain->domain_id)->value('name');
                            return '<span class="badge bg-secondary" style="margin-right:3px;">' . e($name) . '</span>';
                        })->implode(' ').
                        '</strong><br>
                        <strong class="text-primary">Based On: ' . ($parent->basedOnCountry->name ?? '—') . '</strong><br>
                        <strong class="text-success">Operating On: ' . ($parent->operatingOnCountry->name ?? '—') . '</strong><br>
                        <strong class="">Business Type: ' . ($parent->businessType->name ?? '—') . '</strong><br>
                        <strong class="text-primary">Interconnection: ' . ($parent->interConnectionType->name ?? '—') . '</strong><br>' .
                        ($parent->tags->isNotEmpty() ? '<br>' . $parent->tags->map(function ($tag) {
                            return '<span style="font-size:12px; background-color:' . $tag->background_color . '; color:' . $tag->text_color . '; padding: 3px 3px; border-radius: 3px; margin-right: 3px;">' . $tag->name . '</span>';
                        })->implode(' ') : '') . '
                
                        <div class="mt-2 d-flex gap-2">
                            <a href="' . route('companies.show', $parent->id) . '" class="btn btn-sm btn-success text-white" title="View"><i class="fa fa-eye"></i></a>
                            <a href="' . route('companies.edit', $parent->id) . '" class="btn btn-sm btn-info text-white" title="Edit"><i class="fa fa-edit"></i></a>
                        </div>',
                    
                    'children_info' => $childHTML // already includes action buttons per child as added earlier
                ];
            }
        
            return DataTables::of(collect($formatted))
                ->rawColumns(['parent_info', 'children_info', 'action'])
                ->make(true);
        }

        $companies = Company::pluck('name', 'id');

        return view('admin.companies.child_companies', compact('companies'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'child_company_id' => 'required|array|min:1',
            'child_company_id.*' => 'required|exists:companies,id',
        ]);
       
        $companyChildData = [];
        foreach ($request->input('child_company_id') as $childId) {
            $companyChildData[] = [
            'parent_id' => $request->input('company_id'),
            'child_company_id' => $childId,
            'created_at' => now(),
            'updated_at' => now(),
            ];
        }

        CompanyChild::insert($companyChildData);

        // Log the creation of the child companies
        $logController = new LogController();
        foreach ($companyChildData as $childData) {
            $logController->storeLog(
            'Child Company Added: Parent ID: ' . $childData['parent_id'] . ', Child Company ID: ' . $childData['child_company_id'],
            'create',
            auth()->user()->id
            );
        }



        return redirect()->route('companies.show', $request->input('company_id'))
            ->with('success', 'Child company added successfully.');
    }


    public function addChildCompany(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'child_company_id' => 'required|array|min:1',
            'child_company_id.*' => 'required|exists:companies,id',
        ]);
       
        $companyChildData = [];
        foreach ($request->input('child_company_id') as $childId) {
            $companyChildData[] = [
            'parent_id' => $request->input('company_id'),
            'child_company_id' => $childId,
            'created_at' => now(),
            'updated_at' => now(),
            ];
        }

        CompanyChild::insert($companyChildData);

        // Log the creation of the child companies
        $logController = new LogController();
        foreach ($companyChildData as $childData) {
            $logController->storeLog(
            'Child Company Added: Parent ID: ' . $childData['parent_id'] . ', Child Company ID: ' . $childData['child_company_id'],
            'create',
            auth()->user()->id
            );
        }


        return redirect()->back()->with('success', 'Child company added successfully.');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($parentId, $childId)
    {
        // Find the child company record
        $companyChild = CompanyChild::where('parent_id', $parentId)->where('child_company_id', $childId)->first();

        if (!$companyChild) {
            return redirect()->back()->with('error', 'Child company not found.');
        }

        // Delete the child company record

        $companyChild->delete();

        // Log the creation of the company
        $logController = new LogController();
        $logController->storeLog('Child Company Removed: Parent ID: ' . $companyChild->parent_id . ', Child Company ID: ' . $companyChild->child_company_id, 'delete', auth()->user()->id);

        return redirect()->back()->with('success', 'Child company removed successfully.');
    }
}
