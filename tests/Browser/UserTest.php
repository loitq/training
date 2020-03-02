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
     * Admin logged go to dashboard
     * case 1-1
     * @return void
     */
    public function testLoginToPageAdmin()
    {
        $admin = $this->accountAdmin();

        if (!$admin) {
            $admin = factory(User::class)->create([
                'email' => 'loitq@lifull-tech.vn',
                'password' => bcrypt('lifull@123'),
            ]);
        }

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                ->type('email', $admin->email)
                ->type('password', 'lifull@123')
                ->press('Login')
                ->assertPathIs('/admin');
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
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/user/list')
                ->click('@createUser')
                ->assertPathIs('/admin/user/create');
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
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/user/list')
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
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/user/list')
                ->click('@deleteModal2')
                ->waitFor('#myModal2')
                ->press('No')
                ->assertPathIs('/admin/user/list');
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
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/user/list')
                ->click('@deleteModal2')
                ->waitFor('#myModal2')
                ->press('Yes')
                ->waitForLocation('/admin/user/list')
                ->assertSee('Delete account success !');
        });
    }
}

