<?php
	require_once "inc/sql.php";
	connect_valid();
	$QUERY_STRING="SELECT * FROM DOC_ACCEPT_SPOT WHERE VALIDATION_CODE='".$_GET[VC]."'";
	IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
	{
		$DATA=MYSQL_FETCH_ARRAY($RESULT);
		ECHO "
			店名：".$DATA['name']."<BR>
			地址：".$DATA['city'].$DATA['district'].$DATA['address'];
	}
	ELSE
	{
		ECHO "查無資料";
	}
?>