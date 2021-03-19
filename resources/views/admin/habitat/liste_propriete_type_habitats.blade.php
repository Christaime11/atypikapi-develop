@extends('admin.template')

@section('page_level_css')
    <link rel="stylesheet" href="{{asset('css/datable.css')}}"/>
@endsection

@section('content')
    <div class="pt-2">
        <div class="bg-white p-2">
            <h3 class="text-bold text-center">
                Toutes les propriété dynamiques
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

    {{--debut formulaire ajout --}}
    <button class="btn mt-3 btn-admin-success" type="button" data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseExample">
        Afficher le  formulaire d'ajout <i class="fas fa-angle-down"></i>
    </button>

    <div class="bg-white p-3 pt-0 mt-2  collapse" id="collapseForm">
        <form  method="POST" action="{{ route('addProrieteTypeHabitat') }}" class="w-75 m-auto" >
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="name" class="col-md-4 col-form-label ml-n3">Libelle</label>
                    <input id="name" type="text" class="form-control{{ $errors->has('libelle') ? ' is-invalid' : '' }}" name="libelle" value="{{ old('libelle') }}" required autofocus>

                    @if ($errors->has('libelle'))
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('libelle') }}</strong>
                            </span>
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="typeHabitat" class="col-md-4 col-form-label ml-n3">Type Habitat</label>
                    <select   class="form-control{{ $errors->has('typeHabitat') ? ' is-invalid' : '' }}" name="typeHabitat"  required >
                        @foreach($allTypeHabitat as $typeHabitat)
                            <option value="{{$typeHabitat->id}}"> {{$typeHabitat->libelle}} </option>
                        @endforeach
                    </select>

                    @if ($errors->has('typeHabitat'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('typeHabitat') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="description">Description :</label>
                    <textarea class="form-control" name="description"  cols="30" rows="10"></textarea>
                </div>

                @if ($errors->has('typeHabitat'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('typeHabitat') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class=" w-75 btn btn-admin-success ">
                        <i class="fas fa-check"></i> Ajouter une nouvelle proriété
                    </button>
                </div>
            </div>
        </form>
    </div>
    {{--fin formulaire ajout --}}

    <div class="bg-white p-3 mt-2">
        {{-- debut tableau --}}
        <table  class="display table table-bordered mt-5" id="listetypehabitats">
            <thead>
            <tr>
                <th class="itteration-width">N°</th>
                <th class="image-width">Libelle</th>
                <th class="image-width">Description</th>
                <th class="image-width">Type habitat</th>
                <th class="action-width">Actions </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($allProrieteTypeHabitat as $propriete)
                <tr>
                    <td class="itteration-width"> {{ $loop->iteration }} </td>
                    <td class="image-width">{{ $propriete->libelle }}</td>
                    <td class="image-width">{{ $propriete->description }}</td>
                    <td class="image-width">{{ $propriete->getTypeHabitat->libelle }}</td>
                    <td class="action-width text-center">
                        {{-- debut  voir detail + modification--}}
                        <span onclick="modifyProprieteTypeHabitat( '{{$propriete->id}}', '{{$propriete->libelle}}', '{{$propriete->description}}', '{{$propriete->getTypeHabitat->id}}' )"
                              data-toggle="tooltip" data-placement="top" title="modifier ce type habitat"><i class="far text-primary fa-edit"></i></span> &nbsp;
                        {{--fin  voir détail --}}
                        {{--debut  supprimer--}}
                        <a href="{{ route('deleteProrieteTypeHabitat',['prorieteTypeHabitateId'=>$propriete->id]) }}"
                           data-toggle="confirmation" data-title="Voulez-vous vraiment supprimer cette propriété ? "
                           data-btn-ok-label="Oui" data-btn-ok-class="btn-success" data-content="" data-btn-cancel-label="Annuler"
                           data-btn-cancel-class="btn-danger" >
                            <i class="fas fa-trash-alt text-danger"></i>
                        </a>
                        {{--fin  supprimer--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{-- fin tableau --}}

        {{--start modal modification--}}
        @include("admin.habitat.modal_modif_propriete_type_habitat")
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
        function modifyProprieteTypeHabitat(id, libelle, description, typehabitat){
            var form = $("#modificationPropiereTypeHabitatForm");
            let action = form.attr("action").replace(":id",id);
            form.attr("action",action)

            $("#libelleModif").val(libelle);
            $("#descriptionModif").val(description);

            $("#typeHabitatModif option").each(function(){
                if( $(this).val() == typehabitat){
                    $(this).attr('selected', 'selected');
                }
            })

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
