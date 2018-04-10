<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 27/02/2018
 * Time: 15:41
 */

namespace App\Http\Controllers;


use App\Repositories\MeasurementRepository;
use Illuminate\Http\Request;
use Log;

class MeasurementController extends Controller
{
    public function index($customerId)
    {
        return view('measurements.customer-measurement',["customerId" => $customerId]);
    }

    public function getMeasurements($customerId)
    {
        $data = MeasurementRepository::getMeasurement($customerId);

        return $data;

    }
    public function viewMeasurementDetails($measurementId)
    {
        $pageData =null;
        $response = MeasurementRepository::getMeasurementDetail($measurementId);
        foreach ($response as $data){
            $pageData=$data;
        }
        return view('measurements.view-measurement-details', ["pageData" => $pageData]);

    }
    public function addMeasurementView($customerId)
    {

        return view('measurements.add-measurement', ["customerId" => $customerId]);

    }
    public function saveMeasurementsData(Request $request)
    {
        $response = MeasurementRepository::createMeasurement($request->all());
        if($response==true){

            return response()->json(['message' => 'success', 'status_code' => 200]);
        }else{
            return response()->json(['errors' => 'action failed', 'status_code' => 500]);
        }
    }
    public function editMeasurement(Request $request)
    {
        $response = MeasurementRepository::editMeasurement($request->all());
        if($response==true){

            return response()->json(['message' => 'success', 'status_code' => 200]);
        }else{
            return response()->json(['errors' => 'action failed', 'status_code' => 500]);
        }
    }
    public function deactivateMeasurement(Request $request)
    {
        $response = MeasurementRepository::deactivateMeasurement($request['measurement_id']);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);

        }
    }
}