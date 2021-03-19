<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vue extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $table = "vues";
    protected $fillable = ['lienImage', 'legende', 'habitat' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Permet de récupérer la vue à laquelle est rattachée cette image
     */
    public function habitat(){
        return $this->belongsTo('App\Models\Habitat','habitat');
    }
}
