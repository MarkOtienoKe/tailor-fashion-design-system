<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['expense_category_id','description','amount','added_by','modified_by','ip_address','status'];

}
