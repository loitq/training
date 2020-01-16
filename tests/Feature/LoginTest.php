<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
    * A basic feature test user view login.
    **/
    public function testViewLogin()
    {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
    }

    /**
    * A basic feature test user view login.
    **/
    public function testViewLogin()
    {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
    }
}
