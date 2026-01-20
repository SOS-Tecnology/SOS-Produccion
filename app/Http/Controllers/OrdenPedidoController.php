<?php

namespace App\Http\Controllers;

use App\Models\Cabezamov;
use App\Models\Cuerpomov;
use App\Models\Gecliente;
use App\Models\Geclientesaux;
use App\Models\Inrefinv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrdenPedidoController extends Controller // Asegúrate de que esté extendiendo la clase Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenes = Cabezamov::ordenesPedido()
            ->with('cliente')
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('ordenes-pedido.index', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Gecliente::all();
        // $productos = Inrefinv::all();
        // Ahora
        // $productos = Inrefinv::where('tipoprod', 'V')->where('prototipo', 1)->get()->toArray();
        $productos = DB::select("SELECT codr, descr FROM inrefinv WHERE tipoprod = 'V' AND prototipo = 1");
        // Generar un número de documento único para la orden de pedido
        $ultimoDocumento = Cabezamov::ordenesPedido()
            ->orderByRaw('CAST(documento AS UNSIGNED) DESC')
            ->value('documento');

        $nuevoDocumento = str_pad((int)($ultimoDocumento ?? 0) + 1, 8, '0', STR_PAD_LEFT);
        // Añadir estas líneas en el método create()
        $colores = collect([
            ['codcolor' => 'BLA', 'nombrecolor' => 'Blanco'],
            ['codcolor' => 'NEG', 'nombrecolor' => 'Negro'],
            ['codcolor' => 'AZU', 'nombrecolor' => 'Azul'],
            ['codcolor' => 'ROJ', 'nombrecolor' => 'Rojo'],
            ['codcolor' => 'VER', 'nombrecolor' => 'Verde'],
        ]);

        $tallas = collect([
            ['codtalla' => 'XS', 'nombretalla' => 'Extra Small'],
            ['codtalla' => 'S', 'nombretalla' => 'Small'],
            ['codtalla' => 'M', 'nombretalla' => 'Medium'],
            ['codtalla' => 'L', 'nombretalla' => 'Large'],
            ['codtalla' => 'XL', 'nombretalla' => 'Extra Large'],
            ['codtalla' => 'XXL', 'nombretalla' => '2X Large'],
        ]);

        // ESTA LÍNEA ES LA CLAVE. SOLO PASA ESTAS 3 VARIABLES.
        // Antes
        // return view('ordenes-pedido.create', compact('clientes', 'productos', 'nuevoDocumento'));

        // Ahora
        return view('ordenes-pedido.create', compact('clientes', 'productos', 'nuevoDocumento', 'colores', 'tallas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // --- INICIO DE DEPURACIÓN FORZADA ---
        // $logFile = fopen(storage_path('debug_store.log'), 'a');
        // fwrite($logFile, date('Y-m-d H:i:s') . " - Iniciando método store()\n");
        // --- FIN DE DEPURACIÓN FORZADA ---

        // Limpiar códigos de producto
        $productos = $request->input('productos', []);
        foreach ($productos as $key => $producto) {
            if (isset($producto['codr'])) {
                $productos[$key]['codr'] = trim($producto['codr']);
            }
        }
        $request->merge(['productos' => $productos]);
        // --- DEPURACIÓN CLAVE ---
        Log::info('Datos recibidos en el store:', $request->all());
        // ------------------------
        $request->validate([
            'documento' => 'required|string|max:8',
            'codcp' => 'required|exists:geclientes,codcli',
            'codsuc' => 'nullable|exists:geclientesaux,codsuc',
            'fecha' => 'required|date',
            'fechent' => 'required|date|after_or_equal:fecha',
            'comen' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.codr' => 'required|exists:inrefinv,codr',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.valor' => 'required|numeric|min:0',
            'productos.*.codcolor' => 'nullable|string',
            'productos.*.codtalla' => 'nullable|string',
            'productos.*.comencpo' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();
            // fwrite($logFile, date('Y-m-d H:i:s') . " - Transacción iniciada.\n");

            // Calcular totales
            $subtotal = 0;
            foreach ($request->productos as $producto) {
                $subtotal += $producto['cantidad'] * $producto['valor'];
            }

            $iva = $subtotal * 0.16;
            $total = $subtotal + $iva;

            // Crear el encabezado de la orden de pedido
            $cabecera = Cabezamov::create([
                'documento' => $request->documento,
                'prefijo' => 'OP',
                'tm' => 'OP',
                'codcp' => $request->codcp,
                'codsuc' => $request->codsuc ?? '',
                'fecha' => $request->fecha,
                'fechent' => $request->fechent,
                'comen' => $request->comen,
                'valortotal' => $total,
                'vriva' => $iva,
                'descuento' => 0,
                'estado' => 'P',
                'usuario' => Auth::user()->name,
                'fechacrea' => now()->format('Y-m-d'),
                'horacrea' => now()->format('H:i')
            ]);
            // fwrite($logFile, date('Y-m-d H:i:s') . " - Cabecera creada.\n");

            // Crear los detalles de la orden
            foreach ($request->productos as $index => $producto) {
                $productoInfo = DB::table('inrefinv')->where('codr', $producto['codr'])->first();

                Cuerpomov::create([
                    'documento' => $request->documento,
                    'prefijo' => 'OP',
                    'tm' => 'OP',
                    'codr' => $producto['codr'],
                    'descr' => $productoInfo->descr,
                    'cantidad' => $producto['cantidad'],
                    'valor' => $producto['valor'],
                    'unidad' => $productoInfo->unid,
                    'codcolor' => $producto['codcolor'] ?? '',
                    'codtalla' => $producto['codtalla'] ?? '',
                    'comencpo' => $producto['comencpo'] ?? '',
                    'numreg' => str_pad($index + 1, 3, '0', STR_PAD_LEFT)
                ]);
            }

            DB::commit();

            return redirect()->route('ordenes-pedido.index')
                ->with('success', 'Orden de pedido creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            // --- CAPTURA EL ERROR ESPECÍFICO ---
            // --- CAPTURA DEL ERROR ---
            Log::error('ERROR al guardar la orden de pedido:', $e->getMessage());
            Log::error('Traza del error:', $e->getTraceAsString());
            // -----------------------------

            return back()->withInput()
                ->with('error', 'Error al crear la orden de pedido: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    /*
    public function showX0($documento)
    {
        $orden = Cabezamov::ordenesPedido()
            ->where('documento', (string) $documento) // <-- FORZAR A STRING
            ->with(['cliente', 'sucursal', 'detalles.producto'])
            ->firstOrFail();
        return view('ordenes-pedido.show', compact('orden'));
    }
*/
    /*
    public function showX1($documento)
    {
        try {
            // 1. Cargar la orden principal sin relaciones
            $orden = Cabezamov::ordenesPedido()
                ->where('documento', (string) $documento)
                ->firstOrFail();

            // 2. Cargar las relaciones de primer nivel (cliente, sucursal)
            $orden->load('cliente', 'sucursal');

            // 3. Cargar los detalles (Cuerpomov)
            $detalles = $orden->detalles;

            // 4. Cargar la relación anidada (producto) para cada detalle
            foreach ($detalles as $detalle) {
                $detalle->load('producto');
            }

            // 5. (Opcional) Si necesitas la relación inversa, puedes cargarla así:
            // $orden->load('cliente.cabzamovs');

            return view('ordenes-pedido.show', compact('orden'));

        } catch (\Exception $e) {
            // Captura cualquier error y muéstralo en pantalla
            // dd($e->getMessage());
            // O muestra un error más amigable al usuario
            return back()->with('error', 'Error al cargar la orden: ' . $e->getMessage());
        }
    }

    */
    public function show($documento)
    {
        try {
            // dd($documento);

            $orden = Cabezamov::with(['cliente', 'sucursal', 'detalles'])
                ->where('cabezamov.documento', (string) $documento)
                ->firstOrFail();

            dd( DB::table('cuerpomov') ->where('documento', '00000005') ->pluck('tm','prefijo') );

            // dd(['cliente' => $orden->cliente, 'sucursal' => $orden->sucursal, 'detalles' => $orden->detalles->toArray(),]);
            // Cargar las relaciones de forma manual y segura
            $detalles = $orden->detalles;

            // Cargar la relación anidada para cada detalle
            foreach ($detalles as $detalle) {
                try {
                    $detalle->load('producto');
                } catch (\Exception $e) {
                    // Si un detalle no tiene un producto asociado, lo registraremos el error pero no romperá la carga.
                }
            }

            // return view('odenes-pedido.show', compact('orden', 'dentro', 'cliente', 'sucursal', 'detalles'));
            //           dd($detalles);
            return view('ordenes-pedido.show', compact('orden', 'detalles'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($documento)
    {
        $orden = Cabezamov::ordenesPedido()
            ->where('documento', (string) $documento)
            ->with(['detalles'])
            ->firstOrFail();

        $clientes = Gecliente::all();
        $productos = Inrefinv::all();

        // Obtener sucursales del cliente si existen
        $sucursales = [];
        if ($orden->codcp) {
            $sucursales = Geclientesaux::where('codcli', $orden->codcp)->get();
        }

        return view('ordenes-pedido.edit', compact('orden', 'clientes', 'productos', 'sucursales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $documento)
    {
        $request->validate([
            'codcp' => 'required|exists:geclientes,codcli',
            'codsuc' => 'nullable|exists:geclientesaux,codsuc',
            'fecha' => 'required|date',
            'fechent' => 'required|date|after_or_equal:fecha',
            'comen' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.codr' => 'required|exists:inrefinv,codr',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.valor' => 'required|numeric|min:0',
            'productos.*.codcolor' => 'nullable|string',
            'productos.*.codtalla' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Obtener la orden existente
            $orden = Cabezamov::ordenesPedido()
                ->where('documento', $documento)
                ->firstOrFail();

            // Calcular totales
            $subtotal = 0;
            foreach ($request->productos as $producto) {
                $subtotal += $producto['cantidad'] * $producto['valor'];
            }

            $iva = $subtotal * 0.16; // 16% de IVA, ajustar según sea necesario
            $total = $subtotal + $iva;

            // Actualizar el encabezado de la orden de pedido
            $orden->update([
                'codcp' => $request->codcp,
                'codsuc' => $request->codsuc ?? '',
                'fecha' => $request->fecha,
                'fechent' => $request->fechent,
                'comen' => $request->comen,
                'valortotal' => $total,
                'vriva' => $iva,
                'usuario' => Auth::user()->name
            ]);

            // Eliminar los detalles existentes
            Cuerpomov::ordenesPedido()
                ->where('documento', $documento)
                ->delete();

            // Crear los nuevos detalles de la orden
            foreach ($request->productos as $index => $producto) {
                $productoInfo = Inrefinv::find($producto['codr']);

                Cuerpomov::create([
                    'documento' => $documento,
                    'prefijo' => 'OP',
                    'tm' => 'OP',
                    'codr' => $producto['codr'],
                    'descr' => $productoInfo->descr,
                    'cantidad' => $producto['cantidad'],
                    'valor' => $producto['valor'],
                    'unidad' => $productoInfo->unid,
                    'codcolor' => $producto['codcolor'] ?? '',
                    'codtalla' => $producto['codtalla'] ?? '',
                    'numreg' => str_pad($index + 1, 3, '0', STR_PAD_LEFT)
                ]);
            }

            DB::commit();

            return redirect()->route('ordenes-pedido.index')
                ->with('success', 'Orden de pedido actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Error al actualizar la orden de pedido: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($documento)
    {
        try {
            DB::beginTransaction();

            // Eliminar los detalles de la orden
            Cuerpomov::ordenesPedido()
                ->where('documento', $documento)
                ->delete();

            // Eliminar el encabezado de la orden
            Cabezamov::ordenesPedido()
                ->where('documento', $documento)
                ->delete();

            DB::commit();

            return redirect()->route('ordenes-pedido.index')
                ->with('success', 'Orden de pedido eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error al eliminar la orden de pedido: ' . $e->getMessage());
        }
    }

    /**
     * Obtener las sucursales de un cliente específico
     */
    public function getSucursales($codcli)
    {
        $sucursales = Geclientesaux::where('codcli', $codcli)->get();
        return response()->json($sucursales);
    }

    /**
     * Obtener información de un producto específico
     */
    public function getProducto($codr)
    {
        $producto = Inrefinv::find($codr);
        return response()->json($producto);
    }
}
