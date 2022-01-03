<?php
/**
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package php
 * @name member.mod.php
 * @date 2011-12-07 13:42:07
 */



class ModuleObject extends MasterObject
{



	var $Code = array();



	var $ID = 0;


	var $IDS;


	function ModuleObject($config)
	{
		$this->MasterObject($config);

		if(isset($this->Get['code']))
		{
			$this->Code = $this->Get['code'];
		}elseif(isset($this->Post['code']))
		{
			$this->Code = $this->Post['code'];
		}

		if(isset($this->Get['id']))
		{
			$this->ID = (int)$this->Get['id'];
		}elseif(isset($this->Post['id']))
		{
			$this->ID = (int)$this->Post['id'];
		}

		if(isset($this->Get['ids']))
		{
			$this->IDS = $this->Get['ids'];
		}elseif(isset($this->Post['ids']))
		{
			$this->IDS = $this->Post['ids'];
		}

		$this->FormHandler = new FormHandler();

		Load::moduleCode($this);$this->Execute();
	}


	function Execute()
	{
		switch($this->Code)
		{
			case 'list':
			$this->Main();
			break;

			case 'add':
			$this->Add();
			break;

			case 'doadd':
			$this->DoAdd();
			break;

			case 'delete':
			case 'dodelete':
			$this->DoDelete();
			break;
			
			case 'delete_nm':
			case 'dodelete_nm':
			$this->DoDelete_nm();
			break;

			case 'search':
			$this->search();
			break;
			
            case 'nm':
			$this->nm();
			break;
			
			case 'dosearch':
			$this->DoSearch();
			break;
			case 'zhuanzhang':
			$this->Zhuanzhang();
			break;

			case 'showzhuanzhang':
			$this->Showzhuanzhang();
			break;
            case 'showzhuanzhang2':
            $this->showzhuanzhang2();
            break;
			case 'yanzheng':
			$this->Yanzheng();
			break;
				case 'showbill':
			$this->Showbill();
			break;
			case 'bill':
			$this->Bill();
			break;
			case 'lcb':
			$this->lcb();
			break;
			case 'lcbsy':
			$this->lcbsy();
			break;
			case 'lcbff':
			$this->lcbff();
			break;
			
			case 'lcbsyhs':
			$this->lcbsyhs();
			break;

				case 'showzzchongzhi':
			$this->Showzzchongzhi();
			break;
				case 'zzchongzhi':
			$this->ZhuanzhangChongZhi();
			break;

							case 'zhannei':
			$this->Zhannei();
			break;
				case 'showyanzheng':
			$this->ShowYanzheng();
			break;
			
			case 'modify':
			$this->Modify();
			break;
			
			case 'modify_nm':
			$this->Modify_nm();
			break;
			
			
			
			
			case 'domodify':
			$this->DoModify();
			break;
            case 'wbdhlist':
            $this->wbdhlist();
            break;
            case 'wbdetailslist':
            $this->Bill();
            break;
            case 'uszhuanzhang' :
            $this->zhuanzhang2();
            break;
            case 'uschongzhi' :
                $this->uschongzhi();
                break;
            case 'xinyongka' :
                $this->xinyongka();
            break;
            case 'showhuankuan':
			$this->Showhuankuan();
			break;
            case 'help':
			$this->help();
			break;
			
			default:
			$this->Main();
			break;
		}
	}


	function Main()
	{
		$this->DoSearch();
	}


	function Add()
	{
		$sql = "
		 SELECT
			 id,name
		 FROM
			 " . TABLE_PREFIX.'system_role' . "
		 WHERE
			 id!=1";
		$query = $this->DatabaseHandler->Query($sql);
		while($row = $query->GetRow())
		{
			$role_list[] = array('name' => $row['name'], 'value' => $row['id']);
		}
		$role_select = $this->FormHandler->Select('role_id', $role_list, $this->Config['default_role_id']);
		$action = "admin.php?mod=member&code=doadd";
		$title = "添加";
		include handler('template')->file('@admin/member_add');
	}


	function DoAdd()
	{
		$data = array();
		$data['username'] = trim($this->Post['username']);
		$data['password'] = md5(trim($this->Post['password']));
		$data['email'] = trim($this->Post['email']);
		$data['role_id'] = (int)$this->Post['role_id'];

		if ($data['username']=='' or $data['password']=='')
		{
			$this->Messager("用户名或密码不能为空");
		}
		if ($data['role_id']===0) {
			$this->Messager("角色编号未指定");
		}
				$sql="select * from ".TABLE_PREFIX."system_role where id=".$data['role_id'];
		$query = $this->DatabaseHandler->Query($sql);
		$role=$query->GetRow();
		if ($role==false) {
			$this->Messager("角色已经不存在");
		}
		$data['role_type']=$role['type'];
		$this->DatabaseHandler->SetTable(TABLE_PREFIX.'system_members');
		$is_exists = $this->DatabaseHandler->Select('', "username='{$data['username']}'");

		if($is_exists != false)
		{
			$this->Messager("用户名　{$data['username']}　已经被注册");
		}
		$result = $this->DatabaseHandler->Insert($data);
		if($result != false)
		{
						account()->Validated($result);
			$this->Messager("添加成功", 'admin.php?mod=member');
		}
		else
		{
			$this->Messager("添加失败");
		}
	}


	function Search()
	{
		$action = "admin.php?mod=member&code=dosearch";
				$sql = "
		 SELECT
			 id,name
		 FROM
			 " . TABLE_PREFIX.'system_role' . "
		 WHERE
			 id!=1";
		$query = $this->DatabaseHandler->Query($sql);
		while($row = $query->GetRow())
		{
			$role_list[] = $row;
		}
		$role_count = count($role_list) + 1;

		include handler('template')->file('@admin/member_search');
	}

function nm()
	{
		//$action = "admin.php?mod=member&code=donm";
		$action = "admin.php?mod=member&code=delete_nm";
		
		$where="WHERE 1";
		
		$sql = "
		  SELECT
			 count(1) total
		  FROM
			  cenwor_tttuangou_user_private_key
		  $where
		  ";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());
		
		$row1 = $query->GetRow();
		
		//var_dump('打印的row1');
		//var_dump($row1);
		

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		
		//var_dump('打印的pages');
		//var_dump($pages);
		
		//var_dump('打印的total');
		//var_dump($total);
		
		$sql = "
		  SELECT
			  *
		  FROM
			  cenwor_tttuangou_user_private_key
		  $where
		  order by create_time desc  LIMIT $offset,$page_num ";
		$query = $this->DatabaseHandler->Query($sql);

	/*	
		$sql = "
		 SELECT
			 id,encrypt_public
		 FROM
			 cenwor_tttuangou_user_private_key
		 WHERE
			 id!=1";
		$query = $this->DatabaseHandler->Query($sql);
	*/		
		while($row = $query->GetRow())
		{
			
			//var_dump('打印的row');
			//var_dump($row);
/*			
			$sql = 'select * from cenwor_tttuangou_user_private_key where encrypt_public = "' . $row['encrypt_public'].'" ';
			$q = $this->DatabaseHandler->Query($sql);
			if($private = $q->GetRow())
			{
				$row['public'] = $private['encrypt_public'];
				$row['regdate'] = $private['create_time'];
			}
*/		

		$member_list[] = $row;
		$role_list[] = $row;
		}
		$role_count = count($role_list) + 1;

		include handler('template')->file('@admin/member_nm');
	}

	function DoSearch()
	{
		extract($this->Get);


		$where_list = array();
		if($username != '')
		{
			$where_list['username'] = "username like '%{$username}%'";
		}
		if($email != '')
		{
			$where_list['email'] = "email like '%{$email}%'";
		}
		if ($lower_money != '')
		{
			$where_list['money_lower'] = "money <= {$lower_money}";
		}
		if ($higher_money != '')
		{
			$where_list['money_higher'] = "money >= {$higher_money}";
		}
		if ($totalpay != '')
		{
			$where_list['totalpay'] = "totalpay >= {$totalpay}";
		}
		if($regip != '')
		{
			$where_list['regip'] = "regip like '{$regip}%'";
		}
		if($lastip != '')
		{
			$where_list['lastip'] = "lastip like '%{$lastip}'";
		}
		if(is_string($role_ids)==false)
		{
			if($role_id[0] != 'all' and is_array($role_id) and count($role_id) > 0)
			{
				$where_list['role_id'] = $this->DatabaseHandler->BuildIn($role_id, 'role_id');
				$_GET['role_ids']=implode(",",$role_id);
			}
			if($role_id[0]=='all')
			{
				unset($where_list['role_id']);
			}
		}
		else
		{
			$where_list['role_id'] ="role_id in($role_ids)";
		}

				$sql = "
		 SELECT
			 id,name,`type`
		 FROM
			 " . TABLE_PREFIX.'system_role' . "
		 WHERE
			 id!=1";
		$query = $this->DatabaseHandler->Query($sql);
		while($row = $query->GetRow())
		{
			$role_list[$row['id']] = $row;
		}
		if($where_list!=false)
		{
			$where = "WHERE ".implode(" AND \n\t", $where_list);
		}

				$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'system_members' . "
		  $where";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());
		
		$row2=$query->GetRow();
		//var_dump('打印的row_2');
		//var_dump($row2);
		
		//var_dump('打印的total_2');
		//var_dump($total);

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'system_members' . "
		  $where
		   order by uid desc  LIMIT $offset,$page_num";
		$query = $this->DatabaseHandler->Query($sql);
		
		
		//var_dump('打印的pages_2');
		//var_dump($pages);

		foreach($this->Config as $field => $name)
		{
			if(strpos($field, 'credits') !== false)
			{
				if($name != '')
				{
					$credit_list[$field] = $name;
				}
			}
		}
		while($row = $query->GetRow())
		{
			foreach($credit_list as $field => $val)
			{
				$row['credit_value_list'][] = $row[$field];
			}
			$role = $role_list[$row['role_id']];
			if($role != false)
			{
				if($role['is_system'] == 1)
				{
					$row['role_name'] = "<B>{$role['name']}</B>";
				}
				else
				{
					$row['role_name'] = $role['name'];
				}
								$row['money'] *= 1;
				$row['totalpay'] *= 1;
			}

			 $yanzheng = logic('yanzheng')->GetOne($row[uid]);
        if ( $yanzheng['statue']==2 )
        {
        	$row['xingming'] = $yanzheng['idname'];

        }else
        {
        	$row['xingming'] = '';
        }
		
		$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $row['uid'].'"';
		$q = $this->DatabaseHandler->Query($sql);
		if($private = $q->GetRow())
		{
			$row['public'] = $private['encrypt_public'];
		}

			$member_list[] = $row;
		}
		$action = 'admin.php?mod=member&code=delete';
		include handler('template')->file('@admin/member_search_list');
	}
     function  Showzhuanzhang()
   {
	   	if($_GET['submit'] == 1)
	   	{
	   		$post['statue'] = (int)$_POST['cztype'];
	   		if($post['statue']==3)
	   		{
	   			$id= (int)$_GET["id"];
	   	        $info = logic('zhuanzhanglist')->GetOne($id);

	   	        $sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET money = money + ' . $info['value'] . ' WHERE uid = ' . $info['owner'] ;
                $query = $this->DatabaseHandler->Query($sql);

	   		}elseif($post['statue']==2){//确认汇出
				$id= (int)$_GET["id"];
	   	        $info = logic('zhuanzhanglist')->GetOne($id);
				$sql ='UPDATE ' .TABLE_PREFIX.'tttuangou_usermoney  SET is_confirm = 0 WHERE intro = "'.$id .'"';
                $query = $this->DatabaseHandler->Query($sql);
			}

	   		$post['mark'] = trim($_POST['mark']);
	   		//$post['sxfl'] = trim($_POST['sxfl']);
	   		$post['cztime'] = time();
	   		logic('zhuanzhanglist')->Update((int)$_GET['id'],$post);
	   		$this->Messager("操作成功","admin.php?mod=member&code=zhuanzhang");
	   	}else
	   	{

	   	$id= (int)$_GET["id"];
	   	 $info = logic('zhuanzhanglist')->GetOne($id);
	   	//得到扣率
	   	 $klinfo = logic("yanzheng")->GetOne($info['owner']);
	   	 $info['value'] = number_format($info['value'], 2, '.', '');


	   	 $info['wrate'] = $klinfo['wrate'];
	   	    	 $info['brate'] = $klinfo['brate'];

	   	if($info['brate']==0)
	   	  {
	   	  $sxf = 0;
	   	  }else
	   	  {
	   	  	$sxf = max($info['value']*$info['brate']/100.0,1);
	   	  	$sxf = round($sxf,2);
	   	  }
	   	//  var_dump($sxf);
	   	$info['username'] = user($info['owner'])->get("name");
	   	 $action = 'admin.php?mod=member&code=showzhuanzhang&id='.$id.'&submit=1';
	   	 include handler('template')->file('@admin/member_zhuanzhang_info');
	   	}
   }

    function  Showhuankuan()
   {
	   	if($_GET['submit'] == 1)
	   	{
	   		$post['statue'] = (int)$_POST['cztype'];
	   		if($post['statue']==3)
	   		{
	   			$id= (int)$_GET["id"];
	   	        $info = logic('zhuanzhanglist')->GetOne3($id);

	   	        $sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET money = money + ' . number_format($info['value']+$info['sxfl'], 2, '.', '') . ' WHERE uid = ' . $info['owner'] ;
                $query = $this->DatabaseHandler->Query($sql);

	   		}elseif($post['statue']==2){//确认
				$id= (int)$_GET["id"];
	   	        $info = logic('zhuanzhanglist')->GetOne3($id);
				$sql ='UPDATE ' .TABLE_PREFIX.'tttuangou_usermoney  SET is_confirm = 0 WHERE intro = "'.$id .'"';
                $query = $this->DatabaseHandler->Query($sql);
			}

	   		$post['mark'] = trim($_POST['mark']);
	   		//$post['sxfl'] = trim($_POST['sxfl']);
	   		$post['cztime'] = time();
	   		logic('zhuanzhanglist')->Update3((int)$_GET['id'],$post);
	   		$this->Messager("操作成功","admin.php?mod=member&code=xinyongka");
	   	}else
	   	{

	     $id= (int)$_GET["id"];
	   	 $info = logic('zhuanzhanglist')->GetOne3($id);

         $info['username'] = user($info['owner'])->get("name");
         $yinhangka = logic('yinhangka')->GetOne3($info['yhkid']);

	   	 $action = 'admin.php?mod=member&code=showhuankuan&id='.$id.'&submit=1';
	   	 include handler('template')->file('@admin/member_huankuan_info');
	   	}
   }

