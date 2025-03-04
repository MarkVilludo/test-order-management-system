<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;
Use Inertia\Response;
Use Inertia\Inertia;

class CustomerController extends Controller
{

    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(): Response
    {
        return Inertia::render('Customer/Index', ['customers' => CustomerResource::collection($this->customerService->getCustomers())]);
    }
}
