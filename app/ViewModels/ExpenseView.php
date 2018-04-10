<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Model;

class ExpenseView extends Model
{
    protected $table = 'vw_expenses';
    protected $primaryKey = 'expense_id';
}