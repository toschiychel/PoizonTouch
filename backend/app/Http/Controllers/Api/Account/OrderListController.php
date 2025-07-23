<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\BaseController\Api\BaseAccountController;
use App\Http\Resources\Order\OrderResource;
use App\Models\User;

class OrderListController extends BaseAccountController
{
    public function __invoke(User $user)
    {   
        $orders = $this->service->userOrders($user);
        return OrderResource::collection($orders);
    }
}
