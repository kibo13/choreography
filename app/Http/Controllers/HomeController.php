<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function admin()
    {
        return view('admin.pages.home.index');
    }

    public function users()
    {
        return view('admin.pages.users.index');
    }
}
