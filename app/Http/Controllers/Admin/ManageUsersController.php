<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserCanNowAddHabitat;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    public function usersWhoWanToAddHabitat(){
        $usersWhoWanToAddHabitat = User::where(["wantToAddHabitat"=>1, "canAddHabitat"=>0])->latest()->paginate(10);
        return view("admin.users.user_who_want_to_add_habitat",['usersWhoWanToAddHabitat'=> $usersWhoWanToAddHabitat]);
    }

    public function authorizeUserToAddHabitat( $idUser ){
        $user = User::find($idUser);
        if( empty($user) ){
            return back()->with([
                "errorNotification"=>"Utilisateur inexistant !"
            ]);
        } else {
            $user->canAddHabitat = 1;
            $isSaved = $user->save();

            if( $isSaved ){
                $user->notify( new UserCanNowAddHabitat());
                return back()->with([
                    "successNotification" => "Vous avez autorisé ".$user->name." à ajouter des habitats !"
                ]);
            } else {
                return back()->with([
                    "successNotification" => "Une erreur est survenue : votre autorisation n'à pas pu être prise en compte. Veuillez réessayer !"
                ]);
            }
        }
    }

    public function unAuthorizeUserToAddHabitat( $idUser ){
        $user = User::find($idUser);
        if( empty($user) ){
            return back()->with([
                "errorNotification"=>"Utilisateur inexistant !"
            ]);
        } else {
            $user->canAddHabitat = 0;
            $isSaved = $user->save();

            if( $isSaved ){
                return back()->with([
                    "successNotification" => "Modification effectué avec succès. Dorénavant".$user->name."ne pourra plus à ajouter des habitats !"
                ]);
            } else {
                return back()->with([
                    "successNotification" => "Une erreur est survenue : votre modification n'à pas pu être prise en compte. Veuillez réessayer !"
                ]);
            }
        }
    }
}
