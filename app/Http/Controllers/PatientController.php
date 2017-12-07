<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Patient;
use App\Services\UserService;

use App\Sucursal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Jleon\LaravelPnotify\Notify;

class PatientController extends Controller
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * Muestra la cartera de pacientes
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('paciente.index', ['pacientes' => Patient::filter($request->get('nombre'))->paginate(10)]);
    }

    /**
     * Muestra al paciente especificado
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($paciente = Patient::find($id)) {
            return view('paciente.show', ['paciente' => $paciente]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Muestra el formulario para registrar un nuevo paciente
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('paciente.edit', [
            'paciente' => null,
            'clientes' => Customer::all(),
            'sucursales' => Sucursal::all(),
        ]);
    }

    /**
     * Muestra el formulario para editar a un paciente
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($paciente = Patient::find($id)) {
            if ($paciente->account->customer) {
                Notify::warning('Este paciente esta registrado como cliente; 
                para actualizar datos deberá editar el registro de cliente.');
                return back();
            }
            return view('paciente.edit', [
                'paciente' => $paciente,
                'clientes' => Customer::select(['id', 'name', 'comment'])->get(),
                'sucursales' => Sucursal::all(),
            ]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Almacena la información de un paciente
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $request->merge(['identity_document' => str_replace('-', '', $request->identity_document)]);
            $request->merge(['phone_number' => str_replace('-', '', $request->phone_number)]);
            if ($request->id && $paciente = Patient::find($request->id)) {
                $this->validate($request, $this->rules($paciente->account_id));
                $paciente->update($request->all());
            } else {
                $this->validate($request, $this->rules());
                $paciente = Patient::create($request->all());
            }
            $paciente->customers()->sync($request->customer_id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof ValidationException) {
                return back()->withInput()->withErrors($e->validator->errors());
            }
            \Log::error($e);
            Notify::error('No se ha registrado al paciente');
            return back()->withInput();
        }

        Notify::success('Paciente registrado correctamente');
        return redirect()->action('PatientController@show', ['paciente' => $paciente->id]);
    }

    /**
     * Reglas para validar la petición
     * @return array
     */
    private function rules($account_id = null)
    {
        return [
            'sucursal_id' => 'required|integer|min:1',
            'identity_document' => ['max:9', Rule::unique('accounts_dui_vw')->ignore($account_id)],
            'first_name' => 'required|max:127',
            'last_name' => 'max:127',
            'phone_number' => 'required|max:8',
            'birth_date' => 'date_format:Y-m-d',
            'address' => 'max:255',
            'profession' => 'max:127',
            'comment' => 'max:255',
        ];
    }
}
