<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EventsAuthorizationTest extends TestCase
{
    public function testEventIsAuthorized1()
    {
        setUp::run($this);

        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->youShouldHaveRole('reader')->toBeAuthorized();
        HeyMan::whenEventHappens('myEvent4')->youShouldHaveRole('reader')->toBeAuthorized();

        $this->expectException(AuthorizationException::class);

        event('myEvent1');
    }

    public function testEventIsAuthorized2()
    {
        setUp::run($this);

        Gate::define('deadEnd', function () {
            return false;
        });

        Gate::define('open', function () {
            return true;
        });

        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->youShouldPassGate('deadEnd')->toBeAuthorized();
        HeyMan::whenEventHappens('myEvent4')->youShouldPassGate('open')->toBeAuthorized();

        $this->expectException(AuthorizationException::class);

        event('myEvent1');
    }

    public function testAlways()
    {
        setUp::run($this);
        HeyMan::whenEventHappens(['my-event', 'myEvent1'])->immediately()->abort(402);

        $this->get('event/my-event')->assertStatus(402);
    }

    public function testAlways1()
    {
        setUp::run($this);
        HeyMan::whenEventHappens(['my-event', 'myEvent1'])->immediately()->redirectTo('welcome');

        $this->get('event/my-event')->assertStatus(302)->assertRedirect('welcome');
    }
}