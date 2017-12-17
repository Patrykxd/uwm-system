<?php

namespace App\Http\Controllers\Admin\Includes;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Includes\Includes;

/**
 * Includes controller do zaczytywania pojedyńczych elementów np:menu
 */

class Includes extends Controller {

    /**
     * get menu admin panel
     * @return array
     */
    public static function menu() {
//TODO zmienic linki do controllerów
        $data = array(
//            'admin' => 'Panel',
//            'admin/settings' => 'Ustawienia',
//            'Konto' => array(
//                'admin/wyloguj' => 'Wyloguj',
//                'admin/account' => 'Użytkownicy',
//            ),
//            'Zarządzaj treścią' => array(
//                'admin/articles' => 'Strony',
//                'admin/articles/modules' => 'Moduły',
//                'admin/sliders' => 'Slidery',
//                'admin/galleries' => 'Galerie',
//                'admin/contacts' => 'Kontakty',
//                'admin/news' => 'Aktualności',
//            ),
            'UWM' => array(
                'admin/scrapler/projects' => 'Projekty',
                'admin/logout' => 'Wyloguj się',
            )
        );

        return $data;
    }

}
