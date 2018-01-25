<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Seo\Projects;
use App\Http\Models\Seo\Groups;
use App\Http\Models\Seo\Links;
use Auth;

/**
 * Start controller
 */
class Start extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public $array = [];

    public function index() {

        $data['name'] = Auth::user()->name;
        //pobieranie unikalnych znaczników rel z bazy(bez powtórzeń)
        Links::groupBy('nofollow')->each(function($query)use($data) {
            // następnie wyciągniecie ilości każdego z powtarzających sie znaczników
            // z warunkiem dla 'brak' ich liczba jest za duża dlatego podzielono ja na 1000,
            // aby było możliwe porównanie ich z innymi na wykresach
            $this->array[$query->nofollow] = $query->nofollow == 'brak' ? Links::where('nofollow', $query->nofollow)->count()/1000 : Links::where('nofollow', $query->nofollow)->count();
        });
        // pobieraqnie liczby projektów w bazie
        $data['projects_count'] = Projects::all()->count();
        // pobranie unikalnych adresów www w systemie
        $data['distinct_links_count'] = Links::groupBy('refersto')->count();
        // pobranie ilości linków w systemie
        $data['links_count'] = Links::all()->count() / 100;
        // przekazanie tablicy unikalnych nazw wraz z ich liczba 
        $data['charts'] = $this->array;
        // załadowanie przefiltrowanych danych do widoku
        return view('admin.start', $data);
    }

}
