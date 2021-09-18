<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    protected $casts = [
        'habitat' => 'array'
    ];
    use HasFactory;
    use SoftDeletes;

    protected $table = "reservations";
    protected $fillable = ['locataire',
                           'habitat_id',
                           'detail_habitat',
                           'nbrOccupant',
                           'montantTotal',
                           'payementEffectue',
                           'lienfacture',
                           'dateArrivee',
                           'dateDepart',];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Permet de récupérer le futur locataire qui effectue la réservation
     */
    public function locataire(){
        return $this->belongsTo('App\Models\User','locataire');
    }




}
