<?php

namespace App\Http\Controllers;

use App\BoxRegistry;
use App\Imagen;
use App\Services\SucursalService;
use App\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Jleon\LaravelPnotify\Notify;

class SucursalController extends Controller
{

    /**
     * @var SucursalService
     */
    private $sucursalService;

    /**
     * Create a new controller instance.
     */
    public function __construct(SucursalService $sucursalService)
    {
        $this->middleware('auth');
        $this->sucursalService = $sucursalService;
    }

    /**
     * Muestra una lista de las sucursales
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sucursal.index', ['sucursales' => Sucursal::all()]);
    }

    /**
     * Muestra la sucursal especificada
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id = null)
    {
        if (is_null($id)) {
            $id = Auth::user()->account->sucursal->id;
        }
        if ($sucursal = Sucursal::find($id)) {
            $end_date = \Carbon\Carbon::now()->toDateString();
            $start_date = \Carbon\Carbon::now()->subDay(7)->toDateString();
            $caja = $this->sucursalService->getBox($id);
            $registro = $this->sucursalService->getRegistryByDate($id, $start_date, $end_date);
            setlocale(LC_TIME, 'es_SV.UTF-8', 'es');
            return view('sucursal.show', [
                'sucursal' => $sucursal,
                'caja' => $caja,
                'registros' => $registro,
            ]);
        }
        return abort(404);
    }

    /**
     * Muesta el formulario para registrar una nueva sucursal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('sucursal.edit', [
            'sucursal' => null
        ]);
    }

    /**
     * Muestra el formulario para editar la sucursal especificada
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($sucursal = Sucursal::find($id)) {
            return view('sucursal.edit', [
                'sucursal' => $sucursal,
                'edit' => true
            ]);
        }
        return response()->view('errors.404', [], 404);

    }

    /**
     * Almacena una sucursal
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if ($request->id && $sucursal = Sucursal::find($request->id)) {
            $sucursal->update($request->except(['id', '_token']));
        } else {
            $sucursal = Sucursal::create($request->except(['id', '_token']));
        }
        Notify::success('Registro guardado correctamente');
        return redirect()->action('SucursalController@show', $sucursal->id);
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function registry(Request $request, $id = null)
    {
        if (is_null($id)) {
            $id = Auth::user()->account->sucursal->id;
        }
        if ($sucursal = Sucursal::find($id)) {
            $page = $request->page ?: 1;
            $count = BoxRegistry::where('sucursal_id', $id)->count();
            $registro = $this->sucursalService->getRegistry($id, 20, $page);
            $paginate = new LengthAwarePaginator($registro, $count, 20);
            $paginate->setPath('');
            return view('sucursal.registry', [
                'sucursal' => $sucursal,
                'registros' => $paginate,
            ]);
        }
        return abort(404);
    }

    /**
     * Abre la caja de la sucursal
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function openBox(Request $request)
    {
        $this->validate($request, ['id' => 'required|integer', 'cash' => 'nullable|numeric']);
        if ($this->sucursalService->openBox($request->id, Auth::user()->account_id, $request->cash)) {
            Notify::success('La caja se ha abierto');
        } else {
            Notify::danger('Puede que la caja ya estuviese abierta');
        }
        return redirect()->back();
    }

    /**
     * Cierra la caja de al sucursal
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeBox(Request $request)
    {
        $this->validate($request, ['id' => 'required|integer']);
        if ($this->sucursalService->cerrarCaja($request->id, Auth::user()->account_id)) {
            Notify::success('La caja se ha cerrado');
        } else {
            Notify::danger('Puede que la caja ya estuviese cerrada');
        }
        return redirect()->back();
    }

    /**
     * Muestra las imagenes disponibles para seleccionar una como logo de sucursal
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function image($id)
    {
        if ($sucursal = Sucursal::find($id)) {
            $imagenes = Imagen::select(['imagenes.id', 'imagenes.file_name'])
                ->join('imagen_categoria', 'imagenes.imagen_categoria_id', 'imagen_categoria.id')
                ->where('imagen_categoria.name', 'categoria_sucursal')->get();
            return view('sucursal.image', [
                'sucursal' => $sucursal,
                'imagenes' => $imagenes,
            ]);
        }
        return abort(404);
    }

    /**
     * Asocia una imagen a una sucursal
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeImage(Request $request)
    {
        if ($sucursal = Sucursal::find($request->id)) {
            $sucursal->imagen()->associate($request->image);
            $sucursal->save();
            Notify::success('Se ha cambiado la imágen de la sucursal');
        } else {
            Notify::error('No se ha cambiado la imagen');
        }
        return redirect('sucursales/' . $sucursal->id);
    }

}
