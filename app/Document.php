<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['document_name','document_type','description','document_file','added_by','modified_by','ip_address','status'];

}
