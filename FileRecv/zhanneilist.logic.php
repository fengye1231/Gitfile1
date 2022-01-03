<?php

/**
 * 逻辑区：配送地址
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package logic
 * @name address.logic.php
 * @version 1.0
 */

class ZhanneilistLogic
{

	function GetOne( $id, $uid = 0 )
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
			' . table('zhanneilist') . '
		WHERE
			id=' . $id .'
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
			' . table('zhanneilist') . '
		WHERE
			' . $sql_limit_user . '
		ORDER BY
			id
		DESC';
		
		returndbc(DBCMax)->query($sql)->done();
	}
	
	
	
	function Used( $id )
	{
		$ary = array( 
			'lastuse' => time() 
		);
		dbc()->SetTable(table('yinhangka'));
		dbc()->Update($ary, 'id=' . $id);
		return true;
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

		dbc()->SetTable(table('zhanneilist'));
		$aaa=dbc()->Insert($array);



        //file_put_contents("my_log_2021_9_25_21_57.txt", "\naaa=", FILE_APPEND | LOCK_EX);

        //file_put_contents("my_log_2021_9_25_21_57.txt", "\n".$aaa, FILE_APPEND | LOCK_EX);

        return $aaa;


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
		dbc()->SetTable(table('zhuanzhanglist'));
		dbc()->Update($array, 'id='.$id.' AND '.$sql_limit_user);
		return dbc()->AffectedRows();
	}
	
	
	
	
}


?>