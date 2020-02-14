<?php
/**
 * Created by PhpStorm.
 * User: lingxiang
 * Date: 2020/2/14
 * Time: 下午1:40
 */

namespace Lingxiang\Elasticsearch;

use Illuminate\Support\Facades\Facade;

class LaravelServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Elasticsearch';
    }
}