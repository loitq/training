<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
<<<<<<< HEAD
<<<<<<< HEAD
use Hash;
=======
>>>>>>> 09edd17... login, logout test
=======
use Hash;
>>>>>>> be9773b... add case test

class LoginTest extends DuskTestCase
{
    /**
<<<<<<< HEAD
     * Get data from cogfig to test.
     * @return array
     */
    public function getDataTest()
    {
        return config('constants');
    }

    /**
     * Url not login.
     * case 1-1
     */
=======
    * A basic browser url not login.
    */
>>>>>>> 09edd17... login, logout test
    public function testPathWrong()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/abc')
                    ->assertSee('404');
        });
    }

    /**
<<<<<<< HEAD
     * User not logged in go to path admin
     * Case 1-2
     */
    public function testPathAdmin()
    {
        $data = $this->getDataTest();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit($data['path']['admin'])
                    ->assertPathIs($data['path']['login']);
=======
    * A basic browser go to path admin dislay Login.
    */
    public function testPathAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->assertPathIs('/login');
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * Test view login content
     * Case 1-3
     */
    public function testDisplayLogin()
    {
        $data = $this->getDataTest();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->assertSee('Login');
=======
    * Display login test register link.
    */
    public function testRegisterLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Register')
                    ->assertPathIs('/register');
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * Click forget passwork link
     * Case 1-4
     */
    public function testForgetPasswordLink()
    {
        $data = $this->getDataTest();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit($data['path']['login'])
=======
    * Display login test forget password link.
    */
    public function testForgetPasswordLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
>>>>>>> 09edd17... login, logout test
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/password/reset');
        });
    }

    /**
<<<<<<< HEAD
     * Test path register
     * Case 1-5
     */
    public function testRegisterLink()
    {
        $data = $this->getDataTest();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->clickLink('Register')
                    ->assertPathIs('/register');
=======
    * A basic browser dislay Login.
    */
    public function testLinkForgetPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/password/reset');
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * Login with email or password wrong
     * Case 1-6
     */
    public function testLoginNotInput()
    {
        $data = $this->getDataTest();
        $this->browse(function ($browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->press('Login')
                    ->assertFocused('email');
=======
    * A basic browser go to Forget passord.
    */
    public function testDisplayLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login');
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * Login with email or password wrong keep email login
     * Case 1-7
     */
    public function testUserWrong()
    {
        $data = $this->getDataTest();
        $this->browse(function ($browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->type('email', $data['email']['user'])
                    ->type('password', 'abc@123')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records.')
                    ->assertInputValue('email', $data['email']['user']);
=======
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
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * User login with email, password
     * Case 2-1
     */
    public function testUserLogin()
    {
        $data = $this->getDataTest();
        $this->browse(function ($browser) use ($data) {
            $browser->visit($data['path']['login'])
                    ->type('email', $data['email']['user'])
=======
    * A basic browser test user login.
    */
    public function testUserLogin()
    {
        // Get user
        $user = User::find(2);
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
>>>>>>> 09edd17... login, logout test
                    ->type('password', 'lifull@123')
                    ->press('Login')
                    ->assertPathIs('/');
        });
    }

    /**
<<<<<<< HEAD
     * User logged in go to path admin
     * Case 2-2
     */
    public function testUserVisitAdmin()
    {
        $data = $this->getDataTest();
        $this->browse(function ($browser) use ($data) {
            $browser->loginAs(User::find($data['userId']))
                    ->visit($data['path']['admin'])
                    ->assertPathIs($data['path']['user'])
                    ->tearDown();
=======
    * A basic browser test user visit path admin.
    */
    public function testUserVisitAdmin()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(2))
                    ->visit('/admin')
                    ->assertPathIs('/');
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * Admin login with email, password.
     * Case 2-3
     */
    public function testAdminLogin()
    {
        $data = $this->getDataTest();
        $this->browse(function ($browser) use ($data) {
            $browser->logout()
                    ->visit($data['path']['login'])
                    ->type('email', $data['email']['admin'])
                    ->type('password', 'lifull@123')
                    ->press('Login')
                    ->assertPathIs($data['path']['admin']);
=======
    * A basic browser test user logout.
    */
    public function testUserLogout()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(2))
                    ->logout()
                    ->assertGuest();
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * Admin logged go to path user
     * Case 2-4
     */
    public function testPathVisitUser()
    {
        $data = $this->getDataTest();
        $this->browse(function ($browser) use ($data) {
            $browser->loginAs(User::find($data['adminId']))
                    ->visit($data['path']['user'])
                    ->assertPathIs($data['path']['admin'])
                    ->tearDown();
=======
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
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * User logout.
     * Case 3-1
     */
    public function testUserLogout()
    {
        $data = $this->getDataTest();
        $this->browse(function ($browser) use ($data) {
            $browser->loginAs(User::find($data['userId']))
                    ->visit('/')
                    ->click('.dropdown')
                    ->waitFor('.dropdown-menu.show')
                    ->clickLink('Logout')
                    ->assertPathIs($data['path']['login']);
=======
    * A basic browser test admmin visit path /.
    */
    public function testPathVisitUser()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/')
                    ->assertPathIs('/admin');
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * Admin logout.
     * Case 3-2
     */
    public function testAdminLogout()
    {
        $data = $this->getDataTest();
        $this->browse(function ($browser) use ($data){
            $browser->loginAs(User::find($data['adminId']))
                    ->visit('/admin')
                    ->click('.dropdown')
                    ->waitFor('.dropdown-menu.show')
                    ->clickLink('Logout')
                    ->assertPathIs($data['path']['login']);
=======
    * Test admin logout.
    */
    public function testAdminLogout()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                    ->logout()
                    ->assertGuest();
>>>>>>> 09edd17... login, logout test
        });
    }

    /**
<<<<<<< HEAD
     * User logged, after remove user logined, reload browser:
     * Case 3-3
     */
    public function testUserLoginAfterRemoveData()
    {
        $data = $this->getDataTest();
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
        // Redirect path user
        $this->browse(function ($browser) use ($data) {
            $browser->visit($data['path']['user'])
                    ->assertPathIs($data['path']['login']);
        });
=======
    * A basic browser user login, remove database, reload page.
    */
    public function testUserLoginAfterRemoveData()
    {
        // Create data test
        $userDestroy = User::create([
            'name'     => "user destroy",
            'email'    => "usertest@lifull-tech.vn",
            'role'     => \App\User::USER,
            'password' => Hash::make("lifull@123"),
        ]); 
        // Login by data user test
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'lifull@123')
                    ->press('Login')
                    ->assertPathIs('/admin');
        });
        // Destroy user
        User::destroy(2);
        // Redirect path
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->assertPathIs('/login');
        });

>>>>>>> 09edd17... login, logout test
    }
}
