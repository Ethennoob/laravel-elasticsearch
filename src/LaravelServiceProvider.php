<?php

namespace Lingxiang\Elasticsearch;

use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelServiceProvider.
 *
 * @author lingxiang
 */
class LaravelServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $packagePath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->packagePath.'config' => config_path(),
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
        //单例绑定服务
        $this->app->singleton("Elasticsearch", function () {
            return new Builder();
        });
    }
}
