<?php
namespace App\ViewModels;

use Illuminate\Database\Eloquent\Model;

class EmployeeView extends Model
{
    protected $table = 'vw_employees';
    protected $primaryKey = 'employee_id';

}