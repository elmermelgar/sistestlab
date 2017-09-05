@extends('layouts.app')

@section('imports')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            @if(Auth::user()->can('admin_users'))
                <li><a href="{{url('/usuarios')}}">Usuarios</a></li>
            @endif
            <li>{{$user->name}}</li>
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

    @include('user.profile',['user'=>$user])

@endsection

@section('scripts')
@endsection