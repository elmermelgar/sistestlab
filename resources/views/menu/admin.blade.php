<li>
    <a><i class="fa fa-gears"></i>Administrar
        <span class="fa fa-chevron-down"></span>
    </a>
    <ul class="nav child_menu">
        <li><a href="{{url('permisos')}}">Permisos</a></li>
        <li><a href="{{url('roles')}}">Roles</a></li>
        <li><a href="{{url('usuarios')}}">Usuarios</a></li>
        <li><a href="{{url('perfiles')}}">Perfiles</a></li>
        <li><a href="{{url('examenes')}}">Exámenes</a></li>
        <li><a href="{{url('bonos')}}">Bonos</a></li>
    </ul>
</li>
@include('menu.sucursal')
<li>
    <a href="{{route('report')}}"><i class="fa fa-file-text"></i>Reportes</a>
</li>
<li>
    <a><i class="fa fa-image fw"></i>Imágenes
        <span class="fa fa-chevron-down"></span>
    </a>
    <ul class="nav child_menu">
        <li><a href="{{url('imagenes')}}">Todas</a></li>
        <li><a href="{{url('imagenes/categorias')}}">Categorías</a></li>
    </ul>
</li>
<li>
    <a><i class="fa fa-archive fw"></i>Inventario
        <span class="fa fa-chevron-down"></span>
    </a>
    <ul class="nav child_menu">
        <li><a href="{{route('proveedores.index')}}">Proveedores</a></li>
        <li><a href="{{route('activo.index')}}">Activos</a></li>
        <li><a href="{{route('activo.existencias')}}">Existencias</a></li>
    </ul>
</li>