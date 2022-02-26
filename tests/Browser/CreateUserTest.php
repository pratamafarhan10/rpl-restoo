<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateUserTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group user
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'manajer@gmail.com')
                    ->type('password', 'password')
                    ->press('LOG IN');
        });
    }
}
