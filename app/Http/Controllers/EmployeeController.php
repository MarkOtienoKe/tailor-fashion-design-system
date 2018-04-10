<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:35
 */

namespace App\Http\Controllers;

use App\Employee;
use App\Repositories\EmployeeRepository;
use App\ViewModels\EmployeeView;
use function compact;
use Illuminate\Http\Request;
use function view;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Log;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employees.list');
    }

    public function getAllEmployeesData()
    {
        $employees = EmployeeView::select(['employee_id', 'employee_name', 'employee_email', 'employee_mobile_no', 'employee_address', 'salary', 'date_of_employment', 'employee_id_no', 'addedby_user_name', 'modifiedby_user_name', 'ip_address', 'position', 'created_at', 'employee_status'])
            ->where('employee_status', '=', 'ACTIVE');
        return Datatables::of($employees)
            ->make(true);
    }

    public function employeeCreateView()
    {
        return view('employees.create');
    }

    public function export()
    {
        $fileType = 'xls';
        $employeesData = EmployeeView::all();
        Excel::create('Employee-data', function ($excel) use ($employeesData) {
            $excel->sheet('ExportFile', function ($sheet) use ($employeesData) {
                $sheet->fromArray($employeesData);
            });

        })->store($fileType, storage_path('excel/exports'));

        $files = storage_path('excel/exports');
        $zipFile = storage_path('excel/exports/mytest3.zip');

        $zipper = new \Chumper\Zipper\Zipper;
        $zipper->make($zipFile)->add($files);

        return response()->download($zipFile);
    }

    public function deativateEmployee(Request $request)
    {
        $response = EmployeeRepository::deactiveEmployee($request['employee_id']);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);

        }
    }

    public function createEmployee(Request $request)
    {
        \Log::debug('The Gterrr=>',[$request->all()]);
        $employee = Employee::where('email', '=', $request->email)->first();
        if ($employee === null) {
            $response = EmployeeRepository::createEmployee($request);

            if ($response > 0) {

                return response()->json(['message' => 'success', 'status_code' => 200]);
            } else {

                return response()->json(['errors' => 'record already exists', 'status_code' => 412]);
            }
        } else {
            return response()->json(['errors' => 'action failed', 'status_code' => 412]);

        }

    }

    public function editEmployeeView($id)
    {
        $employeeDetailData = EmployeeRepository::employeeEditDetail($id);
        Log::debug('The data',[$employeeDetailData]);

        return view('employees.edit', ["employeeData" => $employeeDetailData]);
    }

    public function editEmployee(Request $request)
    {
        Log::debug('The Req',[$request->all()]);

        $response = EmployeeRepository::editEmployee($request);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);
        }


    }
}