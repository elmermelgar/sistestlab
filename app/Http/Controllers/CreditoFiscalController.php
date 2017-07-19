<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Estado;
use App\Factura;
use App\InvoiceProfile;
use App\TaxCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jleon\LaravelPnotify\Notify;

class CreditoFiscalController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('credito_fiscal.index', ['creditos_fiscales' => TaxCredit::all()]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customers()
    {
        $clientes = Cliente::join('facturas', 'clientes.id', '=', 'facturas.cliente_id')
            ->where('facturas.credito_fiscal', true)->where('facturas.tax_credit_id', null)
            ->select(DB::raw('clientes.id, clientes.nit, clientes.razon_social, 
            count(facturas) as cantidad_facturas, sum(facturas.total) as total'))
            ->groupBy(['clientes.id', 'clientes.nit', 'clientes.razon_social'])->get();
        return view('credito_fiscal.customers', ['clientes' => $clientes]);
    }

    /**
     * Se muestra el credito fiscal como una factura normal, para lo cual es necesario asignar
     * el cliente, un estado de factura y confirmar el atributo credito_fiscal.
     * Se agrupan todos los perfiles de exámenes de las facturas correspondientes al crédito fiscal
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($credito_fiscal = TaxCredit::find($id)) {
            $credito_fiscal->cliente = $credito_fiscal->facturas()->first()->cliente;
            /**
             * se debe asignar el estado de factura CERRADA para omitir los procesos inherentes a
             * una factura normal, así solo se cargarán los de modificar y terminar el crédito fiscal
             */
            $credito_fiscal->estado = Estado::where('name', 'cerrada')->where('tipo', 'factura')->first();
            $credito_fiscal->credito_fiscal = true;
            $profiles = InvoiceProfile::whereIn('factura_id', $credito_fiscal->facturas()->pluck('id')->all())
                ->get()->groupBy('profile_id');
            Notify::info('Usted está viendo un comprobante de crédito fiscal');
            return view('factura.show', [
                'factura' => $credito_fiscal,
                'sucursal' => $credito_fiscal->user->sucursal,
                'user' => $credito_fiscal->user,
                'centro_origen' => false,
                'edit' => false,
                'profiles' => $profiles,
                'suma' => $credito_fiscal->facturas()->first()->payments()->sum('amount'),
                'credito_fiscal' => true,
            ]);
        }
        return abort(404);
    }

    /**
     * @param $cliente_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($cliente_id)
    {
        $facturas = Factura::where('tax_credit_id', null)->where('cliente_id', $cliente_id)->orderBy('created_at')->get();
        return view('credito_fiscal.edit', [
            'credito_fiscal' => null,
            'sucursal' => Auth::user()->sucursal,
            'cliente' => Cliente::find($cliente_id),
            'facturas' => $facturas,
            'user' => Auth::user(),
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($credito_fiscal = TaxCredit::find($id)) {
            if ($credito_fiscal->closed) {
                Notify::warning('Éste crédito fiscal no puede modificarse');
                return back();
            }
            $cliente = $credito_fiscal->facturas()->first()->cliente;
            $facturas = Factura::where('tax_credit_id', null)->where('cliente_id', $cliente->id)
                ->orWhere('tax_credit_id', $credito_fiscal->id)->orderBy('created_at')->get();
            return view('credito_fiscal.edit', [
                'credito_fiscal' => $credito_fiscal,
                'sucursal' => $credito_fiscal->user->sucursal,
                'cliente' => $cliente,
                'facturas' => $facturas,
                'user' => $credito_fiscal->user,
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
        if (count($request->factura_id) <= 0) {
            Notify::error('Debe seleccionar al menos una factura para registrar el crédito fiscal');
            return redirect()->back()->withInput();
        }
        if ($credito_fiscal = TaxCredit::find($request->tax_credit_id)) {
            $credito_fiscal->update($request->all());
            foreach ($credito_fiscal->facturas as $factura) {
                $factura->tax_credit()->dissociate();
                $factura->save();
            }
        } else {
            $credito_fiscal = TaxCredit::create($request->all());
        }

        $total = 0;
        foreach ($request->factura_id as $factura_id) {
            $factura = Factura::find($factura_id);
            $factura->tax_credit()->associate($credito_fiscal);
            $factura->save();
            $total += $factura->total;
        }
        $credito_fiscal->total = $total;
        $credito_fiscal->save();

        Notify::success('El crédito fiscal se guardó correctamente');
        return redirect()->action('CreditoFiscalController@show', ['id' => $credito_fiscal->id]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close(Request $request)
    {
        if ($credito_fiscal = TaxCredit::find($request->tax_credit_id)) {
            $credito_fiscal->closed = true;
            $credito_fiscal->save();
        } else {
            Notify::error('No se cerró ningun crédito fiscal');
            return redirect()->back();
        }
        Notify::success('El crédito fiscal fue confirmado correctamente');
        return redirect()->action('CreditoFiscalController@show', ['id' => $credito_fiscal->id]);
    }
}
