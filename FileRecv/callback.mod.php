<?php

/**
 * 模块：通知回调接口
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name callback.mod.php
 * @version 1.0
 */

class ModuleObject extends MasterObject
{
	function ModuleObject( $config )
	{
		$this->MasterObject($config);
		$runCode = Load::moduleCode($this);
		$this->$runCode();
	}
	function wap()
	{
	 	unset($_POST['mod']);
	 //	$_POST = unserialize('a:23:{s:10:"accessType";s:1:"0";s:7:"bizType";s:6:"000201";s:6:"certId";s:38:"21267647932558653966460913033289351200";s:12:"currencyCode";s:3:"156";s:8:"encoding";s:5:"utf-8";s:5:"merId";s:15:"802310048993437";s:7:"orderId";s:13:"3015052917459";s:7:"queryId";s:21:"201505291941374938918";s:11:"reqReserved";s:12:"透传信息";s:8:"respCode";s:2:"00";s:7:"respMsg";s:8:"Success!";s:9:"settleAmt";s:2:"10";s:18:"settleCurrencyCode";s:3:"156";s:10:"settleDate";s:4:"0529";s:10:"signMethod";s:2:"01";s:7:"traceNo";s:6:"493891";s:9:"traceTime";s:10:"0529194137";s:6:"txnAmt";s:2:"10";s:10:"txnSubType";s:2:"01";s:7:"txnTime";s:14:"20150529194137";s:7:"txnType";s:2:"01";s:7:"version";s:5:"5.0.0";s:9:"signature";s:344:"S1LStoCkRULJczQPUJIF29rLkRqL6dROOBzJV93cBYIov8jlKgJcWjAyh6HEk5v7U3krS8j0J6EPczF2myTOBUsp2xdcxICpCx6gkLlBnx+AzWOh/4L2yPR6hZFeVMY37WJIzdOgWjSihWGfcwZ0tfxJb1t7U5177BJdYiPSHOF7CGJ7wfubvVjF9O03AQztoJwQ7wb/4ysvFlOSazdqS7o2W3xxQnjkd9ogViU4Kh9PIOFSy5nKusFMaF4hsZuVyEl7Ar1NZMoPb0FFrl0HgrhBUz6fCi8Yp/zEk4NRjrXP0Kx9pANV3wDsWZaz6fbvsWrM23hl0rTCQWSGTR6z1A==";}');

	 	$pid = get('pid');
	 	$sign = get('sign');
	 	/*
	 	**[2015-08-30]
	 	*/
	 	$pos = strpos($pid,"a");
	 	if($pos){
			if($sign){
				logic('order')->EditFreezeMoney($sign);
			}
			//其他通道
			if($order_id){
				logic('order')->EditFreezeMoney($order_id);
			}
		}else{
			$payment = logic('pay')->GetOne($pid);

			$payment || exit($this->Ends());
			$status = logic('pay')->Verify($payment);

			$this->log_result("-----------------------------------------------");

			//$this->log_result(serialize($_POST));
			$this->log_result("-----------------------------------------------");

			//  $status || exit($this->Ends());
			logic('order')->EditFreezeMoney($_POST['orderId']);

			//var_dump(logic('pay')->TradeData($payment));
			$parserAPI = logic('callback')->Parser(logic('pay')->TradeData($payment));
			$parserAPI->MasterIframe($this);

			preg_match('/^[a-z_]+$/i', $status) || exit($this->Ends());
			$code = 'Parse_'.$status;

			method_exists($parserAPI, $code) || exit($this->Ends());
			$parserAPI->$code($payment);
		}

			 logic('order')->changeZaitu();
			 echo '<script>window.location="/index.php?mod=me&code=wapbill";</script>';
	}
	function Main()
	{
		$get_str = '';
		$post_str = '';
		foreach($_GET as $k=>$v){
			$get_str .= "get键=".$k." 值=".$v."|";
		}
		foreach($_POST as $m=>$n){
			$post_str .= "post键=".$m." 值=".$n."|";
		}
		$this->log_result(__CLASS__.'/'.__FUNCTION__);
		$this->log_result("参数是：".$get_str.$post_str);
		$this->log_result($_SERVER['QUERY_STRING']);
		$order_id = post('orderno');
		$order_id || $order_id = get('orderno');
		if($order_id){
			$order_id = preg_replace('/^0+/','',$order_id);
		}else{
			$order_id = post('orderId');
			$order_id || $order_id = get('orderId');
			$order_id = preg_replace('/^0+/','',$order_id);
		}


		$pid = get('pid');
		$pid || $pid = post('pid');
		$pos = strpos($pid,"a");

		$sign = get('sign');
		$sign || $sign = post('sign');
		//充值渠道
		//第四通道 和 其他通道
		//特殊处理转账通道
		if((get('HTTP_X_REQUESTED_WITH') == 'xmlhttprequest') && !$pos){
			logic('order')->EditFreezeMoney($sign);
		}

		if($pos){
			if($sign){
				logic('order')->EditFreezeMoney($sign);
			}
			//其他通道
			if($order_id){
				logic('order')->EditFreezeMoney($order_id);

			}
		}else{
			$this->log_result("-----------------------123------------------------");
			$this->log_result($_SERVER['QUERY_STRING']);
			$this->log_result("------------------------123-----------------------");
			$pid || exit($this->Ends());
			preg_match('/^[a-z0-9]+$/i', $pid) || exit($this->Ends());

			$payment = logic('pay')->GetOne($pid);
			$payment || exit($this->Ends());
			$status = logic('pay')->Verify($payment);
			$this->log_result("-----------------------------------------------");
			$this->log_result($_SERVER['QUERY_STRING']);
			$this->log_result($status);
			$this->log_result("-----------------------------------------------");
			$status || exit($this->Ends());
			//var_dump(logic('pay')->TradeData($payment));
			$parserAPI = logic('callback')->Parser(logic('pay')->TradeData($payment));
			$parserAPI->MasterIframe($this);

			preg_match('/^[a-z_]+$/i', $status) || exit($this->Ends());

            //var_dump("status=");
            //var_dump($status);


			$code = 'Parse_'.$status;
            //var_dump("code=");
            //var_dump($code);

			method_exists($parserAPI, $code) || exit($this->Ends());

            //var_dump("执行到了main函数倒数第二行");
			$parserAPI->$code($payment);
            //var_dump("执行到了main函数最后");

		}
		logic('order')->changeZaitu();
		//if(count($_COOKIE)>0)
		//{
			echo '<script>window.location="/index.php?mod=me&code=bill";</script>';
		//}
	}
	private function Ends()
	{
		echo '*^_^*';
	}
   public function  log_result($word) {
	$fp = fopen("logwap.txt","a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,$word."：执行日期：".strftime("%Y%m%d%H%I%S",time())."\t\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}
}

?>