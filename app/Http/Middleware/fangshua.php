<?php

namespace App\Http\Middleware;

use Closure;
//use Illuminate\Http\Request;
use http\Env\Request;
use Illuminate\Support\Facades\Redis;

class fangshua
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next)
    {
        $token=$request->input('token');
        if(isset($token)){

        }
        $user_token=$request->input('token');
        $current_url = $_SERVER['REQUEST_URI'];
        $redis_key = 'str:count:u:'.$user_token.':url:'.md5($current_url);
        $count = Redis::get($redis_key);        //获取接口的访问次数
        if($count>=7){
            Redis::expire($redis_key,5);
            echo '刷新已经到达上限';die;
        }

        return $next($request);
    }
}
