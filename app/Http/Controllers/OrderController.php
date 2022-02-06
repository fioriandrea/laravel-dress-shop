<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\DataLayer;

class OrderController extends Controller
{
    public function getOrders()
    {
        $orders = DataLayer::getUserOrders();
        return view('orders_page', [
            'orders' => $orders,
        ]);
    }

    public function postDeleteOrder($id)
    {
        DataLayer::deleteOrder($id);
        return redirect()->route('orders');
    }
}
