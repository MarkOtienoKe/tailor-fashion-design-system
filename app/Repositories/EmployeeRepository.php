<?php

/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:32
 */
namespace App\Repositories;

use App\Employee;
use App\ViewModels\EmployeeView;
use Request;
use Log;

class EmployeeRepository
{
    public static function deactiveEmployee($id)
    {
        $employee = Employee::find($id);

        $employee->status = 'IN-ACTIVE';

        return $employee->save();
    }
    public static function createEmployee($request)
    {
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->address = $request->address;
        $employee->designation_id = $request->designation_id;
        $employee->added_by = 1;
        $employee->modified_by = 1;
        $employee->ip_address = Request::ip();
        $employee->email = $request->email;
        $employee->mobile = $request->mobile;
        $employee->id_number = $request->id_number;
        $employee->salary = $request->salary;
        $employee->date_of_employment = $request->date_of_employment;
        $employee->status = $request->status;

        return $employee->save();
    }
    public static function editEmployee($request)
    {
        $employee = Employee::find($request->employee_id);
        $employee->name = $request->name;
        $employee->address = $request->address;
        $employee->designation_id = $request->designation_id;
        $employee->modified_by = 1;
        $employee->ip_address = Request::ip();
        $employee->email = $request->email;
        $employee->mobile = $request->mobile;
        $employee->id_number = $request->id_number;
        $employee->salary = $request->salary;
        $employee->date_of_employment = $request->date_of_employment;
        return $employee->save();
    }
    public static function employeeEditDetail($id){
        $query = EmployeeView::find($id)->toArray();
        return $query;

    }
}