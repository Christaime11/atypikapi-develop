<div class="modal fade" id="modalCoordonneesProrpietaire" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-admin-base d-flex justify-content-center text-white">
                <h5 class="modal-title" id="staticBackdropLabel" style="text-align: center!important;font-size: 18px">Coordonnées du Propriétaire</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span  class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12"> <span class="text-bold mr-2"> Nom :</span>  {{ $habitat->getProprietaire->name }} </div>
                    <div class="col-md-12"><span class="text-bold mr-2"> Téléphone : </span>  {{ $habitat->getProprietaire->telephone }} </div>
                    <div class="col-md-12"><span class="text-bold mr-2"> Email : </span>  {{ $habitat->getProprietaire->email }} </div>
                    <div class="col-md-12"><span class="text-bold mr-2"> Adresse :</span>  {{ $habitat->getProprietaire->adresse }} </div>
                </div>
            </div>
        </div>
    </div>
</div>

