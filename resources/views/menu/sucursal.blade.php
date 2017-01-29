<li><a><i class="fa fa-institution"></i> Sucursal <span
                class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="{{url('sucursales')}}">Todas</a></li>
        @php $sucursales=\App\Sucursal::all() @endphp
        @foreach($sucursales as $sucursal)
        <li><a href="{{url('sucursales/'.$sucursal->id)}}">{{$sucursal->display_name}}</a></li>
            @endforeach
    </ul>
</li>