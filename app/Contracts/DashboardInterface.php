<?php

namespace App\Contracts;

interface DashboardInterface
{
    public function getIncomingOrders(int $perPage = 4);
    public function getKitchenOrders(int $perPage = 4);
    public function getDeliveryOrders(int $perPage = 4);
}
