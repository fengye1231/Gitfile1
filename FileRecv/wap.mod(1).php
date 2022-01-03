<?php

/**
 * 模块：WAP
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name wap.mod.php
 * @version 1.0
 */

class ModuleObject extends MasterObject
{
    function ModuleObject( $config )
	
	
	
    {
		/*
		$masterObject=new MasterObject();
		$object = new ReflectionObject($masterObject);
		$method = $object->getMethod('__initComponents');
		$declaringClass = $method->getDeclaringClass();
		$filename = $declaringClass->getFilename();
	
		//var_dump("调试输出filename");
		print_r("调试输出wap.mod.php中filename=");
		print_r($filename)；
		print_r("在wap.mod.php中")；
		*/
		
		
		
		
        $this->MasterObject($config);
        $runCode = Load::moduleCode($this);
        $this->$runCode();
    }
    function Main()
    {
        include handler('template')->file('@wap/index');
    }
/* 	
	public function account_login1()
	{
		$username = post('username', 'txt');
		$password = post('password', 'txt');
		$loginR = account()->Login($username, $password, true); 		
		if ($loginR['error']) {	
			$time = 2;
			$errmsg = $message= $loginR['result'];
			$redirectto = "?mod=wap&code=account_login";
			include handler('template')->file('@wap/account_done');
		} else {
			if($_GET['to']) {
				header('Location: '. base64_decode($_GET['to']));
			} else {
				header('Location: '.'/index.php?mod=wap');
			}

		}
	}
	 */
    public function account_login()
	{
		include handler('template')->file('@wap/account_login');
	}
	public function account_wapsm2(){

        include handler('template')->file('@wap/my_sm2');
    }
	
    public function account_login1()
	{
		include handler('template')->file('@wap/account_login1');
	}
	
	public function create_contract()
	{
		include handler('template')->file('@wap/create_contract');
	}
   public function my_yanzheng()
	{
		include handler('template')->file('@wap/my_yanzheng');
	}
   public function my_noyanzheng()
	{
		include handler('template')->file('@wap/my_noyanzheng');
	}
   public function get_password()
	{
		include handler('template')->file('@wap/get_password');
	}
	
	public function get_password_nm()
	{
		//print_r("进入到了get_password_nm函数里");


		//$msg = '';
        //$obvious= '';


        if (@$_POST['zhanghao']  and @$_POST['zjwords'] )
        {
            $zhanghao=@$_POST['zhanghao'];
            $zjwords=@$_POST['zjwords'];

        /*
            if (empty($zhanghao)){
                $msg='账号不能为空！';

                exit;

            }

            if (empty($zjwords)){
                $msg='助记词不能为空！';
                exit;
            }

            if (strlen($zjwords) < 8) {
                $msg = '助记词需大于等于8位！';
                exit;
            }
        */

                //$sql = 'SELECT words FROM cenwor_tttuangou_user_private_key WHERE encrypt_public='.$username;

            $sql ='select pwd  from cenwor_tttuangou_user_private_key where encrypt_public="' . $zhanghao.'" and words="' . $zjwords.'"   ';

            $query = $this->DatabaseHandler->Query($sql)->GetRow();

            //print_r("query=");
            //print_r($query);

            $obvious=$query['pwd'];
            if ($obvious){
                $msg='';
                include handler('template')->file('@wap/display_pwd');
                //header('Location: '.'/?mod=wap&code=get&op=password_nm');
                exit;

            } else{
               $msg = '用户名或助记词输入错误，请重新输入！';
                include handler('template')->file('@wap/display_pwd');
                //header('Location: '.'/?mod=wap&code=get&op=password_nm');
                exit;
            }

		    }

        include handler('template')->file('@wap/display_pwd');


        }


	
	

public function Exists()
	{
		$field = get('field', 'txt');
		$value = get('value');
		if (false != $f = filter($value))
		{
			exit(jsonEncode(array('status'=>'failed','result'=>$f)));
		}
		$allows = array(
			'email', 'name', 'phone'
		);
		if (false !== array_search($field, $allows))
		{
			if ($field == 'phone' && !ini('member.phone.unique'))
			{
				$r = false;
			}
			else
			{
				$r = account()->Exists($field, $value);
			}
			$ops = array(
				'status' => 'ok',
				'result' => $r
			);
		}
		else
		{
			$ops = array(
				'status'=>'failed',
				'result' => __('未允许字段')
			);
		}
		exit(jsonEncode($ops));
	}
	function Activate()
	{
		$this->Messager("您还没有通过邮箱验证呢！<a href='?mod=account&code=sendcheckmail&uname=" . urlencode(user()->get('name')) . "'>点这里重新发送认证邮件  </a>", 0);
	}
	
