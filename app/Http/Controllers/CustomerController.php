<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:35
 */

namespace App\Http\Controllers;


use App\Customer;
use App\Repositories\CustomerRepository;
use App\ViewModels\CustomerView;
use Illuminate\Http\Request;
use MeasurementRepository;
use function view;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Log;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.list');
    }

    public function getAllCustomersData()
    {
        $customers = CustomerView::select(['customer_id', 'customer_name', 'customer_email','customer_mobile_no','location','customer_id_no','addedby_user_name', 'customer_status', 'created_at'])
            ->where('customer_status','=','ACTIVE');
        return Datatables::of($customers)
            ->make(true);
    }

    public function export()
    {
        $fileType = 'xls';
        $customersData = CustomerView::all();
        Excel::create('customers-data', function ($excel) use ($customersData) {
            $excel->sheet('ExportFile', function ($sheet) use ($customersData) {
                $sheet->fromArray($customersData);
            });

        })->store($fileType, storage_path('excel/exports'));

        $files = storage_path('excel/exports');
        $zipFile = storage_path('excel/exports/mytest3.zip');

        $zipper = new \Chumper\Zipper\Zipper;
        $zipper->make($zipFile)->add($files);

        return response()->download($zipFile);
    }

    public function deativateCustomer(Request $request)
    {
        $response = CustomerRepository::deactiveCustomer($request['customer_id']);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);

        }
    }

    public function createCustomer(Request $request)
    {
        $user = Customer::where('email', '=', $request->email)->first();
        if ($user === null) {
            $response = CustomerRepository::createCustomer($request);

            if ($response > 0) {

                return response()->json(['message' => 'success', 'status_code' => 200]);
            } else {

                return response()->json(['errors' => 'action failed', 'status_code' => 500]);
            }
        }

    }

    public function editCustomer(Request $request)
    {
        $response = CustomerRepository::editCustomer($request);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);
        }


    }
    public function getCustomersData(Request $request)
    {
        $query = $request->get('q', '');

        $response = CustomerRepository::getCustomersData($query);
        if (null === $response) {
            return response()->json(['errors' => [
                ['message' => 'There is no customer found '],
            ]], 422);
        }
        return response()->json($response);
    }

}