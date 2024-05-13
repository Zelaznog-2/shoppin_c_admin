<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Services\ReportServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'folio' =>'required|string:max:50',
                'date' =>'required|date',
                'quantity_products' =>'required|numeric',
                'total' =>'required|numeric',
                'tax' =>'required|numeric',
                'states' =>'required|string:max:30',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $sale = new Sale();
            $sale->folio = $request->folio;
            $sale->date = $request->date;
            $sale->quantity_products = $request->quantity_products;
            $sale->total = $request->total;
            $sale->tax = $request->tax;
            $sale->states = $request->states;
            $sale->save();

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'folio' =>'required|string:max:50',
                'date' =>'required|date',
                'quantity_products' =>'required|numeric',
                'total' =>'required|numeric',
                'tax' =>'required|numeric',
                'states' =>'required|string:max:30',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $sale = Sale::find($id);
            $sale->folio = $request->folio ?? $sale->folio;
            $sale->date = $request->date ?? $sale->date;
            $sale->quantity_products = $request->quantity_products ?? $sale->quantity_products;
            $sale->total = $request->total ?? $sale->total;
            $sale->tax = $request->tax ?? $sale->tax;
            $sale->states = $request->states ?? $sale->states;
            $sale->save();

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sale update successfully.');
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

            $sale = Sale::find($id);
            $sale->delete();

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
        }
    }
}
