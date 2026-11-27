<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request, RateLimiter $limiter)
    {
        $request->merge([
            'email' => $request->input('email', $request->input('correo')),
            'password' => $request->input('password', $request->input('contrasena')),
        ]);
        $request->request->remove('contrasena');
        try {
            $datos = $request->validate([
                'email' => ['required', 'email:rfc', 'max:150'],
                'password' => ['required', 'string'],
            ]);
        } catch (ValidationException $exception) {
            $response = back()
                ->withErrors($exception->errors())
                ->withInput($request->only(['email', 'correo']));

            return $request->routeIs('auth.login.store')
                ? $response->with('abrir_modal', 'login')
                : $response;
        }

        $key = mb_strtolower($datos['email']).'|'.$request->ip();
        if ($limiter->tooManyAttempts($key, 5)) {
            $response = back()
                ->withErrors(['login' => 'Has realizado varios intentos. Espera un momento e inténtalo de nuevo.'])
                ->withInput(['email' => $datos['email'], 'correo' => $datos['email']]);

            return $request->routeIs('auth.login.store')
                ? $response->with('abrir_modal', 'login')
                : $response;
        }

        $credentials = [
            'correo' => $datos['email'],
            'password' => $datos['password'],
            'esta_activo' => true,
        ];

        if (! Auth::attempt($credentials, $request->boolean('recordar'))) {
            $limiter->hit($key, 60);

            $response = back()
                ->withErrors(['login' => 'El correo o la contraseña son incorrectos.'])
                ->withInput(['email' => $datos['email'], 'correo' => $datos['email']]);

            return $request->routeIs('auth.login.store')
                ? $response->with('abrir_modal', 'login')
                : $response;
        }

        $limiter->clear($key);
        $request->session()->regenerate();

        return redirect()
            ->intended(route('store.index'))
            ->with('success', '¡Bienvenido a Deluxe Store!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('store.index')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}
