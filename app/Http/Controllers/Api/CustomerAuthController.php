<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CustomerAuthService;
use App\Http\Requests\RegisterCustomerRequest;
use App\Http\Requests\LoginCustomerRequest;

class CustomerAuthController extends Controller
{
    protected $authService;

    public function __construct(CustomerAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterCustomerRequest $request)
    {
        $validated = $request->validated();
        $result = $this->authService->register($validated);

        return response()->json($result, 201);
    }

    public function login(LoginCustomerRequest $request)
    {
        $validated = $request->validated();
        $result = $this->authService->login($validated);

        return response()->json($result, 200);
    }
}
