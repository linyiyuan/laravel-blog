<?php

namespace App\Http\Controllers\Home;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\Common\BaseController;

class ChatRoomController extends BaseController
{	
	protected $swoole_url = "";

	protected $swoole_port = "";


	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-09-07
	 * 初始化
	 */
	public function __construct()
	{
		$this->swoole_url = Config('app.swoole_url');

		$this->swoole_port = Config('app.swoole_port');
	}

	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-09-07
	 * @聊天室视图
	 */
    public function room()
    {
    	return view('home.chat');
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-09-07	
     * 实习聊天室的逻辑
     */
    public function chat()
    {
    	$server = new swoole_websocket_server($this->swoole_url, $this->swoole_port);
	 
		$server->on('open', function (swoole_websocket_server $server, $request) {
		    echo "server: handshake success with fd{$request->fd}\n";
		});
		 
		$server->on('message', function (swoole_websocket_server $server, $frame) {
		    foreach($server->connections as $key => $fd) {
		        $user_message = $frame->data;
		        $server->push($fd, $user_message);
		    }
		 
		});
		 
		$server->on('close', function ($ser, $fd) {
		    echo "client {$fd} closed\n";
		});
		 
		$server->start();
    }
}
