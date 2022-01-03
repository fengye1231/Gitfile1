<?php
/**
 * 逻辑区：订单管理
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package logic
 * @name order.logic.php
 * @version 1.1
 */

class OrderLogic
{

	public function GetFree($uid = 0, $product_id = 0,$sellerid=0)
	{
		if ($uid == 0)
		{
			$uid = user()->get('id');
		}


		if ($sellerid == 0)
		{
			return false;
		}


		if ($product_id == 0)
		{
			return false;
		}
		$order = $this->Where('userid='.$uid.' AND status=255');
		if ($order)
		{
			$order = $order[0];
		}
		else
		{
			$order = $this->__CreateNew($uid, $product_id,$sellerid);
		}
		return $order;
	}
	public function upzaitu($order_id){
		$sql = 'update '.table('recharge_order').' set statue=5 where orderid='.$order_id;
		$data=dbc()->query($sql);
	}
	//public function EditMoneyNozai($order_id){
	//	$sql = 'update '.table('recharge_order').' set statue=2,paytime=\''.time().'\' where orderid='.$order_id;
	//	$data=dbc()->query($sql);
	//}
	//所有有到账时间的订单设为非在途
	public function changeZaitu(){
		$sql = 'update '.table('recharge_order').' set status=1,statue=2 where paytime!=0';
		$data=dbc()->query($sql);
	}
	public function InitTongdao($order_id,$tongdao){
		$sql = 'update '.table('recharge_order').' set tongdao=\''.$tongdao.'\' where orderid='.$order_id;
		$data=dbc()->query($sql);
	}
	/*修改为在途资金*/
	public function EditFreezeMoney($order_id){
		$sql = 'update '.table('recharge_order').' set statue=1,payment=5 where  orderid='.$order_id;
		$data=dbc()->query($sql);
	}

	/*获取在途资金*/
	/*
    * $is_dollar == '' //获取所有在途资金
    * $is_dollar == 0 //只获取人民币
    * $is_dollar == 1 //只获取美元
    * $is_dollar == 2 //只获取港币
    * $is_dollar == 3 //只获取欧元
    * $is_dollar == 4 //只获取日元
    * $is_dollar == 5 //只获取韩元
    * $is_dollar == 6 //只获取英镑
    * $is_dollar == 7 //只获取澳元
    * $is_dollar == 8 //只获取加元
    * $is_dollar == 9 //只获取瑞郎
    * $is_dollar == 10 //只获取新西兰元
    * $is_dollar == 11 //只获取新加坡元
	* $is_dollar == 12 //只获取香港币
	* $is_dollar == 13 //只获取比特币
	* $is_dollar == 14 //只获取以太币
    */
	public function GetFreezeMoney($uid=0, $is_dollar = '')
	{
		if($uid==0)
		{
			$uid=user()->get('id');
		}
		$sql='select sum(money) as money from '.table('recharge_order').' where userid='.$uid.' and status=255 and payment=5 and statue=1';
		if($is_dollar !== '') {
			if($is_dollar === 0) {
				$sql .= " and ((tongdao like '%转账付款' and is_confrim =  1) or tongdao like '%扫码支付'  or tongdao like  '%微信支付')";
			}else if($is_dollar == 1){
				$sql .= " and ((tongdao like '%美元支付' and is_confrim = 1) or tongdao like '%贝宝支付' )";
			}else if($is_dollar == 2){
				$sql .= " and tongdao like '%港币汇款' and is_confrim = 1";
			}else if($is_dollar == 3){
				$sql .= " and tongdao like '%欧元汇款' and is_confrim = 1";
			}else if($is_dollar == 4){
				$sql .= " and tongdao like '%日元汇款' and is_confrim = 1";
			}else if($is_dollar == 5){
				$sql .= " and tongdao like '%韩元汇款'  and is_confrim = 1";
			}else if($is_dollar == 6){
				$sql .= " and tongdao like '%英镑汇款'  and is_confrim = 1";
			}else if($is_dollar == 7){
				$sql .= " and tongdao like '%澳元汇款' and is_confrim = 1";
			}else if($is_dollar == 8){
				$sql .= " and tongdao like '%加元汇款'  and is_confrim = 1";
			}else if($is_dollar == 9){
				$sql .= " and tongdao like '%瑞郎汇款'  and is_confrim = 1";
			}else if($is_dollar == 10){
				$sql .= " and tongdao like '%新西兰元汇款'   and is_confrim = 1";
			}else if($is_dollar == 11){
				$sql .= " and tongdao like '%新加坡元汇款' and is_confrim = 1";
			}else if($is_dollar == 12){
				$sql .= " and tongdao like '%香港币汇款' and is_confrim = 1";
			}else if($is_dollar == 13){
				$sql .= " and tongdao like '%比特币汇款' and is_confrim = 1";
			}else if($is_dollar == 14){
				$sql .= " and tongdao like '%以太币汇款' and is_confrim = 1";
			}
		}
		$data=dbc(DBCMax)->query($sql)->limit(1)->done();
		// if($is_dollar !== '') {
		//    if($is_dollar === 0) {
		//      $sql = 'select sum(money) as money from '.table('recharge_order').' where userid='.$uid.' and status=255 and payment=5 and statue=1 and tongdao = "转账付款" and is_confrim = 0';
		//    $data2=dbc(DBCMax)->query($sql)->limit(1)->done();
		//  if($data2['money'] && $data2['money'] != '0.00'){
		//    $data['money'] = number_format($data['money'], 2, '.', '') - number_format($data2['money'], 2, '.',  '');
		//}
		//}
		//}
		;
		return $data['money'] ? number_format($data['money'],2,'.', '') : '0.00';
	}

