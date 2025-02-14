<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Admin\Auth\Auth;
use App\Http\Controllers\Admin\MyAdminController;
use App\Models\SystemPostModel;
use App\Models\UserModel;
use App\plugins\login\Models\PaymentModel;
use App\plugins\mcommerce\models\OrderCiModel;
use Harimayco\Menu\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;

class Dashboard extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
        add_action('mk_dashboard_setup', [$this, 'mk_dashboard_setup_callback']);
    }

    /**
     * @return void
     * mk_dashboard_setup_callback
     */
    function mk_dashboard_setup_callback()
    {
        switch (\Illuminate\Support\Facades\Auth::user()->role_id) {
            case ROLE_ADMIN:
            case ROLE_ROOT_USER:
                $dashboard_widgets = $this->getDashboardWidgetForAdmin();
                $this->data['dashboard_widgets'] = $dashboard_widgets;
                $view = $this->renderAdminView('dashboard/dashboard_widgets');
                break;
            case ROLE_CUSTOMER:
                $dashboard_widgets = $this->getDashboardWidgetForCustomer();
                $this->data['dashboard_widgets'] = $dashboard_widgets;
                $view = $this->renderCustomerView('dashboard/dashboard_widgets');
                break;
            default:
                $dashboard_widgets = $this->getDashboardWidgetForAdmin();
                $this->data['dashboard_widgets'] = $dashboard_widgets;
                $view = $this->renderAdminView('dashboard/dashboard_widgets');
                break;
        }

        if (empty($dashboard_widgets)) {
            return;
        }
        echo $view;
    }

    /**
     * @param $post_type
     * @return mixed
     * getCountOfPost
     * Return count of posts
     */
    public function getCountOfPost($post_type = 'page')
    {
        $table = 'posts';
        if ($post_type == "page") {
            $table = 'pages';
        }

        $postModel = new SystemPostModel(); // create instance of post
        $postModel->setTable($table); // set dynamic table
        $postModel->where('status', 1);
        return $postModel->count();
    }

    /**
     * @return void
     * getDashboardWidgetForAdmin
     * Cpu
     */
    public function getDashboardWidgetForAdmin()
    {
        $widgets = array();
        if (!is_root_admin()) {
            if (!$this->has_operation_access('manage_dashboard_widgets')) {
                return;
            }
        }
     
        $widgets[] = array(
            'title' => 'Total Users',
            'value' => UserModel::count('id'),
            'link' => route('admin.users', ['user_type' => 'user']),
            'icon' => ''
        );
        $widgets[] = array(
            'title' => 'Active Users',
            'value' => UserModel::where('status', 1)->count('id'),
            'link' => route('admin.users', ['user_type' => 'user', 'status' => 1]),
            'icon' => ''
        );
        $widgets[] = array(
            'title' => 'Inactive Users',
            'value' => UserModel::where('status', 0)->count('id'),
            'link' => route('admin.users', ['user_type' => 'user', 'status' => 0]),
            'icon' => ''
        );
        return apply_filters('dashboard_widgets', $widgets);
    }

    /**
     * @return void
     * getDashboardWidgetForAdmin
     * Cpu
     */
    public function getDashboardWidgetForCustomer()
    {
        $widgets = array();
        if (!is_root_admin()) {
            if (!$this->has_operation_access('manage_dashboard_widgets')) {
                return;
            }
        }
        return apply_filters('dashboard_customer_widgets', $widgets);
    }

    # Index
    # show dashboard screen
    public function index()
    {
        switch (\Illuminate\Support\Facades\Auth::user()->role_id) {
            case ROLE_ADMIN:
            case ROLE_ROOT_USER:
                return $this->renderAdminView('dashboard/index');
                break;
            case ROLE_CUSTOMER:
                return $this->renderCustomerView(view: 'dashboard/index');
                break;
            default:
                return redirect('/');
                break;
        }
    }

     # Index
    # show dashboard screen
    public function customerIndex()
    {
        switch (\Illuminate\Support\Facades\Auth::user()->role_id) {
            case ROLE_ADMIN:
            case ROLE_ROOT_USER:
                return $this->renderAdminView('dashboard/index');
                break;
            case ROLE_CUSTOMER:
                return $this->renderCustomerView(view: 'dashboard/index');
                break;
            default:
                return redirect('/');
                break;
        }
    }
}
