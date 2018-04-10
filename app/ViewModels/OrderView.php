<?php
namespace App\ViewModels;

use Illuminate\Database\Eloquent\Model;

class OrderView extends Model
{
    protected $table = 'vw_orders';
    protected $primaryKey = 'order_id';
}