<?php 

use Laravel\Lumen\Testing\DatabaseTransactions;

class PermissionActivityControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanGetListOfActivitiesFromPermission()
    {
        $activity = factory('App\Activity')->create();
        $permission = factory('App\Permission')->create();
        $permission->activities()->attach($activity);

        $response = $this->call('GET', '/api/v1/permissions/'.$permission->id.'/activities');
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $activity->id
            ]);
    }

    public function testCanGetListOfPermissionsFromActivity()
    {
        $permission = factory('App\Permission')->create();
        $activity = factory('App\Activity')->create();
        $activity->permissions()->attach($permission);
        
        $response = $this->call('GET', '/api/v1/activities/'.$activity->id.'/permissions');
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $permission->id
            ]);
    }

    public function testCanAttachActivityToPermission()
    {
        $activity = factory('App\Activity')->create();
        $permission = factory('App\Permission')->create();

        $response = $this->call('POST', '/api/v1/permissions/'.$permission->id.'/activities', ['activity_id' => $activity->id]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $activity->id
            ]);
    }

    public function testCanAttachPermissionToActivity()
    {
        $permission = factory('App\Permission')->create();
        $activity = factory('App\Activity')->create();

        $response = $this->call('POST', '/api/v1/activities/'.$activity->id.'/permissions', ['permission_id' => $permission->id]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $permission->id
            ]);
    }

    public function testCanDetachActivityFromPermission()
    {
        $activity = factory('App\Activity')->create();
        $permission = factory('App\Permission')->create();
        $permission->activities()->attach($activity);

        $response = $this->call('DELETE', '/api/v1/permissions/'.$permission->id.'/activities/'.$activity->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'activity_id' => $activity->id,
                'permission_id' => $permission->id
            ]);
    }

    public function testCanDetachPermissionFromActivity()
    {
        $permission = factory('App\Permission')->create();
        $activity = factory('App\Activity')->create();
        $activity->permissions()->attach($permission);

        $response = $this->call('DELETE', '/api/v1/activities/'.$activity->id.'/permissions/'.$permission->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'permission_id' => $permission->id,
                'activity_id' => $activity->id
            ]); 
    }
}