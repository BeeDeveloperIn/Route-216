<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Admin\MyAdminController;
use App\Http\Controllers\Bz;
use App\Http\Controllers\Controller;
use App\Http\Controllers\includes\abstracts\Abstract_user;
use App\Models\UserModel;
use App\plugins\importer\Models\ImportExport;
use App\plugins\importer\Models\ImportExportRow;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;

class UsersImporter extends MyAdminController
{

    public $import_type = "import_users";

    public function __construct($slug = "import_users")
    {
        $this->import_type = $slug;
    }


    /**
     * @return void
     * exportUsers
     */
    public function exportUsers()
    {
        $userController = new Users();
        $formData = request()->all();
        $userController->setUserListingVars($formData);
        $users = $userController->data['users'];
        if (!$users->num_rows()) {
            return back()->with('error_message', __("common.data_list_empty"));
        }
        $userResults = $users->result_array();
        return $this->exportData($userResults, $formData);
    }


    /**
     * @param array $items
     * @param array $formData
     * Prepare export sheet based on given items and form data
     */
    public function exportData($items = array(), $formData = array())
    {
        $slug = $this->import_type;
        $hint_array = [];
        $label = [];
        $required_arr = [];
        $keys = [];
        $sample_data = [];
        $cols = $this->get_import_columns(); // get columns to header
        // repare header of sheet
        foreach ($cols as $key => $group) {
            foreach ($group['cols'] as $key => $item) {
                $keys[] = $key;
                $label[] = $item['label'];
                $required_arr[] = isset($item['required']) ? 'Required' : 'Optional';
                $hint_array[] = $item['hint'] ?? '';
//                $sample_data[] = isset($item['sample']) ? $item['sample'] : '';
            }
        }
        /*
         * fill excel rows
         */
        $rows = [
//            $label,
//            $required_arr,
//            $hint_array,
            $keys,
//            $sample_data
        ];
        /**
         * Append each row into Excel sheet row
         */
        foreach ($items as $each) {

            // ignore super admin
            $ignoreRoles = array(ROLE_ADMIN, ROLE_ROOT_USER);
            if (in_array($each['role_id'], $ignoreRoles)) {
                continue;
            }

            $dataToExport = [];
            $dataToExport[] = $each['membership_id'];
            $dataToExport[] = $each['first_name'];
            $dataToExport[] = $each['last_name'];
            $dataToExport[] = $each['email'];
            $dataToExport[] = $each['country_ext'];
            $dataToExport[] = $each['mobile1'];
            $dataToExport[] = $each['status'];
            $dataToExport[] = $each['country'];
            $dataToExport[] = $each['state'];
            $dataToExport[] = $each['city'];
            $dataToExport[] = $each['pincode'];
            $dataToExport[] = $each['address_line1'];
            array_push($rows, $dataToExport); # push new row
        }
        $fileName = $slug . '-sample.csv';
        return Bz::Export($fileName, $rows);  # process export
    }

    /**
     * @return array
     * get_import_column
     */
    public function get_import_column(): array
    {
        # return data from channel trait
        return $this->get_import_columns();
    }

    public function get_import_columns()
    {
        $columns = array();
        $columns['user_details'] = [
            'label' => 'User information',
            'cols' =>
                array(
                    'membership_id' => [
                        'label' => "Membership no.",
                        'sample' => "ABC123",
                        'hint' => 'string',
                        'required' => true,
                    ],
                    'first_name' => [
                        'label' => "First Name",
                        'sample' => "Manoj",
                        'hint' => 'string',
                        'required' => true,
                    ],
                    'last_name' => [
                        'label' => "Last Name",
                        'sample' => "Kumar",
                        'hint' => 'string',
                        'required' => true,
                    ],
                    'email' => [
                        'label' => "Email",
                        'sample' => "abc@gmail.com",
                        'hint' => 'string',
                        'required' => true,
                    ],
                    'country_ext' => [
                        'label' => "Country Ext.",
                        'sample' => "91",
                        'hint' => 'string',
                        'required' => true,
                    ],
                    'mobile1' => [
                        'label' => "Mobile",
                        'sample' => "7011847903",
                        'hint' => 'string',
                        'required' => true,
                    ],
                    'status' => [
                        'label' => "Status",
                        'sample' => "0",
                        'hint' => 'boolean: 0 or 1',
                        'required' => true,
                    ],
                    'country' => [
                        'label' => "Country Code",
                        'sample' => "IN",
                        'hint' => 'string',
                        'required' => true,
                    ],
                    'state' => [
                        'label' => "State Code",
                        'sample' => "DL",
                        'hint' => 'string',
                        'required' => true,
                    ],
                    'city' => [
                        'label' => "City",
                        'sample' => "New Delhi",
                        'hint' => 'string',
                        'required' => false,
                    ],
                    'pincode' => [
                        'label' => "Pincode",
                        'sample' => "110036",
                        'hint' => 'string',
                        'required' => true,
                    ],
                    'address_line1' => [
                        'label' => "Address line",
                        'sample' => "",
                        'hint' => 'string',
                        'required' => true,
                    ],
                )
        ];
        return $columns;
    }

