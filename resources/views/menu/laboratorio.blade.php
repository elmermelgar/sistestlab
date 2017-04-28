<li>
    <a>
        <i class="fa fa-flask"></i>Laboratorio <span class="fa fa-chevron-down"></span>
    </a>
    <ul class="nav child_menu">
        @if(Auth::user()->sucursal)
            <li><a href="{{url('examenes/'.Auth::user()->sucursal->id)}}">Examenes</a></li>
        @endif
        <li><a href="{{url('clientes')}}">Clientes</a></li>
        <li><a href="{{url('pacientes')}}">Pacientes</a></li>
        <li><a href="{{url('origenes')}}">Centros de Origen</a></li>
        <li><a href="{{url('recolectores')}}">Recolectores</a></li>
    </ul>
</li>