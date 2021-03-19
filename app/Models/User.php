<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'adresse',
        'role',
        'wantToAddHabitat',
        'canAddHabitat',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
        'role',
        'siren',
        'nomEntreprise'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Permet de récupérer tous les habitats ajoutés par un utilisateur
     */
    public function getHabitats(){
        return $this->hasMany('App\Models\Habitat', 'proprietaire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Permet de récuprérer toutes les réservations effectuées par un utilisateurs
     */
    public function getReservations(){
        return $this->hasMany('App\Models\Reservation','locataire');
    }
}