	function Confirm()
	{
		$pwd = get('pwd');
		if ( $pwd == '' ) $this->Messager(__("错误！"));
		$pwdT = authcode(urldecode($pwd), 'DECODE', ini('settings.auth_key'));
		if ($pwdT == '')
		{
						$pwd = authcode($pwd, 'DECODE', ini('settings.auth_key'));
		}
		else
		{
			$pwd = $pwdT;
		}
		if ($pwd == '') $this->Messager('邮箱认证失败，请重发认证邮件或联系网站管理员进行人工审核！', 0);
		$sql = 'select * from ' . TABLE_PREFIX . 'system_members where truename = \'' . $pwd . '\'';
		$query = $this->DatabaseHandler->Query($sql);
		$user = $query->GetRow();
		if ( $user == '' || $user['checked'] == 1 ) $this->Messager(__("用户不存在或已经通过验证！"));
		$ary = array( 
			'checked' => 1 
		);
		$this->DatabaseHandler->SetTable(TABLE_PREFIX . 'system_members');
		$result = $this->DatabaseHandler->Update($ary, 'truename = \'' . $pwd . '\'');
		$this->Messager(__("邮箱认证成功！请重新登录"), rewrite('?mod=account&code=login'));
	}

	
	function Login()
	{
		if ( MEMBER_ID != 0 and false == $this->IsAdmin )
		{
			$this->Messager("您已经使用用户名 " . MEMBER_NAME . " 登录系统，无需再次登录！", null);
		}
		$loginperm = $this->_logincheck();
		if ( ! $loginperm )
		{
			$this->Messager("累计 5 次错误尝试，15 分钟内您将不能登录。", null);
		}
		$this->Title = "用户登录";
		
		$action = "?mod=account&code=login&op=done&to=".$_GET['to'];
		$question_select = FormHandler::Select("question", ConfigHandler::get("member", "question_list"), 0);
		$role_type_select = FormHandler::Radio("role_type", ConfigHandler::get("member", "role_type_list"), "normal");
		account()->loginReferer($_SERVER['HTTP_REFERER']);
		//include ($this->TemplateHandler->Template("account_login"));
		 include handler('template')->file('@wap/account_login');
	}

	
	function Login_done()
	{
		$loginperm = $this->_logincheck();
		if ( ! $loginperm )
		{
			$this->Messager("累计 5 次错误尝试，15 分钟内您将不能登录。", null);
		}
		$user = account()->Search('name', $this->Username, 1);
				if ( $user && $user['role_id'] != 2 && $user['checked'] == 0 && ini('product.default_emailcheck') )
		{
			header('Location: '.rewrite('?mod=account&code=activate'));exit;
		}
		$loginR = account()->Login($this->Username, $this->Password, ($_POST['keeplogin'] == 'on'));
		if ($loginR['error'])
		{
			$this->_loginfailed($loginperm);
			$this->Messager($loginR['result'], -1);
		}
		$ref = account()->loginReferer();
		$ref || $ref = '?mod=me';
		if($_GET['to']) {
				header('Location: '. base64_decode($_GET['to']));
			} else {
		$this->Messager(__('登录成功！').$loginR['result'], $ref);
		}
	}
	
