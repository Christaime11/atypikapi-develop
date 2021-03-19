@extends('admin.template')

@section('page_level_css')
    <link rel="stylesheet" href="{{asset('css/datable.css')}}"/>
@endsection

@section('content')
    <div class="pt-2">
        <div class="bg-white p-2">
            <h3 class="text-bold text-center">
                Les utilisateurs voulant mettre en location des habitats
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
        {{-- debut tableau --}}
        <table  class="display table table-bordered mt-5" id="listetypehabitats">
            <thead>
            <tr>
                <th class="itteration-width">N°</th>
                <th class="image-width">Nom</th>
                <th class="image-width">Email</th>
                <th class="image-width">Téléphone</th>
                <th class="image-width">Entreprise</th>
                <th class="image-width">Siren</th>
                <th class="image-width">Adresse Personnelle</th>
                <th class="action-width">Actions </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($usersWhoWanToAddHabitat as $user)
                <tr>
                    <td class="itteration-width"> {{ $loop->iteration }} </td>
                    <td class="orateur-width">{{ $user->name }}</td>
                    <td class="orateur-width">{{ $user->email }}</td>
                    <td class="orateur-width">{{ $user->telephone }}</td>
                    <td class="orateur-width">{{ $user->nomEntreprise }}</td>
                    <td class="orateur-width">{{ $user->siren }}</td>
                    <td class="orateur-width">{{ $user->adresse }}</td>
                    <td class="action-width text-center">
                        {{--debut  supprimer--}}
                        <a href="{{ route('authorizeUserToAddHabitat',['idUser'=>$user->id]) }}"
                           data-toggle="confirmation" data-title="Souhaitez vous permettre à {{ $user->name }} d'ajouter des habitats sur Atypik-house.com ?"
                           data-btn-ok-label="Oui" data-btn-ok-class="btn-success" data-content="En appuyant sur 'oui', vous confirmez avoir vérifié l'existence de la société de {{ $user->name }}" data-btn-cancel-label="Annuler"
                           data-btn-cancel-class="btn-danger" >
                            <button class="btn btn-admin-success"> Autoriser </button>
                        </a>
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
