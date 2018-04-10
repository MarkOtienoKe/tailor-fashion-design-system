<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 20/02/2018
 * Time: 15:13
 */

namespace App\Repositories;


use App\Transaction;
use Request;

class TransactionRepository
{
    public static function saveTransaction($request)
    {
        $transaction = new Transaction();
        $transaction->expense_id = $request['expense_id'];
        $transaction->order_id = $request['order_id'];
        $transaction->debit = $request['amount'];
        $transaction->balance = $request['balance'];
        $transaction->added_by =1;
        $transaction->modified_by = 1;
        $transaction->ip_address = Request::ip();

        $transaction->save();

    }
}