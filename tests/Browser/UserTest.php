<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
class UserTest extends DuskTestCase
{
    /**
     * Permisson account admin
     *
     * @return $admin
     */
    public function accountAdmin()
    {
        $admin = User::where('email', 'loitq@lifull-tech.vn')->first();

        return $admin;
    }

    /**
     * Get data from cogfig to test.
     * 
     * @return array
     */
    public function getDataTest()
    {
        return config('constants');
    }

    /**
     * Admin logged go to dashboard
     * case 1-1
     * @return void
     */
    public function testLoginToPageAdmin()
    {
        $admin = $this->accountAdmin();
        $data = $this->getDataTest();

        if (!$admin) {
            $admin = factory(User::class)->create([
                'email' => $data['email']['admin'],
                'password' => bcrypt('lifull@123'),
            ]);
        }

        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser->visit($data['path']['login'])
                ->type('email', $data['email']['admin'])
                ->type('password', 'lifull@123')
                ->press('Login')
                ->assertPathIs($data['path']['admin']);
        });
    }

    /**
     * Admin redirect to page create user
     * Case 1-2
     * 
     * @return void
     */
    public function testClickMenuToPageCreate()
    {
        $admin = $this->accountAdmin();
        $data = $this->getDataTest();

        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser->loginAs($admin)
                ->visit($data['path']['listUser'])
                ->click('@createUser')
                ->assertPathIs($data['path']['createUser']);
        });
    }

    /**
     * Admin redirect to page edit user
     * Case 1-3
     * 
     * @return void
     */
    public function testClickMenuToPageEdit()
    {
        $admin = $this->accountAdmin();
        $data = $this->getDataTest();

        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser->loginAs($admin)
                ->visit($data['path']['listUser'])
                ->click('@editUser2')
                ->assertPathIs('/admin/user/edit/2');
        });
    }

    /**
     * Admin delete user
     * case 2-15
     *
     * @return void
     */
    public function testPopupDeleteUserPressNoButton()
    {
        $admin = $this->accountAdmin();
        $data = $this->getDataTest();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser->loginAs($admin)
                ->visit($data['path']['listUser'])
                ->click('@deleteModal2')
                ->waitFor('#myModal2')
                ->press('No')
                ->assertPathIs($data['path']['listUser']);
        });
    }

    /**
     * Admin delete user
     * case 1-4 + 2.12
     *
     * @return void
     */
    public function testPopupDeleteUser()
    {
        $admin = $this->accountAdmin();
        $data = $this->getDataTest();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser->loginAs($admin)
                ->visit($data['path']['listUser'])
                ->click('@deleteModal2')
                ->waitFor('#myModal2')
                ->press('Yes')
                ->waitForLocation($data['path']['listUser'])
                ->assertSee('Delete account success !');
        });
    }
}