    /**
     * @return array
     * get_meta_import_information
     */
    public function get_meta_import_information()
    {
        $fields = [];
        $fields['information'] = array(
            'text' => "<a target='_blank' href='" . route('ie.export-import-sample', ['slug' => $this->import_type]) . "'>Download Sample</a>",
            'sample_file_url' => "https://www.webwila.com",
            'sample_file_btn_text' => "Download Sample file"
        );
        return $fields;
    }

    /**
     * @param $eachRow
     * @param $importExportModel
     * @param $innerRes
     * @param $_errs
     * @return void
     * importSingleRow
     */
    public function importSingleRow($eachRow, $importExportModel, &$innerRes, &$_errs)
    {
        dd("importSingleRow");
    }


    /**
     * @return array
     * get_import_additional_form_fields
     */
    public function get_import_additional_form_fields()
    {
        $sample['update_duplicate_sku'] = array(
            'label' => "Update if SKU is already exists ? ",
            'field_type' => "select",
            'values' => array(
                '0' => "No, Give Stop Importing but don't overwrite",
                '1' => 'Yes, run update'
            ),
            'default_value' => 1,
            'hint' => "Already existing SKU will be skipped"
        );
        $fields = [];
        return $fields;
    }

    /**
     * @param $formData
     * @return array
     * formatDataToInsert
     */
    public function formatDataToInsert($formData)
    {
        $data_to_insert['first_name'] = @$formData['first_name'];
        $data_to_insert['last_name'] = (isset($formData['last_name']) && !empty($formData['last_name'])) ? $formData['last_name'] : null;
        $data_to_insert['mobile1'] = @$formData['mobile1'];
        $data_to_insert['mobile2'] = (isset($formData['mobile2']) && !empty($formData['mobile2'])) ? $formData['mobile2'] : null;
        $data_to_insert['email'] = @$formData['email'];
        $data_to_insert['username'] = @$formData['username'];
        $data_to_insert['membership_id'] = @$formData['membership_id'];
        $data_to_insert['status'] = (isset($formData['status']) && in_array($formData['status'], array(0, 1))) ? $formData['status'] : 1;
        // we can manage block status separately
        if (isset($formData['status'])) {
            $data_to_insert['is_blocked'] = !$formData['status'];
        }
        $data_to_insert['country'] = (isset($formData['country']) && !empty($formData['country'])) ? $formData['country'] : null;
        $data_to_insert['state'] = (isset($formData['state']) && !empty($formData['state'])) ? $formData['state'] : null;
        $data_to_insert['city'] = (isset($formData['city']) && !empty($formData['city'])) ? $formData['city'] : null;
        $data_to_insert['pincode'] = (isset($formData['pincode']) && !empty($formData['pincode'])) ? $formData['pincode'] : null;
        $data_to_insert['address_line1'] = (isset($formData['address_line1']) && !empty($formData['address_line1'])) ? $formData['address_line1'] : null;
        $data_to_insert['address_line2'] = (isset($formData['address_line2']) && !empty($formData['address_line2'])) ? $formData['address_line2'] : null;
        $data_to_insert['role_id'] = ROLE_CUSTOMER; // default role
        return $data_to_insert;
    }

    /**
     * @param $formData
     * @return array
     * getMembershipData
     */
    public function getMembershipData($formData)
    {
        $membershipData = array();
        if (isset($formData['membership_id']) && $formData['membership_id']) {
            // check membership id
            $userQuery = UserModel::where('membership_id', $formData['membership_id']);
            if (isset($formData['id']) && $formData['id']) {
                $userQuery = $userQuery->where('id', "!=", $formData['id']);
            }
            $membershipData = $userQuery->first();
        }

        return $membershipData;
    }

