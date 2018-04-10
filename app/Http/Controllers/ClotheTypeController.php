<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 22/02/2018
 * Time: 19:52
 */

namespace App\Http\Controllers;


use App\Repositories\ClotheTypeRepository;
use Illuminate\Http\Request;

class ClotheTypeController extends Controller
{
    public function getClotheTypesData()
    {
        $response = ClotheTypeRepository::getClotheTypesData();
        if (null === $response) {
            return response()->json(['errors' => [
                ['message' => 'There is no clothe type found '],
            ]], 422);
        }
        return $response;
    }
}