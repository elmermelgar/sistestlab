<?php

namespace App\Http\Controllers;

use App\Imagen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jleon\LaravelPnotify\Notify;

class ImagenController extends Controller
{

    /**
     * @var string
     */
    private $defaultImage = 'testlab.png';

    /**
     * Url base para acceder a las imagenes a través de http, relativo al directorio publico
     * @var string
     */
    private $imageUrl = '/storage/images/';

    /**
     * Ruta donde se almacenan las imagenes relativo al directorio de almacenamiento publico
     * /storage/app/public/
     * @var string
     */
    private $imagePath = 'images';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * Muestra todas la imagenes subidas
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('imagen.index', ['imagenes' => Imagen::all()]);
    }

    /**
     * Muestra el formulario para subir una nueva imagen
     */
    public function upload()
    {
        return view('imagen.edit', ['imagen' => null, 'new' => true]);
    }

    /**
     * Muestra el formulario para editar la información de una imagen subida
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('imagen.edit', ['imagen' => Imagen::find($id)]);
    }

    /**
     * Elimina una imagen anteriormente subida
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Request $request)
    {
        if($request->id&&$imagen=Imagen::find($request->id)){
            if(count($imagen->sucursales) || $imagen->default){
                Notify::error('La imágen esta en uso y no se puede eliminar');
                return redirect()->back();
            }
            Storage::disk('public')->delete($this->imagePath.'/'. $imagen->file_name);
            $imagen->delete();
            Notify::info('La imagen se eliminó correctamente');
            return redirect('imagenes');
        }
        Notify::error('No se ha podido eliminar la imagen');

    }

    /**
     * Almacena una imagen
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if ($request->id && $imagen = Imagen::find($request->id)) {
            $imagen->update($request->only(['title', 'description']));
        } else if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = Carbon::now()->format('YmdHis') . '.' . $extension;
            Storage::disk('public')->putFileAs($this->imagePath, $file, $filename);
            $request->merge(['file_name' => $filename]);
            $imagen = Imagen::create($request->only(['title', 'description', 'file_name']));
        } else {
            Notify::danger('La imagen no se ha subido');
            return redirect()->back();
        }
        if ($request->default) {
            DB::table('imagenes')->where('id', '<>', $imagen->id)->update(['default' => false]);
            $imagen->default = true;
        }
        $imagen->save();
        Notify::success('La imagen se subió exitosamente.', 'Exito');
        return redirect('imagenes');
    }

}
