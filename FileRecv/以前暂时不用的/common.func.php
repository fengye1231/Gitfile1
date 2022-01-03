<?php
/*******************************************************************
 *[TTTuangou] (C)2005 - 2011 Cenwor Inc.
 *
 * This is NOT a freeware, use is subject to license terms
 *
 * @Filename common.func.php $
 *
 * @Author http://www.tttuangou.net $
 *
 * @Date 2011-11-15 13:48:25 $
 *******************************************************************/ 
 

function loadClass($class)
{
	include __DIR__ . '/../functionFiles/' . $class.'.php';
}

function position()
{
	global $rewriteHandler;
	$decribe=__('您的位置：');
	$child_symbol=' &gt; ';
	$mod=$_GET['rmod']?$_GET['rmod']:$_GET['mod'];
	if(strpos($mod,'_')!==false)list($mod,$mod_child)=explode('_',$mod);
	$code=$_GET['code'];

	$config = ConfigHandler::get();

	$list['index']="<a href='{$config['site_url']}'>{$config['site_name']}".__('首页')."</a>";
	
	$list['mod']=ConfigHandler::get('header_menu','list',$mod);
	if($list['mod']!=false)
	{
		if($rewriteHandler)$list['mod']['link']=$rewriteHandler->formatURL($list['mod']['link']);
		$list['mod']="<a href='{$list['mod']['link']}'>{$list['mod']['name']}</a>";
	}
	else
	{
		unset($list['mod']);
	}	
	
	$args_list=func_get_args();
	if(is_array($args_list) and count($args_list)>0)
	{
		foreach ($args_list as $key=>$value)
		{
			if(empty($value))continue;
			if(is_string($value))
			{
				if(trim($value)=='')continue;
				$value=preg_replace("~(\s+[/]\s+)|(\-\>)~",$child_symbol,$value);
			}
			else
			{
				if(isset($value['name']))
				{
					$value['url']=($value['url']!='')?$value['url']:$value['link'];
					$url=$value['url'];
					$name=$value['name'];
				}
				else
				{
					$url=current($value);
					$name=key($value);
				}
				if($rewriteHandler)$url=$rewriteHandler->formatURL($url);
				$value="<a href='$url'>$name</a>";
			}
			$list[$key]=$value;
		}
	}
		$position=implode($child_symbol,$list);
	return $decribe.$position;
}


class Obj
{
	function &Obj($name=null)
	{
		Return Obj::_share($name,$null,'get');
	}

	function &_share($name=null,&$mixed,$type='set')
	{
		static $_register=array();
		if($name==null)
		{
			Return $_register;
		}
		if(isset($_register[$name]) and $type==='get')
		{
			Return $_register[$name];
		}
		elseif($type==='set')
		{
			$_register[$name]=&$mixed;
		}
		
		return true;
	}
	
	function register($name,&$obj)
	{
		Obj::_share($name,$obj,"set");
	}
	
	function &registry($name=null)
	{
		Return Obj::_share($name,$null,'get');
	}
	
	function isRegistered($name)
	{
		Return isset($_register[$name]);
	}
}

function sms_server_init()
{
	return base64_decode('aHR0cDovL3Ntc2xzLnR0dHVhbmdvdS5uZXQ6ODA4MC9MU0JzbXMvc21zSW50ZXJmYWNlLmRv');
}

function ajherrorlog($type='',$log='',$halt=1) {
	$logfile = ROOT_PATH . 'errorlog/'.$type . '-' . date('Y-m').'.php';
	if (!is_file($logfile)) {
		$log ="<? exit; ?>\r\n" . $log; 
	}
	$log = "[".my_date_format(time(),"Y-m-d H:i:s")."]" . $log . "\r\n"; 
	
	global $IoHandler;
	if(is_null($IoHandler)) {
		Load::lib('io');
		$IoHandler = new IoHandler();
		$log = " \r\n ------------------------------------------------------ \r\n " . $log;
	}
	if (!is_dir(dirname($logfile))) {
		$IoHandler->MakeDir(dirname($logfile));
	}
	
	$IoHandler->WriteFile($logfile,$log,'a');
	
	if($halt) {
		exit();
	}
}

