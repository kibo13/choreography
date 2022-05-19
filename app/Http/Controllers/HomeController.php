<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function admin()
    {
        $is_director = Auth::user()->role_id == 3 ? 1 : null;

        return view('admin.pages.home.index', compact('is_director'));
    }
}
