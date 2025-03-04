<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerAuthService
{
    /**
     * Register a new customer.
     *
     * @param  array  $data
     * @return array
     */
    public function register(array $data): array
    {
        $customer = Customer::create([
            'name'  => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Generate an API token for the new customer.
        $token = $customer->createToken('api-token')->plainTextToken;

        return [
            'customer' => $customer,
            'token'    => $token,
        ];
    }

    /**
     * Log in an existing customer.
     *
     * @param  array  $data
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(array $data): array
    {
        $customer = Customer::where('email', $data['email'])->first();

        if (!$customer || !Hash::check($data['password'], $customer->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Generate an API token for the customer.
        $token = $customer->createToken('api-token')->plainTextToken;

        return [
            'customer' => $customer,
            'token'    => $token,
        ];
    }
}
