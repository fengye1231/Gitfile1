<?php

/**
 * 逻辑区：配送地址
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package logic
 * @name address.logic.php
 * @version 1.0
 */

class ZhuCeLogic
{

	

	
	function GetOne( $id =0 )
	{
		$sql_limit_user = '1';
	
		$sql_limit_user = ' id = '.$id;
		
		$sql = 'SELECT *
		FROM
			' . table('members_tmp') . '
		WHERE
			1
		AND
			'.$sql_limit_user;

		return dbc(DBCMax)->query($sql)->limit(1)->done();
	}
	
function GetOneByEmail( $email )
	{
		$sql_limit_user = '1';
	
		$sql_limit_user = ' email = "'.$email.'"';
		
		$sql = 'SELECT *
		FROM
			' . table('members_tmp') . '
		WHERE
			1
		AND
			'.$sql_limit_user;

		return dbc(DBCMax)->query($sql)->limit(1)->done();
	}
	
	
	
	
	
	
	function Add( $array )
	{


		dbc()->SetTable(table('members_tmp'));
		return dbc()->Insert($array);
	}
	
	
	
	function Update($id, $array)
	{
		
		dbc()->SetTable(table('members_tmp'));
	
		dbc()->Update($array, 'id='.$id);
		return dbc()->AffectedRows();
	}
	
	
	
	
}


?>