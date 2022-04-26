<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();

        return view('admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.categories.form');
    }

    public function store(Request $request)
    {
        Category::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('admin.pages.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.categories.index');
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.categories.index');
    }
}
