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
        $user->first_name  = $request['first_name'];
        $user->last_name   = $request['last_name'];
        $user->middle_name = $request['middle_name'];
        $user->birthday    = $request['birthday'];
        $user->address     = $request['address'];
        $user->phone       = $request['phone'];
        $user->email       = $request['email'];
        $user->activity    = $request['activity'];

        if (!is_null($request['password'])) {
            $user->password = bcrypt($request['password']);
        }

        $user->save();

        $request->session()->flash('success', __('crud.update_data'));
        return redirect()->route('admin.profile.index');
    }
}
