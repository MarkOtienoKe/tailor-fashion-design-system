<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['employee_id','payment_type','payment_document','date_of_payment','amount','payment_method','payment_bill_number','payment_ac_number','description','amount','added_by','modified_by','ip_address','status'];

}
