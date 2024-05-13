<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Income_Products;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\ReportServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = Income::with([
            'supplier' => function ($query) {
                $query->select('id', 'name');
            },
            'user' => function ($query) {
                $query->select('id', 'name');
            },
        ])->select('id', 'folio', 'date', 'total_amount', 'total_products', 'total_unitary', 'user_id', 'supplier_id')->get();

        return inertia('Incomes/Index', [
            'incomes' => $incomes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $income = null;
        $suppliers = Supplier::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();
        return inertia('Incomes/Page', [
            'income' => $income,
            'products' => $products,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param integer $income_id
     * @param array $products
     * @return void
     */
    function storeIncomeProduct(int $income_id, array $products) {
        try {

            $code = uniqid('code');
            foreach ($products as $product) {
                $income_product = new Income_Products();
                $income_product->code = $code;
                $income_product->income_id = $income_id;
                $income_product->product_id = $product['id'];
                $income_product->quantity = $product['quantity'];
                $income_product->unitary = $product['unitary'];
                $income_product->total = $product['total'];
                $income_product->save();

                $productTmp = Product::find($product['id']);
                $productTmp->stock = $productTmp->stock + $product['quantity'];
                $productTmp->save();
            }

            return true;
        } catch (\Throwable $th) {
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return false;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'folio' => 'required|string|max:50',
                'date' =>'required|date|before_or_equal:today',
                'total_amount' =>'required|numeric|gt:0',
                'total_products' =>'required|numeric|gt:0',
                'total_unitary' =>'required|numeric|gt:0',
                'supplier_id' => 'required|numeric|gt:0',
                'products' =>'required|array',
                'products.*.id' =>'required|numeric|gt:0',
                'products.*.quantity' =>'required|numeric|gt:0',
                'products.*.unitary' =>'required|numeric|gt:0',
                'products.*.total' =>'required|numeric|gt:0',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $income = new Income();
            $income->folio = $request->folio;
            $income->date = $request->date;
            $income->user_id = Auth::user()->id;
            $income->supplier_id = $request->supplier_id;
            $income->total_amount = $request->total_amount;
            $income->total_products = $request->total_products;
            $income->total_unitary = $request->total_unitary;
            $income->save();

            $result = $this->storeIncomeProduct($income->id, $request->products);

            if (!$result) {
                DB::rollBack();
                return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
            }

            DB::commit();
            return redirect()->route('incomes.index')->with('success', 'Income created successfully.');;

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
        $suppliers = Supplier::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();
        $income = Income::with([
            'income_products' => function ($query) {
                $query->select('income_id', 'product_id as id', 'quantity', 'unitary', 'total');
            }
        ])->where('id', $id)->first();

        foreach ($income->income_products as $product) {
            $product->unitary = floatval($product->unitary);
            $product->total = floatval($product->total);
        }
        $income->total_unitary = floatval($income->total_unitary);

        return inertia('Incomes/Page', [
            'income' => $income,
            'products' => $products,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Undocumented function
     *
     * @param integer $income_id
     * @param array $products
     * @return void
     */
    function updateIncomeProduct(int $income_id, array $products) {
        try {

            foreach ($products as $product) {
                $income_product = Income_Products::where('income_id', $income_id)->first();

                $productTmp = Product::find($product['id']);
                $productTmp->stock = $productTmp->stock - $income_product->quantity;

                $income_product->product_id = $product['id'];
                $income_product->quantity = $product['quantity'];
                $income_product->unitary = $product['unitary'];
                $income_product->total = $product['total'];
                $income_product->save();

                $productTmp->stock = $productTmp->stock + $product['quantity'];
                $productTmp->save();

                return true;
            }
        } catch (\Throwable $th) {
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return false;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'folio' => 'required|string|max:50',
                'date' =>'required|date',
                'total_amount' =>'required|numeric',
                'total_products' =>'required|numeric',
                'total_unitary' =>'required|numeric'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $income = Income::find($id);
            $income->folio = $request->folio ?? $income->folio;
            $income->date = $request->date ?? $income->date;
            $income->supplier_id = $request->supplier_id ?? $income->supplier_id;
            $income->total_amount = $request->total_amount ?? $income->total_amount;
            $income->total_products = $request->total_products ?? $income->total_products;
            $income->total_unitary = $request->total_unitary ?? $income->total_unitary;
            $income->save();

            $result = $this->updateIncomeProduct($income->id, $request->products);

            if (!$result) {
                DB::rollBack();
                return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
            }

            DB::commit();
            return redirect()->route('incomes.index')->with('success', 'Income update successfully.');;

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
            $income = Income::find($id);
            $income->delete();

            DB::commit();
            return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');;
        } catch (\Throwable $th) {
            DB::rollBack();
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
        }
    }
}
