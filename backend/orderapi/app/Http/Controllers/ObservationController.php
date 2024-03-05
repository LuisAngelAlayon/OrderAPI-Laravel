<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ObservationController extends Controller
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
        $observations = Observation::all();
        return response()->json($observations, Response::HTTP_OK);
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
        $observation = Observation::create($request->all());
        $response = [
            'message' => 'Registro creado correctamente',
            'observation' => $observation
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(observation $observation)
    {
        return response()->json($observation, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, observation $observation)
    {
        $data = $this->applyValidators($request);
        if (!empty($data)) {
            return $data;
        }
        $observation->update($request->all());
        $response = [
            'message' => 'Registro creado correctamente',
            'observation' => $observation
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(observation $observation)
    {
        $observation->delete();
        $response = [
            'message' => 'Registro eliminado correctamente',
            'observation' => $observation
        ];
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
