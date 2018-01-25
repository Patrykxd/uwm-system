<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Models\Seo\Links;
use Illuminate\Support\Facades\Auth;

class MyLinks {

    /**
     *  sprawdzenie czy użytkownik działa na włąsnym linku
     * @param type $request
     * @param Closure $next
     * @return type
     */
    public function handle($request, Closure $next) {
        //mam dostęp wszedzie Admin
        if (Auth::user()->id != 1) {
            //pobierz wskazany link i wyjmij id projektu
            $link = Links::where('links_id', $request->route()->id)->first();

            //sprawdz czy id projektu jest zgodne z użytkownikiem
            $auth = $link->projects()->where('id', 
                    $link->projects_id)->where('id_user', Auth::user()->id)->first();

            //jesli nie cofamy go do startu
            if (is_null($auth)) {
                return redirect('/admin/start')
                        ->withErrors(array('Niemasz uprawnien do tego projektu!'));
            }
        }
        return $next($request);
    }

}
