<?php
	require_once "inc/sql.php";
	connect_valid();

	ECHO "
		<BR>
		<CENTER>
		罷免文件配合收件地點管理頁面<BR><BR>
		<TABLE BORDER=0 CELLSPACING=3 STYLE='background-color:#EEEEEE'>";

	IF($_GET[ACT]=="ADD")
	{
		ECHO "<TR><TD ALIGN=CENTER COLSPAN=6 STYLE='background-color:#CCCCCC'>新增收件點</TD></TR>";
		ECHO "
			<TR STYLE='text-align:center;background-color:#DDDDFF'><TD STYLE='width:300'>收件點名稱</TD><TD STYLE='width:100'>縣市</TD><TD STYLE='width:100'>鄉鎮市區</TD><TD STYLE='width:300'>地址</TD><TD STYLE='width:100'>電話</TD><TD STYLE='width:200'>備註</TD></TR>
		
		<FORM NAME=SPOTFORM ACTION=?ACT=ADDEXE METHOD=POST>
			<TR>
			<TD><INPUT TYPE=TEXT NAME=SPOT_NAME STYLE='width:300'></TD>
			<TD><INPUT TYPE=TEXT NAME=CITY STYLE='width:100'></TD>
			<TD><INPUT TYPE=TEXT NAME=DISTRICT STYLE='width:100'></TD>
			<TD><INPUT TYPE=TEXT NAME=ADDRESS STYLE='width:300'></TD>
			<TD><INPUT TYPE=TEXT NAME=TELEPHONE STYLE='width:100'></TD>
			<TD ROWSPAN=3><TEXTAREA NAME=NOTE STYLE='width:200;height:100%'></TEXTAREA></TD></TR>
			<TR><TD STYLE='text-align:center;background-color:#DDDDFF'>營業時間</TD><TD COLSPAN=4><TEXTAREA NAME=BUSINESS_HOUR STYLE='width:100%'></TEXTAREA></TR>
			<TR><TD STYLE='text-align:center;background-color:#DDDDFF'>網址</TD><TD COLSPAN=4><INPUT TYPE=TEXT NAME=WEBSITE_PATH STYLE='width:100%'></TD></TR>
		<TR><TD COLSPAN=6 ALIGN=RIGHT>
			<INPUT TYPE=BUTTON ONCLICK=location.href='accept_spot_management.php' VALUE='取消' STYLE='width:80'>
			<INPUT TYPE=SUBMIT VALUE='新增' STYLE='width:80'>
		</FORM>
		</TD></TR>";
	}
	ELSE IF($_GET[ACT]=="ADDEXE")
	{
		ECHO "<TR><TD ALIGN=CENTER>新增收件點執行結果</TD></TR>";
		$QUERY_STRING="INSERT INTO DOC_ACCEPT_SPOT 
			(NAME,CITY,DISTRICT,ADDRESS,TELEPHONE,NOTE,BUSINESS_HOUR,WEBSITE_PATH,VALIDATION_CODE)
			VALUES(
			'".$_POST['SPOT_NAME']."',
			'".$_POST['CITY']."',
			'".$_POST['DISTRICT']."',
			'".$_POST['ADDRESS']."',
			'".$_POST['TELEPHONE']."',
			'".$_POST['NOTE']."',
			'".$_POST['BUSINESS_HOUR']."',
			'".$_POST['WEBSITE_PATH']."',
			'".returnValidation()."')";
		IF(MYSQL_QUERY($QUERY_STRING))
		{
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>輸入成功<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=location.href='accept_spot_management.php' VALUE='前往列表'><BR><BR>
			</TD></TR>";
		}
		ELSE
		{
			ECHO $QUERY_STRING;
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>輸入失敗<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=history.go(-1) VALUE='回上一頁'><BR><BR>
			</TD></TR>";
		}
	}
	ELSE IF($_GET[ACT]=="MOD")
	{
		$QUERY_STRING="SELECT * FROM DOC_ACCEPT_SPOT WHERE ACCEPT_SPOT_ID='".$_GET[ID]."'";
		$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
		ECHO "<TR><TD ALIGN=CENTER COLSPAN=6 STYLE='background-color:#CCCCCC'>修改收件點</TD></TR>";
		ECHO "
			<TR STYLE='text-align:center;background-color:#DDDDFF'><TD STYLE='width:300'>收件點名稱</TD><TD STYLE='width:100'>縣市</TD><TD STYLE='width:100'>鄉鎮市區</TD><TD STYLE='width:300'>地址</TD><TD STYLE='width:100'>電話</TD><TD STYLE='width:200'>備註</TD></TR>
		
		<FORM NAME=SPOTFORM ACTION=?ACT=MODEXE&ID=".$_GET[ID]." METHOD=POST>
			<TR>
			<TD><INPUT TYPE=TEXT NAME=SPOT_NAME STYLE='width:300' VALUE='".$DATA['name']."'></TD>
			<TD><INPUT TYPE=TEXT NAME=CITY STYLE='width:100' VALUE='".$DATA['city']."'></TD>
			<TD><INPUT TYPE=TEXT NAME=DISTRICT STYLE='width:100' VALUE='".$DATA['district']."'></TD>
			<TD><INPUT TYPE=TEXT NAME=ADDRESS STYLE='width:300' VALUE='".$DATA['address']."'></TD>
			<TD><INPUT TYPE=TEXT NAME=TELEPHONE STYLE='width:100' VALUE='".$DATA['telephone']."'></TD>
			<TD ROWSPAN=3><TEXTAREA NAME=NOTE STYLE='width:200;height:100%'>".$DATA['note']."</TEXTAREA></TD></TR>
			<TR><TD STYLE='text-align:center;background-color:#DDDDFF'>營業時間</TD><TD COLSPAN=4><TEXTAREA NAME=BUSINESS_HOUR STYLE='width:100%'>".$DATA['business_hour']."</TEXTAREA></TD></TR>
			<TR><TD STYLE='text-align:center;background-color:#DDDDFF'>網址</TD><TD COLSPAN=4><INPUT TYPE=TEXT NAME=WEBSITE_PATH STYLE='width:100%' VALUE='".$DATA['website_path']."'></TD></TR>
		<TR><TD COLSPAN=6 ALIGN=RIGHT>
			<INPUT TYPE=BUTTON ONCLICK=location.href='accept_spot_management.php' VALUE='取消' STYLE='width:80'>
			<INPUT TYPE=SUBMIT VALUE='修改' STYLE='width:80'>
		</FORM>
		</TD></TR>";
	}
	ELSE IF($_GET[ACT]=="MODEXE")
	{
		ECHO "<TR><TD ALIGN=CENTER>修改收件點執行結果</TD></TR>";
		$QUERY_STRING="UPDATE DOC_ACCEPT_SPOT SET 
			NAME='".$_POST['SPOT_NAME']."'
			,CITY='".$_POST['CITY']."'
			,DISTRICT='".$_POST['DISTRICT']."'
			,ADDRESS='".$_POST['ADDRESS']."'
			,TELEPHONE='".$_POST['TELEPHONE']."'
			,NOTE='".$_POST['NOTE']."'
			,BUSINESS_HOUR='".$_POST['BUSINESS_HOUR']."'
			,WEBSITE_PATH='".$_POST['WEBSITE_PATH']."'
			 WHERE  ACCEPT_SPOT_ID='".$_GET[ID]."'";
		IF(MYSQL_QUERY($QUERY_STRING))
		{
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>修改成功<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=location.href='accept_spot_management.php' VALUE='前往列表'><BR><BR>
			</TD></TR>";
		}
		ELSE
		{
			ECHO $QUERY_STRING;
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>修改失敗<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=history.go(-1) VALUE='回上一頁'><BR><BR>
			</TD></TR>";
		}
	}
	ELSE IF($_GET[ACT]=="DEL")
	{
		ECHO "<TR><TD ALIGN=CENTER>刪除收件點</TD></TR>";
		$QUERY_STRING="SELECT * FROM DOC_ACCEPT_SPOT WHERE ACCEPT_SPOT_ID='".$_GET[ID]."'";
		IF($RESULT=MYSQL_QUERY($QUERY_STRING))
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>是否確定要刪除以下收件點<BR><BR>
				<FONT COLOR=RED><B>".$DATA['name']."</B></FONT><BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=history.go(-1) VALUE='取消' STYLE='width:80'>
				<INPUT TYPE=BUTTON ONCLICK=location.href='?ACT=DELEXE&ID=".$_GET[ID]."' VALUE='確定刪除' STYLE='width:80'>
				<BR><BR>
			</TD></TR>";
		}
		ELSE
		{
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>刪除失敗<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=history.go(-1) VALUE='回上一頁'><BR><BR>
			</TD></TR>";
		}
	}
	ELSE IF($_GET[ACT]=="DELEXE")
	{
		ECHO "<TR><TD ALIGN=CENTER>刪除收件點執行結果</TD></TR>";
		$QUERY_STRING="DELETE FROM DOC_ACCEPT_SPOT WHERE ACCEPT_SPOT_ID='".$_GET[ID]."'";
		IF(MYSQL_QUERY($QUERY_STRING))
		{
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>刪除成功<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=location.href='accept_spot_management.php' VALUE='前往列表'><BR><BR>
			</TD></TR>";
		}
		ELSE
		{
			ECHO $QUERY_STRING;
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>刪除失敗<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=location.href='accept_spot_management.php' VALUE='前往列表'><BR><BR>
			</TD></TR>";
		}
	}
	ELSE
	{
		$QUERY_STRING="SELECT * FROM DOC_ACCEPT_SPOT ORDER BY CITY, DISTRICT";
		$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
		ECHO "
			<TR><TD COLSPAN=8 ALIGN=RIGHT><INPUT TYPE=BUTTON ONCLICK=location.href='?ACT=ADD' VALUE='新增收件點' STYLE='WIDTH:150;FONT-SIZE:16'></TD></TR>
			<TR STYLE='text-align:center;background-color:#DDDDFF'><TD ROWSPAN=2>No.</TD><TD ROWSPAN=2 STYLE='width:300'>收件點名稱</TD><TD STYLE='width:100'>縣市</TD><TD STYLE='width:100'>鄉鎮市區</TD><TD STYLE='width:300'>地址</TD><TD STYLE='width:100'>電話</TD><TD ROWSPAN=2 STYLE='width:200'>備註</TD><TD ROWSPAN=2 STYLE='width:150'>資料處理</TD></TR>
			<TR STYLE='text-align:center;'><TD COLSPAN=4 STYLE='BACKGROUND-COLOR:#EEEEFF'>營業時間</TD></TR>
			<TR><TD COLSPAN=8 STYLE='height:3;background-color:#cccccc'></TD></TR>";
		FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
		{
			IF($SEED%2==0)
				$BGCOLOR="#DDFFDD";
			ELSE
				$BGCOLOR="#FFDDDD";
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			ECHO "<TR STYLE='BACKGROUND-COLOR:".$BGCOLOR.";TEXT-ALIGN:CENTER'><TD ROWSPAN=2>".($SEED+1)."</TD><TD ROWSPAN=2>";
			IF($DATA['website_path']!="")
			{
					ECHO "<A HREF='".$DATA['website_path']."' TARGET=_blank>".$DATA['name']."</A>";
			}
			ELSE
			{
					ECHO $DATA['name'];
			}
			//補驗證碼的資料
			IF($DATA['validation_code']=="")
			{
				$QUERY_STRING="UPDATE DOC_ACCEPT_SPOT SET VALIDATION_CODE='".returnValidation()."' WHERE ACCEPT_SPOT_ID='".$DATA['accept_spot_id']."'";
				MYSQL_QUERY($QUERY_STRING);
			}
			ECHO "</TD><TD>".$DATA['city']."</TD><TD>".$DATA['district']."</TD><TD>".$DATA['address']."</TD><TD>".$DATA['telephone']."</TD><TD ROWSPAN=2>".nl2br($DATA['note'])."</TD>
			<TD ROWSPAN=2>
			<INPUT TYPE=BUTTON ONCLICK=location.href='?ACT=MOD&ID=".$DATA[accept_spot_id]."' VALUE='修改' STYLE='width:70'>
			<INPUT TYPE=BUTTON ONCLICK=location.href='?ACT=DEL&ID=".$DATA[accept_spot_id]."' VALUE='刪除' STYLE='width:70'><BR>
			<INPUT TYPE=BUTTON ONCLICK=location.href='spot_qrcode_image.php?ACT=DEL&ID=".$DATA[accept_spot_id]."' VALUE='取得收件點含 QRCode 影像' STYLE='width:180'>
				</TD></TR>
			<TR><TD COLSPAN=4>".nl2br($DATA['business_hour'])."</TD></TR>";
				
		}
	}
	ECHO "</TABLE>";
	
	
function returnValidation()
{
	$BASESTRING="0123456789";
	FOR($SEED=0;$SEED<30;$SEED++)
	{
		$FINALSTRING.=$BASESTRING[RAND(0,9)];
	}
	RETURN $FINALSTRING;
}

?>