    function  Showzhuanzhang2()
    {
	   	if($_GET['submit'] == 1)
	   	{
	   		$post['statue'] = (int)$_POST['cztype'];
	   		if($post['statue']==3)
	   		{
	   			$id= (int)$_GET["id"];
	   	        $info = logic('zhuanzhanglist')->GetOne2($id);
				if ($info['is_dollar']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET dollar = dollar + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_hkdollar']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET hkdollar = hkdollar + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_jpy']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET jpy = jpy + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_krw']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET krw = krw + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_gbp']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET gbp = gbp + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_aud']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET aud = aud + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_cad']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET cad = cad + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_chf']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET chf = chf + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_nzd']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET nzd = nzd + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_sgd']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET sgd = sgd + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_hkc']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET hkc = hkc + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_btc']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET btc = btc + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_eth']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET eth = eth + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_money']==1){
				    $sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET money = money + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				}else{
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET euro = euro + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				}

                $query = $this->DatabaseHandler->Query($sql);

	   		}elseif($post['statue']==4)
			{
				$id= (int)$_GET["id"];
				$info = logic('zhuanzhanglist')->GetOne2($id);
				if ($info['is_dollar']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET dollar = dollar + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_hkdollar']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET hkdollar = hkdollar + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_jpy']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET jpy = jpy + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_krw']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET krw = krw + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_gbp']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET gbp = gbp + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_aud']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET aud = aud + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_cad']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET cad = cad + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_chf']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET chf = chf + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_nzd']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET nzd = nzd + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_sgd']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET sgd = sgd + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_hkc']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET hkc = hkc + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_btc']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET btc = btc + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_eth']==1){
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET eth = eth + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				} else if ($info['is_money']==1){
				    $sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET money = money + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				}else{
					$sql ='UPDATE ' .TABLE_PREFIX.'system_members  SET euro = euro + ' . $info['value'] . ' WHERE uid = ' . $info['userid'] ;
				}

				$query = $this->DatabaseHandler->Query($sql);

			}elseif($post['statue']==2){//确认汇出
				$id= (int)$_GET["id"];
	   	        $info = logic('zhuanzhanglist')->GetOne($id);
				$sql ='UPDATE ' .TABLE_PREFIX.'tttuangou_usermoney  SET is_confirm = 0 WHERE intro = "'.$id .'"';
                $query = $this->DatabaseHandler->Query($sql);
			}

	   		$post['mark'] = trim($_POST['mark']);
            /*if($_POST['is_sxf'] == 0) {
	   		$post['sxfl'] = '0.00';//如果确定不收取手续费，手续费值更新为0
            }*/
	   		$post['cztime'] = time();
            $post['is_sxf'] = trim($_POST['is_sxf']);
			if ($post['statue']==4){
				$sql ='DELETE from ' .TABLE_PREFIX.'tttuangou_zhuanzhang_guoji  WHERE id = "'.$id .'"';
				$query = $this->DatabaseHandler->Query($sql);
				$sql ='DELETE from ' .TABLE_PREFIX.'tttuangou_usermoney  WHERE intro = "'.$id .'"';
				$query = $this->DatabaseHandler->Query($sql);
			} else{
				logic('zhuanzhanglist')->Update2((int)$_GET['id'],$post);
			}

	   		$this->Messager("操作成功","admin.php?mod=member&code=uszhuanzhang");
	   	}else
	   	{

	   	  $id= (int)$_GET["id"];
	   	  $info = logic('zhuanzhanglist')->GetOne2($id);
	   	//得到扣率
	   	 $klinfo = logic("yanzheng")->GetOne($info['userid']);

          $yinhangka = logic('yinhangka')->GetOne2($info['yhkid']);
		  $info['yhkinfo'] = $yinhangka['khcity'].' '.$yinhangka['khcc'];
          $info['yhkkh']   = $yinhangka['cardno'];
		  $info['khcity']   = $yinhangka['khcity'];
		  $info['skgj']   = $yinhangka['skgj'];
          $info['yhkname'] = $yinhangka['name'];
		  $info['yhkzipcode'] = $yinhangka['zipcode'];
		  $info['yhkbic'] = $yinhangka['bic'];
		  $info['yhkbankcode'] = $yinhangka['bankcode'];
		  $info['yhkjiedao'] = $yinhangka['jiedao'];
          $info['uid']  = $info['userid'];
		  $info['yhkdetall']  = $this->build_yhkdetall($yinhangka);

	   	  $info['gjrate'] = $klinfo['gjrate'];

	   	if($info['gjrate']==0)
	   	  {
	   	  $sxf = 0;
	   	  }else
	   	  {
	   	  	$sxf = max($info['sxfl'],1);
	   	  	$sxf = round($sxf,2);
	   	  }
	   	//  var_dump($sxf);
        $info['value'] = number_format($info['value'], 2, '.', '');
	   	$info['username'] = user($info['userid'])->get("name");
	   	$action = 'admin.php?mod=member&code=showzhuanzhang2&id='.$id.'&submit=1';
	   	 include handler('template')->file('@admin/member_zhuanzhang_guoji_info');
	   	}
   }

	function Zhuanzhang()
	{
		extract($this->Get);
		$where = "  where 1 ";
		$show = (int)$_GET['show'];

		if($show ==1)
		{
			$where.=" and statue =1 ";
		}elseif($show ==2)
		{
			$where.=" and statue <>1 ";
		}

			$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'tttuangou_zhuanzhanglist' . "
		  $where ";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_zhuanzhanglist' . "
		  $where
		  order by id desc  LIMIT $offset,$page_num ";
		$query = $this->DatabaseHandler->Query($sql);

	while($row = $query->GetRow())
		{
			$row['username'] = user($row['owner'])->get("name");
			$row['uid'] = user($row['owner'])->get("id");

			if (!$row['sxfl'])
			{
		         $klinfo = logic("yanzheng")->GetOne($row['uid']);
	   	    	 $row['brate'] = $klinfo['brate'];
			}else
			{
				$row['brate'] =$row['sxhl'];
			}

	   	if($row['brate']==0)
	   	  {
	   	  $sxf = 0;
	   	  }else
	   	  {
	   	  	$sxf = max($row['value']*$row['brate']/100.0,1);
	   	  	$sxf = round($sxf,2);
	   	  }
            $row['value'] = number_format($row['value'], 2, '.', '');
			$row['tovalue'] = number_format(($row['value']- $sxf), 2, '.', '');


			$member_list[] = $row;
		}
		include handler('template')->file('@admin/member_zhuanzhang_list');

	}

    function Zhuanzhang2()
	{
		extract($this->Get);
		$where = "  where 1 ";
		$show = (int)$_GET['show'];

		if($show ==1)
		{
			$where.=" and statue =1 ";
		}elseif($show ==2)
		{
			$where.=" and statue <>1 ";
		}

			$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'tttuangou_zhuanzhang_guoji' . "
		  $where ";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_zhuanzhang_guoji' . "
		  $where
		  order by id desc  LIMIT $offset,$page_num ";
		$query = $this->DatabaseHandler->Query($sql);

	while($row = $query->GetRow())
		{
			$row['username'] = user($row['userid'])->get("name");
			$row['uid'] = user($row['userid'])->get("id");
            $yinhangka = logic('yinhangka')->GetOne2($row['yhkid']);
			$row['yhkinfo'] =$yinhangka['khcity'].' '.$yinhangka['khcc'];
			$row['skgj']   = $yinhangka['skgj'];
			$row['khcity']   = $yinhangka['khcity'];
            $row['yhkkh']   = $yinhangka['cardno'];
            $row['yhkname'] = $yinhangka['name'];
			$row['yhkjiedao'] = $yinhangka['jiedao'];
			$row['yhkzipcode'] = $yinhangka['zipcode'];
			$row['yhkbankcode'] = $yinhangka['bankcode'];
			$row['yhkbic'] = $yinhangka['bic'];
			$row['yhkdetall']  = $this->build_yhkdetall($yinhangka);
            $row['sxfl'] = number_format($row['sxfl'], 2, '.', '');


			if (!$row['sxfl'])
			{
				$klinfo = logic("yanzheng")->GetOne($row['uid']);
	   	        $row['gjrate'] = $klinfo['gjrate'];
			}else
			{
				$row['gjrate'] =$row['sxhl'];
			}

	   	if($row['gjrate']==0)
	   	  {
	   	  $sxf = 0;
	   	  }else
	   	  {
	   	  	$sxf = max($row['sxfl'],1);
	   	  	$sxf = round($sxf,2);
	   	  }
            /*if($row['is_sxf'] == 1 && !empty($row['cztime'])) {
                $row['tovalue'] = $row['value']- $sxf;//管理员审核要收取手续费
            }elseif($row['is_sxf'] == 0 && !empty($row['cztime'])){
                $row['tovalue'] = $row['value'];//管理员审核不需要收取手续费
            }else{
                $row['tovalue'] = $row['value']- $sxf;//管理员没审核状态下，默认显示收取手续费
            }*/
            $row['value'] = number_format($row['value'], 2, '.', '');

			if($row['is_sxf'] == 1){
				$row['tovalue'] = $row['value']- $sxf;
			}else{
				$row['tovalue'] = $row['value'];
			}

            $row['tovalue'] = number_format($row['tovalue'], 2, '.', '');

			$member_list[] = $row;
		}
		include handler('template')->file('@admin/member_zhuanzhang_guoji_list');

	}


    function xinyongka()
	{
		extract($this->Get);
		$where = "  where 1 ";
		$show = (int)$_GET['show'];

		if($show ==1)
		{
			$where.=" and statue =1 ";
		}elseif($show ==2)
		{
			$where.=" and statue <>1 ";
		}

			$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'tttuangou_zhuanzhang_xyk' . "
		  $where ";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_zhuanzhang_xyk' . "
		  $where
		  order by id desc  LIMIT $offset,$page_num ";
		$query = $this->DatabaseHandler->Query($sql);

	while($row = $query->GetRow())
		{
			$row['username'] = user($row['owner'])->get("name");
			$row['uid'] = user($row['owner'])->get("id");
            $yinhangka = logic('yinhangka')->GetOne3($row['yhkid']);
            $row['yhkinfo'] = $yinhangka['kaihuhang'];
            $row['yhkkh'] = $yinhangka['kahao'];
            $row['yhkname'] = $yinhangka['name'];
            $row['sxfl'] = number_format($row['sxfl'], 2, '.', '');

			if (!$row['sxfl'])
			{
		         $klinfo = logic("yanzheng")->GetOne($row['uid']);
	   	    	 $row['xyk_rate'] = $klinfo['xyk_rate'];
			}else
			{
				$row['xyk_rate'] =$row['sxhl'];
			}

	   	if($row['xyk_rate']==0)
	   	  {
	   	  $sxf = 0;
	   	  }else
	   	  {
	   	  	$sxf = max($row['value']*$row['xyk_rate']/100.0,1);
	   	  	$sxf = round($sxf,2);
	   	  }
            $row['value'] = number_format($row['value'], 2, '.', '');
			$row['tovalue'] = number_format(($row['value'] + $sxf), 2, '.', '');


			$member_list[] = $row;
		}
		include handler('template')->file('@admin/member_huankuan_list');

	}


 function  Showyanzheng()
   {
	   	if($_GET['submit'] == 1)
	   	{
	   		$id= (int)$_GET["id"];
	   	if ($_GET['shanchu']==1)
	   		{
	   			$sql = "
		 delete
		  FROM
			  " . TABLE_PREFIX.'system_members_yanzheng' . " where owner = $id";
		     $query = $this->DatabaseHandler->Query($sql);
		     $this->Messager("操作成功","admin.php?mod=member&code=yanzheng");
		     exit;
	   		}

	        $info = logic('yanzheng')->GetOne($id);
	   		$post['statue'] = (int)$_POST['cztype'];
	   		$post['mark'] = trim($_POST['mark']);
	   		$post['cztime'] = time();
	   		$post['brate'] = trim($_POST['brate']);
	   		$post['wrate'] = trim($_POST['wrate']);
			$post['dongjie'] = trim($_POST['dongjie']);
			/*if($post['statue'] != $info['statue']){
				$post['dongjie'] = 1;
			}*/
			if($post['statue'] == 3){
				$post['dongjie'] = 1;
			}

	   		logic('yanzheng')->Update($info['id'],$post);



	   		logic('push')->addi('sms', user($info['owner'])->get("phone"), array('content'=>"您好，".$info['idname']."，".($post['statue']==2?"您已经通过身份验证":"身份验证失败，请重新提交")));
	   		logic('push')->add("mail", user($info['owner'])->get("email"), array('subject'=>"南雅货币交易所，验证通过通知",'content'=>"您好，".$info['idname']."，".($post['statue']==2?"您已经通过身份验证":"身份验证失败，请重新提交")));

	   		$this->Messager("操作成功","admin.php?mod=member&code=yanzheng");
	   	}else
	   	{

	     $id= (int)$_GET["id"];
	   	 $info = logic('yanzheng')->GetOne($id);
		 $info['uid'] = $info['owner'];

	   	$info['username'] = user($info['owner'])->get("name");
	   	 $action = 'admin.php?mod=member&code=showyanzheng&id='.$info[owner].'&submit=1';

	   	 include handler('template')->file('@admin/member_yanzheng_info');
	   	}
   }
