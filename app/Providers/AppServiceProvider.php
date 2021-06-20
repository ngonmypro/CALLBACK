<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //call bladeDrirective to add php command on html
        $this->bladeDirective();

        if (env('APP_ENV') == 'production') {
            URL::forceScheme('https');
        }
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

    private function bladeDirective()
    {
        # Check To Has Permission
        Blade::directive('Permission', function($expression) {
            $result = $this->PermissionAuthtorize($expression) == true ? true : false ;
            return "<?php if (\"$result\"): ?>";
        });
        Blade::directive('EndPermission', function () {
            return "<?php endif; ?>";
        });

        # Check to has jobs
        Blade::directive('Jobs', function ($expression) {
            $bladeOutput = $this->arrayIntersect(\json_encode(Session::get('user_detail')->job), $expression);
            return $bladeOutput;
        });
        Blade::directive('EndJobs', function () {
            return "<?php endif; //Jobs ?>";
        });
    }

    # 1 variable
    public function buildArrayToAccess($onBlade, $expression)
    {
        return "<?php if (in_array(\"$onBlade\", $expression)): ?>";
    }

    # Array variable
    public function arrayIntersect($onBlade, $expression)
    {
        return "<?php if (count(array_intersect($onBlade, $expression)) > 0): ?>";
    }

    public function PermissionAuthtorize(string $expression)
    {
        $_permissions = json_decode(json_encode(Session::get('permission')), true);
        $expression = explode('|', str_replace([' ', '\''], '', $expression));
        if (!blank($_permissions)) {
            foreach ($expression as $val) {
                list($view, $perm) = array_pad(explode('.', $val), 2, '');
                $_perm = isset($_permissions[$view]) ? $_permissions[$view] : null;
                if ($_perm != null) {
                    if ($perm === '*') {
                        return true;
                    } else if (in_array($perm, $_permissions[$view])) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
