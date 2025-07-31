<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use DataTables;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $logs = Log::latest();
            return DataTables::of($logs)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return '<div class="text-primary">' . ($row->user->name ?? '—') . '</div>';
                })
                // ->addColumn('action', function ($log) {
                //     return '<form action="/logs/' . $log->id . '" method="POST" style="display:inline;">
                //                 ' . csrf_field() . '
                //                 ' . method_field('DELETE') . '
                //                 <button type="submit" class="btn btn-sm btn-danger d-none" onclick="return confirm(\'Are you sure?\')" disabled>Delete</button>
                //             </form>';
                // })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->rawColumns(['user'])
                ->make(true);
        }

        return view('admin.logs.index');
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

    }

    public function storeLog($description, $action, $user_id)
    {
        // Store the log in the database
        Log::create([
            'description' => $description,
            'action' => $action,
            'user_id' => $user_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Log stored successfully',
        ]);
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
    public function destroy(string $id)
    {
        $log = Log::findOrFail($id);
        if (!$log) {
            abort(404);
        }
        $log->delete();

        // Flash message for success
        session()->flash('success', 'Log deleted successfully.');

        return redirect()->route('logs.index');
    }
}
