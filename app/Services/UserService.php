<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsers(): LengthAwarePaginator
    {
        return $this->user->latest()->paginate(10);
    }

    public function findById($id): ?User
    {
        return $this->user->find($id);
    }
}
