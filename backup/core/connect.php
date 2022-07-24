<?php
function connect(){

//$db_host		= "localhost";
$db_host		= "dailysnab.beget.tech";
$db_user		= "dailysnab_db";
//$db_password	= "&ML1&aQo";
$db_password	= "r*6bVbrm";
$db_dname	= "dailysnab_db";
/*
// тестоая для Гари
$db_user		= "dailysnab_test2";
$db_password	= "uh9*Rr%r";
$db_dname	= "dailysnab_test2";
*/

		try
		{
			$db = new PDO( "mysql:host=$db_host;dbname=$db_dname", $db_user, $db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
			if(DEBUG) $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
			else $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$GLOBALS['db'] = $db;
		}
		catch( PDOException $e ) { echo ( $e->getMessage() ); }
		
		
		
	PreExecSQL("SET @@lc_time_names='ru_RU'",array());
		
}

function disConnect(){
	$GLOBALS['db'] = null;
}

function PreExecSQL($sql,$arr=array())
{
	if(empty($sql)) return false;
		$STH = $GLOBALS['db']->prepare($sql);
		$STH->execute($arr);

	return $STH;
}

function PreExecSQL_one($sql,$arr=array())
{
	
	if(empty($sql)||!is_array($arr)) return false;
		$row = PreExecSQL($sql,$arr)->fetch(PDO::FETCH_ASSOC);

	return $row;
}

function PreExecSQL_all($sql,$arr=array())
{
	if(empty($sql)||!is_array($arr)) return false;
		$row = PreExecSQL($sql,$arr)->fetchall(PDO::FETCH_ASSOC);

	return $row;
}

function ExecSQL($sql)
{
	if(empty($sql)) return false;
		$STH = $GLOBALS['db']->query($sql);

	return $STH;
}

connect();
?>