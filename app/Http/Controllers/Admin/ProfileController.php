<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $default_password   = config('constants.password');
        $user               = User::where('id', Auth::user()->id)->first();

        if (Hash::check($default_password, $user->password))
        {
            $request->session()->flash('warning', __('message.password'));
        }

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
