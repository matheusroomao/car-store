<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RequestRegistration;
use App\Repository\Admin\Contract\UserInterface;
use App\Repository\LoginInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestRegistration $request, UserInterface $interface): JsonResponse
    {
        return response()->json($interface->save($request),$interface->getCode());
    }
    
    /**
     * @param LoginRequest $request
     * @param LoginInterface $interface
     * @return JsonResponse
     */
    public function login(LoginRequest $request, LoginInterface $interface): JsonResponse
    {
        return response()->json($interface->login($request), $interface->getCode());
    }

    /**
     * @param Request $request
     * @param LoginInterface $interface
     * @return JsonResponse
     */
    public function logout(Request $request, LoginInterface $interface): JsonResponse
    {
        return response()->json($interface->logout($request), $interface->getCode());
    }

    /**
     * @param Request $request
     * @param LoginInterface $interface
     * @return JsonResponse
     */
    public function me(Request $request, LoginInterface $interface): JsonResponse
    {
        return response()->json($interface->me($request), $interface->getCode());
    }
}
