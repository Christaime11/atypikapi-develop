<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Habitat;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Habitat as HabitatResource;


class ReservationController extends Controller
{
    public function addReservation(Request $request, $idHabitat)
    {
        $habitat = Habitat::find($idHabitat);
        if (empty($habitat) || $habitat->valideParAtypik != 1) {
            return response()->json([
                'error' => 'Réservation impossible : Habitat inexistant'
            ], 404);
        }

        if (Auth::id() == $habitat->getProprietaire->id) {
            return response()->json([
                'error' => 'Vous ne pouvez pas réserver ce habitat, vous en êtes le propriétaire.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'nbrOccupant' => 'required|integer|min:1',
            'dateArrivee' => 'required|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
            'dateDepart' => 'required|date_format:Y-m-d|after_or_equal:dateArrivee',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Erreur de validation des données',
                'validationErrors' => $validator->errors()
            ], 400);
        }

        $validatedData = $validator->validated();
        $dateArrivee = Carbon::parse($validatedData['dateArrivee']);
        $dateDepart = Carbon::parse($validatedData['dateDepart']);

        //On vérifie si il y a déjà une réservation
        //pour cette période
        $reservations = Reservation::where([ //réservation peut être en cours ou future
            'habitat_id' => $idHabitat,
            'dateArrivee' => $dateArrivee->format('Y-m-d'),
            'dateDepart' => $dateDepart->format('Y-m-d'),
        ])
            ->orWhere([ //réservation en cours
                ['habitat_id', "=", $idHabitat],
                ['dateArrivee', '<=', Carbon::now()->format('Y-m-d')],
                ['dateDepart', '>=', Carbon::now()->format('Y-m-d')],
                ['dateDepart', '>=', $dateArrivee->format('Y-m-d')]
            ])->get();

        if (count($reservations) > 0) {
            return response()->json([
                'habitatIndisponible' => [
                    'dateArrivee' => $dateArrivee->format('Y-m-d'),
                    'dateDepart' => $dateDepart->format('Y-m-d')
                ]

            ], 400);
        }

        $nbrTotalDeNuits = $dateDepart->diffInDays($dateArrivee);
        if ($nbrTotalDeNuits == 0) {
            $this->nbrTotalDeNuits = 1;
        }

        $prixParNuit = $habitat->prixParNuit;
        $montantTotal = $prixParNuit * $nbrTotalDeNuits;


        $reservation = Reservation::create([
            'locataire' => Auth::id(),
            'habitat_id' => $habitat->id,
            'detail_habitat' => json_encode(new HabitatResource($habitat)),
            'nbrOccupant' => $request->nbrOccupant,
            'montantTotal' => $montantTotal,
            'dateArrivee' => $dateArrivee,
            'dateDepart' => $dateDepart,
        ]);

        if (empty($reservation)) {
            return response()->json([
                'error' => 'Erreur interne survenue',
                'inputValues' => $request->all()
            ], 500);
        } else {
            return response()->json([
                'id' => $reservation->id,
                'nombreTotalDeNuit' => $nbrTotalDeNuits,
                'montantTotal' => $montantTotal,
            ], 200);
        }
    }

    public function getAllMyReservations()
    {
        $reservations = Reservation::where('locataire', Auth::id())->latest()->paginate(10);
        if (count($reservations) == 0) {
            return response()->json([
                'error' => 'Vous n\'avez aucune réservation'
            ], 404);
        } else {
            return response()->json([
                'reservations' => $reservations
            ], 200);
        }
    }

    public function getReservationDetails($idReservation)
    {
        $reservation = Reservation::find($idReservation);
        if (empty($reservation)) {
            return response()->json([
                'error' => 'Réservation inexistante'
            ], 404);
        } else {
            if (Auth::id() != $reservation->locataire) {
                return response()->json([
                    'error' => 'Accès refusé'
                ], 403);

            } else {
                return response()->json([
                    'reservation' => $reservation
                ], 200);
            }
        }
    }

    public function autoCancelReservation($idReservation)
    {
        $reservation = Reservation::find($idReservation);
        if (empty($reservation)) {
            return response()->json([
                'error' => 'Réservation inexistante'
            ], 404);
        } else {
            $reservation->forceDelete();
            return response()->json([
                'success' => 'Réservation annulée'
            ], 200);
        }
    }

    //@TODO public function generatePdf( $idReservation )

    // Shows all the reservations
    public function getAllReservation()
    {
        $reservations = Reservation::all()->get();
        if (count($reservations) == 0) {
            return response()->json([
                'error' => 'Aucune réservation trouvée'
            ], 404);
        } else {
            return response()->json([
                'reservations' => $reservations
            ], 200);
        }
    }

    // Shows all the reservations of the owner
    public function getAllTheReservationOnMyhabitats()
    {
        $reservations = Reservation::where("detail_habitat->proprietaire->id", Auth::id())->get();
        if (count($reservations) == 0) {
            return response()->json([
                'error' => 'Aucune réservation trouvée'
            ], 404);
        } else {
            return response()->json([
                'reservations' => $reservations
            ], 200);
        }
    }

    //@TODO public function cancelReservation (for owner)

    public function makePayement($idReservation)
    {
        $reservation = Reservation::find($idReservation);
        if (empty($reservation)) {
            return response()->json([
                'error' => 'Réservation inexistante'
            ], 404);
        } else {
            $reservation->payementEffectue = 1;
            $reservation->save();
            //@Todo generatePdf()
            return response()->json([
                'success' => 'Payement effectué. Vous recevrez la facture de votre réservation par mail.'
                //@Todo 'lienFacture'=>''
            ], 200);
        }
    }

}
