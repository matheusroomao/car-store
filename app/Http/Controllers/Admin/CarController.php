<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarRequest;
use App\Repository\Admin\Contract\CarInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CarInterface $interface): JsonResponse
    {
        return response()->json($interface->findAll($request),$interface->getCode());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequest $request, CarInterface $interface): JsonResponse
    {
        return response()->json($interface->save($request),$interface->getCode());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, CarInterface $interface): JsonResponse
    {
        return response()->json($interface->findById($id),$interface->getCode());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarRequest $request, $id, CarInterface $interface): JsonResponse
    {
        return response()->json($interface->update($id, $request),$interface->getCode());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, CarInterface $interface): JsonResponse
    {
        return response()->json($interface->deleteById($id),$interface->getCode());
    }
}