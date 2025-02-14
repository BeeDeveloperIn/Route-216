<?php

namespace App\Http\Controllers\Admin\Locations;

use App\Http\Controllers\Admin\MyAdminController;
use PHPUnit\Exception;

class LocationController extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    // getStatesOfCountryByAjax
    // return state list by ajax method
    public function getStatesOfCountryByAjax()
    {
        try {
            $formData = request()->all();
            if (!isset($formData['country_code']) || (isset($formData['country_code']) && empty($formData['country_code']))) {
                throw new \Exception('Country code is required to fetch states list.');
            }
            $states_list_options_html = "";
            $states = get_states_list($formData['country_code']);

            // set state html
            if (!empty($states)) {
                foreach ($states as $code => $eachState) {
                    $states_list_options_html .= "<option value='{$code}'>{$eachState}</option>";
                }
            }
            // End set state html

            // get country phone code
            $phoneCode = get_country_phone_code_list($formData['country_code']);
            $this->ajax_data['states_list'] = $states;
            $this->ajax_data['states_list_options_html'] = $states_list_options_html;
            $this->ajax_data['country_ext'] = str_replace('+', '', $phoneCode);
            $this->ajax_data['country_phone_code_list'] = $phoneCode;
            $this->ajax_data['country_phone_code_list_html'] = get_country_phone_code_dropdown_options_html($formData['country_code']);
            $this->ajax_msg[] = "Data fetched";
            return $this->mk_print_ajax_error_json(true, true, true);
        } catch (Exception $exception) {
            $this->ajax_errors[] = $exception->getMessage();
            return $this->mk_print_ajax_error_json(false, true, true); // print error
        }
    }
}