	function Login_union()
	{
		$flag = get('flag', 'txt');
		if (!$flag || !ini('alipay.account.login.source.'.$flag)) exit('ERROR: no Union Login Request');
		$html = account('ulogin')->linker($flag);
		include handler('template')->file('@account/login/redirect');
	}
	function Login_callback()
	{
		$from = get('from', 'txt');
		$uuid = account('ulogin')->verify($from);
		if ($uuid !== false)
		{
			if (meta($uuid))
			{
								$result = account('ulogin')->login($uuid);
				$ref = account()->loginReferer();
				$ref || $ref = '?mod=me';
				$this->Messager(__('登录成功！').$result, $ref);
			}
			else
			{
								$data = account('ulogin')->ddata($from);
								include handler('template')->file('account_active');
			}
		}
		else
		{
			$this->Messager(__('快捷登录验证出错！'));
		}
	}
	function Login_active()
	{
		$uuid = post('uuid', 'txt');
		$username = post('username');
		$password = post('password');
		$mail = post('mail', 'txt');
		if (!$mail || !check_email($mail))
		{
			$this->Messager(__('请输入正确的Email地址！'), -1);
		}
		$phone = post('phone', 'number');
		if (!$phone)
		{
			$this->Messager('请输入正确的手机号码！', -1);
		}
		if (ini('member.phone.unique') && account()->Exists('phone', $phone))
		{
			$this->Messager(__('您输入的手机号码已被使用，请重新输入！'), -1);
		}
		$subs = post('subs');
				$result = account('ulogin')->active($uuid, $username, $password, $mail);
		if (!$result)
		{
			$this->Messager(__('帐号激活失败！'));
		}
				if ($subs)
		{
			logic('subscribe')->Add(logic('misc')->City('id'), 'mail', $mail, 'true');
		}
				if ($phone && strlen($phone) == 11)
		{
			user($result)->set('phone', $phone);
			if ($subs)
			{
				logic('subscribe')->Add(logic('misc')->City('id'), 'sms', $phone, 'true');
			}
		}
				$result = account('ulogin')->login($uuid);
		$ref = account()->loginReferer();
		$ref || $ref = '?mod=me';
		$this->Messager(__('登录成功！').$result, $ref);
	}

	
	function _updateLoginFields( $uid )
	{
		$timestamp = time();
		$last_ip = getenv('REMOTE_ADDR');
		$sql = "
		UPDATE
			" . TABLE_PREFIX . 'system_members' . "
		SET
			`login_count`='login_count'+1,
			`lastvisit`='{$timestamp}',
			`lastactivity`='{$timestamp}',
			`lastip`='{$last_ip}'
		WHERE 
			uid={$uid}";
		$query = $this->DatabaseHandler->Query($sql);
		Return $query;
	}

	
	function Logout()
	{
		$logoutR = account()->Logout(MEMBER_NAME);

		$this->Messager($logoutR['result'] . '退出成功', '?index');

	}

