<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Models\Seo\Projects;
use Illuminate\Support\Facades\Auth;

class MyProjects {

    /**
     *  sprawdzenie czy użytkownik działa an włąsnym projekcie
     * @param type $request
     * @param Closure $next
     * @return type
     */
    public function handle($request, Closure $next) {
        
        //mam dostęp wszedzie
        if (Auth::user()->id != 1) {
            $project = Projects::where('id_user', Auth::user()->id)->where('id', $request->route()->id)->first();

            if (is_null($project)) {
                return redirect('/admin/start')->withErrors(array('Niemasz uprawnien do tego projektu!'));
            }
        }
        
        return $next($request);
    }

}
