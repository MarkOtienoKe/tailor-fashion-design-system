<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id','amount','date_received','mobile','date_of_collection','description','completed','added_by','modified_by','ip_address','status'];

    protected $table = 'orders';

}
