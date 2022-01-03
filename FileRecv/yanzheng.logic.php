<?php

/**
 * 逻辑区：配送地址
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package logic
 * @name address.logic.php
 * @version 1.0
 */

class YanzhengLogic
{
	
	function GetOneByUsername( $account)
	{
		$sql_limit_user = 'username = "'.$account.'"';
		

		$sql = 'SELECT *
		FROM
			' . table('members') . '
		WHERE
			
			'.$sql_limit_user;

		return dbc(DBCMax)->query($sql)->limit(1)->done();
	}
	
	function GetOneAC( $uid =0 )
	{
		$sql_limit_user = 'uid = '.$uid;
		

		$sql = 'SELECT *
		FROM
			' . table('members') . '
		WHERE
			
			'.$sql_limit_user;

		return dbc(DBCMax)->query($sql)->limit(1)->done();
	}

	
	function GetOne( $uid =0 )
	{
		$sql_limit_user = '1';
		if ($uid > 0)
		{
			$sql_limit_user = 'owner = '.$uid;
		}
		elseif ($uid == -1)
		{
						$sql_limit_user = 'owner = 0';
		}
		$sql = 'SELECT *
		FROM
			' . table('members_yanzheng') . '
		WHERE
			1
		AND
			'.$sql_limit_user;

		return dbc(DBCMax)->query($sql)->limit(1)->done();
	}
	
	function GetList( $uid = 0 )
	{
		$sql_limit_user = '1';
		if ( $uid > 0 )
		{
			$sql_limit_user = 'owner = ' . $uid;
		}
		elseif ($uid == -1)
		{
						$sql_limit_user = 'owner = 0';
		}
		$sql = 'SELECT *
		FROM
			' . table('members_yanzheng') . '
		WHERE
			' . $sql_limit_user . '
		ORDER BY
			id
		DESC';
		echo $sql;
		
		return dbc(DBCMax)->query($sql)->done();
	}
	
	
	
	
	function Add( $uid = 0, $array )
	{
		if ($uid == 0)
		{
			$uid = user()->get('id');
		}
		elseif ($uid == -1)
		{
						$uid = 0;
		}
		
		$array['owner'] = $uid;

		dbc()->SetTable(table('members_yanzheng'));
		return dbc()->Insert($array);
	}
	
	
	
	function Update($id, $array, $uid = 0)
	{
		$sql_limit_user = '1';
		if ($uid > 0)
		{
			$sql_limit_user = 'owner = '.$uid;
		}
		elseif ($uid == -1)
		{
						$sql_limit_user = 'owner = 0';
		}
		dbc()->SetTable(table('members_yanzheng'));
	
		dbc()->Update($array, 'id='.$id.' AND '.$sql_limit_user);
		return dbc()->AffectedRows();
	}
	
	
	
	
}


?>