<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegisterSuccess(){
        $this->post('/api/users', [
            'username' => 'michael',
            'password' => 'rahasia',
            'name' => 'Michael Ananta'
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    'username' => 'michael',
                    'name' => 'Michael Ananta'
                ]
            ]);
    }
    public function testRegisterfailed(){
        $this->post('/api/users', [
            'username' => '',
            'password' => '',
            'name' => ''
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    'username' => [
                        "The username field is required."
                    ],
                    'password' => [
                        "The password field is required."
                    ],
                    'name' => [
                        "The name field is required."
                    ]
                ]
            ]);
    }
    public function testRegisterUsernameAlreadyExist(){
        $this->testRegisterSuccess();
        $this->post('/api/users', [
            'username' => 'michael',
            'password' => 'rahasia',
            'name' => 'Michael Ananta'
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    'username' => [
                        "username already registered"
                    ]
                ]
            ]);
    }
}
