<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProprieteTypeHabitatValue extends Model
{
    use HasFactory;

    protected $table = "propriete_type_habitatat_values";
    protected $fillable = ['propriete_type_habitat', 'habitat', 'value'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Permet de récupérer la prorité rataché à cette valeur
     */
    public  function  proprieteTypeHabitat(){
        return $this->belongsTo('App\Models\ProprieteTypeHabitat','propriete_type_habitat');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Permet de récupérer l'habitat rataché à cette valeur
     */
    public function habitat(){
        return $this->belongsTo('App\Models\Habitat','habitat');
    }
}
