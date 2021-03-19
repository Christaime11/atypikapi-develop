
@extends('admin.template')

@section('page_level_css')
    <link rel="stylesheet" href="{{asset('css/datable.css')}}"/>
@endsection
@php
    function habitatValidated($habitat){
        if( Request::route()->getName()=="getAllHabitat" && $habitat->valideParAtypik==1 ){
            return "yes";
        } elseif(Request::route()->getName()=="getAllHabitat" && $habitat->valideParAtypik!=1) {
            return "no";
        }
    }
@endphp
@section('content')
    <div class="pt-2">
        <div class="bg-white p-2">
            <h3 class="text-bold text-center">
                @if(Request::route()->getName()=="getAllHabitat")
                    Tous les Habitats
                @elseif( Request::route()->getName()=="getUnValidatedHabitat" )
                    Les Habitats en attente de validation
                @endif
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
        {{--debut indication validation --}}
        @if(Request::route()->getName()=="getAllHabitat")
            <div class="w-100 mb-4">
                <span class="admin-indication-validated" data-toggle="tooltip"
                      title="Les habitats validés sont visible sur le site atypik-house.com">
                </span> Habitats validés
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="admin-indication-unvalidated" data-toggle="tooltip"
                      title="Les habitats non validés ne sont pas visibles sur le site atypik-house.com">
                </span> Habitats en attente de validation

            </div>
        @endif
        {{--fin indication validation --}}

        {{-- debut tableau --}}
        <table  class="display table table-bordered mt-5" id="listetypehabitats">
            <thead>
            <tr>
                <th class="itteration-width">N°</th>
                <th class="image-width">Titre</th>
                <th class="image-width">Propriétaire</th>
                <th class="image-width">Type</th>
                <th class="image-width">Date d'ajout</th>
                <th class="action-width">Actions </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($habitats as $habitat)
                <tr>
                    <td class="itteration-width ">
                        <span class="@if(habitatValidated($habitat)=="yes") btn-admin-success
                                     @elseif(habitatValidated($habitat)=="no") btn-admin-danger @endif">
                            {{ $loop->iteration }}
                        </span>
                    </td>
                    <td class="image-width">{{ $habitat->title }}</td>
                    <td class="image-width">{{ $habitat->getProprietaire->name }}</td>
                    <td class="image-width">{{ $habitat->getType->libelle }}</td>
                    <td class="image-width">{{ \Carbon\Carbon::parse($habitat->created_at)->format('d/m/Y à  H:i')}}</td>
                    <td class="action-width text-center">
                        {{-- debut  voir les details--}}
                        <a href="{{ route('getDetailHabitat', ['idHabitat'=>$habitat->id]) }}" data-toggle="tooltip" data-placement="top" title="cliquer pour voir les détails">
                            <button class="btn btn-admin-primary">
                                <i class="far text-primary fa-eyes"></i> Voir les détails
                            </button>&nbsp;
                        </a>
                        {{--fin  voir détail --}}
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
                 aria: {
                    sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            }
        });

    </script>
@endsection
