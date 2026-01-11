<?php

namespace App\Http\Controllers;

use App\Models\FichaTecnica;
use App\Models\Inrefinv;
use App\Models\Gecliente;
use App\Models\FichaTecnicaFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FichaTecnicaController extends Controller
{
    /**
     * Muestra una lista de todas las fichas técnicas.
     */
    public function index()
    {
        // Cargamos las fichas con sus relaciones para evitar consultas adicionales (N+1)
        $fichas = FichaTecnica::with(['productoBase', 'cliente'])->get();
        return view('fichas-tecnicas.index', compact('fichas'));
    }

    /**
     * Muestra el formulario para crear una nueva ficha técnica.
     */
    public function create()
    {
        // 1. Obtenemos todos los productos y los ordenamos alfabéticamente.
        // La variable se llama '$productosBase'.
        $productosBase = Inrefinv::orderBy('descr', 'asc')->get();

        // 2. Obtenemos todos los clientes y los ordenamos alfabéticamente.
        // La variable se llama '$clientes'.
        $clientes = Gecliente::orderBy('nombrecli', 'asc')->get();

        // 3. Enviamos AMBAS variables a la vista.
        // 'compact' crea un array: ['productosBase' => $productosBase, 'clientes' => $clientes]
        return view('fichas-tecnicas.create', compact('productosBase', 'clientes'));
    }
    /**
     * Almacena una nueva ficha técnica y sus fotos en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'id_producto_base' => 'required|string|exists:inrefinv,codr',
            'id_cliente' => 'required|string|exists:geclientes,codcli',
            'nombre_ficha' => 'required|string|max:255',
            'adicionales' => 'nullable|string',
            'tiempo_corte' => 'nullable|numeric|min:0',
            'tiempo_confeccion' => 'nullable|numeric|min:0',
            'tiempo_alistamiento' => 'nullable|numeric|min:0',
            'tiempo_remate' => 'nullable|numeric|min:0',
            'fotos' => 'nullable',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120' // Cada foto debe ser una imagen de max 2MB
        ]);

        // Usamos una transacción para asegurar que todo se guarde o nada se guarde
        DB::beginTransaction();
        try {
            // Creamos la ficha técnica
            $fichaTecnica = FichaTecnica::create($request->all());

            // Verificamos si se subieron fotos
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    // Generamos un nombre único para cada archivo
                    $nombreArchivo = Str::uuid() . "." . $foto->extension();

                    // Guardamos la imagen en la carpeta 'public/fotos_fichas'
                    $ruta = $foto->storeAs('fotos_fichas', $nombreArchivo, 'public');

                    // Creamos el registro en la tabla de fotos
                    FichaTecnicaFoto::create([
                        'id_ficha_tecnica' => $fichaTecnica->id,
                        'ruta_imagen' => $ruta,
                    ]);
                }
            }

            // Si todo fue bien, confirmamos la transacción
            DB::commit();
            return redirect()->route('fichas-tecnicas.index')->with('success', 'Ficha técnica creada correctamente.');
        } catch (\Exception $e) {
            // Si algo falla, deshacemos los cambios
            DB::rollBack();
            // En un entorno real, aquí podrías loguear el error $e->getMessage()
            return redirect()->back()->with('error', 'Ocurrió un error al guardar la ficha técnica.')->withInput();
        }
    }

    /**
     * Muestra el formulario para editar una ficha técnica.
     */
    public function edit(string $id)
    {
        $ficha = FichaTecnica::with('fotos')->findOrFail($id);
        $productosBase = Inrefinv::orderBy('descr', 'asc')->get();
        $clientes = Gecliente::orderBy('nombrecli', 'asc')->get();
        return view('fichas-tecnicas.edit', compact('ficha', 'productosBase', 'clientes'));
    }

    /**
     * Actualiza una ficha técnica en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $ficha = FichaTecnica::findOrFail($id);

        $request->validate([
            'id_producto_base' => 'required|string|exists:inrefinv,codr',
            'id_cliente' => 'required|string|exists:geclientes,codcli',
            'nombre_ficha' => 'required|string|max:255',
            'adicionales' => 'nullable|string',
            'tiempo_corte' => 'nullable|numeric|min:0',
            'tiempo_confeccion' => 'nullable|numeric|min:0',
            'tiempo_alistamiento' => 'nullable|numeric|min:0',
            'tiempo_remate' => 'nullable|numeric|min:0',
            'fotos' => 'nullable',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        DB::beginTransaction();
        try {
            // Actualizamos los datos de la ficha
            $ficha->update($request->all());

            // Procesamos nuevas fotos si se han subido
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $nombreArchivo = Str::uuid() . "." . $foto->extension();
                    $ruta = $foto->storeAs('fotos_fichas', $nombreArchivo, 'public');

                    FichaTecnicaFoto::create([
                        'id_ficha_tecnica' => $ficha->id,
                        'ruta_imagen' => $ruta,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('fichas-tecnicas.index')->with('success', 'Ficha técnica actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la ficha técnica.')->withInput();
        }
    }

    /**
     * Elimina una foto específica del servidor y la base de datos.
     */
    public function destroyPhoto(FichaTecnica $ficha, FichaTecnicaFoto $foto)
    {
        // Verificamos que la foto pertenezca a la ficha
        if ($foto->id_ficha_tecnica !== $ficha->id) {
            abort(403, 'Acción no autorizada.');
        }

        // Eliminamos el archivo físico del disco
        if (Storage::disk('public')->exists($foto->ruta_imagen)) {
            Storage::disk('public')->delete($foto->ruta_imagen);
        }

        // Eliminamos el registro de la base de datos
        $foto->delete();

        return back()->with('success', 'Foto eliminada correctamente.');
    }

    /**
     * Elimina una ficha técnica del sistema.
     */
    public function destroy(string $id)
    {
        $ficha = FichaTecnica::findOrFail($id);

        // Obtenemos todas las fotos asociadas para eliminar los archivos
        $fotos = $ficha->fotos;

        DB::beginTransaction();
        try {
            // Eliminamos la ficha técnica. Gracias a 'onDelete cascade', esto eliminará
            // los registros de la tabla 'ficha_tecnica_fotos' automáticamente.
            $ficha->delete();

            // Ahora eliminamos los archivos de imagen del disco
            foreach ($fotos as $foto) {
                if (Storage::disk('public')->exists($foto->ruta_imagen)) {
                    Storage::disk('public')->delete($foto->ruta_imagen);
                }
            }

            DB::commit();
            return redirect()->route('fichas-tecnicas.index')->with('success', 'Ficha técnica eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('fichas-tecnicas.index')->with('error', 'Ocurrió un error al eliminar la ficha técnica.');
        }
    }
}
