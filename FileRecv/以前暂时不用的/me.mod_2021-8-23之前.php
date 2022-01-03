<?php

/**
 * 模块：个人操作
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name me.mod.php
 * @version 1.0
 */

class ModuleObject extends MasterObject
{
    var $city;
    var $config;
    var $product_config;

    var $public_global;

    //ini_set('display_errors', 'On');
    //ini_set('error_reporting', E_ALL);


    /*
	session_start();
	$username_nm=$_SESSION['username_nm'];
	*/


    /*
	$masterObject=new MasterObject();
	$object = new ReflectionObject($masterObject);
	$method = $object->getMethod('__initComponents');
	$declaringClass = $method->getDeclaringClass();
	$filename = $declaringClass->getFilename();


	//var_dump("调试输出filename");
	print_r("调试输出me.mod.php中filename=");
	print_r($filename)；
	print_r("在me.mod.php中")；
	*/


    function ModuleObject($config)
    {
        $this->MasterObject($config);
        $a = $this->checkwap();
        if (MEMBER_ID < 1) {
            if (!$a) {
                // $this->Messager(__('请先登录！'), '?mod=account&code=login&to='.base64_encode($_SERVER["REQUEST_URI"]));
            } else {
                if ($_GET['code'] == 'account') {
                    header('Location: ' . rewrite('?mod=wap&code=account_login&to=' . base64_encode($_SERVER["REQUEST_URI"])));
                }
            }
        }
        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        if (!in_array($_GET['code'], array('wapsetting', 'wapsetting_nm', 'doinfo', 'doinfo_nm', 'getprivate', 'wapxykhk', 'wapsp', 'wapxyk', 'wapjl', 'wapjl_nm', 'wapbill', 'wapbill_nm', 'wapsm2', 'docontracttrans', 'createcontractpwd', 'contracttrans', 'contracttrans_nm', 'createcontract', 'wapsp1'))) {

            if ($yanzheng['statue'] != 2) {
                $noyanzheng = 1;
                if (($_GET['code'] != "yanzheng") && ($_GET['code'] != "doyanzheng")) {
                    $yanzheng['statue'] || $yanzheng['statue'] = 0;
                    if (!$a) {
                        include handler('template')->file('my_noyanzheng');
                    } else {
                        include handler('template')->file('@wap/my_noyanzheng');
                    }
                    exit;
                }
            }
        }

        Load::logic('product');
        $this->ProductLogic = new ProductLogic();
        Load::logic('pay');
        $this->PayLogic = new PayLogic();
        Load::logic('me');
        $this->MeLogic = new MeLogic();
        Load::logic('order');
        $this->OrderLogic = new OrderLogic();
        $this->config = $config;
        $this->ID = ( int )($this->Post['id'] ? $this->Post['id'] : $this->Get['id']);
        $this->CacheConfig = ConfigHandler::get('cache');
        $this->ShowConfig = ConfigHandler::get('show');
        $runCode = Load::moduleCode($this, $this->Code);
        $this->product_config = ConfigHandler::get('product');
        $this->$runCode();
    }

    function Main()
    {
        $_GET['code'] = 'coupon';
        $this->Coupon();
    }

    function Coupon()
    {
        $this->Title = __('我的团购券');
        $status = $this->Get['status'];
        if ($status == '') {
            $status = -1;
        } else {
            $status = (int)$status;
        }
        $ticket_all = logic('coupon')->GetList(user()->get('id'), ORD_ID_ANY, $status);

        $_s1 = $_s2 = $_s3 = $_s4 = 3;
        if ($status == -1) $_s1 = 2;
        if ($status == 0) $_s2 = 2;
        if ($status == 1) $_s3 = 2;
        if ($status == 2) $_s4 = 2;

        include handler('template')->file('my_coupon');
    }

    function Order()
    {
        $this->Title = __('我的订单');
        $pay = $this->Get['pay'];
        if ($pay == '') {
            $pay = -1;
        } else {
            $pay = (int)$pay;
        }
        $order_all = logic('order')->GetList(user()->get('id'), -1, $pay);

        $_s1 = $_s2 = $_s3 = 3;
        if ($pay == -1) $_s1 = 2;
        if ($pay == 1) $_s2 = 2;
        if ($pay == 0) $_s3 = 2;

        include handler('template')->file('my_order');
    }

