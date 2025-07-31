<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\TradeReference;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TradeReferanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
            $groups = TradeReference::get()->groupBy('parent_id');
        
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
                        <form action="' . route('removeTradeReferences',['parent_id' => $childItem->parent->id, 'reference_company_id' => $child->id]) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this reference company?\');" style="display: inline;">
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
                        <strong class="text-info">Business Type: ' . ($parent->businessType->name ?? '—') . '</strong><br>
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

        return view('admin.companies.trade_references', compact('companies'));
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
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'reference_company_ids' => 'required|array|min:1',
            'reference_company_ids.*' => 'required|exists:companies,id',
        ]);
    
        $tradeReferenceData = [];
        foreach ($request->input('reference_company_ids') as $referenceId) {
            $tradeReferenceData[] = [
            'parent_id' => $request->input('company_id'),
            'reference_company_id' => $referenceId,
            'created_at' => now(),
            'updated_at' => now(),
            ];
        }

        TradeReference::insert($tradeReferenceData);
      

       // Log the creation of the child companies
       $logController = new LogController();
       foreach ($tradeReferenceData as $referenceData) {
           $logController->storeLog(
           'Trade Reference Added: Parent ID: ' . $referenceData['parent_id'] . ', Reference Company ID: ' . $referenceData['reference_company_id'],
           'create',
           auth()->user()->id
           );
       }

       return redirect()->route('companies.show', $request->input('company_id'))
           ->with('success', 'Trade references added successfully.');
   }



   public function addTradeReference(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'trade_reference_id' => 'required|array|min:1',
            'trade_reference_id.*' => 'required|exists:companies,id',
        ]);
    
        $tradeReferenceData = [];
        foreach ($request->input('trade_reference_id') as $referenceId) {
            $tradeReferenceData[] = [
            'parent_id' => $request->input('company_id'),
            'reference_company_id' => $referenceId,
            'created_at' => now(),
            'updated_at' => now(),
            ];
        }

        TradeReference::insert($tradeReferenceData);
      

       // Log the creation of the child companies
       $logController = new LogController();
       foreach ($tradeReferenceData as $referenceData) {
           $logController->storeLog(
           'Trade Reference Added: Parent ID: ' . $referenceData['parent_id'] . ', Reference Company ID: ' . $referenceData['reference_company_id'],
           'create',
           auth()->user()->id
           );
       }

       return redirect()->route('trade_references.index')
           ->with('success', 'Trade references added successfully.');
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
       //
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
       //
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy($parent_id, $reference_company_id)
   {
       $referenceCompany = TradeReference::where('parent_id', $parent_id)-> where('reference_company_id', $reference_company_id)->first();

       if (!$referenceCompany) {
            return redirect()->back()->with('error', 'Child company not found.');
        }

       $referenceCompany->delete();

       // Log the creation of the company
       $logController = new LogController();
       $logController->storeLog('Trade Reference Removed: Parent ID: ' . $referenceCompany->parent_id . ', Reference Company ID: ' . $referenceCompany->reference_company_id, 'delete', auth()->user()->id);

       return redirect()->back()->with('success', 'Trade reference removed successfully.');
   }
}
