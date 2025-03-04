<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Inertia\Inertia;
Use Inertia\Response;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): Response
    {
        return Inertia::render('User/Index', ['users' => UserResource::collection($this->userService->getUsers())]);
    }

    public function create(): Response
    {
        return Inertia::render('User/Create');
    }

    public function store(Request $request)
    {
        dd($request);
    }

}
