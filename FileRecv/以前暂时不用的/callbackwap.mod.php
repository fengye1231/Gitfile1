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
			$code = 'Parse_'.$status;
			
			method_exists($parserAPI, $code) || exit($this->Ends());
			$parserAPI->$code($payment);
		
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