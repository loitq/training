<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use Hash;

class LoginTest extends DuskTestCase
{
    /**
     * Get data from cogfig to test.
     * @return array
     */
    public function getDatatTest()
    {
        return config('constants');
    }

    /**
     * Url not login.
     * case 1-1
     */
    public function testPathWrong()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/abc')
                    ->assertSee('404');
        });
    }

    /**
     * User not logged in go to path '/admin'
     * Case 1-2
     */
    public function testPathAdmin()
    {
        $data = $this->getDatatTest();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit($data['path']['admin'])
                    ->assertPathIs($data['path']['login']);
        });
    }

    /**
     * Test view login content
     * Case 1-3
     */
    public function testDisplayLogin()
    {
        $data = $this->getDatatTest();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->assertSee('Login');
        });
    }

    /**
     * Click forget passwork link
     * Case 1-4
     */
    public function testForgetPasswordLink()
    {
        $data = $this->getDatatTest();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/password/reset');
        });
    }

    /**
     * Test path register
     * Case 1-5
     */
    public function testRegisterLink()
    {
        $data = $this->getDatatTest();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->clickLink('Register')
                    ->assertPathIs('/register');
        });
    }

    /**
     * Login with email or password wrong
     * Case 1-6
     */
    public function testLoginNotInput()
    {
        $data = $this->getDatatTest();
        $this->browse(function ($browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->press('Login')
                    ->assertFocused('email');
        });
    }

    /**
     * Login with email or password wrong keep email login
     * Case 1-7
     */
    public function testUserWrong()
    {
        $data = $this->getDatatTest();
        $this->browse(function ($browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->type('email', $data['email']['user'])
                    ->type('password', 'abc@123')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records.')
                    ->assertInputValue('email', $data['email']['user']);
        });
    }

    /**
     * User login with email, password
     * Case 2-1
     */
    public function testUserLogin()
    {
        $data = $this->getDatatTest();
        $this->browse(function ($browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->type('email', $data['email']['user'])
                    ->type('password', 'lifull@123')
                    ->press('Login')
                    ->assertPathIs('/')
                    ->logout();
        });
    }

    /**
     * User logged in go to path '/admin'
     * Case 2-2
     */
    public function testUserVisitAdmin()
    {
        $data = $this->getDatatTest();
        $this->browse(function ($browser) use ($data) {
            $browser->loginAs(User::find(2))
                    ->visit($data['path']['admin'])
                    ->assertPathIs($data['path']['user'])
                    ->logout();
        });
    }

    /**
     * Admin login with email, password.
     * Case 2-3
     */
    public function testAdminLogin()
    {
        $data = $this->getDatatTest();
        $this->browse(function ($browser) use ($data) {
            $browser->logout()
                    ->visit($data['path']['login'])
                    ->type('email', $data['email']['admin'])
                    ->type('password', 'lifull@123')
                    ->press('Login')
                    ->assertPathIs($data['path']['admin']);
        });
    }

    /**
     * Admin logged go to path '/user'
     * Case 2-4
     */
    public function testPathVisitUser()
    {
        $data = $this->getDatatTest();
        $this->browse(function ($browser) use ($data) {
            $browser->loginAs(User::find(1))
                    ->visit($data['path']['user'])
                    ->assertPathIs($data['path']['admin']);
        });
    }

    /**
     * User logout.
     * Case 3-1
     */
    public function testUserLogout()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(2))
                    ->logout()
                    ->assertGuest();
        });
    }

    /**
     * Admin logout.
     * Case 3-2
     */
    public function testAdminLogout()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                    ->logout()
                    ->assertGuest();
        });
    }

    /**
     * User logged, after remove user logined, reload browser:
     * Case 3-3
     */
    public function testUserLoginAfterRemoveData()
    {
        $data = $this->getDatatTest();
        // Create data test
        $userDestroy = User::create([
            'name'     => "user destroy",
            'email'    => "usertest@lifull-tech.vn",
            'role'     => \App\User::USER,
            'password' => Hash::make("lifull@123")
        ]);
        // User login
        $this->browse(function ($browser) use ($data, $userDestroy) {
            $browser->loginAs($userDestroy)
                    ->visit($data['path']['user'])
                    ->assertPathIs($data['path']['user']);
        });
        // Remove user login in database
        User::destroy($userDestroy->id);
        // Reload brower
        $this->browse(function ($browser) use ($data) {
            $browser->visit($data['path']['user'])
                    ->assertPathIs($data['path']['login']);
        });
    }
}
