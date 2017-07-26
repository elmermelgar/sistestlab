<li>
    <a>
        <i class="fa fa-asterisk"></i>Transacciones <span class="fa fa-chevron-down"></span>
    </a>
    <ul class="nav child_menu">
        <li><a href="{{url('facturas/create')}}">Nueva Factura</a></li>
        <li><a href="{{url('facturas/create/origen')}}">Nueva Factura
                <br>(Centro de Origen)</a>
        </li>
        @if(Auth::user()->can('credito_fiscal'))
            <li><a href="{{route('credito_fiscal_customers')}}">Otorgar Crédito Fiscal</a></li>
        @endif
        <li><a href="{{url('clientes/create')}}">Registrar Cliente</a></li>
        <li><a href="{{url('pacientes/create')}}">Registrar Paciente</a></li>
    </ul>
</li>