    /**
     * @param $formData
     * @return void
     * validate_user_data
     */
    private function validate_user_data($formData)
    {
        if (empty($formData)) {
            throw new Exception(__("common.throw_error"));
        }


        $errs = [];
        // get user model instance
        $userModel = mkGetModelInstance('UserModel', 'Users', array('table' => $formData['user_type']));

        // Validate fist name
        if (!isset($formData['first_name']) || empty($formData['first_name'])) {
            $errs[] = __("user.first_name_required");
        } elseif (!preg_match('/^[a-zA-Z. ]+$/', $formData['first_name'])) {
            $errs[] = __("user.first_name_exp");
        } elseif (strlen($formData['first_name']) < 2 || strlen($formData['first_name']) > 15) {
            $errs[] = __("user.first_name_length");
        }

        // Valiate last name
        if (isset($formData['last_name']) && !empty($formData['last_name'])) {
            if (!preg_match('/^[a-zA-Z. ]+$/', $formData['last_name'])) {
                $errs[] = __("user.last_name_exp");
            } elseif (strlen($formData['last_name']) < 2 || strlen($formData['last_name']) > 50) {
                $errs[] = __("user.last_name_length");
            }
        }

        // Validate mobile 1
        if (!isset($formData['mobile1']) || empty($formData['mobile1'])) {
            $errs[] = __("user.mobile1_required");
        } elseif (!preg_match('/^[0-9]+$/', $formData['mobile1'])) {
            $errs[] = __("user.mobile1_exp");
        } elseif (strlen($formData['mobile1']) != 10) {
            $errs[] = __("user.mobile1_length");
        }

        $userMobileExist = array();
        if (isset($formData['mobile1']) && $formData['mobile1']) {
            $userMobileExist = UserModel::query();
            $userMobileExist = $userMobileExist->where('mobile1', $formData['mobile1']);
            if (isset($formData['id']) && $formData['id']) {
                $userMobileExist = $userMobileExist->where("id", '!=', $formData['id']);
            }
            $userMobileExist = $userMobileExist->first();
        }
        if (!empty($userMobileExist)) {
            $errs[] = $formData['mobile1'] . " already exist";
        }

        if (isset($formData['membership_id']) && $formData['membership_id']) {
            // check membership id
            $userQuery = UserModel::where('membership_id', $formData['membership_id']);
            if (isset($formData['id']) && $formData['id']) {
                $userQuery = $userQuery->where('id', "!=", $formData['id']);
            }
            $membershipData = $userQuery->first();
            if (!empty($membershipData)) {
                $errs[] = "This " . $formData['membership_id'] . " membership no. is already exists.";
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
        if (!empty($errs)) {
            throw new Exception(implode(', ', $errs));
        }
    }

    /**
     * @param $import_export_id
     * @return JsonResponse
     * @method manage_import
     * This will handle import each row process and will update status in Db tables
     */
    public function manage_import($import_export_id)
    {
        $res = [
            'succ' => true,
            'public_msg' => __('importexport.succ_data_imported')
        ];
        $importExportModel = ImportExport::find($import_export_id);
        $rowsToImport = ImportExportRow::where(['import_export_id' => $import_export_id])
            ->where('updated_at', null)
            ->take(10)->get();

        $res['rows'] = [];
        if (!$rowsToImport->count()) {
            $res['public_msg'] = __('importexport.succ_all_data_imported');
            $importExportModel->imported_rows = $importExportModel->total_rows;
            $importExportModel->update();
            $importExportModel->fresh();
            $res['iemodel'] = $importExportModel;
        } else {
            $userModel = new Abstract_user();
            // Process each pending rows
            $imported_rows = 0;
            foreach ($rowsToImport as $eachRow) {
                $_errs = [];
                $meta_data = $eachRow->meta_data;
                $meta_data['user_type'] = "user";
                $meta_data['role_id'] = ROLE_CUSTOMER;
                // End  default data
                try {
                    $innerRes = [
                        'succ' => true,
                        'public_msg' => __('importexport.row_save_succ')
                    ];
                    // prepare data to insert
                    $data_to_insert = $this->formatDataToInsert($meta_data);
                    $userData = array();
                    $id = false;
                    // get user data
                    if (isset($meta_data['email']) && $meta_data['email'] != "") {
                        $userData = UserModel::where('email', $meta_data['email'])->first();
                    }

                    // set id so that this can be validated
                    if (!empty($userData)) {
                        $meta_data['id'] = $userData->id;
                    }

                    // now do validate data
                    $this->validate_user_data($meta_data);

                    // if email is not found then insert
                    $user_id = false;
                    if (empty($userData)) {
                        // create new user
                        $user_id = $userModel->insert_user($data_to_insert);
                    } else {
                        // do update old user
                        $user_id = $userModel->update_user($data_to_insert, $userData->id);
                    }

                    if (!$user_id) {
                        throw new \Exception(__('common.throw_error'));
                    }

                    $innerRes['public_msg'] .= ", User record imported successfully";
                    $eachRow->succ_msg = @$innerRes['public_msg'];
                    if (isset($innerRes['edit_url'])) {
                        $meta_data['edit_url'] = "";
                    }
                    $eachRow->is_error = 0;
                } catch (\Exception $ex) {
                    $eachRow->error_msg = $ex->getMessage();
                    $meta_data['_errs'] = $_errs;
                    $eachRow->is_error = 1;
                    $eachRow->update();
                }

                $eachRow->created_at = now();
                $eachRow->meta_data = $meta_data;
                $eachRow->update();
                $res['rows'][] = $eachRow->fresh(); // managing below and # fresh model init

                // increment processed row into main handling table
                $importExportModel->imported_rows++;
                $importExportModel->update();
                $imported_rows++;
            }
            # end each row processing data
            $res['iemodel'] = $importExportModel->fresh();
        }
        // returning json if all good
        return response()->json($res);
    }
}
