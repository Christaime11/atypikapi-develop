<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commentaire extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "commentaires";
    protected $fillable = [
        'contenu',
        'auteur',
        'habitat'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * fonction établissant la relation entre la table Commentaire et Users
     *
     * Retourne l'auteur d'un commentaire
     */
    public function auteur(){
        return $this->belongsTo('App\Models\User', 'auteur');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Retourne l'habitat sur lequel est effectué ce commentaire
     */
    public function habitat(){
        return $this->belongsTo('App\Models\Habitat','habitat');
    }
}
