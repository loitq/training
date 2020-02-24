<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\Testcase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testLinkToPageAdmin()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->get('/admin/user/list');
        $response->assertStatus(200 , $response->getStatusCode());
    }
    /**
    * @Test function create user with all checkbox true
    *  case 2-1
    */
    public function testCreateUserAllCheckboxTrue()
    {
        $user = factory(User::class)->create([
            'email' => 'loitq1@lifull@tech.vn',
            'name' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_TRUE,
            'can_delete' => \App\User::IS_TRUE,
        ]);

        $this->post('admin.user.handleCreate',$user->toArray());

        $this->assertEquals(1,User::all()->count());
    }

    /** 
    * @Test function create user with checkbox can see true
    * 2-2
    */
    public function testCreateUserCheckboxCanSeeTrue()
    {
        $user = factory(User::class)->create([
            'email' => 'loitq@lifull@tech.vn',
            'name' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_TRUE,
            'can_delete' => \App\User::IS_FALSE,
        ]);

        $this->post('admin.user.handleCreate',$user->toArray());
 
        $this->assertEquals(1,User::all()->count());
    }

    /** 
    * @Test function create user with checkbox can delete true
    * 2-3
    */
    public function testCreateUserCheckboxCanDeleteTrue()
    {
        $user = factory(User::class)->create([
            'email' => 'loitq@lifull@tech.vn',
            'name' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_TRUE,
        ]);

        $this->post('admin.user.handleCreate',$user->toArray());
 
        $this->assertEquals(1,User::all()->count());
    }

    /** 
    * @Test function create user with all checkbox false
    * 2-4
    */
    public function testCreateUserAllCheckboxFalse()
    {
        $user = factory(User::class)->create([
            'email' => 'loitq1@lifull@tech.vn',
            'name' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ]);

        $this->post('admin.user.handleCreate',$user->toArray());
 
        $this->assertEquals(1,User::all()->count());
    }

    /** 
    * @Test function create user with username empty
    * 2-5
    */
    public function testCreateUserFailWithUsernameEmpty()
    {
        $user = factory(User::class)->create([
            'email' => 'loitq1@lifull@tech.vn',
            'name' => '',
            'password' => '123456',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ]);

        $this->post('admin.user.handleCreate',$user->toArray());

        $this->assertFalse(is_null($user->name));
    }

    /** 
    * @Test function create user with email empty
    * 2-6
    */
    public function testCreateUserWithEmailEmpty()
    {
        $user = factory(User::class)->create([
            'email' => '',
            'name' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ]);

        $this->post('admin.user.handleCreate',$user->toArray());

        $this->assertFalse(is_null($user->email));
    }

    /** 
    * @Test function create user with password empty
    * 2-7
    */
    public function testCreateUserWithPasswordEmpty()
    {
        $user = factory(User::class)->create([
            'email' => '',
            'name' => 'Phan Tuan',
            'password' => '123456',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ]);

        $this->post('admin.user.handleCreate',$user->toArray());

        $this->assertFalse(is_null($user->password));
    }

    /** 
    * @Test function create user with all textbox empty
    * 2-8
    */
    public function testCreateUserWithAllTextboxEmpty()
    {
        $user = factory(User::class)->create([
            'email' => '',
            'name' => '',
            'password' => '',
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ]);

        $this->post('admin.user.handleCreate',$user->toArray());

        $this->assertFalse(is_null($user->email));
        $this->assertFalse(is_null($user->name));
        $this->assertFalse(is_null($user->password));
    }

    /** 
    * @Test function update user with checkbox can delete true
    * 2-9
    */
    public function testUpdateUserCheckboxCanDeleteTrue()
    {
        $data = [
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_TRUE,
        ];
        $user = factory('App\User')->create();
        $this->post('user/edit'.$user->id, $data);
        $this->assertDatabaseHas('users',['id'=> $user->id]);
    }

    /** 
    * @Test function update user with checkbox can see true
    * 2-10
    */
    public function testUpdateUserCheckboxCanSeeTrue()
    {
        $data = [
            'can_see' => \App\User::IS_TRUE,
            'can_delete' => \App\User::IS_FALSE,
        ];
        $user = factory('App\User')->create();
        $this->post('user/edit'.$user->id, $data);
        $this->assertDatabaseHas('users',['id'=> $user->id]);
    }

    /** 
    * @Test function update user with all checbox false
    * 2-11
    */
    public function testUpdateUserAllCheckboxFalse()
    {
        $data = [
            'can_see' => \App\User::IS_FALSE,
            'can_delete' => \App\User::IS_FALSE,
        ];
        $user = factory('App\User')->create();
        $this->post('user/edit'.$user->id, $data);
        $this->assertDatabaseHas('users',['id'=> $user->id]);
    }

    /**
    * @Test function update user with all checbox true
    * 2-13
    */
    public function testUpdateUserAllCheckboxTrue()
    {
        $data = [
            'can_see' => \App\User::IS_TRUE,
            'can_delete' => \App\User::IS_TRUE,
        ];
        $user = factory('App\User')->create();
        $this->post('user/edit'.$user->id, $data);
        $this->assertDatabaseHas('users',['id'=> $user->id]);
    }

    /**
    * @Test function delete user 
    * case 2-14
    */
    public function testDeleteUser()
    {
        $user = factory(User::class)->create();
        $this->post('/user/delete/'. $user->id);
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'deleted_at' => null]);
    }
}
