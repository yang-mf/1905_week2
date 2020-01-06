<?php

namespace App\Http\Controllers\crypt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CryptController extends Controller
{

    /** 加密 */
    public function encrypt()
    {
        $str=$_GET['str'];
        $p=$_GET['p'];
        $lengh=strlen($str);
        $data="";
        for($i=0;$i<$lengh;$i++)
        {
            $a=ord($str[$i])+$p;
            $chr =chr($a);
            $data .=$chr;
        }
        echo $data;


    }

    /** 解密 */
    public function decrypt()
    {
        $str=$_GET['str'];
        $p=$_GET['p'];
        $leng=strlen($str);
        $info="";
        for($i=0;$i<$leng;$i++)
        {
            $a=ord($str[$i])-$p;
            $chr = chr($a);
            echo $chr   ;
        }
    }
}
