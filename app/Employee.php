<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name','email','mobile','address','date_of_employment','salary','id_number','added_by','modified_by','ip_address','designation_id','status'];

}
