<?php

/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:32
 */
namespace App\Repositories;

use App\Customer;
use App\ViewModels\CustomerView;
use Request;

class CustomerRepository
{
    public static function deactiveCustomer($id)
    {
        $customer = Customer::find($id);

        $customer->status = 'IN-ACTIVE';

        return $customer->save();
    }
    public static function createCustomer($request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->location = $request->location;
        $customer->id_number = $request->id_number;
        $customer->added_by = 1;
        $customer->modified_by = 1;
        $customer->ip_address = Request::ip();
        $customer->status = $request->status;

        return $customer->save();
    }
    public static function editCustomer($request)
    {
        $customer = Customer::find($request->customer_id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->location = $request->location;
        $customer->id_number = $request->id_number;
        $customer->modified_by = 1;
        $customer->ip_address = Request::ip();
        return $customer->save();
    }
    public static function getCustomersData($query){
        try {
            $data = CustomerView::where('customer_name', 'LIKE', '%' . $query . '%')
                ->where('customer_status', '=', 'ACTIVE')
                ->get(['customer_id','customer_name']);
            return $data;
        } catch (Exception $e) {
            \Log::error('Exception while fetching customers = ' . [$e]);

            return null;
        }
    }
    public static function getCustomersCount(){
        try {
            $data = CustomerView::where('customer_status','=','ACTIVE')
            ->count();
            return $data;
        } catch (\Exception $e) {
            \Log::error('Exception while fetching number of customers = ' . [$e]);

            return null;
        }
    }
}