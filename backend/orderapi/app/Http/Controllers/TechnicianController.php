<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TechnicianController extends Controller
{

    private $rules = [
        'document' => 'required|numeric|max:9999999999|min:3',
        'name' => 'required|string|max:100|min:3',
        'especiality' => 'required|string|max:100|min:3',
        'phone' => 'required|numeric|max:9999999999|min:3'
    ];

    private $traductionAttributes = [
        'document' => 'Documento',
        'name' => 'Nombre',
        'especiality' => 'Especialidad',
        'phone' => 'Telefono'
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
        $technicians = Technician::all();
        return response()->json($technicians, Response::HTTP_OK);
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

        $technician = Technician::create($request->all());
        $response = [
            'message' => 'Registro creado correctamente',
            'technician' => $technician
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Technician $technician)
    {
        return response()->json($technician, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $technician)
    {
        $data = $this->applyValidators($request);
        if (!empty($data)) {
            return $data;
        }

        $technician->update($request->all());
        $response = [
            'message' => 'Registro creado correctamente',
            'technician' => $technician
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        $technician->delete();
        $response = [
            'message' => 'Registro eliminado correctamente',
            'technician' => $technician
        ];
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
