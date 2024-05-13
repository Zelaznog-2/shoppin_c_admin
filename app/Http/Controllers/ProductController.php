<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ReportServices;
use App\Services\UploadServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with([
            'category' => function ($query) {
                return $query->select('id', 'name');
            }
        ])->get();
        return inertia('Products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $product = null;
        return inertia('Products/Page', [
            'categories' => $categories,
            'product' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|max:100|string',
                'sku' => 'required|max:20|string',
                'image' => 'required|file|mimes:jpeg,png,jpg',
                'price' => 'required|numeric',
                'category_id' => 'required|numeric',
                'rating' => 'required|numeric',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $path = UploadServices::saveFile($request, 'image', 'products', 'product', null);

            $product = new Product();
            $product->name = $request->name;
            $product->sku = $request->sku;
            $product->image = $path;
            $product->price = $request->price;
            $product->stock = 0;
            $product->category_id = $request->category_id;
            $product->rating = $request->rating;
            $product->save();

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product created successfully.');;

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
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->get();
        return inertia('Products/Page', [
            'categories' => $categories,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|max:100|string',
                'sku' => 'required|max:20|string',
                'image' => 'nullable|file|mimes:jpeg,png,jpg',
                'price' => 'required|numeric',
                'category_id' => 'required|numeric',
                'rating' => 'required|numeric',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $product = Product::find($id);
            $path = UploadServices::saveFile($request, 'image', 'products', 'product', $product->image);

            $product->name = $request->name;
            $product->sku = $request->sku;
            if ($request->image) {
                $product->image = $path;
            }
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->rating = $request->rating;
            $product->save();

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product update successfully.');;

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
            $product = Product::find($id);
            $product->delete();

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');;
        } catch (\Throwable $th) {
            DB::rollBack();
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
        }
    }
}
