
@extends('admin.template')

@section('content')
    <div class="card p-2  col-md-6 mx-auto  mt-1 mb-2">
        <h3 class="text-bold text-center">

            @if( Auth::user()->id == $user->id  )
                Votre profil
            @elseif( ( Auth::user()->role == env('ADMIN_ROLE') ) && (Auth::user()->id != $user->id) )
                Profil de {{ $user->name }}
            @endif

        </h3>
    </div>

    @if(session('successNotification'))
        <div class=" alert alert-success alert-dismissible col-md-6 mx-auto tex-center my-2">
            <button class="close" data-dismiss="alert" type="button" >&times;</button>
            <p style="text-align: center;"> {{ session('successNotification') }}</p>
        </div>
    @endif

    @if(session('errorNotification'))
        <div class=" alert alert-danger col-md-6 mx-auto alert-dismissible tex-center  my-2">
            <button class="close" data-dismiss="alert" type="button" >&times;</button>
            <p style="text-align: center;"> {{ session('errorNotification') }}</p>
        </div>
    @endif

    <div class="card p-3 mt-3 col-md-6 m-auto">
        <form method="POST" action="{{ route('updateMyProfil',['id_user'=>$user->id]) }}">
            @csrf
            <div class="form-group">
                <label for="name" class="col-form-label text-md-right">Nom et Prénom</label>
                <input id="name" type="text" value="{{ $user->name }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"  autofocus>

                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group ">
                <label for="email" class="col-form-label text-md-right">Email</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" >

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group ">
                <label for="telephone" class="col-form-label text-md-right">Telephone</label>
                <input id="telephone" type="telephone" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" value="{{ $user->telephone }}" >

                @if ($errors->has('telephone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('telephone') }}</strong>
                    </span>
                @endif
            </div>

            @if( ( Auth::user()->role == env('ADMIN_ROLE') ) && ( Auth::user()->id != $user->id ) )
                <div class="form-group">
                    <label for="role" class="col-form-label text-md-right">Rôle</label>
                    <select id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" >
                        <option value="redacteur"  @if( $user->role=="redacteur") selected  @endif  >Rédacteur </option>
                        <option value="correcteur" @if( $user->role=="correcteur") selected  @endif>Correcteur </option>
                    </select>
                    @if ($errors->has('role'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                </div>
            @endif
{{--
            @if( Auth::user()->id == $user->id )
                <div class="form-group">
                    <label for="password" class="col-form-label text-md-right">Nouveau mot de passe</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" >

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group ">
                    <label for="password-confirm" class="col-form-label text-md-right">Confirmation mot de passe</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                </div>
            @endif --}}

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn bg-admin-base ">
                        <i class="fas fa-check"></i> Modifier le profil
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
