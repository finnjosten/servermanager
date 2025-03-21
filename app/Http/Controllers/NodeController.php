<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Node;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class NodeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Node $node) {
        if ($node->user_id !== Auth::user()->id) {
            return view('pages.errors.error', [
                'code' => 403,
                'message' => 'This node doesnt exists or is not in control by you'
            ]);
        }
        return view('pages.account.nodes.index', ['node' => $node]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('pages.account.nodes.manage', ['mode' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        // Validate the request
        try {
            $validated = $request->validate([
                'name'          => 'required',
                'ipv4'          => 'required',
                'fqdn'          => 'required',
                'endpoint'      => 'required',
                'key'           => 'required',
                'datalix_id'    => 'nullable',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'A field did not meet the requirements')->withInput();
        }

        if (!str_ends_with($validated['endpoint'], '/')) {
            $validated['endpoint'] .= '/';
        }

        $validated['key'] = Crypt::encrypt($validated['key']);

        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        // Create the item
        $node = Node::create([
            'name'          => $validated['name'],
            'ipv4'          => $validated['ipv4'],
            'fqdn'          => $validated['fqdn'],
            'endpoint'      => $validated['endpoint'],
            'key'           => $validated['key'],
            'datalix_id'    => $validated['datalix_id'] ?? null,
            'user_id'       => Auth::user()->id,
        ]);

        return redirect()->route('dashboard.main')->with('success', 'Node has been added');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Node $node) {
        if ($node->user_id !== Auth::user()->id) {
            return view('pages.errors.error', [
                'code' => 403,
                'message' => 'This node doesnt exists or is not in control by you'
            ]);
        }
        return view('pages.account.nodes.manage', ['mode' => 'edit', 'node' => $node]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Node $node) {

        if ($node->user_id !== Auth::user()->id) {
            return view('pages.errors.error', [
                'code' => 403,
                'message' => 'This node doesnt exists or is not in control by you'
            ]);
        }

        // Validate the request
        try {
            $validated = $request->validate([
                'name'          => 'required',
                'ipv4'          => 'required',
                'fqdn'          => 'required',
                'endpoint'      => 'required',
                'key'           => 'required',
                'datalix_id'    => 'nullable',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'A field did not meet the requirements')->withInput();
        }

        if (!str_ends_with($validated['endpoint'], '/')) {
            $validated['endpoint'] .= '/';
        }

        $validated['key'] = Crypt::encrypt($validated['key']);

        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        // Update the item
        $node->update([
            'name'          => $validated['name'],
            'ipv4'          => $validated['ipv4'],
            'fqdn'          => $validated['fqdn'],
            'endpoint'      => $validated['endpoint'],
            'key'           => $validated['key'],
            'datalix_id'    => $validated['datalix_id'] ?? null,
            'user_id'       => Auth::user()->id,
        ]);

        return redirect()->route('dashboard.node', $node->id)->with('success', 'Node has been updated');

    }

    /**
     * Show the form for removing the specified resource.
     */
    public function trash(Node $node) {
        if ($node->user_id !== Auth::user()->id) {
            return view('pages.errors.error', [
                'code' => 403,
                'message' => 'This node doesnt exists or is not in control by you'
            ]);
        }
        return view('pages.account.nodes.manage', ['mode' => 'delete', 'node' => $node]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Node $node) {

        if ($node->user_id !== Auth::user()->id) {
            return view('pages.errors.error', [
                'code' => 403,
                'message' => 'This node doesnt exists or is not in control by you'
            ]);
        }

        $node->delete();

        return redirect()->route('dashboard.main')->with('success', 'Node has been deleted');

    }
}
