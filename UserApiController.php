<?php

namespace App\plugins\Api\Controllers;

use App\Http\Controllers\Admin\MyAdminController;
use App\Http\Controllers\Bz;
use App\Models\UserModel;
use Exception;

class UserApiController extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * getUsers
     */
    public static function getUsers($formData = [])
    {
    }

    /**
     * searchUsersForDropdown
     * Api for select 2
     */
    public function searchUsersForDropdown()
    {
        try {
            $formData = request()->all();
            $query = UserModel::query();
            $query->select([
                'id',
                'name as text',
                'email',
                'mobile1',
                'mobile1',
            ]);
            $query->where('status', 1);
            $query->where('role_id', ROLE_CUSTOMER);
            if (isset($formData['id']) && $formData['id']) {
                $query->where('id', $formData['id']);
            }
            if (isset($formData['search']) && !empty($formData['search'])) {
                $query->where(function ($q) use ($formData) {
                    $q->orWhere('name', 'like', "%{$formData['search']}%");
                    $q->orWhere('first_name', 'like', "%{$formData['search']}%");
                    $q->orWhere('email', 'like', "%{$formData['search']}%");
                    $q->orWhere('mobile1', 'like', "%{$formData['search']}%");
                });
            }

            $query->limit(20);
            $this->ajax_data['results'] = $query->get();
            $this->ajax_msg[] = "Records fetched";
            return $this->mk_print_ajax_error_json(1, 1, 1);
        } catch (Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }
}
