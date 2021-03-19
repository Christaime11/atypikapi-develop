@extends('admin.template')

@section('page_level_css')
    <link rel="stylesheet" href="{{asset('css/datable.css')}}"/>
@endsection

@section('content')
    <div class="pt-2">
        <div class="bg-white p-2">
            <h3 class="text-bold text-center">
                Tous les types d'habitats
            </h3>
        </div>
    </div>



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




    <div class="bg-white p-3 mt-3">
        {{-- debut formulaire ajout--}}
        <form class=" form-inline mr-auto mb-5" method="POST" action="{{ route('addTypeHabitat') }}">
            @csrf
            <label for="libelle" class="mr-3"> Libelle </label>
            <input id="libelle"  type="text" class="w-25 form-control {{ $errors->has('libelle') ? ' is-invalid' : '' }}" name="libelle" value="{{ old('libelle') }}" required autofocus>
            <button type="submit" class=" float-right btn btn-admin-success "> <i class="fas fa-check"></i> Ajouter</button>
            @error('libelle')
            <div class="invalid-feedback ml-5 pl-3" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </form>
        {{-- debut tableau --}}
        <table  class="display table table-bordered mt-5" id="listetypehabitats">
            <thead>
            <tr>
                <th class="itteration-width">N°</th>
                <th class="image-width">Libelle</th>
                <th class="action-width">Actions </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($typeHabitats as $typeHabitat)
                <tr>
                    <td class="itteration-width"> {{ $loop->iteration }} </td>
                    <td class="image-width">{{ $typeHabitat->libelle }}</td>
                    <td class="action-width text-center">
                        {{-- debut  voir detail + modification--}}
                        <span onclick="modifyTypeHabitat( '{{$typeHabitat->id}}', '{{$typeHabitat->libelle}}' )" data-toggle="tooltip" data-placement="top" title="modifier ce type habitat"><i class="far text-primary fa-edit"></i></span> &nbsp;
                        {{--fin  voir détail --}}
                        {{--debut  supprimer--}}
                        @if( $typeHabitat->libelle != env('DEFAULT_TYPE_HABITAT') )
                        <a href="{{ route('deleteTypeHabitat',['idTypeHabitat'=>$typeHabitat->id]) }}"
                           data-toggle="confirmation" data-title="Voulez-vous vraiment supprimer ce type habitat?"
                           data-btn-ok-label="Oui" data-btn-ok-class="btn-success" data-content="Tous les habitats de ce type seront rajouté à au type ' {{env('DEFAULT_TYPE_HABITAT')}} ' " data-btn-cancel-label="Annuler"
                           data-btn-cancel-class="btn-danger" >
                            <i class="fas fa-trash-alt text-danger"></i>
                        </a>
                        @endif
                        {{--fin  supprimer--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{-- fin tableau --}}

        {{--start modal modification--}}
             @include("admin.habitat.modal_ajout_type_habitat")
        {{--end modal modification--}}
    </div>
@endsection

@section('optional_js')
    <script src="{{ asset('js/bootstrap-confirmation.min.js') }}"></script>
    <script src="{{ asset('js/datable.js') }}"></script>
    <script src="{{ asset('js/lang-all.js') }}"></script>
    <script>
        //affichage de la modal de modification
        //d'un type habitat
        function modifyTypeHabitat(id, libelle){
            var form = $("#modificationTypeHabitatForm");
            let action = form.attr("action").replace(":id",id);
            form.attr("action",action)

            $("#libelleModif").attr("value",libelle);
            $("#modalModifTypeHabitatModal").modal();
        }
        $('document').ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle=confirmation]').confirmation({ rootSelector: '[data-toggle=confirmation]' });

        });

        //jquery datatables
        $('#listetypehabitats').DataTable({
            ordering: false,
            language: {
                processing:     "Traitement en cours...",
                search:         "Rechercher&nbsp;:",
                lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
                info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable:     "Aucune donnée disponible dans le tableau",
                paginate: {
                    first:      "Premier",
                    previous:   "Pr&eacute;c&eacute;dent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
                // aria: {
                //     sortAscending:  ": activer pour trier la colonne par ordre croissant",
                //     sortDescending: ": activer pour trier la colonne par ordre décroissant"
                // }
            }
        });

    </script>
@endsection
