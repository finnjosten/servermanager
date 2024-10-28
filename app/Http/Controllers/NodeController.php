<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Node;

class NodeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('pages.account.node-edit', ['mode' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        // Validate the request
        try {
            $validated = $request->validate([
                'name' => 'required',
                'address' => 'required',
                'ssh_user' => 'required',
                'ssh_key' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'A field did not meet the requirements')->withInput();
        }

        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        // Create the item
        $node = Node::create([
            'name' =>  $validated['name'],
            'address' =>  $validated['address'],
            'ssh_user' =>  $validated['ssh_user'],
            'ssh_key' =>  $validated['ssh_key'],
        ]);

        return redirect()->route('dashboard.main')->with('success', 'Node has been added');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Node $node) {
        return view('pages.account.node-edit', ['mode' => 'edit', 'node' => $node]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Node $node) {

        // Validate the request
        try {
            $validated = $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'category' => 'required',
                'content' => 'required',
                'excerpt' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'A field did not meet the requirements')->withInput();
        }

        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        // Update the item
        $node->update([
            'title' => $validated['title'],
            'slug' => vlx_slugify($validated['slug']),
            'category_id' => $validated['category'],
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Node has been updated');

    }

    /**
     * Show the form for removing the specified resource.
     */
    public function trash(Node $node) {
        return view('pages.account.node-edit', ['mode' => 'delete', 'node' => $node]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Node $node) {

        $node->clearMediaCollection('media');
        $node->delete();

        return redirect()->route('dashboard')->with('success', 'Node has been deleted');

    }
}
