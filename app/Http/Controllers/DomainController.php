<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Domain;
use App\Models\DomainType;
use App\Models\DomainStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DomainController extends Controller
{
    public function index(Request $request)
    {
        // Return the data as a JSON response for DataTables
        if ($request->ajax()) {
            
            // Fetch all domains from the database with optional filtering
            $query = Domain::query()
            ->where('type', 'not like', '%Public-Free%')
            ->leftJoin('company_domain', 'company_domain.domain_id', '=', 'domains.id') // leftJoin here
            ->leftJoin('companies', 'companies.id', '=', 'company_domain.company_id')   // leftJoin here
            ->leftJoin('additional_company_names', 'additional_company_names.company_id', '=', 'companies.id')
            ->groupBy(
                'domains.id',
                'domains.name',
                'domains.status',
                'domains.type',
                'companies.name'
            );
      

            // Apply filters
            if ($request->has('name') && $request->name != '') {
                $query->where('domains.name', 'like', '%'. $request->name. '%');
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('domains.status', $request->status);
            }

            $data = $query->select(
                'domains.id as domain_id',
                'domains.name as name',
                'domains.status',
                'domains.type',
                'companies.name as company_name',
                DB::raw("GROUP_CONCAT(additional_company_names.name SEPARATOR ', ') as additional_names")
            )->get()->toArray();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('company',function($row){
                $html = '<div>';
                if (!empty($row['company_name'])) {
                    $html .= '<p>' . $row['company_name'] . '</p>';
                }
                if (!empty($row['additional_names'])) {
                    $html .= '<p class="text-success">Additional Company Names: ' . $row['additional_names'] . '</p>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('actions', function ($row) {
                return '<div class="d-flex gap-2">                        
                    <a href="'.route('domains.edit',$row['domain_id']).'" class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></a>
                    <form action="'.route('domains.destroy', $row['domain_id']).'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this company?\');">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </div>';
            })
            ->rawColumns(['actions','company'])
            ->make(true);
        }

        // $domainTypes = DomainType::all();
        $domainStatuses = DomainStatus::all();

        return view('admin.domains.index', compact('domainStatuses'));
    } 



    public function publicFreeDomain(Request $request)
    {
        // Return the data as a JSON response for DataTables
        if ($request->ajax()) {
            
            // Fetch all domains from the database with optional filtering
            $query = Domain::query()->where('type', 'not like', '%Private%');

            // Apply filters if provided in the request
            if ($request->has('name') && $request->name != '') {
                $query->where('name', 'like', '%'. $request->name. '%');
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            // if ($request->has('type') && $request->type != '') {
            //     $query->where('type', $request->type);
            // }

            $data = $query->select('id', 'name', 'status', 'type')

             ->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="d-flex gap-2">                        
                    <a href="'.route('domains.edit',$row->id).'" class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></a>
                    <form action="'.route('domains.destroy', $row->id).'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this company?\');">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
        }

        // $domainTypes = DomainType::all();
        $domainStatuses = DomainStatus::all();

        return view('admin.domains.public_free', compact('domainStatuses'));
    } 

    public function getDomains(Request $request)
    {
        $search = $request->input('q');
        $ids = $request->input('ids');

        $query = Domain::query()->where('type', 'not like', '%Public-Free%');

        if ($ids) {
            // Preselected loading
            return $query->whereIn('id', $ids)->pluck('name', 'id');
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        } else {
            $query->latest();
        }

        return $query->pluck('name', 'id');
    }

    public function create()
    {
        $domainTypes = DomainType::all();
        $domainStatuses = DomainStatus::all();

        return view('admin.domains.create', compact('domainTypes','domainStatuses'));
    } 

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:domains,name',
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        if(empty($request->type)){
            $validatedData['type'] = 'Private';
        }
        if(empty($request->status)){
            $validatedData['status'] = 'Primary';
        }



        // Create a new domain record in the database
        $domain = Domain::create($validatedData);

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('Domain created: ' . $domain->name. ', Id:'.$domain->id, 'create', auth()->user()->id);


        // Redirect back with a success message
        return redirect()->route('domains.index')->with('success', 'Domain created successfully.');
    }


    public function edit(Domain $domain)
    {
        $domainTypes = DomainType::all();
        $domainStatuses = DomainStatus::all();
        $domain = Domain::find($domain->id);

        // Show the form for editing the specified domain
        return view('admin.domains.edit', compact('domain','domainTypes','domainStatuses'));
    }


    public function update(Request $request, Domain $domain)
    {
   
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:domains,name,' . $domain->id,
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        if(empty($request->type)){
            $validatedData['type'] = 'Private';
        }
        if(empty($request->status)){
            $validatedData['status'] = 'Primary';
        }
        
        // Update the domain record in the database
        $domain->update($validatedData);

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('Domain updated: ' . $domain->name. ', Id:'.$domain->id, 'update', auth()->user()->id);

        // Redirect back with a success message
        return redirect()->route('domains.index')->with('success', 'Domain updated successfully.');
    }

    public function destroy(Domain $domain)
    {
        // Delete the specified domain record from the database
        $domain->delete();

        //Delete domain form company domain table
        DB::table('company_domain')->where('domain_id', $domain->id)->delete();

        // Log the creation of the domain
        $logController = new LogController();
        $logController->storeLog('Domain deleted: ' . $domain->name. ', Id:'.$domain->id. 'fron domains table and also from company_domain tables ', 'delete', auth()->user()->id);

        // Redirect back with a success message
        return redirect()->route('domains.index')->with('success', 'Domain deleted successfully.');
    }
}
