<?php

namespace App\Http\Controllers\V1;

use App\Rules\IsRegex;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Transformers\ActivityTransformer;
use Validator;
use Dingo\Api\Routing\Helpers;
use Laravel\Lumen\Routing\Controller as BaseController;

class ActivityController extends BaseController
{
    use Helpers;
    
    private $validationRules = [
        'url' => 'required|sometimes|url',
        'method' => 'required|sometimes|in:GET,HEAD,POST,PUT,PATCH,DELETE,CONNECT,OPTIONS,TRACE'
    ];

    public function __construct(\App\Activity $activity, ActivityTransformer $activityTransformer)
    {
        $this->activity = $activity;
        $this->transformer = $activityTransformer;
        $this->validationRules['url_regex'] = [ 'required', 'sometimes', new IsRegex ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = $this->activity->all();
        return $this->response->array($activities, $this->transformer);
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

        $activity = $this->activity->create($input);
        return $this->response->item($activity, $this->transformer);
    }

    /**
     * Display the specified resource.
     *
     * @param string $activity
     * @return \Illuminate\Http\Response
     */
    public function show($activity)
    {
        $activity = $this->activity->find($activity);
        if(!$activity)
        {
            return new JsonResponse([
                'errors' => 'The specified activity hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }
        return $this->response->item($activity, $this->transformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $activity)
    {
        $activity = $this->activity->find($activity);
        if(!$activity)
        {
            return new JsonResponse([
                'errors' => 'The specified activity hasn\'t been found'
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

        $activity->fill($input);
        $activity->save();

        return $this->response->item($activity, $this->transformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy($activity)
    {
        $activity = $this->activity->find($activity);
        if(!$activity)
        {
            return new JsonResponse([
                'errors' => 'The specified activity hasn\'t been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $activity->delete();
        return new JsonResponse([
            'message' => 'Activity has been succesfully deleted.',
            'activity_id' => $activity->id
        ], Response::HTTP_OK);
    }
}
