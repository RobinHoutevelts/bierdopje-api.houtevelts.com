<?php
namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use mattiasdelang\Bierdopje;

class AppServiceProvider extends ServiceProvider {

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind('BierdopjeApi', function ($app) {
      $client = new Client([
        'headers' => [
          'User-Agent' => 'BDApi/' . env('APP_VERSION', '0.0.1'),
        ],
      ]);

      return new Bierdopje($client);
    });
  }
}
