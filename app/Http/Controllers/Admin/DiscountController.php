<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::where('size', '>', 0)->get();

        return view('admin.pages.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.pages.discounts.form');
    }

    public function store(Request $request)
    {
        Discount::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.discounts.index');
    }

    public function show(Discount $discount)
    {
        //
    }

    public function edit(Discount $discount)
    {
        return view('admin.pages.discounts.form', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $discount->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.discounts.index');
    }

    public function destroy(Request $request, Discount $discount)
    {
        $discount->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.discounts.index');
    }
}
