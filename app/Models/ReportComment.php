<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportComment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "reports_comments";
    protected $fillable = [
        'description',
        'comment'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Retourne l'habitat sur lequel est effectué ce commentaire
     */
    public function habitat(){
        return $this->belongsTo('App\Models\Habitat','habitat');
    }
}
