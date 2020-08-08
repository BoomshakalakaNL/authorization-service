<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class PermissionControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanGetListOfAllPermissions()
    {
        $response = $this->call('GET', '/api/v1/permissions');
        $response->assertStatus(200);
    }

    public function testCanCreateAPermission()
    {
        $response = $this->call('POST', '/api/v1/permissions', [
            'name' => 'testPermission'
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'testPermission'
            ]);
    }

    public function testCanReadPermission()
    {
        $permission = factory('App\Permission')->create();
        $response = $this->call('GET', '/api/v1/permissions/'.$permission->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $permission->name
            ]);
    }

    public function testCanUpdatePermission()
    {
        $permission = factory('App\Permission')->create();
        $response = $this->call('PUT', '/api/v1/permissions/'.$permission->id, [
            'name' => 'updatedPermissionName'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'updatedPermissionName'
            ]);
    }

    public function testCanDeletePermission()
    {
        $permission = factory('App\Permission')->create();
        $response = $this->call('DELETE', '/api/v1/permissions/'.$permission->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'permission_id' => $permission->id
            ]);
        $this->assertNull(\App\Permission::find($permission->id));        
    }
}