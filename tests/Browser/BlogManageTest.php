<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BlogManageTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp() :void
    {
        parent::setUp();
        $this->artisan('db:seed --class=UserTableTestAddUserSeeder');
        $this->artisan('db:seed --class=BlogTableTestAddBlogSeeder');
    }

    /**
     * Get data from cogfig to test.
     * @return array
     */
    public function getDataTest()
    {
        return config('constants');
    }
    
    /**
     * User browser login blog
     *
     * @return void
     */
    function LoginBlog($user, $data)
    {
        return $this->browse(function ($browser) use ($user, $data) {
            $browser->visit($data['path']['login'])
                    ->loginAs($user)
                    ->visit($data['path']['blog']);

            return $browser;
        });
    }

    /**
     * Test login blog with user can see blog.
     * case 1.1: Test screen Blog list
     *
     * @return void
     */
    public function testLoginBlog()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->assertPathIs($data['path']['blog']);
        });
    }

    /**
     * Test popup create blog with user can see blog.
     * case 1.2: Test popup Create blog
     *
     * @return void
     */
    public function testShowPopupCreateBlog()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) {
            $browser->press('Create Blog')
                    ->waitFor('#createModal')
                    ->assertPresent('#createModal');
        });
    }

    /**
     * Test screen Edit blog by user.
     * case 1.3: Edit blog: Test screen Edit blog by user
     *
     * @return void
     */
    public function testScreenEditBlog()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) {
            $browser->assertSee('user can see title b')
                    ->click('#blog-edit-2')
                    ->assertPathIs('/blog/2/edit')
                    ->assertSeeIn('#blog_id','user can see title b')
                    ->assertSeeIn('#blog-content', 'content');
        });
    }

    /**
     * Test screen delete blog by user.
     * case 1.4: Delete blog: Test screen delete blog by user
     *
     * @return void
     */
    public function testScreenDeleteBlog()
    {
        $user = $this->userCanSeeAndDelete();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) {
            $browser->click('#blog-delete-5')
                    ->waitFor('#deleteModal5')
                    ->assertSee('Delete this blog?');
        });
    }

    /**
     * Blog list have not permission see blog
     * case 1.5: Blog list have not permission see blog
     *
     * @return void
     */
    public function testBlogListUseHaveNotPermissionSeeBlog()
    {
        $user = $this->userCannotSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->assertPathIs($data['path']['user'])
                    ->assertSee("you can't to enter blog manage");
        });
    }

    /**
     * Blog list: User have not permission delete blog
     * case 1.6: Blog list: User have not permission delete blog
     *
     * @return void
     */
    public function testBlogListUseHaveNotPermissionDeleteBlog()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($user, $data) {
            $browser->assertDontSee('Delete');
        });
    }

    /**
     * Test Enter url not defined in route
     * case 1.7: Enter url not defined in route
     *
     * @return void
     */
    public function testLoginUrlNotExist()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $this->browse(function ($browser) use ($user, $data) {
            $browser->loginAs($user)
                    ->visit('/urlkhongtontai')
                    ->assertSeeIn('.code','404')
                    ->assertSeeIn('.message', 'Not Found');
        });
    }

    /**
     * Test create blog with user can see blog.
     * case 2.1: Create blog: Fill all input
     *
     * @return void
     */
    public function testCreateBlogFillAllInput()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->press('Create Blog')
                    ->waitFor('#createModal')
                    ->type('title', 'Lốc bụi cao 650 m trên sao Hỏa')
                    ->script("CKEDITOR.instances['blog-content'].setData('content');");
                    
            $browser->waitForText('Submit')
                    ->press('Submit')
                    ->waitForLocation($data['path']['blog'])
                    ->assertSee('Create new blog success !')
                    ->assertSee('Lốc bụi cao 650 m trên sao Hỏa');
        });
    }

    /**
     * Test create blog with user can see blog.
     * case 2.2: Create blog: Fill all input but fill in title less than 5 characters
     * Error
     *
     * @return void
     */
    public function testCreateBlogFillTitleLessThan5Character()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->press('Create Blog')
                    ->waitFor('#createModal')
                    ->type('title', 'Lốc')
                    ->script("CKEDITOR.instances['blog-content'].setData('content');");

            $browser->waitForText('Submit')
                    ->press('Submit')
                    ->waitForLocation($data['path']['blog'])
                    ->assertSee('The title must be at least 5 characters.')
                    ->assertDontSee('Lốc');
        });
    }

    /**
     * Test create blog with user can see blog.
     * case 2.3: Create blog: Fill all input but fill in title over 100 characters
     * Error
     *
     * @return void
     */
    public function testCreateBlogFillTitleOver100Character()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($user, $data) {
            //string over 100 character
            $textTitleOver100 = str_repeat('a', 101);

            $browser->press('Create Blog')
                    ->waitFor('#createModal')
                    ->type('title', $textTitleOver100)
                    ->script("CKEDITOR.instances['blog-content'].setData('content');");

            $browser->waitForText('Submit')
                    ->press('Submit')
                    ->waitForLocation($data['path']['blog'])
                    ->assertSee('The title may not be greater than 100 characters.')
                    ->assertDontSee($textTitleOver100);
        });
    }

    /**
     * Test create blog with user can see blog.
     * case 2.4: Create blog: Do not fill input
     * Error
     *
     * @return void
     */
    public function testCreateBlogDoNotFillInput()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($user, $data) {
            $browser->press('Create Blog')
                    ->waitFor('#createModal')
                    ->waitForText('Submit')
                    ->press('Submit')
                    ->waitForLocation($data['path']['blog'])
                    ->assertSee('The title field is required.')
                    ->assertSee('The content field is required.');
        });
    }

    /**
     * Test create blog with user can see blog.
     * case 2.5: - Create blog: Content input empty
     * Error
     *
     * @return void
     */
    public function testCreateBlogContentInputEmpty()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->press('Create Blog')
                    ->waitFor('#createModal')
                    ->type('title', 'Các lệnh git cơ bản')
                    ->waitForText('Submit')
                    ->press('Submit')
                    ->waitForLocation($data['path']['blog'])
                    ->assertSee('The content field is required.')
                    ->assertDontSee('Các lệnh git cơ bản');
        });
    }

    /**
     * Test create blog with user can see blog.
     * case 2.6: - Create blog: Title input empty
     * Error
     *
     * @return void
     */
    public function testCreateBlogTitleInputEmpty()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->press('Create Blog')
                    ->waitFor('#createModal')
                    ->type('title', '')
                    ->script("CKEDITOR.instances['blog-content'].setData('content');");

            $browser->waitForText('Submit')
                    ->press('Submit')
                    ->waitForLocation($data['path']['blog'])
                    ->assertSee('The title field is required.');
        });
    }

    /**
     * Edit blog.
     * case 2.7: Edit blog: Fill all input
     *
     * @return void
     */
    public function testEditBlogFillAllInput()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->assertSee('user can see title b')
                    ->click('#blog-edit-2')
                    ->waitForLocation('/blog/2/edit')
                    ->type('title', 'user can see title b edit')
                    ->script("CKEDITOR.instances['content'].setData('content edit');");
            $browser->press('Submit')
                    ->assertPathIs($data['path']['blog'])
                    ->assertSee('Update blog success!')
                    ->assertSee('user can see title b edit');
        });
    }

     /**
     * Edit blog.
     * case 2.8: Edit blog: Title and content input empty
     *
     * @return void
     */
    public function testEditBlogTitleAndContentEmpty()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) {
            $browser->click('#blog-edit-2')
                    ->waitForLocation('/blog/2/edit')
                    ->type('title', '')
                    ->script("CKEDITOR.instances['content'].setData('');");
            $browser->press('Submit')
                    ->assertPathIs('/blog/2/edit')
                    ->assertSee('The title field is required.')
                    ->assertSee('The content field is required.');
        });
    }

    /**
     * Edit blog.
     * case 2.9: Edit blog: Content input empty
     *
     * @return void
     */
    public function testEditBlogContentEmpty()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) {
            $browser->click('#blog-edit-2')
                    ->waitForLocation('/blog/2/edit')
                    ->type('title', 'user can see title b edit')
                    ->script("CKEDITOR.instances['content'].setData('');");
            $browser->press('Submit')
                    ->assertPathIs('/blog/2/edit')
                    ->assertSee('The content field is required.');
        });
    }

    /**
     * Edit blog.
     * case 2.10: Edit blog: Title input empty
     *
     * @return void
     */
    public function testEditBlogTitleEmpty()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) {
            $browser->click('#blog-edit-2')
                    ->waitForLocation('/blog/2/edit')
                    ->type('title', '')
                    ->script("CKEDITOR.instances['content'].setData('content edit');");
            $browser->press('Submit')
                    ->assertPathIs('/blog/2/edit')
                    ->assertSee('The title field is required.');
        });
    }

    /**
     * Edit blog.
     * case 2.11: Edit blog: Blog not found
     *
     * @return void
     */
    public function testEditBlogNotFound()
    {
        $user = $this->userCanSeeAndDelete();
        $data = $this->getDataTest();
        $this->browse(function ($browser1, $browser2) use ($user, $data) {
            $browser1->loginAs($user)
                    ->visit($data['path']['blog']);

            $browser2->loginAs($user)
                    ->visit($data['path']['blog'])
                    ->click('#blog-delete-4')
                    ->waitFor('#deleteModal4')
                    ->press('Confirm')
                    ->waitForLocation($data['path']['blog'])
                    ->waitForText('Delete blog success !');

            $browser1->click('#blog-edit-4')
                    ->assertSee('Blog not found !');
        });
    }

    /**
     * Edit blog.
     * case 2.12: Edit blog: Not change anything.
     *
     * @return void
     */
    public function testEditBlogNotChangeAnything()
    {
        $user = $this->userCanSee();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->click('#blog-edit-2')
                    ->waitForLocation('/blog/2/edit')
                    ->press('Submit')
                    ->assertPathIs($data['path']['blog'])
                    ->assertSee('Update blog success!');
        });
    }
    
    /**
     * Test delete blog by user.
     * case 2.13: Delete blog: Confirm
     *
     * @return void
     */
    public function testDeleteBlogConfirm()
    {
        $user = $this->userCanSeeAndDelete();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->assertSee('user can delete title c')
                    ->click('#blog-delete-6')
                    ->waitFor('#deleteModal6')
                    ->press('Confirm')
                    ->waitForLocation($data['path']['blog'])
                    ->assertSee('Delete blog success !')
                    ->assertDontSee('user can delete title c');
        });
    }

    /**
     * Test delete blog by user.
     * case 2.14: Delete blog: Click close popup
     *
     * @return void
     */
    public function testDeleteBlogClickClosePopup()
    {
        $user = $this->userCanSeeAndDelete();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->assertSee('user can delete title b')
                    ->click('#blog-delete-5')
                    ->waitFor('#deleteModal5')
                    ->press('Close')
                    ->assertPathIs($data['path']['blog'])
                    ->assertSee('user can delete title b');
        });
    }

    /**
     * Test delete blog by user.
     * case 2.15: Delete blog: Click outside popup
     *
     * @return void
     */
    public function testDeleteBlogClickOusitePopup()
    {
        $user = $this->userCanSeeAndDelete();
        $data = $this->getDataTest();
        $browser = $this->LoginBlog($user, $data);
        $this->browse(function ($browser) use ($data) {
            $browser->assertSee('user can delete title b')
                    ->click('#blog-delete-5')
                    ->waitFor('#deleteModal5')
                    ->click('#wrapper')
                    ->assertPathIs($data['path']['blog'])
                    ->assertSee('user can delete title b');
        });
    }

    /**
     * Delete blog.
     * case 2.16: Delete blog:  Blog not found
     *
     * @return void
     */
    public function testDeleteBlogNotFound()
    {
        $user = $this->userCanSeeAndDelete();
        $data = $this->getDataTest();
        $this->browse(function ($browser1, $browser2) use ($user, $data) {
            $browser1->loginAs($user)
                    ->visit($data['path']['blog'])
                    ->assertSee('user can delete title b')
                    ->click('#blog-delete-4')
                    ->waitFor('#deleteModal4');

            $browser2->loginAs($user)
                    ->visit($data['path']['blog'])
                    ->assertSee('user can delete title b')
                    ->click('#blog-delete-4')
                    ->waitFor('#deleteModal4')
                    ->press('Confirm')
                    ->waitForLocation($data['path']['blog'])
                    ->waitForText('Delete blog success !');

            $browser1->press('Confirm')
                    ->waitForLocation($data['path']['blog'])
                    ->assertSee('Blog not found !');
        });
    }
}