function Yanzheng()
	{
		extract($this->Get);
		$where = "  where 1 ";
		$show = (int)$_GET['show'];

		if($show ==1)
		{
			$where.=" and statue =1 ";
		}elseif($show ==2)
		{
			$where.=" and statue <>1 ";
		}

			$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'system_members_yanzheng' . "
		  $where";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'system_members_yanzheng' . "
		  $where
		  order by id desc LIMIT $offset,$page_num";
		$query = $this->DatabaseHandler->Query($sql);

	while($row = $query->GetRow())
		{
			$row['username'] = user($row['owner'])->get("name");
			$row['uid'] = user($row['owner'])->get("id");
			$member_list[] = $row;
		}
		include handler('template')->file('@admin/member_yanzheng_list');

	}

 function  Showzzchongzhi()
   {

   if ($_GET['de']==1)
	   		{
	   			$sql = "
		  delete
		  FROM
			  " . TABLE_PREFIX.'tttuangou_recharge_order' . "
		  where orderid='$_GET[id]' ";
		$this->DatabaseHandler->Query($sql);
		$this->Messager("操作成功","admin.php?mod=member&code=zzchongzhi");
	   			exit;
	   		}
	   		$info = logic('recharge')->GetOne($_GET['id']);
	   		logic('recharge')->Update($_GET['id'], array('paytime '=>time(),'statue'=>2));
	   		//得出充值的订单
	   		$order = logic('recharge')->MakeSuccessed($info['orderid']);
//			logic('me')->money()->add($info['money'], $info['userid'], array(
//						'name' => 'hkcz',
//						'intro' => $_GET['id']
//					));
            if(isset($_GET['rflag'])) {
                $this->Messager("操作成功","admin.php?mod=member&code=uschongzhi");
            }else{
	   		    $this->Messager("操作成功","admin.php?mod=member&code=zzchongzhi");
            }

   }
	function ZhuanzhangChongZhi()
	{
		extract($this->Get);
		$where = "  where 1 and payment=5 and statue in(1,2)";
		$show = (int)$_GET['show'];
        $ttype=$_GET['ttype'];

		if($show ==1)
		{
			$where.=" and statue =1 ";
		}elseif($show ==2)
		{
			$where.=" and statue =2 ";
		}

        if(!empty($ttype)) {
            if(in_array($ttype, array('无卡支付', '移动支付', '网银支付', '手机支付', '美元支付', '转账付款', '贝宝支付'))){
                $where .=" and tongdao = '".$ttype."'";
            }
        }
		$where .= " and (tongdao != '美元支付' and tongdao != '贝宝支付' and tongdao != '欧元汇款' and tongdao != '港币汇款' and tongdao != '日元汇款' and tongdao != '韩元汇款' and tongdao != '英镑汇款' and tongdao != '澳元汇款' and tongdao != '加元汇款' and tongdao != '瑞郎汇款' and tongdao != '新西兰元汇款' and tongdao != '新加坡元汇款' and tongdao != '香港币汇款' and tongdao != '比特币汇款' and tongdao != '以太币汇款' and tongdao != '人民币汇款'
					and tongdao != 'wap美元支付' and tongdao != 'wap贝宝支付' and tongdao != 'wap欧元汇款' and tongdao != 'wap港币汇款' and tongdao != 'wap日元汇款' and tongdao != 'wap韩元汇款' and tongdao != 'wap英镑汇款' and tongdao != 'wap澳元汇款' and tongdao != 'wap加元汇款' and tongdao != 'wap瑞郎汇款' and tongdao != 'wap新西兰元汇款' and tongdao != 'wap新加坡元汇款' and tongdao != 'wap香港币汇款' and tongdao != 'wap比特币汇款' and tongdao != 'wap以太币汇款'  and tongdao != 'wap人民币汇款' )";
			$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'tttuangou_recharge_order' . "
		  $where";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_recharge_order' . "
		  $where
		  order by createtime desc LIMIT $offset,$page_num";
		$query = $this->DatabaseHandler->Query($sql);

	while($row = $query->GetRow())
		{
			$row['username'] = user($row['userid'])->get("name");
            $row['yanzheng'] = logic('yanzheng')->GetOne($row['userid']);
			$row['uid'] = user($row['userid'])->get("id");
			if ($row['zjlx']==1)
			{
				$row['zjlxsting']="公司账户";
			}else {

				$row['zjlxsting']="个人账户";

			}
            $row['money'] = number_format($row['money'], 2, '.', '');
			$member_list[] = $row;
		}
		include handler('template')->file('@admin/member_zzchongzhi_list');

	}


	function Showbill()
	{
	   	$id= (int)$_GET["id"];
	   	 		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_usermoney' . "
		   where id = '$id'
		  LIMIT 1";
		$query = $this->DatabaseHandler->Query($sql);
		$info =$query->GetRow();
	   	$info['username'] = user($info['userid'])->get("name");

	   	/*
		if($info['is_private']) {
			$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $info['userid'].'"';
			$q = $this->DatabaseHandler->Query($sql);
			$private = $q->GetRow();
			$info['username'] = $private['encrypt_public'];
		}
	   	*/
	   	$value = $info;

    	if ($value['name']=='zn' || $value['name']=='zz')
        	{
        	  $zhanzhuanginfo = logic('zhanneilist')->GetOne($value['intro']);
        	  if ($zhanzhuanginfo['money_type']==1){
                        $prefix='USD';
                    }elseif ($zhanzhuanginfo['money_type']==2){
                        $prefix="HKD";
                    }elseif ($zhanzhuanginfo['money_type']==4){
                        $prefix="JPY";
                    }elseif ($zhanzhuanginfo['money_type']==5){
                        $prefix="KRW";
                    }elseif ($zhanzhuanginfo['money_type']==6){
                        $prefix="GBP";
                    }elseif ($zhanzhuanginfo['money_type']==7){
                        $prefix="AUD";
                    }elseif ($zhanzhuanginfo['money_type']==8){
                        $prefix="CAD";
                    }elseif ($zhanzhuanginfo['money_type']==9){
                        $prefix="CHF";
                    }elseif ($zhanzhuanginfo['money_type']==10){
                        $prefix="NZD";
                    }elseif ($zhanzhuanginfo['money_type']==11){
                        $prefix="SGD";
					}elseif ($zhanzhuanginfo['money_type']==12){
                        $prefix="HKC";
					}elseif ($zhanzhuanginfo['money_type']==13){
				        $prefix="BTC";
					}elseif ($zhanzhuanginfo['money_type']==14){
				         $prefix="ETH";

                    }elseif ($zhanzhuanginfo['money_type']==3){
                        $prefix="EUR";
                    }else{
                        $prefix='CNY';
                    }
	        	 if($value['name']== 'zz') {
	        	  	$value['name']="站内转出";
	        	  	$zhanzhuanginfo[tousername] = user($zhanzhuanginfo['touid'])->get("name");

	        	  	/*
					if($zhanzhuanginfo['is_private'] == 1) {
						
						$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['touid'].'"';
						$q = $this->DatabaseHandler->Query($sql);
						$private = $q->GetRow();
						$topublic = $private['encrypt_public'];
						$b = "<b>收款匿名地址：</b>$topublic";
					} else {
						$b = "<b>收款人：</b>$zhanzhuanginfo[tousername]";
					}
	        	  	*/
					 $b = "<b>收款人：</b>$zhanzhuanginfo[tousername]";
					
					
	        	  	 $zhanzhuanginfo['info'] = "
						$b
						<br>
                        <b>金额：</b>{$prefix}".number_format($zhanzhuanginfo[value], 2, '.', '')."元
                        <!--<br>
						<b>付款留言：</b>$zhanzhuanginfo[mark]-->
						<br>
						<b>手续费率：</b>$zhanzhuanginfo[sxfl]%
                        <br>
						<b>手续费：</b>{$prefix}".number_format(($zhanzhuanginfo[value]-$zhanzhuanginfo[tovalue]), 2, '.', '')."元
                        <br>
						<b>实际到账：</b>{$prefix}".number_format($zhanzhuanginfo[tovalue], 2, '.', '')."元
						";
	        	  }else
	        	  {
	        	  	$value['name']="站内转入";
	        	  	$zhanzhuanginfo[sername] = user($zhanzhuanginfo['owner'])->get("name");

	        	  	/*
					if($zhanzhuanginfo['is_private'] == 1) {
						
							$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['owner'].'"';
							$q = $this->DatabaseHandler->Query($sql);
							$private = $q->GetRow();
							$public = $private['encrypt_public'];
							$b = "<b>付款匿名地址：</b>$public";
						} else {
							$b = "<b>付款人：</b>$zhanzhuanginfo[username]";
						}
	        	  	*/
					  $b = "<b>付款人：</b>$zhanzhuanginfo[username]";
					
	        	  	$zhanzhuanginfo['info'] = "
	        	  	    <b>到账时间：</b>".date("Y-m-d:H:i:s",$zhanzhuanginfo[addtime])."
                        <br>
					   $b
						<br>
						<b>金额：</b>{$prefix}".number_format($zhanzhuanginfo[tovalue], 2, '.', '')."元
                       <!--< <br>
						b>付款人留言：</b>$zhanzhuanginfo[mark]-->
						";
	        	  }
	        	 $info['intro'] = $zhanzhuanginfo['info'];
        	}elseif ($value['name']=='cp')
        	{

        		$orderinfo = logic('order')->GetOne($info['intro']);

        		 $info['intro'] = "
	        	  	    <b>到账时间：</b>".date("Y-m-d:H:i:s",$orderinfo[paytime])."
                        <br>
						<b>购买人：</b>".user($orderinfo['userid'])->get('name')."
						<br>
						<b>商品名称：</b>".$orderinfo['product'][name]."
						<br>
						<b>订单编号：</b>000".$info['intro']."
						";

        	}elseif ($value['name']=='djq')
        	{

                $orderinfo = logic('order')->GetOne($info['intro']);
        		 $info['intro'] = "
	        	  	    <b>到账时间：</b>".date("Y-m-d:H:i:s",$orderinfo[paytime])."
					    <br>
                        <b>购买人：</b>".user($ticket['uid'])->get('name')."
						<br>
						<b>商品名称：</b>".$orderinfo['product'][name]."
						<br>
						<b>订单编号：</b>000".$info['intro']."
						";

        	}elseif ($value['name']=='hkcz')
        	{

        		$value['name']="汇款充值";
        		$sql = 'select * from ' . TABLE_PREFIX . 'tttuangou_recharge_order where orderid = \'' . $info['intro'] . '\'';
		$query = $this->DatabaseHandler->Query($sql);
		$ticket = $query->GetRow();




        		 $info['intro'] = "
        		  <b>申请时间：</b>".date("Y-m-d H:i",$ticket[createtime])."
        		  <br>
	        	  	   <b>到账时间：</b>".date("Y-m-d H:i",$ticket[paytime])."
						<br>
						<b>订单号：</b>".$ticket[orderid]."


						";

        	}else if($value['name'] == '银行转账') {
                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne($value['intro']);
                if(!empty($zhanzhuanginfo)) {
                    $info['intro'] =  "
                		  <b>开卡行：</b>". $zhanzhuanginfo['yhkinfo']."<br><b>卡号：</b>". $zhanzhuanginfo['yhkkh']."
                		  <br>
                          <b>开户名：</b>".$zhanzhuanginfo['yhkname']."
                          <br>
                		  <b>金额：</b>￥".number_format($zhanzhuanginfo['value'], 2, '.', '')."元<br/><b>时间：</b>".date('Y-m-d H:i',$zhanzhuanginfo['addtime']).
                          "<br/><b>手续费率：</b>".$zhanzhuanginfo['sxhl'].'%<br/>'."<b>手续费：</b>￥".$zhanzhuanginfo['sxfl'].'元<br/>'.
                          "<b>实际到账：</b>￥".number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '').'元<br/>'.
						  "<b>备注：</b>".$zhanzhuanginfo['mark'].
                          "<br/><b>状态：</b>".($zhanzhuanginfo['statue'] == 1? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                }
            }else if($value['name'] == '国际转账'||$value['name'] == '港币汇款'||$value['name'] == '欧元汇款'||$value['name'] == '日元汇款'||$value['name'] == '韩元汇款'||$value['name'] == '英镑汇款'||$value['name'] == '澳元汇款'||$value['name'] == '加元汇款'||$value['name'] == '瑞郎汇款'||$value['name'] == '新西兰元汇款'||$value['name'] == '新加坡元汇款'||$value['name'] == '香港币汇款'||$value['name'] == '比特币汇款'||$value['name'] == '以太币汇款'||$value['name'] == '人民币汇款'||$value['name'] == '美元汇款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne2($value['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne2($zhanzhuanginfo['yhkid']);
			$prefix='';
			if ($zhanzhuanginfo['is_dollar']==1){
				$prefix='USD';
			} elseif ($zhanzhuanginfo['is_hkdollar']==1){
				$prefix='HKD';
			} elseif ($zhanzhuanginfo['is_jpy']==1){
				$prefix='JPY';
			} elseif ($zhanzhuanginfo['is_krw']==1){
				$prefix='KRW';
			} elseif ($zhanzhuanginfo['is_gbp']==1){
				$prefix='GBP';
			} elseif ($zhanzhuanginfo['is_aud']==1){
				$prefix='AUD';
			} elseif ($zhanzhuanginfo['is_cad']==1){
				$prefix='CAD';
			} elseif ($zhanzhuanginfo['is_chf']==1){
				$prefix='CHF';	
			} elseif ($zhanzhuanginfo['is_nzd']==1){
				$prefix='NZD';
			} elseif ($zhanzhuanginfo['is_sgd']==1){
				$prefix='SGD';
			} elseif ($zhanzhuanginfo['is_hkc']==1){
				$prefix='HKC';
			} elseif ($zhanzhuanginfo['is_btc']==1){
				$prefix='BTC';
			} elseif ($zhanzhuanginfo['is_eth']==1){
				$prefix='ETH';
			}elseif ($zhanzhuanginfo['is_money']==1){
                    $prefix="CNY";
                }elseif ($zhanzhuanginfo['is_euro']==1){
                    $prefix="EUR";
                }else{
                    $prefix="CNY";
                }
                if(!empty($zhanzhuanginfo)) {
                    $info['intro'] =  "
                		  <b>收款银行：</b>". $yinhangkainfo['khcity']. $yinhangkainfo['khcc']. "<br><b>收款人帐号：</b>". $yinhangkainfo['cardno']."
                		  <br>
                          <b>收款人姓名：</b>".$yinhangkainfo['name']."
                          <br>
                		  <b>汇款金额：</b>{$prefix}".number_format($zhanzhuanginfo['value'], 2, '.', '')."元<br/><b>时间：</b>".date('Y-m-d H:i',$zhanzhuanginfo['addtime']).
                          "<br/><b>手续费率：</b>".($zhanzhuanginfo['is_sxf'] ==1 ? $zhanzhuanginfo['sxhl'] : '0').'%<br/>'."<b>手续费：</b>{$prefix}".($zhanzhuanginfo['is_sxf'] ==1 ? number_format($zhanzhuanginfo['sxfl'], 2, '.', '') : '0.00').'元<br/>'.
                          "<b>实际到账：</b>{$prefix}".($zhanzhuanginfo['is_sxf'] ==1 ? number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '') : number_format($zhanzhuanginfo['value'], 2, '.', '')) .'元<br/>'.
                          "<b>收取手续费：</b>".($zhanzhuanginfo['is_sxf'] == 1? '是' : '否').
						  "<br/><b>付款人留言：</b>".$zhanzhuanginfo['message'].
						  "<br/><b>汇款用途：</b>".$zhanzhuanginfo['yongtu'].
						  "<br/><b>备注：</b>".$zhanzhuanginfo['mark'].
                          "<br/><b>状态：</b>".($zhanzhuanginfo['statue'] == 1? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                }
            }elseif($value['name'] == '信用卡还款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne3($value['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne3($zhanzhuanginfo['yhkid']);

                if(!empty($zhanzhuanginfo)) {
                    $info['intro']  =  "
                		  <b>开卡行：</b>". $yinhangkainfo['kaihuhang']."<br><b>卡号：</b>". $yinhangkainfo['kahao']."
                		  <br>
                          <b>开户名：</b>".$yinhangkainfo['name']."
                          <br>
                		  <b>还款金额：</b>￥".number_format($zhanzhuanginfo['value'], 2,'.', '')."元<br/><b>时间：</b>".date('Y-m-d H:i',$zhanzhuanginfo['addtime']).
                          "<br/><b>手续费率：</b>".$zhanzhuanginfo['sxhl'].'%<br/>'."<b>手续费：</b>￥".$zhanzhuanginfo['sxfl'].'元<br/>'.
                          "<b>实际付款：</b>￥".number_format(($zhanzhuanginfo['value'] + $zhanzhuanginfo['sxfl']),  2, '.', '').'元<br/>'.
					      "<b>备注：</b>".$zhanzhuanginfo['mark'].
                          "<br/><b>状态：</b>".($zhanzhuanginfo['statue'] == 1? '还款中' :($zhanzhuanginfo['statue'] == 3 ? '还款失败' : '还款成功'));
                }
            }

            $info['uid'] = $info['userid'];
        	$member = $info;
            if ($info['name']=='zn')
        	{
        		if ($info['type']=="plus")
        		{
        		    $info['name']="站内转入";
        		}else
        		{
        			$info['name']="站内转出";
        		}
        	}elseif ($info['name']=='zz')
        	{
        		$info['name']="站内转出";
        	}elseif ($info['name']=='cp')
        	{
        		$info['name']="卖出商品";
        	}elseif ($info['name']=='djq')
        	{
        		$info['name']="卖出团购券";
        	}elseif ($info['name']=='hkcz')
        	{
        		$info['name']="汇款充值";
        	}
	   	 include handler('template')->file('@admin/member_bill_info');

   }
