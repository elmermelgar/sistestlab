@extends('layouts.app')

@section('styles')

@endsection
@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/results/invoice/')}}">Boletas Pendientes</a></li>
            <li><a href="{{url('results/'.$examen->id.'/'.$examen_paciente->id.'/complete')}}">Llenar Resultados</a></li>
            {{--<li>{{$detail? $detail->name_detail:'Nuevo'}}</li>--}}
        </ol>
        <a href="{{url('/results/invoice/')}}"
           style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px" class="btn btn-dark"><i
                    class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
    </div>

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="x_panel">

        <div class="x_title">


            <h3>Resultados del Examen</h3>
            <h2>{{ $examen->display_name }}</h2>

            {{--<a href="#" style="float: right; margin-top: -35px" class="btn btn-sm btn-primary" data-toggle="modal"--}}
               {{--data-target=".bs-example-modal-sm">--}}
                {{--[<i class="fa fa-plus" aria-hidden="true"></i>] Nuevo Valor de Referencia--}}
            {{--</a>--}}

            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form id="demo-form2" data-parsley-validate="" action="{{ url('results/store/results') }}" method="post" class="form-horizontal form-label-left" novalidate="">
                {{ csrf_field() }}
                <input type="hidden" name="examen_paciente_id" value="{{ $examen_paciente->id }}" readonly required>
                <p>Por favor complete todos los <code>resultados</code> antes de guardar. <code>{{ $examen_paciente->observacion }}</code></p>
                @foreach($groupings as $group)
                    <span class="section">{{ $group->name }}</span>
                    @foreach($details as $detail)
                        @if($detail->grouping_id == $group->id)
                            @if($detail->referenceType->name == 'protozoarios')
                            @elseif($detail->referenceType->name == 'espermograma')
                            @else
                                <input type="hidden" required readonly name="exam_detail_id[]"
                                       value="{{$detail->id}}">
                                <input type="hidden" name="protozoarios_type_id[]" value="{{ $proto_nin->id }}" readonly required>
                                <input type="hidden" name="spermogram_type_id[]" value="{{ $sperm_nin->id }}" readonly required>
                            @endif
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ $detail->name_detail }}
                                    <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    @if($detail->referenceType->name == 'protozoarios')
                                    @elseif($detail->referenceType->name == 'espermograma')
                                    @else
                                        @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],])->first();
                                        @endphp
                                    @endif
                                    @if($detail->referenceType->name == 'protozoarios')
                                        @foreach($proto_types as $type)
                                            @if($type->name != 'Ninguno')
                                                @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],
                                                                    ['protozoarios_type_id', '=', $type->id],])->first();
                                                @endphp
                                                <input type="hidden" required readonly name="exam_detail_id[]"
                                                       value="{{$detail->id}}">
                                                 <input type="hidden" name="spermogram_type_id[]" value="{{ $sperm_nin->id }}" readonly required>
                                                    {{--<input type="hidden" name="protozoarios_type_id[]" value="{{ $proto_nin->id }}" readonly required>--}}
                                                <input type="hidden" name="protozoarios_type_id[]"
                                                       value="{{ $type->id }}" readonly required>
                                                <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                                                    <input type="text" name="result[]"
                                                           value="@if($result){{ $result->result }}@endif"
                                                           required="required" placeholder="{{ $type->name }}"
                                                           class="form-control col-md-7 col-xs-12 parsley-success"
                                                           data-parsley-id="5">
                                                    <ul class="parsley-errors-list" id="parsley-id-5"></ul>
                                                </div>
                                                <input type="hidden" name="observation[]"
                                                       value="@if($result){{$result->observation}}@endif"
                                                       class="form-control"
                                                       placeholder="Observación">
                                            @endif
                                        @endforeach
                                    @elseif($detail->referenceType->name == 'espermograma')
                                        @foreach($sperm_types as $type)
                                            @if($type->name != 'Ninguno')
                                                @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],
                                                                    ['spermogram_modality_id', '=', $type->id],])->first();
                                                @endphp
                                                <input type="hidden" required readonly name="exam_detail_id[]"
                                                       value="{{$detail->id}}">
                                                <input type="hidden" name="protozoarios_type_id[]" value="{{ $proto_nin->id }}" readonly required>
                                                <input type="hidden" name="spermogram_type_id[]"
                                                       value="{{ $type->id }}" readonly required>
                                                <div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
                                                    <input type="text" name="result[]"
                                                           value="@if($result){{ $result->result }}@endif"
                                                           required="required" placeholder="{{ $type->name }}"
                                                           class="form-control col-md-7 col-xs-12 parsley-success"
                                                           data-parsley-id="5">
                                                    <ul class="parsley-errors-list" id="parsley-id-5"></ul>
                                                </div>
                                                <input type="hidden" name="observation[]"
                                                       value="@if($result){{$result->observation}}@endif"
                                                       class="form-control"
                                                       placeholder="Observación">
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                                            <input type="text" name="result[]"
                                                   value="@if($result){{$result->result}}@endif"
                                                   required="required" placeholder="{{ $detail->name_detail }}"
                                                   class="form-control col-md-7 col-xs-12 parsley-success"
                                                   data-parsley-id="5">
                                            <ul class="parsley-errors-list" id="parsley-id-5"></ul>
                                            {{--<span class="fa  form-control-feedback right"--}}
                                            {{--aria-hidden="true"><b>ml-static</b></span>--}}
                                        </div>
                                        <div class="col-md-8 col-sm-6 col-xs-12 form-group has-feedback">
                                            <input type="text" name="observation[]"
                                                   value="@if($result){{$result->observation}}@endif"
                                                   class="form-control"
                                                   placeholder="Obervación">
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-3">
                        <a href="{{url('results/invoice')}}" class="btn btn-primary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar Resultados</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/parsleyjs/dist/parsley.min.js')}}"></script>
@endsection
@section('script-codigo')

@endsection