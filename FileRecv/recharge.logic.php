<?php

/**
 * 逻辑区：充值相关
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package logic
 * @name recharge.logic.php
 * @version 1.2
 */
 
class RechargeLogic
{
	 
	 public function GetOne($id)
	 {
		$sql = '
		SELECT
			*
		FROM
			' . table('recharge_order') .'
		WHERE
			orderid = ' . $id;
		$order = dbc()->Query($sql)->GetRow();
		return $order;
	 }
	 
	 public function GetFree($money)
	 {
		$uid = user()->get('id');
		
        /*$order = $this->Where('money='.$money.' AND userid='.$uid.' AND status='.RECHARGE_STA_Blank);
		if ($order)
		{
			$order = $order[0];
		}
		else
		{
			$order = $this->__CreateNew($uid, $money);
		}*/

        $order = $this->__CreateNew($uid, $money);
		return $order;
	 }
	 
	public function Where($sql_limit)
	{
		$sql = '
		SELECT
			*
		FROM
			'.table('recharge_order').'
		WHERE
			'.$sql_limit.'
		';
		return dbc()->Query($sql)->GetAll();
	}
	
	private function __CreateNew($uid, $money)
	{
		$array = array(
			'orderid' => $this->__GetFreeID(),
			'userid' => $uid,
			'money' => $money, 
			'createtime' => time(),
			'status' => 255
		);
		dbc()->SetTable(table('recharge_order'));
		dbc()->Insert($array);
		return $array;
	}
	
	private function __GetFreeID()
	{
		$id = (date('Y', time())+1000) . date('md', time()) . str_pad(rand('1', '99999'), 5, '0', STR_PAD_LEFT);
		$sql = '
		SELECT
			*
		FROM
			' . table('recharge_order') . '
		WHERE
			orderid = ' . $id;
		$order = dbc()->Query($sql)->GetRow();
		if ( empty($order) )
		{
			return $id;
		}
		else
		{
			return $this->__GetFreeID();
		}
	}
	
	public function Update($id, $array)
	{
		dbc()->SetTable(table('recharge_order'));
		return dbc()->Update($array, 'orderid = '.$id);
	}
	
	public function ccOrder($orderid)
	{
		$order = $this->GetOne($orderid);
		$order['paytype'] = $order['payment'];
		$order['product']['type'] = 'ticket';
		return $order;
	}
	
