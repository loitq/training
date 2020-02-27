<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;
use App\User;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    public $passwordDefault = 'lifull@123';

    /**
     * Create user can see blog.
     *
     * @return $user
     */
    public function userCanSee()
    {
        $user = User::where('name', '=', 'user_can_see')->first();
        
        return $user;
    }

    /**
     * Create user can't see blog.
     *
     * @return $user
     */
    public function userCannotSee()
    {
        $user = User::where('name', '=', 'user_can_not_see')->first();
        
        return $user;
    }

    /**
     * Create user can see and delete blog
     *
     * @return $user
     */
    public function userCanSeeAndDelete()
    {
        $user = User::where('name', '=', 'user_can_see_delete')->first();
        
        return $user;
    }

    /**
     * Create user can see but can't delete blog
     *
     * @return $user
     */
    public function userCanSeeCanNotDelete()
    {
        $user = User::where('name', '=', 'user_can_not_delete')->first();
        
        return $user;
    }
}
