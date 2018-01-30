<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use swoole_websocket_server;
use DB;

class Swoole extends Command
{
    /**
     * The name and signature of the console command.1
     *
     * @var string
     */
    protected $signature = 'swoole:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'start swoole';

    public $host, $port;
    private $serve;
    private $result = [
        'user' => "系统",
        'avar' => "a3.jpg",
        'msg' => "您好啊,使用者",
        'type'=> "3",
        "class_name"=>"chat-ta"
    ];

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
        $this->host = "0.0.0.0";;
        $this->port = "8090";
        $this->serve = new swoole_websocket_server($this->host, $this->port);
        $this->open();
        $this->message();
        $this->close();
        $this->start();
    }

    /**
     * 打开websocket链接
     */
    protected function open()
    {
        $this->serve->on('open', function (swoole_websocket_server $server, $request) {
            $fd = $request->fd;
            $server->users[$fd] = ['fd' => $fd];  //获取客户端id插入table
            $this->info("用户$fd,握手成功");
        });
    }

    /**
     * 接受发送消息websocket
     */
    protected function message()
    {
        $this->serve->on('message', function (swoole_websocket_server $server, $frame) {
            $fd = $frame->fd;
            $state = $frame->opcode;
            $data = json_decode($frame->data,true);
            var_dump($data );
            //msg type  1 初始化  2 通知  3 一般聊天  4 断开链接  5 获取在线用户 6 通知下线
            switch($data['type']){
                case 1:
                    $this->saveUserInfo($server,$data);
                    break;
                case 2:
                    $this->sendToSpecialUser($server,$data);
                    break;
                case 3:
                    $this->sendToSingle($server,$fd,$data);
                    $this->saveUserInfo($server,$data);
                    break;
                case 4:
                    $this->sendToAll($server,$data);
                    break;
            }

        });
    }

    /**
     * 退出websocket
     */
    protected function close()
    {
        $this->serve->on('close', function (swoole_websocket_server $server, $fd) {
            return true;
        });
    }

    /**
     * 调用websocket
     */
    protected function start() {
        // 记录系统
        $this->serve->start();
    }

    protected  function sendToAll($server,$data){
        $data['type'] = "3";
        $user_list = $data['user_list'];
        unset($data['user_list']);

        $fd_list = array();

        foreach ($server->users as $u){
            if(isset($server->users[$u['fd']]['info']))
                if(in_array($server->users[$u['fd']]['info']['user'],$user_list)){
                    $fd_list[] = $u['fd'];
                }
        }
        foreach ($fd_list as $u) {
            $server->push($u, json_encode($data));//消息广播给所有客户端
        }

        $this->info('发送给所有人成功');
    }

    protected  function sendToSpecialUser($server,$data){
        unset($data['type']);

        $user_list = array_column($data,"user");

        $fd_list = array();
        foreach ($server->users as $u){
            if(isset($server->users[$u['fd']]['info']))
                if(in_array($server->users[$u['fd']]['info']['user'],$user_list)){
                    $key = array_search($server->users[$u['fd']]['info']['user'],$user_list);
                    $fd_list[$u['fd']] =  $data[$key];
                }
        }
        foreach ($fd_list as $k=>$u) {
            $server->push($k, json_encode($u));//消息广播给所有客户端
        }

        $this->info('发送给所有人成功');
    }

    protected  function sendToSingle($server,$fd,$data){
        //查询用户是否签约
        $msg = $data['msg'];
        $user = DB::table("users")->where("sjhm",$data['user'])->first();
        $user = json_decode(json_encode($user),true);
        if(is_null($user)){
            $this->result["msg"] = "你不是签约用户";
            $this->send($server,$fd);
            return false;
        }
        $user['date'] = $user['zzsj'];
        $user['khh'] = substr($user['khh'],6,-1);




        $dxmb = DB::table("dxmb")->get();
        //短信模板
        $dxmb = json_decode(json_encode($dxmb),true);

        //短信编号
        $dxbh_arr = array_column($dxmb,"dxbh");
        $dxbh = implode("<br>",$dxbh_arr);
        if(!in_array($msg,$dxbh_arr)){
            $this->result["msg"] = "该命令不存在,你是否想要查询以下命令<br>$dxbh";
            $this->send($server,$fd);
            return false;
        }

        $dxmb = DB::table("dxmb")->where("dxbh",$msg)->get();
        $dxmb = json_decode(json_encode($dxmb),true);

        preg_match_all("/\{([a-zA-Z0-9]+)\}/",$dxmb["0"]["mbnr"],$match);
        $replace = array();
        $subject = array();
        foreach($match[1] as $v){
            if(isset($user[$v])){
                $replace[] = $user[$v];
            }

            $subject[] = "/\{$v\}/";

        }
        $content = preg_replace($subject,$replace,$dxmb[0]["mbnr"]);
        $this->result["msg"] = $content;
        $this->send($server,$fd);

    }

    protected function send($server,$fd){
        $server->push($fd, json_encode($this->result));//消息广播给所有客户端
        $this->info("发送给单个人成功");
    }

    protected  function saveUserInfo($server,$data){
        // 保留用户信息
        foreach ($server->users as $u) {
            if (!isset($server->users[$u['fd']]['info'])) {
                $server->users[$u['fd']]['info'] = [
                    'user' => $data['user'],
                    'msg' => isset($data['msg'])?$data['msg']:""
                ];
            }
        }
    }

}
