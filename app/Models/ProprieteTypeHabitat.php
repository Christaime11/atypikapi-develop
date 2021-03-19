<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProprieteTypeHabitat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "propriete_type_habitats";
    protected $fillable = ['libelle', 'description', 'typeHabitat'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Retourne le type d'habitat pour lequel cette propriété est définie
     */
    public function  getTypeHabitat(){
        return $this->belongsTo('App\Models\TypeHabitat', 'typeHabitat');
    }
}
