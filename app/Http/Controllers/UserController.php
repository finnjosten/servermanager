<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function index() {
        return view('pages.account.profile.index');
    }

    public function edit() {
        return view('pages.account.profile.manage', ['mode' => 'edit', 'user' => Auth::user()]);
    }

    public function update(Request $request) {

        $user = Auth::user();

        // Validate the request
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'datalix_token' => 'nullable',
                'cur_password' => 'nullable',
                'new_password' => 'nullable',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'A field did not meet the requirements')->withInput();
        }


        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        /* if (!empty($validated['cur_password']) && !empty($validated['new_password'])) {
            if (Hash::check($validated['cur_password'], $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect')->withInput();
            }
            $user->update([
                'password' => bcrypt($validated['new_password']),
            ]);
        } */

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'datalix_token' => $validated['datalix_token'] ?? $user->datalix_token,
        ]);

        //dd($user);

        return redirect()->route('profile')->with('success', 'Profile has been updated');

    }

    public function trash(User $user) {
        return view('pages.account.profile.manage', ['mode' => 'delete', 'user' => Auth::user()]);
    }

    public function delete() {
        $user = Auth::user();

        $user->delete();
        return redirect()->route('dashboard')->with('success', 'Account has been deleted');
    }

}
