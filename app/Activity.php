<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use UsesUuid;

    protected $table = 'activities';
    protected $fillable = [
        'url',
        'url_regex',
        'method'
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'permission_activities', 'activity_id', 'permission_id');
    }
}
