<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 22/02/2018
 * Time: 19:53
 */

namespace App\Repositories;


use App\ClotheType;

class ClotheTypeRepository
{
    public static function getClotheTypesData()
    {
        try {
            $query = ClotheType::where('status', '=', 'ACTIVE')
                ->get(['id', 'name']);
            return $query;
        } catch (Exception $e) {
            \Log::error('Exception while fetching clothe types = ' . [$e]);

            return null;
        }

    }
}