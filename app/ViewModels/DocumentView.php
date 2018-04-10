<?php
namespace App\ViewModels;

use Illuminate\Database\Eloquent\Model;


class DocumentView extends Model
{
    protected $table = 'vw_documents';
    protected $primaryKey = 'document_id';
}