<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();

        return view('admin.pages.profile.form', compact('user'));
    }

    public function update(ProfileRequest $request, User $user)
    {
        if (!is_null($request['password'])) {
            $user->password = bcrypt($request['password']);
        }

        $user->save();

        $request->session()->flash('success', __('data.updated'));
        return redirect()->route('admin.profile.index');
    }
}
