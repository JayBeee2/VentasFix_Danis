<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|string|max:50|unique:products',
            'nombre' => 'required|string|max:255',
            'descripcion_corta' => 'required|string|max:255',
            'descripcion_larga' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio_neto' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_bajo' => 'required|integer|min:0',
            'stock_alto' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        
        // Manejar la carga de la imagen
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Registrar en el log que se ha llamado al método show
            \Log::info('ProductController@show llamado con ID: ' . $id);
            
            $product = Product::findOrFail($id);
            \Log::info('Producto encontrado:', ['id' => $product->id, 'nombre' => $product->nombre]);
            
            // Si la petición es AJAX, devolver JSON
            if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
                \Log::info('Respondiendo con JSON');
                return response()->json($product);
            }
            
            // De lo contrario, devolver la vista
            \Log::info('Respondiendo con vista');
            return view('products.show', compact('product'));
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error en ProductController@show: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku,' . $id,
            'nombre' => 'required|string|max:255',
            'descripcion_corta' => 'required|string|max:255',
            'descripcion_larga' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio_neto' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_bajo' => 'required|integer|min:0',
            'stock_alto' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        
        // Manejar la carga de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($product->imagen) {
                Storage::disk('public')->delete($product->imagen);
            }
            
            $imagePath = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        // Eliminar la imagen si existe
        if ($product->imagen) {
            Storage::disk('public')->delete($product->imagen);
        }
        
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Get product data for AJAX requests.
     * Esta ruta es explícitamente para solicitudes AJAX de productos
     */
    public function getProductData(string $id)
    {
        try {
            \Log::info('ProductController@getProductData llamado con ID: ' . $id);
            
            $product = Product::findOrFail($id);
            
            \Log::info('ProductData: Producto encontrado y enviando respuesta JSON');
            
            return response()->json($product);
        } catch (\Exception $e) {
            \Log::error('Error en ProductController@getProductData: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
