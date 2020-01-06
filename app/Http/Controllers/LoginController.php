<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use App\UserLogin;

class LoginController extends Controller
{

    public function test(Request $request)
    {
        $name=$request->input('name');
        $pwd1=$request->input('pwd1');
        $pwd2=$request->input('pwd2');
        if(!$pwd1==$pwd2){
            die('密码有误');
        }
        $pwd=password_hash($pwd1,PASSWORD_BCRYPT);
        $data=[
            'name'          =>$name,
            'pwd'           =>$pwd,
            'last_login'    =>time(),
            'token'         =>rand(000,999).$name,
        ];
        $uid = UserLogin::insertGetId($data);
        var_dump($uid);

    }
    public  function login(Request $request)
    {
        $name = $request->input('name');
        $pass = $request->input('pwd');
        $u = UserLogin::where(['name'=>$name])->first();
        if($u){
            //验证密码
            if( password_verify($pass,$u->pwd) ){
                // 登录成功
                //echo '登录成功';
                //生成token
                $token = Str::random(32);
                $response = [
                    'errno' => 0,
                    'msg'   => 'ok',
                    'data'  => [
                        'token' => $token
                    ]
                ];
            }else{
                $response = [
                    'errno' => 400003,
                    'msg'   => '密码不正确'
                ];
            }
        }else{
            $response = [
                'errno' => 400004,
                'msg'   => '用户不存在'
            ];
        }
        return $response;

    }

    /**
     * 获取用户列表
     * 2020年1月2日16:32:07
     */
    public function userList(Request $request)
    {
        $user_token = $_SERVER['HTTP_TOKEN'];//header传值接收
//        $user_token=$request->input('token');//body传值接收
        echo 'user_token: '.$user_token;echo '</br>';
//        die;
        $current_url = $_SERVER['REQUEST_URI'];
        echo "当前URL: ".$current_url;echo '<hr>';
        //echo '<pre>';print_r($_SERVER);echo '</pre>';
        //$url = $_SERVER[''] . $_SERVER[''];
        $redis_key = 'str:count:u:'.$user_token.':url:'.md5($current_url);
        echo 'redis key: '.$redis_key;echo '</br>';
        $count = Redis::get($redis_key);        //获取接口的访问次数
        echo "接口的访问次数： ".$count;echo '</br>';
        if($count >= 5){
            echo "请不要频繁访问此接口，访问次数已到上限，请稍后再试";
            Redis::expire($redis_key,20);
            die;
        }
        $count = Redis::incr($redis_key);
        echo 'count: '.$count;
    }



}
