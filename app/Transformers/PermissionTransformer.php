<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * This class provides a presentation and transformation layer for Permission data output.
 */
class PermissionTransformer extends TransformerAbstract
{
    public function transform(\App\Permission $permission)
    {
        return $permission->toArray();
    }
}