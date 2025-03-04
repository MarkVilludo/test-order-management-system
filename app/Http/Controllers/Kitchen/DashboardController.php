<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Contracts\DashboardInterface;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardInterface $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $incomingOrders = $this->dashboardService->getIncomingOrders();
        $kitchenOrders  = $this->dashboardService->getKitchenOrders();
        $deliveryOrders = $this->dashboardService->getDeliveryOrders();

        return Inertia::render('Kitchen/Dashboard', [
            'incomingOrders' => $incomingOrders,
            'kitchenOrders'  => $kitchenOrders,
            'deliveryOrders' => $deliveryOrders,
        ]);
    }
}
