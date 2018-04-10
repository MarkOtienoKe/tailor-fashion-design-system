<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Model;


class MaterialView extends Model
{
    protected $table = 'vw_materials';
    protected $primaryKey = 'material_id';
}