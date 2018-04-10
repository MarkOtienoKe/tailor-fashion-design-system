<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClotheType extends Model
{
    protected $fillable = ['name','description','sex','added_by','modified_by','ip_address','status'];

}
