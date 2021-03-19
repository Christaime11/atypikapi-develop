<div class="modal fade" id="modalModifTypeHabitatModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-admin-base d-flex justify-content-center text-white">
                <h5 class="modal-title" id="staticBackdropLabel" style="text-align: center!important;font-size: 18px">Modification type Habitat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span  class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modificationTypeHabitatForm" method="POST" action="{{ route('updateTypeHabitat', ['idTypeHabitat'=>':id']) }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Libelle</label>

                        <div class="col-md-6">
                            <input id="libelleModif" type="text" class="form-control{{ $errors->has('libelle') ? ' is-invalid' : '' }}" name="libelle" value="" required autofocus>

                            @if ($errors->has('libelle'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('libelle') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class=" btn btn-admin-success ">
                                <i class="fas fa-check"></i> Modifier
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

