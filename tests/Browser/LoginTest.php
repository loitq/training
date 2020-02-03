<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class LoginTest extends DuskTestCase
{
    /**
    * A basic browser url not login.
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
    */
    public function testPathAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->assertPathIs('/login');
        });
    }

    /**
    * Display login test register link.
    */
    public function testRegisterLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Register')
                    ->assertPathIs('/register');
        });
    }

    /**
    * Display login test forget password link.
    */
    public function testForgetPasswordLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/password/reset');
        });
    }

    /**
    * A basic browser dislay Login.
    */
    public function testLinkForgetPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/password/reset');
        });
    }

    /**
    * A basic browser go to Forget passord.
    */
    public function testDisplayLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login');
        });
    }

    /**
    * Test email or password wrong input keep email.
    */
    public function testUserWrong()
    {
        // Get user
        $user = User::find(2); 
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'abc@123')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records.')
                    ->assertInputValue('email', $user->email);
        });
    }

    /**
    * Test login not input.
    */
    public function testLoginNotInput()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->press('Login')
                    ->assertFocused('email');
        });
    }

    /**
    * Test email invalid
    */
    public function testEmailInputInvalid()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'abc')
                    ->press('Login')
                    ->assertFocused('email');
        });
    }

    /**
    * A basic browser test user login.
    */
    public function testUserLogin()
    {
        // Get user
        $user = User::find(2);
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'lifull@123')
                    ->press('Login')
                    ->assertPathIs('/');
        });
    }

    /**
    * A basic browser test user visit path admin.
    */
    public function testUserVisitAdmin()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(2))
                    //->visit('/admin')
                    ->assertPathIs('/');
        });
    }

    /**
    * A basic browser test user logout.
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
    * A basic browser test admin login.
    */
    public function testAdminLogin()
    {
        // Get Admin
        $user = User::find(1);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'lifull@123')
                    ->press('Login')
                    ->assertPathIs('/admin');
        });
    }

    /**
    * A basic browser test admmin visit path /.
    */
    public function testPathVisitUser()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/')
                    ->assertPathIs('/admin');
        });
    }

    /**
    * Test admin logout.
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
    */
    public function testUserLoginAfterRemoveData()
    {
        // Call test user login
        $this->testUserLogin();
        // Destroy user
        User::destroy(2);
        // Redirect path
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->assertPathIs('/login');
        });

    }
}
