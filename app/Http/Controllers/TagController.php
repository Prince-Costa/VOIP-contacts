<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all tags from the database
        $tags = Tag::orderBy('name', 'asc')->get();

        // Return the view with the tags data
        return view('admin.tags.index', compact('tags'));
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'background_color' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/|unique:tags,background_color',
        ]);

        // Create a new tag
        $tag = Tag::create($request->all());

        // Log the creation of the tag
        $logController = new LogController();
        $logController->storeLog('Tag created: ' . $tag->name. ', Id:'.$tag->id, 'create', auth()->user()->id);

        // Redirect back with success message
        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the tag by ID
        $tag = Tag::findOrFail($id);

        // Return the edit view with the tag data
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
            'background_color' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/|unique:tags,background_color,' . $id,
        ]);

        // Find the tag by ID and update it
        $tag = Tag::findOrFail($id);
        $tag->update($request->all());

        // Log the creation of the tag
        $logController = new LogController();
        $logController->storeLog('Tag updated: ' . $tag->name. ', Id:'.$tag->id, 'update', auth()->user()->id);

        // Redirect back with success message
        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the tag by ID and delete it
        $tag = Tag::findOrFail($id);
        $tag->delete();

        // Log the creation of the tag
        $logController = new LogController();
        $logController->storeLog('Tag deleted: ' . $tag->name. ', Id:'.$tag->id, 'delete', auth()->user()->id);

        // Redirect back with success message
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }
}
