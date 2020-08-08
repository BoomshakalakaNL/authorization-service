<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Transformers\ActivityTransformer;
use App\Transformers\PermissionTransformer;
use Validator;
use Dingo\Api\Routing\Helpers;
use Laravel\Lumen\Routing\Controller as BaseController;

class PermissionActivityController extends BaseController
{
    use Helpers;

    private $validationRulesPermission = [
        'activity_id' => 'required|uuid|exists:activities,id'
    ];

    private $validationRulesActivity = [
        'permission_id' => 'required|uuid|exists:permissions,id'
    ];

    public function __construct(\App\Permission $permission, \App\Activity $activity, PermissionTransformer $permissionTransformer, ActivityTransformer $activityTransformer)
    {
        $this->permission = $permission;
        $this->activity = $activity;
        $this->permissionTransformer = $permissionTransformer;
        $this->activityTransformer = $activityTransformer;
    }

    public function indexPermission($permission)
    {
        $permission = $this->permission->find($permission);
        if(!$permission)
        {
            return new JsonResponse([
                'errors' => 'The specified permission hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $activities = $permission->activities;
        return $this->response->array($activities, $this->activityTransformer);
    }

    public function storePermission(Request $request, $permission)
    {
        $permission = $this->permission->find($permission);
        if(!$permission)
        {
            return new JsonResponse([
                'errors' => 'The specified permission hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $input = $request->all();
        $validator = Validator::make($input, $this->validationRulesPermission);
        if ($validator->fails())
        {
            return new JsonResponse([
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $activity = $this->activity->find($input['activity_id']);
        $permission->activities()->attach($activity);
        return $this->response->array($permission->activities, $this->activityTransformer);
    }

    public function destroyPermission(Request $request, $permission, $activity)
    {
        $permission = $this->permission->find($permission);
        if(!$permission)
        {
            return new JsonResponse([
                'errors' => 'The specified permission hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $activity = $this->activity->find($activity);
        if(!$activity)
        {
            return new JsonResponse([
                'errors' => 'The specified activity hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $permission->activities()->detach($activity);
        return new JsonResponse([
            'message' => 'The activity has been succesfully detached from this permission.',
            'activity_id' => $activity->id,
            'permission_id' => $permission->id
        ], Response::HTTP_OK);
    }

    public function indexActivity($activity)
    {
        $activity = $this->activity->find($activity);
        if(!$activity)
        {
            return new JsonResponse([
                'errors' => 'The specified activity hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $permission = $activity->permissions;
        return $this->response->array($permission, $this->permissionTransformer);
    }

    public function storeActivity(Request $request, $activity)
    {
        $activity = $this->activity->find($activity);
        if(!$activity)
        {
            return new JsonResponse([
                'errors' => 'The specified activity hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $input = $request->all();
        $validator = Validator::make($input, $this->validationRulesActivity);
        if ($validator->fails())
        {
            return new JsonResponse([
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $permission = $this->permission->find($input['permission_id']);
        $activity->permissions()->attach($permission);
        return $this->response->array($activity->permissions, $this->permissionTransformer);
    }

    public function destroyActivity(Request $request, $activity, $permission)
    {
        $activity = $this->activity->find($activity);
        if(!$activity)
        {
            return new JsonResponse([
                'errors' => 'The specified activity hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $permission = $this->permission->find($permission);
        if(!$permission)
        {
            return new JsonResponse([
                'errors' => 'The specified permission hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $activity->permissions()->detach($permission);
        return new JsonResponse([
            'message' => 'The activity has been succesfully detached from this permission.',
            'permission_id' => $permission->id,
            'activity_id' => $activity->id
        ], Response::HTTP_OK);
    }
}
