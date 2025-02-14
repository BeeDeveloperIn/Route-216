<?php


namespace App\Models;

use App\Http\Controllers\Bz;
use App\Mail\SystemEmail;
use App\plugins\Api\Controllers\MediaApiController;
use App\plugins\Api\Models\VerificationModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Mockery\Exception;

class UserModel extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use HasFactory;
    use SoftDeletes;


    protected $table = "users";
    protected $guarded = [];
    protected $fillable = array();
    protected $appends = [
        'user_id',
        'is_login',
        'is_customer',
        'is_admin',
        'is_super_admin',
    ];

    protected $casts = [
        'meta_data' => 'array'
    ];
    public $timestamps = false;

    protected $hidden = [
        //        'password', 'remember_token',
    ];


    /**
     * updateUserMetaInMainTable
     * This will tell where we have to save user data 
     * in main table of users or in a seprate table that is user meta
     */
    public static function updateUserMetaInMainTable()
    {
        return true;
    }

    public function getUserIdAttribute()
    {
        return $this->id;
    }

    // full name
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * formatted_mobile
     */
    public function getformattedMobileAttribute()
    {
        if (!$this->mobile1) {
            return;
        }
        return "+{$this->country_ext} {$this->mobile1}";
    }


    /**
     * getStatusTextAttribute
     * block_status_text
     */
    public function getBlockStatusTextAttribute()
    {
        if ($this->is_blocked) {
            return "Blocked";
        }
        return "Active";
    }

    public function getProfileImgAttribute()
    {
        return self::transformProfileImg($this->profile_picture);
    }

    /**
     * App\Models\UserModel::transformProfileImg()
     */
    public static function transformProfileImg($profile_picture = "")
    {
        if (!$profile_picture) {
            return asset('profile.jpg');
        }
        if (\Illuminate\Support\Str::startsWith($profile_picture, ['http:', 'https:'])) {
            return $profile_picture;
        } else {
            return asset(Storage::url($profile_picture));
        }
    }

    // is_customer
    public function getIsCustomerAttribute()
    {
        if ($this->role_id == ROLE_CUSTOMER) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * is_login
     */
    public function getIsLoginAttribute()
    {
        return $this->meta_data['is_login'] ?? 0;
    }

    /**
     * is_admin
     */
    public function getIsAdminAttribute()
    {
        if ($this->role_id == ROLE_ADMIN) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * is_super_admin
     */
    public function getIsSuperAdminAttribute()
    {
        if ($this->role_id == ROLE_ROOT_USER) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Add a mutator to ensure hashed passwords
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public static function getUserList($formData = array())
    {
        $query = UserModel::query();
        //
        if (isset($formData['role_id']) && $formData['role_id'] != "") {
            $query->where('role_id', $formData['role_id']);
        }
        return $query->get();
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * meta_data
     * return user meta data
     */
    public function user_meta_data()
    {
        return $this->hasMany(UserMetaModel::class, 'user_id', 'id');
    }

    /**
     * role attribute
     */
    public function getRoleAttribute()
    {

        $roleModel = DB::table('roles')->where('role_id', $this->role_id)->first();
        return $roleModel;
    }

    /**
     * @return string[]
     * getuserFillableMetaKeys
     * Filled which will be saved into user meta keya
     */
    public static function getuserFillableMetaKeys()
    {
        $metaKeys = array(
            'company_name',
            'company_website',
            'company_address',
            'timezone',
            'vat_number'
        );
        return apply_filters('user_fillable_meta_keys', $metaKeys);
    }

    /**
     * validateUserMetaKeys
     * Validate Meta data
     */
    public static function validateUserMetaKeys($userMeta = [])
    {
        if (empty($userMeta)) {
            return;
        }
        // validate vat_number
        if (isset($userMeta['vat_number']) && !empty($userMeta['vat_number'])) {
            if (!preg_match('/^[a-zA-Z0-9]{8,30}$/', $userMeta['vat_number'])) {
                throw new Exception("Invalid format of VAT number");
            }
        }
    }

    /**
     * @param array $formData
     * @return mixed
     * change_password
     * change current user password
     */
    public static function change_password($formData)
    {

        if (empty($formData)) {
            return false;
        }
        $data_to_update = array();
        $data_to_update['password'] = bcrypt($formData['password']);
        return UserModel::where('id', get_current_user_id())->update($data_to_update);
    }


    /**
     * apiResponse
     */
    public static function apiResponse($user)
    {
        $return = array();
        $return['id'] = $user->id;
        $return['name'] = $user->name;
        $return['email'] = $user->email;
        $return['country_ext'] = $user->country_ext;
        $return['mobile'] = $user->mobile1;
        $return['profile_img'] = $user->profile_img;
        $return['is_blocked'] = $user->is_blocked;
        $return['notification_status'] = $user->notification_status;
        $return['email_verified_at'] = $user->email_verified_at;
        $userMeta = get_formatted_user_meta_data($user->id);
        $fillableMetakeys = self::getuserFillableMetaKeys();
        $metaRes = [];
        if (!empty($userMeta) && !empty($fillableMetakeys)) {
            foreach ($fillableMetakeys as $meta_key) {
                if (isset($userMeta[$meta_key])) {
                    $metaRes[$meta_key] = $userMeta[$meta_key];
                }
            }
        }
        // transform response of user meta data
        $return['user_meta_data'] = $metaRes;
        $return['created_at'] = $user->created_at;
        return $return;
    }

    /**
     * userDidEmailChange
     */
    public static function userDidEmailChange($oldUserModel, $userModel)
    {
        $userModel->email_verified_at = null;
        $userModel->update();

        // send verification email
        self::sendEmailVerificaionLink($userModel);
        return true;
    }

    /**
     * userDidLogin
     */
    public static function userDidLogin($userModel)
    {
        if (empty($userModel)) {
            return false;
        }
        $oldMeta = $userModel->meta_data;
        $oldMeta['is_login'] = 1;
        $oldMeta['last_login_at'] = Carbon::now();
        $oldMeta['device_info'] = [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ];
        $userModel->meta_data = $oldMeta;
        $updateRes = $userModel->update();
        // Log
        $logID = (function_exists('mk_punch_log_after_login')) ? mk_punch_log_after_login($userModel) : false;
        return $updateRes;
    }

    /**
     * userDidLogout
     * when user did logout
     */
    public static function userDidLogout($userModel)
    {
        if (empty($userModel)) {
            return false;
        }
        $oldMeta = $userModel->meta_data;
        $oldMeta['is_login'] = 0;
        $oldMeta['last_logout_at'] = Carbon::now();
        $userModel->meta_data = $oldMeta;
        $updateRes =  $userModel->update();

        // remove token access 
        Bz::removeAssetToken($userModel);

        // log
        $logID = (function_exists('mk_punch_log_after_logout')) ? mk_punch_log_after_logout($userModel) : false;
        return $updateRes;
    }

    /**
     * getUserForGlobalAccess
     * This will be used for global use case 
     */
    public static  function getUserForGlobalAccess()
    {
        return self::find(get_option_value('global_admin_user_id'));
    }

    /**
     * get_users
     */
    public static function get_users($formData = array(), $user_model = array())
    {
        $users = array();
        $u = "users";
        $r = 'roles';
        $col = [$u . '.*'];
        $query = UserModel::query();
        // $this->db->join('roles r', 'u.role_id =r.role_id', 'left');
        $query->select($col);
        // single user id is coming then return
        if (isset($formData['id']) && !empty($formData['id'])) {
            $query->where($u . ".ID", $formData['id']);
            return $query->first();
        }
        // not in user id
        if (isset($formData['not_id']) && !empty($formData['not_id'])) {
            $query->where($u . ".id", "!=", $formData['not_id']);
        }
        // email
        if (isset($formData['email']) && !empty($formData['email'])) {
            $query->where($u . ".email", $formData['email']);
        }

        // role id
        if (isset($formData['role_id']) && !empty($formData['role_id'])) {
            $query->where($u . ".role_id", $formData['role_id']);
        }

        // if not root login then hide root user role
        if (!is_root_admin()) {
            $query->whereNotIn($u . '.role_id', array(ROLE_ROOT_USER));
        }

        // where username
        if (isset($formData['username']) && !empty($formData['username'])) {
            $query->where($u . ".username", $formData['username']);
        }

        // password
        if (isset($formData['password']) && !empty($formData['password'])) {
            $query->where($u . ".password", $formData['password']);
        }

        // user status
        if (isset($formData['status']) && in_array($formData['status'], array("0", "1"))) {
            $query->where($u . ".status", $formData['status']);
        }
        // user search
        if (isset($formData['search']) && !empty($formData['search'])) {
            $query->where(function ($query) use ($formData, $u) {
                $query->orWhere($u . '.name', 'like', "%" . $formData['search'] . "%");
                $query->orWhere($u . '.first_name', 'like', "%" . $formData['search'] . "%");
                $query->orWhere($u . '.last_name', 'like', "%" . $formData['search'] . "%");
                $query->orWhere($u . '.email', 'like', "%" . $formData['search'] . "%");
                $query->orWhere($u . '.mobile1', 'like', "%" . $formData['search'] . "%");
                return $query;
            });
        }

        // mobile
        if (isset($formData['mobile']) && $formData['mobile'] != '') {
            $query->where(function ($query) use ($formData, $u) {
                $query->where($u . '.mobile1', 'like', "%" . $formData['search'] . "%");
                $query->orWhere($u . '.mobile2', 'like', "%" . $formData['search'] . "%");
                return $query;
            });
        }

        // search by uploaded in folder date
        if (isset($formData['filter_date']) && $formData['filter_date']) {
            // from_upload_date
            if (isset($formData['fromDate']) && !empty($formData['fromDate'])) {
                $query = $query->where($u . '.created_at', '>=', $formData['fromDate'] . " 00:00:00");
            }
            // to_upload_date
            if (isset($formData['toDate']) && !empty($formData['toDate'])) {
                $query = $query->where($u . '.created_at', '<=', $formData['toDate'] . "  23:59:59");
            }
        }

        // count post and return
        if (isset($formData['count']) && $formData['count']) {
            $count = $query->count();
            return $count;
        }

        // sort
        if (isset($formData['sort']) && $formData['sort']) {
            $sort = explode('_', $formData['sort']);
            $formData['orderBy'] = $u . "." . $sort[0];
            $formData['order'] = $sort[1];

            // manage last login
            if ($formData['sort'] == "last_login_at:asc") {
                $formData['orderBy']    = $u . '.meta_data->last_login_at';
                $formData['order'] = "asc";
            }
            if ($formData['sort'] == "last_login_at:desc") {
                $formData['orderBy']    = $u . '.meta_data->last_login_at';
                $formData['order'] = "desc";
            }
        }
        // default decending order
        $orderBy = $formData['orderBy'] ?? $u . ".id";
        $order = $formData['order'] ?? 'desc';
        $query->orderBy($orderBy, $order);

        $per_page = 10;
        if (isset($formData['per_page']) && $formData['per_page']) {
            $per_page = $formData['per_page'];
        }
        return $query->paginate($per_page);
    }

    /**
     * getUserFilterSortings
     * Return user filter sorting options
     * \App\ModelsUserModel::getUserFilterSortings()
     */
    public static function getUserFilterSortings()
    {
        $sortings = [];
        $sortings[] = [
            'title' => "Latest",
            "value" => "id_desc"
        ];
        $sortings[] = [
            'title' => "Oldest First",
            "value" => "id_asc"
        ];
        $sortings[] = [
            'title' => "Name Asc",
            "value" => "name_asc"
        ];
        $sortings[] = [
            'title' => "Name Desc",
            "value" => "name_desc"
        ];
        $sortings[] = [
            'title' => "Last Login Asc",
            "value" => "last_login_at:asc"
        ];
        $sortings[] = [
            'title' => "Last Login Desc",
            "value" => "last_login_at:desc"
        ];
        // $sortings[] = [
        //     'title' => "Status Active",
        //     "value" => "status_asc"
        // ];
        // $sortings[] = [
        //     'title' => "Status Desc",
        //     "value" => "status_desc"
        // ];
        return $sortings;
    }

    /**
     * get_last_sent_verification_data
     * Get last sent verificaion data with in 10 minutes 
     */
    public static function get_last_sent_verification_data($filters = [])
    {
        return VerificationModel::where('type', $filters['type'])
            ->where('sent_to', $filters['sent_to'])
            ->whereRaw("created_at >= NOW() - INTERVAL 10 MINUTE")
            ->first();
    }

    /**
     * sendEmailVerificaionLink
     * Send verification email 
     */
    public static function sendEmailVerificaionLink($userModel, $via = 'email')
    {
        $sent_to = $userModel->email;
        $processType  =  "email_verify";
        $verificationFilers = [];
        $verificationFilers['type'] = $processType;
        $verificationFilers['via'] = $via;
        $verificationFilers['sent_to'] = $sent_to;
        // $lastVerificationData = self::get_last_sent_verification_data($verificationFilers);
        //  if (!empty($lastVerificationData) && $lastVerificationData != "null") {
        //      throw new Exception("We have already sent a verification $processType please wait for next 10 minutes or try again later after 10 minutes");
        //  }
        $resetCode = rand(100000, 999999);
        $data_to_insert = [];
        $data_to_insert['type'] = $processType;
        $data_to_insert['via'] = $via;
        $data_to_insert['code'] = $resetCode;
        $data_to_insert['sent_to'] = $sent_to;
        $data_to_insert['attempted'] = 0;
        $verificationModel = VerificationModel::entry_in_verification($data_to_insert);
        $verifyLink = route('api.user.verifyEmailViaLink', ['hash' => encryptor($verificationModel->id)]);
        if (!empty($verificationModel)) {
            // send Email Here
            if (env('IS_ENABLE_EMAIL')) {
                ob_start();
?>
                <h2>Verify your email account</h2>
                <p>
                    To complete the account setup process and ensure the security of your account, we kindly ask you to verify your email address by clicking on the link below:
                </p>
                <p style="font-weight: 800;"><a href="<?php echo $verifyLink ?>"><?php echo $verifyLink ?></a></p>
                <p>If you didn't request this, you can safely ignore this email.</p>
                <p>Thank you!</p>
<?php
                $message = ob_get_clean();

                Mail::to($sent_to)->send(new SystemEmail([
                    'subject' => __('Verify your email account'),
                    'message' => $message,
                    'to' => $sent_to
                ]));
            }
        }
    }

    /**
     * uploadProfileImageToMedia
     * Upload profile image to media manager
     */
    public static function uploadProfileImageToMedia()
    {
        $mediaApiIns = new MediaApiController();
        $formData['folder_id'] = 3;
        $formData['upload_type'] = "profile_image";
        $jsonResponse = $mediaApiIns->uploadMediaFiles($formData);
        return $jsonResponse->getData();
    }
}
