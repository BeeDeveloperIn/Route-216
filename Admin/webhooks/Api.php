<?php

namespace App\Http\Controllers\admin\Webhooks;

use App\Http\Controllers\Admin\MyAdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Api  extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        return $this->renderAdminView('webhooks/api/index');
    }
}