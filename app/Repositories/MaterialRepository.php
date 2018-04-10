<?php

/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:34
 */

namespace App\Repositories;

use App\Material;
use App\ViewModels\MaterialView;
use Yajra\Datatables\Datatables;


class MaterialRepository
{
    public static function getMaterialsData()
    {
        try {
            $query = MaterialView::where('material_status', '=', 'ACTIVE')
                ->get(['material_id', 'material_name']);
            if (empty($query)) {
                return null;
            }
            return $query;
        } catch (\Exception $e) {
            \Log::error('Exception while fetching materials = ' . [$e]);

            return null;
        }

    }

    public static function createMaterial($materialParams)
    {
        unset($materialParams['_token']);
        $materialParams['added_by'] = 1;
        $materialParams['modified_by'] = 1;
        $materialParams['status'] = 'ACTIVE';
        try {
            \Log::debug('The params=>', [$materialParams]);
            $response = Material::insert($materialParams);

            return $response;

        } catch (\Exception $e) {
            \Log::error('Exception while saving material = ' . [$e]);

            return null;
        }

    }

    public static function getAllMaterialsData()
    {
        try {
            $query = MaterialView::select()
                ->where('material_status', '=', 'ACTIVE');
            return Datatables::of($query)
                ->make(true);
        } catch (\Exception $e) {
            \Log::error('Exception while fetching all materials data = ' . [$e]);

            return null;
        }

    }

    public static function editMaterial($request)
    {
        try {
            $params = [
                'name' => $request['material_name'],
                'description' => $request['description'],
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'modified_by' => 1
            ];
            return Material::find($request['material_id'])
                ->update($params);

        } catch (\Exception $e) {
            \Log::error('Exception while editing material = ' . [$e]);

            return null;
        }

    }
    public static function uploadMaterialImage($request)
    {
        try {

            $file = $request['material_image'];

            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/materials';
            $file->move($destinationPath, $fileName);
            $params = [
                'image' => $fileName,
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'modified_by' => 1
            ];
            return Material::find($request['material_id'])
                ->update($params);

        } catch (\Exception $e) {
            \Log::error('Exception while adding materials Image = ' . [$e]);

            return null;
        }

    }

    public static function deactivateMaterial($id)
    {
        try {

            $material = Material::find($id);

            $material->status = 'IN-ACTIVE';

            return $material->save();

        } catch (\Exception $e) {
            \Log::error('Exception while deactivating material = ' . [$e]);

            return null;
        }

    }
    public static function getMaterialImages()
    {
        try {

            $query = MaterialView::where('material_status','=','ACTIVE')
            ->get(['material_name','material_image']);

            return $query->toArray();

        } catch (\Exception $e) {
            \Log::error('Exception while fetching for material images' . [$e]);

            return null;
        }

    }

}