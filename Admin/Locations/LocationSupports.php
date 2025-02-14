<?php

namespace App\Http\Controllers\Admin\Locations;

class LocationSupports
{
    public static function get_country_states_js($filters = array())
    {
        ob_start();
        ?>
        <script>
            function getCountryStates(country_code, callback) {
                $.ajax({
                    url: '<?php echo route('location.country.states');?>',
                    method: 'get',
                    data: {country_code: country_code},
                    dataType: 'json',
                    success: function (response) {
                        callback(response);
                    }
                });
            }
        </script>
        <?php
        echo ob_get_clean();
    }

}