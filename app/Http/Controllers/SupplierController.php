<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Services\ReportServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return inertia('Suppliers/Index', [
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = null;
        return inertia('Suppliers/Page', [
           'supplier' => $supplier,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'phone' =>'required|string|max:15',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->phone = $request->phone;
            $supplier->save();

            DB::commit();
            return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
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
        $supplier = Supplier::find($id);
        return inertia('Suppliers/Page', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'phone' =>'required|string|max:15',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $supplier = Supplier::find($id);
            $supplier->name = $request->name ?? $supplier->name;
            $supplier->phone = $request->phone ?? $supplier->phone;
            $supplier->save();

            DB::commit();
            return redirect()->route('suppliers.index')->with('success', 'Supplier update successfully.');
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

            $supplier = Supplier::find($id);
            $supplier->delete();

            DB::commit();
            return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
        }
    }
}
