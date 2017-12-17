<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

/**
 * Start controller
 */
class Start extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        return view('admin.start', array('name'=>Auth::user()->name));
    }

}
