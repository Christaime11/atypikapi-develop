<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test l'enregistrement d'un nouvel utilisateur
     *
     * @return void
     */
    public function testRegister()
    {
        $response = $this->json(
            "POST",
            'api/register',
            [
                'name'=>"Toto",
                'email'=>Str::random(6).'@gmail.com',
                'telephone'=>'0652415421',
                'adresse'=>'1 rue des pèche 93100, Montreuil',
                'password'=>'p@ssW@RD',
                'password_confirmation'=>'p@ssW@RD'
            ],);

        $response->assertStatus(201);
    }

    public function testLogin(){
        $response = $this->json(
            'POST',
            'api/login',
            [
                'email'=>'toto@gmail.com',
                'password'=>'p@ssW@RD',
            ]
        );

        $response->assertStatus(200);
    }
}