	public function MakeSuccessed($orderid)
	{
		$order = $this->GetOne($orderid);
		if ($order['paytime'] > 0)
		{
			return;
		}

		$set = array(
			'paytime'	=> time(),
			'status'	=> RECHARGE_STA_Normal
		);

		$log = array(
                    'name' => '账户充值',
                    'intro' => '<b>充值流水号：</b>'.$orderid,
		);
		$is_dollar = (isset($order['tongdao']) && ($order['tongdao'] == '美元支付' || $order['tongdao'] == '贝宝支付' ||$order['tongdao'] == 'wap美元支付' || $order['tongdao'] == 'wap贝宝支付')) ? 1 :0;
		$is_hkdollar = (isset($order['tongdao']) && ($order['tongdao'] == '港币汇款' || $order['tongdao'] == 'wap港币汇款')) ? 1 :0;
		$is_euro = (isset($order['tongdao']) && ($order['tongdao'] == '欧元汇款'|| $order['tongdao'] == 'wap欧元汇款')) ? 1 :0;
		$is_jpy = (isset($order['tongdao']) && ($order['tongdao'] == '日元汇款' || $order['tongdao'] == 'wap日元汇款')) ? 1 :0;
		$is_krw = (isset($order['tongdao']) && ($order['tongdao'] == '韩元汇款' || $order['tongdao'] == 'wap韩元汇款')) ? 1 :0;
		$is_gbp = (isset($order['tongdao']) && ($order['tongdao'] == '英镑汇款' || $order['tongdao'] == 'wap英镑汇款')) ? 1 :0;
		$is_aud = (isset($order['tongdao']) && ($order['tongdao'] == '澳元汇款' || $order['tongdao'] == 'wap澳元汇款')) ? 1 :0;
		$is_cad = (isset($order['tongdao']) && ($order['tongdao'] == '加元汇款' || $order['tongdao'] == 'wap加元汇款')) ? 1 :0;
		$is_chf = (isset($order['tongdao']) && ($order['tongdao'] == '瑞郎汇款' || $order['tongdao'] == 'wap瑞郎汇款')) ? 1 :0;
		$is_nzd = (isset($order['tongdao']) && ($order['tongdao'] == '新西兰元汇款' || $order['tongdao'] == 'wap新西兰元汇款')) ? 1 :0;
		$is_sgd = (isset($order['tongdao']) && ($order['tongdao'] == '新加坡元汇款' || $order['tongdao'] == 'wap新加坡元汇款')) ? 1 :0;
		$is_hkc = (isset($order['tongdao']) && ($order['tongdao'] == '香港币汇款' || $order['tongdao'] == 'wap香港币汇款')) ? 1 :0;
		$is_btc = (isset($order['tongdao']) && ($order['tongdao'] == '比特币汇款' || $order['tongdao'] == 'wap比特币汇款')) ? 1 :0;
		$is_eth = (isset($order['tongdao']) && ($order['tongdao'] == '以太币汇款' || $order['tongdao'] == 'wap以太币汇款')) ? 1 :0;
		$is_money = (isset($order['tongdao']) && ($order['tongdao'] == '人民币汇款' || $order['tongdao'] == 'wap人民币汇款')) ? 1 :0;
        $log['is_dollar'] = $is_dollar;
		$log['is_hkdollar'] = $is_hkdollar;
		$log['is_euro'] = $is_euro;
		$log['is_jpy'] = $is_jpy;
		$log['is_krw'] = $is_krw;
		$log['is_gbp'] = $is_gbp;
		$log['is_aud'] = $is_aud;
		$log['is_cad'] = $is_cad;
		$log['is_chf'] = $is_chf;
		$log['is_nzd'] = $is_nzd;
		$log['is_sgd'] = $is_sgd;
		$log['is_hkc'] = $is_hkc;
		$log['is_btc'] = $is_btc;
		$log['is_eth'] = $is_eth;
		$log['is_money'] = $is_money;
		$typedollar=0;
		if($is_dollar==1){
			$typedollar=1;
		}elseif ($is_hkdollar==1){
			$typedollar=2;
		}elseif ($is_euro==1){
			$typedollar=3;
		}elseif ($is_jpy==1){
			$typedollar=4;
		}elseif ($is_krw==1){
			$typedollar=5;
		}elseif ($is_gbp==1){
			$typedollar=6;
		}elseif ($is_aud==1){
			$typedollar=7;
		}elseif ($is_cad==1){
			$typedollar=8;
		}elseif ($is_chf==1){
			$typedollar=9;
		}elseif ($is_nzd==1){
			$typedollar=10;
		}elseif ($is_sgd==1){
			$typedollar=11;
		}elseif ($is_hkc==1){
			$typedollar=12;
		}elseif ($is_btc==1){
			$typedollar=13;
		}elseif ($is_eth==1){
			$typedollar=14;
		}elseif ($is_money==1){
			$typedollar=15;
			}
		if($is_dollar == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate = ($order['tongdao'] == '美元支付' || $order['tongdao'] == 'wap美元支付') ? $yanzheng['dollar_rate'] : $yanzheng['paypal_rate'];
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money']; 
			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：USD</b>".$money."元<br/><b>手续费：</b>USD".$sxf.'元<br/><b>实际到帐金额：<b>USD'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_hkdollar == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =  $yanzheng['hkdollar_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				  if ($rate>0){
					  $sxf = max($rate,0.01);
					  $sxf = number_format(round($sxf, 2), 2, '.', '');
				  }

					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：HKD</b>".$money."元<br/><b>手续费：</b>HKD".$sxf.'元<br/><b>实际到帐金额：</b>HKD'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_euro == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['euro_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：EUR</b>".$money."元<br/><b>手续费：</b>EUR".$sxf.'元<br/><b>实际到帐金额：</b>EUR'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_jpy == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['jpy_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：JPY</b>".$money."元<br/><b>手续费：</b>JPY".$sxf.'元<br/><b>实际到帐金额：</b>JPY'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_krw == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['krw_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：KRW</b>".$money."元<br/><b>手续费：</b>KRW".$sxf.'元<br/><b>实际到帐金额：</b>KRW'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_gbp == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['gbp_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：GBP</b>".$money."元<br/><b>手续费：</b>GBP".$sxf.'元<br/><b>实际到帐金额：</b>GBP'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_aud == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['aud_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：AUD</b>".$money."元<br/><b>手续费：</b>AUD".$sxf.'元<br/><b>实际到帐金额：</b>AUD'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_cad == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['cad_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：CAD</b>".$money."元<br/><b>手续费：</b>CAD".$sxf.'元<br/><b>实际到帐金额：</b>CAD'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_chf == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['chf_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：CHF</b>".$money."元<br/><b>手续费：</b>CHF".$sxf.'元<br/><b>实际到帐金额：</b>CHF'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_nzd == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['nzd_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：NZD</b>".$money."元<br/><b>手续费：</b>NZD".$sxf.'元<br/><b>实际到帐金额：</b>NZD'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_sgd == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['sgd_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：SGD</b>".$money."元<br/><b>手续费：</b>SGD".$sxf.'元<br/><b>实际到帐金额：</b>SGD'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_hkc == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['hkc_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：HKC</b>".$money."元<br/><b>手续费：</b>HKC".$sxf.'元<br/><b>实际到帐金额：</b>HKC'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_btc == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['btc_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：BTC</b>".$money."元<br/><b>手续费：</b>BTC".$sxf.'元<br/><b>实际到帐金额：</b>BTC'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_eth == 1) {
			$yanzheng = logic('yanzheng')->GetOne($order['userid']);
			$rate =   $yanzheng['eth_rate'] ;
			$sxf = 0.00;
			$sjje = $order['money'];
			$money = $order['money'];

			if(!empty($rate)) {
				if ($rate>0){
					$sxf = max($rate,0.01);
					$sxf = number_format(round($sxf, 2), 2, '.', '');
				}
					$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
					if($order['money'] < 0) {
						$order['money'] = 0;
					}
			}
			$log['intro'] .= "<br/><b>金额：ETH</b>".$money."元<br/><b>手续费：</b>ETH".$sxf.'元<br/><b>实际到帐金额：</b>ETH'.$order['money'].'元';
			$set['sxfl'] = $rate;
			$set['sxf'] = $sxf;
			$set['sjje'] = $order['money'];
		
		}
		if($is_money == 1) {
				$yanzheng = logic('yanzheng')->GetOne($order['userid']);
				$rate =   $yanzheng['money_rate'] ;
				$sxf = 0.00;
				$sjje = $order['money'];
				$money = $order['money'];
	
				if(!empty($rate)) {
					if ($rate>0){
						$sxf = max($rate,0.01);
						$sxf = number_format(round($sxf, 2), 2, '.', '');
					}
						$order['money'] = number_format(($order['money'] - $sxf), 2, '.', '');
						if($order['money'] < 0) {
							$order['money'] = 0;
						}
				}
				$log['intro'] .= "<br/><b>金额：CNY</b>".$money."元<br/><b>手续费：</b>CNY".$sxf.'元<br/><b>实际到帐金额：</b>CNY'.$order['money'].'元';
				$set['sxfl'] = $rate;
				$set['sxf'] = $sxf;
				$set['sjje'] = $order['money'];
			
		}
		dbc(DBCMax)->update('recharge_order')->data($set)->where('orderid='.$orderid)->done();
		logic('me')->money()->add($order['money'], $order['userid'], $log, $typedollar);
	}
	
	public function Clean()
	{
				$timeOld = time() - 86400;
		return dbc(DBCMax)->delete('recharge_order')->where('status='.RECHARGE_STA_Blank.' AND paytime=0 AND createtime<='.$timeOld)->done();
	}
	
	public function card()
	{
		return loadInstance('logic.recharge.card', 'card_RechargeLogic');
	}
	
	public function forder()
	{
		return loadInstance('logic.recharge.forder', 'forder_RechargeLogic');
	}

    public function change_confrim($orderid) {
        $sql ='UPDATE ' . table('recharge_order').' SET is_confrim = 1 WHERE orderid = ' . $orderid;
        $query = dbc(DBCMax)->query($sql)->done();
        return $query; 
    }
}


class card_RechargeLogic
{
	public function ifo($no)
	{
		return dbc(DBCMax)->select('recharge_card')->where('number='.$no)->limit(1)->done();
	}
	public function MakeUsed($number, $password)
	{
		return dbc(DBCMax)->update('recharge_card')->data(array('usetime'=>time(),'uid'=>user()->get('id')))->where(array('number'=>$number,'password'=>$password))->done();
	}
	
	public function GetList($used = -1)
	{
		$used < 0 && $sql_used = '1';
		$used > 0 && $sql_used = 'usetime > 0';
		$used == 0 && $sql_used = 'usetime = 0';
		$sql = 'SELECT * FROM '.table('recharge_card').' WHERE '.$sql_used.' ORDER BY id DESC';
		logic('isearcher')->Linker($sql);
		$sql = page_moyo($sql);
		$query = dbc()->Query($sql);
		return $query ? $query->GetAll() : array();
	}
	public function Generate($price = 10, $nums = 1)
	{
		$price = (float)$price;
		$nums = (int)$nums;
		if ($price <= 0 || $nums <= 0) return;
		for ($i=0; $i < $nums; $i++)
		{
			dbc(DBCMax)->insert('recharge_card')->data(array(
				'number' => $this->__random_num(12),
				'password' => $this->__random_num(6),
				'price' => $price
			))->done();
		}
	}
	public function Delete($id)
	{
		return dbc(DBCMax)->delete('recharge_card')->where('id='.$id)->done();
	}
	
	public function __random_num($length = 12)
	{
		$length = (int)$length;
		$loops = ceil($length / 3);
		$string = '';
		for ( $i=0; $i<$loops; $i++ )
		{
			$string .= (string)mt_rand(100, 999);
		}
		$string = substr($string, 0, $length);
		return $string;
	}
}


class forder_RechargeLogic
{
	
	public function paid($trade, $order = array(), $money = 0.00, $dsp = true)
	{
		if (is_numeric($trade))
		{
						$rcgOrder = logic('recharge')->GetOne($trade);
			if ((int)$rcgOrder['status'] > 0 && $rcgOrder['paytime'] > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
				$money = (float)$money;
		if ($money <= 0)
		{
						return $this->result(true, $money);
		}
		$userID = $order['userid'];
		$rcgID = $order['orderid'];
		$rcgOrder = logic('recharge')->GetOne($rcgID);
		if ((int)$rcgOrder['status'] > 0 && $rcgOrder['paytime'] > 0)
		{
			return $this->result(false, $money);
		}
		else
		{
			if ((int)$rcgOrder['status'] == 0)
			{
				$roid = dbc(DBCMax)->insert('recharge_order')->data(array(
					'orderid' => $rcgID,
					'userid' => $userID,
					'money' => $money,
					'createtime' => time(),
					'payment' => $order['paytype'],
					'paytime' => time(),
					'status' => RECHARGE_STA_Normal
				))->done();
				if (false === $roid)
				{
					return $this->result(false, $money);
				}
				$extendMsg = '';
				if (isset($trade['money_reason']) && strlen($trade['money_reason']) > 0)
				{
					$dsp = true;
					$extendMsg = '（'.$trade['money_reason'].'）';
				}	if ($dsp)
				{
					$sql ='UPDATE ' . table('members').' SET money = money + ' . $money . ' WHERE uid = ' . $userID;
				
		            $query = dbc(DBCMax)->query($sql)->done();
				}else 
				{
				logic('me')->money()->add($money, $userID, $dsp ? array(
					'name' => __('账户充值'),
					'intro' => sprintf(__('订单号：%s<br/>交易单号：%s ; %s'), $rcgID, $trade['trade_no'], $extendMsg)
				) : array());
				}
			}
			return $this->result(true, $money);
		}
		return $this->result(false, $money);
	}
	
	private function result($paid, $money)
	{
		return array(
			'paid' => $paid,
			'money' => round($money, 2)
		);
	}
}

?>