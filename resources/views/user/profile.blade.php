<div class="x_panel">

    <div class="x_title">
        <h2>Perfil de Usuario</h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
            <div class="profile_img">
                <div id="crop-avatar">
                    <!-- Current avatar -->
                    <img class="img-responsive avatar-view" alt="Avatar" title="Change the avatar"
                         style="max-height: 200px"
                         src="
                            @if($user->account->photo)
                         {{url('/storage/photos/'.$user->account->photo)}}
                         @else
                         {{url('/storage/photos/'. 'user.png')}}
                         @endif ">
                </div>
            </div>
            <br/>
            @role('profesional')
            <div class="profile_img">
                <div id="crop-seal">
                    <!-- Current avatar -->
                    <img class="img-responsive seal-view" alt="Seal" title="Change the seal"
                         style="max-height: 200px"
                         src="
                            @if($user->account->seal)
                         {{url('/storage/seals/'.$user->account->seal)}}
                         @else
                         {{url('/storage/seals/'. 'seal.jpg')}}
                         @endif ">
                </div>
            </div>
            @endrole
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <h3>{{$user->name}}</h3>

            <ul class="list-unstyled user_data">
                <li><i class="fa fa-map-marker user-profile-icon"></i>
                    Sucursal {{$user->account->sucursal->display_name}}</li>
                <li>
                    <i class="fa fa-briefcase user-profile-icon"></i>
                    @forelse($user->roles as $rol)
                        {{$rol->display_name}}
                        @if(!$loop->last)
                            {{', '}}
                        @endif
                    @empty
                        Sin roles!
                    @endforelse
                </li>

                <li class="m-top-xs">
                    <i class="fa fa-envelope user-profile-icon"></i>
                    {{$user->email}}
                </li>
            </ul>

            <a class="btn btn-success" href="
            @if(Auth::user()->can('admin_users'))
            {{url('usuarios/'.$user->id.'/edit')}}
            @else
            {{url('usuario/editar/')}}
            @endif "><i
                        class="fa fa-edit m-right-xs"></i>Editar Perfil</a>
            <br/>
        </div>
    </div>
</div>