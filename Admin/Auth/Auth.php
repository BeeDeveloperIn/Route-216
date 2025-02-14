<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\MyAdminController;
use App\Http\Controllers\Bz;
use App\Http\Controllers\CustomValidations;
use App\Http\Controllers\includes\abstracts\Abstract_user;
use App\Models\UserModel;
use App\plugins\Api\Controllers\MediaApiController;
use App\plugins\Api\Models\DocumentDirectoriesTypeModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class Auth extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return false|string|null
     * saveUserProfilePicture
     */
    public function saveUserProfilePicture(Request $request)
    {
        try {

            $_validator = [
                'profilePicture' => 'sometimes|mimes:jpeg,jpg,png|max:1000'
            ];
            $validator = Validator::make($request->all(), $_validator);
            $formData = $request->all();

            // If validation fails
            if ($validator->fails()) {
                throw new \Exception($this->laravelErrorString($validator));
            }
            if (isset($formData['profilePicture']) && $formData['profilePicture'] != "") {
                $insert_array['profile_picture'] = $formData['profilePicture'];
                $user = \Illuminate\Support\Facades\Auth::user();
                if (isset($user['id']) && $user['id'] != null) {
                    UserModel::where("id", $user['id'])->limit(1)->update($insert_array);
                }
            }
            $this->ajax_msg[] = __('glogin.profile_picture_updated');
            return $this->mk_print_ajax_error_json(1, 1, 1);
        } catch (\Exception $ex) {
            $this->ajax_msg[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * update_password_req
     * Update current user password
     */
    public function update_password_req(Request $request)
    {
        $formData = $request->all();
        // get user data 
        $customerInstance = \Illuminate\Support\Facades\Auth::user();
        try {

            // do validate 
            $validator = Validator::make($formData, [
                'password_current' => 'required|min:' . CustomValidations::passwordMinLength() . '|max:' . CustomValidations::passwordMaxLength(),
                'password' => 'required|min:' . CustomValidations::passwordMinLength() . '|max:' . CustomValidations::passwordMaxLength(),
                'confirm_password' => 'required|min:' . CustomValidations::passwordMinLength() . '|max:' . CustomValidations::passwordMaxLength() . '|same:password',
            ]);

            if ($validator->fails()) {
                throw new Exception($this->laravelErrorString($validator));
            }
            // check current password
            if (isset($formData['password_current']) && $formData['password_current'] != "") {
                if (!Hash::check($formData['password_current'], $customerInstance->password)) {
                    $this->ajax_errors[] = __('user.invalid_current_password');
                }
            }
            # if it has errors
            if (!empty($this->ajax_errors)) {
                throw new Exception(__('common.throw_error'));
            }

            // do update
            $update_res = UserModel::change_password($formData);
            if ($update_res) {
                $this->ajax_msg[] = __("user.password_changed");
                return $this->mk_print_ajax_error_json(1, 1, 1);
            } else {
                $this->ajax_errors[] = __("common.throw_error");
                throw new Exception(__('common.throw_error'));
            }
        } catch (Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }

    // $formData = $request->all();
    // try {

    //     $validator = Validator::make($formData, [
    //         'password' => 'required|min:3|max:255',
    //         'confirm_password' => 'required|min:3|max:255|same:password',
    //     ]);

    //     if ($validator->fails()) {
    //         throw new Exception($this->laravelErrorString($validator));
    //     }
    //     $user_details = UserModel::find(\Illuminate\Support\Facades\Auth::id());

    //     // check if it matches with existing password
    //     if (Hash::check($formData['password'], $user_details->password)) {
    //         throw new Exception(__('glogin.same_pass'));
    //     }
    //     $insert_array['password'] = bcrypt(trim($formData['password']));
    //     if (!UserModel::where("id", \Illuminate\Support\Facades\Auth::id())->update($insert_array)) {
    //         throw new Exception(__('common.throw_error'));
    //     }
    //     // if username and password okay adding details into session
    //     $this->ajax_msg[] = __('glogin.password_change_succ');

    //     FacadesAuth::logoutOtherDevices($formData['password']);

    //     return $this->mk_print_ajax_error_json(1, 1, 1);
    // } catch (Exception $ex) {
    //     $this->ajax_errors[] = $ex->getMessage();
    //     return $this->mk_print_ajax_error_json(0, 1, 1);
    // }


    /**
     * @return false|JsonResponse|string
     * updateSelfProfile
     */
    public function backup_updateSelfProfile()
    {
        $formData = request()->post();
        try {

            $alreadyExist = UserModel::where('mobile1', $formData['mobile'])
                ->where('id', '!=', \Illuminate\Support\Facades\Auth::id())
                ->first();
            $validator = Validator::make($formData, [
                'name' => 'required|min:3|alpha_spaces_underscore|max:255',
                'mobile' => 'sometimes|min:10|max:10',
            ]);

            $validator->after(function ($validator) use ($formData) {
                if (isset($formData['mobile']) && $formData['mobile'] != "") {
                    $alreadyExist = UserModel::where('mobile1', $formData['mobile'])
                        ->where('id', '!=', \Illuminate\Support\Facades\Auth::id())
                        ->first();
                    if (!empty($alreadyExist)) {
                        $validator->errors()->add('mobile', $formData['mobile'] . " already exist");
                    }
                }
            });

            if ($validator->fails()) {
                throw new Exception($this->laravelErrorString($validator));
            }

            $insert_array = [
                'first_name' => $formData['first_name'],
                'name' => $formData['first_name'],
                'last_name' => $formData['last_name']
            ];
            if (isset($formData['mobile']) && $formData['mobile']) {
                $insert_array['mobile1'] = $formData['mobile'];
            }

            if (!UserModel::where("id", \Illuminate\Support\Facades\Auth::id())->update($insert_array)) {
                throw new Exception(__('common.throw_error'));
            }

            $this->ajax_msg[] = __('glogin.profile_update_succ');
            return $this->mk_print_ajax_error_json(1, 1, 1);
        } catch (Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }


    /**
     * updateProfileImage
     * Upload image in directory and update profile image in usermodel
     */
    public function updateProfileImage()
    {
        $formData = request()->post();
        try {
            $user = FacadesAuth::user();
            $data = UserModel::uploadProfileImageToMedia($formData, $user->id);
            if ($data->succ) {
                $totalFilesUploaded = $data->data->total_files_uploaded;
                $uploadedItems = $data->data->uploaded_items;
                $profile_picture  = current($uploadedItems)->full_url;
                $updateProfileData = [];
                $updateProfileData['name'] = $user->name;
                $updateProfileData['mobile'] = $user->mobile1;
                $updateProfileData['email'] = $user->email;
                $updateProfileData['profile_picture'] = $profile_picture;
                return $this->updateSelfProfile($updateProfileData);
            } else {
                throw new Exception("Error while updating user's profile. {$data->errors}");
            }
        } catch (Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }

    /**
     * updateSelfProfile
     * Update user profile 
     */
    public function updateSelfProfile($formData = [])
    {
        if (empty($formData)) {
            $formData = request()->post();
        }
        // TODO need to make it dynamic if multiple country are enable 
        $formData['country'] = Bz::getDefaultCountryCode();
        $formData['country_ext'] = Bz::getDefaultCountryExt();
        $oldUserModel  = FacadesAuth::user();
        // if country and country_ext is not coming then take it from old or set default

        $dataToUpdate = [];
        try {
            // validate data 
            // check name 
            if (isset($formData['name']) && $formData['name'] != "") {
                if (!CustomValidations::is_name($formData['name'])) {
                    throw new Exception('Invalid name format');
                }
                // check length
                if (strlen($formData['name']) < CustomValidations::nameMinLength() || strlen($formData['name']) > CustomValidations::nameMaxLength()) {
                    throw new Exception("Name must be between " . CustomValidations::nameMinLength() . " to " . CustomValidations::nameMaxLength() . " characters");
                }
                $dataToUpdate['name'] = $formData['name'];
                $dataToUpdate['first_name'] = $formData['name'];
            }else{
                throw new Exception('Name field is required');
            }

            // validate mobile
            if (isset($formData['mobile']) && $formData['mobile'] != "") {
                if (!CustomValidations::is_phone($formData['mobile'])) {
                    throw new Exception("Invalid mobile number format");
                }
                // check mobile no exists or not 
                $oldMobile = UserModel::where('mobile1', $formData['mobile'])
                    ->where('id', '!=', $oldUserModel->id)->first();
                if (!empty($oldMobile)) {
                    throw new Exception("This '{$formData['mobile']}' mobile number is already registered with another account");
                }

                // set update var 
                $dataToUpdate['mobile1'] = $formData['mobile'];
            }else{
                throw new Exception('Mobile field is required');
            }

            // validate email
            if (isset($formData['email']) && $formData['email'] != "") {
                if (!CustomValidations::is_email($formData['email'])) {
                    throw new Exception("Invalid email format");
                }
                // check mobile no exists or not 
                $oldEmail = UserModel::where('email', $formData['email'])
                    ->where('id', '!=', $oldUserModel->id)->first();
                if (!empty($oldEmail)) {
                    throw new Exception("This '{$formData['email']}' email is already registered with another account");
                }

                // set update var 
                $dataToUpdate['email'] = $formData['email'];
            }

            // validate mobile length based on country 
            if (isset($formData['country']) && $formData['country'] != "") {
                // validate if mobile is coming
                if (@$formData['mobile']) {
                    $mobileLength = Bz::getCountryMobileLength($formData['country']);
                    if ($mobileLength) {
                        if (strlen($formData['mobile']) != $mobileLength) {
                            throw new Exception(__("user.mobile1_length", ['digit' => $mobileLength]));
                        }
                    } else {
                        throw new Exception(__("user.country_len_not_found"));
                    }
                }

                // set country udpate var
                $dataToUpdate['country'] = $formData['country'];
            } else {
                // throw new Exception(__("user.country_required"));
            }

            // profile_picture
            if (isset($formData['profile_picture']) && $formData['profile_picture']) {
                $dataToUpdate['profile_picture'] = $formData['profile_picture'];
            }

            // check is meta data is coming
            if (isset($formData['user_meta_data']) && !empty($formData['user_meta_data'])) {
                // do validate meta fields
                UserModel::validateUserMetaKeys($formData['user_meta_data']);
            }


            // has data to update
            if (empty($dataToUpdate)) {
                throw new Exception("Form data is empty to update");
            }


            $userModel = new Abstract_user();
            $user_id = $userModel->update_user($dataToUpdate, FacadesAuth::id(), $formData);
            if (!$user_id) {
                throw new Exception("Error while user updating details");
            }

            // Manage things after profile update 
            $userModel = UserModel::find($oldUserModel->id);
            if ($userModel->email != $oldUserModel->email) {
                UserModel::userDidEmailChange($oldUserModel, $userModel);
            }


            $this->ajax_msg[] = "Details updated successfully";
            return $this->mk_print_ajax_error_json(1, 1, 1);
        } catch (Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * profile
     *  details show of current user
     */
    public function profile()
    {
        $this->data['userData'] = \Illuminate\Support\Facades\Auth::user();
        if (!is_root_admin()) {
            return $this->renderCustomerView('auth.user-profile');
        }
        return $this->renderAdminView('auth.user-profile');
    }


    /**
     * view_profile
     * For user
     */
    public function view_profile($user_id)
    {
        $logs = [];
        $view_all_logs_url = "javascript:void(0)";
        if (function_exists('mk_getRecentLogs')) {
            $logs = mk_getRecentLogs([
                'user_id' => $user_id,
                'per_page' => 10
            ]);
            $view_all_logs_url = route('admin.system.log.display', ['user_id' => $user_id]);
        }
        $this->data['logs'] = $logs;
        $this->data['view_all_logs_url'] = $view_all_logs_url;
        $this->data['folders'] = DocumentDirectoriesTypeModel::where('user_id',$user_id)->get();
        $this->data['userData'] = UserModel::find($user_id);
        if (empty($this->data['userData'])) {
            return abort('404');
        }
        return $this->renderAdminView('auth.view-profile');
    }


    /**
     * @param $request
     * @param $formData
     * @return \Illuminate\Contracts\Auth\Authenticatable
     * @throws \Exception
     * do_login_by_email_password
     * Do log in via username and password
     */
    public function do_login_by_email_password($request, $formData)
    {
        $user_details = \App\Models\UserModel::where(['email' => $formData['email']])->get()->first();

        // if wrong username and password
        if ($user_details == null) {
            throw new \Exception(__('user.login_unsucc'));
        }

        if (!Hash::check($formData['password'], $user_details->password)) {
            throw new \Exception(__('user.login_unsucc'));
        }

        if ($user_details->is_blocked) {
            throw new \Exception(__('user.blocked_user', ['first_name' => $user_details->first_name]));
        }
        // Create session
        return $this->create_session($request, $user_details);
    }

    /**
     * @throws \Exception
     */
    public function index(Request $request)
    {
        // is has user
        if (\Illuminate\Support\Facades\Auth::id()) {
            return redirect(route('admin.dashboard'));
        }
        // Get the "Remember Me" token from the user's cookies
        $rememberToken = request()->cookie(FacadesAuth::getRecallerName());
        $this->data['error'] = "";
        $this->data['email'] = "";
        $this->data['password'] = "";
        $formData = $request->post();
        if (!empty($formData)) {
        }
        return $this->renderBeforeLoginView('auth/login');
    }

    public function privacypolicy(Request $request)
    {
        return $this->renderBeforeLoginView('auth/privacypolicy');
    }

    public function support(Request $request)
    {
        return $this->renderBeforeLoginView('auth/support');
    }
    public function welcome(Request $request)
    {
        return $this->renderBeforeLoginView('auth/welcome');
    }

    /**
     * adminLogin
     * Admin Login post method
     */
    public function adminLogin()
    {
        $request = request();
        $this->data['error'] = "";
        $this->data['email'] = "";
        $this->data['password'] = "";
        $formData = $request->post();
        try {
            $user_type = 'user';
            //  user model according to user type
            $userModel = mkGetModelInstance('UserModel', 'Users', array('table' => $user_type));
            // Validate login form data
            $this->validate_login($formData, $userModel);
            $this->data['email'] = $formData['email'];
            $this->data['password'] = $formData['password'];
            $this->do_login_by_email_password($request, $formData);
            if(\Illuminate\Support\Facades\Auth::user()->role_id == ROLE_CUSTOMER){
                return redirect()->route('customer.dashboard');
            }
            return redirect()->route('admin.dashboard');
        } catch (\Exception $e) {
            $this->data['error'] = $e->getMessage();
            return $this->renderBeforeLoginView('auth/login');
        }
    }

    public function logout(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $redirect = route('admin.login');
        //check if the user logging has storeadmin role
        \Illuminate\Support\Facades\Auth::logout();
        Session::flush();

        // event on logout 
        \App\Models\UserModel::userDidLogout($user);
        return redirect($redirect);
    }

    // Validate do login data
    private function validate_login($formData, $userModel)
    {
        $errs = [];

        if (!isset($formData['email']) || empty($formData['email'])) {
            $errs[] = "Email | Username is required";
        } elseif (!$userModel->check_login_email_exist($formData['email'])) {
            $errs[] = "This email doesn't exist";
            // $errs[] = "This email {$formData['email']} does not exist";
        }

        if (!isset($formData['password']) || empty($formData['password'])) {
            $errs[] = "Password is required";
        }

        if (!empty($errs)) {
            throw new Exception(implode(',', $errs));
        }
    }

    private function create_session($request, $user_model)
    {
        $remember = $request->get('remember');
        if ($remember) {
            $remember = true;
        } else {
            $remember = false;
        }

        $logedIn = \Illuminate\Support\Facades\Auth::loginUsingId($user_model->id, $remember);
        \App\Models\UserModel::userDidLogin($user_model);
        return $logedIn;
    }
}
