<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Array_;
use Tests\TestCase;

class HabitatTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
  /* public function testAddHabitat(){
       $user = User::create([
           'name'=>"Toto",
           'email'=>Str::random(6).'@gmail.com',
           'telephone'=>'0652415421',
           'adresse'=>'1 rue des pèche 93100, Montreuil',
           'password'=>bcrypt('p@ssW@RD'),
           'role'=>'user'
       ]);


       $user->canAddHabitat=1;
       $user->save();
       $accessToken = $user->createToken("authToken")->accessToken;
       $response = $this->withHeaders(['Authorization'=> 'Bearer  '.$accessToken])
                       ->json(
                       'POST',
                       'api/habitats/add',
                       [
                           'title'=>Str::random(20),
                           'description'=>Str::random(100),
                           'nombreChambre'=>2,
                           'prixParNuit'=>25,
                           'nombreLit'=>2,
                           'adresse'=>'64 allée Rue de boulets',
                           'hasTelevision'=>1, //utiliser des radios button "oui"=>1, "non"=>0
                           'hasClimatiseur'=>0,
                           'hasChauffage'=>1,
                           'hasInternet'=>1,
                           'typeHabitat'=>1,
                           'vues[]'=>'imagecreate('50',25)',
                       ]
                   );

       $response->assertStatus(201);
   } */

    public function testgetAllHabitat()
    {
        $response = $this->json(
            'GET',
            'api/habitats/getAll'
        );

        $response->assertStatus(200);
    }

}
