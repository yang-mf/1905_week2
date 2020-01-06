<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MimaController extends Controller
{
    //设置
    public function set()
    {
        $char = "hello baby";
        $lengh = strlen($char);
//        echo $lengh;echo '</br>';
        $data="";
        for($i=0;$i<$lengh;$i++)
        {
//            echo $char[$i] . '>>>' . ord($char[$i]);echo '</br>';
            $a=ord($char[$i]) + 3;
            $chr=chr($a);
//            echo $char[$i] . '>>>' .$a.'>>>'.$chr;echo '</br>';echo '<hr>';
            $data.=$chr;
        }
        echo $data;
    }

    //获取
    public function get()
    {
        $str='khoor#ede|';
        $lengh=strlen($str);
        $data="";
        for($i=0;$i<$lengh;$i++)
        {
            $a=ord($str[$i]) - 3;
            $chr=chr($a);
//            echo $chr . '>>>' .$chr;echo '</br>';echo '<hr>';
            $data.=$chr;
        }
        echo '解密： '.$data;


    }
}
