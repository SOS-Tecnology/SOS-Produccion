<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satelite;
use App\Models\Proveedor;

class SateliteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Obtenemos todos los satélites de la BD usando el Modelo
        // $satelites = Satelite::all();

        // Usamos with() para cargar la relación 'proveedor' de forma anticipada
        $satelites = Satelite::with('proveedor')->get();

        return view('satelites.index', compact('satelites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Eliminamos cualquier mensaje de éxito previo
        session()->forget('success');

        // 1. Obtenemos todos los proveedores de la BD
        $proveedores = Proveedor::orderBy('nombre', 'asc')->get();

        // 2. Devolvemos la vista y le pasamos la lista de proveedores
        return view('satelites.create', compact('proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Obtenemos todos los datos del formulario
        $datos = $request->all();

        // 2. Creamos un nuevo satélite en la BD usando el Modelo
        Satelite::create($datos);

        // 3. Redirigimos al usuario a la lista de satélites
        return redirect()->route('satelites.index');
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
        // Eliminamos cualquier mensaje de éxito previo
        session()->forget('success');
        // 1. Buscamos el satélite por su ID. Si no lo encuentra, da un error 404.
        $satelite = Satelite::findOrFail($id);

        // 2. Obtenemos todos los proveedores para el desplegable
        $proveedores = Proveedor::orderBy('nombre', 'asc')->get();

        // 3. Devolvemos la vista, pasando el satélite encontrado y los proveedores
        return view('satelites.edit', compact('satelite', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Eliminamos cualquier mensaje de éxito previo (nuestra red de seguridad)
        session()->forget('success');
        // 1. Obtenemos todos los datos del formulario
        $datos = $request->all();

        // 2. Buscamos el satélite por su ID
        $satelite = Satelite::findOrFail($id);

        // 3. Actualizamos el satélite en la BD con los nuevos datos
        $satelite->update($datos);

        // 4. Redirigimos a la lista de satélites con un mensaje de éxito
        return redirect()->route('satelites.index')->with('success', 'Satélite actualizado correctamente.');

        // X. Devolvemos una respuesta JSON con el mensaje y la URL de redirección
        // return response()->json([
        //     'message' => 'Satélite actualizado correctamente.',
        //     'redirect' => route('satelites.index')
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $satelite = Satelite::findOrFail($id);

        // --- INICIO DE LA VERIFICACIÓN DE INTEGRIDAD ---
        // TODO: Cuando se cree la tabla de 'ordenes_produccion' (o similar),
        // descomentar y ajustar el siguiente código para evitar eliminar satélites con tareas.
        //
        // if ($satelite->ordenesProduccion()->count() > 0) {
        //     return redirect()->route('satelites.index')
        //         ->with('error', 'No se puede eliminar el satélite porque tiene órdenes de producción asociadas.');
        // }
        // --- FIN DE LA VERIFICACIÓN ---

        $satelite->delete();

        return redirect()->route('satelites.index')
            ->with('success', 'Satélite eliminado correctamente.');
    }

}
