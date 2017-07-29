@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">

@endsection

@section('content')
        <!-- form input knob -->
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h1>Existencias de Reactivos
                    <a href="{{ route('activo.reactivo.edit') }}" title="Actualizar existencia" style="float: right">
                        <div class="btn btn-primary">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i> Actualizar Existencia
                        </div>
                    </a>
                </h1>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @foreach($inventario as $inv)
                    @if($inv->activo->tipo=='reactivo')
                        <div class="col-md-2" style="text-align: center">
                            <form class="form-horizontal form-label-left" action="activo.store" method="POST">
                                {{ csrf_field() }}
                                <p>{{$inv->activo->nombre_activo}}</p>
                                <input class="knob" data-width="110" data-max="{{$inv->cantidad_maxima}}" data-min="0" data-height="120" data-angleOffset=15
                                       data-angleArc=330 data-displayPrevious=true @if($inv->cantidad_minima>=$inv->existencia) data-fgColor="#FA1C1C"@else data-fgColor="#0AC3EF" @endif
                                       data-skin="tron" data-thickness=".2" value="{{$inv->existencia}}" readonly>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- /form input knob -->

@endsection
@section('scripts')

    <!-- jQuery Knob -->
    <script src="{{url('gentallela/vendors/jquery-knob/dist/jquery.knob.min.js')}}"></script>

    <script src="{{url('pnotify/pnotify.custom.min.js')}}"></script>


@endsection
@section('script-codigo')
        <!-- jQuery Knob -->
    <script>
        $(function($) {

            $(".knob").knob({
                change: function(value) {
                    //console.log("change : " + value);
                },
                release: function(value) {
                    //console.log(this.$.attr('value'));
                    console.log("release : " + value);
                },
                cancel: function() {
                    console.log("cancel : ", this);
                },
                /*format : function (value) {
                 return value + '%';
                 },*/
                draw: function() {

                    // "tron" case
                    if (this.$.data('skin') == 'tron') {

                        this.cursorExt = 0.8;

                        var a = this.arc(this.cv) // Arc
                                ,
                                pa // Previous arc
                                , r = 1;

                        this.g.lineWidth = this.lineWidth;

                        if (this.o.displayPrevious) {
                            pa = this.arc(this.v);
                            this.g.beginPath();
                            this.g.strokeStyle = this.pColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                            this.g.stroke();
                        }

                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                        this.g.stroke();

                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();

                        return false;
                    }
                }
            });

        });
    </script>
    <!-- /jQuery Knob -->


@endsection