<?php

/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:33
 */

namespace App\Repositories;

use App\Payment;
use Request;

class PaymentRepository
{
    public static function makePayment($request)
    {
        $file = $request['cheque_image'];
        $fileName = $file->getClientOriginalName();
        $destinationPath = public_path() . '/uploads/paymentDocuments';
        $file->move($destinationPath, $fileName);
        $payment = new Payment();
        $payment->expense_id = $request['expense_id'];
        $payment->order_id = $request['order_id'];
        $payment->mpesa_transaction_id = $request['mpesa_transaction_id'];
        $payment->date_of_payment = \Carbon\Carbon::now()->toDateTimeString();
        $payment->amount = $request['amount'];
        $payment->payment_method = $request['payment_method'];
        $payment->added_by = 1;
        $payment->modified_by = 1;
        $payment->payment_type = $request['payment_type'];
        $payment->status = $request['status'];
        $payment->payment_document = $fileName;
        $payment->ip_address = Request::ip();
        return $payment->save();
    }
}