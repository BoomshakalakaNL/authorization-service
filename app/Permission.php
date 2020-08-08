<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use UsesUuid;

    protected $table = 'permissions';
    protected $fillable = [ 'name' ];

    
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_permissions');
    }

    public function activities()
    {
        return $this->belongsToMany('App\Activity', 'permission_activities', 'permission_id', 'activity_id');
    }
}
