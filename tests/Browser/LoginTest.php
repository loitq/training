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
     * A basic browser url not login.
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
     * A basic browser go to path admin dislay Login.
     * Case 1-2
     */
    public function testPathAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(config('contants.path.admin'))
                    ->assertPathIs(config('contants.path.login'));
        });
    }

    /**
     * A basic browser go to Forget passord.
     * case 1-3
     */
    public function testDisplayLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(config('contants.path.login'))
                    ->assertSee('Login');
        });
    }


    /**
     * Display login test forget password link.
     * Case 1-4
     */
    public function testForgetPasswordLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(config('contants.path.login'))
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/password/reset');
        });
    }

    /**
     * Display login test register link.
     * Case 1-5
     */
    public function testRegisterLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(config('contants.path.admin'))
                    ->clickLink('Register')
                    ->assertPathIs('/register');
        });
    }

    /**
     * Test login not input.
     * Case 1-6
     */
    public function testLoginNotInput()
    {
        $this->browse(function ($browser) {
            $browser->visit(config('contants.path.login'))
                    ->press('Login')
                    ->assertFocused('email');
        });
    }

    /**
     * Test email or password wrong input keep email.
     * Case 1-7
     */
    public function testUserWrong()
    {
        // Get user
        $user = User::find(2);
        $this->browse(function ($browser) use ($user) {
            $browser->visit(config('contants.path.login'))
                    ->type('email', $user->email)
                    ->type('password', 'abc@123')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records.')
                    ->assertInputValue('email', $user->email);
        });
    }

    /**
     * A basic browser test user login.
     * Case 2-1
     */
    public function testUserLogin()
    {
        // Get user
        $user = User::find(2);
        $this->browse(function ($browser) use ($user) {
            $browser->visit(config('contants.path.login'))
                    ->type('email', $user->email)
                    ->type('password', 'lifull@123')
                    ->press('Login')
                    ->assertPathIs('/');
        });
    }

    /**
     * A basic browser test user visit path admin.
     * Case 2-2
     */
    public function testUserVisitAdmin()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(2))
                    ->visit(config('contants.path.admin'))
                    ->assertPathIs('/');
        });
    }

    /**
     * A basic browser test admin login.
     * Case 2-3
     */
    public function testAdminLogin()
    {
        // Get Admin
        $user = User::find(1);

        $this->browse(function ($browser) use ($user) {
            $browser->visit(config('contants.path.login'))
                    ->type('email', $user->email)
                    ->type('password', 'lifull@123')
                    ->press('Login')
                    ->assertPathIs(config('contants.path.admin'));
        });
    }

    /**
     * A basic browser test admmin visit path /.
     * Case 2-4
     */
    public function testPathVisitUser()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/')
                    ->assertPathIs(config('contants.path.admin'));
        });
    }

    /**
     * A basic browser test user logout.
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
     * Test admin logout.
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
     * A basic browser user login, remove database, reload page.
     * Case 3-3
     */
    public function testUserLoginAfterRemoveData()
    {
        // Create data test
        $userDestroy = User::create([
            'name'     => "user destroy",
            'email'    => "usertest@lifull-tech.vn",
            'role'     => \App\User::USER,
            'password' => Hash::make("lifull@123")
        ]);
        // Login by data user test
        $this->browse(function ($browser) use ($userDestroy) {
            $browser->loginAs($userDestroy)
                    ->visit('/')
                    ->assertPathIs('/');
        });
        // Destroy user
        User::destroy($userDestroy->id);
        // Redirect path
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->assertPathIs(config('contants.path.login'));
        });
    }
}
