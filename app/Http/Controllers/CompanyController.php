<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Tag;
use App\Models\Domain;
use App\Models\Company;
use App\Models\Country;
use App\Models\BusinessType;
use App\Models\CompanyChild;
use Illuminate\Http\Request;
use App\Models\CompanyDomain;
use App\Models\TradeReference;
use Illuminate\Support\Facades\DB;
use App\Models\InterconnectionType;


class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::with('basedOnCountry', 'operatingOnCountry','businessType','interconnectionType','tags','domains','additionalCompanyNames');

            if ($request->has('name') && $request->name != '') {
                $data->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->name . '%')
                        ->orWhereHas('additionalCompanyNames', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->name . '%');
                        });
                });
            }

            if ($request->has('domain_id') && $request->domain_id != '') {
                $data->whereHas('domains', function ($query) use ($request) {
                    $query->where('domain_id', $request->domain_id);
                });
            }

            if ($request->has('tag_id') && $request->tag_id != '') {
                $data->whereHas('tags', function ($query) use ($request) {
                    $query->where('tag_id', $request->tag_id);
                });
            }

            if ($request->has('based_on') && $request->based_on != '') {
                $data->where('based_on', $request->based_on);
            }

            if ($request->has('interconnection_type') && $request->interconnection_type != '') {
                $data->where('interconnection_type', $request->interconnection_type);
            }

            $data = $data->orderBy('name', 'asc')->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return '<div class="text-success">Name: ' . ($row->name ?? '—') . '</div>'
                    . (count($row->domains) > 0
                        ? '<div class="text-light">Domains: '
                            . collect($row->domains)->map(function($domain) {
                                $name = DB::table('domains')->where('id', $domain->domain_id)->value('name');
                                return '<span class="badge bg-secondary" style="margin-right:3px;">' . e($name) . '</span>';
                            })->implode(' ')
                        . '</div>'
                        : ''
                    )
                    . (count($row->additionalCompanyNames) > 0
                        ? '<div class="text-danger">Additional Names: '
                            . collect($row->additionalCompanyNames)->map(function($company) {
                                return '<span class="badge bg-danger" style="margin-right:3px;">' . e($company->name) . '</span>';
                            })->implode(' ')
                        . '</div>'
                        : ''
                    );
            })
            ->addColumn('country', function ($row) {
                $html = '';
                if (!empty($row->operatingOnCountry) && !empty($row->operatingOnCountry->name)) {
                    $html .= '<div class="text-success">Operating On: ' . e($row->operatingOnCountry->name) . '</div>';
                }
                if (!empty($row->basedOnCountry) && !empty($row->basedOnCountry->name)) {
                    $html .= '<div class="text-dark">Based On: ' . e($row->basedOnCountry->name) . '</div>';
                }
                return $html ?: '—';
            })
            ->addColumn('others', function ($row) {
                $html = '';
                if (!empty($row->interconnectionType) && !empty($row->interconnectionType->name)) {
                    $html .= '<div class="text-success">Interconnection type: ' . e($row->interconnectionType->name) . '</div>';
                }
                if (!empty($row->businessType) && !empty($row->businessType->name)) {
                    $html .= '<div class="text-dark">Business type: ' . e($row->businessType->name) . '</div>';
                }
                if (!empty($row->credit_limit)) {
                    $html .= '<div class="text-primary">Credit Limit: ' . e($row->credit_limit) . '</div>';
                }
                if (!empty($row->agreement_status)) {
                    $html .= '<div class="text-success">Agreement Status: ' . e($row->agreement_status) . '</div>';
                }
                if (!empty($row->usdt_support)) {
                    $html .= '<div class="text-dark">USDT Support: ' . e($row->usdt_support) . '</div>';
                }
                return $html ?: '—';
            })

            ->addColumn('tags', function ($row) {
                return $row->tags->map(function ($tag) {
                    return '<span style="font-size:12px; background-color:' . $tag->background_color . '; color:' . $tag->text_color . '; padding: 3px 3px; border-radius: 3px; margin-right: 3px; display: inline-block; margin-bottom:3px;">' . $tag->name . '</span>';
                })->implode(' ');
            })
            ->addColumn('action', function ($row) {
                return '<div class="d-flex gap-2">
                            <a href="'.route('companies.show',$row->id).'" class="btn btn-sm btn-success text-white"><i class="fa fa-eye"></i></a>
                            <a href="'.route('companies.edit',$row->id).'" class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></a>
                            <form action="'.route('companies.destroy', $row->id).'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this company?\');">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>';
            })
            ->rawColumns(['action','tags','country', 'name','others']) // only action needs to be raw HTML
            ->make(true);
        }

        $countries = Country::all();
      
        $interconnectionTypes = InterconnectionType::all();

        $tags = Tag::all();

        return view('admin.companies.index', compact('countries', 'interconnectionTypes', 'tags'));
    }


    public function show($id)
    {
        $company = Company::with('basedOnCountry', 'operatingOnCountry','businessType','interconnectionType','tags','domains')->findOrFail($id);

        if(!$company){
            abort(404);
        }

        // $parentIds = CompanyChild::pluck('parent_id');
        // $childIds = CompanyChild::pluck('child_company_id');
        // $excludeIds = $parentIds->merge($childIds)->push($id)->unique();
        // $companies = Company::whereNotIn('id', $excludeIds)->get();

        // Get all child company IDs where the parent is the current company
        $childIds = CompanyChild::where('parent_id', $id)->pluck('child_company_id');
        $excludeIds = $childIds->push($id)->unique();
        $companies = Company::whereNotIn('id', $excludeIds)->get();

        // $parentTradIds = TradeReference::pluck('parent_id');
        // $childTradIds = TradeReference::pluck('reference_company_id');
        // $excludeTradeIds = $parentTradIds->merge($childTradIds)->push($id)->unique();
        // $tradeCompanies = Company::whereNotIn('id', $excludeTradeIds)->get();
        // Get all trade reference company IDs where the parent is the current company
        $tradeIds = TradeReference::where('parent_id', $id)->pluck('reference_company_id');
        $excludeTradeIds = $tradeIds->push($id)->unique();
        $tradeCompanies = Company::whereNotIn('id', $excludeTradeIds)->get();
      

        return view('admin.companies.show', compact('company','companies','tradeCompanies'));
    }
    
    public function create()
    {
        $countries = Country::all();
        $businessTypes = BusinessType::all();
        $interconnectionTypes = InterconnectionType::all();
        $tags = Tag::all();

        return view('admin.companies.create', compact('countries', 'businessTypes', 'interconnectionTypes','tags'));
    }
    
    public function store(Request $request)
    {
        // Validate the request data
       $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'domain_ids' => 'exists:domains,id',
            'registered_address' => 'nullable|string|max:255',
            'office_address' => 'nullable|string|max:255',
            'business_phone' => 'nullable|string|max:255',
            'credit_limit' => 'nullable|string|max:255',
            'based_on' => 'nullable|exists:countries,id',
            'operating_on' => 'nullable |exists:countries,id',
            'business_type' => 'nullable|exists:business_types,id',
            'interconnection_type' => 'nullable|exists:interconnection_types,id',
            'agreement_status' => 'nullable',
            'usdt_support' => 'nullable|in:Yes,No',
            'remarks1' => 'nullable|string',
            'remarks2' => 'nullable|string',
        ]);

        $company = Company::create($validatedData);
        
        // Attach the new domains
        $domainIds = $request->input('domain_ids');

        if (is_array($domainIds)) {
            $insertData = [];

            foreach ($domainIds as $domainId) {
                $insertData[] = [
                    'company_id' => $company->id,
                    'domain_id' => $domainId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            CompanyDomain::insert($insertData);
        }
        
        // Sync the tags with the company
        $company->tags()->sync($request->input('tags', []));

        // Log the creation of the company
        $logController = new LogController();
        $logController->storeLog('Company created: ' . $company->name. ', Id:'.$company->id, 'create', auth()->user()->id);

        return redirect()->route('companies.index')->with('success', 'Company added successfully.');
    }   

    public function addDomain(Request $request)
    {

        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'domain_ids' => 'required|array|min:1',
            'domain_ids.*' => 'required|exists:domains,id',
        ]);

        $company = Company::findOrFail($validatedData['company_id']);

        // Attach the new domains
        $domainIds = $request->input('domain_ids');

        if (is_array($domainIds)) {
            $insertData = [];

            foreach ($domainIds as $domainId) {
                $insertData[] = [
                    'company_id' => $company->id,
                    'domain_id' => $domainId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            CompanyDomain::insert($insertData);
        }

        // Log the removal of the domain
        $logController = new LogController();
        $logController->storeLog('Domain Added to company('. $company->name.')' , 'added', auth()->user()->id);

        return redirect()->back()->with('success', 'Domains added successfully.');
    }

    public function removeDomain($companyId, $domainId)
    {
        $company = Company::findOrFail($companyId);
        $domain = Domain::findOrFail($domainId);

        // Detach the domain from the company
        $companyDomain = CompanyDomain::where('company_id', $companyId)->where('domain_id', $domainId)->first();

        if ($companyDomain) {
            $companyDomain->delete();
            // Log the removal of the domain
            $logController = new LogController();
            $logController->storeLog('Domain removed: ' . $domain->name . ', Id: ' . $domainId,'removed', auth()->user()->id);

        } else {
            return redirect()->back()->with('error', 'Domain not found for this company.');
        }
        

        return redirect()->back()->with('success', 'Domain removed successfully.');
    }
    
    public function edit($id)
    {
        $company = Company::findOrFail($id);

        if(!$company){
            abort(404);
        }

        $countries = Country::all();
        $businessTypes = BusinessType::all();
        $interconnectionTypes = InterconnectionType::all();
        $tags = Tag::all();
        $selectedDomains = CompanyDomain::where('company_id', $id)->pluck('domain_id')->toArray();
        $selectedTags = $company->tags->pluck('id')->toArray();
        
        return view('admin.companies.edit', compact(
            'countries',
            'businessTypes',
            'interconnectionTypes',
            'tags',
            'selectedTags',
            'company',
            'selectedDomains',
        ));
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'domain_ids' => 'exists:domains,id',
            'registered_address' => 'nullable|string|max:255',
            'office_address' => 'nullable|string|max:255',
            'business_phone' => 'nullable|string|max:255',
            'credit_limit' => 'nullable|string|max:255',
            'based_on' => 'nullable|exists:countries,id',
            'operating_on' => 'nullable |exists:countries,id',
            'business_type' => 'nullable|exists:business_types,id',
            'interconnection_type' => 'nullable|exists:interconnection_types,id',
            'agreement_status' => 'nullable',
            'usdt_support' => 'nullable|in:Yes,No',
            'remarks1' => 'nullable|string',
            'remarks2' => 'nullable|string',
        ]);
        $company = Company::findOrFail($id);
        $company->update($validatedData);

        // Detach all existing domains
        $domains = CompanyDomain::where('company_id', $id)->get();
        foreach ($domains as $domain) {
            $domain->delete();
        }

        // Attach the new domains
        $domainIds = $request->input('domain_ids');

        if (is_array($domainIds)) {
            $insertData = [];

            foreach ($domainIds as $domainId) {
                $insertData[] = [
                    'company_id' => $company->id,
                    'domain_id' => $domainId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            CompanyDomain::insert($insertData);
        }


        // Sync the tags with the company
        // This will attach new tags and detach removed ones
        $company->tags()->sync($request->input('tags', []));

        // Log the update of the company
        $logController = new LogController();
        $logController->storeLog('Company updated: ' . $company->name. ', Id:'.$id, 'update', auth()->user()->id);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }
    
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        if(!$company){
            abort(404);
        }
        
        $company->tags()->detach(); // Detach tags before deleting the company
        $company->delete();
        CompanyChild::where('parent_id', $id)->orWhere('child_company_id', $id)->delete();
        TradeReference::where('parent_id', $id)->orWhere('reference_company_id', $id)->delete();

        // Log the deletion of the company
        $logController = new LogController();
        $logController->storeLog('Company deleted: ' . $company->name. ', Id:'.$id, 'delete', auth()->user()->id);

        // Flash message for success
        session()->flash('success', 'Company deleted successfully.');

        return redirect()->route('companies.index');
    }   
}
