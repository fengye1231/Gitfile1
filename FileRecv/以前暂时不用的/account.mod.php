<?php

/**
 * 模块：账户相关
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name account.mod.php
 * @version 1.0
 */

class ModuleObject extends MasterObject
{
	public $Username = '';
	public $Password = '';
	public $Secques = '';
	public $IsAdmin = false;

	function ModuleObject( $config )
	{
		$this->MasterObject($config);
				$this->Username = isset($this->Post['username']) ? trim($this->Post['username']) : "";
		$this->Password = isset($this->Post['password']) ? trim($this->Post['password']) : "";
		$this->Secques = quescrypt($this->Post['question'], $this->Post['answer']);
		if ( MEMBER_ID > 0 )
		{
			$this->IsAdmin = $this->MemberHandler->HasPermission('member', 'admin');
		}
				$runCode = Load::moduleCode($this);
		$this->$runCode();
	}
	
	public function Main()
	{
		header('Location: '.rewrite('?mod=me'));
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
		include ($this->TemplateHandler->Template("account_login"));
	}
    function Login1()
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
		
		$action = "?mod=account&code=login1&op=done&to=".$_GET['to'];
		$question_select = FormHandler::Select("question", ConfigHandler::get("member", "question_list"), 0);
		$role_type_select = FormHandler::Radio("role_type", ConfigHandler::get("member", "role_type_list"), "normal");
		account()->loginReferer($_SERVER['HTTP_REFERER']);
		include ($this->TemplateHandler->Template("account_login1"));
	}
	
	function sm2()
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
		
		$action = "?mod=account&code=sm2&op=done&to=".$_GET['to'];
		$question_select = FormHandler::Select("question", ConfigHandler::get("member", "question_list"), 0);
		$role_type_select = FormHandler::Radio("role_type", ConfigHandler::get("member", "role_type_list"), "normal");
		account()->loginReferer($_SERVER['HTTP_REFERER']);
		include ($this->TemplateHandler->Template("my_sm2"));
	}
	
		function create_contract()
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
		
		$action = "?mod=account&code=create_contract&op=done&to=".$_GET['to'];
		$question_select = FormHandler::Select("question", ConfigHandler::get("member", "question_list"), 0);
		$role_type_select = FormHandler::Radio("role_type", ConfigHandler::get("member", "role_type_list"), "normal");
		account()->loginReferer($_SERVER['HTTP_REFERER']);
		include ($this->TemplateHandler->Template("create_contract"));
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
	
			header('location: ' . base64_decode($_GET['to']));exit;
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
		if($_GET['to']) {
			header('location. ' . base64_decode($_GET['to']));
		} else {
			$this->Messager(__('登录成功！').$result, $ref);
		}
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

	function Register()
	{
	$step = trim($_GET['step']);
		
		$step || $step = "1";
	
		if($step==2)
		{
		$id = get("id","int");
		$info = logic("zhuce")->GetOne($id);
		//var_dump($id,$info,post("vcode"));exit;
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
		$action = '?mod=account&code=register&op=done&step='.$step.'&id='.$id;
		include ($this->TemplateHandler->Template("account_register_".$step));
	}


    public function Register_nm($username, $password, $mail = '', $phone = '', $qq = '', $noExRegister = false,$zfpassword='')
    {
        /*
        $aCheckResult = $this->invaidAccount($username, $password, $mail);
        if ($aCheckResult)
        {
            return $this->ErrorInf($aCheckResult);
        }
        */

        if (logic('account')->Exists('name', $username))
        {
            return $this->ErrorInf('用户名已经存在！');
        }
        /*
        if (logic('account')->Exists('mail', $mail))
        {
            return $this->ErrorInf('Email 地址已经被使用！');
        }
        */

        if ($noExRegister)
        {
            $extend = array('ucuid' => 0);
        }

        /*
        else
        {
            $exRegister = $this->exRegister($username, $password, $mail);
            if ($exRegister['error'])
            {
                return $this->ErrorInf($exRegister['result']);
            }
            $extend = $exRegister['result'];
        }
        */
        $data = array(
            'username' => $username,
            'truename' => $username,
            'password' => $password,
            'phone' => (is_numeric($phone) ? $phone : ''),
            'email' => $mail,
            'role_id' => ini('settings.normal_default_role_id'),
            'checked' => ((ini('product.default_emailcheck') == '1') ? 0 : 1),
            'finder' => handler('cookie')->GetVar('finderid'),
            'findtime' => handler('cookie')->GetVar('findtime'),
            'ucuid' => $extend['ucuid'],
            'regip' => client_ip(),
            'lastip' => client_ip(),
            'regdate' => time(),
            'zfpassword' => $zfpassword,
        );
        $iid = dbc(DBCMax)->insert('members')->data($data)->done();
        if (!$iid)
        {
            return $this->ErrorInf('注册失败！（本地数据库错误）');
        }
        $data['password'] = $password;
        logic('notify')->Call($iid, 'logic.account.register.done', $data);
        return $this->SuccInf($iid);
    }


























    private function __vcode_generate()
    {
        //$string = md5(time());
        //return substr($string, 12, 6);
		return mt_rand(10000,99999);
    }
	//手机验证码
	private function __vocde_getcode()
	{
		$code = rand(10000,99999).rand(0,9);
		return $code;
	}
	function Register_done()
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
          // $send = "您好，请点击下面的地址继续注册：<a href='".ini("settings.site_url").rewrite('?mod=account&code=register&id='.$id.'&step=2&vcode='.$code)."'>".ini("settings.site_url").rewrite('?mod=account&code=register&id='.$id.'&step=2&vcode='.$code)."</a>  ";
		   
		    $send = "请把这个验证码：".$code. "，填写到验证页面上。";
			//<a href='".ini("settings.site_url").rewrite('?mod=account&code=register&id='.$id.'&step=2&vcode='.$code)."'>".ini("settings.site_url").rewrite('?mod=account&code=register&id='.$id.'&step=2&vcode='.$code)."</a>  ";
		   
		   logic('push')->add("mail", $email, array('subject'=>$subject,'content'=>$send));
		  
		   include ($this->TemplateHandler->Template("account_mail_validate"));
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
		  $action = '?mod=account&code=register&step=3'.'&id='.$id;
		  include ($this->TemplateHandler->Template("account_sms_validate"));
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
		$mail['content'] = $this->Config['site_name'] . '欢迎您的注册 ，<a href="' . $this->Config['site_url'] . '/?mod=account&code=confirm&pwd=' . urlencode($key) . '">请点击这里激活账号</a>，或者复制 <br/>' . $this->Config['site_url'] . '/?mod=account&code=confirm&pwd=' . urlencode($key) . '到浏览器中';
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