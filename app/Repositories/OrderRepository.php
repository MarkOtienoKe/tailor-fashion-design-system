<?php

/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:33
 */

namespace App\Repositories;

use App\Order;
use App\ViewModels\OrderView;
use Request;
use Log;

class OrderRepository
{
    public static function createOrder($request)
    {
        $order = new Order();
        $order->customer_id = $request->customer_id;
        $order->clothe_type_id = $request->clothe_type_id;
        $order->material_id = $request->material_id;
        $order->amount_to_pay = $request->amount_to_pay;
        $order->date_received = $request->date_received;
        $order->date_of_collection = $request->date_of_collection;
        $order->description = $request->description;
        $order->added_by = 1;
        $order->modified_by = 1;
        $order->ip_address = Request::ip();
        $order->status = $request->status;

        return $order->save();
    }

    public static function savePaymentAmount($request)
    {
        $finalResponse = false;
        $order = Order::find($request->order_id);
        $order->amount_paid = $order->amount_paid + $request->amount;
        $order->modified_by = 1;
        $order->ip_address = Request::ip();
        $response = $order->save();
        if ($response == true) {
            //change order status
            \Log::debug('the order id',[$request->order_id]);
            $orderData = Order::find((int)$request->order_id);
            \Log::debug('the order $orderData',[$orderData]);
            $status = 'FULLY PAID';
            if ($orderData->balance > 0) {
                $status = 'PARTIALLY PAID';
            }
            $orderStatusUpdate = Order::find($request->order_id);
            $orderStatusUpdate->status = $status;
            $finalResponse = $orderStatusUpdate->save();
        }
        return $finalResponse;
    }

    public static function getOrdersCount($status)
    {
        $orders = OrderView::where('order_status','=',$status)
            ->count();
        return $orders;
    }

    public static function closeOrder($id)
    {
        $order = Order::find($id);
        $order->modified_by = 1;
        $order->status = 'CLOSED';
        return $order->save();
    }


}