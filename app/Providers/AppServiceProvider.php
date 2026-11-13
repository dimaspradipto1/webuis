<?php

namespace App\Providers;

use App\Models\BahasaSetting;
use App\Models\Contact;
use App\Models\Layanan;
use App\Models\PmbSetting;
use App\Models\Publikasi;
use App\Models\Topbar;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('url', function ($app) {
            $routes = $app['router']->getRoutes();
            $app->instance('routes', $routes);

            $url = new \App\Routing\VirtualSlugUrlGenerator(
                $routes,
                $app->rebinding('request', function ($app, $request) {
                    $app['url']->setRequest($request);
                }),
                $app['config']['app.asset_url']
            );

            $url->setSessionResolver(function () use ($app) {
                return $app['session'] ?? null;
            });

            $url->setKeyResolver(function () use ($app) {
                $config = $app->make('config');

                return [$config->get('app.key'), ...($config->get('app.previous_keys') ?? [])];
            });

            $app->rebinding('routes', function ($app, $routes) {
                $app['url']->setRoutes($routes);
            });

            return $url;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $contact = Contact::latest('id')->first();
            $pmbSetting = PmbSetting::first();
            $navProdis = Layanan::where('aktif', true)->orderBy('urutan')->get();
            $navPublikasis = Publikasi::where('aktif', true)->orderBy('urutan')->get();
            $topbarSetting = Topbar::where('is_active', true)->latest('id')->first();
            $waAdminSetting = \App\Support\WaAdminConfig::get();

            $cleanWa = $waAdminSetting->clean_wa ?? '';
            if (empty($cleanWa)) {
                $waSource = $topbarSetting?->telepon ?? $contact?->no_wa ?? '';
                if (! empty($waSource)) {
                    $cleanWa = preg_replace('/[^0-9]/', '', $waSource);
                    if (strpos($cleanWa, '08') === 0) {
                        $cleanWa = '628'.substr($cleanWa, 2);
                    }
                }
            }

            try {
                $bahasaList = BahasaSetting::where('is_active', true)->orderBy('urutan')->get();
                $defaultBahasa = $bahasaList->firstWhere('is_default', true) ?? $bahasaList->first();
            } catch (\Throwable $e) {
                $bahasaList = collect();
                $defaultBahasa = null;
            }

            $view->with([
                'contact' => $contact,
                'cleanWa' => $cleanWa,
                'waAdminSetting' => $waAdminSetting,
                'tampilan' => \App\Support\TampilanConfig::get(),
                'pmbSetting' => $pmbSetting,
                'navProdis' => $navProdis,
                'navPublikasis' => $navPublikasis,
                'topbarSetting' => $topbarSetting,
                'bahasaList' => $bahasaList,
                'defaultBahasa' => $defaultBahasa,
            ]);
        });
    }
}
