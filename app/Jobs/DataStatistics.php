<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DataStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $ip;
    /**
     * 获取访问ip
     *
     * @return void
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    /**
     * 添加一条统计访问数据队列
     *
     * @return void
     */
    public function handle()
    {
        $nowTime = date('Y-m-d',time());

        $redis = Redis::connection('blog_visits');

        if (!$redis->Hget($nowTime,$this->ip)) {
            $redis->Hset($nowTime,$this->ip,time());
        }
    }
}
