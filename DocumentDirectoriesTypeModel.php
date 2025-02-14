<?php

namespace App\plugins\Api\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentDirectoriesTypeModel extends Model
{
    protected $table = 'document_directories_type';
    protected $fillable = [];
    protected $casts = [
        'meta_data' => 'array',
    ];

    /**
     * getDocumentDirID
     * App\plugins\Api\Models\DirectoriesModel::getDocumentDirID()
     */
    public static function getDocumentDirID()
    {
        return 4;
    }

    
}
