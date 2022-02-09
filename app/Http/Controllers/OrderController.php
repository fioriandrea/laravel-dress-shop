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
        ]);
    }

    public function postDeleteOrder($id)
    {
        DataLayer::deleteOrder($id);
        return response()->json(['success' => true, 'message' => 'Order deleted successfully']);
    }

    public function getAdminOrders()
    {
        $orders = DataLayer::getPendingOrders();
        return view('orders_page', [
            'orders' => $orders,
        ]);
    }

    public function postConfirmOrder($id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('user_error', ['messages' => ['Order not found.'], 'status' => 404]);
        }
        DataLayer::confirmOrder($id);
        return response()->json(['success' => true, 'message' => 'Order confirmed successfully']);
    }

    public function postRefuseOrder($id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('user_error', ['messages' => ['Order not found.'], 'status' => 404]);
        }
        DataLayer::refuseOrder($id);
        return response()->json(['success' => true, 'message' => 'Order refused successfully']);
    }
}
