<?php
	require_once "inc/sql.php";
	connect_valid();

	IF($_GET[SNO]!="")
	{
		$SNO=$_GET[SNO];
		$VC=$_GET[VC];
		$STATUS=$_GET[STATUS];
		$STFPWD=$_GET[STFPWD];
		$NICKNAME=$_GET[NICKNAME];
		$QUERY_STRING="SELECT staff_id FROM STAFF_INFO WHERE NICKNAME='".$NICKNAME."'";
		IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			$STAFF=$DATA[staff_id];
		}
		ELSE
		{
			ECHO "使用者不存在！";
		}
		$FROM="APP";
	}
	ELSE IF($_POST[SNO]!="")
	{
		$SNO="AP".$_POST[SNO];
		$IDL5=$_POST[IDL5];
		$STATUS=$_POST[STATUS];
		$STAFF=$_POST[STAFF];
		$FROM="DESKTOP";
	}
	
	IF($SNO[4]==1)
	{
		$MAIN_TABLE="PROPOSAL";
		$RECORD_TABLE="PROPOSAL_CHANGE_RECORD";
	}
	ELSE IF($SNO[4]==2)
	{
		$MAIN_TABLE="PETITION";
		$RECORD_TABLE="PETITION_CHANGE_RECORD";
	}

	ECHO $QUERY_STRING="INSERT INTO ".$RECORD_TABLE."(".$MAIN_TABLE."_ID,STATUS_CHANGED_TO,STAFF_ID)VALUES('".intval(substr($SNO,5))."','".$STATUS."','".$STAFF."')";
	IF(MYSQL_QUERY($QUERY_STRING))
	{
		$RECORD_ID=MYSQL_INSERT_ID();
		IF($FROM=="APP")
		{
			ECHO $QUERY_STRING="UPDATE ".$MAIN_TABLE." SET CURRENT_STATUS='".$STATUS."' WHERE ".$MAIN_TABLE."_ID='".intval(substr($SNO,5))."' AND VALIDATION_CODE='".$VC."'";
			IF(MYSQL_QUERY($QUERY_STRING))
			{
				IF(MYSQL_AFFECTED_ROWS()==1)
				{
					$QUERY_STRING="UPDATE ".$RECORD_TABLE." SET SUCCEED='1' WHERE ".$RECORD_TABLE."_ID='".$RECORD_ID."'";
					MYSQL_QUERY($QUERY_STRING);
//					ECHO "1";
				}
				ELSE
				{
//					ECHO "2";
				}
			}
			ELSE
			{
				ECHO "0";
			}
		}
		ELSE IF($FROM="DESKTOP")
		{
			ECHO $QUERY_STRING="SELECT id_last_five FROM ".$MAIN_TABLE." WHERE ".$MAIN_TABLE."_ID='".intval(substr($SNO,5))."'";
			$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
			IF($DATA[id_last_five]=="")
			{
				ECHO $QUERY_STRING="UPDATE ".$MAIN_TABLE." SET CURRENT_STATUS='".$STATUS."',ID_LAST_FIVE='".$IDL5."' WHERE ".$MAIN_TABLE."_ID='".intval(substr($SNO,5))."'";
			}
			ELSE
			{
				ECHO $QUERY_STRING="UPDATE ".$MAIN_TABLE." SET CURRENT_STATUS='".$STATUS."' WHERE ".$MAIN_TABLE."_ID='".intval(substr($SNO,5))."' AND ID_LAST_FIVE='".$IDL5."'";
			}
			IF(MYSQL_QUERY($QUERY_STRING)&&MYSQL_AFFECTED_ROWS()==1)
			{
				IF(MYSQL_AFFECTED_ROWS()==1)
				{
					$QUERY_STRING="UPDATE ".$RECORD_TABLE." SET SUCCEED='1' WHERE ".$RECORD_TABLE."_ID='".$RECORD_ID."'";
					MYSQL_QUERY($QUERY_STRING);
					ECHO "成功更新";
				}
				ELSE
				{
					ECHO "資料已更新，未變動";
						
				}
			}
			ELSE
			{
				ECHO "更新失敗";
			}
		}
	}
?>

</body>
</html>
