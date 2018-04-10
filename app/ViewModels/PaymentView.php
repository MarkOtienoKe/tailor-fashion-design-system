<?php
namespace App\ViewModels;

use Illuminate\Database\Eloquent\Model;

class PaymentView extends Model
{
    protected $table = 'vw_payments';
    protected $primaryKey = 'payment_id';

}