<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Caps\Caps;
use App\Http\Controllers\Controller;
use Harimayco\Menu\Models\Menus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class MyAdminController extends Controller
{
    public $data = array();
    public $ajax_errors = array();
    public $ajax_msg = array();
    public $ajax_data = array();
    public $ajax_error_with_key = array();

    /*
     * Constructor call
     */
    public function __construct()
    {
        // Set timezone
        date_default_timezone_set('Asia/Kolkata');
    }


    # has operation access
    # ye role and uski permission check krega
    public function has_operation_access($cap = "")
    {
        $caps = new Caps();
        $capData = $caps->can($cap);
        return apply_filters('has_operation_access', $cap, $capData);
    }

    # show_invalid_access
    public function show_invalid_access()
    {
        return $this->renderAdminView('global/invalid_access');
    }


    public function getStandardErrorFormat($ex, $_errs, $res = [])
    {
        return response()->json(array_merge($res, array(
            'succ' => false,
            'error_track' => config('app.debug') ? $ex->getFile() . $ex->getLine() : null,
            'public_msg' => $ex->getMessage(),
            'errs' => $_errs
        )), 200);
    }

    public function getStandardSuccFormat()
    {
        return [
            'succ' => true,
            'public_msg' => __('common.default_public_msg')
        ];
    }

    /*
     * renderAdminView
     * Load admin view from admin view folder
     */
    public function renderAdminView($view = "")
    {
        /*
         * First check in admin theme
         * then look for theme
         */
        $this->get_admin_theme_assets();

        // set website menu
        $website_menu_id = apply_filters('mk_admin_menu_id', 1);
        $public_menu = array();
        $final_view = "admin/" . $view;
        if (View::exists($final_view)) {
            return view($final_view, $this->data);
        } else {
            // check in plugin view
            if (View::exists($view)) {
                return \view($view, $this->data);
            } else {
                return abort('404');
            }
        }
    }

     /*
     * renderCustomerView
     * Load customer view from customer view folder
     */
    public function renderCustomerView($view = "")
    {
        /*
         * First check in admin theme
         * then look for theme
         */
        $this->get_customer_theme_assets();

        // set website menu
        $website_menu_id = apply_filters('mk_admin_menu_id', 1);
        $public_menu = array();
        $final_view = "customer/" . $view;
        if (View::exists($final_view)) {
            return view($final_view, $this->data);
        } else {
            // check in plugin view
            if (View::exists($view)) {
                return \view($view, $this->data);
            } else {
                return abort('404');
            }
        }
    }


    public function renderBeforeLoginView($view = "")
    {
        // set layout path
        $this->data['themeLayoutPath'] = 'admin/layouts.before-login';
        // adminAssets: Admin assets folder url
        $this->data['adminAssets'] = asset('admin/assets/') . '/';
        return view("admin/" . $view, $this->data);
    }

    //get_admin_theme_assets
    // set admin theme assets
    public function get_admin_theme_assets()
    {
        // set layout path
        $this->data['themeLayoutPath'] = 'admin/layouts.theme';
        // adminAssets: Admin assets folder url
        $this->data['adminAssets'] = asset('admin/assets/') . '/';
    }

    //get_admin_theme_assets
    // set admin theme assets
    public function get_customer_theme_assets()
    {
        // set layout path
        $this->data['themeLayoutPath'] = 'customer/layouts.theme';
        // adminAssets: Admin assets folder url
        $this->data['adminAssets'] = asset('admin/assets/') . '/';
    }


    /**
     * mk_print_ajax_error_json
     * This will print error as json format
     */
    public function mk_print_ajax_error_json($success = false, $die = false, $returnJson = false)
    {
        if ($success) {
            $success = true;
        } else {
            $success = false;
        }
        $json = array(
            'succ' => $success, // true or false 
            'errors' => implode(',', $this->ajax_errors), // for only error
            'msg' => implode(',', $this->ajax_msg), // to show common message 
            'data' => $this->ajax_data // data as array
        );
        if ($returnJson) {
            return response()->json($json);
        } else {
            echo json_encode($json);
        }
        if ($die) {
            die();
        }
    }


    /**
     * laravelErrorString
     * laravelErrorString | array to string laravel error
     */
    public function laravelErrorString($validator)
    {
        return implode(",", $validator->messages()->all());
    }

    #get_datatable_css_and_scripts
    # Css and js for datatable
    public function get_datatable_css_and_scripts()
    {
        ob_start();
?>
        <link rel="stylesheet" type="text/css" href="<?php echo asset('/vendors/datatable/css/dataTables.bootstrap4.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" />
        <script type="text/javascript" src="<?php echo asset('/vendors/datatable/dataTables.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo asset('/vendors/datatable/js/dataTables.bootstrap4.js') ?>"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<?php
        return ob_get_clean();
    }

     /**
     * @param $validator
     * @return mixed
     * laravelErrorArray
     * Laravel validation error format to basic array
     */
    public function laravelErrorArray($validator, $mergeWithAjaxErr = true)
    {
        $err = $validator->messages()->all();
        $errWithKey = $validator->errors()->toArray();
        if ($mergeWithAjaxErr) {
            $this->ajax_errors = array_merge($this->ajax_errors, $err);
            $this->ajax_error_with_key = array_merge($this->ajax_error_with_key, $errWithKey);
        }
        return $err;
    }
}
