<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $keyword = $request->keyword;
        if ($keyword) {
            $categories = Category::where("name", "LIKE", "%$keyword%")->paginate(10);
        } else {
            $categories = Category::paginate(10);
        }
        return view("categories.index", ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        $new_category = new Category;
        $new_category->name = $name;


        if ($request->image) {
            $file = $request->image->store("categories", "public");
            $new_category->image = $file;
        }
        $new_category->slug = Str::slug($name, '-');
        $new_category->created_by = Auth::id();
        $new_category->save();
        return redirect("categories/create")->with("status", "Category Has Been Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category = Category::findOrFail($id);
        return view("categories.detail", ["category" => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view("categories.edit", ["category" => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->name;
        $slug = $request->slug;

        $category = Category::findOrFail($id);

        $category->name = $name;
        $category->slug = $slug;


        if ($request->image) {
            if ($category->image && file_exists(storage_path('app/public/' . $category->image))) {
                Storage::delete('public/' . $category->image);
            }
            $file = $request->image->store("categories", "public");
            $category->image = $file;
        }

        $category->updated_by = Auth::id();
        $category->slug = Str::slug($name);
        $category->save();

        return redirect()->route('categories.edit', [$id])->with("status", "Category has been changed");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect("categories")->with("status", "Category has been moved to trash");
    }
    public function trash(Request $request)
    {
        $keyword = $request->keyword;
        if ($keyword) {
            $categories = Category::onlyTrashed()->where("name", "LIKE", "%$keyword%")->paginate(10);
        } else {
            $categories = Category::onlyTrashed()->paginate(10);
        }
        return view("categories.trash", ['categories' => $categories]);
    }
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        if ($category->trashed()) {
            $category->restore();
        } else {
            return redirect()->route('categories.index')->with('status', 'Category is not in trash');
        }
        return redirect()->route('categories.index')->with('status', 'Category has been restored');
    }

    public function permanentDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        if (!$category->trashed()) {
            return redirect()->route('categories.index')
                ->with('status', 'Can not delete permanent active category');
        } else {
            $category->forceDelete();
            return redirect()->route('categories.index')
            ->with('status', 'Category permanently deleted');
        }
    }
}
