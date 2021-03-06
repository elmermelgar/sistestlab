@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="page-title">
        <div class="title_left">
            <ol class="breadcrumb">
                <li><a href="{{ url('/inicio')}}">
                        <i class="fa fa-home"></i>
                    </a></li>
                <li>Inventario</li>
                <li>Existencias</li>
            </ol>
        </div>

        <div class="title_right">
            <div class="form-group pull-right">
                <div class="input-group" style="">
                    <a href="{{route('activo.existencias')}}" style="float: right;" class="btn btn-danger"><i
                                class="fa fa-reply-all"></i> Regresar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <!-- form input knob -->
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Administración de recursos</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @foreach($inventarios as $inv)
                    <div class="col-md-2" style="text-align: center">
                        <form class="form-horizontal form-label-left"
                              action="{{route('activo.existencias.update',$inv->id)}}" method="POST">
                            {{ csrf_field() }}
                            <p>{{$inv->activo->nombre}}</p>
                            <h2>{{$inv->existencias()->sum('cantidad')}}</h2>
                            <input name="valor" class="knob" data-width="110" data-max="{{$inv->maximo}}"
                                   data-min="0" data-height="120" data-angleOffset=15
                                   data-angleArc=330 data-displayPrevious=true data-fgColor="#0AC3EF"
                                   data-skin="tron" data-thickness=".2"
                                   value="{{$inv->maximo-$inv->existencias()->sum('candidad')}}">
                            <button class="btn btn-round btn-warning btn-xs">Actualizar</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- /form input knob -->

@endsection
@section('scripts')
    <!-- jQuery Knob -->
    <script src="{{url('gentallela/vendors/jquery-knob/dist/jquery.knob.min.js')}}"></script>
    <script>
        $(function ($) {

            $(".knob").knob({
                change: function (value) {
                    //console.log("change : " + value);
                },
                release: function (value) {
                    //console.log(this.$.attr('value'));
                    console.log("release : " + value);
                },
                cancel: function () {
                    console.log("cancel : ", this);
                },
                /*format : function (value) {
                 return value + '%';
                 },*/
                draw: function () {

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