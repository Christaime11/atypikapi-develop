<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Habitat as HabitatResource;
use App\Models\Commentaire;
use App\Models\Habitat;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentairesController extends Controller
{
    /**
     * Je vérifie si l'habitat est parmi les reservations de l'utilisateurs
     * Si oui j'ajoute le commentaire (Note sur 5 et descrition)
     * Si non je renvoir une erreur JSON
     **/
    public function addComment(Request $request, $idHabitat)
    {
        $userReservations = Reservation::where('locataire', Auth::id())->latest()->paginate(10);
        if (count($userReservations) == 0) {
            return response()->json([
                'error' => 'Vous n\'avez aucune réservation'
            ], 404);
        }

        $habitat = Habitat::find($idHabitat);
        if (empty($habitat) || $habitat->valideParAtypik != 1) {
            return response()->json([
                'error' => 'Réservation impossible : Habitat inexistant ou non validé'
            ], 404);
        }

        $reservationsExists = Reservation::where('locataire', Auth::id())->where('habitat_id', $idHabitat)->get();
        if (!empty($reservationsExists)) {
            return response()->json([
                'error' => 'Vous ne pouvez pas ajouter un commentaire car vous n\'avez jamais réservé ce habitat'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'contenu' => 'required',
            'note' => 'required',
        ]);

        if( $validator->fails() ){
            return response()->json([
                'error'=>'Erreur de validation des données',
                'validationErrors'=>$validator->errors()
            ],400);
        }

        $commentaire =  Commentaire::create([
            'auteur' =>Auth::id(),
            'habitat'=>$idHabitat,
            'note' => $request->note,
            'contenu' => $request->contenu
        ]);

        if ( empty($commentaire) ){
            return response()->json([
                'error'=>'Erreur interne survenue',
                'inputValues'=>$request->all()
            ],500);
        } else {
            return response()->json([
                'message'=>"Commentaire rajouté",
            ],200);
        }


        /*else {
            return response()->json([
                'reservations'=>$reservations
            ],200);
        }*/

        /**
         * AllUserReservation.
         * If this Habitat_id can be found in aLL uSERrESERVATION then
         * "UserCanAddComment" = true*/
    }

    public function getAllcomments()
    {
        $comments =  Commentaire::all();
        if( $comments->isEmpty() ) {
            return response()->json([
                'error'=>'Aucun Commentaire trouvé'
            ], 404);
        }

        return response()->json([
            'success'=>'success',
            'commentaires'=>$comments
        ],200);
    }

    // Admin route
    public function getcommentsOfOneHabitat($habitat_id){

    }

    // User route
    public function deleteAComment($habitat_id){

    }

    // User route
    public function editAComment($habitat_id){

    }

}
