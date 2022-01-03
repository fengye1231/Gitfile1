<?php

/**
 * 模块：wap-帐户充值
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name recharge.mod.php
 * @version 1.0
 */

class ModuleObject extends MasterObject
{
	function ModuleObject( $config )
	{
		$this->MasterObject($config);
		if (MEMBER_ID < 1)
		{
			$this->Messager(__('请先登录！'), '?mod=wap&code=login');
		}
		$yanzheng = logic('yanzheng')->GetOne(user()->get('id'));
       
		$runCode = Load::moduleCode($this);
		$this->$runCode();
	}
	public function main()

	{
		$aaa=user()->get('name');
		//var_dump($aaa);
        if(strpos($aaa,'@')!== FALSE){
			//var_dump('实名页面');
			$yanzheng = logic('yanzheng')->GetOne(user()->get('id'));
			include handler('template')->file('@wap/czwap');
        }
		else{
			//var_dump('匿名页面');
			$yanzheng=array('statue'=>2);
			include handler('template')->file('@wap/czwap_nm');
		}

	}
	public function order()
	{
		$id = $this->__orderid();
		$order = logic('recharge')->GetOne($id);
		if (!$order)
		{
			$this->Messager('订单编号无效！', -1);
		}
		logic('order')->changeZaitu();



		$aaa=user()->get('name');
		//var_dump($aaa);
		if(strpos($aaa,'@')!== FALSE){
			//var_dump('实名页面');
			include handler('template')->file('@wap/cz_order');
		}
		else{
			//var_dump('匿名页面');
			include handler('template')->file('@wap/cz_order_nm');
		}


	}
	public function order_save()
	{
		$money = round((float)post('money'), 2);
		if (!$money || $money <= 0)
		{
			$this->Messager('充值金额无效！', -1);
		}

		//这一句插入了数据库recharge_order
		$order = logic('recharge')->GetFree($money);
		logic('order')->changeZaitu();
		header('Location: '.rewrite('?mod=wapcz&code=order&id='.$order['orderid']));
	}
	public function getTongdao($no){
		//支付宝3
		//移动支付26
		//无卡支付32
		//网银支付29
		//无卡南雅43
		//网银南雅42
		//企业南雅44
		//迷你支付45
		//转账付款5
		//企业支付33
		//美元支付41
		//贝宝支付35
		//手机支付46
		//快捷支付47
		//扫码支付48
		//港币汇款49
		//欧元汇款50
		//微信支付51
		//日元汇款52
		//韩元汇款53
		//英镑汇款54
		//澳元汇款55
		//加元汇款56
		//瑞郎汇款57
		//新西兰元汇款58
		//新加坡元汇款59
		$tongdao = array(
			'3' =>	'支付宝',
			'26' =>	'移动支付',
			'32' =>	'无卡支付',
			'29' =>	'网银支付',
			'43' =>	'无卡南雅',
			'42' =>	'网银南雅',
			'44' =>	'企业南雅',
			'45' =>	'迷你支付',
			'5' =>	'转账付款',
			'33' =>	'企业支付',
			'41' =>	'美元支付',
			'35' =>	'贝宝支付',
			'46' =>	'手机支付',
			'47' =>	'快捷支付',
			'48' =>	'扫码支付',
			'49' =>	'港币汇款',
			'50' =>	'欧元汇款',
			'51' =>	'微信支付',
			'52' =>	'日元汇款',
			'53' =>	'韩元汇款',
			'54' =>	'英镑汇款',
			'55' =>	'澳元汇款',
			'56' =>	'加元汇款',
			'57' =>	'瑞郎汇款',
			'58' =>	'新西兰元汇款',
			'59' =>	'新加坡元汇款',
			'60' =>	'比特币汇款',
			'61' =>	'以太币汇款'

		);

		return $tongdao[$no];
	}
	public function payment_save()
	{
		$payment_id = post('payment_id');
		$id = $this->__orderid();
		$pid = post('payment_id', 'int');
		$test = logic('recharge')->GetOne($id);
		if (!$test)
		{
			$this->Messager('订单编号无效！', -1);
		}
		//给订单加支付通道
		$tongdao = 'wap'.$this->getTongdao($payment_id);


		logic('order')->InitTongdao($id,$tongdao);
		logic('recharge')->Update($id, array('payment'=>$pid));
		if($payment_id == '5'){
			logic('order')->upzaitu($id);
		}
		logic('order')->changeZaitu();
		header('Location: '.rewrite('?mod=wapcz&code=pay&payment_id='.$payment_id.'&id='.$id));
	}
	public function card_redirect()
	{
		$payment = logic('pay')->GetOne('recharge');
		if ($payment['enabled'] != 'true')
		{
			$this->Messager('本站没有开放充值卡功能，请返回使用其他支付方式！', -1);
		}
		$order = logic('recharge')->GetFree(0);
		logic('recharge')->Update($order['orderid'], array('payment'=>$payment['id']));
		header('Location: '.rewrite('?mod=recharge&code=pay&id='.$order['orderid']));
	}
	
