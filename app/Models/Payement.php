<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "payements";
    protected $fillable = ['montant', 'reservation', 'lienFacture'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Retourne la réservation pour laquelle cet payement a été fait
     */
    public function reservation(){
        return $this->belongsTo('App\Models\Reservation', 'reservation');
    }
}
