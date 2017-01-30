@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <!-- PNotify -->
    {{--<link href="{{url('gentallela/vendors/pnotify/dist/pnotify.css')}}" rel="stylesheet">--}}
    {{--<link href="{{url('gentallela/vendors/pnotify/dist/pnotify.buttons.css')}}" rel="stylesheet">--}}
    {{--<link href="{{url('gentallela/vendors/pnotify/dist/pnotify.nonblock.css')}}" rel="stylesheet">--}}

    <link href="{{url('pnotify/pnotify.custom.min.css')}}" rel="stylesheet">

@endsection

@section('content')
        <!-- form input knob -->
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Input knob</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-2" style="text-align: center">
                    <form class="form-horizontal form-label-left" action="#" method="PUT">
                        {{ csrf_field() }}
                        <p>Display value</p>
                        <input class="knob" data-width="110" data-height="120" data-angleOffset=15 data-angleArc=330 data-displayPrevious=true data-fgColor="#0AC3EF" data-skin="tron" data-thickness=".2" value="75">
                        <button type="submit" class="btn btn-round btn-warning btn-xs">Guardar</button>
                    </form>
                </div>
                <div class="col-md-2">
                    <p>&#215; 'cursor' mode</p>
                    <input class="knob" data-width="100" data-height="120" data-cursor=true data-fgColor="#34495E" value="29">
                </div>
                <div class="col-md-2">
                    <p>Step 0.1</p>
                    <input class="knob" data-width="100" data-height="120" data-min="-10000" data-displayPrevious=true data-fgColor="#26B99A" data-max="10000" data-step=".1" value="0">
                </div>
                <div class="col-md-2">
                    <p>Angle arc</p>
                    <input class="knob" data-width="110" data-height="120" data-angleOffset=-125 data-angleArc=250 data-fgColor="#34495E" data-rotation="anticlockwise" value="35">
                </div>
                <div class="col-md-2">
                    <p>Alternate design</p>
                    <input class="knob" data-width="110" data-height="120" data-angleOffset=15 data-angleArc=330 data-displayPrevious=true data-fgColor="#0AC3EF" data-skin="tron" data-thickness=".2" value="75">
                </div>
                <div class="col-md-2">
                    <p>Angle offset</p>
                    <input class="knob" data-width="100" data-height="120" data-angleOffset=90 data-linecap=round data-fgColor="#26B99A" value="35">
                </div>
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