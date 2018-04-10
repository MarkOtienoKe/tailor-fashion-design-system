<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = ['designation_name','description','added_by','modified_by','ip_address','status'];
    protected $table = 'designations';

}
