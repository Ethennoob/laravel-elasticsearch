<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ESInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:indices:create {index?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init laravel es for post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $indices = !is_null($this->argument('index')) ?
            $this->argument('index') :
            config('search.index');

        $host = config('search.hosts')[0];

        $client = new Client();
        // 创建模版
        $url = $host . '/_template/tmp';
//        $client->put($url, [
//            'json' => [
//                'template' => $indices,
//                'settings' => [
//                    'number_of_shards' => 1
//                ],
//                'mappings' => [
//                    '_default_' => [
//                        '_all' => [
//                            'enabled' => true
//                        ],
//                        'dynamic_templates' => [
//                            [
//                                'strings' => [
//                                    'match_mapping_type' => 'string',
//                                    'mapping' => [
//                                        'type' => 'text',
//                                        'analyzer' => 'ik_smart',
//                                        'ignore_above' => 256,
//                                        'fields' => [
//                                            'keyword' => [
//                                                'type' => 'keyword'
//                                            ]
//                                        ]
//                                    ]
//                                ]
//                            ]
//                        ]
//                    ]
//                ]
//            ]
//        ]);

        $this->info("========创建模板成功=======");

        $url = $host . '/' . $indices;
        $client->put($url, [
            'json' => [
                'settings' => [
                    'refresh_interval' => '5s',
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    '_default_' => [
                        '_all' => [
                            'enabled' => false
                        ]
                    ]
                ]
            ]
        ]);
        $this->info("========创建索引成功=======");
    }

}