<?php

namespace App\Contracts;

interface OrderInterface
{
    public function getOrders(int $perPage);
    public function createOrder(array $data, int $customerId);
}
