<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use App\Models\ContactType;
use Illuminate\Http\Request;
use DataTables;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch all contacts from the database with optional filtering
            $query = Contact::query()->with('company', 'contactType');

            if ($request->has('company_id') && $request->company_id) {
                $query->where('company_id', $request->company_id);
            }

            if ($request->has('contact_type_id') && $request->contact_type_id) {
                $query->where('contact_type_id', $request->contact_type_id);
            }

            if ($request->has('name') && $request->name) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }


            if ($request->has('email') && $request->email) {
                $query->where('email1', 'like', '%' . $request->email . '%')
                      ->orWhere('email2', 'like', '%' . $request->email . '%');
            }

            if ($request->has('phone_number') && $request->phone_number) {
                $query->where('phone_number', 'like', '%' . $request->phone_number . '%');
            }

            $data = $query->orderBy('name', 'asc')->get();

            return DataTables::of($data)
            ->addIndexColumn()
            
            ->addColumn('details', function ($row) {
                return '<div class="text-success">Email1: ' . ($row->email1 ?? '—') . '</div>
                        <div class="text-info">Email2: ' . ($row->email2 ?? '—') . '</div>
                        <div class="text-light">Phone: ' . ($row->phone_number ?? '—') . '</div>';
            })

            ->addColumn('company', function ($row) {
                return ($row->company->name ?? '—');
            })
            
            ->addColumn('contact_type', function ($row) {
                return ($row->contactType->name ?? '—');
            })

            ->addColumn('action', function ($row) {
                return '<div class="d-flex gap-2">
                            <a href="'.route('contacts.show',$row->id).'" class="btn btn-sm btn-success text-white"><i class="fa fa-eye"></i></a>
                            <a href="'.route('contacts.edit',$row->id).'" class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></a>
                            <form action="'.route('contacts.destroy', $row->id).'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this company?\');">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>';
            })
            ->rawColumns(['action','details'])
            ->make(true);
        }

        $companies = Company::all();
        $contactTypes = ContactType::all();

        return view('admin.contacts.index', compact('companies', 'contactTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $contactTypes = ContactType::all();

        return view('admin.contacts.create', compact('companies', 'contactTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // 'email1' => 'required|email|unique:contacts',
            // 'email2' => 'nullable|email|unique:contacts',
            'email1' => 'required|email|unique:contacts,email1|different:email2', 
            'email2' => 'nullable|email|unique:contacts,email2|different:email1',
            'phone_number' => 'nullable|string|max:20',
            'company_id' => 'nullable|integer|exists:companies,id',
            'contact_type_id' => 'nullable|integer|exists:contact_types,id', 
            // 'role' => 'nullable|string|max:50',
        ]);

        
        Contact::create($validatedData);

        // Log the creation of the contact
        $logController = new LogController();
        $logController->storeLog('Contact created: ' . $validatedData['name'], 'create', auth()->user()->id);

        return redirect()->route('contacts.index')->with('success', 'Contact added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::with(['company', 'contactType'])->findOrFail($id);

        if (!$contact) {
            abort(404);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::findOrFail($id);

        if (!$contact) {
            abort(404);
        }
        $companies = Company::all();
        $contactTypes = ContactType::all();

        return view('admin.contacts.edit', compact('contact', 'companies', 'contactTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // 'email1' => 'required|email|unique:contacts,email1,' . $id,
            // 'email2' => 'nullable|email|unique:contacts,email2,' . $id,
            'email1' => 'required|email|unique:contacts,email1,' . $id . ',id|different:email2',
            'email2' => 'nullable|email|unique:contacts,email2,' . $id . ',id|different:email1',
            'phone_number' => 'nullable|string|max:20',
            'company_id' => 'nullable|integer|exists:companies,id',
            'contact_type_id' => 'nullable|integer|exists:contact_types,id', 
            // 'role' => 'nullable|string|max:50',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($validatedData);

        // Log the update of the contact
        $logController = new LogController();
        $logController->storeLog('Contact updated: ' . $validatedData['name'], 'update', auth()->user()->id);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        if (!$contact) {
            abort(404);
        }
        
        $contact->delete();

        // Log the deletion of the contact
        $logController = new LogController();
        $logController->storeLog('Contact deleted: ' . $contact->name . ', ID: ' . $contact->id , 'delete', auth()->user()->id);

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
