<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 17/03/2018
 * Time: 11:43
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\DocumentRepository;
use function view;

class DocumentController extends Controller
{
    public function index()
    {
        return view('documents.list');
    }

    public function getAllDocuments()
    {
        $response = DocumentRepository::getAllDocuments();

        return $response;
    }
    public function saveDocument(Request $request)
    {
        $response = DocumentRepository::saveDoc($request);

        if($response>0){
            return response()->json(['message' => 'success', 'status_code' => 200]);
        }else{
            return response()->json(['errors' => 'action failed', 'status_code' => 500]);
        }

    }
    public function downloadDocument($documentId)
    {
        $response = DocumentRepository::getDocumentName($documentId);

        $filePath = public_path() . "/uploads/Documents/".$response->document_file;
        return response()->download($filePath);
    }

    public function deactivateDocument(Request $request)
    {
        $response = DocumentRepository::deactivateDocument($request['document_id']);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);

        }
    }

}