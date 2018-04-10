<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 22/02/2018
 * Time: 19:46
 */

namespace App\Http\Controllers;


use App\Repositories\MaterialRepository;
use function collect;
use Illuminate\Http\Request;
use function response;
use function view;
use Log;

class MaterialController extends Controller
{
    public function getMaterialsData()
    {
        $response = MaterialRepository::getMaterialsData();
        if (null === $response) {
            return response()->json(['errors' => [
                ['message' => 'There is no material found '],
            ]], 422);
        }
        return $response;
    }

    public function index()
    {
        return view('materials.list');
    }

    public function getAllMaterials()
    {
        $response = MaterialRepository::getAllMaterialsData();

        return $response;
    }

    public function createMaterial(Request $request)
    {
        $response = MaterialRepository::createMaterial($request->all());
        if ($response == true) {
            return response()->json([
                'status' => 'success',
                'message' => 'Material successfully created.',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something Went wrong.Try Again.',
            ], 500);
        }
    }

    public function editMaterial(Request $request)
    {
        $this->validate($request, [
            'material_name' => 'required',
        ]);

        $response = MaterialRepository::editMaterial($request->all());
        if ($response == true) {
            return response()->json([
                'status' => 'success',
                'message' => 'Material Image successfully Added.',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something Went wrong.Try Again.',
            ], 500);
        }
    }

    public function uploadMaterialImage(Request $request)
    {
        $this->validate($request, [
            'material_image' => 'required',
        ]);

        $response = MaterialRepository::uploadMaterialImage($request->all());
        if ($response == true) {
            return response()->json([
                'status' => 'success',
                'message' => 'Material Image successfully Added.',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something Went wrong.Try Again.',
            ], 500);
        }
    }

    public function deactivateMaterial(Request $request)
    {
        $response = MaterialRepository::deactivateMaterial($request['material_id']);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);

        }
    }
    public function viewMaterialImages()
    {
        $pageData = collect([]);
        $pageData->put('title','View Images');
        $iamges = MaterialRepository::getMaterialImages();
        $pageData->put('material_images',$iamges);
        \Log::debug('the page data=>',[$pageData]);

        return view('materials.view-images',['pageData'=>$pageData]);
    }
}