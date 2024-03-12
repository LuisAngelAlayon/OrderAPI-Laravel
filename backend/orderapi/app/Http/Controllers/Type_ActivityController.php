<?php

namespace App\Http\Controllers;

use App\Models\TypeActivity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class Type_ActivityController extends Controller
{
    private $rules = [
        'description' => 'required|string|max:100|min:3'
    ];

    private $traductionAttributes = [
        'description' => 'Descripción'
    ];

    public function applyValidators(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);

        $data = [];

        if ($validator->fails()) {
            $data = response()->json([
                'errors' => $validator->errors(),
                'data' => $request->all()
            ], Response::HTTP_BAD_REQUEST);
        }
        return $data;


    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type_activities = TypeActivity::all();
        return response()->json($type_activities, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->applyValidators($request);
        if (!empty($data)) {
            return $data;
        }

        $type_activity = TypeActivity::create($request->all());
        $response = [
            'message' => 'Registro creado correctamente',
            'type_activity' => $type_activity
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeActivity $type_activity)
    {
        return response()->json($type_activity, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeActivity $type_activity)
    {
        $data = $this->applyValidators($request);
        if (!empty($data)) {
            return $data;
        }

        $type_activity->update($request->all());
        $response = [
            'message' => 'Registro creado correctamente',
            'type_activity' => $type_activity
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeActivity $type_activity)
    {
        $type_activity->delete();
        $response = [
            'message' => 'Registro eliminado correctamente',
            'type_activity' => $type_activity
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
