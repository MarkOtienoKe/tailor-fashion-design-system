<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = ['id','customer_id','measurements_person_name','measurement_date','date','sex','length','waist','bottom','thigh','round','fly','shoulder','sleeves','chest','tummy','biceps','round_sleeve','burst','hips','bodies','added_by','modified_by','ip_address','status'];

}
