<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ActivityControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanGetListOfAllActivities()
    {
        $response = $this->call('GET', '/api/v1/activities');
        $response->assertStatus(200);
    }

    public function testCanCreateAActivity()
    {
        $response = $this->call('POST', '/api/v1/activities', [
            'url' => 'http://user.verbeek.io/api/v1/users',
            'url_regex' => '/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/',
            'method' => 'GET'
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'url' => 'http://user.verbeek.io/api/v1/users',
                'url_regex' => '/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/',
                'method' => 'GET'
            ]);
    }

    public function testCanReadAActivity()
    {
        $activity = factory('App\Activity')->create();
        $response = $this->call('GET', '/api/v1/activities/'.$activity->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'url' => $activity->url,
                'url_regex' => $activity->url_regex,
                'method' => $activity->method
            ]);
    }

    public function testCanUpdateAActivity()
    {
        $activity = factory('App\Activity')->create();
        $response = $this->call('PUT', '/api/v1/activities/'.$activity->id, [
            'method' => 'DELETE'
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'url' => $activity->url,
                'url_regex' => $activity->url_regex,
                'method' => 'DELETE'
            ]);
    }

    public function testCanDeleteAActivity()
    {
        $activity = factory('App\Activity')->create();
        $response = $this->call('DELETE', '/api/v1/activities/'.$activity->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'activity_id' => $activity->id
            ]);
        $this->assertNull(\App\Activity::find($activity->id));
    }
}
