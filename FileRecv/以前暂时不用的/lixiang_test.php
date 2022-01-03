<?php




/*
$pat_form='%<tr.*?>(.*?)</tr>%si';


$aaa='<span class="pid-1057391-last" id="last_last">50,052.6</span>';

//preg_match_all($pat_form,$result,$arr);
//$tr = explode('<tr>', $aaa);

$selling =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($aaa));
        //$purchase =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($aaa));

echo $selling;
*/


/*
$aaa='<span class="arial_20 greenFont  pid-1057391-pcp parentheses" dir="ltr">+0.13%</span>';

//preg_match_all($pat_form,$result,$arr);
//$tr = explode('<tr>', $aaa);

$selling =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($aaa));
        //$purchase =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($aaa));

echo $selling;
*/


/*
$aaa='<span class="arial_20 greenFont   pid-1057391-pc" dir="ltr">+65.9</span>';

//preg_match_all($pat_form,$result,$arr);
//$tr = explode('<tr>', $aaa);

$selling =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($aaa));
//$purchase =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($aaa));

echo $selling;
*/
/*
$aaa='<span class="arial_20   pid-1057391-pc redFont" dir="ltr">-512.8</span>';

//preg_match_all($pat_form,$result,$arr);
//$tr = explode('<tr>', $aaa);

$selling =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($aaa));
//$purchase =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($aaa));

echo $selling;
*/


echo requestGet('https://cn.investing.com/crypto/bitcoin?__cf_chl_jschl_tk__=pmd_QzvQTUYbQy73NFH402IboqNM_A4qZMzyg57oJ3fQyVQ-1630824268-0-gqNtZGzNAiWjcnBszQnl');


function requestGet($url, $timeout = 15, $debug = true) {
    $header[] = "Content-type: application/x-www-form-urlencoded";
    $user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
    if(!function_exists('curl_init')) return false;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $result = curl_exec($ch);
    if($debug) {
        if(curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);
        }
    }
    curl_close($ch);
    return $result;
}


