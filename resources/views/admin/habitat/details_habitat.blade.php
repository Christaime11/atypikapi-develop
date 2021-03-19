
@extends('admin.template')

@section('content')
    {{--debut notification --}}
    @if(session('successNotification'))
        <div class=" alert alert-success alert-dismissible  tex-center my-2">
            <button class="close" data-dismiss="alert" type="button" >&times;</button>
            <p style="text-align: center;"> {{ session('successNotification') }}</p>
        </div>
    @endif

    @if(session('errorNotification'))
        <div class=" alert alert-danger alert-dismissible tex-center  my-2">
            <button class="close" data-dismiss="alert" type="button" >&times;</button>
            <p style="text-align: center;"> {{ session('errorNotification') }}</p>
        </div>
    @endif
    {{--fin notification --}}

    {{--debut titre et description --}}
    <div  class="bg-white p-3 @if($habitat->valideParAtypik == 1) pt-5 @endif mt-3" style="position: relative">
        <div >
            <h4 class="admin-title-section mb-4" style="display: inline-block"> Informations </h4>
            <a href="" style="display: inline-block; position: absolute; right: 200px;" data-toggle="modal" id="launchModalCoordonneesProrpietaire" data-target="#modalCoordonneesProrpietaire">
                <button class=" btn btn-admin-primary"> <i class="fas fa-address-card"></i> Coordonnés du propriétaire </button>
            </a>

            @if( $habitat->valideParAtypik != 1)
                <a href="{{ route('validateHabitat', ['idHabitat'=>$habitat->id]) }}" style="display: inline-block; position: absolute; right: 0px;">
                    <button class=" btn btn-admin-primary"> <i class="fas fa-thumbs-up"></i> Valider cet Habitat </button>
                </a>
            @else
                <div class="bg-admin-base p-2" style="display: inline-block; position: absolute; right: 1px; top: 0; border-radius:2px">
                    Habitat déjà validé !
                </div>
                <a href="{{ route('unValidateHabitat', ['idHabitat'=>$habitat->id]) }}" style="display: inline-block; position: absolute; right: 0px;">
                    <button class=" btn btn-admin-danger"> <i class="fas fa-thumbs-down"></i> Annuler la validation </button>
                </a>
            @endif
        </div>
        <h4> {{ $habitat->title }}</h4>
        <div class="admin-divider"></div>
        <div class="mt-3"> {{ $habitat->description }}</div>

        <h4 class="mt-3 "> Prix par nuit : <span class="text-admin-orange">{{ $habitat->prixParNuit }} &#128;</span> </h4>

        <p class="text-bold mt-4"> <i class="fas fa-map-marker-alt"></i> {{ $habitat->adresse }}</p>
    </div>
    {{--fin partie informations --}}


    {{--debut équipements --}}
    <div  class="bg-white p-3 mt-3">
        <h4 class="admin-title-section mb-4" style="display: inline-block"> Équipements </h4>
        <div>
            <span class="mx-4"> <i class="fas fa-tv"></i> Télévision : {{ $habitat->hasTelevision == 1 ? "Oui"  : "Non"}}</span>
            <span class="mx-4" > <img class="admin-image-icon" src="{{ asset('images/air-conditioner.png') }}" alt="climatiseur" style=""> Climatiseur : {{ $habitat->hasClimatiseur == 1 ? "Oui"  : "Non"}}</span>
            <span class="mx-4 "> <img class="admin-image-icon" src="{{ asset('images/heater.png') }}" alt="chauffage" style="margin-top: -5px"> Chauffage : {{ $habitat->hasChauffage == 1 ? "Oui"  : "Non"}}</span>
            <span class="mx-4 "> <i class="fas fa-wifi"></i> Internet : {{ $habitat->hasInternet == 1 ? "Oui"  : "Non"}}</span>
            <span class="mx-4"> <img class="admin-image-icon" src="{{ asset('images/room.png') }}" alt="chambre" style="margin-top: -5px"> Nombre de chambres : {{ $habitat->nombreChambre }}</span>
            <span class="mx-4"> <img class="admin-image-icon" src="{{ asset('images/bed.png') }}" alt="lit" style="margin-top: -5px">  Nombre de lit : {{ $habitat->nombreLit }}</span>
        </div>
    </div>
    {{--fin équipements --}}

    <div  class="bg-white p-3 mt-3">
        <h4 class="admin-title-section mb-4" style="display: inline-block"> Images </h4>
        <div class="row ">
            @foreach( $habitat->getVues as $vue )
                <div class="ml-5 col-md-5  mb-3 ">
                    <img class="img-fluid" src="{{asset('storage/'.$vue->lienImage)}}" width="800" height="300" alt=""/>
                     @if(!empty(( $vue->legende)))
                        <div class="bg-admin-base text-center p-2">
                            {{$vue->legende}}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- debut modal coordonnées propriétaire --}}
    @include('admin.habitat.modal_coordonnées_proprietaire')
    {{-- fin modal  coordonnées propriétaire --}}
@endsection


@section('optional_js')
    <script>
/*       $('document').ready(function (){
           $("#launchModalCoordonneesProrpietaire").click(function (){
               $("#modalCoordonneesProrpietaire").modal();
           })
       })*/
    </script>
@endsection
