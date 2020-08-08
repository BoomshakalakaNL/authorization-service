<?php

use App\Role;
use App\Permission;
use App\Activity;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PermissionModelTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanGetSetName()
    {
        $permission = Permission::make([
            'name' => 'testPermission'
        ]);
        $this->assertEquals('testPermission', $permission->name);
    }

    public function testCanAttachAndDetachRole()
    {
        $role = factory('App\Role')->create();
        $permission = factory('App\Permission')->create();

        $permission->roles()->attach($role);
        $permission = Permission::find($permission->id);
        $this->assertEquals(1, sizeof($permission->roles));

        $permission->roles()->detach($role);
        $permission = Permission::find($permission->id);
        $this->assertEquals(0, sizeof($permission->roles));
    }

    public function testCanAttachAndDetachActivity()
    {
        $activity = factory('App\Activity')->create();
        $permission = factory('App\Permission')->create();

        $permission->activities()->attach($activity);
        $permission = Permission::find($permission->id);
        $this->assertEquals(1, sizeof($permission->activities));

        $permission->activities()->detach($activity);
        $permission = Permission::find($permission->id);
        $this->assertEquals(0, sizeof($permission->activities));
    }

    public function testCanCreatePermissionInDatabase()
    {
        $permission = Permission::make([
            'name' => 'testPermission'
        ]);
        $permission->save();
        $permissionId = $permission->id;
        $permission = Permission::find($permissionId);
        $this->assertNotNull($permission);
    }

    public function testCanReadPermissionFromDatabase()
    {
        $permission = factory('App\Permission')->create();
        $permissionId = $permission->id;
        $permission = Permission::find($permissionId);
        $this->assertNotNull($permission);
    }

    public function testCanUpdatePermissionInDatabase()
    {
        $permission = factory('App\Permission')->create();
        $permission->name = 'UpdatedName';
        $permission->save();
        $permission = Permission::find($permission->id);
        $this->assertEquals('UpdatedName', $permission->name);
    }

    public function testCanDeletePermissionFromDatabase()
    {
        $permission = factory('App\Permission')->create();
        $permissionId = $permission->id;
        $permission->delete();
        $this->assertNull(Permission::find($permissionId));
    }
}
