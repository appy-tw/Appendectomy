<?php
	require_once "inc/sql.php";
	connect_valid();
	
	$QUERY_STRING="SELECT * FROM DOC_ACCEPT_SPOT WHERE VALIDACTION_CODE='".$_GET[VC]."'";
	IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
	{
		$DATA=MYSQL_FETCH_ARRAY($RESULT);
		ECHO "
			���W�G".$DATA['name']."<BR>
			�a�}�G".$DATA['city'].$DATA['district'].$DATA['address'];
	}
	ELSE
	{
		ECHO "�d�L���";
	}
?>