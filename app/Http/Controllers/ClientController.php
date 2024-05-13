<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ReportServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role_id', 3)->get();
        return inertia('Clients/Index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = null;
        return inertia('Clients/Page', [
            'user' => $user
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
                'email' =>'required|string|email|max:100|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' =>'required|string|max:15',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->role_id = 3;
            $user->save();

            DB::commit();
            return redirect()->route('clients.index')->with('success', 'Client created successfully.');;

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
        $user = User::find($id);
        return inertia('Clients/Page', [
            'user' => $user
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
                'email' =>'required|string|email|max:100',
                'phone' =>'required|string|max:15',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $checkEmail = User::where('email', '=', $request->email)->where('id', '!=', $id)->first();
            if ($checkEmail) {
                return redirect()->back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
            }

            DB::beginTransaction();

            $user = User::find($id);
            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            if ($request->password) {
                $user->password =  Hash::make($request->password);
            }
            $user->save();

            DB::commit();
            return redirect()->route('clients.index')->with('success', 'Client updated successfully.');;

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
            $user = User::find($id);
            $user->delete();

            DB::commit();
            return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');;
        } catch (\Throwable $th) {
            DB::rollBack();
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error']);
        }
    }
}