function Bill()
	{
		extract($this->Get);
		$where = "  where 1 and is_confirm = 0 ";//is_confirm=0 代表都已经确认的交易
		$show = (int)$_GET['show'];
        $ttype = $_GET['ttype'];

		if($show ==1)
		{
			//$where.=" and statue =1 ";
		}elseif($show ==2)
		{
			$where.=" and name ='团购商品' ";
		}elseif($show ==3)
		{
			$where.=" and name ='zn' ";
		}elseif($show ==5)
		{
			$where.=" and name ='zz' ";
		} elseif($show ==4)
		{
			$where.=" and name ='账户充值' ";
		}

        if(!empty($ttype)) {
            if($ttype == 1) {
                $where .= " and (is_dollar = 1 or is_hkdollar=1 or is_euro=1 or is_jpy=1 or is_krw=1 or is_gbp=1 or is_aud=1 or is_cad=1 or is_chf=1 or is_nzd=1 or is_sgd=1 or is_hkc=1 or is_btc=1 or is_eth=1) ";
            }elseif($ttype == 2){
                $where .= " and (is_dollar = 0 and is_hkdollar=0 and is_euro=0 and is_jpy=0 and is_krw=0 and is_gbp=0 and is_aud=0 and is_cad=0 and is_chf=0 and is_nzd=0 and is_sgd=0 and is_hkc=0 and is_btc=0 and is_eth=0) ";
            }
        }
        if($_GET['code'] != 'wbdetailslist') {
            $where .= " and (is_dollar = 0 and is_hkdollar=0 and is_euro=0 and is_jpy=0 and is_krw=0 and is_gbp=0 and is_aud=0 and is_cad=0 and is_chf=0 and is_nzd=0 and is_sgd=0 and is_hkc=0 and is_btc=0 and is_eth=0) ";
        }

			$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'tttuangou_usermoney' . "
		  $where";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_usermoney' . "
		  $where
		 order by id desc LIMIT $offset,$page_num";
		$query = $this->DatabaseHandler->Query($sql);

	while($row = $query->GetRow())
		{
			$row['username'] = user($row['userid'])->get("name");
			$row['uid'] =$row['userid'];
			if ($row['name']=='zn')
        	{
        		if ($row['type']=="plus")
        		{
        		$row['name']="站内转入";
        		}else
        		{
        			$row['name']="站内转出";
        		}
        	}elseif ($row['name']=='zz')
        	{
        		$row['name']="站内转出";
        	}elseif ($row['name']=='cp')
        	{
        		$row['name']="卖出商品";
        	}elseif ($row['name']=='djq')
        	{
        		$row['name']="卖出团购券";
        	}elseif ($row['name']=='hkcz')
        	{
        		$row['name']="汇款充值";
        	}

        	//
        	$reg='/^\d+$/';
        	if(preg_match($reg,$row['intro'])){
        		$row['intro']='订单号：'.$row['intro'];
        	}

        	/*
			if($row['is_private'] == 1) {
						
				$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $row['userid'].'"';
				$q = $this->DatabaseHandler->Query($sql);
				$private = $q->GetRow();
				$row['username'] = $private['encrypt_public'];
				
			}
        	*/
			
			$member_list[] = $row;
		}
        if($this->Code == 'wbdetailslist') {
            include handler('template')->file('@admin/member_wbdetailslist');
        }else{
		    include handler('template')->file('@admin/member_bill_list');
        }
	}

    function wbdhlist(){
        extract($this->Get);
		$where = "  where 1=1 ";
        $ttype = $_GET['type'];
        $wbsklist = array();
		if(isset($ttype) && $ttype !== ''){
         //   if($ttype == 0) {
                $where .= " and type={$ttype}";
        //    }else if($ttype == 1) {
          //      $where .= " and type=1";
            //}
        }

		$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'tttuangou_wbsk' . "
		  $where";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_wbsk' . "
		  $where
		 order by id desc  LIMIT $offset,$page_num";
		$query = $this->DatabaseHandler->Query($sql);
		$arr=array(
				0=>'人民币兑换美元',
			    1=>'美元兑换人民币',
				3=>'人民币兑换港币',
				2=>'港币兑换人民币',
				5=>'人民币兑换欧元',
				4=>'欧元兑换人民币',
				7=>'人民币兑换日元',
				6=>'日元兑换人民币',
				9=>'人民币兑换韩元',
				8=>'韩元兑换人民币',
				11=>'人民币兑换英镑',
				10=>'英镑兑换人民币',
				13=>'人民币兑换澳元',
				12=>'澳元兑换人民币',
				15=>'人民币兑换加元',
				14=>'加元兑换人民币',
				17=>'人民币兑换瑞郎',
				16=>'瑞郎兑换人民币',
				19=>'人民币兑换新西兰元',
				18=>'新西兰元兑换人民币',
				21=>'人民币兑换新加坡元',
				20=>'新加坡元兑换人民币',
				23=>'人民币兑换香港币',
				22=>'香港币兑换人民币',
				24=>'美元兑换欧元',
				25=>'美元兑换日元',
				26=>'美元兑换英镑',
				27=>'美元兑换澳元',
				28=>'美元兑换加元',
				29=>'美元兑换瑞郎',
				30=>'美元兑换新西兰元',
				31=>'美元兑换新加坡元',
				32=>'美元兑换香港币',
				33=>'美元兑换港币',
				34=>'香港币兑换欧元',
				35=>'香港币兑换日元',
				36=>'香港币兑换英镑',
				37=>'香港币兑换澳元',
				38=>'香港币兑换加元',
				39=>'香港币兑换瑞郎',
				40=>'香港币兑换新西兰元',
				41=>'香港币兑换新加坡元',
				42=>'香港币兑换美元',
				43=>'香港币兑换港币',
				63=>'香港币兑换比特币',
				64=>'香港币兑换以太币',

				44=>'欧元兑换美元',
				45=>'日元兑换美元',
				46=>'英镑兑换美元',
				47=>'澳元兑换美元',
				48=>'加元兑换美元',
				49=>'瑞郎兑换美元',
				50=>'新西兰元兑换美元',
				51=>'新加坡元兑换美元',
				53=>'港币兑换美元',
				54=>'欧元兑换香港币',
				55=>'日元兑换香港币',
				56=>'英镑兑换香港币',
				57=>'澳元兑换香港币',
				58=>'加元兑换香港币',
				59=>'瑞郎兑换香港币',
				60=>'新西兰元兑换香港币',
				61=>'新加坡元兑换香港币',
				62=>'港币兑换香港币',
				65=>'比特币兑换香港币',
				66=>'以太币兑换香港币',
				// 42=>'香港币兑换香港币',
				// 43=>'港币兑换香港币',
		);
		$showusa= array(24,25,26,27,28,29,30,31,32,33);
		$showhkc= array(34,35,36,37,38,39,40,41,42,43,63,64);
		$sjusa= array(44,45,46,47,48,49,50,51,52,53);
		$sjhkc= array(54,55,56,57,58,59,60,61,62,63,65,66);
	    while($row = $query->GetRow())
		{
			$row['username'] = user($row['userid'])->get("name");
			$row['typename'] =$arr[$row['type']];
			$row['showdate'] = date('Y-m-d H:i', $row['date']);
			if (in_array($row['type'],$showusa)){
				$row['showdhje']=('USD'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('USD'.$row['sxf']);
			}

			if (in_array($row['type'],$showhkc)){
				$row['showdhje']=('HKC'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('HKC'.$row['sxf']);
			}
			
			if ( $row['type'] == 1){
				$row['showdhje']=('USD'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('USD'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}elseif ( $row['type'] == 2 || $row['type'] == 53 || $row['type'] == 62){
				$row['showdhje']=('HKD'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('HKD'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 4 || $row['type'] == 44 || $row['type'] == 54){
				$row['showdhje']=('EUR'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('EUR'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 6 || $row['type'] == 45 || $row['type'] == 55){
				$row['showdhje']=('JPY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('JPY'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 8){
				$row['showdhje']=('KRW'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('KRW'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 10 || $row['type'] == 46 || $row['type'] == 56){
				$row['showdhje']=('gbp'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('gbp'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 12 || $row['type'] == 47 || $row['type'] == 57){
				$row['showdhje']=('aud'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('aud'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 14 || $row['type'] == 48 || $row['type'] == 58){
				$row['showdhje']=('cad'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('cad'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 16 || $row['type'] == 49 || $row['type'] == 59){
				$row['showdhje']=('chf'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('chf'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 18 || $row['type'] == 50 || $row['type'] == 60){
				$row['showdhje']=('nzd'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('nzd'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 20 || $row['type'] == 51 || $row['type'] == 61){
				$row['showdhje']=('sgd'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('sgd'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 22 ){
				$row['showdhje']=('hkc'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('hkc'.$row['sxf']);
				$row['showsjdhje']= ('CNY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 63 ){
				$row['showdhje']=('hkc'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('hkc'.$row['sxf']);
				$row['showsjdhje']= ('BTC'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 64 ){
				$row['showdhje']=('hkc'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('hkc'.$row['sxf']);
				$row['showsjdhje']= ('ETH'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 3){
				// if()
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('HKD'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 5){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('EUR'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 7){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('JPY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 9){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('KRW'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 11){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('gbp'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 13){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('aud'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 15){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('cad'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 17){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('chf'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 19){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('nzd'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 21){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('sgd'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 23){
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('hkc'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 65){
				$row['showdhje']=('BTC'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('BTC'.$row['sxf']);
				$row['showsjdhje']= ('hkc'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 66){
				$row['showdhje']=('ETH'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('ETH'.$row['sxf']);
				$row['showsjdhje']= ('hkc'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 24 || $row['type'] == 34 ){
				$row['showsjdhje']= ('ERU'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 25 || $row['type'] == 35){
				$row['showsjdhje']= ('JPY'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 26 || $row['type'] == 36){
				$row['showsjdhje']= ('GBP'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 27 || $row['type'] == 37){
				$row['showsjdhje']= ('AUD'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 28 || $row['type'] == 38){
				$row['showsjdhje']= ('CAD'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 29 || $row['type'] == 39){
				$row['showsjdhje']= ('CHF'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 30 || $row['type'] == 40){
				$row['showsjdhje']= ('NZD'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 31 || $row['type'] == 41){
				$row['showsjdhje']= ('SGD'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 33 || $row['type'] == 43){
				$row['showsjdhje']= ('HKD'.number_format($row['sjdhje'], 2, '.', ''));
			}
			elseif ( $row['type'] == 32 || $row['type'] == 42 ){

			}
			else{
				$row['showdhje']=('CNY'.number_format($row['dhje'], 2, '.', ''));
				$row['showsxf'] =('CNY'.$row['sxf']);
				$row['showsjdhje']= ('USD'.number_format($row['sjdhje'], 2, '.', ''));
			}

			if ( $row['type'] == 32 ||  in_array($row['type'],$sjhkc)){
				$row['showsjdhje']= ('HKC'.number_format($row['sjdhje'], 2, '.', ''));
			}
			if ( $row['type'] == 42 || in_array($row['type'],$sjusa)){
				$row['showsjdhje']= ('USD'.number_format($row['sjdhje'], 2, '.', ''));
			}
        //    $row['showdhje'] = $row['type'] == 1 ? ('$'.number_format($row['dhje'], 2, '.', '')) :  ('￥'.number_format($row['dhje'], 2, '.', ''));
         //   $row['showsxf'] = $row['type'] == 1 ? ('$'.$row['sxf']) :  ('￥'.$row['sxf']);
          //  $row['showsjdhje'] = $row['type'] == 1 ? ('￥'.number_format($row['sjdhje'], 2, '.', '')) :  ('$'.number_format($row['sjdhje'], 2, '.', ''));
			$wbsklist[] = $row;

		}

		include handler('template')->file('@admin/member_wbsk_list');

    }

	function lcb()
	{
		extract($this->Get);
		$where = "  where 1=1";
		$show = (int)$_GET['show'];
		if($show ==1)
		{
			//$where.=" and statue =1 ";
		}elseif($show ==2)
		{
			$where.=" and (name ='理财宝转出' or name ='币息宝转出' )";
		}elseif($show ==3)
		{
			$where.=" and (name ='理财宝转入' or name='币息宝转入') ";
		}elseif($show ==5)
		{
			$where.=" and (name ='理财宝收益' or name='币息宝收益' )";
		}
		else
		{
			$where.=" and (name like '理财宝__' or name like '币息宝__' ) ";
		}

			$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'tttuangou_usermoney' . "
		  $where";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_usermoney' . "
		  $where
		 order by id desc  LIMIT $offset,$page_num";
		$query = $this->DatabaseHandler->Query($sql);

	while($row = $query->GetRow())
		{
			$row['username'] = user($row['userid'])->get("name");
			$row['uid'] =$row['userid'];
			$member_list[] = $row;
		}
		include handler('template')->file('@admin/member_lcb_list');

	}
	
	function lcbhistorysy()
	{
		$product=ConfigHandler::get('product');
		$hsy = array();
		for($day=1;$day<=10;$day++){
			$sql = "select * from ".TABLE_PREFIX."tttuangou_usermoney WHERE time>=".strtotime(date('Y-m-'.(date('d')-$day).' 00:00:00'))." and  time<=".strtotime(date('Y-m-'.(date('d')-$day).' 23:59:59'))." and (name='理财宝收益' or name='币息宝收益') and userid='".$userid."';";
			$query = $this->DatabaseHandler->Query($sql);
			if($row = $query->GetRow()) {
				//当日已发放收益
			} else {
				//未发放收益
				
				$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=0 and userid={$userid} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-'.(date('d')-($day-1)).' 00:00'))." group by type order by type desc";
				$q = $this->DatabaseHandler->Query($sql);
		
				$sum=$q->GetRow();
				$um=$q->GetRow();
				if($sum['type']=='minus'&&!empty($um))
				{
					$sum['lcb']-=$um['lcb'];
				}
				$sum=$sum['lcb'];
				$v=bcmul($sum,$product['default_lcbv'],2);
				$hsy[date('Y-m-'.(date('d')-$day) )]['dcep'] = $v; 
				
		
				$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=1 and userid={$userid} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-'.(date('d')-($day-1)).' 00:00'))." group by type order by type desc";
	
		
				$q = $this->DatabaseHandler->Query($sql);

				$sum=$q->GetRow();
				$um=$q->GetRow();
				if($sum['type']=='minus'&&!empty($um))
				{
					$sum['lcb']-=$um['lcb'];
				}
				$sum=$sum['lcb'];
		
				$ll = round((((float)$product['default_hkc']/100)/365),6);
			
				$v_hkc=round($sum*$ll, 2);
				$hsy[date('Y-m-'.(date('d')-$day) )]['hkc'] = $v_hkc; 
			}
		}
		
	}
	
	function lcbsyhs()
	{
		
		$uid=(int)$_GET['uid'];
		$userinfo=user($uid)->get('*');
		$mc = $_GET['mc'];
		
		
		//if($mc=='dcep'){
			
		for($day=1;$day<=10;$day++){
			
			$sql="select count(*) as ct from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=0 and (name='理财宝收益' or name='币息宝收益' ) and userid={$userinfo['id']} and  time>=".strtotime(date('Y-m-d 00:00:00', strtotime('-'.$day.' day')))." and  time<=".strtotime(date('Y-m-d 23:59:59', strtotime('-'.$day.' day')));
			
			$query=$this->DatabaseHandler->Query($sql);
			$row=$query->GetRow();
			if($row['ct']>0)
			{
			} else {
				$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=0 and userid={$userinfo['id']} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-d 00:00:00', strtotime('-'.($day-1).' day')))." group by type order by type desc";
				$q = $this->DatabaseHandler->Query($sql);
				$sum=$q->GetRow();
				$um=$q->GetRow();
				if($sum['type']=='minus'&&!empty($um))
				{
					$sum['lcb']-=$um['lcb'];
				}
				$sum=$sum['lcb'];
				if($sum==0)
				{
				
					
				} else {
					Load::logic('me');
					$this->MeLogic = new MeLogic();
					$product=ConfigHandler::get('product');
					
					$sy=bcmul($sum,$product['default_lcbv'],2);
					$this->MeLogic->money()->add($sy,$userinfo['id'],array('name'=>'币息宝收益','intro'=>'<b>'.
date('Y-m-d', strtotime('-'.$day.' day') ).'收益发放</b><br /><b>账户DCEP余额:</b>'.($userinfo['money']+$sy), 'time'=>strtotime(date('Y-m-d 12:13:14', strtotime('-'.$day.' day') ))));
					$this->MeLogic->money()->less($sy,347,array('name'=>'币息宝收益','intro'=>
date('Y-m-d', strtotime('-'.$day.' day') ).' 用户收益发放', 'time'=>strtotime(date('Y-m-d 12:13:14', strtotime('-'.$day.' day') ))));
					$product['d']=date('d');
					ConfigHandler::set('product',$product);
			
				}
		
			}
		}
	

		for($day=1;$day<=10;$day++){
		
			
			$sql="select count(*) as ct from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=1 and (name='理财宝收益' or name='币息宝收益' ) and userid={$userinfo['id']} and  time>=".strtotime(date('Y-m-d 00:00:00', strtotime('-'.$day.' day')))." and  time<=".strtotime(date('Y-m-d 23:59:59', strtotime('-'.$day.' day')));
		
	
			$query=$this->DatabaseHandler->Query($sql);
			$row=$query->GetRow();
			if($row['ct']>0)
			{
			}else {
				
				$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=1 and userid={$userinfo['id']} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-d 00:00:00', strtotime('-'.($day-1).' day')))." group by type order by type desc";
				$q = $this->DatabaseHandler->Query($sql);
				$sum=$q->GetRow();
				$um=$q->GetRow();
				if($sum['type']=='minus'&&!empty($um))
				{
					$sum['lcb']-=$um['lcb'];
				}
				$sum=$sum['lcb'];
				if($sum==0)
				{
				

				} else {
				Load::logic('me');
				$this->MeLogic = new MeLogic();
				$product=ConfigHandler::get('product');
				
				
				$ll = round((((float)$product['default_hkc']/100)/365),6);
				
				$sy=round($sum*$ll, 2);
				
				
				
				$this->MeLogic->money()->add($sy,$userinfo['id'],array('name'=>'币息宝收益','intro'=>'<b>'.date('Y-m-d', strtotime('-'.$day.' day') ).'收益发放</b><br /><b>账户HKC余额:</b>'.($userinfo['hkc']+$sy) , 'is_hkc'=>$is_hkc = 1, 'time'=>strtotime(date('Y-m-d 12:13:14', strtotime('-'.$day.' day') ))), $is_dollar=12);
				$this->MeLogic->money()->less($sy,347,array('name'=>'币息宝收益','intro'=>date('Y-m-d', strtotime('-'.$day.' day') ).' 用户收益发放', 'is_hkc'=>$is_hkc = 1, 'time'=>strtotime(date('Y-m-d 12:13:14', strtotime('-'.$day.' day') ))), $is_dollar=12);
				$product['d']=date('d');
				ConfigHandler::set('product',$product);
			
				}
				
			}
		
		}
		
		
		//today
		
			
		$sql="select count(*) as ct from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=0 and (name='理财宝收益' or name='币息宝收益' ) and userid={$userinfo['id']} and time>".strtotime(date('Y-m-d 00:00'));
		$query=$this->DatabaseHandler->Query($sql);
		$row=$query->GetRow();
		if($row['ct']>0)
		{
		
		} else {
		
			
			$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=0 and userid={$userinfo['id']} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-d 00:00', strtotime('-1 day')))." group by type order by type desc";
			$q = $this->DatabaseHandler->Query($sql);
			$sum=$q->GetRow();
			$um=$q->GetRow();
			if($sum['type']=='minus'&&!empty($um))
			{
				$sum['lcb']-=$um['lcb'];
			}
			$sum=$sum['lcb'];
			if($sum==0)
			{
	
				
			} else {
				Load::logic('me');
				$this->MeLogic = new MeLogic();
				$product=ConfigHandler::get('product');
				
				$sy=bcmul($sum,$product['default_lcbv'],2);
				$this->MeLogic->money()->add($sy,$userinfo['id'],array('name'=>'币息宝收益','intro'=>'<b>账户DCEP余额:</b>'.($userinfo['money']+$sy)));
				$this->MeLogic->money()->less($sy,347,array('name'=>'币息宝收益','intro'=>date('Y-m-d').' 用户收益发放'));
				$product['d']=date('d');
				ConfigHandler::set('product',$product);
			
			}
	
		}
	
	
		//hkc
		$sql="select count(*) as ct from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=1 and (name='理财宝收益' or name='币息宝收益' ) and userid={$userinfo['id']} and time>".strtotime(date('Y-m-d 00:00'));
		$query=$this->DatabaseHandler->Query($sql);
		$row=$query->GetRow();
		if($row['ct']>0)
		{
	

		}else {
		
			
			$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=1 and userid={$userinfo['id']} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-d 00:00', strtotime('-1 day')))." group by type order by type desc";
			$q = $this->DatabaseHandler->Query($sql);
			$sum=$q->GetRow();
			$um=$q->GetRow();
			if($sum['type']=='minus'&&!empty($um))
			{
				$sum['lcb']-=$um['lcb'];
			}
			$sum=$sum['lcb'];
			if($sum==0)
			{
		

			} else {
			Load::logic('me');
			$this->MeLogic = new MeLogic();
			$product=ConfigHandler::get('product');
			
			
			$ll = round((((float)$product['default_hkc']/100)/365),6);
			
			$sy=round($sum*$ll, 2);
			
			
			
			$this->MeLogic->money()->add($sy,$userinfo['id'],array('name'=>'币息宝收益','intro'=>'<b>账户HKC余额:</b>'.($userinfo['hkc']+$sy) , 'is_hkc'=>$is_hkc = 1), $is_dollar=12);
			$this->MeLogic->money()->less($sy,347,array('name'=>'币息宝收益','intro'=>date('Y-m-d').' 用户收益发放', 'is_hkc'=>$is_hkc = 1), $is_dollar=12);
			$product['d']=date('d');
			ConfigHandler::set('product',$product);
	
			}
		}
		echo '1';
	
	}
	
	
	function lcbff()
	{

		extract($this->Get);
		$product=ConfigHandler::get('product');
		

		$sql = "select sum(lcb_money) as num from ".TABLE_PREFIX."system_members;";
		$query = $this->DatabaseHandler->Query($sql);
		$row = $query->GetRow();
		
		$lcb_dcep_total = $row['num'];
		
		$sql = "select sum(lcb_hkc_money) as num from ".TABLE_PREFIX."system_members;";
		$query = $this->DatabaseHandler->Query($sql);
		$row = $query->GetRow();
		
		$lcb_hkc_total = $row['num'];
		
		$sql = "select aa.*,bb.id,bb.time from ".TABLE_PREFIX."system_members as aa left join (SELECT * FROM ".TABLE_PREFIX."tttuangou_usermoney WHERE time>".strtotime(date('Y-m-d 00:00'))." and (name='理财宝收益' or name='币息宝收益') group by userid) as bb on uid=userid where lcb_money>0 or lcb_hkc_money >0";
		$query = $this->DatabaseHandler->Query($sql);
		$member_list=array();
		$lcb_all_dcep =0;
		while($row = $query->GetRow())
		{
			if(empty($row['id']))
			{
				$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=0 and userid={$row['uid']} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-d 00:00', strtotime('-1 day')))." group by type order by type desc";
				$q = $this->DatabaseHandler->Query($sql);
		
				$sum=$q->GetRow();
				$um=$q->GetRow();
				if($sum['type']=='minus'&&!empty($um))
				{
					$sum['lcb']-=$um['lcb'];
				}
				$sum=$sum['lcb'];
				$v=bcmul($sum,$product['default_lcbv'],2);
		
				$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=1 and userid={$row['uid']} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-d 00:00', strtotime('-1 day')))." group by type order by type desc";
	
				$q = $this->DatabaseHandler->Query($sql);

				$sum=$q->GetRow();
				$um=$q->GetRow();
				if($sum['type']=='minus'&&!empty($um))
				{
					$sum['lcb']-=$um['lcb'];
				}
				$sum=$sum['lcb'];
		
				$ll = round((((float)$product['default_hkc']/100)/365),6);
			
				$v_hkc=round($sum*$ll, 2);
			}
			else
			{
				$v=0;
				$v_hkc=0;
			}
			$row['lcb_sy']=$v;
			$row['lcb_sy_hkc']=$v_hkc;
		
			$userid=$row['uid'];
			$hsy = array();
			$is_has_history = false;
			$is_has_history_hkc = false;
			$history = 0;
			$history_hkc = 0;
			for($day=1;$day<=10;$day++){
				
				$sql = "select * from ".TABLE_PREFIX."tttuangou_usermoney WHERE is_hkc=0 and time>=".strtotime(date('Y-m-d 00:00:00', strtotime('-'.$day.' day')))." and  time<=".strtotime(date('Y-m-d 23:59:59', strtotime('-'.$day.' day')))." and (name='理财宝收益' or name='币息宝收益') and userid='".$userid."';";
	
				$squery = $this->DatabaseHandler->Query($sql);
				
				if($srow = $squery->GetRow()) {
				
				
				} else {
					//未发放收益
			
					$is_has_history = true;
					$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=0 and userid={$userid} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-d 00:00:00', strtotime('-'.($day-1).' day')))." group by type order by type desc";
					$q = $this->DatabaseHandler->Query($sql);
			
					$sum=$q->GetRow();
					$um=$q->GetRow();
					if($sum['type']=='minus'&&!empty($um))
					{
						$sum['lcb']-=$um['lcb'];
					}
					$sum=$sum['lcb'];
					$v=bcmul($sum,$product['default_lcbv'],2);
					$history+=$v;
					if($v>0){
					$hsy['dcep'][] = date('Y-m-d', strtotime('-'.$day.' day') ).'：'.$v;
					}
					
				}
	
				$sql = "select * from ".TABLE_PREFIX."tttuangou_usermoney WHERE is_hkc=1 and time>=".strtotime(date('Y-m-d 00:00:00', strtotime('-'.$day.' day')))." and  time<=".strtotime(date('Y-m-d 23:59:59', strtotime('-'.$day.' day')))." and (name='理财宝收益' or name='币息宝收益') and userid='".$userid."';";
				$squery = $this->DatabaseHandler->Query($sql);
				if($srow = $squery->GetRow()) {
					//当日已发放收益
			
				} else {
					//未发放收益
					$is_has_history_hkc = true;
					$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=1 and userid={$userid} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-d 00:00:00', strtotime('-'.($day-1).' day')))." group by type order by type desc";
				
			
					$q = $this->DatabaseHandler->Query($sql);

					$sum=$q->GetRow();
					$um=$q->GetRow();
					if($sum['type']=='minus'&&!empty($um))
					{
						$sum['lcb']-=$um['lcb'];
					}
					$sum=$sum['lcb'];
			
					$ll = round((((float)$product['default_hkc']/100)/365),6);
				
					$v_hkc=round($sum*$ll, 2);
			
					$history_hkc+=$v_hkc;
					if($v_hkc>0){
						$hsy['hkc'][] =  date('Y-m-d', strtotime('-'.$day.' day') ).'：'.$v_hkc; 
					}
				}
				
			}
			
			
			$row['is_has_history']=$is_has_history;
			$row['is_has_history_hkc']=$is_has_history_hkc;
			$row['lcb_sy_o'] = $row['lcb_sy'];
			$row['lcb_sy_hkc_o'] = $row['lcb_sy_hkc'];
			$row['lcb_sy']+=$history;
			$row['lcb_sy_hkc']+=$history_hkc;
			$row['history'] = $history;
			$row['history_hkc'] = $history_hkc;
			$row['history_detail'] = $hsy;

			$member_list[] = $row;
		}
	
		
		include handler('template')->file('@admin/member_lcbff_list');
		
	}
	
	

	function lcbsy()
	{
		$uid=(int)$_GET['uid'];
		$userinfo=user($uid)->get('*');
		
			
		$sql="select count(*) as ct from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=0 and (name='理财宝收益' or name='币息宝收益' ) and userid={$userinfo['id']} and time>".strtotime(date('Y-m-d 00:00'));
		$query=$this->DatabaseHandler->Query($sql);
		$row=$query->GetRow();
		if($row['ct']>0)
		{
			echo '2';
		} else {
		
			
			$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=0 and userid={$userinfo['id']} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-'.(date('d')-1).' 00:00'))." group by type order by type desc";
			$q = $this->DatabaseHandler->Query($sql);
			$sum=$q->GetRow();
			$um=$q->GetRow();
			if($sum['type']=='minus'&&!empty($um))
			{
				$sum['lcb']-=$um['lcb'];
			}
			$sum=$sum['lcb'];
			if($sum==0)
			{
				echo '1';
				
			} else {
				Load::logic('me');
				$this->MeLogic = new MeLogic();
				$product=ConfigHandler::get('product');
				
				$sy=bcmul($sum,$product['default_lcbv'],2);
				$this->MeLogic->money()->add($sy,$userinfo['id'],array('name'=>'币息宝收益','intro'=>'<b>账户DCEP余额:</b>'.($userinfo['money']+$sy)));
				$this->MeLogic->money()->less($sy,347,array('name'=>'币息宝收益','intro'=>date('Y-m-d').' 用户收益发放'));
				$product['d']=date('d');
				ConfigHandler::set('product',$product);
				echo '1';
			}
	
		}
	
	
		//hkc
		$sql="select count(*) as ct from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=1 and (name='理财宝收益' or name='币息宝收益' ) and userid={$userinfo['id']} and time>".strtotime(date('Y-m-d 00:00'));
		$query=$this->DatabaseHandler->Query($sql);
		$row=$query->GetRow();
		if($row['ct']>0)
		{
			echo '2';

		}else {
		
			
			$sql="select type,sum(money) as lcb from ".TABLE_PREFIX."tttuangou_usermoney where is_hkc=1 and userid={$userinfo['id']} and name in ('理财宝转入','理财宝转出','币息宝转入','币息宝转出') and time<".strtotime(date('Y-m-'.(date('d')-1).' 00:00'))." group by type order by type desc";
			$q = $this->DatabaseHandler->Query($sql);
			$sum=$q->GetRow();
			$um=$q->GetRow();
			if($sum['type']=='minus'&&!empty($um))
			{
				$sum['lcb']-=$um['lcb'];
			}
			$sum=$sum['lcb'];
			if($sum==0)
			{
				echo '1';

			} else {
			Load::logic('me');
			$this->MeLogic = new MeLogic();
			$product=ConfigHandler::get('product');
			
			
			$ll = round((((float)$product['default_hkc']/100)/365),6);
			
			$sy=round($sum*$ll, 2);
			
			
			
			$this->MeLogic->money()->add($sy,$userinfo['id'],array('name'=>'币息宝收益','intro'=>'<b>账户HKC余额:</b>'.($userinfo['hkc']+$sy) , 'is_hkc'=>$is_hkc = 1), $is_dollar=12);
			$this->MeLogic->money()->less($sy,347,array('name'=>'币息宝收益','intro'=>date('Y-m-d').' 用户收益发放', 'is_hkc'=>$is_hkc = 1), $is_dollar=12);
			$product['d']=date('d');
			ConfigHandler::set('product',$product);
			echo '1';
			}
		}
			
	}
	

	function Zhannei()
	{
		extract($this->Get);
		$where = "  where 1 ";
		$show = (int)$_GET['show'];
		$type = (int)$_GET['money_type'];
		if($show ==1)
		{
			$where.=" and statue =2 ";
		}elseif($show ==2)
		{
			$where.=" and statue <>2 ";
		}
		if ($type==1){
			$where .= " and money_type > 0 ";
		} else{
			$where .= " and money_type = 0 ";
		}
		

			$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'tttuangou_zhanneilist' . "
		  $where";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_zhanneilist' . "
		  $where
		  order by id desc  LIMIT $offset,$page_num";
		$query = $this->DatabaseHandler->Query($sql);

	while($row = $query->GetRow())
		{
			$row['username'] = user($row['owner'])->get("name");
			$row['uid'] = user($row['owner'])->get("id");

			$row['tousername'] = user($row['touid'])->get("name");
            $row['value'] = number_format($row['value'], 2 , '.', '');
            $row['tovalue'] = number_format($row['tovalue'], 2 , '.', '');

            if ($row['money_type']==1){
                        $prefix='USD';
            }elseif ($row['money_type']==2){
                $prefix="HKD";
			}elseif ($row['money_type']==3){
                $prefix="EUR";
			}elseif ($row['money_type']==4){
                $prefix="JPY";
			}elseif ($row['money_type']==5){
                $prefix="KRW";
			}elseif ($row['money_type']==6){
                $prefix="GBP";
			}elseif ($row['money_type']==7){
                $prefix="AUD";
			}elseif ($row['money_type']==8){
                $prefix="CAD";
            }elseif ($row['money_type']==9){
                $prefix="CHF";
			}elseif ($row['money_type']==10){
                $prefix="NZD";
			}elseif ($row['money_type']==11){
                $prefix="SGD";
            }elseif ($row['money_type']==12){
                $prefix="HKC";
			}elseif ($row['money_type']==13){
				$prefix="BTC";
			}elseif ($row['money_type']==14){
				$prefix="ETH";
			}else{
                $prefix="CNY";
            }
            $row['prefix']=$prefix;

            /*
			if($row['is_private'] == 1) {
						
				$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $row['owner'].'"';
				$q = $this->DatabaseHandler->Query($sql);
				$private = $q->GetRow();
				$row['username'] = $private['encrypt_public'];
				
				$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $row['touid'].'"';
				$q = $this->DatabaseHandler->Query($sql);
				$private = $q->GetRow();
				$row['tousername'] = $private['encrypt_public'];
				
			}
            */
			
			
			$member_list[] = $row;
		}
		include handler('template')->file('@admin/member_zhannei_list');

	}


	function DoDelete_nm()
	{
		$this->IDS = (array) ($this->IDS ? $this->IDS : $this->ID);
		foreach ($this->IDS as $key=>$val) {
			if(1 > ($this->IDS[$key] = (int) $val)) {
				unset($this->IDS[$key]);
			}
		}
		if (!$this->IDS) {
			$this->Messager("请先指定一个要删除的用户ID",null);
		}
		//$query = $this->DatabaseHandler->Query("select * from ".TABLE_PREFIX."system_members where `uid` in('".implode("','",$this->IDS)."')");
		
		$query = $this->DatabaseHandler->Query("select * from cenwor_tttuangou_user_private_key where `id` in('".implode("','",$this->IDS)."')");

		$member_ids = array();
		$admin_list = array();
		$member_ids_count = 0;
		while ($row = $query->GetRow())
		{
			/*
			if(1==$row['uid'] || $row['role_type']=='admin') {
				$admin_list[$row['uid']] = $row['username'];
				continue;
			}
			

						if(true === UCENTER && $row['ucuid'] > 0) {
				include_once(UC_CLIENT_ROOT . './client.php');

				uc_user_delete($row['ucuid']);
			}
			*/
			$member_ids[$row['id']] = $row['id'];
		}
		if(isset($member_ids[1])) unset($member_ids[1]);

		if (0 < ($member_ids_count =  count($member_ids))) {
						/*
						$this->DatabaseHandler->Query("delete from `".TABLE_PREFIX."system_members` where `uid` in ('".implode("','",$member_ids)."')");
						$this->DatabaseHandler->Query("delete from `".TABLE_PREFIX."system_memberfields` where `uid` in('".implode("','",$member_ids)."')");
						$this->DatabaseHandler->Query("delete from `".TABLE_PREFIX."system_log` where `uid` in('".implode("','",$member_ids)."')");
						*/
						
						$this->DatabaseHandler->Query("delete from cenwor_tttuangou_user_private_key where `id` in ('".implode("','",$member_ids)."')");
						foreach ($member_ids as $i => $uid)
			{
				$aliuid = meta('luid_'.$uid);
				meta('luid_'.$uid, null);
				meta('token_'.$aliuid, null);
				meta('ul.alipay.'.$aliuid, null);
			}
		}

		$msg = '';
		$msg .= "成功删除<b>{$member_ids_count}</b>位会员";
		/*
		if($admin_list) {
			$msg .= "，其中<b>".implode(' , ',$admin_list)."</b>是管理员，不能直接删除";
		}
		*/
		$this->Messager($msg);
	}
	
		function Modify()
	{
		$this->Title="编辑用户";
		$action="admin.php?mod=member&code=domodify";
				$sql="
		 SELECT
			 *
		 FROM
			 ".TABLE_PREFIX.'system_members'." M LEFT JOIN ".TABLE_PREFIX.'system_memberfields'." MF ON(M.uid=MF.uid)
		 WHERE
			 M.uid={$this->ID}";

		$query = $this->DatabaseHandler->Query($sql);
		$uid=$this->ID;
		$member_info=$query->GetRow();
		$money_zaitu=logic('order')->GetFreezeMoney($uid, 0);

		$dollar_zaitu=logic('order')->GetFreezeMoney($uid, 1);

		$hkdollar_zaitu=logic('order')->GetFreezeMoney($uid, 2);
		$euro_zaitu=logic('order')->GetFreezeMoney($uid, 3);
		$jpy_zaitu=logic('order')->GetFreezeMoney($uid, 4);
		$krw_zaitu=logic('order')->GetFreezeMoney($uid, 5);
		$gbp_zaitu=logic('order')->GetFreezeMoney($uid, 6);
		$aud_zaitu=logic('order')->GetFreezeMoney($uid, 7);
		$cad_zaitu=logic('order')->GetFreezeMoney($uid, 8);
		$chf_zaitu=logic('order')->GetFreezeMoney($uid, 9);
		$nzd_zaitu=logic('order')->GetFreezeMoney($uid, 10);
		$sgd_zaitu=logic('order')->GetFreezeMoney($uid, 11);
		$hkc_zaitu=logic('order')->GetFreezeMoney($uid, 12);

		$btc_zaitu=logic('order')->GetFreezeMoney($uid, 13);
		$eth_zaitu=logic('order')->GetFreezeMoney($uid, 14);
		if($member_info==false)
		{
			$this->Messager("用户已经不存在");
		}
		//var_dump($member_info)；die;
		extract($member_info);

		 $yzinfo = logic('yanzheng')->GetOne($uid);

		//$username = $yzinfo['idname'];

				$sql = "
		 SELECT
			 id,name
		 FROM
			 " . TABLE_PREFIX.'system_role' . "
		 WHERE
			 id!=1";
		$query = $this->DatabaseHandler->Query($sql);
		while($row = $query->GetRow())
		{
			$role_list[$row['id']] = array('name' => $row['name'], 'value' => $row['id']);
		}

				foreach($this->Config as $field => $name)
		{
			if(strpos($field, 'credits') !== false)
			{
				if($name != '')
				{
					$credit_list[$field] = $name;
				}
			}
		}

		$role_select = $this->FormHandler->Select('role_id', $role_list,$role_id);
		$role_name = $role_list[$role_id]['name'];
		$gender_radio=$this->FormHandler->Radio('gender',array(
		array('name'=>"男",'value'=>'1'),
		array('name'=>"女",'value'=>'2'),
		array('name'=>"保密",'value'=>'0'),
		),$gender);
		list($year,$month,$day)=explode('-',$bday);
		$year_select=$this->FormHandler->NumSelect('year','1920','2006',$year!='0000'?$year:1980);
		$month_select=$this->FormHandler->NumSelect('month','1','12',$month);
		$day_select=$this->FormHandler->NumSelect('day','1','31',$day);
		$validate_radio = $this->FormHandler->YesNoRadio('validate',$member_info['validate']);
		$_options = array(
			'0' => array(
				'name' => '请选择',
				'value' => '0',
			),
			'身份证' => array(
				'name' => '身份证',
				'value' => '身份证',
			),
			'学生证' => array(
				'name' => '学生证',
				'value' => '学生证',
			),
			'军官证' => array(
				'name' => '军官证',
				'value' => '军官证',
			),
			'护照' => array(
				'name' => '护照',
				'value' => '护照',
			),
			'其他' => array(
				'name' => '其他',
				'value' => '其他',
			),
		);
		$validate_card_type_select = $this->FormHandler->Select('validate_card_type',$_options,$member_info['validate_card_type']);

        $log = logic('me')->money()->log($this->ID, '*');
        if(!empty($log) && is_array($log)) {
            foreach($log as $k => $v) {
                $name = $v['name'];
                $intro = $v['intro'];

                if ($name=='zn' || $name =='zz')
        	    {
        	      $zhanzhuanginfo = logic('zhanneilist')->GetOne($v['intro']);
        	      if ($zhanzhuanginfo['money_type']==1){
                        $prefix='USD';
                    }elseif ($zhanzhuanginfo['money_type']==2){
                        $prefix="HKD";
                    }elseif ($zhanzhuanginfo['money_type']==4){
                        $prefix="JPY";
                    }elseif ($zhanzhuanginfo['money_type']==5){
                        $prefix="KRW";
                    }elseif ($zhanzhuanginfo['money_type']==6){
                        $prefix="GBP";
                    }elseif ($zhanzhuanginfo['money_type']==7){
                        $prefix="AUD";
                    }elseif ($zhanzhuanginfo['money_type']==8){
                        $prefix="CAD";
                    }elseif ($zhanzhuanginfo['money_type']==9){
                        $prefix="CHF";
                    }elseif ($zhanzhuanginfo['money_type']==10){
                        $prefix="NZD";
                    }elseif ($zhanzhuanginfo['money_type']==11){
                        $prefix="SGD";
					}elseif ($zhanzhuanginfo['money_type']==12){
                        $prefix="HKC";
					}elseif ($zhanzhuanginfo['money_type']==13){
					  $prefix="BTC";
					}elseif ($zhanzhuanginfo['money_type']==14){
					  $prefix="ETH";
                    }elseif ($zhanzhuanginfo['money_type']==3){
                        $prefix="EUR";
                    }else{
                        $prefix='CNY';
                    }
                  if($name == 'zz') {
	        	  	$zhanzhuanginfo[tousername] = user($zhanzhuanginfo['touid'])->get("name");
					/*
					if($zhanzhuanginfo['is_private'] == 1) {
						
						$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['touid'].'"';
						$q = $this->DatabaseHandler->Query($sql);
						$private = $q->GetRow();
						$topublic = $private['encrypt_public'];
						$b = "<b>收款匿名地址：</b>$topublic";
					} else {
						$b = "<b>收款人：</b>$zhanzhuanginfo[tousername]";
					}
					*/
					  $b = "<b>收款人：</b>$zhanzhuanginfo[tousername]";
					
					
	        	  	 $zhanzhuanginfo['info'] = "
						$b 
                        <br>
						<b>金额：</b>{$prefix}".number_format($zhanzhuanginfo[value], 2, '.', '')."元
						<br>
						<b>付款留言：</b>$zhanzhuanginfo[mark]
						<br>
						<b>手续费率：</b>$zhanzhuanginfo[sxfl]%<br>
						<b>手续费：</b>{$prefix}".number_format(($zhanzhuanginfo[value]-$zhanzhuanginfo[tovalue]), 2, '.', '')."元<br>
						<b>实际到账：</b>{$prefix}".number_format($zhanzhuanginfo[tovalue], 2, '.', '')."元
						";

	        	  }else{
					  
					  
	        	  	$zhanzhuanginfo[sername] = user($zhanzhuanginfo['owner'])->get("name");
	        	  	/*
				  if($zhanzhuanginfo['is_private'] == 1) {
					
						$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['owner'].'"';
						$q = $this->DatabaseHandler->Query($sql);
						$private = $q->GetRow();
						$public = $private['encrypt_public'];
						$b = "<b>付款匿名地址：</b>$public";
					} else {
						$b = "<b>付款人：</b>$zhanzhuanginfo[username]";
					}
	        	  	*/
					  $b = "<b>付款人：</b>$zhanzhuanginfo[username]";
					
	        	  	$zhanzhuanginfo['info'] = "
	        	  	   <b>到账时间：</b>".date("Y-m-d:H:i:s",$zhanzhuanginfo[addtime])."
                       <br>
						$b 
						<br>
						<b>金额：</b>{$prefix}".number_format($zhanzhuanginfo[tovalue], 2, '.', '')."元
						<br>
						<b>付款留言：</b>$zhanzhuanginfo[mark]

						";
	        	  }
	        	$log[$k]['intro'] = $zhanzhuanginfo['info'];
        	}elseif ($name =='cp')
        	{
        		$orderinfo = logic('order')->GetOne($v['intro']);

        		$log[$k]['intro'] = "
	        	  	   <b>到账时间：</b>".date("Y-m-d:H:i:s",$orderinfo[paytime])."
						<b>购买人：</b>".user($orderinfo['userid'])->get('name')."
						<br>
						<b>商品名称：</b>".$orderinfo['product']['name'];
			$log[$k]['name']="卖出商品";
        	}elseif ($name =='djq')
        	{
        		$usermoney[$key]['name']="卖出团购券";
        		$orderinfo = logic('order')->GetOne($v['intro']);

                $log[$k]['intro']= "
	        	  	   <b>到账时间：</b>".date("Y-m-d:H:i:s",$orderinfo[paytime])."
						<b><br>购买人：</b>".user($orderinfo['userid'])->get('name')."
						<br>
						<b>商品名称：</b>".$orderinfo['product']['name']."
						";

        	}elseif ($name =='hkcz')
        	{

        		$usermoney[$key]['name']="汇款充值";
        		$sql = 'select * from ' . TABLE_PREFIX . 'tttuangou_recharge_order where orderid = \'' . $info['intro'] . '\'';
        		$query = $this->DatabaseHandler->Query($sql);
        		$ticket = $query->GetRow();
        		 $log[$k]['intro'] = "
        		  <b>申请时间：</b>".date("Y-m-d H:i",$ticket[createtime])."
        		  <br>
	        	  	   <b>到账时间：</b>".date("Y-m-d H:i",$ticket[paytime])."
						<br>
						<b>订单号：</b>".$ticket[orderid]."
						";
        	}elseif($name == '银行转账') {
                    $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne($v['intro']);
                    if(!empty($zhanzhuanginfo) && is_array($zhanzhuanginfo)) {
                    $log[$k]['intro'] = "
                		  <b>开卡行：</b>". $zhanzhuanginfo['yhkinfo']."<br><b>卡号：</b>". $zhanzhuanginfo['yhkkh']."
                		  <br>
                          <b>开户名：</b>".$zhanzhuanginfo['yhkname']."
                          <br>
                		  <b>金额：</b>￥".number_format($zhanzhuanginfo['value'], 2, '.', '')."元<br/><b>时间：</b>".date('Y-m-d H:i',$zhanzhuanginfo['addtime']).
                          "<br/><b>手续费率：</b>".$zhanzhuanginfo['sxhl'].'%<br/>'."<b>手续费：</b>￥".number_format($zhanzhuanginfo['sxfl'], 2, '.', '').'元<br/>'.
                          "<b>实际到账：</b>￥".number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '').'元<br/>'.
						  "<b>备注：</b>".$zhanzhuanginfo['mark'].
                          "<br/><b>状态：</b>".($zhanzhuanginfo['statue'] == 1? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                   }
                }elseif($name == '国际转账' ||$name == '港币汇款'||$name == '欧元汇款'||$name == '日元汇款'||$name == '韩元汇款'||$name == '英镑汇款'||$name == '澳元汇款'||$name == '加元汇款'||$name == '瑞郎汇款'||$name == '新西兰元汇款'||$name == '新加坡元汇款'||$name == '香港币汇款'||$name == '比特币汇款'||$name == '以太币汇款'||$name == '人民币汇款'||$name == '美元汇款') {
                    $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne2($v['intro']);
                    $yinhangkainfo = logic('yinhangka')->GetOne2($zhanzhuanginfo['yhkid']);

                    if(!empty($zhanzhuanginfo)) {
						if ($zhanzhuanginfo['is_dollar']==1){
						$prefix='USD';
					} elseif ($zhanzhuanginfo['is_hkdollar']==1){
						$prefix='HKD';
					} elseif ($zhanzhuanginfo['is_jpy']==1){
						$prefix='JPY';
					} elseif ($zhanzhuanginfo['is_krw']==1){
						$prefix='KRW';
					} elseif ($zhanzhuanginfo['is_gbp']==1){
						$prefix='GBP';
					} elseif ($zhanzhuanginfo['is_aud']==1){
						$prefix='AUD';
					} elseif ($zhanzhuanginfo['is_cad']==1){
						$prefix='CAD';
					} elseif ($zhanzhuanginfo['is_chf']==1){
						$prefix='CHF';
					} elseif ($zhanzhuanginfo['is_nzd']==1){
						$prefix='NZD';
					} elseif ($zhanzhuanginfo['is_sgd']==1){
						$prefix='SGD';
					} elseif ($zhanzhuanginfo['is_hkc']==1){
						$prefix='HKC';
					} elseif ($zhanzhuanginfo['is_btc']==1){
						$prefix='BTC';
					} elseif ($zhanzhuanginfo['is_eth']==1){
						$prefix='ETH';
					}elseif ($zhanzhuanginfo['is_money']==1){
                        $prefix="CNY";
                    }elseif ($zhanzhuanginfo['is_euro']==1){
                         $prefix="EUR";
                    }else{
                         $prefix="CNY";
                    }

					$log[$k]['intro'] =  "
                    		  <b>收款银行：</b>". $yinhangkainfo['skgj']. $yinhangkainfo['khcity']. $yinhangkainfo['khcc']. "<br><b>收款帐号：</b>". $yinhangkainfo['cardno']."
                    		  <br>
                              <b>收款人姓名：</b>".$yinhangkainfo['name']."
                              <br>
                    		  <b>金额：</b>$prefix".number_format($zhanzhuanginfo['value'], 2, '.', '')."元<br/><b>时间：</b>".date('Y-m-d H:i',$zhanzhuanginfo['addtime']).
                              "<br/><b>手续费率：</b>".($zhanzhuanginfo['is_sxf'] ==1 ? $zhanzhuanginfo['sxhl'] : '0').'%<br/>'."<b>手续费：</b>$prefix".($zhanzhuanginfo['is_sxf'] ==1 ? number_format($zhanzhuanginfo['sxfl'], 2, '.', '') : '0.00').'元<br/>'.
                              "<b>实际到账：</b>$prefix".($zhanzhuanginfo['is_sxf'] ==1 ? number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '') : number_format($zhanzhuanginfo['value'], 2, '.', '')) .'元<br/>'.
                              "<b>收取手续费：</b>".($zhanzhuanginfo['is_sxf'] == 1? '是' : '否').
							  "<br/><b>付款人留言：</b>".$zhanzhuanginfo['message'].
							  "<br/><b>汇款用途：</b>".$zhanzhuanginfo['yongtu'].
							  "<br/><b>备注：</b>".$zhanzhuanginfo['mark'].
                              "<br/><b>状态：</b>".($zhanzhuanginfo['statue'] == 1? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                    }
                }elseif($name == '信用卡还款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne3($v['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne3($zhanzhuanginfo['yhkid']);

                if(!empty($zhanzhuanginfo)) {
                    $log[$k]['intro'] =  "
                		  <b>开卡行：</b>". $yinhangkainfo['kaihuhang']."<br><b>卡号：</b>". $yinhangkainfo['kahao']."
                		  <br>
                          <b>开户名：</b>".$yinhangkainfo['name']."
                          <br>
                		  <b>还款金额：</b>￥".number_format($zhanzhuanginfo['value'], 2,'.', '')."元<br/><b>时间：</b>".date('Y-m-d H:i',$zhanzhuanginfo['addtime']).
                          "<br/><b>手续费率：</b>".$zhanzhuanginfo['sxhl'].'%<br/>'."<b>手续费：</b>￥". number_format($zhanzhuanginfo['sxfl'],2,'.','').'元<br/>'.
                          "<b>实际付款：</b>￥".number_format(($zhanzhuanginfo['value'] + $zhanzhuanginfo['sxfl']),  2, '.', '').'元<br/>'.
					      "<b>备注：</b>".$zhanzhuanginfo['mark'].
                          "<br/><b>状态：</b>".($zhanzhuanginfo['statue'] == 1? '还款中' :($zhanzhuanginfo['statue'] == 3 ? '还款失败' : '还款成功'));
                }
            }
            }
        }
		$money = logic('me')->money()->count($this->ID);
        $money_zaitu = logic('order')->GetFreezeMoney($this->ID, 0);
        $dollar_zaitu = logic('order')->GetFreezeMoney($this->ID, 1);
		
		
		$sql = "select sum(lcb_money) as num from ".TABLE_PREFIX."system_members;";
		$query = $this->DatabaseHandler->Query($sql);
		$row = $query->GetRow();
		
		$lcb_dcep_total = $row['num'];
		
		$sql = "select sum(lcb_hkc_money) as num from ".TABLE_PREFIX."system_members;";
		$query = $this->DatabaseHandler->Query($sql);
		$row = $query->GetRow();
		
		$lcb_hkc_total = $row['num'];
		
		include handler('template')->file('@admin/member_info');
	}



	function DoDelete()
	{
		$this->IDS = (array) ($this->IDS ? $this->IDS : $this->ID);
		foreach ($this->IDS as $key=>$val) {
			if(1 > ($this->IDS[$key] = (int) $val)) {
				unset($this->IDS[$key]);
			}
		}
		if (!$this->IDS) {
			$this->Messager("请先指定一个要删除的用户ID",null);
		}
		$query = $this->DatabaseHandler->Query("select * from ".TABLE_PREFIX."system_members where `uid` in('".implode("','",$this->IDS)."')");

		$member_ids = array();
		$admin_list = array();
		$member_ids_count = 0;
		while ($row = $query->GetRow())
		{
			if(1==$row['uid'] || $row['role_type']=='admin') {
				$admin_list[$row['uid']] = $row['username'];
				continue;
			}

						if(true === UCENTER && $row['ucuid'] > 0) {
				include_once(UC_CLIENT_ROOT . './client.php');

				uc_user_delete($row['ucuid']);
			}
			$member_ids[$row['uid']] = $row['uid'];
		}
		if(isset($member_ids[1])) unset($member_ids[1]);

		if (0 < ($member_ids_count =  count($member_ids))) {
						$this->DatabaseHandler->Query("delete from `".TABLE_PREFIX."system_members` where `uid` in ('".implode("','",$member_ids)."')");
						$this->DatabaseHandler->Query("delete from `".TABLE_PREFIX."system_memberfields` where `uid` in('".implode("','",$member_ids)."')");
						$this->DatabaseHandler->Query("delete from `".TABLE_PREFIX."system_log` where `uid` in('".implode("','",$member_ids)."')");
						foreach ($member_ids as $i => $uid)
			{
				$aliuid = meta('luid_'.$uid);
				meta('luid_'.$uid, null);
				meta('token_'.$aliuid, null);
				meta('ul.alipay.'.$aliuid, null);
			}
		}

		$msg = '';
		$msg .= "成功删除<b>{$member_ids_count}</b>位会员";
		if($admin_list) {
			$msg .= "，其中<b>".implode(' , ',$admin_list)."</b>是管理员，不能直接删除";
		}
		$this->Messager($msg);
	}


	function Modify_nm()
	{
		$this->Title="编辑用户";
		$action="admin.php?mod=member&code=domodify";
		
		/*
				$sql="
		 SELECT
			 *
		 FROM
			 ".TABLE_PREFIX.'system_members'." M LEFT JOIN ".TABLE_PREFIX.'system_memberfields'." MF ON(M.uid=MF.uid)
		 WHERE
			 M.uid={$this->ID}";
		*/
		
		$sql="
		 SELECT
			 *
		 FROM
			 cenwor_tttuangou_user_private_key
		 WHERE
			 id={$this->ID}";
			 

		$query = $this->DatabaseHandler->Query($sql);
		$uid=$this->ID;
		$member_info=$query->GetRow();
		$hkdollar_zaitu=logic('order')->GetFreezeMoney($uid, 2);
		$euro_zaitu=logic('order')->GetFreezeMoney($uid, 3);
		$jpy_zaitu=logic('order')->GetFreezeMoney($uid, 4);
		$krw_zaitu=logic('order')->GetFreezeMoney($uid, 5);
		$gbp_zaitu=logic('order')->GetFreezeMoney($uid, 6);
		$aud_zaitu=logic('order')->GetFreezeMoney($uid, 7);
		$cad_zaitu=logic('order')->GetFreezeMoney($uid, 8);
		$chf_zaitu=logic('order')->GetFreezeMoney($uid, 9);
		$nzd_zaitu=logic('order')->GetFreezeMoney($uid, 10);
		$sgd_zaitu=logic('order')->GetFreezeMoney($uid, 11);
		$hkc_zaitu=logic('order')->GetFreezeMoney($uid, 12);
		$money_zaitu=logic('order')->GetFreezeMoney($uid, 13);
		$btc_zaitu=logic('order')->GetFreezeMoney($uid, 14);
		$eth_zaitu=logic('order')->GetFreezeMoney($uid, 15);
		if($member_info==false)
		{
			$this->Messager("用户已经不存在");
		}
		//var_dump($member_info)；die;
		extract($member_info);

		 $yzinfo = logic('yanzheng')->GetOne($uid);
		//$username = $yzinfo['idname'];

		/*
				$sql = "
		 SELECT
			 id,name
		 FROM
			 " . TABLE_PREFIX.'system_role' . "
		 WHERE
			 id!=1";
		$query = $this->DatabaseHandler->Query($sql);
		while($row = $query->GetRow())
		{
			$role_list[$row['id']] = array('name' => $row['name'], 'value' => $row['id']);
		}

				foreach($this->Config as $field => $name)
		{
			if(strpos($field, 'credits') !== false)
			{
				if($name != '')
				{
					$credit_list[$field] = $name;
				}
			}
		}

		$role_select = $this->FormHandler->Select('role_id', $role_list,$role_id);
		$role_name = $role_list[$role_id]['name'];
		
		*/
		$gender_radio=$this->FormHandler->Radio('gender',array(
		array('name'=>"男",'value'=>'1'),
		array('name'=>"女",'value'=>'2'),
		array('name'=>"保密",'value'=>'0'),
		),$gender);
		
		list($year,$month,$day)=explode('-',$bday);
		$year_select=$this->FormHandler->NumSelect('year','1920','2006',$year!='0000'?$year:1980);
		$month_select=$this->FormHandler->NumSelect('month','1','12',$month);
		$day_select=$this->FormHandler->NumSelect('day','1','31',$day);
		$validate_radio = $this->FormHandler->YesNoRadio('validate',$member_info['validate']);
		$_options = array(
			'0' => array(
				'name' => '请选择',
				'value' => '0',
			),
			'身份证' => array(
				'name' => '身份证',
				'value' => '身份证',
			),
			'学生证' => array(
				'name' => '学生证',
				'value' => '学生证',
			),
			'军官证' => array(
				'name' => '军官证',
				'value' => '军官证',
			),
			'护照' => array(
				'name' => '护照',
				'value' => '护照',
			),
			'其他' => array(
				'name' => '其他',
				'value' => '其他',
			),
		);
		$validate_card_type_select = $this->FormHandler->Select('validate_card_type',$_options,$member_info['validate_card_type']);

        $log = logic('me')->money()->log($this->ID, '*');
        if(!empty($log) && is_array($log)) {
            foreach($log as $k => $v) {
                $name = $v['name'];
                $intro = $v['intro'];

                if ($name=='zn' || $name =='zz')
        	    {
        	      $zhanzhuanginfo = logic('zhanneilist')->GetOne($v['intro']);
        	      if ($zhanzhuanginfo['money_type']==1){
                        $prefix='USD';
                    }elseif ($zhanzhuanginfo['money_type']==2){
                        $prefix="HKD";
                    }elseif ($zhanzhuanginfo['money_type']==4){
                        $prefix="JPY";
                    }elseif ($zhanzhuanginfo['money_type']==5){
                        $prefix="KRW";
                    }elseif ($zhanzhuanginfo['money_type']==6){
                        $prefix="GBP";
                    }elseif ($zhanzhuanginfo['money_type']==7){
                        $prefix="AUD";
                    }elseif ($zhanzhuanginfo['money_type']==8){
                        $prefix="CAD";
                    }elseif ($zhanzhuanginfo['money_type']==9){
                        $prefix="CHF";
                    }elseif ($zhanzhuanginfo['money_type']==10){
                        $prefix="NZD";
                    }elseif ($zhanzhuanginfo['money_type']==11){
                        $prefix="SGD";
					}elseif ($zhanzhuanginfo['money_type']==12){
                        $prefix="HKC";
					}elseif ($zhanzhuanginfo['money_type']==13){
                        $prefix="CNY";
					}elseif ($zhanzhuanginfo['money_type']==14){
                        $prefix="BTC";
					}elseif ($zhanzhuanginfo['money_type']==15){
                        $prefix="ETH";
                    }elseif ($zhanzhuanginfo['money_type']==3){
                        $prefix="EUR";
                    }else{
                        $prefix='CNY';
                    }
                  if($name == 'zz') {
	        	  	$zhanzhuanginfo[tousername] = user($zhanzhuanginfo['touid'])->get("name");

	        	  	/*
					if($zhanzhuanginfo['is_private'] == 1) {
						
						$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['touid'].'"';
						$q = $this->DatabaseHandler->Query($sql);
						$private = $q->GetRow();
						$topublic = $private['encrypt_public'];
						$b = "<b>收款匿名地址：</b>$topublic";
					} else {
						$b = "<b>收款人：</b>$zhanzhuanginfo[tousername]";
					}
	        	  	*/
					  $b = "<b>收款人：</b>$zhanzhuanginfo[tousername]";
					
					
	        	  	 $zhanzhuanginfo['info'] = "
						$b 
                        <br>
						<b>金额：</b>{$prefix}".number_format($zhanzhuanginfo[value], 2, '.', '')."元
						<br>
						<b>付款留言：</b>$zhanzhuanginfo[mark]
						<br>
						<b>手续费率：</b>$zhanzhuanginfo[sxfl]%<br>
						<b>手续费：</b>{$prefix}".number_format(($zhanzhuanginfo[value]-$zhanzhuanginfo[tovalue]), 2, '.', '')."元<br>
						<b>实际到账：</b>{$prefix}".number_format($zhanzhuanginfo[tovalue], 2, '.', '')."元
						";

	        	  }else{
					  
					  
	        	  	$zhanzhuanginfo[sername] = user($zhanzhuanginfo['owner'])->get("name");

	        	  	/*
				  if($zhanzhuanginfo['is_private'] == 1) {
					
						$sql = 'select * from cenwor_tttuangou_user_private_key where uid = "' . $zhanzhuanginfo['owner'].'"';
						$q = $this->DatabaseHandler->Query($sql);
						$private = $q->GetRow();
						$public = $private['encrypt_public'];
						$b = "<b>付款匿名地址：</b>$public";
					} else {
						$b = "<b>付款人：</b>$zhanzhuanginfo[username]";
					}
	        	  	*/
					  $b = "<b>付款人：</b>$zhanzhuanginfo[username]";
					
	        	  	$zhanzhuanginfo['info'] = "
	        	  	   <b>到账时间：</b>".date("Y-m-d:H:i:s",$zhanzhuanginfo[addtime])."
                       <br>
						$b 
						<br>
						<b>金额：</b>{$prefix}".number_format($zhanzhuanginfo[tovalue], 2, '.', '')."元
						<br>
						<b>付款留言：</b>$zhanzhuanginfo[mark]

						";
	        	  }
	        	$log[$k]['intro'] = $zhanzhuanginfo['info'];
        	}elseif ($name =='cp')
        	{
        		$orderinfo = logic('order')->GetOne($v['intro']);

        		$log[$k]['intro'] = "
	        	  	   <b>到账时间：</b>".date("Y-m-d:H:i:s",$orderinfo[paytime])."
						<b>购买人：</b>".user($orderinfo['userid'])->get('name')."
						<br>
						<b>商品名称：</b>".$orderinfo['product']['name'];
			$log[$k]['name']="卖出商品";
        	}elseif ($name =='djq')
        	{
        		$usermoney[$key]['name']="卖出团购券";
        		$orderinfo = logic('order')->GetOne($v['intro']);

                $log[$k]['intro']= "
	        	  	   <b>到账时间：</b>".date("Y-m-d:H:i:s",$orderinfo[paytime])."
						<b><br>购买人：</b>".user($orderinfo['userid'])->get('name')."
						<br>
						<b>商品名称：</b>".$orderinfo['product']['name']."
						";

        	}elseif ($name =='hkcz')
        	{

        		$usermoney[$key]['name']="汇款充值";
        		$sql = 'select * from ' . TABLE_PREFIX . 'tttuangou_recharge_order where orderid = \'' . $info['intro'] . '\'';
        		$query = $this->DatabaseHandler->Query($sql);
        		$ticket = $query->GetRow();
        		 $log[$k]['intro'] = "
        		  <b>申请时间：</b>".date("Y-m-d H:i",$ticket[createtime])."
        		  <br>
	        	  	   <b>到账时间：</b>".date("Y-m-d H:i",$ticket[paytime])."
						<br>
						<b>订单号：</b>".$ticket[orderid]."
						";
        	}elseif($name == '银行转账') {
                    $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne($v['intro']);
                    if(!empty($zhanzhuanginfo) && is_array($zhanzhuanginfo)) {
                    $log[$k]['intro'] = "
                		  <b>开卡行：</b>". $zhanzhuanginfo['yhkinfo']."<br><b>卡号：</b>". $zhanzhuanginfo['yhkkh']."
                		  <br>
                          <b>开户名：</b>".$zhanzhuanginfo['yhkname']."
                          <br>
                		  <b>金额：</b>￥".number_format($zhanzhuanginfo['value'], 2, '.', '')."元<br/><b>时间：</b>".date('Y-m-d H:i',$zhanzhuanginfo['addtime']).
                          "<br/><b>手续费率：</b>".$zhanzhuanginfo['sxhl'].'%<br/>'."<b>手续费：</b>￥".number_format($zhanzhuanginfo['sxfl'], 2, '.', '').'元<br/>'.
                          "<b>实际到账：</b>￥".number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '').'元<br/>'.
						  "<b>备注：</b>".$zhanzhuanginfo['mark'].
                          "<br/><b>状态：</b>".($zhanzhuanginfo['statue'] == 1? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                   }
                }elseif($name == '国际转账' ||$name == '港币汇款'||$name == '欧元汇款'||$name == '日元汇款'||$name == '韩元汇款'||$name == '英镑汇款'||$name == '澳元汇款'||$name == '加元汇款'||$name == '瑞郎汇款'||$name == '新西兰元汇款'||$name == '新加坡元汇款'||$name == '香港币汇款'||$name == '比特币汇款'||$name == '以太币汇款'||$name == '人民币汇款'||$name == '美元汇款') {
                    $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne2($v['intro']);
                    $yinhangkainfo = logic('yinhangka')->GetOne2($zhanzhuanginfo['yhkid']);

                    if(!empty($zhanzhuanginfo)) {
						if ($zhanzhuanginfo['is_dollar']==1){
						$prefix='USD';
					} elseif ($zhanzhuanginfo['is_hkdollar']==1){
						$prefix='HKD';
					} elseif ($zhanzhuanginfo['is_jpy']==1){
						$prefix='JPY';
					} elseif ($zhanzhuanginfo['is_krw']==1){
						$prefix='KRW';
					} elseif ($zhanzhuanginfo['is_gbp']==1){
						$prefix='GBP';
					} elseif ($zhanzhuanginfo['is_aud']==1){
						$prefix='AUD';
					} elseif ($zhanzhuanginfo['is_cad']==1){
						$prefix='CAD';
					} elseif ($zhanzhuanginfo['is_chf']==1){
						$prefix='CHF';
					} elseif ($zhanzhuanginfo['is_nzd']==1){
						$prefix='NZD';
					} elseif ($zhanzhuanginfo['is_sgd']==1){
						$prefix='SGD';
					} elseif ($zhanzhuanginfo['is_hkc']==1){
						$prefix='HKC';
					} elseif ($zhanzhuanginfo['is_btc']==1){
						$prefix='BTC';
					} elseif ($zhanzhuanginfo['is_eth']==1){
						$prefix='ETH';
					}elseif ($zhanzhuanginfo['is_money']==1){
                        $prefix="CNY";
                    }elseif ($zhanzhuanginfo['is_euro']==1){
                         $prefix="EUR";
                    }else{
                         $prefix="CNY";
                    }

					$log[$k]['intro'] =  "
                    		  <b>收款银行：</b>". $yinhangkainfo['skgj']. $yinhangkainfo['khcity']. $yinhangkainfo['khcc']. "<br><b>收款帐号：</b>". $yinhangkainfo['cardno']."
                    		  <br>
                              <b>收款人姓名：</b>".$yinhangkainfo['name']."
                              <br>
                    		  <b>金额：</b>$prefix".number_format($zhanzhuanginfo['value'], 2, '.', '')."元<br/><b>时间：</b>".date('Y-m-d H:i',$zhanzhuanginfo['addtime']).
                              "<br/><b>手续费率：</b>".($zhanzhuanginfo['is_sxf'] ==1 ? $zhanzhuanginfo['sxhl'] : '0').'%<br/>'."<b>手续费：</b>$prefix".($zhanzhuanginfo['is_sxf'] ==1 ? number_format($zhanzhuanginfo['sxfl'], 2, '.', '') : '0.00').'元<br/>'.
                              "<b>实际到账：</b>$prefix".($zhanzhuanginfo['is_sxf'] ==1 ? number_format(($zhanzhuanginfo['value'] - $zhanzhuanginfo['sxfl']), 2, '.', '') : number_format($zhanzhuanginfo['value'], 2, '.', '')) .'元<br/>'.
                              "<b>收取手续费：</b>".($zhanzhuanginfo['is_sxf'] == 1? '是' : '否').
							  "<br/><b>付款人留言：</b>".$zhanzhuanginfo['message'].
							  "<br/><b>汇款用途：</b>".$zhanzhuanginfo['yongtu'].
							  "<br/><b>备注：</b>".$zhanzhuanginfo['mark'].
                              "<br/><b>状态：</b>".($zhanzhuanginfo['statue'] == 1? '转账中' : ($zhanzhuanginfo['statue'] == 3 ? '转账失败' : '转账成功'));
                    }
                }elseif($name == '信用卡还款') {

                $zhanzhuanginfo = logic('zhuanzhanglist')->GetOne3($v['intro']);
                $yinhangkainfo = logic('yinhangka')->GetOne3($zhanzhuanginfo['yhkid']);

                if(!empty($zhanzhuanginfo)) {
                    $log[$k]['intro'] =  "
                		  <b>开卡行：</b>". $yinhangkainfo['kaihuhang']."<br><b>卡号：</b>". $yinhangkainfo['kahao']."
                		  <br>
                          <b>开户名：</b>".$yinhangkainfo['name']."
                          <br>
                		  <b>还款金额：</b>￥".number_format($zhanzhuanginfo['value'], 2,'.', '')."元<br/><b>时间：</b>".date('Y-m-d H:i',$zhanzhuanginfo['addtime']).
                          "<br/><b>手续费率：</b>".$zhanzhuanginfo['sxhl'].'%<br/>'."<b>手续费：</b>￥". number_format($zhanzhuanginfo['sxfl'],2,'.','').'元<br/>'.
                          "<b>实际付款：</b>￥".number_format(($zhanzhuanginfo['value'] + $zhanzhuanginfo['sxfl']),  2, '.', '').'元<br/>'.
					      "<b>备注：</b>".$zhanzhuanginfo['mark'].
                          "<br/><b>状态：</b>".($zhanzhuanginfo['statue'] == 1? '还款中' :($zhanzhuanginfo['statue'] == 3 ? '还款失败' : '还款成功'));
                }
            }
            }
        }
		$money = logic('me')->money()->count($this->ID);
        $money_zaitu = logic('order')->GetFreezeMoney($this->ID, 0);
        $dollar_zaitu = logic('order')->GetFreezeMoney($this->ID, 1);
		
		
		$sql = "select sum(lcb_money) as num from ".TABLE_PREFIX."system_members;";
		$query = $this->DatabaseHandler->Query($sql);
		$row = $query->GetRow();
		
		$lcb_dcep_total = $row['num'];
		
		$sql = "select sum(lcb_hkc_money) as num from ".TABLE_PREFIX."system_members;";
		$query = $this->DatabaseHandler->Query($sql);
		$row = $query->GetRow();
		
		$lcb_hkc_total = $row['num'];
		
		include handler('template')->file('@admin/member_nm_info');
	}


	function DoModify()
	{
		extract($this->Post);
		if($password=='')
		{
			unset($this->Post['password']);
		}
		else
		{
			$this->Post['password']=md5($password);
		}

		$this->DatabaseHandler->SetTable(TABLE_PREFIX.'system_members');
		if($old_username!=$username)
		{
			$is_exists=$this->DatabaseHandler->Select('',"username='$username'");
			if($is_exists)
			{
				$this->Messager("{$username}已经存在");
			}
		}
        $yanzhengpost = array();
        if($brate !==''){
            $yanzhengpost['brate'] = $brate;

        }
        if($wrate !==''){
            $yanzhengpost['wrate'] = $wrate;
        }

        if($gjrate !== '') {
            $yanzhengpost['gjrate'] = $gjrate;
        }
		if($paypal_rate !== '') {
            $yanzhengpost['paypal_rate'] = $paypal_rate;
        }
		if($dollar_rate !== '') {
            $yanzhengpost['dollar_rate'] = $dollar_rate;
        }
		if($hkdollar_rate !== '') {
            $yanzhengpost['hkdollar_rate'] = $hkdollar_rate;
        }
		if($euro_rate !== '') {
            $yanzhengpost['euro_rate'] = $euro_rate;
        }
		if($jpy_rate !== '') {
            $yanzhengpost['jpy_rate'] = $jpy_rate;
        }
		if($krw_rate !== '') {
            $yanzhengpost['krw_rate'] = $krw_rate;
        }
		if($gbp_rate !== '') {
            $yanzhengpost['gbp_rate'] = $gbp_rate;
        }
		if($aud_rate !== '') {
            $yanzhengpost['aud_rate'] = $aud_rate;
        }
		if($cad_rate !== '') {
            $yanzhengpost['cad_rate'] = $cad_rate;
        }
		if($chf_rate !== '') {
            $yanzhengpost['chf_rate'] = $chf_rate;
        }
		if($nzd_rate !== '') {
            $yanzhengpost['nzd_rate'] = $nzd_rate;
        }
		if($sgd_rate !== '') {
            $yanzhengpost['sgd_rate'] = $sgd_rate;
        }
		if($hkc_rate !== '') {
            $yanzhengpost['hkc_rate'] = $hkc_rate;
        }
		if($btc_rate !== '') {
            $yanzhengpost['btc_rate'] = $btc_rate;
        }
		if($eth_rate !== '') {
            $yanzhengpost['eth_rate'] = $eth_rate;
        }
		if($money_rate !== '') {
            $yanzhengpost['money_rate'] = $money_rate;
        }
        if($xyk_rate !== '') {
            $yanzhengpost['xyk_rate'] = $xyk_rate;
        }




		if(empty($yzid)) {
			logic('yanzheng')->Update($yzid, $yanzhengpost);



		}



        if(!empty($yanzhengpost)) {
            logic('yanzheng')->Update($yzid, $yanzhengpost);
        }

		if ($moneyMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($moneyOps == 'plus')
			{
								logic('me')->money()->add($moneyMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的人民币余额，详情请联系！'
				));
			}
			elseif ($moneyOps == 'less')
			{

			        $current_money = logic('me')->money()->count($uid);
			        if(empty($current_money) || $current_money == 0.00 || $current_money < $moneyMoved) {
			            $this->Messager("人民币余额不足，扣费失败！");
			        }else{
								logic('me')->money()->less($moneyMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的人民币余额，详情请联系！'
				));

			        }
			}
		}

        if ($dollarMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($dollarOps == 'plus')
			{
								logic('me')->money()->add($dollarMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的美元余额，详情请联系！',
                    'is_dollar' => 1
				), 1);
			}
			elseif ($dollarOps == 'less')
			{
			    $current_money = logic('me')->money()->count_dollar($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("美元余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($dollarMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的美元余额，详情请联系！',
                    'is_dollar' => 1
				), 1);
			    }
			}
		}
		if ($hkdollarMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($hkdollarOps == 'plus')
			{
								logic('me')->money()->add($hkdollarMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的港币余额，详情请联系！',
                    'is_hkdollar' => 1
				), 2);
			}
			elseif ($hkdollarOps == 'less')
			{
			    $current_money = logic('me')->money()->count_hkdollar($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("港币余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($hkdollarMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的港币余额，详情请联系！',
                    'is_hkdollar' => 1
				),2);
			    }
			}
		}
		if ($euroMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($euroOps == 'plus')
			{
								logic('me')->money()->add($euroMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的欧元余额，详情请联系！',
                    'is_euro' => 1
				), 3);
			}
			elseif ($euro= 'less')
			{
			    $current_money = logic('me')->money()->count_euro($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("欧元余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($euroMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的欧元余额，详情请联系！',
                    'is_euro' => 1
				), 3);
			    }
			}
		}
        if ($jpyMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($jpyOps == 'plus')
			{
								logic('me')->money()->add($jpyMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的日元余额，详情请联系！',
                    'is_jpy' => 1
				), 4);
			}
			elseif ($jpy= 'less')
			{
			    $current_money = logic('me')->money()->count_jpy($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("日元余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($jpyMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的日元余额，详情请联系！',
                    'is_jpy' => 1
				), 4);
			    }
			}
		}
		if ($krwMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($krwOps == 'plus')
			{
								logic('me')->money()->add($krwMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的韩元余额，详情请联系！',
                    'is_krw' => 1
				), 5);
			}
			elseif ($krw= 'less')
			{
			    $current_money = logic('me')->money()->count_krw($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("韩元余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($krwMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的韩元余额，详情请联系！',
                    'is_krw' => 1
				), 5);
			    }
			}
		}
		if ($gbpMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($gbpOps == 'plus')
			{
								logic('me')->money()->add($gbpMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的英镑余额，详情请联系！',
                    'is_gbp' => 1
				), 6);
			}
			elseif ($gbp= 'less')
			{
			    $current_money = logic('me')->money()->count_gbp($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("英镑余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($gbpMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的英镑余额，详情请联系！',
                    'is_gbp' => 1
				), 6);
			    }
			}
		}
		if ($audMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($audOps == 'plus')
			{
								logic('me')->money()->add($audMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的澳元余额，详情请联系！',
                    'is_aud' => 1
				), 7);
			}
			elseif ($aud= 'less')
			{
			    $current_money = logic('me')->money()->count_aud($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("澳元余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($audMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的澳元余额，详情请联系！',
                    'is_aud' => 1
				), 7);
			    }
			}
		}
		if ($cadMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($cadOps == 'plus')
			{
								logic('me')->money()->add($cadMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的加元余额，详情请联系！',
                    'is_cad' => 1
				), 8);
			}
			elseif ($cad= 'less')
			{
			    $current_money = logic('me')->money()->count_cad($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("加元余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($cadMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的加元余额，详情请联系！',
                    'is_cad' => 1
				), 8);
			    }
			}
		}
		if ($chfMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($chfOps == 'plus')
			{
								logic('me')->money()->add($chfMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的瑞郎余额，详情请联系！',
                    'is_chf' => 1
				), 9);
			}
			elseif ($chf= 'less')
			{
			    $current_money = logic('me')->money()->count_chf($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("瑞郎余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($chfMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的瑞郎余额，详情请联系！',
                    'is_chf' => 1
				), 9);
			    }
			}
		}
		if ($nzdMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($nzdOps == 'plus')
			{
								logic('me')->money()->add($nzdMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的新西兰元余额，详情请联系！',
                    'is_nzd' => 1
				), 10);
			}
			elseif ($nzd= 'less')
			{
			    $current_money = logic('me')->money()->count_nzd($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("新西兰元余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($nzdMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的新西兰元余额，详情请联系！',
                    'is_nzd' => 1
				), 10);
			    }
			}
		}
		if ($sgdMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($sgdOps == 'plus')
			{
								logic('me')->money()->add($sgdMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的新加坡元余额，详情请联系！',
                    'is_sgd' => 1
				), 11);
			}
			elseif ($sgd= 'less')
			{
			    $current_money = logic('me')->money()->count_sgd($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("新加坡元余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($sgdMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的新加坡元余额，详情请联系！',
                    'is_sgd' => 1
				), 11);
			    }
			}
		}
		if ($hkcMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($hkcOps == 'plus')
			{
								logic('me')->money()->add($hkcMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的香港币余额，详情请联系！',
                    'is_hkc' => 1
				), 12);
			}
			elseif ($hkc= 'less')
			{
			    $current_money = logic('me')->money()->count_hkc($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("香港币余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($hkcMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的香港币余额，详情请联系！',
                    'is_hkc' => 1
				), 12);
			    }
			}
		}
		if ($btcMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($btcOps == 'plus')
			{
								logic('me')->money()->add($btcMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的比特币余额，详情请联系！',
                    'is_btc' => 1
				), 13);
			}
			elseif ($btc= 'less')
			{
			    $current_money = logic('me')->money()->count_btc($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("比特币余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($btcMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的比特币余额，详情请联系！',
                    'is_btc' => 1
				), 13);
			    }
			}
		}
		if ($ethMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($ethOps == 'plus')
			{
								logic('me')->money()->add($ethMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的以太币余额，详情请联系！',
                    'is_eth' => 1
				), 14);
			}
			elseif ($eth= 'less')
			{
			    $current_money = logic('me')->money()->count_eth($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("以太币余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($ethMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的以太币余额，详情请联系！',
                    'is_eth' => 1
				), 14);
			    }
			}
		}

		/*
		if ($moneyMoved != '')
		{
						Load::logic('me');
			$this->MeLogic = new MeLogic();

			if ($moneyOps == 'plus')
			{
								logic('me')->money()->add($moneyMoved, $uid, array(
					'name' => '后台编辑(增加)',
					'intro' => '管理员（'.MEMBER_NAME.'）增加了您的人民币余额，详情请联系！',
                    'is_money' => 1
				), 13);
			}
			elseif ($money= 'less')
			{
			    $current_money = logic('me')->money()->count_money($uid);
			    if(empty($current_money) || $current_money == 0.00 || $current_money < $dollarMoved) {
			        $this->Messager("人民币余额不足，扣费失败！");
			    }else{
								logic('me')->money()->less($moneyMoved, $uid, array(
					'name' => '后台编辑(减少)',
					'intro' => '管理员（'.MEMBER_NAME.'）减少了您的人民币余额，详情请联系！',
                    'is_money' => 1
				), 13);
			    }
			}
		}
		*/
		if ((int)$this->Post['role_id']!=0)
		{
			$this->DatabaseHandler->SetTable(TABLE_PREFIX.'system_role');
			$role=$this->DatabaseHandler->Select((int)$this->Post['role_id']);
			if($role!=false)
			{
				zlog('admin')->roleChange($this->Post['uid'], $role);
				$this->Post['role_type']=$role['type'];
			}
			else {
				$this->messager("角色已经不存在");
			}
		}
		elseif($this->ID > 1)
		{
			$this->messager("角色必须选择");
		}
		if (1==$this->ID) {
			unset($this->Post['role_id']);
			$this->Post['role_type'] = 'admin';
		}

		$this->Post['bday']=$year.'-'.$month.'-'.$day;
		$this->DatabaseHandler->SetTable(TABLE_PREFIX.'system_members');
		$table1=$this->DatabaseHandler->Update($this->Post);


		$this->DatabaseHandler->SetTable(TABLE_PREFIX.'system_memberfields');
		$table2=$this->DatabaseHandler->Replace($this->Post);

		if($table1 !==false)
		{
			$this->Messager("编辑成功");
		}
		else
		{
			$this->Messager("编辑失败");
		}
	}

	function build_yhkdetall($yinhangka) {
		$htm = "收款人名称：".$yinhangka['name'].
						"&#10;收款人账号：".$yinhangka['cardno'].
						'&#10;收款行Swiftcode/BIC：'.$yinhangka['bic'].
						'&#10;收款国家/地区：'.$yinhangka['skgj'].
						'&#10;收款人开户银行所在城市：'.$yinhangka['khcity'].
						'&#10;收款人开户银行地址：'.$yinhangka['khdetall'].
						'&#10;收款人开户银行全称：'.$yinhangka['khcc'].
						'&#10;收款人地址：'.$yinhangka['jiedao'].' '.$yinhangka['city'].' '.$yinhangka['zipcode'];

		return $htm;
	}

    function uschongzhi()
	{
		extract($this->Get);
		$where = "  where 1 and payment=5 and statue in(1,2)";
		$show = (int)$_GET['show'];
        $ttype='美元支付';
		$ttypepay='贝宝支付';
		$ttypepay2='港币汇款';
		$ttypepay3='欧元汇款';
		$ttypepay5='日元汇款';
		$ttypepay6='韩元汇款';
		$ttypepay7='英镑汇款';
		$ttypepay8='澳元汇款';
		$ttypepay9='加元汇款';
		$ttypepay10='瑞郎汇款';
		$ttypepay11='新西兰元汇款';
		$ttypepay12='新加坡元汇款';
        $ttypepay13='香港币汇款';
		$ttypepay14='人民币汇款';
		$ttypepay15='比特币汇款';
		$ttypepay16='以太币汇款';
		if($show ==1)
		{
			$where.=" and statue =1 ";
		}elseif($show ==2)
		{
			$where.=" and statue =2 ";
		}


        $where .=" and (tongdao = '".$ttype."' or tongdao = '".$ttypepay."'  or tongdao = '".$ttypepay2."'  or tongdao = '".$ttypepay3."' or tongdao = '".$ttypepay5."' or tongdao = '".$ttypepay6."' or tongdao = '".$ttypepay7."' or tongdao = '".$ttypepay8."' or tongdao = '".$ttypepay9."' or tongdao = '".$ttypepay10."' or tongdao = '".$ttypepay11."' or tongdao = '".$ttypepay12."' or tongdao = '".$ttypepay13."' or tongdao = '".$ttypepay14."' or tongdao = '".$ttypepay15."' or tongdao = '".$ttypepay16."'
        			or tongdao = 'wap美元支付' or tongdao = 'wap贝宝支付' or tongdao = 'wap欧元汇款' or tongdao = 'wap港币汇款' or tongdao = 'wap日元汇款' or tongdao = 'wap韩元汇款' or tongdao = 'wap英镑汇款' or tongdao = 'wap澳元汇款' or tongdao = 'wap加元汇款' or tongdao = 'wap瑞郎汇款' or tongdao = 'wap新西兰元汇款' or tongdao = 'wap新加坡元汇款' or tongdao = 'wap香港币汇款' or tongdao = 'wap比特币汇款' or tongdao = 'wap以太币汇款' or tongdao = 'wap人民币汇款')";


			$sql = "
		  SELECT
			 count(1) total
		  FROM
			  " . TABLE_PREFIX.'tttuangou_recharge_order' . "
		  $where";
		$query = $this->DatabaseHandler->Query($sql);
		extract($query->GetRow());

		$page_num=20;
		$p=max($p,1);
		$offset=($p-1)*$page_num;
		$pages=page($total,$page_num,'',array('var'=>'p'));
		$sql = "
		  SELECT
			  *
		  FROM
			  " . TABLE_PREFIX.'tttuangou_recharge_order' . "
		  $where
		  order by createtime desc LIMIT $offset,$page_num";
		$query = $this->DatabaseHandler->Query($sql);

	while($row = $query->GetRow())
		{
			$row['username'] = user($row['userid'])->get("name");
			$row['uid'] = user($row['userid'])->get("id");
			$yanzheng = logic('yanzheng')->GetOne($row['userid']);
			$row['money'] = number_format($row['money'], 2, '.', '');
            $row['yanzheng'] = $yanzheng;
			if($row['statue'] == 2){
				$row['sjje'] = !empty($row['sjje']) ? $row['sjje'] : $row['money'];
				$row['rate'] = $row['sxfl'];
				$row['sxf'] = $row['sxf'];
			}else{
				$row['sjje'] = $row['money'];
				$row['rate']=$yanzheng['paypal_rate'];
				if ($row['tongdao'] == '美元支付' ||$row['tongdao'] == 'wap美元支付')
				  $row['rate']=$yanzheng['dollar_rate'];
				if ($row['tongdao'] == '港币汇款' || $row['tongdao'] == 'wap港币汇款')
				  $row['rate']=$yanzheng['hkdollar_rate'];
				if ($row['tongdao'] == '欧元汇款' ||$row['tongdao'] == 'wap欧元汇款' )
				  $row['rate']=$yanzheng['euro_rate'];
				if ($row['tongdao'] == '日元汇款' || $row['tongdao'] == 'wap日元汇款')
				  $row['rate']=$yanzheng['jpy_rate'];
				if ($row['tongdao'] == '韩元汇款' || $row['tongdao'] == 'wap韩元汇款')
				  $row['rate']=$yanzheng['krw_rate'];
				if ($row['tongdao'] == '英镑汇款' || $row['tongdao'] == 'wap英镑汇款')
				  $row['rate']=$yanzheng['gbp_rate'];
				if ($row['tongdao'] == '澳元汇款' || $row['tongdao'] == 'wap澳元汇款')
				  $row['rate']=$yanzheng['aud_rate'];
				if ($row['tongdao'] == '加元汇款' || $row['tongdao'] == 'wap加元汇款')
				  $row['rate']=$yanzheng['cad_rate'];
				if ($row['tongdao'] == '瑞郎汇款' || $row['tongdao'] == 'wap瑞郎汇款')
				  $row['rate']=$yanzheng['chf_rate'];
				if ($row['tongdao'] == '新西兰元汇款' || $row['tongdao'] == 'wap新西兰元汇款')
				  $row['rate']=$yanzheng['nzd_rate'];
				if ($row['tongdao'] == '新加坡元汇款' || $row['tongdao'] == 'wap新加坡元汇款')
				  $row['rate']=$yanzheng['sgd_rate'];
				if ($row['tongdao'] == '香港币汇款' || $row['tongdao'] == 'wap香港币汇款')
				  $row['rate']=$yanzheng['hkc_rate'];
				 if ($row['tongdao'] == '比特币汇款' || $row['tongdao'] == 'wap比特币汇款')
				  $row['rate']=$yanzheng['btc_rate'];
				if ($row['tongdao'] == '以太币汇款' || $row['tongdao'] == 'wap以太币汇款')
				  $row['rate']=$yanzheng['eth_rate'];
				if ($row['tongdao'] == '人民币汇款' || $row['tongdao'] == 'wap人民币汇款')
				  $row['rate']=$yanzheng['money_rate'];
				//$row['rate'] = $row['tongdao'] == '美元支付' ? $yanzheng['dollar_rate'] : $yanzheng['paypal_rate'];
				$row['sxf'] = 0.00;

				if(!empty($row['rate'])) {
					if( $row['rate']>0){
						$row['sxf'] = max($row['rate'],0.01);
						$row['sxf'] = number_format(round($row['sxf'], 2), 2, '.', '');
					}

					$row['sjje'] = number_format(($row['money'] - $row['sxf']), 2, '.', '');
					if($row['sjje'] < 0) {
						$row['sjje'] = 0;
					}
				}
			}

			if ($row['zjlx']==1)
			{
				$row['zjlxsting']="公司账户";
			}else {
				$row['zjlxsting']="个人账户";

			}
			$member_list[] = $row;
		}
		include handler('template')->file('@admin/member_uschongzhi_list');

	}
}

?>
