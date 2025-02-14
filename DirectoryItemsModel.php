<?php

namespace App\plugins\Api\Models;

use App\Models\UserModel;
use App\plugins\Api\Controllers\MediaApiController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DirectoryItemsModel extends Model
{
    protected $table = 'directories_items';
    protected $guarded = [];
    protected $fillable = [];
    protected $casts = [
        'meta_data' => 'array',
    ];

    /**
     * file_type_img_url
     */
    public function  getFileTypeImgUrlAttribute()
    {
        return asset($this->type . ".png");
    }

    /**
     * public_name
     * Which will be used to display data
     */
    public function  getPublicNameAttribute()
    {
        return $this->meta_data['public_name'] ?? $this->title;
    }

    public function  directoryType()
    {
        return $this->hasOne(DocumentDirectoriesTypeModel::class,'id','directory_type_id');
    }

    /**
     * dir_tail
     */
    public function getDirTailAttribute()
    {
        if (!$this->directory_id) {
            return "";
        }
        $string = MediaApiController::tc_get_directory_tail_string($this->directory_id);
        if ($string) {
            $arr = explode("/", $string);
            return $arr[count($arr) - 2];
        }
    }

    public function directory(){
        return $this->hasOne(DirectoriesModel::class,  'id','directory_id',);
    }

    /**
     * 
     * uploaded_date
     */
    public function getuploadedDateAttribute()
    {
        $date = Carbon::parse($this->created_at);
        return $date->format('d-m-Y h:i:s A');
    }

    /**
     * status_text
     */
    public function getstatusTextAttribute()
    {
        $status_text = "Processed";
        if (!$this->status) {
            $status_text = "Not Processed";
        }

        return apply_filters('dir_item_status_text',$status_text);
    }

    /**
     * Return owner details of the item 
     */
    public function getownerDetailsAttribute()
    {
        if (!$this->user_id) {
            return [];
        }
        $user = UserModel::find($this->user_id);
        if (empty($user)) {
            return [];
        }
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }

    /**
     * getaddedByAttribute
     * added by user details
     * added_by
     */
    public function getaddedByAttribute()
    {
        if (!$this->add_user) {
            return [];
        }
        $user = UserModel::find($this->add_user);
        if (empty($user)) {
            return [];
        }
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }


    /**
     * transformResultsForApi
     * transform data for api
     */
    public static function transformResultsForApi($itemModel)
    {
        $data = [];
        $data['id'] = $itemModel->id;
        $data['title'] = $itemModel->meta_data['public_name'] ?? $itemModel->title;
        $data['sales_expense'] = $itemModel->meta_data['sales_expense'] ?? '';
        $data['file_type_img_url'] = $itemModel->file_type_img_url;
        $data['uploaded_date'] = $itemModel->uploaded_date;
        $data['formatted_uploaded_date'] = date("d/m/Y",strtotime($itemModel->uploaded_date));
        $data['formatted_uploaded_time'] = date("h:i:s A",strtotime($itemModel->uploaded_date));
        $data['uploaded_in'] = ucfirst($itemModel->dir_tail);
        $data['type'] = $itemModel->type;
        $data['full_url'] = dc_get_document_asset_url($itemModel->full_url);
        $data['user_id'] = $itemModel->user_id;
        $data['add_user'] = $itemModel->add_user;
        return $data;
    }
}
