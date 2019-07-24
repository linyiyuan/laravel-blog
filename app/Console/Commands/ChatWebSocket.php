<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cookie;

class ChatWebSocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:websocket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用来执行swoole长连接';

    /**
     * 储存swoole的地址
     * 
     * @var string
     */
    protected $swoole_url = "";

    /**
     *储存swoole端口
     * 
     * @var string
     */
    protected $swoole_port = "";

    /**
     * 初始化
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->swoole_url = Config('app.chat_websocket_swoole_url');

        $this->swoole_port = Config('app.chat_websocket_swoole_port');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $server = new \swoole_websocket_server($this->swoole_url, $this->swoole_port);
     
        $server->on('open', function (\swoole_websocket_server $server, $request) {
            echo "server: handshake success with fd{$request->fd}\n";
        });
         
        $server->on('message', function (\swoole_websocket_server $server, $frame) {
            foreach($server->connections as $key => $fd) {
                $user_message = $frame->data;
                $user_message = json_decode($user_message,true);
                switch ($user_message['type']){
                    case 'joinMessage':
                        $user_message = json_encode($user_message,JSON_UNESCAPED_UNICODE);
                        $server->push($fd, $user_message);
                        break;
                    case 'sendMessage':
                        $parsedown = new \Parsedown();
                        $parsedown->setSafeMode(true);
                        $user_message['data'] = $parsedown->text($user_message['data']);
                        $user_message = json_encode($user_message,JSON_UNESCAPED_UNICODE);
                        $server->push($fd, $user_message);
                        break;
                }
            }
         
        });
         
        $server->on('close', function ($ser, $fd) {
            echo "client {$fd} closed\n";
        });
         
        $server->start();
    }
}
