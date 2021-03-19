<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habitat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="habitats";

    protected $fillable = ['title','nombreChambre', 'prixParNuit', 'description', 'nombreLit',
        'adresse', 'hasTelevision', 'hasClimatiseur', 'hasChauffage',
        'hasInternet', 'valideParAtypik', 'proprietaire', 'typeHabitat'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * fonction établissant la relation
     * entre la table "Habitat" et "Commentaire"
     *
     * Permet de récupérer tous les commentaires d'un habitat donnée
     */
    public function commentaires(){
        return $this->hasMany("App\Models\Commentaire", "habitat");
    }

    /**
     * fonction établissant la relation entre la table "Habitat" et la table "ProprieteTypeHabitatValue"
     * Permet de récupérer tous les valeurs des propriété dynamiques d'un habitat
     */
    public function proprieteTypeHabitatValues() {
       return $this->hasMany('App\Models\ProprieteTypeHabitatValue', 'habitat');
    }

    /**
     * fonction établissant la relation entre la table "Reservation" et la table "Habitat"
     * Permet de récupérer toutes les réservations d'un habitat
     */
    public function getReservations(){
        return $this->hasMany("App\Models\Reservation");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Permet de récupérer la liste des vues d'un habitat
     */
    public function getVues(){
        return $this->hasMany('App\Models\Vue','habitat');
    }

    public function  getProprietaire(){
        return $this->belongsTo('App\Models\User',"proprietaire");
    }

    public function getType(){
        return $this->belongsTo('App\Models\TypeHabitat','typeHabitat');
    }
}
