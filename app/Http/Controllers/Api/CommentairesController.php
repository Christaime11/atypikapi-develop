<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Habitat as HabitatResource;
use App\Models\Commentaire;
use App\Models\Habitat;
use App\Models\ReportComment;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
    public function addComment(Request $request, $idHabitat): JsonResponse
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
        if (count($reservationsExists) == 0) {
            return response()->json([
                'error' => 'Vous ne pouvez pas ajouter un commentaire car vous n\'avez jamais réservé ce habitat'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'contenu' => 'required',
            'note' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Erreur de validation des données',
                'validationErrors' => $validator->errors()
            ], 400);
        }

        $commentaire = Commentaire::create([
            'auteur' => Auth::id(),
            'habitat' => $idHabitat,
            'note' => $request->note,
            'contenu' => $request->contenu,
            'detail_habitat' => json_encode(new HabitatResource($habitat)),
        ]);

        if (empty($commentaire)) {
            return response()->json([
                'error' => 'Erreur interne survenue',
                'inputValues' => $request->all()
            ], 500);
        } else {
            return response()->json([
                'message' => "Commentaire rajouté",
            ], 200);
        }

        /**
         * AllUserReservation.
         * If this Habitat_id can be found in aLL uSERrESERVATION then
         * "UserCanAddComment" = true
         */
    }

    public function getAllComments(): JsonResponse
    {
        $comments = Commentaire::all();
        if ($comments->isEmpty()) {
            return response()->json([
                'error' => 'Aucun Commentaire trouvé'
            ], 404);
        }

        return response()->json([
            'success' => 'success',
            'commentaires' => $comments
        ], 200);
    }

    // Owner
    public function getAllCommentsOfOwner(): JsonResponse
    {
        $comments = Commentaire::where("detail_habitat->proprietaire->id", Auth::id())->get();

        if ($comments->isEmpty()) {
            return response()->json([
                'error' => 'Aucun Commentaire trouvé'
            ], 404);
        }

        return response()->json([
            'success' => 'success',
            'commentaires' => $comments
        ], 200);
    }

    public function getCommentsOfOneHabitat($habitat_id): JsonResponse
    {
        $comments = Commentaire::where('habitat', $habitat_id)->get();
        if ($comments->isEmpty()) {
            return response()->json([
                'error' => 'Aucun Commentaire trouvé'
            ], 404);
        }

        return response()->json([
            'success' => 'success',
            'commentaires' => $comments
        ], 200);
    }

    // Admin
    public function deleteAComment($comment_id): JsonResponse
    {
        $comment = Commentaire::find($comment_id);
        if (!$comment) {
            return response()->json([
                'error' => 'Commentaire introuvable'
            ], 404);
        }

        if (Auth::id() != $comment->auteur && Auth::user()->role != env('ADMIN_ROLE')) {
            return response()->json([
                'error' => 'Vous n\'êtes pas autorisé a effectuer cette opération'
            ], 404);
        }

        $isDeleted = $comment->delete();

        if ($isDeleted) {
            return response()->json([
                'success' => 'Commentaire supprimé avec succès !'
            ]);
        } else {
            return response()->json([
                'error' => 'Une erreur est survenue lors de la suppression ; Veuillez reéessayer !'
            ]);
        }
    }

    public function editAComment(Request $request, $comment_id): JsonResponse
    {
        $comment = Commentaire::find($comment_id);

        if (empty($comment)) {
            return response()->json([
                'error' => 'Aucun commentaire ne correspond à l\'id : ' . $comment_id
            ], 404);
        }

        if (Auth::id() != $comment->auteur) {
            return response()->json([
                'error' => 'Vous n\'êtes pas l\'auteur du commentaire. Vous n\'êtes pas autorisé à effectuer cette action'
            ], 403);
        } else {
            $validation = Validator::make($request->all(), [
                'note' => 'required',
                'contenu' => 'required',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'error' => 'Veuillez vérifier les données saisies',
                    'validationErrors' => $validation->errors()
                ], 400);
            }

            $comment->note = $request->note;
            $comment->contenu = $request->contenu;


            $isSaved = $comment->save();
            if ($isSaved) { // si l'habitat est bien enregisté en bd
                return response()->json([
                    'success' => 'Commentaire modifié avec succès !',
                    'habitat' => $request->all()
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Erreur lors de l\'enregistrement des modifications',
                    'inputs' => $request->all()
                ], 500);
            }
        }
    }

    public function reportAComment(Request $request, $comment_id): JsonResponse
    {
        $comment = Commentaire::find($comment_id);

        if (!$comment) {
            return response()->json([
                'error' => 'Commentaire introuvable'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Erreur de validation des données',
                'validationErrors' => $validator->errors()
            ], 400);
        }

        $report = ReportComment::create([
            'description' => $request->description,
            'comment' => $comment_id,
        ]);

        if (empty($report)) {
            return response()->json([
                'error' => 'Erreur interne survenue',
                'inputValues' => $request->all()
            ], 500);
        } else {
            $comment->reported = 1;
            $isSaved = $comment->save();
            if ($isSaved) {
                return response()->json([
                    'success' => "Commentaire reporté",
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Erreur lors du report du commentaire',
                    'inputs' => $comment->all()
                ], 500);
            }
        }
    }

    // Admin
    public function getAllCommentReports(): JsonResponse
    {
        $reports = ReportComment::all();

        if (Auth::user()->role != env('ADMIN_ROLE')) {
            return response()->json([
                'error' => 'Vous n\'êtes pas autorisé a effectuer cette opération'
            ], 404);
        }

        if ($reports->isEmpty()) {
            return response()->json([
                'error' => 'Aucun signalement de commentaire trouvé'
            ], 404);
        }

        return response()->json([
            'success' => 'success',
            'commentaires' => $reports
        ], 200);
    }

}
