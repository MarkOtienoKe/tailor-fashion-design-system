<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 17/02/2018
 * Time: 19:37
 */

namespace App\Http\Controllers;


use App\Repositories\DesignationRepository;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function getDesignationData()
    {
        $response = DesignationRepository::getDesignations();
        if (null === $response) {
            return response()->json(['errors' => [
                ['message' => 'There is no designation found '],
            ]], 422);
        }
        return $response;
    }
    public function createDesignation(Request $request)
    {
        if(DesignationRepository::DoesDesignationExists($request->designation_name)==true){

            return response()->json(['errors' => 'action failed', 'status_code' => 412]);
        }

        $response = DesignationRepository::createDesignation($request);
        if($response!=true){

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);

        }

        return response()->json(['message' => 'success', 'status_code' => 200]);
    }
}