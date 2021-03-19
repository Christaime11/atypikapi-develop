<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeHabitat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "type_habitats";
    protected $fillable =  ['libelle'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Retourne tous les habitat de ce type
     */
    public function habitats(){
        return $this->hasMany('App\Models\Habitats', 'typeHabitat');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Retourne toutes les proprietes dynamiques rattachés à ce type d'habitats
     */
    public function proprieteTypeHabitats(){
        return $this->hasMany('App\Models\ProprieteTypeHabitat', 'typeHabitat');
    }


}
