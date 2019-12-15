<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Schema;

class Localization
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        if (Schema::hasTable('general_settings')){
            $language = \DB::table('general_settings')->where('id', '1')->value('language');
        }else
        {
            $language  = 'en';
        }
        \Session::put('locale', $language);

        if(\Session::has('locale')) {
            \App::setlocale(\Session::get('locale'));
        }
        return $next($request);
    }
}
