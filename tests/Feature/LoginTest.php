<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
    * test url is not login.
    **/
    public function testUrlIsNotLogin()
    {
        $response = $this->get('/abc');
        $response->assertSee('404');
    }

    /**
    * Not login go to path admin.
    **/
    public function testFirstPathAdmin()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('login');
    }

    /**
    * A basic feature test user view login.
    **/
    public function testViewLogin()
    {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
    }

    // /**
    // * Feature test user wrong
    // **/
    // public function testUserWrong()
    // {
    //     $response = $this->from('/login')->post('/login', [
    //         'email' => 'user@lifull-tech.vn',
    //         'password' => 'invalid-password'
    //     ]);
    //     $response->assertViewIs('auth.login');
    //     $response->assertSee('These credentials do not match our records.');
    //     $response->assertSessionHasErrors('email');
    //     $this->assertTrue(session()->hasOldInput('email'));
    //     $this->assertFalse(session()->hasOldInput('password'));
    //     $this->assertGuest();
    // }

    /**
    * Test user login.
    */
    public function testUserLogin()
    {
        $user = User::find(1);

        $response = $this->post('/login', [
            'email' => 'user@lifull-tech.vn',
            'password' => Hash::make('lifull@123'),
            '_token' => csrf_token()
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }
}
