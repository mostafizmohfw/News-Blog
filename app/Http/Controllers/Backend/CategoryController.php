<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = Category::orderBy('order_by')->get();
        return view('backend.modules.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.modules.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {

       $this->validate($request, [
          'name'=>'required|min:3|max:255',
          'slug'=>'required|min:3|max:255|unique:categories',
          'order_by'=>'required|numeric',
          'status'=>'required',
       ]);

        // foreach ($request->all() as  $category){
            $category_data = $request->all();
            $category_data['slug']= Str::slug($category_data['slug']);
            Category::create($category_data);
        // }

        session()->flash('cls', 'success');
        session()->flash('msg', 'Category Created Successfully');
       return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|View
     */
    public function show(Category $category)
    {
        return view('backend.modules.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        return view('backend.modules.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Category $category
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name'=>'required|min:3|max:255',
            'slug'=>'required|min:3|max:255|unique:categories,slug,'.$category->id,
            'order_by'=>'required|numeric',
            'status'=>'required',
        ]);
        $category_data = $request->all();
        $category_data['slug']= Str::slug($request->input('slug'));
        $category->update($category_data);
        session()->flash('cls', 'success');
        session()->flash('msg', 'Category Updated Successfully');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category  $categroy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('cls', 'error');
        session()->flash('msg', 'Category Deleted Successfully');
        return redirect()->route('category.index');
    }
}
