<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * This class provides a presentation and transformation layer for Activity data output.
 */
class ActivityTransformer extends TransformerAbstract
{
    public function transform(\App\Activity $activity)
    {
        return $activity->toArray();
    }
}