    function wapbill()
    {
        $this->Title = __('消费详单');
        $yanzheng = logic("yanzheng")->GetOne(user()->get(id));
        $usermoney = logic('me')->money()->log();

        foreach ($usermoney as $key => $value) {
            $info = $value;
            if ($value['name'] == 'zn' || $value['name'] == 'zz') {
                $zhanzhuanginfo = logic('zhanneilist')->GetOne($value['intro']);
                if ($zhanzhuanginfo['money_type'] == 1) {
                    $prefix = 'USD';
                    $$usermoney[$key]['is_dollar'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 2) {
                    $prefix = "HKD";
                    $$usermoney[$key]['is_hkdollar'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 4) {
                    $prefix = "JPY";
                    $$usermoney[$key]['is_jpy'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 5) {
                    $prefix = "KRW";
                    $$usermoney[$key]['is_krw'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 6) {
                    $prefix = "GBP";
                    $$usermoney[$key]['is_gbp'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 7) {
                    $prefix = "AUD";
                    $$usermoney[$key]['is_aud'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 8) {
                    $prefix = "CAD";
                    $$usermoney[$key]['is_cad'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 9) {
                    $prefix = "CHF";
                    $$usermoney[$key]['is_chf'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 10) {
                    $prefix = "NZD";
                    $$usermoney[$key]['is_nzd'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 11) {
                    $prefix = "SGD";
                    $$usermoney[$key]['is_sgd'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 12) {
                    $prefix = "HKC";
                    $$usermoney[$key]['is_hkc'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 13) {
                    $prefix = "CNY";
                    $$usermoney[$key]['is_money'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 14) {
                    $prefix = "BTC";
                    $$usermoney[$key]['is_btc'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 15) {
                    $prefix = "ETH";
                    $$usermoney[$key]['is_eth'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 3) {
                    $prefix = "EUR";
                    $$usermoney[$key]['is_euro'] = 1;
                } else {
                    $prefix = 'CNY';
                }
                if ($zhanzhuanginfo['owner'] == user()->get('id')) {
                    $zhanzhuanginfo[tousername] = user($zhanzhuanginfo['touid'])->get("name");

                    if ($zhanzhuanginfo['is_private'] == 1) {

                        $sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['touid'] . '"';
                        $q = $this->DatabaseHandler->Query($sql);
                        $private = $q->GetRow();
                        $topublic = $private['encrypt_public'];
                        $b = "<b>收款匿名地址：</b>$topublic";
                    } else {
                        $b = "<b>收款人：</b>$zhanzhuanginfo[tousername]";
                    }

                    $zhanzhuanginfo['info'] = "
						" . $b . "
                        <br>
						<b>金额：</b>{$prefix}" . number_format($zhanzhuanginfo[value], 2, '.', '') . "元
						<br>
						<!--<b>付款留言：</b>$zhanzhuanginfo[mark]-->
						<br>
						<b>手续费率：</b>" . number_format($zhanzhuanginfo['sxfl'], 2, '.', '') . "%
                        <br>
						<b>手续费：</b>{$prefix}" . ($zhanzhuanginfo[value] - $zhanzhuanginfo[tovalue]) . "元
                        <br>
						<b>实际到账：</b>{$prefix}" . number_format($zhanzhuanginfo[tovalue], 2, '.', '') . "元
						";
                } else if ($zhanzhuanginfo['touid'] == user()->get('id')) {

                    if ($zhanzhuanginfo['is_private'] == 1) {

                        $sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['owner'] . '"';
                        $q = $this->DatabaseHandler->Query($sql);
                        $private = $q->GetRow();
                        $public = $private['encrypt_public'];
                        $b = "<b>付款匿名地址：</b>$public";
                    } else {
                        $b = "<b>付款人：</b>$zhanzhuanginfo[username]";
                    }

                    $zhanzhuanginfo[sername] = user($zhanzhuanginfo['owner'])->get("name");
                    $zhanzhuanginfo['info'] = "
	        	  	   <b>到账时间：</b>" . date("Y-m-d:H:i:s", $zhanzhuanginfo[addtime]) . "
                       <br>
						$b
						<br>
						<b>金额：</b>{$prefix}" . number_format($zhanzhuanginfo[tovalue], 2, '.', '') . "元
						<br>
						<!--<b>付款人留言：</b>$zhanzhuanginfo[mark]-->

						";
                }
                $usermoney[$key]['info'] = $zhanzhuanginfo['info'];
            } elseif ($value['name'] == 'cp') {
                $orderinfo = logic('order')->GetOne($value['intro']);

                $usermoney[$key]['intro'] = "
	        	  	   <b>到账时间：</b>" . date("Y-m-d:H:i:s", $orderinfo[paytime]) . "
                       <br>
						<b>购买人：</b>" . user($orderinfo['userid'])->get('name') . "
						<br>
						<b>商品名称：</b>" . $orderinfo['product']['name'] . "


						";
                $usermoney[$key]['name'] = "卖出商品";
            } elseif ($value['name'] == 'djq') {
                $usermoney[$key]['name'] = "卖出团购券";
                $orderinfo = logic('order')->GetOne($value['intro']);

                $usermoney[$key]['intro'] = "
	        	  	   <b>到账时间：</b>" . date("Y-m-d:H:i:s", $orderinfo[paytime]) . "
						<br>
                        <b>购买人：</b>" . user($orderinfo['userid'])->get('name') . "
						<br>
						<b>商品名称：</b>" . $orderinfo['product']['name'] . "


						";

            } elseif ($value['name'] == 'hkcz') {

                $usermoney[$key]['name'] = "汇款充值";
                $sql = 'select * from ' . TABLE_PREFIX . 'tttuangou_recharge_order where orderid = \'' . $info['intro'] . '\'';
                $query = $this->DatabaseHandler->Query($sql);
                $ticket = $query->GetRow();


                $usermoney[$key]['intro'] = "
        		  <b>申请时间：</b>" . date("Y-m-d H:i", $ticket[createtime]) . "
        		  <br>
	        	  	   <b>到账时订：</b>" . date("Y-m-d H:i", $ticket[paytime]) . "
						<br>
						<b>订单号：</b>" . $ticket[orderid] . "


						";

            } elseif ($value['name'] == '银行转账') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne($value['intro']);
                if (!empty($zhanzhuanginfo)) {
                    $usermoney[$key]['intro'] = "
                		  <b>开卡行：</b>" . $zhanzhuanginfo['yhkinfo'] . "<br><b>卡号：</b>" . $zhanzhuanginfo['yhkkh'] . "
                		  <br>
                          <b>开户名：</b>" . $zhanzhuanginfo['yhkname'] . "
                          <br>
                		  <b>金额：</b>￥" . number_format($zhanzhuanginfo['value'], 2, '.', '') . "元<br/><b>时间：</b>" . date('Y-m-d H:i', $zhanzhuanginfo['addtime']) .
                        "<br/><b>手续费率：</b>" . $zhanzhuanginfo['sxhl'] . '%<br/>' . "<b>手续费：</b>￥" . number_format($zhanzhuanginfo['sxfl'], 2, '.', '') . '元<br/>' .
                        "<b>实际到账：</b>￥" . number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '') . '元<br/>' .
                        "<b>备注：</b>" . $zhanzhuanginfo['mark'] .
                        "<br/><b>状态：</b>" . ($zhanzhuanginfo['statue'] == 1 ? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                }
            } elseif ($value['name'] == '国际转账' || $value['name'] == '港币汇款' || $value['name'] == '欧元汇款' || $value['name'] == '日元汇款' || $value['name'] == '韩元汇款' || $value['name'] == '英镑汇款' || $value['name'] == '澳元汇款' || $value['name'] == '加元汇款' || $value['name'] == '瑞郎汇款' || $value['name'] == '新西兰元汇款' || $value['name'] == '新加坡元汇款' || $value['name'] == '香港币汇款' || $value['name'] == '比特币汇款' || $value['name'] == '以太币汇款' || $value['name'] == '人民币汇款' || $value['name'] == '美元汇款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne2($value['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne2($zhanzhuanginfo['yhkid']);

                if (!empty($zhanzhuanginfo)) {
                    $prefix = '';
                    if ($zhanzhuanginfo['is_dollar'] == 1) {
                        $prefix = 'USD';
                    } elseif ($zhanzhuanginfo['is_hkdollar'] == 1) {
                        $prefix = "HKD";
                    } elseif ($zhanzhuanginfo['is_jpy'] == 1) {
                        $prefix = "JPY";
                    } elseif ($zhanzhuanginfo['is_krw'] == 1) {
                        $prefix = "KRW";
                    } elseif ($zhanzhuanginfo['is_gbp'] == 1) {
                        $prefix = "GBP";
                    } elseif ($zhanzhuanginfo['is_aud'] == 1) {
                        $prefix = "AUD";
                    } elseif ($zhanzhuanginfo['is_cad'] == 1) {
                        $prefix = "CAD";
                    } elseif ($zhanzhuanginfo['is_chf'] == 1) {
                        $prefix = "CHF";
                    } elseif ($zhanzhuanginfo['is_nzd'] == 1) {
                        $prefix = "NZD";
                    } elseif ($zhanzhuanginfo['is_sgd'] == 1) {
                        $prefix = "SGD";
                    } elseif ($zhanzhuanginfo['is_hkc'] == 1) {
                        $prefix = "HKC";
                    } elseif ($zhanzhuanginfo['is_btc'] == 1) {
                        $prefix = "BTC";
                    } elseif ($zhanzhuanginfo['is_eth'] == 1) {
                        $prefix = "ETH";
                    } elseif ($zhanzhuanginfo['is_money'] == 1) {
                        $prefix = "CNY";
                    } elseif ($zhanzhuanginfo['is_euro'] == 1) {
                        $prefix = "EUR";
                    } else {
                        $prefix = "CNY";
                    }
                    $usermoney[$key]['intro'] = "
                		  <b>开卡行：</b>" . $yinhangkainfo['khcity'] . $yinhangkainfo['khcc'] . "<br><b>卡号：</b>" . $yinhangkainfo['cardno'] . "
                		  <br>
                          <b>开户名：</b>" . $yinhangkainfo['name'] . "
                          <br>
                		  <b>金额：</b>{$prefix}" . number_format($zhanzhuanginfo['value'], 2, '.', '') . "元<br/><b>时间：</b>" . date('Y-m-d H:i', $zhanzhuanginfo['addtime']) .
                        "<br/><b>手续费率：</b>" . ($zhanzhuanginfo['is_sxf'] == 1 ? $zhanzhuanginfo['sxhl'] : '0') . '%<br/>' . "<b>手续费：</b>{$prefix}" . ($zhanzhuanginfo['is_sxf'] == 1 ? number_format($zhanzhuanginfo['sxfl'], 2, '.', '') : '0.00') . '元<br/>' .
                        "<b>实际到账：</b>{$prefix}" . ($zhanzhuanginfo['is_sxf'] == 1 ? number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '') : number_format($zhanzhuanginfo['value'], 2, '.', '')) . '元<br/>' .
                        "<b>收取手续费：</b>" . ($zhanzhuanginfo['is_sxf'] == 1 ? '是' : '否') .
                        "<br/><b>付款人留言：</b>" . $zhanzhuanginfo['message'] .
                        "<br/><b>汇款用途：</b>" . $zhanzhuanginfo['yongtu'] .
                        "<br/><b>备注：</b>" . $zhanzhuanginfo['mark'] .
                        "<br/><b>状态：</b>" . ($zhanzhuanginfo['statue'] == 1 ? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                }
            } elseif ($value['name'] == '信用卡还款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne3($value['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne3($zhanzhuanginfo['yhkid']);

                if (!empty($zhanzhuanginfo)) {
                    $usermoney[$key]['intro'] = "
                		  <b>开卡行：</b>" . $yinhangkainfo['kaihuhang'] . "<br><b>卡号：</b>" . $yinhangkainfo['kahao'] . "
                		  <br>
                          <b>开户名：</b>" . $yinhangkainfo['name'] . "
                          <br>
                		  <b>还款金额：</b>￥" . number_format($zhanzhuanginfo['value'], 2, '.', '') . "元<br/><b>时间：</b>" . date('Y-m-d H:i', $zhanzhuanginfo['addtime']) .
                        "<br/><b>手续费率：</b>" . $zhanzhuanginfo['sxhl'] . '%<br/>' . "<b>手续费：</b>￥" . number_format($zhanzhuanginfo['sxfl'], 2, '.', '') . '元<br/>' .
                        "<b>实际付款：</b>￥" . number_format(($zhanzhuanginfo['value'] + $zhanzhuanginfo['sxfl']), 2, '.', '') . '元<br/>' .
                        "<b>备注：</b>" . $zhanzhuanginfo['mark'] .
                        "<br/><b>状态：</b>" . ($zhanzhuanginfo['statue'] == 1 ? '还款中' : ($zhanzhuanginfo['statue'] == 3 ? '还款失败' : '还款成功'));
                }
            }
        }


        include handler('template')->file('@wap/my_bill');

    }


    function wapbill_nm()
    {

        session_start();
        $username_nm = $_SESSION['username_nm'];

        $this->Title = __('消费详单');
        $yanzheng = logic("yanzheng")->GetOne(user()->get(id));
        $usermoney = logic('me')->money()->log();

        foreach ($usermoney as $key => $value) {
            $info = $value;
            if ($value['name'] == 'zn' || $value['name'] == 'zz') {
                $zhanzhuanginfo = logic('zhanneilist')->GetOne($value['intro']);
                if ($zhanzhuanginfo['money_type'] == 1) {
                    $prefix = 'USD';
                    $$usermoney[$key]['is_dollar'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 2) {
                    $prefix = "HKD";
                    $$usermoney[$key]['is_hkdollar'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 4) {
                    $prefix = "JPY";
                    $$usermoney[$key]['is_jpy'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 5) {
                    $prefix = "KRW";
                    $$usermoney[$key]['is_krw'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 6) {
                    $prefix = "GBP";
                    $$usermoney[$key]['is_gbp'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 7) {
                    $prefix = "AUD";
                    $$usermoney[$key]['is_aud'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 8) {
                    $prefix = "CAD";
                    $$usermoney[$key]['is_cad'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 9) {
                    $prefix = "CHF";
                    $$usermoney[$key]['is_chf'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 10) {
                    $prefix = "NZD";
                    $$usermoney[$key]['is_nzd'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 11) {
                    $prefix = "SGD";
                    $$usermoney[$key]['is_sgd'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 12) {
                    $prefix = "HKC";
                    $$usermoney[$key]['is_hkc'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 13) {
                    $prefix = "CNY";
                    $$usermoney[$key]['is_money'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 14) {
                    $prefix = "BTC";
                    $$usermoney[$key]['is_btc'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 15) {
                    $prefix = "ETH";
                    $$usermoney[$key]['is_eth'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 3) {
                    $prefix = "EUR";
                    $$usermoney[$key]['is_euro'] = 1;
                } else {
                    $prefix = 'CNY';
                }
                if ($zhanzhuanginfo['owner'] == user()->get('id')) {
                    $zhanzhuanginfo[tousername] = user($zhanzhuanginfo['touid'])->get("name");

                    if ($zhanzhuanginfo['is_private'] == 1) {

                        $sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['touid'] . '"';
                        $q = $this->DatabaseHandler->Query($sql);
                        $private = $q->GetRow();
                        $topublic = $private['encrypt_public'];
                        $b = "<b>收款匿名地址：</b>$topublic";
                    } else {
                        $b = "<b>收款人：</b>$zhanzhuanginfo[tousername]";
                    }

                    $zhanzhuanginfo['info'] = "
						" . $b . "
                        <br>
						<b>金额：</b>{$prefix}" . number_format($zhanzhuanginfo[value], 2, '.', '') . "元
						<br>
						<!--<b>付款留言：</b>$zhanzhuanginfo[mark]-->
						<br>
						<b>手续费率：</b>" . number_format($zhanzhuanginfo['sxfl'], 2, '.', '') . "%
                        <br>
						<b>手续费：</b>{$prefix}" . ($zhanzhuanginfo[value] - $zhanzhuanginfo[tovalue]) . "元
                        <br>
						<b>实际到账：</b>{$prefix}" . number_format($zhanzhuanginfo[tovalue], 2, '.', '') . "元
						";
                } else if ($zhanzhuanginfo['touid'] == user()->get('id')) {

                    if ($zhanzhuanginfo['is_private'] == 1) {

                        $sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['owner'] . '"';
                        $q = $this->DatabaseHandler->Query($sql);
                        $private = $q->GetRow();
                        $public = $private['encrypt_public'];
                        $b = "<b>付款匿名地址：</b>$public";
                    } else {
                        $b = "<b>付款人：</b>$zhanzhuanginfo[username]";
                    }

                    $zhanzhuanginfo[sername] = user($zhanzhuanginfo['owner'])->get("name");
                    $zhanzhuanginfo['info'] = "
	        	  	   <b>到账时间：</b>" . date("Y-m-d:H:i:s", $zhanzhuanginfo[addtime]) . "
                       <br>
						$b
						<br>
						<b>金额：</b>{$prefix}" . number_format($zhanzhuanginfo[tovalue], 2, '.', '') . "元
						<br>
						<!--<b>付款人留言：</b>$zhanzhuanginfo[mark]-->

						";
                }
                $usermoney[$key]['info'] = $zhanzhuanginfo['info'];
            } elseif ($value['name'] == 'cp') {
                $orderinfo = logic('order')->GetOne($value['intro']);

                $usermoney[$key]['intro'] = "
	        	  	   <b>到账时间：</b>" . date("Y-m-d:H:i:s", $orderinfo[paytime]) . "
                       <br>
						<b>购买人：</b>" . user($orderinfo['userid'])->get('name') . "
						<br>
						<b>商品名称：</b>" . $orderinfo['product']['name'] . "


						";
                $usermoney[$key]['name'] = "卖出商品";
            } elseif ($value['name'] == 'djq') {
                $usermoney[$key]['name'] = "卖出团购券";
                $orderinfo = logic('order')->GetOne($value['intro']);

                $usermoney[$key]['intro'] = "
	        	  	   <b>到账时间：</b>" . date("Y-m-d:H:i:s", $orderinfo[paytime]) . "
						<br>
                        <b>购买人：</b>" . user($orderinfo['userid'])->get('name') . "
						<br>
						<b>商品名称：</b>" . $orderinfo['product']['name'] . "


						";

            } elseif ($value['name'] == 'hkcz') {

                $usermoney[$key]['name'] = "汇款充值";
                $sql = 'select * from ' . TABLE_PREFIX . 'tttuangou_recharge_order where orderid = \'' . $info['intro'] . '\'';
                $query = $this->DatabaseHandler->Query($sql);
                $ticket = $query->GetRow();


                $usermoney[$key]['intro'] = "
        		  <b>申请时间：</b>" . date("Y-m-d H:i", $ticket[createtime]) . "
        		  <br>
	        	  	   <b>到账时订：</b>" . date("Y-m-d H:i", $ticket[paytime]) . "
						<br>
						<b>订单号：</b>" . $ticket[orderid] . "


						";

            } elseif ($value['name'] == '银行转账') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne($value['intro']);
                if (!empty($zhanzhuanginfo)) {
                    $usermoney[$key]['intro'] = "
                		  <b>开卡行：</b>" . $zhanzhuanginfo['yhkinfo'] . "<br><b>卡号：</b>" . $zhanzhuanginfo['yhkkh'] . "
                		  <br>
                          <b>开户名：</b>" . $zhanzhuanginfo['yhkname'] . "
                          <br>
                		  <b>金额：</b>￥" . number_format($zhanzhuanginfo['value'], 2, '.', '') . "元<br/><b>时间：</b>" . date('Y-m-d H:i', $zhanzhuanginfo['addtime']) .
                        "<br/><b>手续费率：</b>" . $zhanzhuanginfo['sxhl'] . '%<br/>' . "<b>手续费：</b>￥" . number_format($zhanzhuanginfo['sxfl'], 2, '.', '') . '元<br/>' .
                        "<b>实际到账：</b>￥" . number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '') . '元<br/>' .
                        "<b>备注：</b>" . $zhanzhuanginfo['mark'] .
                        "<br/><b>状态：</b>" . ($zhanzhuanginfo['statue'] == 1 ? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                }
            } elseif ($value['name'] == '国际转账' || $value['name'] == '港币汇款' || $value['name'] == '欧元汇款' || $value['name'] == '日元汇款' || $value['name'] == '韩元汇款' || $value['name'] == '英镑汇款' || $value['name'] == '澳元汇款' || $value['name'] == '加元汇款' || $value['name'] == '瑞郎汇款' || $value['name'] == '新西兰元汇款' || $value['name'] == '新加坡元汇款' || $value['name'] == '香港币汇款' || $value['name'] == '比特币汇款' || $value['name'] == '以太币汇款' || $value['name'] == '人民币汇款' || $value['name'] == '美元汇款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne2($value['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne2($zhanzhuanginfo['yhkid']);

                if (!empty($zhanzhuanginfo)) {
                    $prefix = '';
                    if ($zhanzhuanginfo['is_dollar'] == 1) {
                        $prefix = 'USD';
                    } elseif ($zhanzhuanginfo['is_hkdollar'] == 1) {
                        $prefix = "HKD";
                    } elseif ($zhanzhuanginfo['is_jpy'] == 1) {
                        $prefix = "JPY";
                    } elseif ($zhanzhuanginfo['is_krw'] == 1) {
                        $prefix = "KRW";
                    } elseif ($zhanzhuanginfo['is_gbp'] == 1) {
                        $prefix = "GBP";
                    } elseif ($zhanzhuanginfo['is_aud'] == 1) {
                        $prefix = "AUD";
                    } elseif ($zhanzhuanginfo['is_cad'] == 1) {
                        $prefix = "CAD";
                    } elseif ($zhanzhuanginfo['is_chf'] == 1) {
                        $prefix = "CHF";
                    } elseif ($zhanzhuanginfo['is_nzd'] == 1) {
                        $prefix = "NZD";
                    } elseif ($zhanzhuanginfo['is_sgd'] == 1) {
                        $prefix = "SGD";
                    } elseif ($zhanzhuanginfo['is_hkc'] == 1) {
                        $prefix = "HKC";
                    } elseif ($zhanzhuanginfo['is_btc'] == 1) {
                        $prefix = "BTC";
                    } elseif ($zhanzhuanginfo['is_eth'] == 1) {
                        $prefix = "ETH";
                    } elseif ($zhanzhuanginfo['is_money'] == 1) {
                        $prefix = "CNY";
                    } elseif ($zhanzhuanginfo['is_euro'] == 1) {
                        $prefix = "EUR";
                    } else {
                        $prefix = "CNY";
                    }
                    $usermoney[$key]['intro'] = "
                		  <b>开卡行：</b>" . $yinhangkainfo['khcity'] . $yinhangkainfo['khcc'] . "<br><b>卡号：</b>" . $yinhangkainfo['cardno'] . "
                		  <br>
                          <b>开户名：</b>" . $yinhangkainfo['name'] . "
                          <br>
                		  <b>金额：</b>{$prefix}" . number_format($zhanzhuanginfo['value'], 2, '.', '') . "元<br/><b>时间：</b>" . date('Y-m-d H:i', $zhanzhuanginfo['addtime']) .
                        "<br/><b>手续费率：</b>" . ($zhanzhuanginfo['is_sxf'] == 1 ? $zhanzhuanginfo['sxhl'] : '0') . '%<br/>' . "<b>手续费：</b>{$prefix}" . ($zhanzhuanginfo['is_sxf'] == 1 ? number_format($zhanzhuanginfo['sxfl'], 2, '.', '') : '0.00') . '元<br/>' .
                        "<b>实际到账：</b>{$prefix}" . ($zhanzhuanginfo['is_sxf'] == 1 ? number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '') : number_format($zhanzhuanginfo['value'], 2, '.', '')) . '元<br/>' .
                        "<b>收取手续费：</b>" . ($zhanzhuanginfo['is_sxf'] == 1 ? '是' : '否') .
                        "<br/><b>付款人留言：</b>" . $zhanzhuanginfo['message'] .
                        "<br/><b>汇款用途：</b>" . $zhanzhuanginfo['yongtu'] .
                        "<br/><b>备注：</b>" . $zhanzhuanginfo['mark'] .
                        "<br/><b>状态：</b>" . ($zhanzhuanginfo['statue'] == 1 ? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                }
            } elseif ($value['name'] == '信用卡还款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne3($value['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne3($zhanzhuanginfo['yhkid']);

                if (!empty($zhanzhuanginfo)) {
                    $usermoney[$key]['intro'] = "
                		  <b>开卡行：</b>" . $yinhangkainfo['kaihuhang'] . "<br><b>卡号：</b>" . $yinhangkainfo['kahao'] . "
                		  <br>
                          <b>开户名：</b>" . $yinhangkainfo['name'] . "
                          <br>
                		  <b>还款金额：</b>￥" . number_format($zhanzhuanginfo['value'], 2, '.', '') . "元<br/><b>时间：</b>" . date('Y-m-d H:i', $zhanzhuanginfo['addtime']) .
                        "<br/><b>手续费率：</b>" . $zhanzhuanginfo['sxhl'] . '%<br/>' . "<b>手续费：</b>￥" . number_format($zhanzhuanginfo['sxfl'], 2, '.', '') . '元<br/>' .
                        "<b>实际付款：</b>￥" . number_format(($zhanzhuanginfo['value'] + $zhanzhuanginfo['sxfl']), 2, '.', '') . '元<br/>' .
                        "<b>备注：</b>" . $zhanzhuanginfo['mark'] .
                        "<br/><b>状态：</b>" . ($zhanzhuanginfo['statue'] == 1 ? '还款中' : ($zhanzhuanginfo['statue'] == 3 ? '还款失败' : '还款成功'));
                }
            }
        }


        include handler('template')->file('@wap/my_bill_nm');

    }


    function Bill()
    {
        $this->Title = __('消费详单');
        $yanzheng = logic("yanzheng")->GetOne(user()->get(id));
        $usermoney = logic('me')->money()->log();

        foreach ($usermoney as $key => $value) {
            $info = $value;
            $intro = $value['intro'];
            if ($value['name'] == 'zn' || $value['name'] == 'zz') {
                $zhanzhuanginfo = logic('zhanneilist')->GetOne($value['intro']);
                if ($zhanzhuanginfo['money_type'] == 1) {
                    $prefix = 'USD';
                    $$usermoney[$key]['is_dollar'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 2) {
                    $prefix = "HKD";
                    $$usermoney[$key]['is_hkdollar'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 4) {
                    $prefix = "JPY";
                    $$usermoney[$key]['is_jpy'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 5) {
                    $prefix = "KRW";
                    $$usermoney[$key]['is_krw'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 6) {
                    $prefix = "GBP";
                    $$usermoney[$key]['is_gbp'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 7) {
                    $prefix = "AUD";
                    $$usermoney[$key]['is_aud'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 8) {
                    $prefix = "CAD";
                    $$usermoney[$key]['is_cad'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 9) {
                    $prefix = "CHF";
                    $$usermoney[$key]['is_chf'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 10) {
                    $prefix = "NZD";
                    $$usermoney[$key]['is_nzd'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 11) {
                    $prefix = "SGD";
                    $$usermoney[$key]['is_sgd'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 12) {
                    $prefix = "HKC";
                    $$usermoney[$key]['is_hkc'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 13) {
                    $prefix = "CNY";
                    $$usermoney[$key]['is_money'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 14) {
                    $prefix = "BTC";
                    $$usermoney[$key]['is_btc'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 15) {
                    $prefix = "ETH";
                    $$usermoney[$key]['is_eth'] = 1;
                } elseif ($zhanzhuanginfo['money_type'] == 3) {
                    $prefix = "EUR";
                    $$usermoney[$key]['is_euro'] = 1;
                } else {
                    $prefix = 'CNY';
                }
                if ($zhanzhuanginfo['owner'] == user()->get('id')) {
                    $zhanzhuanginfo[tousername] = user($zhanzhuanginfo['touid'])->get("name");
                    $zhanzhuanginfo['info'] = "
						<b>收款人：</b>$zhanzhuanginfo[tousername]
                        <br>
						<b>金额：</b>{$prefix}" . number_format($zhanzhuanginfo[value], 2, '.', '') . "元
						<br>
						<b>付款留言：</b>$zhanzhuanginfo[mark]
						<br>
						<b>手续费率：</b>" . number_format($zhanzhuanginfo['sxfl'], 2, '.', '') . "%
                        <br>
						<b>手续费：</b>{$prefix}" . ($zhanzhuanginfo[value] - $zhanzhuanginfo[tovalue]) . "元
                        <br>
						<b>实际到账：</b>{$prefix}" . number_format($zhanzhuanginfo[tovalue], 2, '.', '') . "元
						";
                } else if ($zhanzhuanginfo['touid'] == user()->get('id')) {
                    $zhanzhuanginfo[sername] = user($zhanzhuanginfo['owner'])->get("name");
                    $zhanzhuanginfo['info'] = "
	        	  	   <b>到账时间：</b>" . date("Y-m-d:H:i:s", $zhanzhuanginfo[addtime]) . "
                       <br>
						<b>付款人：</b>$zhanzhuanginfo[username]
						<br>
						<b>金额：</b>{$prefix}" . number_format($zhanzhuanginfo[tovalue], 2, '.', '') . "元
						<br>
						<b>付款人留言：</b>$zhanzhuanginfo[mark]

						";
                }
                $usermoney[$key]['info'] = $zhanzhuanginfo['info'];
            } elseif ($value['name'] == 'cp') {
                $orderinfo = logic('order')->GetOne($value['intro']);

                $usermoney[$key]['intro'] = "
	        	  	   <b>到账时间：</b>" . date("Y-m-d:H:i:s", $orderinfo[paytime]) . "
                       <br>
						<b>购买人：</b>" . user($orderinfo['userid'])->get('name') . "
						<br>
						<b>商品名称：</b>" . $orderinfo['product']['name'] . "
                        <br>
                        <b>流水号：</b>" . $intro . "

						";
                $usermoney[$key]['name'] = "卖出商品";
            } elseif ($value['name'] == 'djq') {
                $usermoney[$key]['name'] = "卖出团购券";
                $orderinfo = logic('order')->GetOne($value['intro']);

                $usermoney[$key]['intro'] = "
	        	  	   <b>到账时间：</b>" . date("Y-m-d:H:i:s", $orderinfo[paytime]) . "
						<br>
                        <b>购买人：</b>" . user($orderinfo['userid'])->get('name') . "
						<br>
						<b>商品名称：</b>" . $orderinfo['product']['name'] . "
                        <br>
                        <b>流水号：</b>" . $intro . "

						";

            } elseif ($value['name'] == 'hkcz') {

                $usermoney[$key]['name'] = "汇款充值";
                $sql = 'select * from ' . TABLE_PREFIX . 'tttuangou_recharge_order where orderid = \'' . $info['intro'] . '\'';
                $query = $this->DatabaseHandler->Query($sql);
                $ticket = $query->GetRow();


                $usermoney[$key]['intro'] = "
        		  <b>申请时间：</b>" . date("Y-m-d H:i", $ticket[createtime]) . "
        		  <br>
	        	  	   <b>到账时订：</b>" . date("Y-m-d H:i", $ticket[paytime]) . "
						<br>
						<b>订单号：</b>" . $ticket[orderid] . "


						";

            } elseif ($value['name'] == '银行转账') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne($value['intro']);
                if (!empty($zhanzhuanginfo)) {
                    $usermoney[$key]['intro'] = "
                		  <b>收款银行：</b>" . $zhanzhuanginfo['yhkinfo'] . "<br><b>收款人帐号：</b>" . $zhanzhuanginfo['yhkkh'] . "
                		  <br>
                          <b>收款人姓名：</b>" . $zhanzhuanginfo['yhkname'] . "
                          <br>
                		  <b>金额：</b>￥" . number_format($zhanzhuanginfo['value'], 2, '.', '') . "元<br/><b>时间：</b>" . date('Y-m-d H:i', $zhanzhuanginfo['addtime']) .
                        "<br/><b>手续费率：</b>" . $zhanzhuanginfo['sxhl'] . '%<br/>' . "<b>手续费：</b>￥" . number_format($zhanzhuanginfo['sxfl'], 2, '.', '') . '元<br/>' .
                        "<b>实际到账：</b>￥" . number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '') . '元<br/>' .
                        "<b>备注：</b>" . $zhanzhuanginfo['mark'] .
                        "<br/><b>状态：</b>" . ($zhanzhuanginfo['statue'] == 1 ? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                }
            } elseif ($value['name'] == '国际转账' || $value['name'] == '港币汇款' || $value['name'] == '欧元汇款' || $value['name'] == '日元汇款' || $value['name'] == '韩元汇款' || $value['name'] == '英镑汇款' || $value['name'] == '澳元汇款' || $value['name'] == '加元汇款' || $value['name'] == '瑞郎汇款' || $value['name'] == '新西兰元汇款' || $value['name'] == '新加坡元汇款' || $value['name'] == '香港币汇款' || $value['name'] == '比特币汇款' || $value['name'] == '以太币汇款' || $value['name'] == '人民币汇款' || $value['name'] == '美元汇款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne2($value['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne2($zhanzhuanginfo['yhkid']);
                if ($zhanzhuanginfo['is_dollar'] == 1) {
                    $prefix = 'USD';
                } elseif ($zhanzhuanginfo['is_hkdollar'] == 1) {
                    $prefix = "HKD";
                } elseif ($zhanzhuanginfo['is_jpy'] == 1) {
                    $prefix = "JPY";
                } elseif ($zhanzhuanginfo['is_krw'] == 1) {
                    $prefix = "KRW";
                } elseif ($zhanzhuanginfo['is_gbp'] == 1) {
                    $prefix = "GBP";
                } elseif ($zhanzhuanginfo['is_aud'] == 1) {
                    $prefix = "AUD";
                } elseif ($zhanzhuanginfo['is_cad'] == 1) {
                    $prefix = "CAD";
                } elseif ($zhanzhuanginfo['is_chf'] == 1) {
                    $prefix = "CHF";
                } elseif ($zhanzhuanginfo['is_nzd'] == 1) {
                    $prefix = "NZD";
                } elseif ($zhanzhuanginfo['is_sgd'] == 1) {
                    $prefix = "SGD";
                } elseif ($zhanzhuanginfo['is_hkc'] == 1) {
                    $prefix = "HKC";
                } elseif ($zhanzhuanginfo['is_btc'] == 1) {
                    $prefix = "BTC";
                } elseif ($zhanzhuanginfo['is_eth'] == 1) {
                    $prefix = "ETH";
                } elseif ($zhanzhuanginfo['is_money'] == 1) {
                    $prefix = "CNY";
                } elseif ($zhanzhuanginfo['is_euro'] == 1) {
                    $prefix = "EUR";
                } else {
                    $prefix = "CNY";
                }
                if (!empty($zhanzhuanginfo)) {
                    $usermoney[$key]['intro'] = "
                		  <b>收款银行：</b>" . $yinhangkainfo['khcity'] . $yinhangkainfo['khcc'] . "<br><b>收款帐号：</b>" . $yinhangkainfo['cardno'] . "
                		  <br>
                          <b>收款人姓名：</b>" . $yinhangkainfo['name'] . "
                          <br>
                		  <b>汇款金额：</b>{$prefix}" . number_format($zhanzhuanginfo['value'], 2, '.', '') . "元<br/><b>时间：</b>" . date('Y-m-d H:i', $zhanzhuanginfo['addtime']) .
                        "<br/><b>手续费率：</b>" . ($zhanzhuanginfo['is_sxf'] == 1 ? $zhanzhuanginfo['sxhl'] : '0') . '%<br/>' . "<b>手续费：</b>{$prefix}" . ($zhanzhuanginfo['is_sxf'] == 1 ? number_format($zhanzhuanginfo['sxfl'], 2, '.', '') : '0.00') . '元<br/>' .
                        "<b>实际到账：</b>{$prefix}" . ($zhanzhuanginfo['is_sxf'] == 1 ? number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '') : number_format($zhanzhuanginfo['value'], 2, '.', '')) . '元<br/>' .
                        "<b>收取手续费：</b>" . ($zhanzhuanginfo['is_sxf'] == 1 ? '是' : '否') .
                        "<br/><b>付款人留言：</b>" . $zhanzhuanginfo['message'] .
                        "<br/><b>汇款用途：</b>" . $zhanzhuanginfo['yongtu'] .
                        "<br/><b>备注：</b>" . $zhanzhuanginfo['mark'] .
                        "<br/><b>状态：</b>" . ($zhanzhuanginfo['statue'] == 1 ? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                }
            } elseif ($value['name'] == '信用卡还款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne3($value['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne3($zhanzhuanginfo['yhkid']);

                if (!empty($zhanzhuanginfo)) {
                    $usermoney[$key]['intro'] = "
                		  <b>开卡行：</b>" . $yinhangkainfo['kaihuhang'] . "<br><b>卡号：</b>" . $yinhangkainfo['kahao'] . "
                		  <br>
                          <b>开户名：</b>" . $yinhangkainfo['name'] . "
                          <br>
                		  <b>还款金额：</b>￥" . number_format($zhanzhuanginfo['value'], 2, '.', '') . "元<br/><b>时间：</b>" . date('Y-m-d H:i', $zhanzhuanginfo['addtime']) .
                        "<br/><b>手续费率：</b>" . $zhanzhuanginfo['sxhl'] . '%<br/>' . "<b>手续费：</b>￥" . number_format($zhanzhuanginfo['sxfl'], 2, '.', '') . '元<br/>' .
                        "<b>实际付款：</b>￥" . number_format(($zhanzhuanginfo['value'] + $zhanzhuanginfo['sxfl']), 2, '.', '') . '元<br/>' .
                        "<b>备注：</b>" . $zhanzhuanginfo['mark'] .
                        "<br/><b>状态：</b>" . ($zhanzhuanginfo['statue'] == 1 ? '还款中' : ($zhanzhuanginfo['statue'] == 3 ? '还款失败' : '还款成功'));
                }
            }
        }
        $a = false;
        if (stristr($_SERVER['HTTP_VIA'], "wap")) {
            $a = true;
        } elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            $a = true;
        } elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $a = true;
        } else {
            $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
            $mobileList = array('windows phone', 'mac os', 'iphone', 'android', 'ipad');
            foreach ($mobileList as $value) {
                if (strpos($agent, $value) !== false) {
                    $a = true;
                }
            }

            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
                $clientkeywords = array(
                    'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-'
                , 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu',
                    'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini',
                    'operamobi', 'opera mobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile', 'huawei'
                );
// 从HTTP_USER_AGENT中查找手机浏览器的关键字
                if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", $userAgent) && strpos($userAgent, 'ipad') === false) {
                    $a = true;
                }
            }
        }
        if (!$a) {
            include handler('template')->file('my_bill');
        } else {
            include handler('template')->file('@wap/my_bill');
        }
    }

    function checkwap()
    {
        $a = false;
        if (stristr($_SERVER['HTTP_VIA'], "wap")) {
            $a = true;
        } elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            $a = true;
        } elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $a = true;
        } else {
            $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
            $mobileList = array('windows phone', 'mac os', 'iphone', 'android', 'ipad');
            foreach ($mobileList as $value) {
                if (strpos($agent, $value) !== false) {
                    $a = true;
                }
            }

            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
                $clientkeywords = array(
                    'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-'
                , 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu',
                    'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini',
                    'operamobi', 'opera mobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile', 'huawei'
                );
// 从HTTP_USER_AGENT中查找手机浏览器的关键字
                if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", $userAgent) && strpos($userAgent, 'ipad') === false) {
                    $a = true;
                }
            }
        }
        return $a;
    }

    function Setting()
    {
        $this->Title = __('账户设置');
        $user = user()->get();
        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));
        if ($yanzheng['statue'] == 2) {
            $user['xingming'] = $yanzheng['idname'];
        } else {
            $user['xingming'] = '未验证';
        }
        include handler('template')->file('my_setting');
    }

    function Address()
    {
        $this->Title = __('收货地址');
        $addressList = logic('address')->GetList(user()->get('id'));
        include handler('template')->file('my_address');
    }

    function Doyanzheng()
    {
        $uid = user()->get('id');
        $post['owner'] = $uid;
        $post['idname'] = trim($_POST['name']);
        $post['idno'] = trim($_POST['idcard']);
        $post['xingzhi'] = (int)$_POST['xingzhi'];
        $id = (int)$_POST['y_id'];
        if (!$post['xingzhi']) {
            $this->Messager("性质不能为空", "?mod=me&code=yanzheng");
        }
        if (!$post['idname']) {
            $this->Messager("姓名不能为空", "?mod=me&code=yanzheng");
        }
        if (!$post['idno']) {
            $this->Messager("身份证号不能为空", "?mod=me&code=yanzheng");
        }

        $sql = 'select  owner from ' . TABLE_PREFIX . 'system_members_yanzheng where idno = "' . $post['idno'] . '"  ';
        $query = $this->DatabaseHandler->Query($sql);
        $user = $query->GetRow();
        if ($user) {
            if ($user['owner'] != $uid) {
                $this->Messager("此身份证号已经注册！，提交失败", "?mod=me&code=yanzheng");
            }
        }


        $targetPath = 'uploads/sfz';
        $time = time();
        $fileTypes = array('jpg', 'jpeg', 'gif', 'png', "JPG", "JPEG", "GIF", "PNG"); // File extensions

        $tempFile = $_FILES['idimagea']['tmp_name'];
        $fileParts = pathinfo($_FILES['idimagea']['name']);
        $targetFile = rtrim($targetPath, '/') . '/' . $time . md5($_FILES['idimagea']['name']) . "." . $fileParts['extension'];
        if (in_array($fileParts['extension'], $fileTypes)) {

            if (move_uploaded_file($tempFile, $targetFile)) {
                $post['idimagea'] = $targetFile;
            } else {
                $this->Messager("上传图片失败", "?mod=me&code=zhuanzhang");
                exit;
            }
        } elseif (!$id) {

            $this->Messager("请上传图片格式", "?mod=me&code=yanzheng");
        }

        $time = time();
        $tempFile = $_FILES['idimageb']['tmp_name'];
        if ($tempFile) {
            $fileParts = pathinfo($_FILES['idimageb']['name']);
            $targetFile = rtrim($targetPath, '/') . '/' . $time . md5($_FILES['idimageb']['name']) . "." . $fileParts['extension'];
            if (in_array($fileParts['extension'], $fileTypes)) {

                if (move_uploaded_file($tempFile, $targetFile)) {
                    $post['idimageb'] = $targetFile;
                } else {
                    $this->Messager("上传图片失败", "?mod=me&code=yanzheng");
                    exit;
                }
            } elseif (!$id) {
                $this->Messager("请上传图片格式", "?mod=me&code=yanzheng");
            }
        } elseif ($_POST['idimageb']) {
            $post['idimageb'] = trim($_POST['idimageb']);
        }
        $time = time();
        $tempFile = $_FILES['idimagec']['tmp_name'];
        $fileParts = pathinfo($_FILES['idimagec']['name']);
        $targetFile = rtrim($targetPath, '/') . '/' . $time . md5($_FILES['idimagec']['name']) . "." . $fileParts['extension'];
        if (in_array($fileParts['extension'], $fileTypes)) {

            if (move_uploaded_file($tempFile, $targetFile)) {
                $post['idimagec'] = $targetFile;
            } else {
                $this->Messager("上传图片失败", "?mod=me&code=zhuanzhang");
                exit;
            }
        } elseif (!$id) {

            $this->Messager("请上传图片格式", "?mod=me&code=yanzheng");
        }
        $post['addtime'] = time();


        $post['statue'] = 1;
        if (!$id) {
            logic("yanzheng")->Add($uid, $post);
        } else {
            logic("yanzheng")->Update($id, $post, $uid);
        }
        logic('push')->addi('sms', user(1)->get("phone"), array('content' => "用户:" . $post['idname'] . "申请身份验证"));
        $a = $this->checkwap();
        if (!$a) {
            $this->Messager("申请成功，我们将在三个工作日内验证", "?mod=me&code=bill");
        } else {
            header('Location: ' . rewrite('?mod=me&code=wapbill'));
        }
    }

    function Zhuanzhang()
    {

        $this->Title = __('转账支付');

        $addressList = logic('yinhangka')->GetList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        if (stristr($_SERVER['HTTP_VIA'], "wap")) {
            $a = true;
        } elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            $a = true;
        } elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $a = true;
        } else {
            $a = false;
        }

        if (!$a) {
            include handler('template')->file('my_zhuanzhang');
        } else {
            include handler('template')->file('@wap/my_zhuanzhang');
        }
    }


    function wapzhuanzhang()
    {

        $this->Title = __('提现');

        $addressList = logic('yinhangka')->GetList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        include handler('template')->file('@wap/my_zhuanzhang');
    }

    function xyk()
    {

        $this->Title = __('信用卡还款');

        $addressList = logic('yinhangka')->GetXinyongKaList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        if (stristr($_SERVER['HTTP_VIA'], "wap")) {
            $a = true;
        } elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            $a = true;
        } elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $a = true;
        } else {
            $a = false;
        }
        if (!$a) {
            include handler('template')->file('my_xyk');
        } else {
            include handler('template')->file('@wap/my_xyk');
        }
    }

    function wapxyk()
    {

        $this->Title = __('还款');

        $addressList = logic('yinhangka')->GetXinyongKaList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;
        $payto = false;
        if ($_GET['payto']) {
            if (!$scr = logic('yanzheng')->GetOneByUsername($_GET['payto'])) {
                exit('invalid pay user.');
            }
            $payto = true;
            $scryz = logic('yanzheng')->GetOne($scr['uid']);
        }
        $ac = logic('yanzheng')->GetOneAC(user()->get('id'));
        ini_set("display_errors", "On");//打开错误提示
        ini_set("error_reporting", E_ALL);//显示所有错误
        include handler('template')->file('@wap/my_xyk');
    }

    function wapxykhk()
    {
        header('location:/?mod=me&code=contracttrans');
        exit;
        $this->Title = __('信用卡还款');

        $addressList = logic('yinhangka')->GetXinyongKaList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        include handler('template')->file('@wap/my_xykhk');
    }

    function sp()
    {

        $this->Title = __('购物');

        $addressList = logic('yinhangka')->GetXinyongKaList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        if (stristr($_SERVER['HTTP_VIA'], "wap")) {
            $a = true;
        } elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            $a = true;
        } elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $a = true;
        } else {
            $a = false;
        }
        if (!$a) {
            include handler('template')->file('my_sp');
        } else {
            include handler('template')->file('@wap/my_sp');
        }

    }

    function wapsp()
    {

        $this->Title = __('首页');

        $addressList = logic('yinhangka')->GetXinyongKaList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        include handler('template')->file('@wap/my_sp');

    }

    function wapdetail()
    {

        $clientUser = get('u', 'int');
        if ($clientUser != '') {
            handler('cookie')->setVar('finderid', $clientUser);
            handler('cookie')->setVar('findtime', time());
        }
        $data = logic('product')->display();
        $data || header('Location: ' . rewrite('?mod=subscribe&code=mail'));
        $product = $data['product'];
        $this->Title = $data['mutiView'] ? '' : $product['name'];
        include handler('template')->file('detailwapp');
    }

    function Yanzheng()
    {
        $this->Title = __('身份验证');

        $a = $this->checkwap();
        $userid = logic('yanzheng')->GetOne(user()->get('id'));
        if (!$a) {
            include handler('template')->file('my_yanzheng');
        } else {
            include handler('template')->file('@wap/my_yanzheng');
        }
    }

    function Wbsk()
    {
        $this->Title = __('外币收付');


        include handler('template')->file('my_wbsk');
    }

    function wbsk_save()
    {
        $this->Title = __('外币收付');

        $foreign_rate = $this->product_config['foreign_rate'];
        $default_purchase_cash = $this->product_config['default_purchase_cash'];
        $default_spot_selling_rate = $this->product_config['default_spot_selling_rate'];
        $default_hkd_purchase_cash = $this->product_config['default_hkd_purchase_cash'];
        $default_hkd_spot_selling_rate = $this->product_config['default_hkd_spot_selling_rate'];
        $default_eur_purchase_cash = $this->product_config['default_eur_purchase_cash'];
        $default_eur_spot_selling_rate = $this->product_config['default_eur_spot_selling_rate'];
        $default_jpy_purchase_cash = $this->product_config['default_jpy_purchase_cash'];
        $default_jpy_spot_selling_rate = $this->product_config['default_jpy_spot_selling_rate'];
        $default_krw_purchase_cash = $this->product_config['default_krw_purchase_cash'];
        $default_krw_spot_selling_rate = $this->product_config['default_krw_spot_selling_rate'];
        $default_gbp_purchase_cash = $this->product_config['default_gbp_purchase_cash'];
        $default_gbp_spot_selling_rate = $this->product_config['default_gbp_spot_selling_rate'];
        $default_aud_purchase_cash = $this->product_config['default_aud_purchase_cash'];
        $default_aud_spot_selling_rate = $this->product_config['default_aud_spot_selling_rate'];
        $default_cad_purchase_cash = $this->product_config['default_cad_purchase_cash'];
        $default_cad_spot_selling_rate = $this->product_config['default_cad_spot_selling_rate'];
        $default_chf_purchase_cash = $this->product_config['default_chf_purchase_cash'];
        $default_chf_spot_selling_rate = $this->product_config['default_chf_spot_selling_rate'];
        $default_nzd_purchase_cash = $this->product_config['default_nzd_purchase_cash'];
        $default_nzd_spot_selling_rate = $this->product_config['default_nzd_spot_selling_rate'];
        $default_sgd_purchase_cash = $this->product_config['default_sgd_purchase_cash'];
        $default_sgd_spot_selling_rate = $this->product_config['default_sgd_spot_selling_rate'];
        $default_hkc_purchase_cash = $this->product_config['default_hkc_purchase_cash'];
        $default_hkc_spot_selling_rate = $this->product_config['default_hkc_spot_selling_rate'];
        $default_btc_purchase_cash = $this->product_config['default_btc_purchase_cash'];
        $default_btc_spot_selling_rate = $this->product_config['default_btc_spot_selling_rate'];
        $default_eth_purchase_cash = $this->product_config['default_eth_purchase_cash'];
        $default_eth_spot_selling_rate = $this->product_config['default_eth_spot_selling_rate'];
        //

        $usa_hkd_purchase_cash = $this->product_config['usa_hkd_purchase_cash'];
        $usa_hkd_spot_selling_rate = $this->product_config['usa_hkd_spot_selling_rate'];
        $usa_eur_purchase_cash = $this->product_config['usa_eur_purchase_cash'];
        $usa_eur_spot_selling_rate = $this->product_config['usa_eur_spot_selling_rate'];
        $usa_jpy_purchase_cash = $this->product_config['usa_jpy_purchase_cash'];
        $usa_jpy_spot_selling_rate = $this->product_config['usa_jpy_spot_selling_rate'];
        $usa_krw_purchase_cash = $this->product_config['usa_krw_purchase_cash'];
        $usa_krw_spot_selling_rate = $this->product_config['usa_krw_spot_selling_rate'];
        $usa_gbp_purchase_cash = $this->product_config['usa_gbp_purchase_cash'];
        $usa_gbp_spot_selling_rate = $this->product_config['usa_gbp_spot_selling_rate'];
        $usa_aud_purchase_cash = $this->product_config['usa_aud_purchase_cash'];
        $usa_aud_spot_selling_rate = $this->product_config['usa_aud_spot_selling_rate'];
        $usa_cad_purchase_cash = $this->product_config['usa_cad_purchase_cash'];
        $usa_cad_spot_selling_rate = $this->product_config['usa_cad_spot_selling_rate'];
        $usa_chf_purchase_cash = $this->product_config['usa_chf_purchase_cash'];
        $usa_chf_spot_selling_rate = $this->product_config['usa_chf_spot_selling_rate'];
        $usa_nzd_purchase_cash = $this->product_config['usa_nzd_purchase_cash'];
        $usa_nzd_spot_selling_rate = $this->product_config['usa_nzd_spot_selling_rate'];
        $usa_sgd_purchase_cash = $this->product_config['usa_sgd_purchase_cash'];
        $usa_sgd_spot_selling_rate = $this->product_config['usa_sgd_spot_selling_rate'];
        $usa_hkc_purchase_cash = $this->product_config['usa_hkc_purchase_cash'];
        $usa_hkc_spot_selling_rate = $this->product_config['usa_hkc_spot_selling_rate'];
        $usa_btc_purchase_cash = $this->product_config['usa_btc_purchase_cash'];
        $usa_btc_spot_selling_rate = $this->product_config['usa_btc_spot_selling_rate'];
        $usa_eth_purchase_cash = $this->product_config['usa_eth_purchase_cash'];
        $usa_eth_spot_selling_rate = $this->product_config['usa_eth_spot_selling_rate'];

        $money_a = $this->Post("money_a", 'int');
        $money_b = $this->Post("money_b", 'int');
        // $money = $money_a == 1 ? user()->get('dollar') : user()->get('money');
        $money = user()->get('money');

        if ($money_a == 1) {
            $money = user()->get('dollar');
        } else if ($money_a == 3) {
            $money = user()->get('hkdollar');
        } else if ($money_a == 4) {
            $money = user()->get('euro');
        } else if ($money_a == 5) {
            $money = user()->get('jpy');
        } else if ($money_a == 6) {
            $money = user()->get('krw');
        } else if ($money_a == 7) {
            $money = user()->get('gbp');
        } else if ($money_a == 8) {
            $money = user()->get('aud');
        } else if ($money_a == 9) {
            $money = user()->get('cad');
        } else if ($money_a == 10) {
            $money = user()->get('chf');
        } else if ($money_a == 11) {
            $money = user()->get('nzd');
        } else if ($money_a == 12) {
            $money = user()->get('sgd');
        } else if ($money_a == 13) {
            $money = user()->get('hkc');
        } else if ($money_a == 14) {
            $money = user()->get('money');
        } else if ($money_a == 15) {
            $money = user()->get('btc');
        } else if ($money_a == 16) {
            $money = user()->get('eth');
        }

        $exchange_money = $this->Post("exchange_money", 'float');

        $sxf_val = (!empty($foreign_rate) && $foreign_rate > 0) ? ($exchange_money * ($foreign_rate / 100)) : 0;
        $sxf_val = number_format($sxf_val, 2, '.', '');
        if ($money_a == $money_b) {
            $this->Messager("持有货币和兑换货币不能重复!", "?mod=me&code=wbsk");
            exit;
        } else if (empty($exchange_money)) {
            $this->Messager("请输入兑换金额!", "?mod=me&code=wbsk");
            exit;
        } else if ($money < ($exchange_money + $sxf_val)) {
            $this->Messager("持有货币金额不足!", "?mod=me&code=wbsk");
            exit;
        } else {
            $uid = user()->get('id');
            $sxf = $sxf_val;
            $dhje = 0.00;
            $date = time();
            // $type = $money_a == 1 ? 1 : 0;//1:美元换人民币 0:人民币换美元 2:港币换人民币 3：人民币换港币 4：欧元换人民币 5：人民币换欧元  6：日元换人民币 7：人民币换日元  8：韩元兑人民币 9：人民币换韩元 10：英镑兑人民币 11：人民币换英镑 12：澳元兑人民币 13：人民币换澳元 14：加元兑人民币 15：人民币换加元 16：瑞郎兑人民币 17：人民币换瑞郎 18：新西兰元兑人民币 19：人民币换新西兰元 20：新加坡元兑人民币 21：人民币换新加坡元 22：香港币兑人民币 23：人民币换香港币 24：香港币兑比特币 25：比特币换香港币 26：香港币兑以太币 27：以太币换香港币
            $type = 0;
            $rate = 0;
            $dhje = 0;
            if ($money_a == 1) {
                if ($money_b == 2) {
                    $type = 1;
                    $dhje = ($exchange_money * ($default_purchase_cash / 100));
                    $rate = ($default_purchase_cash);
                }
                if ($money_b == 3) {
                    $type = 33;
                    $dhje = ($exchange_money * ($usa_hkd_spot_selling_rate));
                    $rate = ($usa_hkd_spot_selling_rate);
                }
                if ($money_b == 4) {
                    $type = 24;
                    $dhje = ($exchange_money / ($usa_eur_spot_selling_rate));
                    $rate = ($usa_eur_spot_selling_rate);
                }
                if ($money_b == 5) {
                    $type = 25;
                    $dhje = ($exchange_money * ($usa_jpy_spot_selling_rate));
                    $rate = ($usa_jpy_spot_selling_rate);
                }
                if ($money_b == 7) {
                    $type = 26;
                    $dhje = ($exchange_money / ($usa_gbp_spot_selling_rate));
                    $rate = ($usa_gbp_spot_selling_rate);
                }
                if ($money_b == 8) {
                    $type = 27;
                    $dhje = ($exchange_money / ($usa_aud_spot_selling_rate));
                    $rate = ($usa_aud_spot_selling_rate);
                }
                if ($money_b == 9) {
                    $type = 28;
                    $dhje = ($exchange_money * ($usa_cad_spot_selling_rate));
                    $rate = ($usa_cad_spot_selling_rate);
                }
                if ($money_b == 10) {
                    $type = 29;
                    $dhje = ($exchange_money * ($usa_chf_spot_selling_rate));
                    $rate = ($usa_chf_spot_selling_rate);
                }
                if ($money_b == 11) {
                    $type = 30;
                    $dhje = ($exchange_money / ($usa_nzd_spot_selling_rate));
                    $rate = ($usa_nzd_spot_selling_rate);
                }
                if ($money_b == 12) {
                    $type = 31;
                    $dhje = ($exchange_money * ($usa_sgd_spot_selling_rate));
                    $rate = ($usa_sgd_spot_selling_rate);
                }
                if ($money_b == 13) {
                    $type = 32;
                    $dhje = ($exchange_money);
                    $rate = ($usa_hkc_purchase_cash);
                }
                if ($money_b == 14) {
                    $type = 33;
                    $dhje = ($exchange_money);
                    $rate = ($usa_btc_purchase_cash);
                }
                if ($money_b == 15) {
                    $type = 34;
                    $dhje = ($exchange_money);
                    $rate = ($usa_eth_purchase_cash);
                }
            } elseif ($money_a == 3) {
                if ($money_b == 1) {
                    $type = 53;
                    $dhje = ($exchange_money / ($usa_hkd_purchase_cash));
                    $rate = ($usa_hkd_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 2;
                    $dhje = ($exchange_money * ($default_hkd_purchase_cash / 100));
                    $rate = ($default_hkd_purchase_cash);
                }
                if ($money_b == 13) {
                    $type = 62;
                    $dhje = ($exchange_money / ($usa_hkd_purchase_cash));
                    $rate = ($usa_hkd_purchase_cash);
                }
            } elseif ($money_a == 4) {
                if ($money_b == 1) {
                    $type = 44;
                    $dhje = ($exchange_money * ($usa_eur_purchase_cash));
                    $rate = ($usa_eur_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 4;
                    $dhje = ($exchange_money * ($default_eur_purchase_cash / 100));
                    $rate = ($default_eur_purchase_cash);
                }
                if ($money_b == 13) {
                    $type = 54;
                    $dhje = ($exchange_money * ($usa_eur_purchase_cash));
                    $rate = ($usa_eur_purchase_cash);
                }
            } elseif ($money_a == 5) {
                if ($money_b == 1) {
                    $type = 45;
                    $dhje = ($exchange_money / ($usa_jpy_purchase_cash));
                    $rate = ($usa_jpy_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 6;
                    $dhje = ($exchange_money * ($default_jpy_purchase_cash / 100));
                    $rate = ($default_jpy_purchase_cash);
                }
                if ($money_b == 13) {
                    $type = 55;
                    $dhje = ($exchange_money / ($usa_jpy_purchase_cash));
                    $rate = ($usa_jpy_purchase_cash);
                }
            } elseif ($money_a == 6) {
                $type = 8;
                $dhje = ($exchange_money * ($default_krw_purchase_cash / 100));
                $rate = ($default_krw_purchase_cash);
            } elseif ($money_a == 7) {
                if ($money_b == 1) {
                    $type = 46;
                    $dhje = ($exchange_money * ($usa_gbp_purchase_cash));
                    $rate = ($usa_gbp_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 10;
                    $dhje = ($exchange_money * ($default_gbp_purchase_cash / 100));
                    $rate = ($default_gbp_purchase_cash);
                }
                if ($money_b == 13) {
                    $type = 56;
                    $dhje = ($exchange_money * ($usa_gbp_purchase_cash));
                    $rate = ($usa_gbp_purchase_cash);
                }
            } elseif ($money_a == 8) {
                if ($money_b == 1) {
                    $type = 47;
                    $dhje = ($exchange_money * ($usa_aud_purchase_cash));
                    $rate = ($usa_aud_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 12;
                    $dhje = ($exchange_money * ($default_aud_purchase_cash / 100));
                    $rate = ($default_aud_purchase_cash);
                }
                if ($money_b == 13) {
                    $type = 57;
                    $dhje = ($exchange_money * ($usa_aud_purchase_cash));
                    $rate = ($usa_aud_purchase_cash);
                }
            } elseif ($money_a == 9) {
                if ($money_b == 1) {
                    $type = 48;
                    $dhje = ($exchange_money / ($usa_cad_purchase_cash));
                    $rate = ($usa_cad_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 14;
                    $dhje = ($exchange_money * ($default_cad_purchase_cash / 100));
                    $rate = ($default_cad_purchase_cash);
                }
                if ($money_b == 13) {
                    $type = 58;
                    $dhje = ($exchange_money / ($usa_cad_purchase_cash));
                    $rate = ($usa_cad_purchase_cash);
                }
            } elseif ($money_a == 10) {
                if ($money_b == 1) {
                    $type = 49;
                    $dhje = ($exchange_money / ($usa_chf_purchase_cash));
                    $rate = ($usa_chf_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 16;
                    $dhje = ($exchange_money * ($default_chf_purchase_cash / 100));
                    $rate = ($default_chf_purchase_cash);
                }
                if ($money_b == 13) {
                    $type = 59;
                    $dhje = ($exchange_money / ($usa_chf_purchase_cash));
                    $rate = ($usa_chf_purchase_cash);
                }
            } elseif ($money_a == 11) {
                if ($money_b == 1) {
                    $type = 50;
                    $dhje = ($exchange_money * ($usa_nzd_purchase_cash));
                    $rate = ($usa_nzd_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 18;
                    $dhje = ($exchange_money * ($default_nzd_purchase_cash / 100));
                    $rate = ($default_nzd_purchase_cash);
                }
                if ($money_b == 13) {
                    $type = 60;
                    $dhje = ($exchange_money * ($usa_nzd_purchase_cash));
                    $rate = ($usa_nzd_purchase_cash);
                }
            } elseif ($money_a == 12) {
                if ($money_b == 1) {
                    $type = 51;
                    $dhje = ($exchange_money / ($usa_sgd_purchase_cash));
                    $rate = ($usa_sgd_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 20;
                    $dhje = ($exchange_money * ($default_sgd_purchase_cash / 100));
                    $rate = ($default_sgd_purchase_cash);
                }
                if ($money_b == 13) {
                    $type = 61;
                    $dhje = ($exchange_money / ($usa_sgd_purchase_cash));
                    $rate = ($usa_sgd_purchase_cash);
                }
            } elseif ($money_a == 13) {
                // $type=22;
                if ($money_b == 1) {
                    $type = 42;
                    $dhje = ($exchange_money);
                    $rate = ($usa_hkc_purchase_cash);
                }
                if ($money_b == 2) {
                    $type = 22;
                    $dhje = ($exchange_money * ($default_hkc_purchase_cash / 100));
                    $rate = ($default_hkc_purchase_cash);
                }
                if ($money_b == 3) {
                    $type = 43;
                    $dhje = ($exchange_money * ($usa_hkd_spot_selling_rate));
                    $rate = ($usa_hkd_spot_selling_rate);
                }
                if ($money_b == 4) {
                    $type = 34;
                    $dhje = ($exchange_money / ($usa_eur_spot_selling_rate));
                    $rate = ($usa_eur_spot_selling_rate);
                }
                if ($money_b == 5) {
                    $type = 35;
                    $dhje = ($exchange_money * ($usa_jpy_spot_selling_rate));
                    $rate = ($usa_jpy_spot_selling_rate);
                }
                if ($money_b == 7) {
                    $type = 36;
                    $dhje = ($exchange_money / ($usa_gbp_spot_selling_rate));
                    $rate = ($usa_gbp_spot_selling_rate);
                }
                if ($money_b == 8) {
                    $type = 37;
                    $dhje = ($exchange_money / ($usa_aud_spot_selling_rate));
                    $rate = ($usa_aud_spot_selling_rate);
                }
                if ($money_b == 9) {
                    $type = 38;
                    $dhje = ($exchange_money * ($usa_cad_spot_selling_rate));
                    $rate = ($usa_cad_spot_selling_rate);
                }
                if ($money_b == 10) {
                    $type = 39;
                    $dhje = ($exchange_money * ($usa_chf_spot_selling_rate));
                    $rate = ($usa_chf_spot_selling_rate);
                }
                if ($money_b == 11) {
                    $type = 40;
                    $dhje = ($exchange_money / ($usa_nzd_spot_selling_rate));
                    $rate = ($usa_nzd_spot_selling_rate);
                }
                if ($money_b == 12) {
                    $type = 41;
                    $dhje = ($exchange_money * ($usa_sgd_spot_selling_rate));
                    $rate = ($usa_sgd_spot_selling_rate);
                }
                if ($money_b == 13) {
                    $type = 42;
                    $dhje = ($exchange_money * ($usa_btc_spot_selling_rate));
                    $rate = ($usa_btc_spot_selling_rate);
                }
                if ($money_b == 14) {
                    $type = 43;
                    $dhje = ($exchange_money * ($usa_eth_spot_selling_rate));
                    $rate = ($usa_eth_spot_selling_rate);
                }
            } else {
                if ($money_b == 1) {
                    $type = 0;
                    $rate = ($default_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_spot_selling_rate / 100));
                } else if ($money_b == 3) {
                    $type = 3;
                    $rate = ($default_hkd_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_hkd_spot_selling_rate / 100));
                } else if ($money_b == 4) {
                    $type = 5;
                    $rate = ($default_eur_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_eur_spot_selling_rate / 100));
                } else if ($money_b == 5) {
                    $type = 7;
                    $rate = ($default_jpy_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_jpy_spot_selling_rate / 100));
                } else if ($money_b == 6) {
                    $type = 9;
                    $rate = ($default_krw_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_krw_spot_selling_rate / 100));
                } else if ($money_b == 7) {
                    $type = 11;
                    $rate = ($default_gbp_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_gbp_spot_selling_rate / 100));
                } else if ($money_b == 8) {
                    $type = 13;
                    $rate = ($default_aud_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_aud_spot_selling_rate / 100));
                } else if ($money_b == 9) {
                    $type = 15;
                    $rate = ($default_cad_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_cad_spot_selling_rate / 100));
                } else if ($money_b == 10) {
                    $type = 17;
                    $rate = ($default_chf_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_chf_spot_selling_rate / 100));
                } else if ($money_b == 11) {
                    $type = 19;
                    $rate = ($default_nzd_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_nzd_spot_selling_rate / 100));
                } else if ($money_b == 12) {
                    $type = 21;
                    $rate = ($default_sgd_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_sgd_spot_selling_rate / 100));
                } else if ($money_b == 13) {
                    $type = 23;
                    $rate = ($default_hkc_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_hkc_spot_selling_rate / 100));
                } else if ($money_b == 14) {
                    $type = 24;
                    $rate = ($default_btc_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_btc_spot_selling_rate / 100));
                } else if ($money_b == 15) {
                    $type = 25;
                    $rate = ($default_eth_spot_selling_rate);
                    $dhje = ($exchange_money / ($default_eth_spot_selling_rate / 100));
                }
            }
            // $rate = $money_a == 1 ? ($default_purchase_cash/100) : ($default_spot_selling_rate/100);
            // if($money_a == 1) {
            //           $dhje = ($exchange_money * ($default_purchase_cash/100));
            //       } else {
            //          $dhje = ($exchange_money / ($default_spot_selling_rate/100));
            //}

            $post2 = array(
                'userid' => $uid,
                'type' => $type,
                'dhje' => $exchange_money ? number_format($exchange_money, 2, '.', '') : 0.00,
                'rate' => $rate,
                'sxf' => $sxf,
                'sjdhje' => $dhje ? number_format($dhje, 2, '.', '') : 0.00,
                'date' => time()
            );

            $bRet = logic('me')->recordWbsk($post2);
            if ($bRet) {
                $typename = '';
                if ($money_a == 1) {
                    if ($money_b == 2) {
                        $typename = '美元兑换人民币';
                        $fh = 'USD';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 3) {
                        $typename = '美元兑换港币';
                        $fh = 'USD';
                        $fh2 = 'HKD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkdollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 2);
                    }
                    if ($money_b == 4) {
                        $typename = '美元兑换欧元';
                        $fh = 'USD';
                        $fh2 = 'EUR';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_euro' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 3);
                    }
                    if ($money_b == 5) {
                        $typename = '美元兑换日元';
                        $fh = 'USD';
                        $fh2 = 'JPY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_jpy' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 4);
                    }
                    if ($money_b == 7) {
                        $typename = '美元兑换英镑';
                        $fh = 'USD';
                        $fh2 = 'GBP';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_gbp' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 6);
                    }
                    if ($money_b == 8) {
                        $typename = '美元兑换澳元';
                        $fh = 'USD';
                        $fh2 = 'AUD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_aud' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 7);
                    }
                    if ($money_b == 9) {
                        $typename = '美元兑换加元';
                        $fh = 'USD';
                        $fh2 = 'CAD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_cad' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 8);
                    }
                    if ($money_b == 10) {
                        $typename = '美元兑换瑞郎';
                        $fh = 'USD';
                        $fh2 = 'CHF';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_chf' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 9);
                    }
                    if ($money_b == 11) {
                        $typename = '美元兑换新西兰元';
                        $fh = 'USD';
                        $fh2 = 'NZD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_nzd' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 10);
                    }
                    if ($money_b == 12) {
                        $typename = '美元兑换新加坡元';
                        $fh = 'USD';
                        $fh2 = 'SGD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_sgd' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 11);
                    }
                    if ($money_b == 13) {
                        $typename = '美元兑换香港币';
                        $fh = 'USD';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }
                    if ($money_b == 14) {
                        $typename = '比特币兑换香港币';
                        $fh = 'BTC';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_btc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 13);
                    }
                    if ($money_b == 15) {
                        $typename = '以太币兑换香港币';
                        $fh = 'ETH';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_eth' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 14);
                    }

                } else if ($money_a == 3) {
                    if ($money_b == 1) {
                        $typename = '港币兑换美元';
                        $fh = 'HKD';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkdollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 2);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '港币兑换人民币';
                        $fh = 'HKD';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkdollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 2);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 13) {
                        $typename = '港币兑换香港币';
                        $fh = 'HKD';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkdollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 2);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }

                } else if ($money_a == 4) {
                    if ($money_b == 1) {
                        $typename = '欧元兑换美元';
                        $fh = 'EUR';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_euro' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 3);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '欧元兑换人民币';
                        $fh = 'EUR';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_euro' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 3);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 13) {
                        $typename = '欧元兑换香港币';
                        $fh = 'EUR';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_euro' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 3);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }

                } else if ($money_a == 5) {
                    if ($money_b == 1) {
                        $typename = '日元兑换美元';
                        $fh = 'JPY';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_jpy' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 4);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '日元兑换人民币';
                        $fh = 'JPY';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_jpy' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 4);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 13) {
                        $typename = '日元兑换香港币';
                        $fh = 'JPY';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_jpy' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 4);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }

                } else if ($money_a == 6) {
                    $typename = '韩元兑换人民币';
                    $fh = 'KRW';
                    $fh2 = 'CNY';
                    logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                        'name' => $typename,
                        'is_krw' => 1,
                        'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                            "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                            "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                    ), 5);

                    logic('me')->money()->add($post2['sjdhje'], $uid, array(
                        'name' => $typename,
                        'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                            "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                            "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                    ));
                } else if ($money_a == 7) {
                    if ($money_b == 1) {
                        $typename = '英镑兑换美元';
                        $fh = 'GBP';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_gbp' => 1,
                            'intro' => "
                              <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                              <br>
                              <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 6);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                              <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                              <br>
                              <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '英镑兑换人民币';
                        $fh = 'GBP';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_gbp' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 6);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 13) {
                        $typename = '英镑兑换香港币';
                        $fh = 'GBP';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_gbp' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 6);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }
                } else if ($money_a == 8) {
                    if ($money_b == 1) {
                        $typename = '澳元兑换美元';
                        $fh = 'AUD';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_aud' => 1,
                            'intro' => "
                              <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                              <br>
                              <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 7);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                              <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                              <br>
                              <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '澳元兑换人民币';
                        $fh = 'AUD';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_aud' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 7);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 13) {
                        $typename = '澳元兑换香港币';
                        $fh = 'AUD';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_aud' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 7);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }
                } else if ($money_a == 9) {
                    if ($money_b == 1) {
                        $typename = '加元兑换美元';
                        $fh = 'CAD';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_cad' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 8);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '加元兑换人民币';
                        $fh = 'CAD';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_cad' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 8);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 13) {
                        $typename = '加元兑换香港币';
                        $fh = 'CAD';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_cad' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 8);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }
                } else if ($money_a == 10) {
                    if ($money_b == 1) {
                        $typename = '瑞郎兑换美元';
                        $fh = 'CHF';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_chf' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 9);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '瑞郎兑换人民币';
                        $fh = 'CHF';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_chf' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 9);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 13) {
                        $typename = '瑞郎兑换香港币';
                        $fh = 'CHF';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_chf' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 9);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }
                } else if ($money_a == 11) {
                    if ($money_b == 1) {
                        $typename = '新西兰元兑换美元';
                        $fh = 'NZD';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_nzd' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 10);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '新西兰元兑换人民币';
                        $fh = 'NZD';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_nzd' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 10);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 13) {
                        $typename = '新西兰元兑换香港币';
                        $fh = 'NZD';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_nzd' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 10);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }
                } else if ($money_a == 12) {
                    if ($money_b == 1) {
                        $typename = '新加坡元兑换美元';
                        $fh = 'SGD';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_sgd' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 11);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '新加坡元兑换人民币';
                        $fh = 'SGD';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_sgd' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 11);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 13) {
                        $typename = '新加坡元兑换香港币';
                        $fh = 'SGD';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_sgd' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 11);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }
                } else if ($money_a == 13) {
                    if ($money_b == 1) {
                        $typename = '香港币兑换美元';
                        $fh = 'HKC';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    }
                    if ($money_b == 2) {
                        $typename = '香港币兑换人民币';
                        $fh = 'HKC';
                        $fh2 = 'CNY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));
                    }
                    if ($money_b == 3) {
                        $typename = '香港币兑换港币';
                        $fh = 'HKC';
                        $fh2 = 'HKD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkdollar' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 2);
                    }
                    if ($money_b == 4) {
                        $typename = '香港币兑换欧元';
                        $fh = 'HKC';
                        $fh2 = 'EUR';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_euro' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 3);
                    }
                    if ($money_b == 5) {
                        $typename = '香港币兑换日元';
                        $fh = 'HKC';
                        $fh2 = 'JPY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_jpy' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 4);
                    }
                    if ($money_b == 7) {
                        $typename = '香港币兑换英镑';
                        $fh = 'HKC';
                        $fh2 = 'GBP';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_gbp' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 6);
                    }
                    if ($money_b == 8) {
                        $typename = '香港币兑换澳元';
                        $fh = 'HKC';
                        $fh2 = 'AUD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_aud' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 7);
                    }
                    if ($money_b == 9) {
                        $typename = '香港币兑换加元';
                        $fh = 'HKC';
                        $fh2 = 'CAD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_cad' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 8);
                    }
                    if ($money_b == 10) {
                        $typename = '香港币兑换瑞郎';
                        $fh = 'HKC';
                        $fh2 = 'CHF';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_chf' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 9);
                    }
                    if ($money_b == 11) {
                        $typename = '香港币兑换新西兰元';
                        $fh = 'HKC';
                        $fh2 = 'NZD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_nzd' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 10);
                    }
                    if ($money_b == 12) {
                        $typename = '香港币兑换新加坡元';
                        $fh = 'HKC';
                        $fh2 = 'SGD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_sgd' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 11);
                    }
                    if ($money_b == 13) {
                        $typename = '香港币兑换比特币';
                        $fh = 'HKC';
                        $fh2 = 'BTC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 13);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_btc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    }
                    if ($money_b == 14) {
                        $typename = '香港币兑换以太币';
                        $fh = 'HKC';
                        $fh2 = 'ETH';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 14);

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_eth' => 1,
                            'intro' => "
                            <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                            <br>
                            <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 13);
                    }
                } else {
                    if ($money_b == 1) {
                        $typename = '人民币兑换美元';
                        $fh = 'CNY';
                        $fh2 = 'USD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_dollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 1);
                    } else if ($money_b == 3) {
                        $typename = '人民币兑换港币';
                        $fh = 'CNY';
                        $fh2 = 'HKD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkdollar' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 2);
                    } else if ($money_b == 5) {
                        $typename = '人民币兑换日元';
                        $fh = 'CNY';
                        $fh2 = 'JPY';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_jpy' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 4);
                    } else if ($money_b == 6) {
                        $typename = '人民币兑换韩元';
                        $fh = 'CNY';
                        $fh2 = 'KRW';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_krw' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 5);
                    } else if ($money_b == 7) {
                        $typename = '人民币兑换英镑';
                        $fh = 'CNY';
                        $fh2 = 'GBP';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_gbp' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 6);
                    } else if ($money_b == 8) {
                        $typename = '人民币兑换澳元';
                        $fh = 'CNY';
                        $fh2 = 'AUD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_aud' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 7);
                    } else if ($money_b == 9) {
                        $typename = '人民币兑换加元';
                        $fh = 'CNY';
                        $fh2 = 'CAD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_cad' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 8);
                    } else if ($money_b == 10) {
                        $typename = '人民币兑换瑞郎';
                        $fh = 'CNY';
                        $fh2 = 'CHF';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_chf' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 9);
                    } else if ($money_b == 11) {
                        $typename = '人民币兑换新西兰元';
                        $fh = 'CNY';
                        $fh2 = 'NZD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_nzd' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 10);
                    } else if ($money_b == 12) {
                        $typename = '人民币兑换新加坡元';
                        $fh = 'CNY';
                        $fh2 = 'SGD';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_sgd' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 11);
                    } else if ($money_b == 13) {
                        $typename = '人民币兑换香港币';
                        $fh = 'CNY';
                        $fh2 = 'HKC';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_hkc' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 12);
                    } else {
                        $typename = '人民币兑换欧元';
                        $fh = 'CNY';
                        $fh2 = 'EUR';
                        logic('me')->money()->less(($exchange_money + $sxf), $uid, array(
                            'name' => $typename,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ));

                        logic('me')->money()->add($post2['sjdhje'], $uid, array(
                            'name' => $typename,
                            'is_euro' => 1,
                            'intro' => "
                		  <b>用户：</b>" . user()->get("name") . "<br><b>兑换方向：</b>" . $typename . "
                		  <br>
                		  <b>兑换金额：</b>" . $fh . $post2['dhje'] . "元" . "<br/><b>汇率：</b>" . $post2['rate'] .
                                "<br/><b>手续费：</b>" . $fh . $post2['sxf'] . "元" . "<br/><b>实际兑换金额：</b>" . $fh2 . $post2['sjdhje'] . "元" .
                                "<br/><b>交易时间：</b>" . date('Y-m-d H:i', $post2['date'])
                        ), 3);

                    }


                }


                if ($_GET['type'] == 1) {
                    $this->Messager("兑换成功!", "?mod=me&code=wapbill");
                } else {
                    $this->Messager("兑换成功!", "?mod=me&code=bill");
                }

            }
        }

    }

    function Wbfk()
    {
        $this->Title = __('国际汇款');
        $addressList = logic('yinhangka')->GetList2(user()->get('id'));


        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;


        include handler('template')->file('my_wbfk');
    }

    function yzhk()
    {

        $this->Title = __('地址汇款');


        $sql = "select sum(lcb_money) as num from " . TABLE_PREFIX . "system_members;";
        $query = $this->DatabaseHandler->Query($sql);
        $row = $query->GetRow();

        $lcb_dcep_total = $row['num'];

        $sql = "select sum(lcb_hkc_money) as num from " . TABLE_PREFIX . "system_members;";
        $query = $this->DatabaseHandler->Query($sql);
        $row = $query->GetRow();

        $lcb_hkc_total = $row['num'];

        $uid = user()->get('id');


        include handler('template')->file('my_yzhk');
    }

    function xlhk()
    {
        $this->Title = __('账号收款');

        include handler('template')->file('my_xlhk');
    }

    function sszhuanzhang()
    {
        $this->Title = __('银行转账');

        include handler('template')->file('my_sszhuanzhang');
    }

    function Dozhuanzhang()
    {

        $uid = user()->get('id');

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));
        $row['brate'] = $yanzheng['brate'];

        if ($yanzheng['statue'] != 2) {
            $this->Messager("您需要验证通过个人资料", "?mod=me&code=zhuanzhang");
            exit;
        }

        $yinhangkaid = $this->Post("yinhangkaid", 'int');
        $money = $this->Post("tixiannum", 'float');
        $zfpassword = $this->Post("zfpassword", 'string');
        //验证开始
        //检测银行卡是不是自己的
        $addressList = logic('yinhangka')->GetOne($yinhangkaid, user()->get('id'));
        if (!$addressList) {
            $this->Messager("您没有此银行卡", "?mod=me&code=zhuanzhang");
            exit;
        }
        if ($money <= 0) {
            $this->Messager("提现余额应大于0", "?mod=me&code=zhuanzhang");
        }

        //检测金额是否大于余额
        if ($money > user()->get('money')) {
            $this->Messager("提现余额应小于账户余额", "?mod=me&code=zhuanzhang");
        }

        //检测支付密码是否正确
        if (md5($zfpassword) != user()->get('zfpassword')) {
            $this->Messager("支付密码错误", "?mod=me&code=zhuanzhang");
        }

        $sxf = 0;
        if ($row['brate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['brate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }

        $post['yhkid'] = $yinhangkaid;
        $post['yhkinfo'] = $addressList['kaihuhang'] . "," . $addressList['region'] . "," . $addressList['zhihang'];
        $post['yhkname'] = $addressList['name'];
        $post['yhkkh'] = $addressList['kahao'];
        $post['value'] = $money;
        $post['addtime'] = time();
        $post['statue'] = 1;
        $post['sxfl'] = $sxf;
        $post['sxhl'] = round($row['brate'], 2);

        $new_id = logic('zhuanzhanglist')->Add($uid, $post);

        //用户金额减少
        logic('me')->money()->less($money, $uid, array(
            'name' => '银行转账',
            'intro' => $new_id,
            'is_confirm' => 1
        ));

        if ($row['brate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['brate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }
        $row['tovalue'] = $money - $sxf;


        logic('push')->addi('sms', user(1)->get("phone"), array('content' => "用户:" . user()->get("name") . "申请银行汇款，金额为:" . $row['tovalue'] . "元"));
        $this->Messager("转账申请成功，资金预计将在三个工作日内到账，请注意查收", "?mod=me&code=bill");

    }

    function wapdozhuanzhang()
    {

        $uid = user()->get('id');

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));
        $row['brate'] = $yanzheng['brate'];

        if ($yanzheng['statue'] != 2) {
            $this->Messager("您需要验证通过个人资料", "?mod=me&code=wapzhuanzhang");
            exit;
        }

        $yinhangkaid = $this->Post("yinhangkaid", 'int');
        $money = $this->Post("tixiannum", 'float');
        $zfpassword = $this->Post("zfpassword", 'string');
        //验证开始
        //检测银行卡是不是自己的
        $addressList = logic('yinhangka')->GetOne($yinhangkaid, user()->get('id'));
        if (!$addressList) {
            $this->Messager("您没有此银行卡", "?mod=me&code=wapzhuanzhang");
            exit;
        }
        if ($money <= 0) {
            $this->Messager("提现余额应大于0", "?mod=me&code=wapzhuanzhang");
        }

        //检测金额是否大于余额
        if ($money > user()->get('money')) {
            $this->Messager("提现余额应小于账户余额", "?mod=me&code=wapzhuanzhang");
        }

        //检测支付密码是否正确
        if (md5($zfpassword) != user()->get('zfpassword')) {
            $this->Messager("支付密码错误", "?mod=me&code=wapzhuanzhang");
        }

        $sxf = 0;
        if ($row['brate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['brate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }

        $post['yhkid'] = $yinhangkaid;
        $post['yhkinfo'] = $addressList['kaihuhang'] . "," . $addressList['region'] . "," . $addressList['zhihang'];
        $post['yhkname'] = $addressList['name'];
        $post['yhkkh'] = $addressList['kahao'];
        $post['value'] = $money;
        $post['addtime'] = time();
        $post['statue'] = 1;
        $post['sxfl'] = $sxf;
        $post['sxhl'] = round($row['brate'], 2);

        $new_id = logic('zhuanzhanglist')->Add($uid, $post);

        //用户金额减少
        logic('me')->money()->less($money, $uid, array(
            'name' => '银行转账',
            'intro' => $new_id,
            'is_confirm' => 1
        ));

        if ($row['brate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['brate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }
        $row['tovalue'] = $money - $sxf;


        logic('push')->addi('sms', user(1)->get("phone"), array('content' => "用户:" . user()->get("name") . "申请银行汇款，金额为:" . $row['tovalue'] . "元"));
        $this->Messager("转账申请成功，资金预计将在三个工作日内到账，请注意查收", "?mod=me&code=wapbill");

    }

    function Dohuankuan()
    {

        $uid = user()->get('id');

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));
        $row['xyk_rate'] = $yanzheng['xyk_rate'];

        if ($yanzheng['statue'] != 2) {
            $this->Messager("您需要验证通过个人资料", "?mod=me&code=xyk");
            exit;
        }

        $yinhangkaid = $this->Post("yinhangkaid", 'int');
        $money = $this->Post("tixiannum", 'float');
        $zfpassword = $this->Post("zfpassword", 'string');
        //验证开始
        //检测银行卡是不是自己的
        $addressList = logic('yinhangka')->GetOne3($yinhangkaid, user()->get('id'));
        if (!$addressList) {
            $this->Messager("您没有此银行卡", "?mod=me&code=xyk");
            exit;
        }
        if ($money <= 0) {
            $this->Messager("还款余额应大于0", "?mod=me&code=xyk");
        }

        //检测金额是否大于余额
        if ($money > user()->get('money')) {
            $this->Messager("还款余额应小于账户余额", "?mod=me&code=xyk");
        }

        //检测支付密码是否正确
        if (md5($zfpassword) != user()->get('zfpassword')) {
            $this->Messager("支付密码错误", "?mod=me&code=xyk");
        }

        $sxf = 0;
        if ($row['xyk_rate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['xyk_rate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }

        $post['yhkid'] = $yinhangkaid;
        $post['owner'] = $uid;
        //$post['yhkinfo'] =  $addressList['kaihuhang'].",". $addressList['region'].",". $addressList['zhihang'];
        $post['yhkname'] = $addressList['name'];
        $post['yhkkh'] = $addressList['kahao'];
        $post['value'] = $money;
        $post['addtime'] = time();
        $post['statue'] = 1;
        $post['sxfl'] = $sxf;
        $post['sxhl'] = round($row['xyk_rate'], 2);

        $new_id = logic('zhuanzhanglist')->Add3($uid, $post);


        //用户金额减少(还款金额+手续费)
        logic('me')->money()->less(number_format($money + $sxf, 2, '.', ''), $uid, array(
            'name' => '信用卡还款',
            'intro' => $new_id,
            'is_confirm' => 1
        ));

        if ($row['xyk_rate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['xyk_rate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }
        $row['tovalue'] = $money + $sxf;


        $htm_sxf = ($sxf == 0) ? '' : ('手续费为:' . $sxf);
        //logic('push')->addi('sms', user(1)->get("phone"), array('content'=>"用户:".user()->get("name")."申请信用卡还款，还款金额为:".$money."元".$htm_sxf));

        $this->Messager("信用卡还款申请成功，资金预计将在三个工作日内到账，请注意查收", "?mod=me&code=bill");

    }

    function wapdohuankuan()
    {

        $uid = user()->get('id');

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));
        $row['xyk_rate'] = $yanzheng['xyk_rate'];

        if ($yanzheng['statue'] != 2) {
            $this->Messager("您需要验证通过个人资料", "?mod=me&code=wapxyk");
            exit;
        }

        $yinhangkaid = $this->Post("yinhangkaid", 'int');
        $money = $this->Post("tixiannum", 'float');
        $zfpassword = $this->Post("zfpassword", 'string');
        //验证开始
        //检测银行卡是不是自己的
        $addressList = logic('yinhangka')->GetOne3($yinhangkaid, user()->get('id'));
        if (!$addressList) {
            $this->Messager("您没有此银行卡", "?mod=me&code=wapxyk");
            exit;
        }
        if ($money <= 0) {
            $this->Messager("还款余额应大于0", "?mod=me&code=wapxyk");
        }

        //检测金额是否大于余额
        if ($money > user()->get('money')) {
            $this->Messager("还款余额应小于账户余额", "?mod=me&code=wapxyk");
        }

        //检测支付密码是否正确
        if (md5($zfpassword) != user()->get('zfpassword')) {
            $this->Messager("支付密码错误", "?mod=me&code=wapxyk");
        }

        $sxf = 0;
        if ($row['xyk_rate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['xyk_rate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }

        $post['yhkid'] = $yinhangkaid;
        $post['owner'] = $uid;
        //$post['yhkinfo'] =  $addressList['kaihuhang'].",". $addressList['region'].",". $addressList['zhihang'];
        $post['yhkname'] = $addressList['name'];
        $post['yhkkh'] = $addressList['kahao'];
        $post['value'] = $money;
        $post['addtime'] = time();
        $post['statue'] = 1;
        $post['sxfl'] = $sxf;
        $post['sxhl'] = round($row['xyk_rate'], 2);

        $new_id = logic('zhuanzhanglist')->Add3($uid, $post);


        //用户金额减少(还款金额+手续费)
        logic('me')->money()->less(number_format($money + $sxf, 2, '.', ''), $uid, array(
            'name' => '信用卡还款',
            'intro' => $new_id,
            'is_confirm' => 1
        ));

        if ($row['xyk_rate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['xyk_rate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }
        $row['tovalue'] = $money + $sxf;


        $htm_sxf = ($sxf == 0) ? '' : ('手续费为:' . $sxf);
        //logic('push')->addi('sms', user(1)->get("phone"), array('content'=>"用户:".user()->get("name")."申请信用卡还款，还款金额为:".$money."元".$htm_sxf));

        $this->Messager("信用卡还款申请成功，资金预计将在三个工作日内到账，请注意查收", "?mod=me&code=wapbill");

    }

    function Dozhuanzhang2()
    {

        $uid = user()->get('id');

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));
        $row['gjrate'] = $yanzheng['gjrate'];

        if ($yanzheng['statue'] != 2) {
            $this->Messager("您需要验证通过个人资料", "?mod=me&code=wbfk");
            exit;
        }

        $yinhangkaid = $this->Post("yinhangkaid", 'int');
        $money = $this->Post("tixiannum", 'float');
        $zfpassword = $this->Post("zfpassword", 'string');
        $yongtu = $this->Post("yongtu", 'string');
        $message = $this->Post("message", 'string');
        $is_sxf = $this->Post("is_sxf", 'int');
        $money_a = $this->Post("money_a", 'int');

        //验证开始
        //检测银行卡是不是自己的
        $addressList = logic('yinhangka')->GetOne2($yinhangkaid, user()->get('id'));
        if (!$addressList) {
            $this->Messager("您没有此银行卡", "?mod=me&code=wbfk");
            exit;
        }
        if ($money <= 0) {
            $this->Messager("转账余额应大于0", "?mod=me&code=wbfk");
        }


        //检查资金用途
        if (empty($yongtu)) {
            $this->Messager("请选择汇款用途", "?mod=me&code=wbfk");
        }

        //检测支付密码是否正确
        if (md5($zfpassword) != user()->get('zfpassword')) {
            $this->Messager("支付密码错误", "?mod=me&code=wbfk");
        }

        $sxf = 0;
        if ($row['gjrate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['gjrate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }
        //检测金额是否大于余额
        if ($money_a == 1) {
            $post['is_dollar'] = 1;
            if ($money + $sxf > user()->get('dollar')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 3) {
            $post['is_hkdollar'] = 1;
            if ($money + $sxf > user()->get('hkdollar')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 5) {
            $post['is_jpy'] = 1;
            if ($money + $sxf > user()->get('jpy')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 6) {
            $post['is_krw'] = 1;
            if ($money + $sxf > user()->get('krw')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 7) {
            $post['is_gbp'] = 1;
            if ($money + $sxf > user()->get('gbp')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 8) {
            $post['is_aud'] = 1;
            if ($money + $sxf > user()->get('aud')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 9) {
            $post['is_cad'] = 1;
            if ($money + $sxf > user()->get('cad')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 10) {
            $post['is_chf'] = 1;
            if ($money + $sxf > user()->get('chf')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 11) {
            $post['is_nzd'] = 1;
            if ($money + $sxf > user()->get('nzd')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 12) {
            $post['is_sgd'] = 1;
            if ($money + $sxf > user()->get('sgd')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 13) {
            $post['is_hkc'] = 1;
            if ($money + $sxf > user()->get('hkc')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 14) {
            $post['is_money'] = 1;
            if ($money + $sxf > user()->get('money')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 15) {
            $post['is_btc'] = 1;
            if ($money + $sxf > user()->get('btc')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else if ($money_a == 16) {
            $post['is_eth'] = 1;
            if ($money + $sxf > user()->get('eth')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        } else {
            $post['is_euro'] = 1;
            if ($money + $sxf > user()->get('euro')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=wbfk");
            }
        }
        $post['yhkid'] = $yinhangkaid;
        $post['is_sxf'] = $is_sxf;
        $post['value'] = $money + $sxf;
        $post['addtime'] = time();
        $post['statue'] = 1;
        $post['sxfl'] = $sxf;
        $post['sxhl'] = round($row['gjrate'], 2);
        $post['yongtu'] = $yongtu;
        $post['message'] = $message;

        $new_id = logic('zhuanzhanglist')->Add2($uid, $post);
        $name_prefix = "";

        //用户金额减少
        if ($money_a == 1) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '美元汇款',
                'intro' => $new_id,
                'is_dollar' => 1,
                'is_confirm' => 1,
            ), 1);
            $name_prefix = "美元汇款";
        } else if ($money_a == 3) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '港币汇款',
                'intro' => $new_id,
                'is_hkdollar' => 1,
                'is_confirm' => 1,
            ), 2);
            $name_prefix = "港币汇款";
        } else if ($money_a == 5) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '日元汇款',
                'intro' => $new_id,
                'is_jpy' => 1,
                'is_confirm' => 1,
            ), 4);
            $name_prefix = "日元汇款";
        } else if ($money_a == 6) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '韩元汇款',
                'intro' => $new_id,
                'is_krw' => 1,
                'is_confirm' => 1,
            ), 5);
            $name_prefix = "韩元汇款";
        } else if ($money_a == 7) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '英镑汇款',
                'intro' => $new_id,
                'is_gbp' => 1,
                'is_confirm' => 1,
            ), 6);
            $name_prefix = "英镑汇款";
        } else if ($money_a == 8) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '澳元汇款',
                'intro' => $new_id,
                'is_aud' => 1,
                'is_confirm' => 1,
            ), 7);
            $name_prefix = "澳元汇款";
        } else if ($money_a == 9) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '加元汇款',
                'intro' => $new_id,
                'is_cad' => 1,
                'is_confirm' => 1,
            ), 8);
            $name_prefix = "加元汇款";
        } else if ($money_a == 10) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '瑞郎汇款',
                'intro' => $new_id,
                'is_chf' => 1,
                'is_confirm' => 1,
            ), 9);
            $name_prefix = "瑞郎汇款";
        } else if ($money_a == 11) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '新西兰元汇款',
                'intro' => $new_id,
                'is_nzd' => 1,
                'is_confirm' => 1,
            ), 10);
            $name_prefix = "新西兰元汇款";
        } else if ($money_a == 12) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '新加坡元汇款',
                'intro' => $new_id,
                'is_sgd' => 1,
                'is_confirm' => 1,
            ), 11);
            $name_prefix = "新加坡元汇款";
        } else if ($money_a == 13) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '香港币汇款',
                'intro' => $new_id,
                'is_hkc' => 1,
                'is_confirm' => 1,
            ), 12);
            $name_prefix = "香港币汇款";
        } else if ($money_a == 14) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '人民币汇款',
                'intro' => $new_id,
                'is_money' => 1,
                'is_confirm' => 1,
            ), 13);
            $name_prefix = "人民币汇款";
        } else if ($money_a == 15) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '比特币汇款',
                'intro' => $new_id,
                'is_btc' => 1,
                'is_confirm' => 1,
            ), 14);
            $name_prefix = "比特币汇款";
        } else if ($money_a == 16) {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '以太币汇款',
                'intro' => $new_id,
                'is_eth' => 1,
                'is_confirm' => 1,
            ), 15);
            $name_prefix = "以太币汇款";
        } else {
            logic('me')->money()->less($money + $sxf, $uid, array(
                'name' => '欧元汇款',
                'intro' => $new_id,
                'is_euro' => 1,
                'is_confirm' => 1,
            ), 3);
            $name_prefix = "欧元汇款";
        }

        if ($row['gjrate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $row['gjrate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }

        if ($is_sxf == 1) {
            $row['tovalue'] = $money;
        } else {
            $row['tovalue'] = $money;
        }


        logic('push')->addi('sms', user(1)->get("phone"), array('content' => "用户:" . user()->get("name") . "申请{$name_prefix}，金额为:" . $row['tovalue'] . "元"));
        if ($_GET['type'] == 1) {
            $this->Messager("转账申请成功，资金预计将在三个工作日内到账，请注意查收!", "?mod=me&code=wapbill");
        } else {
            $this->Messager("转账申请成功，资金预计将在三个工作日内到账，请注意查收!", "?mod=me&code=bill");
        }
        //$this->Messager("转账申请成功，资金预计将在三个工作日内到账，请注意查收", "?mod=me&code=bill");

    }

    function Linkpay()
    {
        if (stristr($_SERVER['HTTP_VIA'], "wap")) {
            $a = true;
        } elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            $a = true;
        } elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $a = true;
        } else {
            $a = false;
        }

        if (!$scr = logic('yanzheng')->GetOneByUsername($_GET['account'])) {
            exit('invalid pay user[' . $_GET['account'] . '].');
        }
        $scryz = logic('yanzheng')->GetOne($scr['uid']);

        if (!$a) {
            $topay = 'zhannei';
            include handler('template')->file('my_linkpay');
        } else {
            $topay = 'wapxyk';
            include handler('template')->file('@wap/my_linkpay');
        }
    }

    function Zhannei()
    {

        $payto = false;
        if ($_GET['payto']) {
            if (!$scr = logic('yanzheng')->GetOneByUsername($_GET['payto'])) {
                exit('invalid pay user.');
            }
            $payto = true;
            $scryz = logic('yanzheng')->GetOne($scr['uid']);
        }

        $ac = logic('yanzheng')->GetOneAC(user()->get('id'));

        $this->Title = __('站内转账支付');

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        include handler('template')->file('my_zhannei');
    }

    function Dozhannei()
    {

        $uid = user()->get('id');

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        if ($yanzheng['statue'] != 2) {
            $this->Messager("您需要验证通过个人资料", "?mod=me&code=zhannei");
            exit;
        }

        $tousername = $this->Post("tousername", 'string');

        $sql = 'select uid ,phone  from ' . TABLE_PREFIX . 'system_members where email = "' . $tousername . '"';
        $query = $this->DatabaseHandler->Query($sql);
        $touser = $query->GetRow();

        if (!$touser) {
            $this->Messager("此账号不存在", "?mod=me&code=zhannei");
        }

        if ($touser['uid'] == $uid) {
            $this->Messager("不能给自己转账", "?mod=me&code=zhannei");
        }


        $money = $this->Post("tixiannum", 'float');
        $zfpassword = $this->Post("zfpassword", 'string');
        //验证开始
        //检测银行卡是不是自己的


        if ($money <= 0) {
            $this->Messager("转账余额应大于0", "?mod=me&code=zhannei");
        }
        $sxf = 0;
        if ($yanzheng['wrate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $yanzheng['wrate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }
        //检测金额是否大于余额
        $money_a = $this->Post("money_a", 'int');
        $lessType = '';
        if ($money_a == 1) {
            $lessType = 'dollar';
            $post['money_type'] = 1;
            if ($money + $sxf > user()->get('dollar')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 3) {
            $lessType = 'hkdollar';
            $post['money_type'] = 2;
            if ($money + $sxf > user()->get('hkdollar')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 5) {
            $lessType = 'jpy';
            $post['money_type'] = 4;
            if ($money + $sxf > user()->get('jpy')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 6) {
            $lessType = 'krw';
            $post['money_type'] = 5;
            if ($money + $sxf > user()->get('krw')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 7) {
            $lessType = 'gbp';
            $post['money_type'] = 6;
            if ($money + $sxf > user()->get('gbp')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 8) {
            $lessType = 'aud';
            $post['money_type'] = 7;
            if ($money + $sxf > user()->get('aud')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 9) {
            $lessType = 'cad';
            $post['money_type'] = 8;
            if ($money + $sxf > user()->get('cad')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 10) {
            $lessType = 'chf';
            $post['money_type'] = 9;
            if ($money + $sxf > user()->get('chf')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 11) {
            $lessType = 'nzd';
            $post['money_type'] = 10;
            if ($money + $sxf > user()->get('nzd')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 12) {
            $lessType = 'sgd';
            $post['money_type'] = 11;
            if ($money + $sxf > user()->get('sgd')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 13) {
            $lessType = 'hkc';
            $post['money_type'] = 12;
            if ($money + $sxf > user()->get('hkc')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 14) {
            $lessType = 'money';
            $post['money_type'] = 13;
            if ($money + $sxf > user()->get('money')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 15) {
            $lessType = 'btc';
            $post['money_type'] = 14;
            if ($money + $sxf > user()->get('btc')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 16) {
            $lessType = 'eth';
            $post['money_type'] = 15;
            if ($money + $sxf > user()->get('eth')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else if ($money_a == 4) {
            $lessType = 'euro';
            $post['money_type'] = 3;
            if ($money + $sxf > user()->get('euro')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        } else {
            $lessType = 'money';
            $post['money_type'] = 0;
            if ($money + $sxf > user()->get('money')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=zhannei");
            }
        }


        //检测支付密码是否正确
        if (md5($zfpassword) != user()->get('zfpassword')) {
            $this->Messager("支付密码错误", "?mod=me&code=zhannei");
        }

        //


        $post['touid'] = $touser['uid'];
        $post['username'] = user()->get("name");
        $post['tousername'] = $tousername;
        $post['value'] = $money + $sxf;
        $post['tovalue'] = $money;
        $post['sxfl'] = $yanzheng['wrate'];
        $post['mark'] = trim($_POST['mark']);
        $post['addtime'] = time();
        $post['statue'] = 2;

        $new_id = logic('zhanneilist')->Add($uid, $post);
        if ($post['money_type'] == 0) {
            //用户金额减少
            $lessType = 'CNY';
            logic('me')->money()->less($post['value'], $uid, array(
                'name' => 'zz',
                'intro' => $new_id,
                'is_confirm' => 0
            ));
            logic('me')->money()->add($post['tovalue'], $post['touid'], array(
                'name' => 'zn',
                'intro' => $new_id,
                'is_confirm' => 0
            ));
        } else {
            logic('me')->money()->less($post['value'], $uid, array(
                'name' => 'zz',
                'intro' => $new_id,
                'is_' . $lessType => 1,
                'is_confirm' => 0
            ), $post['money_type']);
            logic('me')->money()->add($post['tovalue'], $post['touid'], array(
                'name' => 'zn',
                'intro' => $new_id,
                'is_' . $lessType => 1,
                'is_confirm' => 0
            ), $post['money_type']);
            $lessType = strtoupper($lessType);
        }


        logic('push')->addi('sms', $touser['phone'], array('content' => "用户:" . user()->get("name") . "向您账户转入" . $lessType . $post['tovalue'] . "元"));
        if ($_GET['type'] == 1) {
            $this->Messager("转账成功！", "?mod=me&code=wapbill");
        } else {
            $this->Messager("转账成功！", "?mod=me&code=bill");
        }


    }

    function Cancel()
    {
        extract($this->Get);
        $this->OrderLogic->orderType($orderid, '0');
        $this->Messager("您已经成功取消该订单！", "?mod=me&code=order");
    }


function Doinfo()
    {
        extract($this->Post);
        $ary = array();
        if ( $newpwd == $confirmpwd && $newpwd != '' )
        {
            $ary['password'] = md5($newpwd);
            if ( true === UCENTER )
            {
                include_once (UC_CLIENT_ROOT . './client.php');
                $result = uc_user_edit(MEMBER_NAME, '', $newpwd, '', 1);
                if ( $result != 1 )
                {
                    $this->Messager('通知UC修改密码失败，请检查你的UC配置！');
                }
            }
            account('ulogin')->UserPasswd(user()->get('id'), $newpwd);
        }


        if ( $newzfpwd == $confirmzfpwd && $newzfpwd != '' )
        {
            $ary['zfpassword'] = md5($newzfpwd);

            //account('ulogin')->UserPasswd(user()->get('id'), $newpwd);
        }


        if ( $phone != '' )
        {
            $ary['phone'] = $phone;
        }
        $sql = 'select `email` from ' . TABLE_PREFIX . 'system_members where uid = ' . MEMBER_ID;
        $query = $this->DatabaseHandler->Query($sql);
        $user = $query->GetRow();
        $ary['qq'] = $qq;
        if ( $user['email'] != $email )
        {
            $ary['email'] = $email;
            $ary['username'] = $email;
            if ( $this->config['default_emailcheck'] )
            {
                $ary['checked'] = 0;
            }
        }
        $this->DatabaseHandler->SetTable(TABLE_PREFIX . 'system_members');
        $result = $this->DatabaseHandler->Update($ary, 'uid = ' . MEMBER_ID);
        $a=$this->checkwap();

		if($newzfpwdprivate) {
			$pwd = $newzfpwdprivate;
			$msg = false;
			if( strlen($pwd) < 8) {
				$msg = ('合约密码需大于8位。');
			}
			$lower_arr = array();
			$lower = 'abcdefghijklmnopqrstuvwxyz';
			for($i=0;$i<strlen($lower); $i++) {
				$lower_arr[] = substr($lower, $i, 1);
			}
			$upper_arr = array();
			$upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			for($i=0;$i<strlen($upper); $i++) {
				$upper_arr[] = substr($upper, $i, 1);
			}
			$num_arr = array();
			$num = '0123456789';
			for($i=0;$i<strlen($num); $i++) {
				$num_arr[] = substr($num, $i, 1);
			}

			$pwdstr = array();
			$hasLower = false;
			$hasUpper = false;
			$hasNum = false;

			for($i=0;$i<strlen($pwd); $i++) {
				$str = substr($pwd, $i, 1);
				if(in_array($str, $lower_arr)) {
					$hasLower = true;
				}

				if(in_array($str, $upper_arr)) {
					$hasUpper = true;
				}

				if(in_array($str, $num_arr)) {
					$hasNum = true;
				}
			}
			if(!$hasLower) {
				$msg = ('合约密码需要包含小写字母。');
			}
			if(!$hasUpper) {
				$msg = ('合约密码需要包含大写字母。');
			}
			if(!$hasNum) {
				$msg = ('合约密码需要包含数字。');
			}

			if($msg) {
				echo $msg;
				header('Location: '.rewrite('?mod=me&code=wapsetting'));
				exit;
			}

			//var_dump($newzfpwdprivate, md5($newzfpwdprivate));

			$res = $this->DatabaseHandler->Query(
			    'UPDATE `cenwor_tttuangou_user_private_key` SET pwd="' . sha1( md5('testdescryptionwoshisunzhen') . md5( $newzfpwdprivate) )    . '" WHERE uid='. user()->get('id'));
		}


        if($res)
        {
            $this->Messager("资料修改成功！");
        }
        else
        {
            header('Location: '.rewrite('?mod=me&code=wapsetting'));
        }
    }





    function doinfo_nm()
    {
        extract($this->Post);
        $ary = array();
        $msg = false;

        session_start();
        $username_nm = $_SESSION['username_nm'];

        if ($newpwd == $confirmpwd && $newpwd != '') {
            $pwd = $newpwd;

            if (strlen($pwd) < 8) {
                $msg = ('登录密码需大于8位。');
            }
            $lower_arr = array();
            $lower = 'abcdefghijklmnopqrstuvwxyz';
            for ($i = 0; $i < strlen($lower); $i++) {
                $lower_arr[] = substr($lower, $i, 1);
            }
            $upper_arr = array();
            $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            for ($i = 0; $i < strlen($upper); $i++) {
                $upper_arr[] = substr($upper, $i, 1);
            }
            $num_arr = array();
            $num = '0123456789';
            for ($i = 0; $i < strlen($num); $i++) {
                $num_arr[] = substr($num, $i, 1);
            }

            $pwdstr = array();
            $hasLower = false;
            $hasUpper = false;
            $hasNum = false;

            for ($i = 0; $i < strlen($pwd); $i++) {
                $str = substr($pwd, $i, 1);
                if (in_array($str, $lower_arr)) {
                    $hasLower = true;
                }

                if (in_array($str, $upper_arr)) {
                    $hasUpper = true;
                }

                if (in_array($str, $num_arr)) {
                    $hasNum = true;
                }
            }
            if (!$hasLower) {
                $msg = ('登录密码需要包含小写字母。');
            }
            if (!$hasUpper) {
                $msg = ('登录密码需要包含大写字母。');
            }
            if (!$hasNum) {
                $msg = ('登录密码需要包含数字。');
            }

            if ($msg) {
                echo $msg;
                header('Location: ' . rewrite('?mod=me&code=wapsetting_nm'));
                exit;

            } else {
                $ary['pwd'] = $newpwd;

            }

        }


        if ($newzfpwd == $confirmzfpwd && $newzfpwd != '') {
            $pwd = $newzfpwd;
            if (strlen($pwd) < 8) {
                $msg = ('支付密码需大于等于8位！');
            }


            if ($msg) {
                echo $msg;
                header('Location: ' . rewrite('?mod=me&code=wapsetting_nm'));
                exit;

            } else {
                $ary['pin'] = $newzfpwd;
            }


        }

        if ($zjwords != '') {
            $pwd = $zjwords;
            if (strlen($pwd) < 8) {
                $msg = ('助记词需大于等于8位！');
            }

            if ($msg) {
                echo $msg;
                header('Location: ' . rewrite('?mod=me&code=wapsetting_nm'));
                exit;

            } else {
                $ary['words'] = $zjwords;
            }
        }


        $this->DatabaseHandler->SetTable('cenwor_tttuangou_user_private_key');
        $result = $this->DatabaseHandler->Update($ary, 'encrypt_public=' . $username_nm);

        if ($result) {
            $this->Messager("资料修改成功!");
        } else {
            header('Location: ' . rewrite('?mod=me&code=wapsetting_nm'));
        }


    }


    /*
		$res = $this->DatabaseHandler->Query('
			UPDATE `cenwor_tttuangou_user_private_key` SET pwd="' . $newpwd. '",pin="'. $newzfpwd.'" WHERE encrypt_public='.$username_nm'
			');
		*/


    function Printticket()
    {
        extract($this->Get);
        $order = $this->OrderLogic->GetTicket($id);
        $pwd = $order['password'];
        if ($order == '' || $pwd == '') $this->Messager("读取团购券出现错误！", "?mod=me");
        include($this->TemplateHandler->Template("tttuangou_printticket"));
    }

    function Addmoney()
    {
        $money = $this->MeLogic->moneyMe();
        $pay = $this->PayLogic->payType(intval($id), $this->city);
        $action = '?mod=me&code=doaddmoney';
        include($this->TemplateHandler->Template("tttuangou_addmoney"));
    }

    function Topay($mod, $returnurl, $pay)
    {
        $payment = unserialize($pay['pay_config']);
        $returnurl .= '&pay=' . $mod;
        include_once('./modules/' . $mod . '.pay.php');
        $bottom = payTo($payment, $returnurl, $pay);
        return $bottom;
    }

    function Doaddmoney()
    {
        $this->Post['money'] = round($this->Post['money'], 2);
        if ($this->Post['paytype'] == '') $this->Messager("您没有选择支付方式或者没有适合的支付接口！");
        if (!is_numeric($this->Post['money']) || $this->Post['money'] <= 0) $this->Messager("充值金额必须大于0！");
        $pay = $this->PayLogic->payChoose(intval($this->Post['paytype']));
        $pay['orderid'] = time() . rand(10000, 99999);
        $pay['price'] = $this->Post['money'];
        $pay['name'] = '账户充值';
        $pay['show_url'] = $this->Config['site_url'] . '/?mod=me&code=money';
        $returnurl = $this->Config['site_url'] . '/index.php?mod=me&code=readdmoney';
        $bottom = $this->Topay($pay['pay_code'], $returnurl, $pay);
        include($this->TemplateHandler->Template('tttuangou_doaddmoney'));
    }

    function Readdmoney()
    {
        $pay_code = (isset($_POST['pay']) ? $_POST['pay'] : $_GET['pay']);
        if ($pay_code == '') {
            $this->Messager('参数传递错误！');
        }
        if (isset($_GET['pay'])) {
            $is_notify = false;
            $userID = MEMBER_ID;
        } elseif (isset($_POST['pay'])) {
            $is_notify = true;
            $userID = $_POST['uid'];
        }

        $this->log_result("-----------------------------------------------");
        $this->log_result($_SERVER['QUERY_STRING']);
        $this->log_result('./modules/' . $pay_code . '.pay.php');
        $this->log_result("-----------------------------------------------");


        include_once('./modules/' . $pay_code . '.pay.php');
        $msg = addmymoney($userID);
        $oid = isset($_GET['out_trade_no']) ? $_GET['out_trade_no'] : $_POST['out_trade_no'];
        $trade_status = isset($_GET['trade_status']) ? $_GET['trade_status'] : $_POST['trade_status'];
        $pay = $this->PayLogic->payChoose($pay_code);
        $pay = unserialize($pay['pay_config']);
        $ifTrust = true;
        if ($pay['alipay_iftype'] == 'distrust') {
            $ifTrust = false;
        }
        if (is_array($msg)) {
            if ($is_notify) {
                $trade_no = $_POST['trade_no'];
                if ($ifTrust || $trade_status == 'TRADE_FINISHED') {
                    $this->Dopay($msg['price'], $msg['orderid'], $userID, $trade_no);
                }
                if (!$ifTrust && $trade_status == 'WAIT_SELLER_SEND_GOODS') {
                    $url = sendGoods($trade_no, $pay);
                    $doc = new DOMDocument();
                    $doc->load($url);
                }
                exit('success');
            }
            if ($pay_code != 'alipay') {
                if ($pay_code == 'tenpay') {
                    $trade_no = $_REQUEST['transaction_id'];
                } elseif ($pay_code == 'kuaiqian') {
                    $trade_no = $_REQUEST['dealId'];
                }
                $result = $this->Dopay($msg['price'], $msg['orderid'], $userID, $trade_no);
                $this->Messager($result, '?mod=me&code=money');
            } else {
                if (!$ifTrust && $trade_status != 'TRADE_FINISHED') {
                    $this->Messager('支付还没有完成，请您先确认收货，之后系统便会自动完成本次交易！', 'http:/' . '/lab.alipay.com/consume/record/buyerConfirmTrade.htm?tradeNo=' . $_GET['trade_no'], 5);
                }
            }
            $this->Messager('充值成功！', '?mod=me&code=money');
        } else {
            if ($is_notify) {
                exit('success');
            }
            if ($pay_code == 'alipay' && $msg == '您不能重复充值同一订单，充值失败！') {
                $this->Messager('充值成功！', '?mod=me&code=money');
            }
            $this->Messager($msg, '?mod=me&code=money');
        };
    }

    function Dopay($price, $orderid, $userID, $trade_no)
    {
        if ($price == '' || $orderid == '') {
            return "支付失败!";
        };
        if ($price > 0) {
            $pay = $this->MeLogic->moneyAdd($price, $userID);
            $ary = array(
                'userid' => $userID, 'type' => 1, 'name' => '直接充值', 'intro' => '您为账户充值' . $price . '元', 'money' => $price, 'time' => time(), 'trade_no' => $trade_no
            );
            $this->MeLogic->moneyLog($ary);
        };
        $ary = array(
            'id' => $orderid, 'money' => $price, 'userid' => $userID, 'paytime' => date('Y-m-d H:i:s')
        );
        $this->DatabaseHandler->SetTable(TABLE_PREFIX . 'tttuangou_addmoney');
        $result = $this->DatabaseHandler->Insert($ary);
        return '充值成功！';
    }

    function Face()
    {
        $sql = 'select ucuid from ' . TABLE_PREFIX . 'system_members where uid = ' . MEMBER_ID;
        $query = $this->DatabaseHandler->Query($sql);
        $usr = $query->GetRow();
        if (UCENTER) {
            include_once(UC_CLIENT_ROOT . './client.php');
            $face = uc_avatar($usr['ucuid']);
        } else {
            ;
        }
        include($this->TemplateHandler->Template("tttuangou_face"));
    }

    function lcb()
    {
        if (stristr($_SERVER['HTTP_VIA'], "wap")) {
            $a = true;
        } elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            $a = true;
        } elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $a = true;
        } else {
            $a = false;
        }
        if (!$a) {
            include handler('template')->file('lcb');
            //include ($this->TemplateHandler->Template("my_lcb"));
        } else {
            include handler('template')->file('@wap/lcb');
        }
    }

    function waplcb()
    {

        $this->Title = __('理财宝');

        $addressList = logic('yinhangka')->GetXinyongKaList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        include handler('template')->file('@wap/lcb');
    }

    function wapjl()
    {
        $sql = "select sum(lcb_money) as num from " . TABLE_PREFIX . "system_members;";
        $query = $this->DatabaseHandler->Query($sql);
        $row = $query->GetRow();

        $lcb_dcep_total = $row['num'];

        $sql = "select sum(lcb_hkc_money) as num from " . TABLE_PREFIX . "system_members;";
        $query = $this->DatabaseHandler->Query($sql);
        $row = $query->GetRow();

        $lcb_hkc_total = $row['num'];

        $uid = user()->get('id');
        include handler('template')->file('@wap/my_jl');
    }


    function wapjl_nm()
    {
        session_start();
        $username_nm = $_SESSION['username_nm'];


        /*
		 $sql = "select sum(lcb_money) as num from ".TABLE_PREFIX."system_members;";
		$query = $this->DatabaseHandler->Query($sql);
		$row = $query->GetRow();

		$lcb_dcep_total = $row['num'];

		$sql = "select sum(lcb_hkc_money) as num from ".TABLE_PREFIX."system_members;";
		$query = $this->DatabaseHandler->Query($sql);
		$row = $query->GetRow();

		$lcb_hkc_total = $row['num'];

		$uid = user()->get('id');
		*/

        include handler('template')->file('@wap/my_jl_nm');
    }


    function wapwbfk()
    {

        $this->Title = __('国际汇款');
        $addressList = logic('yinhangka')->GetList2(user()->get('id'));


        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        include handler('template')->file('@wap/my_wbfk');

    }

    function wapwbsk()
    {

        include handler('template')->file('@wap/my_wbsk');
    }

    function getprivate()
    {
        if (!$pwd = $_POST['pwd']) {
            echo json_encode(array('code' => 2, 'msg' => '合约支付密码不能为空'));
            exit;
        }

        $uid = user()->get('id');
        $sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $uid . '"';
        $query = $this->DatabaseHandler->Query($sql);
        if (!$encrypt = $query->GetRow()) {
            echo json_encode(array('code' => 3, 'msg' => '尚未设置匿名合约'));
            exit;
        }
        if ($encrypt['pwd'] != md5($pwd)) {
            echo json_encode(array('code' => 3, 'msg' => '合约支付密码错误'));
            exit;
        }
        echo json_encode(array('code' => 1, 'msg' => $encrypt['encrypt_private']));

    }

    function wapsetting()
    {
        $this->Title = __('账户设置');
        $user = user()->get();
        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));
        if ($yanzheng['statue'] == 2) {
            $user['xingming'] = $yanzheng['idname'];
        } else {
            $user['xingming'] = '未验证';
        }
        include handler('template')->file('@wap/my_setting');
    }

    function wappassword()
    {

        include handler('template')->file('@wap/my_password');
    }

    function waphd()
    {

        include handler('template')->file('@wap/my_hd');
    }

    function wapsm()
    {

        include handler('template')->file('@wap/my_sm');
    }

    function wapsm1()
    {

        include handler('template')->file('@wap/my_sm1');
    }

    function wapsm2()
    {
        $uid = user()->get('id');
        $sql = 'SELECT * FROM ' . table('user_private_key') . ' WHERE uid=' . $uid;

        if (!$d = dbc(DBCMax)->query($sql)->limit(1)->done()) {
            include handler('template')->file('@wap/my_sm2');
        } else {
            if ($d['pwd']) {
                header('location: /?mod=me&code=contracttrans');
            } else {
                header('location: /?mod=me&code=createcontractpwd');
            }
        }
    }

    function docontracttrans()
    {

        session_start();
        if (!isset($_SESSION['try_times'])) {
            $_SESSION['try_times'] = 0;
        }

        if (!isset($_SESSION['is_lock'])) {
            $_SESSION['is_lock'] = 0;
        }
        if ($_SESSION['is_lock'] == 1) {

            $t = time() - $_SESSION['lock_time'];
            if ($t > (20)) {
                $_SESSION['is_lock'] = 0;
            } else {
                $this->Messager("匿名转账功能已锁定。(于" . $t . "秒后解锁)", "?mod=me&code=contracttrans");
                exit;
            }
        }

        $uid = user()->get('id');


        $sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $uid . '"';
        $query = $this->DatabaseHandler->Query($sql);
        $from = $query->GetRow();
        if (!$from['pwd']) {
            $this->Messager("您尚未设置匿名支付密码。", "?mod=me&code=contracttrans");
            exit;
        }

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        if ($yanzheng['statue'] != 2) {
            //$this->Messager("您需要验证通过个人资料", "?mod=me&code=contracttrans");
            //exit;
        }

        $tousername = $this->Post("tousername", 'string');

        $sql = 'select * from cenwor_tttuangou_user_private_key where encrypt_public = "' . $tousername . '"';
        $query = $this->DatabaseHandler->Query($sql);
        if (!$encrypt = $query->GetRow()) {
            $this->Messager("收款地址不存在。", "?mod=me&code=contracttrans");
            exit;
        }


        $sql = 'select *  from ' . TABLE_PREFIX . 'system_members where uid = "' . $encrypt['uid'] . '"';
        $query = $this->DatabaseHandler->Query($sql);
        $touser = $query->GetRow();

        if (!$touser) {
            $this->Messager("收款账号不存在", "?mod=me&code=contracttrans");
            exit;
        }

        if ($touser['uid'] == $uid) {
            $this->Messager("不能给自己转账", "?mod=me&code=contracttrans");
            exit;
        }


        $money = $this->Post("tixiannum", 'float');
        $zfpassword = $this->Post("zfpassword", 'string');
        //验证开始
        //检测银行卡是不是自己的
        $yanzheng['wrate'] = 0.5;
        if ($money <= 0) {
            $this->Messager("转账余额应大于0", "?mod=me&code=contracttrans");
            exit;
        }
        $sxf = 0;
        if ($yanzheng['wrate'] == 0) {
            $sxf = 0;
        } else {
            $sxf = max($money * $yanzheng['wrate'] / 100.0, 1);
            $sxf = round($sxf, 2);
        }
        //检测金额是否大于余额
        $money_a = $this->Post("money_a", 'int');
        $lessType = '';
        if ($money_a == 1) {
            $lessType = 'dollar';
            $post['money_type'] = 1;
            if ($money + $sxf > user()->get('dollar')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 3) {
            $lessType = 'hkdollar';
            $post['money_type'] = 2;
            if ($money + $sxf > user()->get('hkdollar')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 5) {
            $lessType = 'jpy';
            $post['money_type'] = 4;
            if ($money + $sxf > user()->get('jpy')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 6) {
            $lessType = 'krw';
            $post['money_type'] = 5;
            if ($money + $sxf > user()->get('krw')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 7) {
            $lessType = 'gbp';
            $post['money_type'] = 6;
            if ($money + $sxf > user()->get('gbp')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 8) {
            $lessType = 'aud';
            $post['money_type'] = 7;
            if ($money + $sxf > user()->get('aud')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 9) {
            $lessType = 'cad';
            $post['money_type'] = 8;
            if ($money + $sxf > user()->get('cad')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 10) {
            $lessType = 'chf';
            $post['money_type'] = 9;
            if ($money + $sxf > user()->get('chf')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 11) {
            $lessType = 'nzd';
            $post['money_type'] = 10;
            if ($money + $sxf > user()->get('nzd')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 12) {
            $lessType = 'sgd';
            $post['money_type'] = 11;
            if ($money + $sxf > user()->get('sgd')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 13) {
            $lessType = 'hkc';
            $post['money_type'] = 12;
            if ($money + $sxf > user()->get('hkc')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 14) {
            $lessType = 'money';
            $post['money_type'] = 13;
            if ($money + $sxf > user()->get('money')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 15) {
            $lessType = 'btc';
            $post['money_type'] = 14;
            if ($money + $sxf > user()->get('btc')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 16) {
            $lessType = 'eth';
            $post['money_type'] = 15;
            if ($money + $sxf > user()->get('eth')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else if ($money_a == 4) {
            $lessType = 'euro';
            $post['money_type'] = 3;
            if ($money + $sxf > user()->get('euro')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        } else {
            $lessType = 'money';
            $post['money_type'] = 0;
            if ($money + $sxf > user()->get('money')) {
                $this->Messager("转账余额应小于账户余额", "?mod=me&code=contracttrans");
                exit;
            }
        }

        //检测支付密码是否正确
        // var_dump($zfpassword, md5($zfpassword), $encrypt['pwd']);exit;


        if (sha1(md5('testdescryptionwoshisunzhen') . md5($zfpassword)) != $from['pwd']) {

            if ($_SESSION['try_times'] >= 3) {
                $_SESSION['is_lock'] = 1;
                $_SESSION['lock_time'] = time();
                $this->Messager("合约支付密码错误已达上限，匿名转账功能已锁定。(于" . (20) . "秒后解锁)", "?mod=me&code=contracttrans");
                exit;
            }
            $_SESSION['try_times']++;

            $this->Messager("合约支付密码错误", "?mod=me&code=contracttrans");
            exit;
        }


        $post['touid'] = $touser['uid'];
        $post['username'] = user()->get("name");
        $post['tousername'] = $touser['username'];
        $post['value'] = $money + $sxf;
        $post['tovalue'] = $money;
        $post['sxfl'] = $yanzheng['wrate'];
        $post['mark'] = trim($_POST['mark']);
        $post['addtime'] = time();
        $post['statue'] = 2;
        $post['is_private'] = 1;

        $new_id = logic('zhanneilist')->Add($uid, $post);
        if ($post['money_type'] == 0) {
            //用户金额减少
            $lessType = 'CNY';
            logic('me')->money()->less($post['value'], $uid, array(
                'name' => 'zz',
                'intro' => $new_id,
                'is_confirm' => 0,
                'is_private' => 1,
            ));
            logic('me')->money()->add($post['tovalue'], $post['touid'], array(
                'name' => 'zn',
                'intro' => $new_id,
                'is_confirm' => 0,
                'is_private' => 1,
            ));
        } else {
            logic('me')->money()->less($post['value'], $uid, array(
                'name' => 'zz',
                'intro' => $new_id,
                'is_' . $lessType => 1,
                'is_confirm' => 0,
                'is_private' => 1,
            ), $post['money_type']);
            logic('me')->money()->add($post['tovalue'], $post['touid'], array(
                'name' => 'zn',
                'intro' => $new_id,
                'is_' . $lessType => 1,
                'is_confirm' => 0,
                'is_private' => 1,
            ), $post['money_type']);
            $lessType = strtoupper($lessType);
        }


        logic('push')->addi('sms', $touser['phone'], array('content' => "匿名用户:" . $from['encrypt_public'] . "向您账户转入" . $lessType . $post['tovalue'] . "元"));
        if ($_GET['type'] == 1) {
            $this->Messager("转账成功！", "?mod=me&code=wapbill");
        } else {
            $this->Messager("转账成功！", "?mod=me&code=bill");
        }

    }

    function contracttrans()
    {

        $uid = user()->get('id');
        $sql = 'SELECT * FROM ' . table('user_private_key') . ' WHERE uid=' . $uid;

        if (!$d = dbc(DBCMax)->query($sql)->limit(1)->done()) {
            exit('您尚未设置合约地址。');
        }

        $public = $d['encrypt_public'];


        $addressList = logic('yinhangka')->GetXinyongKaList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        $yanzheng['wrate'] = 0.5;

        $ac = logic('yanzheng')->GetOneAC(user()->get('id'));
        ini_set("display_errors", "On");//打开错误提示
        ini_set("error_reporting", E_ALL);//显示所有错误
        include handler('template')->file('@wap/contract_trans');
    }


    function contracttrans_nm()
    {

        session_start();
        $username_nm = $_SESSION['username_nm'];


        /*
		 $uid =  user()->get('id');

		 print_r("uid=");
		 print_r($uid);


		 $export = Reflection::export( new ReflectionFunction("user") ,true);
		 print_r("user=");
		 print_r($export);

		 $export1 = Reflection::export( new ReflectionFunction("logic") ,true);
		 print_r("logic=");
		 print_r($export1);



		 $sql = 'SELECT * FROM ' . table('user_private_key') . ' WHERE uid='.$uid;

		if(!$d = dbc(DBCMax)->query($sql)->limit(1)->done()) {
			exit('您尚未设置合约地址。');
		}

		$public = $d['encrypt_public'];
		*/

        $addressList = logic('yinhangka')->GetXinyongKaList(user()->get('id'));

        $yanzheng = logic('yanzheng')->GetOne(user()->get('id'));

        $yanzheng['statue'] || $yanzheng['statue'] = 0;

        $yanzheng['wrate'] = 0.5;

        $ac = logic('yanzheng')->GetOneAC(user()->get('id'));

        ini_set("display_errors", "On");//打开错误提示
        ini_set("error_reporting", E_ALL);//显示所有错误
        include handler('template')->file('@wap/contract_trans_nm');
    }


    function createcontractpwd()
    {
        //ini_set('display_errors', 'On');
        //ini_set('error_reporting', E_ALL);

        //var_dump("123");
        //print_r("101010");

        $public = "";

        //include handler('template')->file('@wap/create_contractpwd');

        //var_dump("456");
        //print_r("202020");

        /*ini_set('display_erros', 'On');
		ini_set('error_reporting', E_ALL);
		var_dump(file_put_contents(__DIR__ . '/test.txt', 'test'));
		echo 'test';exit;
		*/
        //var_dump(file_put_contents(__DIR__ . '/test.txt', 'test'));

        /*
		if(@$_POST['public']) {
			$public = $_POST['public'];

			$private = $_POST['private'];

			$uid =  user()->get('id');

			$res = $this->DatabaseHandler->Query('
			 INSERT INTO `cenwor_tttuangou_user_private_key`( `uid`, `encrypt_private`, `encrypt_public`, `create_time`) VALUES ("'.$uid.'", "'.$private.'", "'.$public.'", "'.date('Y-m-d H:i:s').'");
			 ');

			if($res) {
				//保存成功
				header('location: /?mod=me&code=createcontractpwd&public='.$public);
				exit;

			} else {
				//保存失败
				exit('系统处理出错，请联系管理员。');
			}
		}
		*/


        if (@$public == "") {
            loadClass('sample_rsa');
            $ob = new sample_rsa();
            $key = $ob->createKey();
            $public = $key['publicKey'][0] . '' . $key['publicKey'][1];
            $private = $key['privateKey'][0] . '' . $key['privateKey'][1];

            $public = base64_encode($public) . '=0';
            $private = base64_encode($private) . '=0';

            $puslength = 42 - strlen($public);
            $public = $this->randomStrings(16);
            $prslength = 64 - strlen($private);
            $private .= $this->randomString($prslength);
        }


        //include handler('template')->file('@wap/create_contractpwd');

        //include handler('template')->file('@wap/create_contractpwd');


        //$public = $_GET['public'];


        //global $public_global=$_GET['public'];
        //自己改的
        //$public =$_POST['public'];

        //var_dump('打印的$public=');
        //var_dump($public);
        //$public1 = @$_POST['public'];


        if (@$_POST['pwd']) {
            //交易密码
            $pin = @$_POST['pin'];
            //助记词
            $words = @$_POST['words'];
            $public1 = @$_POST['public'];

            $uid = user()->get('id');
            $sql = 'SELECT * FROM ' . table('user_private_key') . ' WHERE uid=' . $uid;

            //自己改的
            //$sql = 'SELECT * FROM ' . table('user_private_key') . ' WHERE encrypt_public='.$public;


            if (!$pwd = $_POST['pwd']) {
                $msg = ('密码不能为空。');
            }
            $msg = false;
            if (strlen($pwd) < 8) {
                $msg = ('密码需大于8位。');
            }
            $lower_arr = array();
            $lower = 'abcdefghijklmnopqrstuvwxyz';
            for ($i = 0; $i < strlen($lower); $i++) {
                $lower_arr[] = substr($lower, $i, 1);
            }
            $upper_arr = array();
            $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            for ($i = 0; $i < strlen($upper); $i++) {
                $upper_arr[] = substr($upper, $i, 1);
            }
            $num_arr = array();
            $num = '0123456789';
            for ($i = 0; $i < strlen($num); $i++) {
                $num_arr[] = substr($num, $i, 1);
            }

            $pwdstr = array();
            $hasLower = false;
            $hasUpper = false;
            $hasNum = false;

            for ($i = 0; $i < strlen($pwd); $i++) {
                $str = substr($pwd, $i, 1);
                if (in_array($str, $lower_arr)) {
                    $hasLower = true;
                }

                if (in_array($str, $upper_arr)) {
                    $hasUpper = true;
                }

                if (in_array($str, $num_arr)) {
                    $hasNum = true;
                }
            }
            if (!$hasLower) {
                $msg = ('密码需要包含小写字母。');
            }
            if (!$hasUpper) {
                $msg = ('密码需要包含大写字母。');
            }
            if (!$hasNum) {
                $msg = ('密码需要包含数字。');
            }
            if ($msg != false) {
                include handler('template')->file('@wap/create_contractpwd');
                exit;
            }
            $pwd_md5 = $pwd;
            //var_dump('打印的public=');
            //var_dump($public);
            //自己改的
            $res = $this->DatabaseHandler->Query('
			 INSERT INTO `cenwor_tttuangou_user_private_key`( `uid`, `encrypt_private`, `encrypt_public`, `create_time`,`pwd`,`pin`,`words`) VALUES ("' . $uid . '", "' . $private . '", "' . $public1 . '", "' . date('Y-m-d H:i:s') . '","' . $pwd_md5 . '", "' . $pin . '", "' . $words . '")
			');
            //$res1=$this->DatabaseHandler->Query("UPDATE `cenwor_tttuangou_user_private_key` SET pwd='".$pwd_md5."',pin='".$pin."',words='".$words."'  WHERE encrypt_public='". $public1"' ");
            //$res = $this->DatabaseHandler->Query("UPDATE `cenwor_tttuangou_user_private_key` SET pwd='".$pwd_md5."',pin='".$pin."',words='".$words."'  WHERE encrypt_public='". $public1"' ");

            if($res){
                $this->Messager("注册成功!","?mod=wap&code=account&op=login1",5);
                //exit;
            } else {
            //保存失败
            exit('系统处理出错1，请联系管理员。');
            }

            //从实名那里复制过来
            $truename=$public1;
            $email="123456@qq.com";
            $phone="12345678987";
            $zfpwd=$pin;

            $rresult = account()->Register_nm($truename, $pwd, $email, $phone,'',FALSE,$zfpwd);
            if ($rresult['error'])
            {
                $this->Messager($rresult['result'], -1);
            }
            /*
            if ( ! ini('product.default_emailcheck'))
            {
                $keepLogin = true;
                $lresult = account()->Login($truename, $pwd, $keepLogin);
                if ($lresult['error'])
                {
                    $this->Messager('注册成功，自动登录失败：'.$lresult['result'], -1);
                }
                $ref = account()->loginReferer();
                $ref || $ref = '?mod=me';
                $ucsynlogin = $lresult['result'];
                if ( post('showemail') )
                {
                    logic('subscribe')->Validate(logic('subscribe')->Add($city, 'mail', $email));

                    logic('subscribe')->Validate(logic('subscribe')->Add($city, 'sms', $phone));

                }
            */
                //$this->Messager("注册成功{$ucsynlogin}", $ref);
            //$this->Messager("注册成功");
            print_r("注册成功111");
            exit;

            }
        //$res = $this->DatabaseHandler->Query('
        // UPDATE `cenwor_tttuangou_user_private_key` SET pwd="'. sha1( md5('testdescryptionwoshisunzhen') . md5( $pwd) ) .'" ,pin="'.$pin.'",words="'.$words.'" WHERE uid='.$uid);
        include handler('template')->file('@wap/create_contractpwd');

        //$timeStr = date('Y-m-d H:m:s',time());
        //自己改的
        //$pwd_md5 =  sha1( md5('testdescryptionwoshisunzhen') . md5( $pwd) );

        /*
		$res = $this->DatabaseHandler->Query("INSERT INTO `cenwor_tttuangou_user_private_key` (`id`, `uid`, `encrypt_private`, `encrypt_public`, `create_time`, `public`, `pwd`, `pin`, `words`) VALUES (NULL, '-1', '', '', '".$timeStr."', '".$public."', '".$pwd_md5."', '".$pin."', '".$words."')");
		*/


        //自己改的，之前成功的
        /*
		var_dump('打印的public1=');
		var_dump($public1);
		$res = $this->DatabaseHandler->Query('UPDATE `cenwor_tttuangou_user_private_key` SET pwd="'.$pwd_md5.'",pin="'.$pin.'",words="'.$words.'"  WHERE encrypt_public='. $public1 );
		*/
    }

    function createcontract()
    {
        ini_set('display_errors', 'On');
        ini_set('error_reporting', E_ALL);

        /*ini_set('display_erros', 'On');
		ini_set('error_reporting', E_ALL);
		var_dump(file_put_contents(__DIR__ . '/test.txt', 'test'));
		echo 'test';exit;
		*/
        //var_dump(file_put_contents(__DIR__ . '/test.txt', 'test'));


        if (@$_POST['public']) {
            $public = $_POST['public'];

            $private = $_POST['private'];

            $uid = user()->get('id');

            $res = $this->DatabaseHandler->Query('
			 INSERT INTO `cenwor_tttuangou_user_private_key`( `uid`, `encrypt_private`, `encrypt_public`, `create_time`) VALUES ("' . $uid . '", "' . $private . '", "' . $public . '", "' . date('Y-m-d H:i:s') . '")
			 ');

            if ($res) {
                //保存成功
                header('location: /?mod=me&code=createcontractpwd&public=' . $public);
                exit;

            } else {
                //保存失败
                exit('系统处理出错，请联系管理员。');
            }
        }


        loadClass('sample_rsa');
        $ob = new sample_rsa();
        $key = $ob->createKey();

        $public = $key['publicKey'][0] . '' . $key['publicKey'][1];
        $private = $key['privateKey'][0] . '' . $key['privateKey'][1];


        $public = base64_encode($public) . '=0';
        $private = base64_encode($private) . '=0';


        $puslength = 42 - strlen($public);

        $public = $this->randomStrings(16);

        $prslength = 64 - strlen($private);

        $private .= $this->randomString($prslength);


        include handler('template')->file('@wap/create_contract');
    }

    function randomStrings($length, $arr = false)
    {
        $abc = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        if ($arr) {
            $str = array();
        } else {
            $str = '';
        }
        for ($i = 0; $i < $length; $i++) {
            $s = $abc[mt_rand(1, 10) - 1];
            if ($arr) {
                $str[] = $s;
            } else {
                $str .= $s;
            }
        }
        return $str;
    }

    function randomString($length, $arr = false)
    {
        $abc = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        if ($arr) {
            $str = array();
        } else {
            $str = '';
        }
        for ($i = 0; $i < $length; $i++) {
            $s = $abc[mt_rand(1, 62) - 1];
            if ($arr) {
                $str[] = $s;
            } else {
                $str .= $s;
            }
        }
        return $str;
    }

    function wapask()
    {

        include handler('template')->file('@wap/my_ask');
    }

    function wapyanzheng()
    {

        include handler('template')->file('@wap/my_yanzheng');
    }

    function wapnoyanzheng()
    {

        include handler('template')->file('@wap/my_noyanzheng');
    }

    function wapget_password()
    {

        include handler('template')->file('@wap/get_password');
    }

    function wapbill2()
    {

        include handler('template')->file('@wap/my_bill2');
    }

    function wapsp1()
    {

        session_start();

        $username_nm = $_SESSION['username_nm'];

        include handler('template')->file('@wap/my_sp1');
    }

    function wapsetting2()
    {

        include handler('template')->file('@wap/my_setting2');
    }


    function wapsetting_nm()
    {
        session_start();

        $username_nm = $_SESSION['username_nm'];

        include handler('template')->file('@wap/my_setting2');
    }


    function wapxq()
    {

        include handler('template')->file('@wap/my_xq');
    }

    function __AddressCheckOns($id)
    {
        return false;
        $sql = 'SELECT COUNT(orderid) AS CNT FROM ' . TABLE_PREFIX . 'tttuangou_order WHERE addressid=' . $id . ' AND status IN(1,4)';
        $query = $this->DatabaseHandler->Query($sql)->GetRow();
        if ($query['CNT'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function log_result($word)
    {
        $fp = fopen("log.txt", "a");
        flock($fp, LOCK_EX);
        fwrite($fp, $word . "：执行日期：" . strftime("%Y%m%d%H%I%S", time()) . "\t\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }

}
?>
