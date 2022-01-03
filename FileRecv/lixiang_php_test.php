<?php


/*
class aaa
{


    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }


}
*/

//$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxd32617e613511fe7&secret=07ecdc46008edc7ef15113ce5b42bf9f';
//$url='https://www.xinxinxiangrong1.xyz/demo.php';
//$re=file_get_contents($url);

//print_r($re);


function aa(){
    bb();
    return 456;
}

function bb(){
   return 123;
}


print_r(aa());




