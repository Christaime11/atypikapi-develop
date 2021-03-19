<div class="modal fade" id="modalModifTypeHabitatModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-admin-base d-flex justify-content-center text-white">
                <h5 class="modal-title" id="staticBackdropLabel" style="text-align: center!important;font-size: 18px">Modification Proriété type Habitat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span  class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modificationPropiereTypeHabitatForm" method="POST" action="{{ route('updateProrieteTypeHabitat', ['prorieteTypeHabitateId'=>':id']) }}" class="w-100">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="name" class="col-md-4 col-form-label ml-n3">Libelle</label>
                            <input id="libelleModif" type="text" class="form-control{{ $errors->has('libelle') ? ' is-invalid' : '' }}" name="libelle" value="" required autofocus>

                            @if ($errors->has('libelle'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('libelle') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="name" class="col-md-4 col-form-label  ml-n3"> Type Habitat </label>
                            <select id="typeHabitatModif"  class="form-control{{ $errors->has('typeHabitat') ? ' is-invalid' : '' }}" name="typeHabitat"  required >
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

                    <div class="form-group row mt-3">
                        <div class="col-md-12">
                            <label for="descriptionModif"> Description </label>
                            <textarea class="form-control" name="description" id="descriptionModif" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-0 justify-content-center">
                        <div class="col-md-6">
                            <button type="submit" class=" btn btn-admin-success w-75">
                                <i class="fas fa-check"></i> Modifier
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

