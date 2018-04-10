<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['income_category_id','description','amount','added_by','modified_by','ip_address','status'];

}
