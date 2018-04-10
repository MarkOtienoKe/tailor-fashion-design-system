<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    protected $fillable = ['name','description','added_by','modified_by','ip_address','status'];

}
