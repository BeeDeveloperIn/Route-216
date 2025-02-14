<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleCapabilitiesModel extends Model
{
    protected $table = 'role_capabilities';
    protected $fillable = array();
    protected $guarded = array();


    // return active capabilities
    public static function getActiveCapabilities()
    {
        return self::where('status', 1)->get();
    }


}
