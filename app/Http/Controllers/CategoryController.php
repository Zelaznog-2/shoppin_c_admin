<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ReportServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return inertia('Categories/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = null;
        return inertia('Categories/Page', [
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' =>'required|string|max:50',
                'description' =>'required|string|max:150'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Category created successfully.');;

        } catch (\Throwable $th) {
            DB::rollBack();
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        return inertia('Categories/Page', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' =>'required|string|max:50',
                'description' =>'required|string|max:150'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $category = Category::find($id);
            $category->name = $request->name ?? $category->name;
            $category->description = $request->description ?? $category->description;
            $category->save();

            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Category update successfully.');;

        } catch (\Throwable $th) {
            DB::rollBack();
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $category = Category::find($id);
            $category->delete();

            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');;
        } catch (\Throwable $th) {
            DB::rollBack();
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
        }
    }
}
