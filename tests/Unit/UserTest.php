<?php

namespace Tests\Unit;

use Tests\Testcase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Permisson account admin
     *
     * @return $admin
     */
    public function accountAdmin()
    {
        $admin = factory(User::class)->create(['role' => \App\User::ADMIN]);
        $this->actingAs($admin);

        return $admin;
    }

    /**
     * Admin login to page user list
     *
     * @return void
     */
    public function testLinkToPageAdmin()
    {
        $admin = $this->accountAdmin();

        $response = $this->get('/admin/user/list');
        $response->assertStatus(200, $response->getStatusCode());
    }

    /**
     * Test function create user with all checkbox true
     *  case 2-1
     *
     * @return void
     */
    public function testCreateUserAllCheckboxTrue()
    {
        $admin = $this->accountAdmin();

        $params = [
            'email' => 'loitq1@lifull@tech.vn',
            'username' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_TRUE,
            'can_delete' => \App\User::IS_TRUE,
        ];

        $response = $this->post(route('admin.user.handleCreate'), $params)
            ->assertSessionHas('message', 'Create user success !')
            ->assertRedirect();
    }

    /**
     * Test function create user with checkbox can see true
     * case 2-2
     *
     * @return void
     */
    public function testCreateUserCheckboxCanSeeTrue()
    {
        $admin = $this->accountAdmin();

        $params = [
            'email' => 'loitq1@lifull@tech.vn',
            'username' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_TRUE,
            'can_delete' => \App\User::IS_FALSE,
        ];

        $response = $this->post(route('admin.user.handleCreate'), $params)
            ->assertSessionHas('message', 'Create user success !')
            ->assertRedirect();
    }

    /**
     * Test function create user with checkbox can delete true
     * case 2-3
     *
     * @return void
     */
    public function testCreateUserCheckboxCanDeleteTrue()
    {
        $admin = $this->accountAdmin();

        $params = [
            'email' => 'loitq1@lifull@tech.vn',
            'username' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_TRUE,
        ];

        $response = $this->post(route('admin.user.handleCreate'), $params)
            ->assertSessionHas('message', 'Create user success !')
            ->assertRedirect();
    }

    /**
     * Test function create user with all checkbox false
     * case 2-4
     *
     * @return void
     */
    public function testCreateUserAllCheckboxFalse()
    {
        $admin = $this->accountAdmin();

        $params = [
            'email' => 'loitq1@lifull@tech.vn',
            'username' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ];

        $response = $this->post(route('admin.user.handleCreate'), $params)
            ->assertSessionHas('message', 'Create user success !')
            ->assertRedirect();
    }

    /**
     * Test function create user with username empty
     * case 2-5
     *
     * @return void
     */
    public function testCreateUserFailWithUsernameEmpty()
    {
        $admin = $this->accountAdmin();

        $params = [
            'email' => 'loitq1@lifull@tech.vn',
            'username' => '',
            'password' => '123456',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ];

        $response = $this->post(route('admin.user.handleCreate'), $params);
        $response->assertStatus(302)
            ->assertSessionHasErrors('username');
    }

    /**
     * Test function create user with email empty
     * case 2-6
     *
     * @return void
     */
    public function testCreateUserWithEmailEmpty()
    {
        $admin = $this->accountAdmin();

        $params = [
            'email' => '',
            'username' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ];

        $response = $this->post(route('admin.user.handleCreate'), $params);
        $response->assertStatus(302)
            ->assertSessionHasErrors('email');
    }

    /**
     * Test function create user with password empty
     * case 2-7
     *
     * @return void
     */
    public function testCreateUserWithPasswordEmpty()
    {
        $admin = $this->accountAdmin();

        $params = [
            'email' => 'loitq1@lifull@tech.vn',
            'username' => 'Phan Tuan',
            'password' => '',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ];

        $response = $this->post(route('admin.user.handleCreate'), $params);
        $response->assertStatus(302)
            ->assertSessionHasErrors('password');
    }

    /**
     * Test function create user with all textbox empty
     * case 2-8
     *
     * @return void
     */
    public function testCreateUserWithAllTextboxEmpty()
    {
        $admin = $this->accountAdmin();

        $params = [
            'email' => '',
            'username' => '',
            'password' => '',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ];

        $response = $this->post(route('admin.user.handleCreate'), $params);
        $response->assertStatus(302)
            ->assertSessionHasErrors('email')
            ->assertSessionHasErrors('username')
            ->assertSessionHasErrors('password');
    }

    /**
     * Test function update user with checkbox can delete true
     * case 2-9
     *
     * @return void
     */
    public function testUpdateUserCheckboxCanDeleteTrue()
    {
        $admin = $this->accountAdmin();

        $params = [
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_TRUE,
        ];

        $user = factory('App\User')->create();
        $response = $this->post('admin/user/edit/'. $user->id, $params);
        $this->assertDatabaseHas('users', ['id'=> $user->id]);
        $response->getSession()->flash('message', 'Edit user success !');
    }

    /**
     * Test function update user with checkbox can see true
     * case 2-10
     *
     * @return void
     */
    public function testUpdateUserCheckboxCanSeeTrue()
    {
        $admin = $this->accountAdmin();

        $params = [
            'can_see' => \App\User::IS_TRUE,
            'can_delete' => \App\User::IS_FALSE,
        ];

        $user = factory('App\User')->create();
        $response = $this->post('admin/user/edit/'.$user->id, $params);
        $this->assertDatabaseHas('users', ['id'=> $user->id]);
        $response->getSession()->flash('message', 'Edit user success !');
    }

    /**
     * Test function update user with all checbox false
     * case 2-11
     *
     * @return void
     */
    public function testUpdateUserAllCheckboxFalse()
    {
        $admin = $this->accountAdmin();

        $params = [
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ];

        $user = factory('App\User')->create();
        $response = $this->post('admin/user/edit/'.$user->id, $params);
        $this->assertDatabaseHas('users', ['id'=> $user->id]);
        $response->getSession()->flash('message', 'Edit user success !');
    }

    /**
     * Test delete user with id not found
     * case 2-16
     *
     * @return void
     */
    public function testDeleteuserWithIdNotFound()
    {
        $admin = $this->accountAdmin();

        $user = factory(User::class)->create();
        $idNotFound = !($user->id);
        $response = $this->post('admin/user/delete/'. $idNotFound);
        $response->assertStatus(404);
    }
}
