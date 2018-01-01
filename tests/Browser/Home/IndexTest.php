<?php

namespace Tests\Browser\Home;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('阅读全文')
                ->clickLink('写给 thinkphp 开发者的 laravel 系列教程 (一) 序言');
            $window = collect($browser->driver->getWindowHandles())->last();
            $browser->driver->switchTo()->window($window);
            $browser->assertPathIs('/article/1')
                ->click('.b-nav-login')
                ->script("$('.b-login-img').eq(2).find('a').find('img').click();");
            $browser->type('login', env('DUSK_GITHUB_EMAIL'))
                ->type('password', env('DUSK_GITHUB_PASSWORD'))
                ->press('Sign in')
                ->waitForLocation('/article/1');
        });
    }
}
