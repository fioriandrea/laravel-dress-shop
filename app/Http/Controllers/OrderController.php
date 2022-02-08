<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\DataLayer;
use dress_shop\Order;

class OrderController extends Controller
{
    public function getOrders()
    {
        $orders = DataLayer::getUserOrders();
        return view('orders_page', [
            'orders' => $orders,
            'admin' => false,
        ]);
    }

    public function postDeleteOrder($id)
    {
        DataLayer::deleteOrder($id);
        return redirect()->route('orders');
    }

    public function getAdminOrders()
    {
        $orders = DataLayer::getPendingOrders();
        return view('orders_page', [
            'orders' => $orders,
            'admin' => true,
        ]);
    }

    public function postConfirmOrder($id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('error', ['messages' => ['Order not found.']]);
        }
        DataLayer::confirmOrder($id);
        return redirect()->route('admin_orders');
    }
}
