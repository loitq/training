<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
class UserTest extends DuskTestCase
{
    /**
     * Admin logged go to dashboard
     * Case 1-1
     */
    public function testLoginToPageAdmin()
    {
        $admin = User::where('email', 'loitq@lifull-tech.vn')->first();

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
     */
    public function testClickMenuToPageCreate()
    {
        $admin = User::where('email', 'loitq@lifull-tech.vn')->first();
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin')
                ->visit(
                    $browser->attribute('#link-create-user', 'href')
                )
                ->assertPathIs('/admin/user/create');
        });
    }

    /**
     * Admin redirect to page edit user
     * Case 1-3
     */
    public function testClickMenuToPageEdit()
    {
        $admin = User::where('role', \App\User::ROLE_ADMIN);
        $this->browse(function (Browser $browser) use ($admin){
            $idUser = 2;
            $browser
                ->visit('/admin/user/list')
                ->visit(
                    $browser->attribute('#link-update-user', 'href')
                )
                ->assertPathIs('/admin/user/edit/'. $idUser);
        });
    }
}

