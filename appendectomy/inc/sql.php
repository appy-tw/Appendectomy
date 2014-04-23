<?php

// onnect_to_db() 建立資料庫連線
// onnect_valid() 檢驗連線是否正常

// ---------------------------------------------------------------------------------------------------------------------------
// 建立資料庫連線//
// ---------------------------------------------------------------------------------------------------------------------------
function connect_to_db()
{
	$host = 'localhost';
	$dbname = '';
	$user = '';
	$password = '';
	if ($link = mysql_pconnect ( $host, $user, $password ))
	{
		mysql_query ( "SET NAMES 'utf8'" );
		if (mysql_select_db ( $dbname, $link ))
			return true;
		else
			return false;
	}
}

// ---------------------------------------------------------------------------------------------------------------------------
// 檢驗連線是否正常
// ---------------------------------------------------------------------------------------------------------------------------
function connect_valid()
{
	if (connect_to_db ())
		return true;
	else
	{
		echo "<font color=red>Connection Abnormal!";
		return false;
	}
}

php?>