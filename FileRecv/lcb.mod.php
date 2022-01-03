<?php
	class ModuleObject extends MasterObject{
		function ModuleObject($config)
		{
			$this->MasterObject($config);
			if (MEMBER_ID < 1)
	        {
	            $this->Messager(__('请先登录！'), '?mod=account&code=login');
	        }
			$runCode = Load::moduleCode($this);
			Load::logic('me');
			$this->MeLogic = new MeLogic();
			$this->$runCode();
		}

		function main()
		{
			$product=ConfigHandler::get('product');
			if(stristr($_SERVER['HTTP_VIA'],"wap")){
				$a= true;
			}elseif(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){
				$a= true;
			}elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){
				$a= true;
			}else{
				   $a= false;   
			}
			if(!$a){
				include handler('template')->file("lcb");
			}else{
				include handler('template')->file('@wap/lcb');
			}
			
		}

		function zhuanchu()
		{
			$product=ConfigHandler::get('product');
			if(!empty($_POST['num']))
			{
				if(!is_numeric($_POST['num']))
				{
					$this->Messager(__('请输入数字！'), '?mod=lcb&code=zhuanchu');
				}
				
				if($_POST['num'] <=0)
				{
					$this->Messager(__('输入金额无效！'), '?mod=lcb&code=zhuanchu');
				}

				$userinfo=user()->get('*');

				if($userinfo['zfpassword']!=md5($_POST['password']))
				{
					$this->Messager(__('请输入正确的密码！'), '?mod=lcb&code=zhuanchu');
				}
				
				$is_hkc = 0;
				switch($_POST['money_category']) {
					case 'hkc':
					if($userinfo['lcb_hkc_money']<$_POST['num'])
					{
						$this->Messager(__('币息宝HKC余额不足！'), '?mod=lcb&code=zhuanchu');
					}
					user()->set('lcb_hkc_money',$userinfo['lcb_hkc_money']-$_POST['num']);
					$is_dollar = 12;
					$is_hkc = 1;
					$intro = '<b>币息宝HKC余额:</b>'.($userinfo['lcb_hkc_money']-$_POST['num']);
					break;
					
					default:
					if($userinfo['lcb_money']<$_POST['num'])
					{
						$this->Messager(__('币息宝DCEP余额不足！'), '?mod=lcb&code=zhuanchu');
					}
					user()->set('lcb_money',$userinfo['lcb_money']-$_POST['num']);
					$is_dollar = 0;
					
					$intro = '<b>币息宝DCEP余额:</b>'.($userinfo['lcb_money']-$_POST['num']);
					break;
				}				

				$this->MeLogic->money()->add($_POST['num'],$userinfo['id'],array('name'=>'币息宝转出','intro'=>$intro, 'is_hkc'=>$is_hkc), $is_dollar);
				$this->MeLogic->money()->less($_POST['num'],347,array('name'=>'币息宝转出','intro'=>'用户转出：'.$userinfo['email'], 'is_hkc'=>$is_hkc), $is_dollar);
				$this->Messager(__('转出成功！'), '?mod=lcb');
			}
			if(stristr($_SERVER['HTTP_VIA'],"wap")){
				$a= true;
			}elseif(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){
				$a= true;
			}elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){
				$a= true;
			}else{
				   $a= false;   
			}
			if(!$a){
				include handler('template')->file("lcb_zhuanchu");
			}else{
				include handler('template')->file('@wap/lcb_zhuanchu');
			}
			
		}
		function wapzhuanchu()
		{
			$product=ConfigHandler::get('product');
			if(!empty($_POST['num']))
			{
				
				if(!is_numeric($_POST['num']))
				{
					$this->Messager(__('请输入数字！'), '?mod=lcb&code=wapzhuanchu');
				}
				
				if($_POST['num'] <=0)
				{
					$this->Messager(__('输入金额无效！'), '?mod=lcb&code=wapzhuanchu');
				}

				$userinfo=user()->get('*');

				if($userinfo['zfpassword']!=md5($_POST['password']))
				{
					$this->Messager(__('请输入正确的密码！'), '?mod=lcb&code=wapzhuanchu');
				}
				
				$is_hkc = 0;
				switch($_POST['money_category']) {
					case 'hkc':
					if($userinfo['lcb_hkc_money']<$_POST['num'])
					{
						$this->Messager(__('币息宝HKC余额不足！'), '?mod=lcb&code=wapzhuanchu');
					}
					user()->set('lcb_hkc_money',$userinfo['lcb_hkc_money']-$_POST['num']);
					$is_dollar = 12;
					$is_hkc = 1;
					$intro = '<b>币息宝HKC余额:</b>'.($userinfo['lcb_hkc_money']-$_POST['num']);
					break;
					
					default:
					if($userinfo['lcb_money']<$_POST['num'])
					{
						$this->Messager(__('币息宝DCEP余额不足！'), '?mod=lcb&code=wapzhuanchu');
					}
					user()->set('lcb_money',$userinfo['lcb_money']-$_POST['num']);
					$is_dollar = 0;
					
					$intro = '<b>币息宝DCEP余额:</b>'.($userinfo['lcb_money']-$_POST['num']);
					break;
				}				

				$this->MeLogic->money()->add($_POST['num'],$userinfo['id'],array('name'=>'币息宝转出','intro'=>$intro, 'is_hkc'=>$is_hkc), $is_dollar);
				$this->MeLogic->money()->less($_POST['num'],347,array('name'=>'币息宝转出','intro'=>'用户转出：'.$userinfo['email'], 'is_hkc'=>$is_hkc), $is_dollar);
				
				

				$this->Messager(__('转出成功！'), '?mod=me&code=waplcb');
			}
			
				include handler('template')->file('@wap/lcb_zhuanchu');
			
			
		}







        function wapzhuanchu_nm()
        {
            $product=ConfigHandler::get('product');
            if(!empty($_POST['num']))
            {

                if(!is_numeric($_POST['num']))
                {
                    $this->Messager(__('请输入数字！'), '?mod=lcb&code=wapzhuanchu_nm');
                }

                if($_POST['num'] <=0)
                {
                    $this->Messager(__('输入金额无效！'), '?mod=lcb&code=wapzhuanchu_nm');
                }

                $userinfo=user()->get('*');


                if($userinfo['zfpassword']!=$_POST['password'])
                {
                    $this->Messager(__('请输入正确的密码！'), '?mod=lcb&code=wapzhuanchu_nm');
                }

                $is_hkc = 0;
                switch($_POST['money_category']) {
                    case 'hkc':
                        if($userinfo['lcb_hkc_money']<$_POST['num'])
                        {
                            $this->Messager(__('币息宝HKC余额不足！'), '?mod=lcb&code=wapzhuanchu_nm');
                        }
                        user()->set('lcb_hkc_money',$userinfo['lcb_hkc_money']-$_POST['num']);
                        $is_dollar = 12;
                        $is_hkc = 1;
                        $intro = '<b>币息宝HKC余额:</b>'.($userinfo['lcb_hkc_money']-$_POST['num']);
                        break;

                    default:
                        if($userinfo['lcb_money']<$_POST['num'])
                        {
                            $this->Messager(__('币息宝DCEP余额不足！'), '?mod=lcb&code=wapzhuanchu_nm');
                        }
                        user()->set('lcb_money',$userinfo['lcb_money']-$_POST['num']);
                        $is_dollar = 0;

                        $intro = '<b>币息宝DCEP余额:</b>'.($userinfo['lcb_money']-$_POST['num']);
                        break;
                }

                $this->MeLogic->money()->add($_POST['num'],$userinfo['id'],array('name'=>'币息宝转出','intro'=>$intro, 'is_hkc'=>$is_hkc), $is_dollar);
                $this->MeLogic->money()->less($_POST['num'],347,array('name'=>'币息宝转出','intro'=>'用户转出：'.$userinfo['name'], 'is_hkc'=>$is_hkc), $is_dollar);



                $this->Messager(__('转出成功！'), '?mod=me&code=waplcb_nm');
            }

            include handler('template')->file('@wap/lcb_zhuanchu_nm');


        }














		function zhuanru()
		{
			$product=ConfigHandler::get('product');
			if(!empty($_POST['num']))
			{
				if(!is_numeric($_POST['num']))
				{
					$this->Messager(__('请输入数字！'), '?mod=lcb&code=zhuanru');
				}
				if($_POST['num']<100 && is_numeric($_POST['num']))
				{
					$this->Messager(__('金额最小值不能低于100'), '?mod=lcb&code=zhuanru');
				}
			
				$userinfo=user()->get('*');
				if($userinfo['id']==347){
					$this->Messager(__('理财宝管理员无法转入金额！'), '?mod=lcb&code=zhuanru');
				}
				if($userinfo['zfpassword']!=md5($_POST['password']))
				{
					$this->Messager(__('请输入正确的密码！'), '?mod=lcb&code=zhuanru');
				}
				$is_hkc = 0;
				switch($_POST['money_category']) {
					case 'hkc':
					if($userinfo['hkc']<$_POST['num'])
					{
						$this->Messager(__('账户HKC余额不足！'), '?mod=lcb&code=zhuanru');
					}
					user()->set('lcb_hkc_money',$userinfo['lcb_hkc_money']+$_POST['num']);
					$is_dollar = 12;
					$is_hkc = 1;
					$intro = '<b>币息宝HKC余额:</b>'.($userinfo['lcb_hkc_money']+$_POST['num']);
					break;
					
					default:
					if($userinfo['money']<$_POST['num'])
					{
						$this->Messager(__('账户DCEP余额不足！'), '?mod=lcb&code=zhuanru');
					}
					user()->set('lcb_money',$userinfo['lcb_money']+$_POST['num']);
					$is_dollar = 0;
					
					$intro = '<b>币息宝DCEP余额:</b>'.($userinfo['lcb_money']+$_POST['num']);
					break;
				}
				
				$this->MeLogic->money()->less($_POST['num'],$userinfo['id'],array('name'=>'币息宝转入','intro'=>$intro, 'is_hkc'=>$is_hkc), $is_dollar);
				$this->MeLogic->money()->add($_POST['num'],347,array('name'=>'币息宝转入','intro'=>'用户转入：'.$userinfo['email'], 'is_hkc'=>$is_hkc), $is_dollar);
				$this->Messager(__('转入成功！'), '?mod=lcb');
			}
			if(stristr($_SERVER['HTTP_VIA'],"wap")){
				$a= true;
			}elseif(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){
				$a= true;
			}elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){
				$a= true;
			}else{
				   $a= false;   
			}
			if(!$a){
				include handler('template')->file("lcb_zhuanru");
			}else{
				include handler('template')->file('@wap/lcb_zhuanru');
			}
			
		}
		function wapzhuanru()
		{
			$product=ConfigHandler::get('product');
			if(!empty($_POST['num']))
			{
				if(!is_numeric($_POST['num']))
				{
					$this->Messager(__('请输入数字！'), '?mod=lcb&code=wapzhuanru');
				}
				if($_POST['num']<100 && is_numeric($_POST['num']))
				{
					$this->Messager(__('金额最小值不能低于100'), '?mod=lcb&code=wapzhuanru');
				}
				$userinfo=user()->get('*');
				if($userinfo['id']==347){
					$this->Messager(__('理财宝管理员无法转入金额！'), '?mod=lcb&code=zhuanru');
				}
				if($userinfo['zfpassword']!=md5($_POST['password']))
				{
					$this->Messager(__('请输入正确的密码！'), '?mod=lcb&code=wapzhuanru');
				}
				$is_hkc = 0;
				switch($_POST['money_category']) {
					case 'hkc':
					if($userinfo['hkc']<$_POST['num'])
					{
						$this->Messager(__('账户HKC余额不足！'), '?mod=lcb&code=wapzhuanru');
					}
					user()->set('lcb_hkc_money',$userinfo['lcb_hkc_money']+$_POST['num']);
					$is_dollar = 12;
					$is_hkc = 1;
					$intro = '<b>币息宝HKC余额:</b>'.($userinfo['lcb_hkc_money']+$_POST['num']);
					break;
					
					default:
					if($userinfo['money']<$_POST['num'])
					{
						$this->Messager(__('账户DCEP余额不足！'), '?mod=lcb&code=wapzhuanru');
					}
					user()->set('lcb_money',$userinfo['lcb_money']+$_POST['num']);
					$is_dollar = 0;
					
					$intro = '<b>币息宝DCEP余额:</b>'.($userinfo['lcb_money']+$_POST['num']);
					break;
				}
			
				$this->MeLogic->money()->less($_POST['num'],$userinfo['id'],array('name'=>'币息宝转入','intro'=>$intro, 'is_hkc'=>$is_hkc), $is_dollar);
				$this->MeLogic->money()->add($_POST['num'],347,array('name'=>'币息宝转入','intro'=>'用户转入'.$userinfo['email'], 'is_hkc'=>$is_hkc), $is_dollar);
				$this->Messager(__('转入成功！'), '?mod=me&code=waplcb');
			}
		
			
				include handler('template')->file('@wap/lcb_zhuanru');
			
			
		}


        function wapzhuanru_nm()
        {
            $product=ConfigHandler::get('product');
            if(!empty($_POST['num']))
            {
                if(!is_numeric($_POST['num']))
                {
                    $this->Messager(__('请输入数字！'), '?mod=lcb&code=wapzhuanru_nm');
                }
                if($_POST['num']<100 && is_numeric($_POST['num']))
                {
                    $this->Messager(__('金额最小值不能低于100'), '?mod=lcb&code=wapzhuanru_nm');
                }
                $userinfo=user()->get('*');




                if($userinfo['id']==347){
                    $this->Messager(__('理财宝管理员无法转入金额！'), '?mod=lcb&code=wapzhuanru_nm');
                }
                if($userinfo['zfpassword']!=$_POST['password'])
                {
                    $this->Messager(__('请输入正确的密码！'), '?mod=lcb&code=wapzhuanru_nm');
                }
                $is_hkc = 0;
                switch($_POST['money_category']) {
                    case 'hkc':
                        if($userinfo['hkc']<$_POST['num'])
                        {
                            $this->Messager(__('账户HKC余额不足！'), '?mod=lcb&code=wapzhuanru_nm');
                        }
                        user()->set('lcb_hkc_money',$userinfo['lcb_hkc_money']+$_POST['num']);
                        $is_dollar = 12;
                        $is_hkc = 1;
                        $intro = '<b>币息宝HKC余额:</b>'.($userinfo['lcb_hkc_money']+$_POST['num']);
                        break;

                    default:
                        if($userinfo['money']<$_POST['num'])
                        {
                            $this->Messager(__('账户DCEP余额不足！'), '?mod=lcb&code=wapzhuanru_nm');
                        }
                        user()->set('lcb_money',$userinfo['lcb_money']+$_POST['num']);
                        $is_dollar = 0;

                        $intro = '<b>币息宝DCEP余额:</b>'.($userinfo['lcb_money']+$_POST['num']);
                        break;
                }

                $this->MeLogic->money()->less($_POST['num'],$userinfo['id'],array('name'=>'币息宝转入','intro'=>$intro, 'is_hkc'=>$is_hkc), $is_dollar);
                $this->MeLogic->money()->add($_POST['num'],347,array('name'=>'币息宝转入','intro'=>'用户转入'.$userinfo['name'], 'is_hkc'=>$is_hkc), $is_dollar);
                $this->Messager(__('转入成功！'), '?mod=me&code=waplcb_nm');
            }


            include handler('template')->file('@wap/lcb_zhuanru_nm');


        }

















	}
