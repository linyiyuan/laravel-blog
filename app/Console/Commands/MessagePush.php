<?php
//
//namespace App\Console\Commands;
//
//use Illuminate\Console\Command;
//use Illuminate\Support\Facades\Redis;
//
//class MessagePush extends Command
//{
//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//    protected $signature = 'message:push';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = '用来实现消息异步通知';
//
//
//    /**
//     * 储存swoole的地址
//     *
//     * @var string
//     */
//    protected $swoole_url = "";
//
//    /**
//     *储存swoole端口
//     *
//     * @var string
//     */
//    protected $swoole_port = "";
//
//
//    /**
//     * Create a new command instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        parent::__construct();
//
//        $this->swoole_url = Config('app.message_push_swoole_url');
//
//        $this->swoole_port = Config('app.message_push_swoole_port');
//    }
//
//    /**
//     * Execute the console command.
//     *
//     * @return mixed
//     */
//    public function handle()
//    {
//        set_time_limit(0);
//        ini_set('default_socket_timeout', -1);
//
//        $server = new \swoole_websocket_server("0.0.0.0", 9502);
//
//        $server->on('open', function ($server, $request) {
//            echo "server: handshake success with fd{$request->fd}\n";
//        });
//
//        $server->on('message', function ($server, $frame) {
//            $server->push($frame->fd, "this is server");
//        });
//
//        $server->on('close', function ($ser, $fd) {
//            echo "client {$fd} closed\n";
//        });
//
//        $tcp_server = $tcp_server = $server->addListener('0.0.0.0', 9503, SWOOLE_SOCK_TCP);
//        $tcp_server->set([]);
//        $tcp_server->on('receive',function($serv,$fd,$threadId,$data) use($server){
//            $data = json_decode($data,true);
//            // $server->connections 遍历所有websocket连接用户的fd，给所有用户推送
//            foreach ($server->connections4 as $fd) {
//                Redis::set($fd,$fd);
//                $server->push($fd, $data['message']);
//            }
//
//        });
//        $server->start();
//    }
//}
