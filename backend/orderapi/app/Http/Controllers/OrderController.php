<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    private $rules = [
        'legalization_date' => 'required|date',
        'address' => 'required|string|max:100|min:3',
        'city' => 'required|string|max:100|min:3',
        'observation_id' => 'required|numeric',
        'causal_id' => 'required|numeric'
    ];

    private $traductionAttributes = [
        'legalization_date' => 'Fecha de legalización',
        'address' => 'Dirección',
        'city' => 'Ciudad',
        'observation_id' => 'Observación_id',
        'causal_id' => 'Causal_id'
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
        $orders = Order::all();
        $orders->load('observation_id', 'causal_id');
        return response()->json($orders, Response::HTTP_OK);
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
        $order = Order::create($request->all());
        $response = [
            'message' => 'Registro creado correctamente',
            'order' => $order
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order = Order::all();
        return response()->json($order, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = $this->applyValidators($request);
        if (!empty($data)) {
            return $data;
        }
        $order->update($request->all());
        $response = [
            'message' => 'Registro actualizado correctamente',
            'order' => $order
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {

        $order->delete();
        $response = [
            'message' => 'Registro eliminado correctamente',
            'order' => $order
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    /**
     * Agrega una actividad a la orden
     */

    public function add_activity(Order $order, Activity $activity)
    {
        $order->activities()->attach($activity);
        $response = [
            'message' => 'Actividad agregada correctamente',
            'order_activity' => $order->activities
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }
    /**
     * Elimina una actividad a la orden
     */

    public function remove_activity(Order $order, Activity $activity)
    {
        $order->activities()->detach($activity);
        $response = [
            'message' => 'Actividad eliminada correctamente',
            'order_activity' => $order->activities
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
