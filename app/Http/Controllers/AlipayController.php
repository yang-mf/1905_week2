<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlipayController extends Controller
{
    public function pay(){

        //公共请求参数
        $ali_gateway='https://openapi.alipaydev.com/gateway.do';
        $app_id='2016101300673569';
        $method='alipay.trade.page.pay';
        $charset='utf-8';
        $sign_type='RSA2';
        $sign='';
        $timestamp=date('Y-m-d H:i:s');
        $version='1.0';
        $notify_url='http://api.1905.com/pay/notify';
        $return_url='http://api.1905.com/pay/return';
        $biz_content='';


        //请求参数
        $out_trade_no=time() . rand(1111,9999);
        $product_code='FAST_INSTANT_TRADE_PAY';
        $total_amount=0.1;
        $subject='测试支付'.$out_trade_no;

        $request_param=[
            'out_trade_no'     =>$out_trade_no,
            'product_code'     =>$product_code,
            'total_amount'     =>$total_amount,
            'subject'          =>$subject,
        ];

        $param=[
            'app_id'        =>$app_id,
            'method'        =>$method,
            'charset'       =>$charset,
            'sign_type'     =>$sign_type,
            'timestamp'     =>$timestamp,
            'version'       =>$version,
            'notify_url'    =>$notify_url,
            'return_url'    =>$return_url,
            'biz_content'   =>json_encode($request_param),
        ];

//        echo '<pre>';print_r($param);echo '</pre>';
        //字典序排序
        ksort($param);
//        echo '<pre>';print_r($param);echo '</pre>';

        //拼接 k1=v1&k2=v2
        $str="";
        foreach ($param as $k=>$v){
            $str .=$k .'='. $v .'&';
        }
        $str = rtrim($str,'&');
        //计算签名
        $key = storage_path('keys/app_priv');
        $priKey = file_get_contents($key);
//        print_r($priKey);die;
        $res = openssl_get_privatekey($priKey);
        //var_dump($res);echo '</br>';
        openssl_sign($str, $sign, $res, OPENSSL_ALGO_SHA256);       //计算签名
        $sign = base64_encode($sign);
        $param['sign'] = $sign;
        // 4 urlencode
        $param_str = '?';
        foreach($param as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $param_str = rtrim($param_str,'&');
        $url = $ali_gateway . $param_str;
        //发送GET请求
//        echo $url;die;
        header("Location:".$url);

    }
}
