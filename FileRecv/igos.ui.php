<?php

/**
 * 界面支持：产品展示
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package UserInterface
 * @name igos.ui.php
 * @version 1.0
 */

class iGOSUI
{
	
	public function load($product)
	{
		$style = ini('ui.igos.style');
		$style || $style = 'default';
		if ($style == 'm1selse' && get('page', 'int') > 1)
		{
						$style = 'meituan';
		}

        if($this->checkwap()){

            include handler('template')->file('@html/igos/'.$style.'/index_wap');

        }else{
            include handler('template')->file('@html/igos/'.$style.'/index');

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









}

?>