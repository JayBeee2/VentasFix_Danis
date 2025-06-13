<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|string|max:20|unique:users',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verificar manualmente que no contenga @
        if (str_contains($request->email, '@')) {
            return redirect()->back()
                ->withErrors(['email' => 'No incluya el símbolo @ en el nombre de usuario, ya se agrega automáticamente.'])
                ->withInput();
        }
        
        // Verificar que solo contenga caracteres permitidos
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $request->email)) {
            return redirect()->back()
                ->withErrors(['email' => 'El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos.'])
                ->withInput();
        }

        // Construir el email completo con dominio @ventasfix.cl
        $email = $request->email . '@ventasfix.cl';
        
        // Verificar si el email ya existe
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['email' => 'Este correo electrónico ya está en uso.'])
                ->withInput();
        }

        User::create([
            'rut' => $request->rut,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'rut' => 'required|string|max:20|unique:users,rut,'.$id,
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Verificar manualmente que no contenga @
        if (str_contains($request->email, '@')) {
            return redirect()->back()
                ->withErrors(['email' => 'No incluya el símbolo @ en el nombre de usuario, ya se agrega automáticamente.'])
                ->withInput();
        }
        
        // Verificar que solo contenga caracteres permitidos
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $request->email)) {
            return redirect()->back()
                ->withErrors(['email' => 'El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos.'])
                ->withInput();
        }

        // Construir el email completo con dominio @ventasfix.cl
        $email = $request->email . '@ventasfix.cl';
        
        // Verificar si el email ya existe (excluyendo el usuario actual)
        $existingUser = User::where('email', $email)->where('id', '!=', $id)->first();
        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['email' => 'Este correo electrónico ya está en uso.'])
                ->withInput();
        }

        $userData = [
            'rut' => $request->rut,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
