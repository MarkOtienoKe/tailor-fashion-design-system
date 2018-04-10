<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['name','description','clothe_type_id','image','updated_at','added_by','modified_by','ip_address','status'];
protected $table = 'materials';
}
