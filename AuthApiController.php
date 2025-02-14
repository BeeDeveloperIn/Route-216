<?php

namespace App\plugins\Api\Controllers;

use App\Http\Controllers\Admin\MyAdminController;
use App\Http\Controllers\Bz;
use App\Http\Controllers\CustomValidations;
use App\Http\Controllers\includes\abstracts\Abstract_user;
use App\Models\UserDevice;
use App\Models\UserModel as User;
use App\Models\UserModel;
use App\plugins\Api\Models\VerificationModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * selfProfileDelete
     * Delete user account by current user 
     */
    public function  selfProfileDelete()
    {
        try {
            $user = request()->user('api');
            $userModel = new Abstract_user();
            if ($userModel->delete_user($user->id)) {
                $this->ajax_msg[] = "Your profile has been deleted successfully.";
                return $this->mk_print_ajax_error_json(1, 1, 1);
            } else {
                throw new Exception("Error while deleting your profile.");
            }
        } catch (\Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }

    /**
     * getUserDetails
     * return user details for api user 
     */
    public function getUserDetails()
    {
        try {
            $user = request()->user('api');
            $this->ajax_data['user_details'] = User::apiResponse($user);
            $this->ajax_msg[] = "User Details fetched";
            return $this->mk_print_ajax_error_json(1, 1, 1);
        } catch (\Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }


    /**
     * verifyEmailViaLink
     * Verify email account which will come from email link
     */
    public function verifyEmailViaLink($hash)
    {
        $v_id = decryptor($hash);
        if (!$v_id) {
            return redirect()->route('admin.welcome')->with('error_message', __('The link has been expired'));
        }
        $verificationModel = VerificationModel::find($v_id);
        if (empty($verificationModel)) {
            return redirect()->route('admin.welcome')->with('error_message', __('The link has been expired'));
        }
        // get user
        $userModel = UserModel::where('email', $verificationModel->sent_to)->first();
        if (empty($userModel)) {
            $this->ajax_msg[] = "User with this email doesnot exist!";
            return redirect()->route('admin.welcome')->with('error_message', __('User with this email doesnot exist!'));
        }
        $userModel->email_verified_at = Carbon::now(); // update email time 
        $userModel->status = 1;
        $userModel->update();
        $userModel = $userModel->fresh();
        do_action('user_email_verified', $userModel->id, $userModel);
        $verificationModel->delete(); // delete verificaion
        //$this->ajax_msg[] = "Thank you for verifying your email address";
        //return $this->mk_print_ajax_error_json(1, 1, 1);
        return redirect()->route('admin.welcome')->with('success_message', __('Thank you for verifying your email address'));
    }

    /**
     * signupByEmail
     * Sign up user via email 
     */
    public function signupByEmail()
    {
        try {
            $formData = request()->all();
            $this->validateSignupByEmail($formData);
            $user_id = $this->processSignupByEmail($formData);
            if (!$user_id) {
                throw new Exception("Error while registering user");
            }
            $user = UserModel::find($user_id);
            $this->ajax_data['user_details'] = User::apiResponse($user);
            $this->ajax_msg[] = "Thanks for registering with us.";
            UserModel::sendEmailVerificaionLink($user);
            return $this->mk_print_ajax_error_json(1, 1, 1);
        } catch (\Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }

    /**
     * validateSignupByEmail
     * Validate data for sign up via email
     */
    public  function validateSignupByEmail($formData)
    {

        $name = $formData['name'] ?? false; // required
        $email = $formData['email'] ?? false; // required
        $password = $formData['password'] ?? false; // required
        $mobile = $formData['mobile'] ?? false;
        // check name 
        if (!$name) {
            throw new Exception("Name field is required");
        } else {
            // is name
            if (!CustomValidations::is_name($name)) {
                throw new Exception('Invalid name format');
            }
            // check length
            if (strlen($name) < CustomValidations::nameMinLength() || strlen($name) > CustomValidations::nameMaxLength()) {
                throw new Exception("Name must be between " . CustomValidations::nameMinLength() . " to " . CustomValidations::nameMaxLength() . " characters");
            }
        }

        // validate email
        // is_email
        if (!$email) {
            throw new Exception("Name field is required");
        } else {
            // check email exists
            $oldEmailUser = UserModel::where('email', $email)->first();
            if (!empty($oldEmailUser)) {
                throw new Exception("This email '{$email}' is already registered with us.");
            }
        }

        // check password
        if (!$password) {
            throw new Exception("Password field is required");
        } else {
            if (strlen($password) < CustomValidations::passwordMinLength() || strlen($password) > CustomValidations::passwordMaxLength()) {
                throw new Exception("Password must be between " . CustomValidations::passwordMinLength() . " to " . CustomValidations::passwordMaxLength() . " characters");
            }
        }
    }

    /**
     * processSignupByEmail
     */
    public function processSignupByEmail($formData)
    {
        // Required: name ,email,password 
        $dataToSave = [];
        $dataToSave['name'] = $formData['name'];
        $dataToSave['first_name'] = $formData['name'];
        $dataToSave['email'] = $formData['email'];
        $dataToSave['password'] = bcrypt($formData['password']);
        $dataToSave['role_id'] = ROLE_CUSTOMER;
        $dataToSave['is_blocked'] = 0;
        $dataToSave['status'] = 0;
        $dataToSave['country'] = Bz::getDefaultCountryCode(); // default country
        $dataToSave['store_id'] = Bz::getDefaultStoreId();
        $userModel = new Abstract_user();
        $user_id = $userModel->insert_user($dataToSave);
        return $user_id;
    }

    /**
     * Logout
     * logoutAndDeleteToken
     * App logout and delete tokens
     */
    public function logoutAndDeleteToken(Request $request)
    {
        try {
            $user = $request->user('api');
            // delete tokens
            $this->ajax_data['user_details'] = null;
            if ($user) {
                $this->ajax_data['user_details'] = User::apiResponse($user);
                $user->token()->delete();
            }
            \Illuminate\Support\Facades\Auth::logout();
            \Illuminate\Support\Facades\Session::flush();

            // manage event
            User::userDidLogout($user);
            $this->ajax_msg[] = "You are logout";
            return $this->mk_print_ajax_error_json(1, 1, 1);
        } catch (\Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }

    /**
     * login_view
     * Login view for Unauthenticated
     */
    public function login_view()
    {
        $request = request()->all();
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    /**
     * @param Request $request
     * @return false|\Illuminate\Http\JsonResponse|string|void
     * login
     * Login process
     */
    public function login(Request $request)
    {
        try {
            $formData = $request->post();
            // validation
            $this->loginValidation($formData);
            // runProcess if everything is okay
            $this->loginProcess($formData);
            // returning json if all good

            return $this->mk_print_ajax_error_json(1, 1, 1);
        } catch (\Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }

    /**
     * @param $formData
     * @return false|string|void
     * loginValidation
     */
    private function loginValidation($formData)
    {
        $rules = array(
            'login_method' => 'required|in:' . implode(',', ['gToken', 'fToken', 'user_pass', 'otp_token']),
            'gToken' => 'required_without_all:fToken,password,otp_token',
            'fToken' => 'required_without_all:gToken,password,otp_token',
            'password' => 'required_without_all:fToken,gToken,otp_token',
            'otp_token' => 'required_without_all:fToken,password,gToken',
        );
        // Now pass the input and rules into the validator
        $validator = Validator::make($formData, $rules);
        if ($validator->fails()) {
            $this->laravelErrorArray($validator, 1);
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
    }

    /**
     * @param $formData
     * @param $res
     * @param $_errs
     * loginProcess
     * Login process
     */
    private function loginProcess($formData)
    {
        $res = [];
        $userModel = null;
        if ($formData['login_method'] == 'otp_token') {
            $userModel = $this->manageOTPLogin($formData);
        } else {
            $userModel = $this->manageUserPassLogin($formData);
        }
       
        if(!empty($userModel) && empty($userModel->email_verified_at) && $userModel->status == 0){
            UserModel::sendEmailVerificaionLink($userModel);
            throw new \Exception(message: __('user.login_verify_email_succ'));
        }
        if(!empty($userModel) && $userModel->status == 0){
            throw new \Exception(__('user.login_inactive'));
        }
        if (empty($userModel)) {
            throw new \Exception(message: __('user.login_unsucc'));
        }

        // save device token for user device
        if (!empty($userModel) && !empty($formData['device_token'])) {
            $deviceToken = UserDevice::where(['device_token' => $formData['device_token'],'user_id' => $userModel->id,'device_type' => $formData['device_type']])->first();
            if(empty($deviceToken)){
                $deviceToken = new UserDevice();
                $deviceToken->user_id = $userModel->id;
                $deviceToken->device_token = $formData['device_token'];
                $deviceToken->device_type = $formData['device_type'];
                $deviceToken->device_name = $formData['device_name'] ;
                $deviceToken->save();
            }
        }

        // create and get token response
        $res['token'] = Bz::createTokenAndGetResponse($userModel);
        /*get user details*/
        if (@$formData['get_user_details']) {
            // return user information
            $res['user_details'] = User::apiResponse($userModel);
        }



        // do login via user id 
        $logedIn = \Illuminate\Support\Facades\Auth::loginUsingId($userModel->id, 0);
        // manage user logged in or not 
        User::userDidLogin($userModel);
        $this->ajax_data = array_merge($this->ajax_data, $res);
        $this->ajax_msg[] = __("user.login_succ", ["first_name" => $userModel->first_name]);
    }

    /**
     * @param $formData
     * @return null
     * manageOTPLogin
     * Manage OTP Login
     */
    private function manageOTPLogin($formData)
    {
        // will do in future
    }
    /**
     * @param $formData
     * @param $res
     * @param $_errs
     * @return mixed
     * manageUserPassLogin
     */
    private function manageUserPassLogin($formData)
    {
        //check
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        // Now pass the input and rules into the validator
        $validator = Validator::make($formData, $rules);
        if ($validator->fails()) {
            $this->laravelErrorArray($validator, 1);
            return $this->mk_print_ajax_error_json(0, 1, 1);
        }
        $userModel = User::where([
            'deleted_at' => null,
           // 'status' => 1
        ])->where(function ($query) use ($formData) {
            $query->OrWhere([
                'email' => $formData['username'],
                'mobile1' => $formData['username']
            ]);
        })->first();

        if ($userModel == null) {
            throw new  \Exception(__('user.login_unsucc'));
        }
        if ($userModel->is_blocked) {
            throw new \Exception(__('user.blocked_user'));
        }
        if (!Hash::check($formData['password'], $userModel->password)) {
            throw new \Exception(__('user.login_unsucc'));
        }
        return $userModel;
    }
}