	private function __CreateNew($uid, $product_id,$sellerid)
	{
		$array = array(
			'orderid' => $this->__GetFreeID(),
			'productid' => $product_id,
			'userid' => $uid,
			'buytime' => time(),
			'status' => 255,
			'sellerid'=>$sellerid

		);
		dbc()->SetTable(table('order'));
		dbc()->Insert($array);
		return $array;
	}

	private function __GetFreeID()
	{
		$id = date('Ymd', time()) . str_pad(rand('1', '99999'), 5, '0', STR_PAD_LEFT);
		$sql = '
		SELECT
			*
		FROM
			' . table('order') . '
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

	public function GetOne( $id, $uid = 0 )
	{
		$sql_limit_user = '1';
		if ($uid > 0)
		{
			$sql_limit_user = 'userid = '.$uid;
		}
		$sql = 'SELECT *
		FROM
			' . table('order') .'
		WHERE
			orderid = ' . $id . '
		AND
			' . $sql_limit_user;
		return $this->__parse_result(dbc(DBCMax)->query($sql)->limit(1)->done());
	}

	public function GetList( $uid = 0, $status = ORD_STA_ANY, $pay = ORD_PAID_ANY, $extend = '1' )
	{
		$sql_limit_user = '1';
		if ($uid > 0)
		{
			$sql_limit_user = 'userid = '.$uid;
		}
		$sql_limit_status = '1';
		if ( $status >= 0 )
		{
			$sql_limit_status =  'status = '.$status;
		}
		$sql_limit_pay = '1';
		if ( $pay >= 0 )
		{
			$sql_limit_pay = 'pay = '.$pay;
		}
		$sql = 'SELECT o.*, m.username
		FROM
			' . table('order') .' o
		LEFT JOIN
			' .table('members'). ' m
		ON
			(o.userid=m.uid)
		WHERE
			'.$sql_limit_user.'
		AND
			'.$sql_limit_status.'
		AND
			'.$sql_limit_pay.'
		AND
			'.$extend.'
		ORDER BY
			buytime
		DESC';
		logic('isearcher')->Linker($sql);
		$sql = page_moyo($sql);
		$order = dbc(DBCMax)->query($sql)->done();

		return $this->__parse_result($order);
	}


	public function GetList1( $uid = 0, $status = ORD_STA_ANY, $pay = ORD_PAID_ANY, $extend = '1' )
	{
		$sql_limit_user = '1';
		if ($uid > 0)
		{
			$sql_limit_user = 'sellerid = '.$uid;
		}
		$sql_limit_status = '1';
		if ( $status >= 0 )
		{
			$sql_limit_status =  'status = '.$status;
		}
		$sql_limit_pay = '1';
		if ( $pay >= 0 )
		{
			$sql_limit_pay = 'pay = '.$pay;
		}
		$sql = 'SELECT o.*, m.username
		FROM
			' . table('order') .' o
		LEFT JOIN
			' .table('members'). ' m
		ON
			(o.sellerid=m.uid)
		WHERE
			'.$sql_limit_user.'
		AND
			'.$sql_limit_status.'
		AND
			'.$sql_limit_pay.'
		AND
			'.$extend.'
		ORDER BY
			buytime
		DESC';
		logic('isearcher')->Linker($sql);
		$sql = page_moyo($sql);
		$order = dbc(DBCMax)->query($sql)->done();
		return $this->__parse_result($order);
	}




	public function SrcOne($id)
	{
		$sql = 'SELECT * FROM '.table('order').' WHERE orderid='.$id;
		return dbc()->Query($sql)->GetRow();
	}

	public function SrcList( $uid = USR_ANY, $status = ORD_STA_ANY, $pay = ORD_PAID_ANY, $extend = '1' )
	{
		$sql_limit_user = '1';
		if ($uid > 0)
		{
			$sql_limit_user = 'userid = '.$uid;
		}
		$sql_limit_status = '1';
		if ( $status >= 0 )
		{
			$sql_limit_status =  'status = '.$status;
		}
		$sql_limit_pay = '1';
		if ( $pay >= 0 )
		{
			$sql_limit_pay = 'pay = '.$pay;
		}
		$sql = '
		SELECT
			*
		FROM
			' . table('order') .'
		WHERE
			'.$sql_limit_user.'
		AND
			'.$sql_limit_status.'
		AND
			'.$sql_limit_pay.'
		AND
			'.$extend.'
		ORDER BY
			buytime
		DESC';
		$order = dbc()->Query($sql)->GetAll();
		return $order;
	}

	public function Where($sql_limit)
	{
		$sql = '
		SELECT
			*
		FROM
			'.table('order').'
		WHERE
			'.$sql_limit.'
		';
		return dbc()->Query($sql)->GetAll();
	}

	public function Update($id, $array)
	{
		dbc()->SetTable(table('order'));
		dbc()->Update($array, 'orderid = '.$id);
	}

	public function Delete($id)
	{
		$sqls = array();
		$sqls[] = 'DELETE FROM '.table('order').' WHERE orderid='.$id;
		$sqls[] = 'DELETE FROM '.table('order_clog').' WHERE sign='.$id;
		$sqls[] = 'DELETE FROM '.table('paylog').' WHERE sign='.$id;
		$sqls[] = 'DELETE FROM '.table('ticket').' WHERE orderid='.$id;
		foreach ($sqls as $i => $sql)
		{
			dbc()->Query($sql);
		}
		return true;
	}

	public function Count($where)
	{
		$sql = 'SELECT COUNT(1) AS CNT FROM '.table('order').' WHERE '.$where;
		$result = dbc()->Query($sql)->GetRow();
		return $result['CNT'];
	}

	public function Summary($where)
	{
		$sql = 'SELECT SUM(productprice*productnum)+expressprice as TTL FROM '.table('order').' WHERE '.$where;
		$result = dbc(DBCMax)->query($sql)->limit(1)->done();
		return $result['TTL'] ? $result['TTL'] : 0;
	}

	public function _TMP_Payed($trade)
	{
		$id = $trade['sign'];
		$order = $this->GetOne($id);
		if ($order['pay'] == ORD_PAID_No)
		{
			$product = logic('product')->BuysCheck($order['productid'], false, $order['productnum'], ORD_PAID_No);
			$error = false;
			isset($product['false']) && $error = $product['false'];

			if ($trade['money'] > 0)
			{
				$rcgPrice = $trade['price'];
				$rcgDSP = true;
			}
			else
			{
				if (!$trade['nmadd'])
				{
					$rcgPrice = $trade['price'];
					$rcgDSP = false;
				}
			}
			$order['_tmpd_'] = logic('recharge')->forder()->paid($trade, $order, $rcgPrice, $rcgDSP);
			if (!$trade['nmpay'])
			{
				//$money = round(logic('me')->money()->count($order['userid']), 2);
				$money = round(logic('me')->money()->count_hkc($order['userid']), 2);

				$price = round($order['productprice']*$order['productnum']+$order['expressprice'], 2);
				if ($error)
				{

				}
				else
				{
					if ($order['_tmpd_']['paid'] === false)
					{
						$error = '订单支付失败，也许您之前已经支付过此订单了！';
					}
					elseif ($order['status'] != ORD_STA_Normal)
					{
						$error = '订单状态非正常，已经无法支付！';
					}
					elseif ($money >= $price)
					{
						$express = '';
						if ($order['expressprice'] > 0)
						{
							$express = sprintf(__('运费：%.2f'), $order['expressprice']);
						}
						if ($product['type']=="ticket")
						{


							//2021-11-24 自己修改
							$namem = "购买团购券";

							if($order['product']['flag']=='BTC' or  $order['product']['flag']=='btc')
							{
								$namem="购买BTC";
							}elseif ($order['product']['flag']=='ETH' or  $order['product']['flag']=='eth')
							{
								$namem="购买ETH";
							}

								/*
							if ($order['productid']==336){
								$namem="购买BTC";
							}
							if ($order['productid']==337){
								$namem="购买ETH";
							}
								*/

						}else {
							$namem = "购买实物商品";
						}


						$order = logic('order')->GetOne($id);

						$price = $order['totalprice'];

						$pid = $order['productid'];

						$product = logic('product')->GetOne($pid);

						$sellerid = $product['sellerid'];

						$seller = logic('seller')->GetOne($sellerid);
						//修改开始
						$uid = $seller['userid'];

						logic('me')->money()->pay($price, $order['userid'], array(//减少用户钱，并且记录日志
							'name' => $namem,
							'intro' => sprintf(__('商品名：%s<br/>卖家：%s<br/>单价：%.2f<br/>数目：%d<br/>%s'), $order['product']['flag'],user($uid)->get("name"), $order['productprice'], $order['productnum'], $express),
							'is_hkc'=>1
						));



						if($order['product']['flag']=='BTC' or  $order['product']['flag']=='btc')
						{
							logic('me')->money()->add($order['productnum'], $order['userid'], array(),$is_dollar=13);
						}elseif ($order['product']['flag']=='ETH' or  $order['product']['flag']=='eth')
						{
							logic('me')->money()->add($order['productnum'], $order['userid'], array(),$is_dollar=14);
						}


/*
						if ($pid==336){
							logic('me')->money()->add(1, $order['userid'], array(),$is_dollar=13);
						}elseif ($pid==337){
							logic('me')->money()->add(1, $order['userid'], array(),$is_dollar=14);
						}
*/


						$order_update = array(
							'pay' => ORD_PAID_Yes,
							'paytime' => time()
						);
						$this->Update($id, $order_update);
						logic('order')->doSuccess($order);
						if (in_array($order['process'], array('__CREATE__', 'WAIT_BUYER_PAY')))
						{
							$this->Processed($order['orderid'], '__PAY_YET__');
							logic('order')->clog($trade['sign'])->sys('订单支付系统：用户已付款');
						}
					}
					else
					{
						$error = '账户余额不足以支付此订单，请充值后重新支付或者选择重新下单！（本次支付金额已充值到您的个人账户）';
					}
				}
			}
		}
		$error && $order['false'] = $error;
		return $order;
	}

	public function Processed($orderid, $process)
	{
		$this->Update($orderid, array('process' => $process));
		if($process=="TRADE_FINISHED")
		{
			//修改开始

			$id = $orderid;
			$order = logic('order')->GetOne($id);

			$price = $order['totalprice'];

			$pid = $order['productid'];

			$product = logic('product')->GetOne($pid);
			if($product['type'] == 'ticket' || $product['type'] == 'stuff')
			{
				$sellerid = $product['sellerid'];
				$seller = logic('seller')->GetOne($sellerid);
				$uid = $seller['userid'];

				$name2 = $product['type'] == 'ticket' ? 'djq': 'cp';


				if(($order['product']['flag']=='BTC' or  $order['product']['flag']=='btc') and $name2=='djq')
				{
					logic('me')->money()->less($order['productnum'], $uid,array(),$is_dollar=13);
					$name2='卖出BTC';

				}elseif (($order['product']['flag']=='ETH' or  $order['product']['flag']=='eth') and $name2=='djq')
				{
					logic('me')->money()->less($order['productnum'], $uid,array(),$is_dollar=14);
					$name2='卖出ETH';
				}

				logic('me')->money()->add($price, $uid, array('name' => $name2,'intro' => $id,'is_hkc'=>1),$is_dollar=12);
/*
				if ($pid==336){
					logic('me')->money()->less(1, $uid,array(),$is_dollar=13);
				}elseif ($pid==337){
					logic('me')->money()->less(1, $uid,array(),$is_dollar=14);

				}
*/


			}else{
				$sellerid = $product['sellerid'];

				$seller = logic('seller')->GetOne($sellerid);
				//修改开始
				$uid = $seller['userid'];
//		$this->DatabaseHandler->SetTable(TABLE_PREFIX . 'system_members');
//		
//		$this->DatabaseHandler->Query("  update  ".TABLE_PREFIX . 'system_members'." set money = money+ $price where uid = '$uid'  ");
				$sql = 'SELECT *
		FROM
			' . table('usermoney') . '
		WHERE
			userid = ' . $uid . '
		AND
		   name="cp" and intro = "'.$id.'" 
		';

				$test =  dbc()->Query($sql)->GetAll();
				if ($test)
				{

				}else {
					//dbc()->Query("  update  ".TABLE_PREFIX . 'system_members'." set money = money+ $price where uid = '$uid'  ");
					//先不要加钱，把订单置为在途
					//$this->EditFreezeMoney($orderid);
					//logic('me')->money()->add($price, $uid, array(
					//				'name' => 'cp',
					//				'intro' => $id
					//			));
					//修改结束
				}
			}
		}
	}

	public function MakeSuccessed($orderid, $ignore_rules = false)
	{
		$order = $this->GetOne($orderid);
		$product = logic('product')->BuysCheck($order['productid'], false, $order['productnum'], ORD_PAID_Yes);
		if (isset($product['false']))
		{
			$order['false'] = $product['false'];
			return $order;
		}
		if (false == $ignore_rules)
		{
			logic('product')->Maintain($order['productid']);
			return $order;
		}
		if ($order['product']['type'] == 'ticket')
		{
			$tickets = logic('coupon')->GetList($order['userid'], $order['orderid'], TICK_STA_ANY);
			if (count($tickets) > 0)
			{
			}
			else
			{
				if ($order['product']['allinone'] == 'true')
				{
					logic('coupon')->Create($order['productid'], $order['orderid'], $order['userid'], $order['productnum']);
				}
				else
				{
					for ($i=0; $i<$order['productnum']; $i++)
					{
						logic('coupon')->Create($order['productid'], $order['orderid'], $order['userid']);
					}
				}
			}
			logic('order')->Processed($order['orderid'], 'TRADE_FINISHED');
			logic('order')->clog($orderid)->sys('团购券已经生成：交易完成');
		}
		else
		{
			logic('order')->Processed($order['orderid'], 'WAIT_SELLER_SEND_GOODS');
			logic('order')->clog($orderid)->sys('用户已经下单：等待发货');
		}
		$this->doRelSuccess($order);
		$MID = 'notify_YET_'.$orderid;
		if (meta($MID))
		{
			meta($MID, null);
			return $order;
		}
		logic('notify')->Call($order['userid'], 'logic.order.MakeSuccessed', array(
			'orderid' => $order['orderid'],
			'productflag' => $order['product']['flag'],
			'productnum' => $order['productnum'],
			'productprice' => $order['productprice'],
			'buytime' => $order['buytime'],
			'paymoney' => $order['paymoney'],
			'paytime' => $order['paytime'],
			'expressprice' => $order['expressprice'],
			'extmsg' => $order['extmsg']
		));
		meta($MID, time(), 'd:30');
		return $order;
	}

	public function findSuccess($pid)
	{
		$process_search = 'productid = '.$pid.' AND process = "__PAY_YET__"';
		$order_list = logic('order')->SrcList(USR_ANY, ORD_STA_Normal, ORD_PAID_Yes, $process_search);
		if (count($order_list) > 0)
		{
			foreach ($order_list as $i => $order_one)
			{
				logic('order')->MakeSuccessed($order_one['orderid'], true);
			}
		}
	}

	private function __parse_result($data)
	{
		if ( ! $data ) return false;
		if ( is_array($data[0]) )
		{
			$return = array();
			foreach ( $data as $i => $one )
			{
				$return[] = $this->__parse_result($one);
			}
			return $return;
		}
		$data['product'] = logic('product')->GetOne($data['productid']);
		return $data;
	}


	private function __parse_result1($data)
	{
		if ( ! $data ) return false;
		if ( is_array($data[0]) )
		{
			$return = array();
			foreach ( $data as $i => $one )
			{
				$return[] = $this->__parse_result($one);
			}
			return $return;
		}
		$data['product1'] = logic('product')->GetOne($data['productid']);
		return $data;
	}





	public function STA_Name($STA_Code)
	{
		$STA_NAME_MAP = array(
			ORD_STA_ANY => '任意状态',
			ORD_STA_Cancel => '已经取消',
			ORD_STA_Failed => '订单失败',
			ORD_STA_Normal => '订单正常',
			ORD_STA_Overdue => '已经过期',
			ORD_STA_Refund => '已经返款'
		);
		return $STA_NAME_MAP[$STA_Code];
	}

	public function PROC_Name($PRO_Code)
	{
		$PROC_NAME_MAP = array(
			'*' => '任意进程',
			'__CREATE__' => '创建订单',
			'__PAY_YET__' => '已经付款',
			'WAIT_BUYER_PAY' => '等待付款',
			'WAIT_SELLER_SEND_GOODS' => '等待发货',
			'WAIT_BUYER_CONFIRM_GOODS' => '等待收货',
			'TRADE_FINISHED' => '交易完成'
		);
		$POCN = $PROC_NAME_MAP[$PRO_Code];
		return $POCN ? $POCN : $PRO_Code;
	}

	public function clog($oid)
	{
		$obj = loadInstance('logic.order.clog', 'OrderLogic_cLog');
		$obj->CSIGN = $oid;
		return $obj;
	}

	public function Refund($oid, $inRFM = null)
	{
		$order = logic('order')->GetOne($oid);
		logic('order')->Update($oid, array('status'=>ORD_STA_Refund));
		logic('order')->doFailed($order);
		if ($order['product']['type'] == 'ticket')
		{
			dbc(DBCMax)->update('ticket')->where('orderid='.$order['orderid'])->data('status='.TICK_STA_Invalid)->done();
		}
		$rfm = is_null($inRFM) ? $order['paymoney'] : ($inRFM > 0 ? (float)$inRFM : 0);
		$rfm && logic('me')->money()->add($rfm, $order['userid'], array(
			'name' => __('订单退款'),
			'intro' => '您好，您的订单[ '.$oid.' ]已经退款！'
		));
		logic('notify')->Call($order['userid'], 'logic.order.Refund', array(
			'orderid' => $oid,
			'productflag' => $order['product']['flag'],
			'refundmoney' => $order['productnum']*$order['productprice']
		));
		return true;
	}

	public function Confirm($oid)
	{
		$order = logic('order')->SrcOne($oid);
		$product = logic('product')->SrcOne($order['productid']);
		$trade = array(
			'sign' => $oid,
			'trade_no' => time(),
			'price' => $order['paymoney'],
			'money' => 0,
			'money_reason' => '管理员 '.user()->get('name').' 确认订单已付款',
			'status' => ($product['type'] == 'ticket') ? 'TRADE_FINISHED' : 'WAIT_SELLER_SEND_GOODS'
		);
		$error = false;
		$order = logic('order')->_TMP_Payed($trade);
		isset($order['false']) && $error = ' [P] '.$order['false'];
		if (!$error)
		{
			$order = logic('order')->MakeSuccessed($trade['sign']);
			isset($order['false']) && $error = ' [M] '.$order['false'];
			if (!$error)
			{
				logic('notify')->Call($order['userid'], 'logic.order.Confirm', array(
					'orderid' => $oid
				));
				if (($order['productprice'] != 0 || $order['expressprice'] != 0) && $order['totalprice'] == 0)
				{
					$totalprice = $order['productprice']*$order['productnum']+$order['expressprice'];
					logic('order')->Update($oid, array('totalprice'=>$totalprice));
				}
			}
		}
		if ($error)
		{
			logic('order')->Update($oid, array('status'=>ORD_STA_Overdue,'process'=>'__PAY_YET__'));
			return ' [R] '.$error;
		}
		return '';
	}

	public function Cancel($oid, $inRFM = null)
	{
		$order = logic('order')->GetOne($oid);
		logic('order')->Update($oid, array('status'=>ORD_STA_Cancel));
		if ($order['pay'] == ORD_PAID_Yes)
		{
			$rfm = is_null($inRFM) ? $order['paymoney'] : ($inRFM > 0 ? (float)$inRFM : 0);
			$rfm && logic('me')->money()->add($rfm, $order['userid'], array(
				'name' => __('订单取消'),
				'intro' => '您好，您的订单[ '.$oid.' ]已经被取消，余款已经充值到您的个人账户！'
			));
			logic('order')->doFailed($order);
		}
		logic('notify')->Call($order['userid'], 'logic.order.Cancel', array(
			'orderid' => $oid
		));
		return true;
	}


	public function doSuccess($order)
	{
		//2021-10-26已经验证以下两个正常更新
		$aaa=logic('seller')->money_add($order['product']['sellerid'], $order['productnum']*$order['productprice']);
		$bbb=logic('seller')->order_success($order['product']['sellerid']);



		//

		dbc(DBCMax)->update('product')->data('totalnum=totalnum+1')->where('id='.$order['productid'])->done();
	}

	public function doFailed($order)
	{
		$sid = $order['product']['sellerid'];
		logic('seller')->money_less($sid, $order['productnum']*$order['productprice']);
		logic('seller')->order_failed($sid);
		dbc(DBCMax)->update('product')->data('totalnum=totalnum-1')->where('id='.$order['productid'])->done();
	}

	public function doRelSuccess($order)
	{
		logic('me')->finder($order['userid'], $order['productid']);
	}


	function orderCheck( $id )
	{
		$sql = 'select * from ' . TABLE_PREFIX . 'tttuangou_order where orderid=' . $id . ' and status=1 and pay=0';
		$query = $this->DatabaseHandler->Query($sql);
		$order = $query->GetRow();
		return $order;
	}

	function orderGetByUser( $productid, $uid, $checkMuti = false )
	{
		if ( false == $checkMuti )
		{
			$sql = 'select * from ' . TABLE_PREFIX . 'tttuangou_order where productid=' . intval($productid) . ' and userid=' . intval($uid) . ' and status=1';
		}
		else
		{
			$sql = 'select o.*,p.multibuy from ' . TABLE_PREFIX . 'tttuangou_order o LEFT JOIN ' . TABLE_PREFIX . 'tttuangou_product p ON(o.productid=p.id) where o.productid=' . intval($productid) . ' and o.userid=' . intval($uid) . '';
		}
		$query = $this->DatabaseHandler->Query($sql);
		if ( ! $query ) return '';
		$order = $query->GetRow();
		if ( $order['multibuy'] != '' && $order['multibuy'] == 'true' )
		{
			return '';
		}
		return $order;
	}

	function orderEdit( $orderid, $ary = array() )
	{
		$this->DatabaseHandler->SetTable(TABLE_PREFIX . 'tttuangou_order');
		$result = $this->DatabaseHandler->Update($ary, 'orderid=' . $orderid);
		return $result;
	}

	function orderCreater( $ary = array() )
	{
		$this->DatabaseHandler->SetTable(TABLE_PREFIX . 'tttuangou_order');
		$result = $this->DatabaseHandler->Insert($ary);
		return $result;
	}

	function orderType( $id, $type, $paytime = '', $pay = '' )
	{
		$ary = array(
			'status' => $type
		);
		if ( $paytime != '' ) $ary['paytime'] = time();
		if ( $pay != '' )
		{
			$ary['pay'] = 1;
			$sql = 'update ' . TABLE_PREFIX . 'tttuangou_product p left join ' . TABLE_PREFIX . 'tttuangou_order o on p.id=o.productid set p.totalnum = p.totalnum + 1 where o.orderid = ' . $id;
			$this->DatabaseHandler->Query($sql);
		}
		$this->DatabaseHandler->SetTable(TABLE_PREFIX . 'tttuangou_order');
		$result = $this->DatabaseHandler->Update($ary, 'orderid=' . $id);
		return $result;
	}

	function orderPaylist( $productid )
	{
		$sql = 'select o.*,m.username,m.email,p.nowprice,p.successnum from ' . TABLE_PREFIX . 'tttuangou_order o left join ' . TABLE_PREFIX . 'system_members m on o.userid= m.uid left join ' . TABLE_PREFIX . 'tttuangou_product p on o.productid=p.id where o.productid = ' . intval($productid) . ' and o.pay = 1 and o.status = 1';
		$query = $this->DatabaseHandler->Query($sql);
		$orderPayed = $query->GetAll();
		return $orderPayed;
	}

	function listProductOrderPayed( $productid )
	{
		$sql = 'select o.*,m.username,m.email,p.nowprice,p.successnum from ' . TABLE_PREFIX . 'tttuangou_order o left join ' . TABLE_PREFIX . 'system_members m on o.userid= m.uid left join ' . TABLE_PREFIX . 'tttuangou_product p on o.productid=p.id where o.productid = ' . intval($productid) . ' and o.pay = 1';
		$query = $this->DatabaseHandler->Query($sql);
		$orderPayed = $query->GetAll();
		return $orderPayed;
	}

	function UpOrder()
	{
		$sql = 'update ' . TABLE_PREFIX . 'tttuangou_order o left join ' . TABLE_PREFIX . 'tttuangou_product p on o.productid = p.id set o.status=2 where ' . time() . ' > p.overtime and  o.pay = 0 and o.status = 1 and o.userid = ' . MEMBER_ID;
		$query = $this->DatabaseHandler->Query($sql);
		return true;
	}

	function GetTicket( $id, $seller = 0 )
	{
		if ( $seller == 0 )
		{
			$sql = 'select t.*,p.name,p.intro,p.nowprice,s.sellerurl,p.perioddate,s.selleraddress from ' . TABLE_PREFIX . 'tttuangou_ticket t LEFT JOIN ' . TABLE_PREFIX . 'tttuangou_product p on t.productid = p.id left join ' . TABLE_PREFIX . 'tttuangou_seller s on p.sellerid=s.id where uid = ' . MEMBER_ID . ' and ticketid = ' . intval($id);
		}
		else
		{
			$sql = 'select t.*,p.name,p.intro,p.nowprice,s.sellerurl,p.perioddate,s.selleraddress from ' . TABLE_PREFIX . 'tttuangou_ticket t LEFT JOIN ' . TABLE_PREFIX . 'tttuangou_product p on t.productid = p.id left join ' . TABLE_PREFIX . 'tttuangou_seller s on p.sellerid=s.id where ticketid = ' . intval($id);
		}
		$query = dbc()->Query($sql);
		$ticket = $query->GetRow();
		return $ticket;
	}
}

/**
 * 扩充类：变更日志
 * @author Moyo <dev@uuland.org>
 */
class OrderLogic_cLog
{
	public $CSIGN = null;

	function sys($mark)
	{
		return $this->add('system', $mark, 0);
	}

	function add($action, $mark, $uid = null)
	{
		return dbc(DBCMax)->insert('order_clog')->data(array(
			'sign' => $this->CSIGN,
			'action' => $action,
			'uid' => is_null($uid) ? user()->get('id') : $uid,
			'remark' => $mark,
			'time' => time()
		))->done();
	}

	function del($id = null)
	{
		dbc(DBCMax)->delete('order_clog')->where('sign='.$this->CSIGN);
		if ($id !== null)
		{
			dbc(DBCMax)->where('id='.$id);
		}
		return dbc(DBCMax)->done();
	}

	function vlist($action = '1')
	{
		return
			dbc(DBCMax)
				->select('order_clog')
				->where('sign='.$this->CSIGN)
				->where($action)
				->order('id.desc')
				->done();
	}


}
?>
