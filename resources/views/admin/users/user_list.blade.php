@extends('admin.template')

@section('page_level_css')
    <link rel="stylesheet" href="{{asset('css/datable.css')}}"/>
@endsection

@section('content')
    <div class="pt-2">
        <div class="card p-2">
            <h3 class="text-bold text-center"> Liste des utilisateurs </h3>
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

    <div class="card p-3 mt-3">
        {{-- debut tableau --}}
        <table id="listeuser" class="display table table-bordered mt-5">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->telephone }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="text-center">
                            {{--debut  voir detail--}}
                            <a href="{{route('myprofil',['id'=>$user->id])}}" data-toggle="tooltip" data-placement="top" title="Voir ou modifier le profil de {{$user->name}}"><i class="fas fa-eye iconSize text-primary" ></i></a> &nbsp;
                            {{--fin  voir détail--}}

                            {{--debut  supprimer--}}
                                <a href="{{route('deleteUser',['id'=>$user->id])}}" 
                                data-toggle="confirmation" data-title="Voulez-vous vraiment supprimer {{$user->name}} ?"
                                data-btn-ok-label="Oui" data-btn-ok-class="btn-success" data-content="Toutes les informations le concernant serront supprimées" data-btn-cancel-label="Annuler"
                                data-btn-cancel-class="btn-danger" >
                                <i class="fas fa-trash-alt text-danger"></i>
                            </a>
                                &nbsp;
                                {{--fin  supprimer--}} 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- fin tableau --}}
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
        $('#listeuser').DataTable({
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
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
        });	
    </script>
@endsection