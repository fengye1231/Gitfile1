


<?php
include_once('simple_html_dom.php');
/*
$html = new simple_html_dom();

$html->load_file('https://www.baidu.com/');
//$html = file_get_html('http://www.cne.hk/xq/btc.htm');
$ret=$html->find('#s-usersetting-top');

var_dump($ret);
*/
/*
$return=file_get_contents('http://www.cne.hk/xq/btc.htm');
//var_dump($ret);
$regex4='/id="last_last" dir="ltr">.*?<\/span>/';
print_r(preg_match_all($regex4, $return, $matches));
if(preg_match_all($regex4, $return, $matches)){
    print_r($matches);
    //$regex5='/>[\s\S]*?</i';
    $regex5='/\d+.*\d+/is';
    $return=$matches[0][0];
    if(preg_match_all($regex5, $return, $matches1)){
        print_r($matches1[0][0]);

        return $matches1[0][0];
        /*
        $regex6='/,(\d+)/';
        if(preg_match_all($regex5, $return, $matches1)) {
            print_r($matches1[0][0]);
        }else{
                echo '2';
            }
        }

    }else{
        echo '未读取到1';
    }
}else{
    echo '未读取到';
}
*/


$return=file_get_contents('https://www.okcoin.com/api/v1/ticker.do?symbol=btc_usd');
var_dump($return);

/*
$regex4='/id="last_last" dir="ltr">.*?<\/span>/';
print_r(preg_match_all($regex4, $return, $matches));
if(preg_match_all($regex4, $return, $matches)){
    print_r($matches);
    //$regex5='/>[\s\S]*?</i';
    $regex5='/\d+.*\d+/is';
    $return=$matches[0][0];
    if(preg_match_all($regex5, $return, $matches1)){
        print_r($matches1[0][0]);

        return($matches1[0][0]);
        /*
        $regex6='/,(\d+)/';
        if(preg_match_all($regex5, $return, $matches1)) {
            print_r($matches1[0][0]);
        }else{
                echo '2';
            }
        }

    }else{
        echo '未读取到1';
    }
}else{
    echo '未读取到';



}
*/
