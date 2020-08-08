<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Transformers\PermissionTransformer;
use Validator;
use Dingo\Api\Routing\Helpers;
use Laravel\Lumen\Routing\Controller as BaseController;

class PermissionController extends BaseController
{
    use Helpers;

    private $validationRules = [
        'name' => 'required|unique:permissions|min:3'
    ];

    public function __construct(\App\Permission $permission, PermissionTransformer $permissionTransformer)
    {
        $this->permission = $permission;
        $this->transformer = $permissionTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->permission->all();
        return $this->response->array($permissions, $this->transformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, $this->validationRules);
        if ($validator->fails())
        {
            return new JsonResponse([
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $permission = $this->permission->create($input);
        return $this->response->item($permission, $this->transformer);
    }

    /**
     * Display the specified resource.
     *
     * @param string $permission
     * @return \Illuminate\Http\Response
     */
    public function show($permission)
    {
        $permission = $this->permission->find($permission);
        if(!$permission)
        {
            return new JsonResponse([
                'errors' => 'The specified permission hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }
        return $this->response->item($permission, $this->transformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $permission)
    {
        $permission = $this->permission->find($permission);
        if(!$permission)
        {
            return new JsonResponse([
                'errors' => 'The specified permission hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $input = $request->all();
        $validator = Validator::make($input, $this->validationRules);
        if ($validator->fails())
        {
            return new JsonResponse([
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $permission->fill($input);
        $permission->save();

        return $this->response->item($permission, $this->transformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($permission)
    {
        $permission = $this->permission->find($permission);
        if(!$permission)
        {
            return new JsonResponse([
                'errors' => 'The specified permission hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $permission->delete();
        return new JsonResponse([
            'message' => 'Permission has been succesfully deleted.',
            'permission_id' => $permission->id
        ], Response::HTTP_OK);
    }
}
