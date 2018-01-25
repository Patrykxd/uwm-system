<?php

namespace App\Http\Controllers\Admin\Includes;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Includes\Includes;

/**
 * Includes controller do zaczytywania
 * elementów graficznego interfejsu użytkownika 
 * np:menu
 */
class Includes extends Controller {

    /**
     * get menu admin panel
     * @return array
     */
    public static function menu() {

        $data = array(
            'admin/start' => 'Start',
            'UWM' => array(
                'admin/scrapler/projects' => 'Projekty',
                'admin/logout' => 'Wyloguj się',
            )
        );

        return $data;
    }

}
