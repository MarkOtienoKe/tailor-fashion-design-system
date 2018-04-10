<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Model;

class IncomeView extends Model
{
    protected $table = 'vw_incomes';
    protected $primaryKey = 'income_id';

}