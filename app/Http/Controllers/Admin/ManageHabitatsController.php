<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProprieteTypeHabitat;
use App\Models\TypeHabitat;
use App\Models\Habitat;
use App\Notifications\HabitatValidated;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ManageHabitatsController extends Controller
{
 /*
 * ----------------------------------
 * début gestion type habitats
 */

    public function listTypeHabitat()
    {
        $typeHabitats = TypeHabitat::latest()->paginate(20);
        return view('admin.habitat.liste_type_habitats', compact("typeHabitats"));
    }

    public function addTypeHabitat(Request $request)
    {
        $request->validate([
            'libelle' => 'string|required|unique:type_habitats'
        ]);
        $typeHabitatCreated = TypeHabitat::create([
            'libelle' => $request->libelle,
        ]);

        //si ça a été bien créé
        if (!empty($typeHabitatCreated)) {
            return back()->with([
                'successNotification' => 'Le type habitat "' . $typeHabitatCreated->libelle . '" a été créé avec succeess'
            ]);
        } else {
            return back()->with([
                'errorNotification' => 'Le type habitat "' . $request->libelle . '" n\'a pas pu être ajouté. Veuillez réessayer !'
            ]);
        }
    }

    public function updateTypeHabitat(Request $request, $idTypeHabitat)
    {
        $request->validate([
            'libelle' => 'string|required|unique:type_habitats'
        ]);
        $typeHabitat = TypeHabitat::find($idTypeHabitat);
        if (empty($typeHabitat)) {
            return back()->with([
                'errorNotification' => 'Modification interrompue : Type Habitat inexistant !'
            ]);
        } else {
            $typeHabitat->libelle = $request->libelle;
            $isSaved = $typeHabitat->save();

            if ($isSaved) {
                return back()->with([
                    'successNotification' => 'Type Habitat modifié avec succès !'
                ]);
            } else {
                return back()->with([
                    'errorNotification' => 'Une erreur est survenue lors de la modification ; Veuillez reéessayer !'
                ]);
            }
        }
    }

    public function deleteTypeHabitat($idTypeHabitat)
    {
        $typeHabitat = TypeHabitat::find($idTypeHabitat);
        if (empty($typeHabitat)) {
            return back()->with([
                'errorNotification' => 'Suppression interrompue : Type Habitat inexistant !'
            ]);
        } else {
            if( count( $typeHabitat->proprieteTypeHabitats ) >0)  {

                return back()->with([
                    'errorNotification' => 'Le type habitat "'. $typeHabitat->libelle.'"est associé à des propriétés dynamiques. Veuillez d\'abord supprimer les propriétés dynamique
                     ou les associer à un autre type'
                ]);
            }
            $isDeleted = $typeHabitat->delete();
            $IdtypeNonCategorise =  TypeHabitat::where('libelle', env('DEFAULT_TYPE_HABITAT') )->first()->id;
            //tous les habitat qui avaient ce type sont
            //rajouté au types non catégorisés

            if ( $isDeleted ) {

                $isUpdated = Habitat::where('typeHabitat', $idTypeHabitat)->update(['typeHabitat'=>$IdtypeNonCategorise]);

                if( !$isUpdated ){
                    Log::alert('Type habitat "'.$typeHabitat->libelle.'" supprimé mais les habitats concernés n\'ont pas pu être rajouté
                     aux habitats nont catégorisé
                     ');
                }

                return back()->with([
                    'successNotification' => 'Type Habitat supprimé avec succès !'
                ]);
            } else {
                return back()->with([
                    'errorNotification' => 'Une erreur est survenue lors de la suppression ; Veuillez reéessayer !'
                ]);
            }
        }
    }
/*
 * fin gestion type habitats
 * ----------------------------------
 */


/*
* ----------------------------------
* début gestion  habitats
*/
    public function getAllHabitat()
    {
        $habitats = Habitat::latest()->get();
        return view("admin.habitat.liste_habitats", ['habitats' => $habitats]);
    }


    /**
     * Retourne tous les habitats qui ont été ajouté
     * par les utilisateurs mais qui n'ont pas encore été
     * validé
     */
    public function getUnValidatedHabitat()
    {
        $habitats = Habitat::Where("valideParAtypik", 0)->latest()->get();
        return view("admin.habitat.liste_habitats", ['habitats' => $habitats]);
    }

    public function getDetailHabitat($idHabitat)
    {
        $habitat = Habitat::find($idHabitat);
        if (empty($idHabitat)) {
            abort('404', 'Habitat non trouvé !');
        } else {
            return view('admin.habitat.details_habitat', ['habitat' => $habitat]);
        }
    }

    public function validateHabitat($idHabitat)
    {
        $habitat = Habitat::find($idHabitat);

        if (empty($idHabitat)) {
            abort('404', 'Habitat non trouvé !');
        } else {
            $habitat->valideParAtypik = 1;
            $isSaved = $habitat->save();

            if ($isSaved) {
                $habitat->getProprietaire->notify( new HabitatValidated($habitat->id));
                return back()->with('successNotification', 'Habitat validé !');
            } else {
                return back()->with('errorNotification', 'Une erreur est survenue lors de la validation de l\'habitat. Veuillez réessayer !');
            }
        }
    }

    public function unValidateHabitat($idHabitat)
    {
        $habitat = Habitat::find($idHabitat);

        if (empty($idHabitat)) {
            abort('404', 'Habitat non trouvé !');
        } else {
            $habitat->valideParAtypik = 0;
            $isSaved = $habitat->save();

            if ($isSaved) {
                return back()->with('successNotification', 'Validation de l\'Habitat annulé !');
            } else {
                return back()->with('errorNotification', 'Une erreur est survenue lors de  l\'annnulation de la validation de l\'habitat. Veuillez réessayer !');
            }
        }
    }
/*
 * fin gestion habitats
 * ----------------------------------
 */






/*
* ----------------------------------
* début gestion propriété dynamiques
*/
    public function listProrieteTypeHabitat(){
        $allTypeHabitat = TypeHabitat::where('libelle','!=', env('DEFAULT_TYPE_HABITAT'))->latest()->paginate(20);
        $allProrieteTypeHabitat =  ProprieteTypeHabitat::all();

        return view('admin.habitat.liste_propriete_type_habitats', [
            'allTypeHabitat'=>$allTypeHabitat,
            'allProrieteTypeHabitat'=>$allProrieteTypeHabitat,
        ]);
    }


    public function addProrieteTypeHabitat(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string',
            'description' => 'required|string',
            'typeHabitat' => 'required|string',
        ]);

        $prorieteTypeHabitat = ProprieteTypeHabitat::create([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'typeHabitat' => TypeHabitat::find($request->typeHabitat)->id,
        ]);

        if (empty($prorieteTypeHabitat)) {
            return back()->with([
                'errorNotification' => 'La propriété ' . $request->libelle . ' n\'a pu être ajouté. Veuillez réessayer !'
            ]);
        }

        return back()->with([
            'successNotification' => 'La propriété ' . $request->libelle . ' a été ajouté avec succès pour le type habitat "' . TypeHabitat::find($request->typeHabitat)->libelle . '"'
        ]);
    }

    public function updateProrieteTypeHabitat(Request $request, $prorieteTypeHabitateId)
    {
        $prorieteTypeHabitat = ProprieteTypeHabitat::find($prorieteTypeHabitateId);

        if (empty($prorieteTypeHabitat)) {
            return back()->with([
                'errorNotification' => 'La propriété ayant l\'id ' . $prorieteTypeHabitateId . 'n\'existe pas'
            ]);
        }

        $request->validate([
            'libelle' => 'required|string',
            'description' => 'required|string',
            'typeHabitat' => 'required|string',
        ]);

        $prorieteTypeHabitat->libelle = $request->libelle;
        $prorieteTypeHabitat->description = $request->description;
        $prorieteTypeHabitat->typeHabitat = $request->typeHabitat;

        $isSaved = $prorieteTypeHabitat->save();

        if (!$isSaved) {
            return back()->with([
                'errorNotification' => 'Une erreur interne s\'est produite. Veuillez réessayer'
            ]);
        }

        return back()->with([
            'successNotification' => 'La propriété ' . $prorieteTypeHabitat->libelle . ' a été bien modifié'
        ]);
    }

    public function deleteProrieteTypeHabitat( $prorieteTypeHabitateId ){
        $prorieteTypeHabitat = ProprieteTypeHabitat::find($prorieteTypeHabitateId);
        if ( empty($prorieteTypeHabitat) ) {
            return back()->with([
                'errorNotification' => 'La propriété ayant l\'id ' . $prorieteTypeHabitateId . 'n\'existe pas'
            ]);
        }

        $prorieteTypeHabitat->delete();

        return back()->with([
            'successNotification' => 'La propriété ' . $prorieteTypeHabitat->libelle . ' a été bien supprimé'
        ]);

    }
    /*
     * fin gestion proriété dynamiques
     * ----------------------------------
     */

}
