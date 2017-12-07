@extends('layouts.app')

@section('imports')
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{route('account')}}">{{$user->name}}</a></li>
            <li>Actualizar Foto</li>
        </ol>
    </div>

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif


    <div class="col-md-6 col-sm-6 col-xs-12 col-sm-offset-3">
        <div class="x_panel">

            <div class="x_title">
                <h2>Actualizar Foto</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <form class="form-horizontal form-label-left" method="post"
                      action="{{route('account.avatar.store')}}" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="profile_img" style="text-align: center">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img class="img-responsive avatar-view" alt="Avatar" title="Avatar"
                                 style="max-height: 200px;margin: auto" src="
                            @if($user->account->photo)
                            {{url('/storage/photos/'.$user->account->photo)}}
                            @else
                            {{url('/storage/photos/'. 'user.png')}}
                            @endif ">
                            <br>
                            <label for="avatar" id="labelAvatar" class="btn btn-success" style="margin-bottom: 1em">
                                Cambiar Foto
                            </label>
                            <input type="file" id="avatar" name="avatar" maxlength="255" accept=".png,.jpg,.jpeg"
                                   style="display: none">
                            <p>*Resolución recomendada: 200x200</p>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-sm-6 col-xs-12">
                            <a href="{{route('account')}}" class="form-control btn btn-default">Cancelar</a>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <input type="submit" class="form-control btn btn-primary" value="Guardar">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('/js/avatar.js')}}"></script>
@endsection