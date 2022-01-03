<?php
/**
 * Config File of [service]
 *
 * @time 2011-06-14 18:16:14
 */


header("content-type:text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers:Origin,X-Requested-With,Content-Type,Accept");
header("Access-Control-Allow-Methods:GET,POST,PUT");
$config["service"] =  array (
  'mail' => 
  array (
    'balance' => true,
  ),
  'sms' => 
  array (
    'driver' => 
    array (
      'ls' => 
      array (
        'name' => '电信通道',
        'intro' => '075开头，网关短信直发，价格便宜（自动重发功能暂时只支持此通道）<br/><a href="'.ihelper('tg.shop.sms.ls').'" target="_blank"><font color="red"></font></a>',
      ),
      'qxt' => 
      array (
        'name' => '最新的短信接口',
        'intro' => ' 最新的',
      ),
    ),
    'autoERSend' => true,
  ),
  'push' => 
  array (
    'mthread' => false,
  ),



);
?>