	function _logincheck()
	{
		$onlineip = $_SERVER['REMOTE_ADDR'];
		$timestamp = time();
		$query = $this->DatabaseHandler->Query("SELECT count, lastupdate FROM " . TABLE_PREFIX . 'system_failedlogins' . " WHERE ip='$onlineip'");
		if ( $login = $query->GetRow() )
		{
			if ( $timestamp - $login['lastupdate'] > 900 )
			{
				return 3;
			}
			elseif ( $login['count'] < 5 )
			{
				return 2;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 1;
		}
	}

	function _loginfailed( $permission )
	{
		$onlineip = $_SERVER['REMOTE_ADDR'];
		$timestamp = time();
		switch ( $permission )
		{
			case 1 :
				$this->DatabaseHandler->Query("REPLACE INTO " . TABLE_PREFIX . 'system_failedlogins' . " (ip, count, lastupdate) VALUES ('$onlineip', '1', '$timestamp')");
				break;
			case 2 :
				$this->DatabaseHandler->Query("UPDATE " . TABLE_PREFIX . 'system_failedlogins' . " SET count=count+1, lastupdate='$timestamp' WHERE ip='$onlineip'");
				break;
			case 3 :
				$this->DatabaseHandler->Query("UPDATE " . TABLE_PREFIX . 'system_failedlogins' . " SET count='1', lastupdate='$timestamp' WHERE ip='$onlineip'");
				$this->DatabaseHandler->Query("DELETE FROM " . TABLE_PREFIX . 'system_failedlogins' . " WHERE lastupdate<$timestamp-901", 'UNBUFFERED');
				break;
		}
	}


	public function account_register_1() {
	$step = trim($_GET['step']);
		
		$step || $step = "1";
	
		if($step==2)
		{
		$id = get("id","int");
		$info = logic("zhuce")->GetOne($id);
		
			if($info['ecode'] != post("vcode"))
			{
			$this->Messager("验证出错", -1);
			exit;
			}
		}elseif($step==3)
		{
		$id = get("id","int");
		$info = logic("zhuce")->GetOne($id);
		
			if($info['pcode'] != post("vcode"))
			{
			$this->Messager("验证出错", -1);
			exit;
			}
		}
		
		$this->Title = __('注册');
		//include ($this->TemplateHandler->Template("account_register_".$step));
		$action = '?mod=wap&code=account_register_1&op=done&step='.$step.'&id='.$id;
        include handler('template')->file('@wap/account_register_'.$step);
    }




	public function account_mail_validate() {
        include handler('template')->file('@wap/account_mail_validate');
    }
	
	public function account_logcheck()
	{
		
		
		//print_r("调试输出：在wap.mod.php文件中account_logcheck函数中");
		//function_dump('post');
		//function_dump('account');
		$export = Reflection::export( new ReflectionFunction("account") ,true);
		//print_r("export=");
		//print_r($export);

		$username = post('username', 'txt');
		
		$export = Reflection::export( new ReflectionFunction("post") ,true);
		//print_r("post=");
		//print_r($export);
		
		
		//print_r("username=");
		//print_r($username);
		$password = post('password', 'txt');
		//print_r("password=");
		//print_r($password);
		$loginR = account()->Login($username, $password, true); 
		//print_r("loginR=");
		//print_r($loginR);
		
		

		
		if ($loginR['error'])
		{	
			$time = 2;
			$errmsg = $message= $loginR['result'];
			$redirectto = "?mod=wap&code=account_login";
			include handler('template')->file('@wap/account_done');
		}
		else
		{
			if($_GET['to']) {
				header('Location: '. base64_decode($_GET['to']));
			} else {
				//header('Location: '.'/index.php?mod=wap');							
				header('Location: '.'/?mod=me&code=wapsp');
				
			}
		    
		}
	}
	
	public function account_logchecknm()
	{
		
		
		//print_r("调试输出：在wap.mod.php文件中account_logchecknm函数中");
		//function_dump('post');
		//function_dump('account');
		//$export = Reflection::export( new ReflectionFunction("post") ,true);
		//print_r("export=");
		//print_r($export);

		$username = post('username', 'txt');
		if (strpos($username,'@')!= false){
							
			$time = 5;
			//$errmsg = $message= $loginR['result'];
			$errmsg = $message = '匿名用户不能包含邮箱';
			//$redirectto = "?mod=wap&code=account_login";
			//include handler('template')->file('@wap/account_done');
			$redirectto = "?mod=wap&code=account_login1";
			include handler('template')->file('@wap/account_done');
			exit();
			//header('Location: '.'/mod=wap&code=account&op=login1');
			
		}



		//$export = Reflection::export( new ReflectionFunction("post") ,true);
		//print_r("post=");
		//print_r($export);
		
		
		//print_r("username=");
		//print_r($username);
		$password = post('password', 'txt');
		//print_r("password=");
		//print_r($password);
		$loginR = account()->Login_nm($username, $password, true); 
		//print_r("loginR=");
		//print_r($loginR);
		
		

		
		if ($loginR['error'])
		{	
			$time = 5;
			$errmsg = $message= $loginR['result'];
			//$redirectto = "?mod=wap&code=account_login";
			//$redirectto = "?mod=wap&code=account_login";
			//include handler('template')->file('@wap/account_done');
			$redirectto = "?mod=wap&code=account_login1";
			include handler('template')->file('@wap/account_done');
			//header('Location: '.'/mod=wap&code=account&op=login1');
		}
		else
		{
			if($_GET['to']) {
				header('Location: '. base64_decode($_GET['to']));
			} else {
				//header('Location: '.'/index.php?mod=wap');
							
				header('Location: '.'/?mod=me&code=wapsp1');
				
			}
		    
		}
	}
	

	
	
	function function_dump($funcname) {
		try {
			if(is_array($funcname)) {
				$func = new ReflectionMethod($funcname[0], $funcname[1]);
				$funcname = $funcname[1];
			} else {
				$func = new ReflectionFunction($funcname);
			}
		} catch (ReflectionException $e) {
			echo $e->getMessage();
			return;
		}
		$start = $func->getStartLine() - 1;
		$end =  $func->getEndLine() - 1;
		$filename = $func->getFileName();
		echo "function $funcname defined by $filename($start - $end)\n";
		echo "*********";
		//print_r("function $funcname defined by $filename($start - $end)\n");
	
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function account_logout()
	{

		account()->Logout(MEMBER_NAME);
		header('Location: '.rewrite('?mod=wap&code=account&op=login'));
	}


    public function account_logout_nm()
    {
        //var_dump("MEMBER_NAME");
        //var_dump(MEMBER_NAME);
        account()->Logout(MEMBER_NAME);
        header('Location: '.rewrite('?mod=wap&code=account&op=login'));
    }


    public function account_logout_nm1()
    {
        //var_dump("MEMBER_NAME");
        //var_dump(MEMBER_NAME);
        account()->Logout(MEMBER_NAME);
        header('Location: '.rewrite('?mod=wap&code=account&op=login1'));
    }













	
	public function coupon_input()
	{
		$msgcode = get('msgcode');
		$number = get('number') ? get('number', 'number') : '';
		$password = get('password') ? get('password', 'number') : '';
		if ($msgcode)
		{
			$mmaps = array(
				'ops-success' => '验证消费成功！',
				'input-blank' => '请输入号码和密码！',
				'not-found' => '团购券输入无效！',
				'access-denied' => '此券不是您的产品！',
				'password-wrong' => '团购券密码错误！',
				'be-used' => '此券已经被使用了！',
				'be-overdue' => '此券已经过期了！',
				'be-invalid' => '此券已经失效了！'
			);
			$msg = isset($mmaps[$msgcode]) ? $mmaps[$msgcode] : '未知错误';
			if ($msgcode == 'ops-success')
			{
				$product = logic('coupon')->ProductGet(get('last'));
			}
		}
		include handler('template')->file('@wap/coupon_input');
	}
	
	public function coupon_verify()
	{
		$number = post('number') ? post('number', 'number') : '';
		$password = post('password') ? post('password', 'number') : '';
		if ($number && $password)
		{
			$result = logic('coupon')->MakeUsed($number, $password);
			if ($result['error'])
			{
				$this->coupon_input_msg($result['errcode'], $number, $password);
			}
			else
			{
				$this->coupon_input_msg('ops-success', '', '', $number);
			}
		}
		else
		{
			$this->coupon_input_msg('input-blank', $number, $password);
		}
	}
	
	private function coupon_input_msg($msgcode, $number = '', $password = '', $last = '')
	{
		$url = rewrite('index.php?mod=wap&code=coupon&op=input&msgcode='.$msgcode.'&number='.$number.'&password='.$password.'&last='.$last);
		header('Location: '.$url);
	}

    private function __vcode_generate()
    {
        $string = md5(time());
        return substr($string, 12, 6);
    }
	//手机验证码
	private function __vocde_getcode()
	{
		$code = rand(10000,99999).rand(0,9);
		return $code;
	}

	function account_register_1_done()
	{
		$step = trim($_GET['step']);
		$step || $step = "1";
		if($step==1)
		{
		   $email = post('email');
		   $email || $email = get('email');
		   if(!$email)
		   {
		   $this->Messager('Email 地址不能为空！', -1);
		   }
		   
		   if(!check_email($email))
		   {
		   	$this->Messager('Email格式不正确！', -1);
		   }
			if (logic('account')->Exists('mail', $email))
		   {
			$this->Messager('Email 地址已经被使用！', -1);
		    }
		   
		   $hasinfo = logic("zhuce")->GetOneByEmail($email);
		   if(!$hasinfo)
		   {
		   $code = $this->__vcode_generate();
		   $array = array("email"=>$email,"ecode"=>$code,"step"=>1);
		   $id = logic("zhuce")->add($array);
		  }else
		   {
		      $code = $hasinfo['ecode'];
		      $id = $hasinfo['id'];
		   } 
           
		    $subject = __('您正在注册，请验证！');
           //$send = "您好，请点击下面的地址继续注册：<a href='".ini("settings.site_url").rewrite('?mod=wap&code=account_register_1&id='.$id.'&step=2&vcode='.$code)."'>".ini("settings.site_url").rewrite('?mod=wap&code=account_register_1&id='.$id.'&step=2&vcode='.$code)."</a>  ";
		    $send = "请把这个验证码：".$code. "，填写到验证页面上。";
		   logic('push')->add("mail", $email, array('subject'=>$subject,'content'=>$send));
		  $action = '?mod=wap&code=account_register_1&step=2'.'&id='.$id;
		   //include ($this->TemplateHandler->Template("account_mail_validate"));
		   include handler('template')->file('@wap/account_mail_validate');
		   exit;
		}elseif($step==2)
		{
		   $email = post('email');
		   $email || $email = get('email');
		   
		   $hasinfo = logic("zhuce")->GetOneByEmail($email);
		   $id = $hasinfo['id'];
		   if(!$hasinfo)
		   {
		  $this->Messager("操作有误！", -1);
		  } 
		$phone = post('phone', 'number');
		$phone ||$phone=get('phone');
		if (!$phone)
		{
			$this->Messager('请输入正确的手机号码！', -1);
		}
		if (!preg_match('/[0-9]{8,12}/', $phone))
				{
					$this->Messager('请输入正确的手机号码！', -1);
				}
		if (ini('member.phone.unique') && account()->Exists('phone', $phone))
		{
			$this->Messager(__('您输入的手机号码已被使用，请重新输入！'), -1);
		}
		
		 $code = $this->__vocde_getcode();
		 $array = array("phone"=>$phone,"step"=>2,"pcode"=>$code);
		 logic("zhuce")->Update($id,$array);
		  
		 
          $send = "本次验证码为：$code";
		  logic('push')->addi('sms', $phone, array('content'=>$send));
		  $action = '?mod=wap&code=account_register_1&step=3'.'&id='.$id;
		  //include ($this->TemplateHandler->Template("account_sms_validate"));
		  include handler('template')->file('@wap/account_sms_validate');
		  exit;
		}
		elseif($step==3)
		{
		
		$pwd = post('pwd');
		$ckpwd = post('ckpwd');
				if ( $pwd != $ckpwd )
		{
			$this->Messager("两次密码输入不一致！", -1);
		}
			$zfpwd = post('zfpwd');
		$ckzfpwd = post('ckzfpwd');
				if ( $zfpwd != $ckzfpwd )
		{
			$this->Messager("两次支付密码输入不一致！", -1);
		}
		
		$truename = post('email');
		$email = post('email');
		$phone = post('phone', 'number');
		if (!$phone)
		{
			$this->Messager('请输入正确的手机号码！', -1);
		}

		$rresult = account()->Register($truename, $pwd, $email, $phone,'',FALSE,$zfpwd);
		if ($rresult['error'])
		{
			$this->Messager($rresult['result'], -1);
		}
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
			$this->Messager("注册成功{$ucsynlogin}", $ref);
		}
				$this->registmail($truename, $email);
		$this->Messager($r['result']."感谢您的注册，我们已经给您的邮箱发送了一封邮件请您登录邮箱激活账号！", 0);
		}
	}

		function registmail( $truename, $email )
	{
		$key = authcode($truename, 'ENCODE', ini('settings.auth_key'));
		$mail['title'] = $this->Config['site_name'] . '欢迎您！';
		$mail['content'] = $this->Config['site_name'] . '欢迎您的注册 ，<a href="' . $this->Config['site_url'] . '/?mod=wap&code=confirm&pwd=' . urlencode($key) . '">请点击这里激活账号</a>，或者复制 <br/>' . $this->Config['site_url'] . '/?mod=wap&code=confirm&pwd=' . urlencode($key) . '到浏览器中';
		logic('service')->mail()->Send($email, $mail['title'], $mail['content']);
	}

	function Sendcheckmail()
	{
		extract($this->Get);
		$uname = $uname;
				$sql = 'select * from ' . TABLE_PREFIX . 'system_members where username=\'' . $uname . '\' and checked = 0';
		$query = $this->DatabaseHandler->Query($sql);
		$user = $query->GetRow();
		if ( $user != '' )
		{
			$this->registmail($uname, $user['email']);
			$this->Messager("已经发送一封确认信件到您的邮箱去了，请注意查收！", 0);
		}
		$this->Messager("错误，该用户已确认信箱或不存在！", 0);
	}
}

?>