<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\ResponseServices;
use App\Services\ReportServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * A function that allows you to authenticate a user through an API.
     *
     * @param Request request The request object.
     *
     * @return The access token and the user data
     */
    public function authenticateApi(Request $request)
    {
        $validate = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        try {
            if ($validate) {
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    $data = $this->getToken($request);
                    return ResponseServices::responseSuccess('Ingresaste exitosamente', $data);
                } else {
                    return ResponseServices::responseFailed(['email' => trans('auth.failed')]);
                }
            }
        } catch (\Throwable $th) {
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return ResponseServices::responseError();
        }
    }

    public function authenticateIdApi(Request $request)
    {
        $validate = $request->validate([
            'user_id' => ['required', 'numeric'],
        ]);
        try {
            if ($validate) {
                $credentials = $request->user_id;
                if (Auth::loginUsingId($credentials)) {
                    $data = $this->getToken($request);
                    return ResponseServices::responseSuccess('Ingresaste exitosamente', $data);
                } else{
                    return ResponseServices::responseErrorToken();
                }
            }
        } catch (\Throwable $th) {
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return ResponseServices::responseError();
        }
    }


    function deleteTokenOld() {
        try {
            $countToken = DB::table('personal_access_tokens')
            ->where('tokenable_id', Auth::id())
            ->get()->count();
            if ($countToken > 10) {
                DB::beginTransaction();
                DB::table('personal_access_tokens')
                    ->where('tokenable_id', Auth::id())
                    ->delete();
                    DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return ResponseServices::responseError();
        }
    }

    private function getToken($request) : array
    {
        $this->deleteTokenOld();
        $user = User::where('id', Auth::id())->first();
        $tokenResult = $request->user()->createToken('Token de usuario');

        return [
            'accessToken' => $user ? $tokenResult->plainTextToken : null,
            'tokenType'   => $user ? 'Bearer' : null,
            'id'          => $user ? $user->id : null,
        ];
    }

    public function me()
    {
        try {
            if (Auth::check()) {
                $user = User::where('id', Auth::id())->select('id', 'name', 'email', 'phone')->first();
                return ResponseServices::responseSuccess('Usuario', $user);
            } else {
                return ResponseServices::responseNotAuthorize();
            }
        } catch (\Throwable $th) {
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return ResponseServices::responseError();
        }
    }

    /**
     * It logs out the user.
     *
     * @param Request request The incoming request.
     */
    function logoutApi(Request $request)
    {
        try {
            $this->deleteTokenOld();
            Auth::guard('web')->logout();
            return ResponseServices::responseSuccess('logout', true);
        } catch (\Throwable $th) {
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return ResponseServices::responseError();
        }

    }
}
