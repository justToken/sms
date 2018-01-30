<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\Admin\WebSocketClientTrait;
use DB;

class AutoSendMsg extends Command
{
    use WebSocketClientTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'msg:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send msg to user';

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
        
        $user = DB::table("send")->where("status","0")->get();
        $user = json_decode(json_encode($user),true);

        $data = array();
        foreach($user as $v){
            $data[] = [
                'user'=>$v['received'],
                'avar'=>'a3.jpg',
                'msg'=>$v["content"],
                'type'=> "3",
                'class_name'=>"chat-ta",
            ];
            DB::table("send")->where("id",$v['id'])->update(["status"=>1]);
        }
        $data['type'] = 2;

        $data = json_encode($data);
        $this->connect("www.liverecord.cn", 8090,"/");
        $this->sendData($data);
        $this->disconnect();
    }
}