function error($type, $message, $file = null, $line = 0)
{
	if(E_NOTICE==$type) return true;
	require_once(LIB_PATH."error.han.php");
	if(false == class_exists("ErrorHandler")) return false;
	$ErrorHandler = new ErrorHandler($type, $message, $file, $line);
	if(error_reporting() && $type) exit($ErrorHandler->fatal());
	return true;
}

function requestGet($url, $timeout = 5, $debug = true) {
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

function requestPost($url, $data, $timeout = 1, $debug = false) {
	if(!function_exists('curl_init')) return false;

	if(!is_array($data) || empty($data) || empty($url)) return false;
	$str = '';
	foreach($data as $k => $v)
	{
		$str .= '&' . $k . '=' . rawurlencode($v);
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
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

function getWphj($pjname = '') {
    $pjname = empty($pjname) ?1316  : $pjname;
    $result = requestPost('https://srh.bankofchina.com/search/whpj/search_cn.jsp', array('pjname' => $pjname));
    if(!empty($result)) {
        $pat_form='%<tr.*?>(.*?)</tr>%si';
        preg_match_all($pat_form,$result,$arr);
        if(!empty($arr) && is_array($arr)) {
            $data =array_map(create_function('$a', 'return  preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($a));'), explode('</td>', $arr[0][2]));
            $purchase = $data[1];
            $selling = $data[3];
            return array('purchase' => $purchase, 'selling' => $selling);
        }
    }
    return false;
}


function getWphj_nm($pjname = '') {
    //$pjname = empty($pjname) ?1316  : $pjname;
   // $result = requestPost('https://srh.bankofchina.com/search/whpj/search_cn.jsp', array('pjname' => $pjname));
    $result = requestPost('https://cn.investing.com/crypto/bitcoin');
    if(!empty($result)) {
        $pat_form='%<tr.*?>(.*?)</tr>%si';
        preg_match_all($pat_form,$result,$arr);
        if(!empty($arr) && is_array($arr)) {
            $data =array_map(create_function('$a', 'return  preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($a));'), explode('</td>', $arr[0][2]));
            $purchase = $data[1];
            $selling = $data[3];
            return array('purchase' => $purchase, 'selling' => $selling);
        }
    }
    return false;
}









function getWphk($pjname = '人民币') {
	$result = requestGet('http://v.cne.hk/test.php?name='.$pjname);
	//$result = requestGet('http://d.cne.hk/test.php?name='.$pjname);
    if(!empty($result)) {
		$data = json_decode($result,true);
		return $data["data"];
	}
}

function getWphks($pjname = '人民币') {
	if($pjname == "英镑"){
		$pjname ="英镑/美元";
	}else if($pjname == "澳元"){
		$pjname ="澳元/美元";
	}else if($pjname == "纽元"){
		$pjname ="纽元/美元";
	}else{
		$pjname ="美元/".$pjname;
	}
	$result = requestGet('https://www.bochk.com/whk/rates/exchangeRatesUSD/exchangeRatesUSD-input.action?lang=cn');

    if(!empty($result)) {
        $pat_form='%<tr.*?>(.*?)</tr>%si';
        preg_match_all($pat_form,$result,$arr);
        $tr = explode('<tr>', $arr[0][2]);
        foreach ($tr as $value) {
            if(strpos($value,$pjname)){
                $td = explode('<td>', $value);
                $selling =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($td[2]));
                $purchase =preg_replace("/((\s)*(\n)+(\s)*)/i","", strip_tags($td[3]));
                return array('purchase' => $purchase, 'selling' => $selling);
            }
        }
    }
    return false;
}

?>