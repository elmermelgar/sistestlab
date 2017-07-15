<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Profile;
use App\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Jleon\LaravelPnotify\Notify;

class ProfileController extends Controller
{

    /**
     * Constante para el perfil tipo examen
     */
    const EXAMEN = 0;

    /**
     * Constante para el perfil tipo grupo
     */
    const GRUPO = 1;

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('perfil.index', [
            'perfiles' => Profile::filter($request->get('display_name'))->paginate(20)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|
     */
    public function show($id)
    {
        if ($perfil = Profile::find($id)) {
            return view('perfil.show', [
                'perfil' => $perfil,
                'examenes' => [],
                'sucursales' => Sucursal::all(),
            ]);
        }
        return abort(404);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|
     */
    public function create()
    {
        return view('perfil.edit', ['perfil' => null]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|
     */
    public function edit($id)
    {
        if ($perfil = Profile::find($id)) {
            if ($perfil->type == self::EXAMEN) {
                Notify::warning('Esté es el perfil de un examen, para actualizalo edite el examen correspondiente');
                return back();
            }
            return view('perfil.edit', [
                'perfil' => $perfil
            ]);
        }
        return abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!$request->enabled) {
            $request->merge(['enabled' => false]);
        }
        if ($request->profile_id && $perfil = Profile::find($request->profile_id)) {
            $perfil->update($request->all());
        } else {
            $perfil = Profile::create($request->all());
        }
        Notify::success('Perfil guardado correctamente');
        return redirect()->action("ProfileController@show", ['id' => $perfil->id]);
    }

    /**
     * @param Request $request
     * @return Redirect
     */
    public function prices(Request $request)
    {
        if (($profile = Profile::find($request->profile_id)) && (count($request->sucursal_id) == count($request->price))) {
            $profile->sucursales()->detach();
            foreach ($request->sucursal_id as $index => $sucursal_id) {
                if ($request->price[$index] > 0)
                    $profile->sucursales()->attach($sucursal_id, ['price' => $request->price[$index]]);
            }
            Notify::success('Precios guardados correctamente');
            return redirect()->action('ProfileController@show', ['id' => $profile->id]);
        }
        Notify::danger('No se han guardado los precios');
        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add_exam(Request $request)
    {
        if ($profile = Profile::find($request->profile_id)) {
            if ($profile->type == self::EXAMEN) {
                Notify::warning('Esté es el perfil de un examen, no puede agregar más exámenes');
                return back();
            }
            $profile->exams()->syncWithoutDetaching([$request->exam_id]);
            Notify::success('Examen agregado correctamente');
        } else {
            Notify::danger('No se agregó el examen');
        }
        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function del_exam(Request $request)
    {
        if ($profile = Profile::find($request->profile_id)) {
            if ($profile->type == self::EXAMEN) {
                Notify::warning('Esté es el perfil de un examen, no puede remover exámenes');
                return back();
            }
            $profile->exams()->detach([$request->exam_id]);
            Notify::warning('Se quitó un examen de este perfil');
        } else {
            Notify::danger('No se agregó el examen');
        }
        return back();
    }

    /**
     * Busca y retorna a los exámenes que coincidan con el nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param Request $request
     * @return string
     */
    public function searchExam(Request $request)
    {
        try {
            $exam = Exam::select(['id', 'name', 'display_name', 'observation', 'precio'])
                ->where('display_name', '~*', $request->display_name)
                ->get();
            $resultado = [
                "total_count" => count($exam),
                "incomplete_results" => false,
                "items" => $exam,
            ];
        } catch (\Exception $e) {
            $resultado = [
                "total_count" => 0,
                "incomplete_results" => true,
                "items" => [],
            ];
        }
        return json_encode($resultado);
    }

}
