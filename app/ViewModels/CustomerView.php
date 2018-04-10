<?php
namespace App\ViewModels;

use Illuminate\Database\Eloquent\Model;

class CustomerView extends Model
{
    protected $table = 'vw_customers';
    protected $primaryKey = 'customer_id';
}