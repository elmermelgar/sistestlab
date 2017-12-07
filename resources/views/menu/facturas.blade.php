<li>
    <a>
        <i class="fa fa-usd"></i>Facturas <span class="fa fa-chevron-down"></span>
    </a>
    <ul class="nav child_menu">
        <li><a href="{{url('facturas')}}">Facturas</a></li>
        <li><a href="{{route('credito_fiscal.index')}}">Crédito Fiscal</a></li>
        @if(Auth::user()->can('credito_fiscal'))
            <li><a href="{{route('credito_fiscal.customers')}}">Otorgar Crédito Fiscal</a></li>
        @endif
    </ul>
</li>