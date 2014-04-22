<?php
	require_once "inc/sql.php";
	connect_valid();

	IF($_GET['SNO']!="")
	{
		$SNO=$_GET['SNO'];
		$VC=$_GET['VC'];
		$STATUS=$_GET['STATUS'];
		$STFPWD=$_GET['STFPWD'];
		$NICKNAME=$_GET['NICKNAME'];
		$IDL5=$_GET['IDL5'];
		$PROCEED=TRUE;
		IF(($STATUS=="refused"||$STATUS=="voided")&&$STFPWD=="")
		{
			$RETURNED_STRING="STFPWD";
			$PROCEED=FALSE;
		}
		ELSE
		{
			IF($STATUS=="refused"||$STATUS=="voided")
			{
				$QUERY_STRING="SELECT staff_id FROM STAFF_INFO WHERE NICKNAME='".$NICKNAME."' AND PASSWORD=PASSWORD('".$STFPWD."')";
			}
			ELSE
			{
				$QUERY_STRING="SELECT staff_id FROM STAFF_INFO WHERE NICKNAME='".$NICKNAME."'";
			}
			IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
			{
				$DATA=MYSQL_FETCH_ARRAY($RESULT);
				$STAFF=$DATA['staff_id'];
			}
			ELSE
			{
				$PROCEED=FALSE;
			}
		}
		IF($PROCEED)
		{
			IF($STAFF=="")
			{
				$QUERY_STRING="SELECT staff_id FROM STAFF_INFO WHERE NICKNAME='".$NICKNAME."'";
				IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
				{
					$STAFF=$DATA['staff_id'];
				}
			}
			IF($STAFF!="")
			{
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

				$QUERY_STRING="INSERT INTO ".$RECORD_TABLE."(".$MAIN_TABLE."_ID,STATUS_CHANGED_TO,STAFF_ID)VALUES('".intval(substr($SNO,5))."','".$STATUS."','".$STAFF."')";
				IF(MYSQL_QUERY($QUERY_STRING))
				{
					$RECORD_ID=MYSQL_INSERT_ID();
					$QUERY_STRING="SELECT current_status,id_last_five FROM ".$MAIN_TABLE." WHERE ".$MAIN_TABLE."_ID='".intval(substr($SNO,5))."' AND VALIDATION_CODE='".$VC."'";
					IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
					{
						$DATA=MYSQL_FETCH_ARRAY($RESULT);
						
						IF($DATA['id_last_five']=="")
						{
							IF($IDL5=="")
							{
								$RETURNED_STRING="IDL5";
								$QUERY_STRING="";
							}
							ELSE
							{
								$QUERY_STRING="UPDATE ".$MAIN_TABLE." SET CURRENT_STATUS='".$STATUS."',ID_LAST_FIVE='".$IDL5."' WHERE ".$MAIN_TABLE."_ID='".intval(substr($SNO,5))."' AND VALIDATION_CODE='".$VC."'";
							}
						}
						ELSE
						{
							$QUERY_STRING="UPDATE ".$MAIN_TABLE." SET CURRENT_STATUS='".$STATUS."' WHERE ".$MAIN_TABLE."_ID='".intval(substr($SNO,5))."' AND VALIDATION_CODE='".$VC."'";
						}
						
						IF($QUERY_STRING!="")
						{
							$RETURNED_STRING=$DATA['current_status'];
							IF(MYSQL_QUERY($QUERY_STRING))
							{
								IF(MYSQL_AFFECTED_ROWS()==1)
								{
									$QUERY_STRING="UPDATE ".$RECORD_TABLE." SET SUCCEED='1' WHERE ".$RECORD_TABLE."_ID='".$RECORD_ID."'";
									MYSQL_QUERY($QUERY_STRING);
									$QUERY_STRING="SELECT current_status,last_update FROM ".$MAIN_TABLE." WHERE ".$MAIN_TABLE."_ID='".intval(substr($SNO,5))."' AND VALIDATION_CODE='".$VC."'";
									IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
									{
										$DATA=MYSQL_FETCH_ARRAY($RESULT);
										$RETURNED_STRING.=";".$DATA['current_status'].";".$DATA['last_update'];
									}
								}
								ELSE
								{
									$RETURNED_STRING.=";NOCHANGE";
								}
							}
							ELSE
							{
								$RETURNED_STRING="更新失敗";
							}
						}
					}
					ELSE
					{
						$RETURNED_STRING="更新失敗";
					}
				}
			}
			ELSE
			{
				$RETURNED_STRING.="NA";
			}
		}
	}
	ECHO $RETURNED_STRING;

?>