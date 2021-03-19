<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProprieteTypeHabitatValueResource;
class Habitat extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'description'=>$this->description,
            'nombreChambre'=>$this->nombreChambre,
            'prixParNuit'=>$this->prixParNuit,
            'nombreLit'=>$this->nombreLit,
            'adresse'=>$this->adresse,
            'hasTelevision'=>$this->hasTelevision,
            'hasClimatiseur'=>$this->hasClimatiseur,
            'hasChauffage'=>$this->hasChauffage,
            'hasInternet'=>$this->hasInternet,
            'proprietaire'=>$this->getProprietaire,
            'typeHabitat'=>$this->getType->libelle,
            'proprietes'=> ProprieteTypeHabitatValueResource::collection($this->proprieteTypeHabitatValues),
          /*  'proprietes' => $this->when(count( $this->proprieteTypeHabitatValues ),
                                        ProprieteTypeHabitatValueResource::collection($this->proprieteTypeHabitatValues)),*/

            'vues'=>$this->getVues
        ];
    }
}
