<li>
    <a><i class="fa fa-gears"></i> Administrar
        <span class="fa fa-chevron-down"></span>
    </a>
    <ul class="nav child_menu">
        <li><a href="{{url('usuarios')}}">Usuarios</a></li>
        <li><a href="{{url('roles')}}">Roles</a></li>
        <li><a href="{{url('permisos')}}">Permisos</a></li>
        <li><a href="{{url('imagenes')}}">Imágenes</a></li>
    </ul>
</li>
<li>
    <a><i class="fa fa-archive"></i> Inventario
        <span class="fa fa-chevron-down"></span>
    </a>
    <ul class="nav child_menu">
        <li><a href="{{route('proveedores.index')}}">Proveedores</a></li>
        <li><a href="{{route('activo.index')}}">Activos</a></li>
    </ul>
</li>