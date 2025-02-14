<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Admin\MyAdminController;
use App\Http\Controllers\Bz;
use App\Http\Controllers\CustomValidations;
use App\Http\Controllers\includes\abstracts\Abstract_user;
use App\Models\UserModel;
use App\plugins\Api\Models\DirectoryItemsModel;
use App\plugins\Api\Models\DocumentDirectoriesTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;


class Users extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param $formData
     * @param $user_type
     * @return void
     * setUserListingVars
     * Set user listing variables
     */
    public function setUserListingVars($formData = array(), $user_type = 'user')
    {
        // if registered date is coming
        if (!@$formData['registered_at']) {
            $formData['fromDate'] = Carbon::now()->startOfMonth()->toDateString();
            $formData['toDate'] = Carbon::now()->toDateString();
        } else {
            $upload_date = explode('to', $formData['registered_at']);
            $formData['fromDate'] = trim(current($upload_date));
            $formData['toDate'] = trim($upload_date[1]);
        }


        // set limit and offset logic
        $page = 0; // current page
        $limit = 50;
        $formData['limit'] = $limit; // filter
        $formData['page'] = isset($formData['offset']) ? $formData['offset'] : 0;; // filter
        // get post instance and post model query
        $userModel = mkGetModelInstance('UserModel', 'Users', array('table' => $user_type));
        $users = UserModel::get_users($formData, $userModel); // get table data

        // get total rows
        $formData['count'] = true;
        $this->data['results'] = $users;
        $this->data['user_type'] = $user_type;
        $this->data['roles'] = $userModel->get_active_roles();
    }


    /**
     * @param Request $request
     * @param $user_type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * index
     * user listing display
     */
    public function index(Request $request, $user_type = "user")
    {
        #check access
        if (!$this->has_operation_access("edit_{$user_type}")) {
            return $this->show_invalid_access();
        }

        $formData = $request->all();
        $this->setUserListingVars($formData);


        // load view
        $view = 'users/' . $user_type . '-list';
        if (\Illuminate\Support\Facades\View::exists("admin/$view")) {
            // check in admin
            return $this->renderAdminView("admin/$view");
        } else if (\Illuminate\Support\Facades\View::exists($view)) {
            // check in plugin
            return $this->renderAdminView($view);
        } else {
            // load from default
            $view = 'users/default-list';
            return $this->renderAdminView($view);
        }
    }

    /*
     * addUser
     * This will manage user creation in system
     */
    public function addUser($user_type = "user", $user_id = false)
    {



        #check access
        if (!$this->has_operation_access("edit_{$user_type}")) {
            return $this->show_invalid_access();
        }

        // get user model instance
        $userModel = mkGetModelInstance('UserModel', 'Users', array('table' => $user_type));

        // set user var
        $this->data['user'] = [
            'country_ext' => "0",
            'user_meta_data' => (object)array()
        ];
        $this->data['user']['role_id'] = (string)ROLE_CUSTOMER; // set default role id

        // if user id is coming | This is update case
        if ($user_id) {
            // get user data from the DB
            $this->data['user'] = $userModel->get_users(array("id" => $user_id));
            $this->data['user']['user_meta_data'] = (empty(get_formatted_user_meta_data($user_id))) ? (object)array() : get_formatted_user_meta_data($user_id);
        }




        // included general options files for validate country and state
        // Set vars of data
        $this->data['user']['user_type'] = $user_type;
        $this->data['countries'] = get_countries_list();
        $this->data['states'] = (isset($this->data['user']['country']) && $this->data['user']['country']) ? get_states_list($this->data['user']['country']) : array();
        $this->data['user_type'] = $user_type;
        $this->data['users_roles'] = $userModel->get_active_roles(); // get all active roles in system
        // Post view file
        // sample file: users/customer-add
        $view = 'users/' . $user_type . '-add';
        if (\Illuminate\Support\Facades\View::exists("admin/$view")) {
            // check in admin
            return $this->renderAdminView("admin/$view");
        } else if (\Illuminate\Support\Facades\View::exists($view)) {
            // check in plugin
            return $this->renderAdminView($view);
        } else {
            // load from default
            $view = 'users/default-add';
            return $this->renderAdminView($view);
        }
    }

    // create_user
    // Manage create of update user from the admin
    public function create_user(Request $request)
    {
        $data_to_insert = array();

        try {

            $request = $request->post();
            $formData = json_decode($request['user'], 1);

            #check access
            if (!$this->has_operation_access("edit_{$formData['user_type']}")) {
                return $this->show_invalid_access();
            }

            // validate user form details
            $this->validate_user_data($formData);
            $id = (isset($formData['id']) && !empty($formData['id'])) ? $formData['id'] : '';

            $data_to_insert['first_name'] = $formData['name'] ?? $formData['name'];
            $data_to_insert['name'] = $data_to_insert['first_name'];

            if (!isset($formData['name']) || (isset($formData['name'])) && empty($formData['name'])) {
                $data_to_insert['name'] = $data_to_insert['first_name'];
                if (isset($formData['last_name']) && $formData['last_name'] != "") {
                    $data_to_insert['name'] = $formData['name'] . ' ' . $formData['last_name'];
                }
            }
            $data_to_insert['last_name'] = (isset($formData['last_name']) && !empty($formData['last_name'])) ? $formData['last_name'] : null;
            $data_to_insert['mobile1'] = $formData['mobile1'] ?? null;
            $data_to_insert['mobile2'] = (isset($formData['mobile2']) && !empty($formData['mobile2'])) ? $formData['mobile2'] : null;
            $data_to_insert['email'] = $formData['email'];
            $data_to_insert['username'] = @$formData['username'];
            $data_to_insert['membership_id'] = @$formData['membership_id'];
            $data_to_insert['status'] = (isset($formData['status']) && in_array($formData['status'], array(0, 1))) ? $formData['status'] : 1;
            // we can manage block status separately
            if (isset($formData['status'])) {
                $data_to_insert['is_blocked'] = !$formData['status'];
            }
            $data_to_insert['country'] = (isset($formData['country']) && !empty($formData['country'])) ? $formData['country'] : null;
            $data_to_insert['country_ext'] = $formData['country_ext'] ?? null;
            $data_to_insert['state'] = (isset($formData['state']) && !empty($formData['state'])) ? $formData['state'] : null;
            $data_to_insert['city'] = (isset($formData['city']) && !empty($formData['city'])) ? $formData['city'] : null;
            $data_to_insert['pincode'] = (isset($formData['pincode']) && !empty($formData['pincode'])) ? $formData['pincode'] : null;
            $data_to_insert['address_line1'] = (isset($formData['address_line1']) && !empty($formData['address_line1'])) ? $formData['address_line1'] : null;
            $data_to_insert['address_line2'] = (isset($formData['address_line2']) && !empty($formData['address_line2'])) ? $formData['address_line2'] : null;
            $data_to_insert['role_id'] = ROLE_CUSTOMER; // default role

            // dd($data_to_insert);
            # set password states
            if ($id) {
                // in update case if update password is checked then do update else skip
                if (isset($formData['update_password']) && $formData['update_password']) {
                    $data_to_insert['password'] = Hash::make($formData['password']);
                }
            } else {
                // in create case make hash of password
                if (isset($formData['password']) && $formData['password'] != "") {
                    $data_to_insert['password'] = Hash::make($formData['password']);
                } else {
                    $data_to_insert['password'] = Hash::make('manoj#tags');
                }
            }

            // Allow and set role id permit
            $allowRoleIdEdit = array(ROLE_ROOT_USER, ROLE_ADMIN);
            if (in_array(get_current_user_role_id(), $allowRoleIdEdit)) {
                if (isset($formData['role_id']) && $formData['role_id'] != "") {
                    $data_to_insert['role_id'] = $formData['role_id'];
                }
            } else {
                // do unset role id
                if (isset($data_to_insert['role_id'])) {
                    unset($data_to_insert);
                }
            }


            // here check profile image is coming or not 
            // if coming then save to media manager
            if (isset($_FILES['fileInput']) && !empty($_FILES['fileInput'])) {
                $data = UserModel::uploadProfileImageToMedia();
                if ($data->succ) {
                    $uploadedItems = $data->data->uploaded_items;
                    $data_to_insert['profile_picture']  = current($uploadedItems)->full_url;
                }
            }

            $userModel = new Abstract_user();
            // Save OR Update user data
            if ($id) {
                $user_id = $userModel->update_user($data_to_insert, $id, $formData);
            } else {
                $user_id = $userModel->insert_user($data_to_insert, $formData);
            }
            if (!$user_id) {
                throw new Exception(__("common.throw_error"));
            }


            $this->ajax_data['redirect'] = route('admin.users', ['user_type' => $formData['user_type']]);
            // $this->ajax_data['redirect'] = route('admin.editUser', ['user_type' => $formData['user_type'], 'user_id' => $user_id]);
            $this->ajax_msg[] = __('common.details_saved_updated');
            return $this->mk_print_ajax_error_json(true); // print error
        } catch (Exception $e) {
            $this->ajax_errors[] = $e->getMessage();
            return $this->mk_print_ajax_error_json(false); // print errors
        }
    }

    /*
     * @ validate_user_data
     * Validate user form data
     */
    private function validate_user_data($formData)
    {
        if (empty($formData)) {
            throw new Exception(__("common.throw_error"));
        }

        // check user type
        if (!isset($formData['user_type']) || empty($formData['user_type'])) {
            throw new Exception("User type is required");
        }

        $errs = [];
        // get user model instance
        $userModel = mkGetModelInstance('UserModel', 'Users', array('table' => $formData['user_type']));

        $name = @$formData['name'] ?? @$formData['first_name'];
        // Validate fist name
        if (!isset($name)) {
            throw new Exception(__("user.name_required"));
        } elseif (!preg_match('/^[a-zA-Z. ]+$/', $name)) {
            throw new Exception(__("user.first_name_exp"));
        } elseif (strlen($name) < CustomValidations::nameMinLength() || strlen($name) > CustomValidations::nameMaxLength()) {
            throw new Exception(__("user.name_length"));
        }
        // Valiate last name
        if (isset($formData['last_name']) && !empty($formData['last_name'])) {
            if (!preg_match('/^[a-zA-Z. ]+$/', $formData['last_name'])) {
                throw new Exception(__("user.last_name_exp"));
            } elseif (strlen($formData['last_name']) < CustomValidations::nameMinLength() || strlen($formData['last_name']) > CustomValidations::nameMaxLength()) {
                throw new Exception(__("user.last_name_length"));
            }
        }

        // Validate mobile 1 doing optonal mobile
        if (isset($formData['mobile1']) && $formData['mobile1'] != "") {

            if (!isset($formData['mobile1']) || empty($formData['mobile1'])) {
                throw new Exception(__("user.mobile1_required"));
            }
            if (!preg_match('/^[0-9]+$/', $formData['mobile1'])) {
                throw new Exception(__("user.mobile1_exp"));
            }

            // validate mobile length based on country 
            if (isset($formData['country']) && $formData['country'] != "") {
                $mobileLength = Bz::getCountryMobileLength($formData['country']);
                if ($mobileLength) {
                    if (strlen($formData['mobile1']) != $mobileLength) {
                        throw new Exception(__("user.mobile1_length", ['digit' => $mobileLength]));
                    }
                } else {
                    throw new Exception(__("user.country_len_not_found"));
                }
            } else {
                // country is required 
                throw new Exception(__("user.country_required"));
            }

            // check mobile exists 
            $otherMobileData = $userModel->get_users(array(
                "mobile" => $formData['mobile1'],
                "not_id" => (isset($formData['id']) && !empty($formData['id'])) ? $formData['id'] : '',
                "count" => true
            ));
            if ($otherMobileData) {
                throw new Exception($formData['mobile1'] . " already exist");
            }
        }

        if (isset($formData['membership_id']) && $formData['membership_id']) {
            // check membership id
            $userQuery = UserModel::where('membership_id', $formData['membership_id']);
            if (isset($formData['id']) && $formData['id']) {
                $userQuery = $userQuery->where('id', "!=", $formData['id']);
            }
            $membershipData = $userQuery->first();
            if (!empty($membershipData)) {
                throw new Exception("This " . $formData['membership_id'] . " membership number is already exists.");
            }
        }

        // Validate mobile 2
        if (isset($formData['mobile2']) && !empty($formData['mobile2'])) {
            if (!preg_match('/^[0-9]+$/', $formData['mobile2'])) {
                $errs[] = __("user.mobile2_exp");
            } elseif (strlen($formData['mobile2']) != 10) {
                $errs[] = __("user.mobile2_length");
            } elseif ($userModel->get_users(array(
                "mobile" => $formData['mobile2'],
                "not_id" => (isset($formData['id']) && !empty($formData['id'])) ? $formData['id'] : '',
                "count" => true
            ))) {
                $errs[] = $formData['mobile2'] . " already exist";
            }
        }

        // Validate email
        if (!isset($formData['email']) || empty($formData['email'])) {
            $errs[] = __("user.email_required");
        } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $errs[] = __("user.email_exp");
        } elseif (strlen($formData['email']) > 100) {
            $errs[] = __("user.email_length");
        } elseif ($userModel->get_users(array(
            "email" => $formData['email'],
            "not_id" => (isset($formData['id']) && !empty($formData['id'])) ? $formData['id'] : '',
            "count" => true
        ))) {
            $errs[] = $formData['email'] . " already exist";
        }

        // Validate username
        if (!isset($formData['username']) || empty($formData['username'])) {
            //            $errs[] = __("user.username_required");
        } elseif (!preg_match('/^[^\'_\".#%]*$/', $formData['username'])) {
            $errs[] = __("user.username_exp");
        } elseif (strlen($formData['username']) < 2 || strlen($formData['username']) > 15) {
            $errs[] = __("user.username_length");
        } elseif ($userModel->get_users(array(
            "username" => $formData['username'],
            "not_id" => (isset($formData['id']) && !empty($formData['id'])) ? $formData['id'] : '',
            "count" => true
        ))) {
            $errs[] = $formData['username'] . " already exist";
        }

        // Validate password

        //        if (!isset($formData['password']) || empty($formData['password'])) {
        //            $errs[] = __("user.password_required");
        //        }


        // elseif (!preg_match('/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,16}$/', $formData['password'])) {
        //     $errs[] = __("user.password_exp");
        // }

        // Validate status
        if (!isset($formData['status'])) {
            $errs[] = __("user.status_required");
        } elseif (!in_array($formData['status'], array(0, 1))) {
            $errs[] = __("user.status_exp");
        }

        // included general options files for validate country and state
        mk_load_options(['general']);

        // Validate country
        if (isset($formData['country']) && !empty($formData['country'])) {
            $countries = get_countries_list();
            if (!isset($countries[$formData['country']])) {
                $errs[] = __("user.country_exp");
            }

            // Validate state
            if (isset($formData['state']) && !empty($formData['state'])) {
                $states = get_states_list($formData['country']);
                if (!isset($states[$formData['state']])) {
                    $errs[] = __("user.state_exp");
                }
            }
        }

        # check role id
        $role_allowed_in = array('user');
        if (in_array($formData['user_type'], $role_allowed_in)) {
            if (!isset($formData['role_id']) || (isset($formData['role_id']) && $formData['role_id'] == "")) {
                $errs[] = __("user.role_id_required");
            }
        }

        // Validate city
        //        if (isset($formData['city']) && !empty($formData['city'])) {
        //            if (strlen($formData['city']) < 3 || strlen($formData['city'] > 50)) {
        //                $errs[] = __("user.city_length");
        //            }
        //        }


        // Validate address line 1
        //        if (isset($formData['address_line1']) && !empty($formData['address_line1'])) {
        //            if (strlen($formData['address_line1']) < 2 || strlen($formData['address_line1'] > 30)) {
        //                $errs[] = __("user.address_line1_length");
        //            }
        //        }

        // Validate address line 2
        //        if (isset($formData['address_line2']) && !empty($formData['address_line2'])) {
        //            if (strlen($formData['address_line2']) < 2 || strlen($formData['address_line2'] > 30)) {
        //                $errs[] = __("user.address_line2_length");
        //            }
        //        }

        if (isset($formData['user_meta_data']) && !empty($formData['user_meta_data'])) {
            // do validate meta fields
            UserModel::validateUserMetaKeys($formData['user_meta_data']);
        }

        if (!empty($errs)) {
            throw new Exception(implode(', ', $errs));
        }
    }

    /*
     * delete_user
     * Delete user
     */
    public function delete_user(Request $request, $user_type = 'user', $user_id = 0)
    {
        # check has access
        if (!$this->has_operation_access("delete_{$user_type}")) {
            return $this->show_invalid_access();
        }

        # validate
        if (!$user_id) {
            return redirect()->back()->with('error_message', __('common.error_while_deleting'));
        }
        // get user model instance
        $userModel = new Abstract_user();
        if ($userModel->delete_user($user_id)) {
            return redirect()->back()->with('success_message', __('common.item_deleted'));
        } else {
            return redirect()->back()->with('error_message', __('common.error_while_deleting'));
        }
    }

    /*
        deleteFolder
        Delete folder
    */
    function delete_folder(Request $request, $folder_id = 0) {
        # validate
        if (!$folder_id) {
            return redirect()->back()->with('error_message', __('common.error_while_deleting'));
        }
        // get folder model instance
        $folder = DocumentDirectoriesTypeModel::find($folder_id);
        if (!empty($folder)) {
            DirectoryItemsModel::where(['directory_type_id' => $folder_id])->update(['directory_type_id' => null]);
            $folder->delete();
            return redirect()->back()->with('success_message', __('common.item_deleted'));
        } else {
            return redirect()->back()->with('error_message', __('common.error_while_deleting'));
        }
    }
}