	public function pay()
	{
		$id = $this->__orderid();
		$order = logic('recharge')->GetOne($id);
		if (!$order)
			$this->Messager('订单编号无效！', -1);
	
		if ($order['payment'] == 0)
			$this->Messager('请选择充值方式！', '?mod=wapcz&code=order&id='.$id);
		
		if ($order['paytime'] > 0 || $order['status'] != RECHARGE_STA_Blank)
			$this->Messager('此订单已经充值过了！', '?mod=me&code=wapbill');
		
		$pay = logic('pay')->GetOne($order['payment']);
		if (!$pay)
			$this->Messager('无效的充值方式！', -1);
		
		//移动支付26
		//无卡支付32
		//网银支付29
		//无卡南雅43
		//网银南雅42
		//企业南雅44
		//迷你支付45
		//转账付款5
		//企业支付33
		//美元支付41
		//贝宝支付35
		//手机支付46(34)
		//快捷支付47
		//微信支付49
		$parameter = array(
			'name' => '账户充值（'.$id.'）',
			'detail' => '充值：'.$order['money'].'元，充值编号：'.$id,
			'price' => $order['money'],
			'sign' => $order['orderid'],
			'notify_url' => ini('settings.site_url').'/index.php?mod=callback&pid='.$pay['id'],
			'product_url' => ini('settings.site_url').'/index.php?mod=me&code=wapbill'
		);
		
		if ($order['payment'] == 46 || $order['payment'] == 34)
			$parameter['notify_url'] = ini('settings.site_url').'/unionwap.php';

		if($order['payment'] == 47){
			//无跳转支付的已存在卡号
			$uid=$order['userid'];
			$sql='select * from `cardbind` where `uid`='.$uid;
			$rs=$this->DatabaseHandler->Query($sql);

			if(empty($rs)) $cards='';
			else{
				$temp_arr=array();
				while($row=$rs->GetRow()){
					$temp_arr[]=$row['cardno'];
				}
				$cards=implode(',',$temp_arr);
			}

			$parameter['cards']=$cards;
			//无跳转支付的回调
			//[2015-09-13]
			$parameter['notify_url']=ini('settings.site_url').'/index.php?mod=callback&code=wap&sign='.$order['orderid'].'&pid='.'&pid=47a123';
		}

		$pay = logic('pay')->Linker($pay, $parameter);
        if($order['payment'] == 46 || $order['payment'] == 34 || $order['payment'] ==47){
			$requrl=$pay['requrl'];
			$data=$pay['data'];
			$data=$this->post($requrl,$data);
			$payment_linker = $this->zfform($data, true);
		}
		else
		    $payment_linker = $pay;

		//var_dump($payment_linker);die;
		logic('order')->upzaitu($id);
		logic('order')->changeZaitu();


		$aaa=user()->get('name');
		//var_dump($aaa);

		if(strpos($aaa,'@')!== FALSE){
			//var_dump('实名页面');
			include handler('template')->file('@wap/cz_pay');
		}
		else{
			//var_dump('匿名页面');
			include handler('template')->file('@wap/cz_pay_nm');
		}

	}
	public function change_confrim(){
		$orderid = post('orderid');
		if(empty($orderid))exit('No Order Id');
		$result = logic('recharge')->change_confrim($orderid);
		return $result;
	}
	private function __orderid()
	{
		$id = get('id', 'number');
		if (!$id || strlen($id) != 13)
		{
			$this->Messager('请输入正确的订单编号！', -1);
		}
		return $id;
	}
	//签名相关函数
	function post($url, $post = null)
	{
				$context = array();

				if (is_array($post))
				{
					ksort($post);

					$context['http'] = array
					(
						'method' => 'POST',
						'content' => http_build_query($post, '', '&'),
					);
				}
				return file_get_contents($url,'r', stream_context_create($context));
		}
		function geturl($url)
		{
				$tmp = array();
				foreach($url as $k=>$param)
				{
					$tmp[$k] =$param;
				}
				$params = implode('&',$tmp);
				return $params;
		}
		function zfform($str, $isget = false){
				preg_match('!url<hi:=>(.*)<!U',$str,$url);
				$url= $url[1];
				preg_match('!method<hi:=>(.*)<!U',$str,$method);
				$method=$method['1'];
				preg_match('!sessionId<hi:=>(.*)!',$str,$se);
				$se='sessionId='.$se['1'];
				$see=explode('&',$se);
				$num=count($see);
				$se=array();
				if($isget === true) {
					$param = array();
					for($i=0;$i<$num;$i++){
						$tmp=explode('=',$see[$i]);
						$param[$tmp[0]] = $tmp[1];
					}

					$fr= '<form action="'.$url.'?'.http_build_query($param).'" method="'.$method.'">';
					$fr.= '<input class="bu" type="submit" value="确认支付" />
					</form>';
				}else{
					$fr= '<form action="'.$url.'" method="'.$method.'">';
					for($i=0;$i<$num;$i++){
						$tmp=explode('=',$see[$i]);
						$fr.= '<input type="hidden" name="'.$tmp[0].'" value="'.$tmp[1].'" />';
					}
					$fr.= '<input class="bu" type="submit" value="确认支付" />
					</form>';
				}
				return $fr;
			}
}

?>
