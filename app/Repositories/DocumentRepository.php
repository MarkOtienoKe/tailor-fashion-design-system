<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 20/02/2018
 * Time: 14:35
 */

namespace App\Repositories;


use App\Document;
use App\ViewModels\DocumentView;
use Request;
use Yajra\Datatables\Datatables;


class DocumentRepository
{
    public static function saveDoc($request)
    {
        $file = $request['document_file'];

        $fileName = $file->getClientOriginalName();
        $destinationPath = public_path() . '/uploads/Documents';
        $file->move($destinationPath, $fileName);
        $params=[
            'document_file'=>$fileName,
            'added_by'=>1,
            'modified_by'=>1,
            'document_type'=>$request['document_type'],
            'document_name'=>$request['document_name'],
            'status'=>'ACTIVE',
            'ip_address'=>Request::ip(),
        ];
        return Document::insert($params);
    }

    public static function getAllDocuments()
    {
        try {
            $query = DocumentView::select()
                ->where('document_status', '=', 'ACTIVE');
            return Datatables::of($query)
                ->make(true);
        } catch (\Exception $e) {
            \Log::error('Exception while fetching documents data' . [$e]);

            return null;
        }

    }
    public static function getDocumentName($docId)
    {
        try {
            $query = DocumentView::where('document_id','=',$docId)
                ->get(['document_file']);
            if(empty($query)){
                return null;
            }
            return $query[0];
        } catch (\Exception $e) {
            \Log::error('Exception while fetching document name' . [$e]);

            return null;
        }

    }

    public static function deactivateDocument($id)
    {
        try {

            $document = Document::find($id);

            $document->status = 'IN-ACTIVE';

            return $document->save();

        } catch (\Exception $e) {
            \Log::error('Exception while deactivating Document = ' . [$e]);

            return null;
        }

    }
}