<?php

/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:35
 */
namespace App\Repositories;

use App\Designation;
use Request;

class DesignationRepository
{
    public static function getDesignations()
    {
        try {
            // get product id and name.

            $query = Designation::where('status', '=', 'ACTIVE')
                ->get(['id', 'designation_name']);
            return $query;
        } catch (Exception $e) {
            \Log::error('Exception while fetching designations = ' . [$e]);

            return null;
        }

    }
    public static function createDesignation($request){
        $designation = new Designation();
        $designation->designation_name = $request->designation_name;
        $designation->description = $request->description;
        $designation->added_by = 1;
        $designation->modified_by = 1;
        $designation->ip_address = Request::ip();
        $designation->status = $request->status;

        return $designation->save();
    }
    
    public static function DoesDesignationExists($designation_name){
        $query = Designation::where('designation_name', '=', $designation_name)->first();
        if ($query === null) {
           return false; 
        }
        return true;
    }
}