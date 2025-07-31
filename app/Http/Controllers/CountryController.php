<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        // Fetch all countries from the database
        $countries = Country::orderBy('name', 'asc')->get();
        $regions = Region::orderBy('name', 'asc')->get();
        return view('admin.countries.index', compact('countries','regions'));
    }




    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'iso_code' => 'required|string',
            'country_code' => 'nullable',
            'world_region' => 'nullable',
        ]);
        // store the country data

        $country = Country::create($validatedData);

        // Log the creation of the Country
        $logController = new LogController();
        $logController->storeLog('Country created: ' . $country->name. ', Id:'.$country->id, 'create', auth()->user()->id);

        // Redirect or return a response
        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }  
    
    
    public function edit($id)
    {
        $country = Country::findOrFail($id);
        $regions = Region::orderBy('name', 'asc')->get();
        
        return view('admin.countries.edit', ['country' => $country, 'regions' => $regions]);
    }


    public function update(Request $request, $id)
    {
        // Validate and update the country data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'iso_code' => 'required|string',
            'country_code' => 'nullable',
            'world_region' => 'nullable',
        ]);

        $country = Country::findOrFail($id);
        $country->update($validatedData);

        // Log the creation of the Country
        $logController = new LogController();
        $logController->storeLog('Country updated: ' . $country->name. ', Id:'.$country->id, 'update', auth()->user()->id);

        // Redirect or return a response
        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }


    public function destroy($id)
    {
        // Delete the country
        $country = Country::findOrFail($id);
        $country->delete();

        // Log the creation of the Country
        $logController = new LogController();
        $logController->storeLog('Country deleted: ' . $country->name. ', Id:'.$country->id, 'delete', auth()->user()->id);

        // Redirect or return a response
        return redirect()->route('countries.index')->with('success', 'Contact Type deleted successfully.');
    }
}
