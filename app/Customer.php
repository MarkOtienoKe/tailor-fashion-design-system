<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name','email','mobile','location','id_number','added_by','modified_by','ip_address','status'];

}
