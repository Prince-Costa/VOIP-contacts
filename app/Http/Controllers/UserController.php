<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        $companies = Company::all();
        return view('admin.users.index', compact('users','companies'));
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
        $authId = auth()->user()->id;

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)
                            ->mixedCase()
                            ->letters()
                            ->numbers()
                            ->symbols()
                            ->uncompromised()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $request->company_id,
            'role' => $request->role,
            'last_activity' => now(),
            'auth_id' => $authId,
        ]);

        // Log the creation of the user
        $logController = new LogController();
        $logController->storeLog('User created: ' . $user->name . ', ID:' . $user->id, 'create', $authId);

        // Optionally, you can redirect or return a response after creating the user
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $companies = Company::all();
        return view('admin.users.edit', compact('user', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', Password::min(8)
                            ->mixedCase()
                            ->letters()
                            ->numbers()
                            ->symbols()
                            ->uncompromised()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'role' => $request->role,
        ];

        // Only update the password if it is provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Log the update of the user
        $logController = new LogController();
        $logController->storeLog('User updated: ' . $user->name . ', ID:' . $user->id, 'update', auth()->user()->id);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Log the deletion of the user
        $logController = new LogController();
        $logController->storeLog('User deleted: ' . $user->name . ', ID:' . $user->id, 'delete', auth()->user()->id);

        // Optionally, you can redirect or return a response after deleting the user
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
