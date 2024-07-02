<?php

namespace App\Providers;

use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
		//if(config('app.debug')!=true) {
		//\Illuminate\Support\Facades\URL::forceScheme('https');
		//}

        Blade::directive('isMobile', function () {
            return "<?php if(request()->isMobile()): ?>";
        });
    
        Blade::directive('endisMobile', function () {
            return "<?php endif; ?>";
        });
    
        HttpRequest::macro('isMobile', function () {
            $userAgent = request()->server('HTTP_USER_AGENT');
            $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone', 'BlackBerry'];
            
            foreach ($mobileKeywords as $keyword) {
                if (str_contains($userAgent, $keyword)) {
                    return true;
                }
            }
    
            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
