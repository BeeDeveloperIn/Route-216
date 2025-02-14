<?php


namespace App\Http\Controllers\Admin\Auth;


use App\Http\Controllers\Admin\MyAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleCaps extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        #check access 
        if (!$this->has_operation_access("edit_role_caps")) {
            return $this->show_invalid_access();
        }
        $request = \request();
        $formData = $request->all();
        $this->set_list_data($request, $formData);
        return $this->renderAdminView('auth/rolecaps');
    }

    /**
     * @param $request
     * @param array $formData
     */
    private function set_list_data($request, $formData = [])
    {

        // set limit and offset logic
        $page = 0; // current page
        $limit = 10;

        if (isset($formData['limit']) && $formData['limit'] != "") {
            $limit = $formData['limit'];
        }

        // request search
        if (isset($formData['offset']) && $formData['offset'] != "") {
            $page = $formData['offset'];
        }
        $formData['limit'] = $limit; // filter
        $formData['page'] = $page; // filter
        $this->data['current_page'] = $page + 1; // for table serial number

        // get caps instance and post model query

        $roleCapsModel = mkGetModelInstance('RoleCapsModel', 'Auth');
        $this->data['caps'] = $roleCapsModel->getCaps($formData); // get table data

        // get total rows
        $formData['count'] = true;
        $this->data['caps']->total_rows = $roleCapsModel->getCaps($formData);
        // end get total rows filter

        // make pagination
        $pagination = getPaginationInstance();

        $unsetVars = ['count', '_token', 'offset'];
        foreach ($unsetVars as $var) {
            if (isset($formData[$var])) {
                unset($formData[$var]);
            }
        }

        $config['base_url'] = route('admin.roleCaps', $formData);
        $config['total_rows'] = $this->data['caps']->total_rows;
        $config['query_string_segment'] = 'offset';
        $config['per_page'] = $limit;
        $pagination->initialize($config);
        $this->data['pagination_links'] = $pagination->create_links();
        // end pagination

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add($cap_id = 0)
    {
        #check access 
        if (!$this->has_operation_access("edit_role_caps")) {
            return $this->show_invalid_access();
        }


        $this->data['cap'] = [];
        if ($cap_id) {
            $roleCapsModel = mkGetModelInstance('RoleCapsModel', 'Auth');
            $this->data['cap'] = $roleCapsModel->getSingleCap($cap_id);
        } else {
            // do set for default
            $capData = array();
            $capData['cap_name'] = old('cap_name');
            $capData['cap_slug'] = old('cap_slug');
            $capData['status'] = old('status');
            $capData['role_ids'] = old('roles');
            $this->data['cap'] = $capData;
        }

        $roleModel = mkGetModelInstance('RoleModel', 'Auth');
        $roles = $roleModel->get_roles(['status' => 1]);

        // Mark check role ids
        if (!empty($this->data['cap']) && $this->data['cap']['role_ids']) {
            $selected_roles = explode(',', $this->data['cap']['role_ids']);
            foreach ($roles as $index => $each_role) {
                if (in_array($each_role['role_id'], $selected_roles)) {
                    $roles[$index]['checked'] = 1;
                }
            }
        }

        $this->data['roles'] = $roles;
        return $this->renderAdminView('auth/addRoleCaps');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            #check access 
            if (!$this->has_operation_access("edit_role_caps")) {
                return $this->show_invalid_access();
            }
            $_errs = [];
            $formData = $request->all();
            // Validate role caps data
            $this->validateStoreData($formData, $_errs);
            if (!empty($_errs)) {
                return redirect()->back()->with('error_message', implode(", ", $_errs))->withInput($formData);
            }

            $roleCapsModel = mkGetModelInstance('RoleCapsModel', 'Auth');
            $data_to_store = [
                'cap_name' => $formData['cap_name'],
                'cap_slug' => $formData['cap_slug'],
                'status' => $formData['status']
            ];

            // if root user then allow to change for strict
            if (is_root_admin()) {
                if (isset($formData['strict']) && $formData['strict'] != '') {
                    $data_to_store['strict'] = $formData['strict'];
                }
            }


            $cap_id = (isset($formData['id']) && !empty($formData['id'])) ? $formData['id'] : '';

            // Insert & Update capability
            $cap_id = $roleCapsModel->store($data_to_store, $cap_id);

            if (!$cap_id) {
                return redirect()->back()->with('error_message', __('rolecaps.caps_storing_error'));
            }

            $permissionModel = mkGetModelInstance('PermissionModel', 'Auth');

            // Deleting existing capability roles
            $permissionModel->delete_by_cap_id($cap_id);

            $cap_and_roles = [];
            foreach ($formData['roles'] as $each_role) {
                $cap_and_roles[] = [
                    'cap_id' => $cap_id,
                    'role_id' => $each_role
                ];
            }

            //            Saving roles with capability
            $permissionModel->store($cap_and_roles);

            return redirect()->back()->with('success_message', __("common.details_saved_updated"));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error_message', $exception->getMessage());
        }
    }

    /**
     * @param $formData
     * @throws \Exception
     */
    private function validateStoreData($formData, &$_errs)
    {
        $cap_id = (isset($formData['id']) && !empty($formData['id'])) ? $formData['id'] : '';

        //        validate caps name
        if (!isset($formData['cap_name']) || empty($formData['cap_name'])) {
            $_errs[] = __('rolecaps.caps_name_required');
        }

        //        validate caps slug
        if (!isset($formData['cap_slug']) || empty($formData['cap_slug'])) {
            $_errs[] = __('rolecaps.caps_slug_required');
        } elseif (!preg_match('/[a-zA-Z_-]/', $formData['cap_slug'])) {
            $_errs[] = __('rolecaps.caps_slug_invalid');
        } else {
            $roleCapsModel = mkGetModelInstance('RoleCapsModel', 'Auth');
            if ($roleCapsModel->slug_exist($formData['cap_slug'], $cap_id)) {
                $_errs[] = __('rolecaps.caps_slug_exist');
            }
        }

        //        validate caps status
        if (!isset($formData['status']) || !in_array($formData['status'], ['0', '1'])) {
            $_errs[] = __('rolecaps.status_required');
        }

        //        validate caps roles
        if (!isset($formData['roles']) || empty($formData['roles'])) {
            $_errs[] = __('rolecaps.roles_required');
        }
    }

    /**
     * @param Request $request
     * @param $cap_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $cap_id)
    {
        #check access 
        if (!$this->has_operation_access("delete_role_caps")) {
            return $this->show_invalid_access();
        }

        // check cap is strict or not because few caps are interconnected for internal system use

        $roleCapsModel = mkGetModelInstance('RoleCapsModel', 'Auth');
        $capDetails = $roleCapsModel->getSingleCap($cap_id);
        if (isset($capDetails['strict']) && (int)$capDetails['strict']) {
            // this is strict mode for this cap
            // do restrict other user for delete
            // or we can check cap mode here who can delete these strict caps
            return redirect()->back()->with('error_message', __('rolecaps.strict_cap_del_error'));
//            if (!is_root_admin()) {
//                return redirect()->back()->with('error_message', __('rolecaps.caps_delete_error'));
//            }
        }

        // first delete all permissions
        $permissionModel = mkGetModelInstance('PermissionModel', 'Auth');
        //            Deleting existing capability roles
        $permissionModel->delete_by_cap_id($cap_id);

        // then delete cap details from the system
        if ($roleCapsModel->delete_cap($cap_id)) {
            return redirect()->back()->with('success_message', __('rolecaps.caps_delete_succ'));
        } else {
            return redirect()->back()->with('error_message', __('rolecaps.caps_delete_error'));
        }
    }
}
