<?php

/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:34
 */

namespace App\Repositories;

use App\Measurement;
use App\ViewModels\MeasurementView;
use Yajra\Datatables\Datatables;
use Log;

class MeasurementRepository
{

    public static function getMeasurement($customerId)
    {
        try {
            $query = MeasurementView::select(['measurement_id', 'measurement_date', 'measurements_person_name', 'description', 'measurement_status', 'addedby_user_name'])
                ->where('customer_id', '=', $customerId)
                ->where('measurement_status', '=', 'ACTIVE');
            return Datatables::of($query)
                ->make(true);

        } catch (Exception $e) {
            \Log::error('Exception while fetching customer measurements = ' . [$e]);

            return null;
        }

    }

    public static function getMeasurementDetail($measurementId)
    {
        try {
            $query = MeasurementView::where('measurement_id', '=', $measurementId)
                ->get();
            if (empty($query)) {
                return null;
            }
            return $query;
        } catch (Exception $e) {
            \Log::error('Exception while fetching measurements details = ' . [$e]);

            return null;
        }

    }

    public static function createMeasurement($measurementParameters)
    {
        unset($measurementParameters['_token']);
        $measurementParameters['added_by'] = 1;
        $measurementParameters['modified_by'] = 1;
        try {
            return Measurement::insert($measurementParameters);
        } catch (Exception $e) {
            \Log::error('Exception while saving measurement = ' . [$e]);

            return null;
        }

    }

    public static function editMeasurement($measurementParameters)
    {
        unset($measurementParameters['_token']);
        $measurementParameters['added_by'] = 1;
        $measurementParameters['modified_by'] = 1;

        try {
            return Measurement::find($measurementParameters['measurement_id'])
                ->update($measurementParameters);
        } catch (\Exception $e) {
            \Log::error('Exception while editing measurement = ' . [$e]);

            return null;
        }

    }
    public static function deactivateMeasurement($id)
    {
        try {

            $measurement = Measurement::find($id);

            $measurement->status = 'IN-ACTIVE';

            return $measurement->save();

        } catch (\Exception $e) {
            \Log::error('Exception while deactivating Measurement = ' . [$e]);

            return null;
        }

    }
}