@extends('admin.template ')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if(session('successNotification'))
                    <div class=" alert alert-success alert-dismissible  tex-center my-2">
                        <button class="close" data-dismiss="alert" type="button" >&times;</button>
                        <p style="text-align: center;"> {{ session('successNotification') }}</p>
                    </div>
                @endif

                <div class="bg-white">
                    <div class="card-header bg-admin-base  text-center bg-admin-base  text-white text-bold">
                        Atypik House Administration | Nouveau type d'habitat
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nom et Prénom</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn bg-admin-base ">
                                        <i class="fas fa-check"></i> Ajouter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
