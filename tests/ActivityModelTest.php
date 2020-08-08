<?php

use App\Activity;
use App\Permission;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ActivityModelTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanGetSetUrl()
    {
        $activity = factory('App\Activity')->create();
        $activity->url = 'https://user.verbeek.io/api/v1/users';
        $this->assertEquals('https://user.verbeek.io/api/v1/users', $activity->url);
    }

    public function testCanGetSetUrlRegex()
    {
        $activity = factory('App\Activity')->create();
        $activity->url_regex = '[0-9]';
        $this->assertEquals('[0-9]', $activity->url_regex);
    }

    public function testCanGetSetMethod()
    {
        $activity = factory('App\Activity')->create();
        $activity->method = 'GET';
        $this->assertEquals('GET', $activity->method);
    }

    public function testCanAttachDetachPermission()
    {
        $activity = factory('App\Activity')->create();
        $permission = factory('App\Permission')->create();

        $activity->permissions()->attach($permission);
        $activity = Activity::find($activity->id);
        $this->assertEquals(1, sizeof($activity->permissions));

        $activity->permissions()->detach($permission);
        $activity = Activity::find($activity->id);
        $this->assertEquals(0, sizeof($activity->permissions));
    }

    public function testCanCreateActivityInDatabase()
    {
        $activity = Activity::make([
            'url' => 'https://user.verbeek.io/api/v1/users',
            'url_regex' => '[0-9]',
            'method' => 'POST'
        ]);
        $activity->save();

        $activity = Activity::find($activity->id);
        $this->assertNotNull($activity);
    }

    public function testCanReadActivityFromDatabase()
    {
        $activity = factory('App\Activity')->create();
        $activity = Activity::find($activity->id);
        $this->assertNotNull($activity);
    }

    public function testCanUpdateActivityFromDatabase()
    {
        $activity = factory('App\Activity')->create();
        $activity = Activity::find($activity->id);
        $activity->method = 'PUT';
        $activity->save();
        $activity = Activity::find($activity->id);
        $this->assertEquals('PUT', $activity->method);
    }

    public function testCanDeleteActivityFromDatabase()
    {
        $activity = factory('App\Activity')->create();
        $activity = Activity::find($activity->id);
        $activity->delete();
        $activity = Activity::find($activity->id);
        $this->assertNull($activity);
    }
}
