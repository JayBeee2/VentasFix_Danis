<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\LogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de registro
     */
    public function showRegisterForm()
    {
        LogHelper::info('Mostrando formulario de registro');
        return view('auth.register');
    }

    /**
     * Manejar el registro de un nuevo usuario
     */
    public function register(Request $request)
    {
        try {
            LogHelper::info('Iniciando proceso de registro', ['datos' => $request->except('password')]);

            // Validación de datos
            $validator = Validator::make($request->all(), [
                'rut' => 'required|string|max:12|unique:users',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'terms' => 'required',
            ]);

            if ($validator->fails()) {
                LogHelper::warning('Validación fallida en registro', ['errores' => $validator->errors()->toArray()]);
                return redirect('/register')
                    ->withErrors($validator)
                    ->withInput();
            }

            // Verificar manualmente que no contenga @
            if (str_contains($request->email, '@')) {
                LogHelper::warning('Usuario intentó ingresar @ en el campo de email', ['email' => $request->email]);
                return redirect('/register')
                    ->withErrors(['email' => 'No incluya el símbolo @ en el nombre de usuario, ya se agrega automáticamente.'])
                    ->withInput();
            }
            
            // Verificar que solo contenga caracteres permitidos
            if (!preg_match('/^[a-zA-Z0-9._-]+$/', $request->email)) {
                LogHelper::warning('Usuario ingresó caracteres no permitidos en el email', ['email' => $request->email]);
                return redirect('/register')
                    ->withErrors(['email' => 'El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos.'])
                    ->withInput();
            }

            // Construir el email completo con dominio @ventasfix.cl
            $email = $request->email . '@ventasfix.cl';
            
            // Verificar si el email ya existe
            $existingUser = User::where('email', $email)->first();
            if ($existingUser) {
                LogHelper::warning('Intento de registro con email existente', ['email' => $email]);
                return redirect('/register')
                    ->withErrors(['email' => 'Este correo electrónico ya está en uso.'])
                    ->withInput();
            }

            // Crear el usuario
            $user = User::create([
                'rut' => $request->rut,
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $email,
                'password' => Hash::make($request->password),
            ]);

            LogHelper::info('Usuario registrado exitosamente', ['user_id' => $user->id, 'email' => $user->email]);


            // Redirigir a login con mensaje de éxito
            return redirect('/login')->with('success', 'Usuario registrado correctamente. Por favor inicia sesión.');
        } catch (Exception $e) {
            LogHelper::exception($e);
            return redirect('/register')
                ->with('error', 'Ha ocurrido un error al procesar el registro. Por favor, inténtalo nuevamente.')
                ->withInput();
        }
    }

    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        LogHelper::info('Mostrando formulario de login');
        return view('auth.login');
    }

    /**
     * Manejar el inicio de sesión
     */
    public function login(Request $request)
    {
        try {
            LogHelper::info('Iniciando proceso de login', ['email' => $request->email]);

            $credentials = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            // Verificar si el email incluye el dominio, si no, agregarlo
            if (!str_contains($credentials['email'], '@')) {
                $credentials['email'] = $credentials['email'] . '@ventasfix.cl';
                LogHelper::info('Email complementado con dominio', ['email_final' => $credentials['email']]);
            }
            // Si ya tiene @ pero no es @ventasfix.cl, es posible que sea un error
            else if (!str_ends_with($credentials['email'], '@ventasfix.cl')) {
                if (str_ends_with($credentials['email'], 'ventasfix.cl')) {
                    // Falta el @, corregirlo
                    $credentials['email'] = str_replace('ventasfix.cl', '@ventasfix.cl', $credentials['email']);
                } else {
                    // Reemplazar cualquier dominio con @ventasfix.cl
                    $parts = explode('@', $credentials['email']);
                    $credentials['email'] = $parts[0] . '@ventasfix.cl';
                }
                LogHelper::info('Email corregido', ['email_final' => $credentials['email']]);
            }

            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();
                LogHelper::info('Login exitoso', ['user_id' => Auth::id()]);
                return redirect()->route('home')->with('success', '¡Bienvenido/a de nuevo a VentasFix!');
            }

            LogHelper::warning('Intento de login fallido', ['email' => $credentials['email']]);
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->withInput();
        } catch (Exception $e) {
            LogHelper::exception($e);
            return back()->withErrors([
                'general' => 'Ha ocurrido un error al procesar el inicio de sesión. Por favor, inténtalo nuevamente.',
            ])->withInput();
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        $userId = Auth::id();
        LogHelper::info('Usuario cerrando sesión', ['user_id' => $userId]);
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
