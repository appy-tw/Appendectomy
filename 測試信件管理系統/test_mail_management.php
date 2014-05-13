<?php
	require_once "inc/sql.php";
	connect_valid();

	ECHO "	<CENTER>
			<BR>
			<H2>測試郵件追蹤管理系統</H2>
			<BR>
			<TABLE BORDER=0 CELLSPACING=3 CELLPADDING=2 STYLE='background-color:#CCCCCC'>";


	IF($_GET[ACT]=="ADD")
	{
		ECHO "
			<TR><TD COLSPAN=8 ALIGN=CENTER>新增測試郵件紀錄</TD></TR>
			<TR STYLE='text-align:center;background-color:#DDDDFF'>
				<TD ROWSPAN=2 STYLE='width:150'>測試人</TD>
				<TD ROWSPAN=2 STYLE='width:150'>測試文件流水號</TD>
				<TD ROWSPAN=2 STYLE='width:150'>寄出日期<BR>YYYY-MM-DD</TD>
				<TD COLSPAN=3>寄出地點</TD>
				<TD ROWSPAN=2>寄送方式</TD></TR>
			<TR STYLE='background-color:#ffeeee;text-align:center'><TD STYLE='width:100;'>縣市</TD><TD STYLE='width:100'>鄉鎮市區</TD><TD STYLE='width:300'>地點（如郵局名稱或郵筒地址）</TD></TR>";
		ECHO "
			<FORM NAME=TESTMAIL_FORM ACTION=?ACT=ADDEXE METHOD=POST>
			<TR>
			<TD><INPUT TYPE=TEXT NAME=TESTER STYLE='WIDTH:100%'></TD>
			<TD><INPUT TYPE=TEXT NAME=SNO STYLE='WIDTH:100%'></TD>
			<TD><INPUT TYPE=TEXT NAME=SEND_DATE STYLE='width:100%;font-size:16;text-align:center' VALUE='".date('Y-m-d')."'></TD>
			<TD><INPUT TYPE=TEXT NAME=CITY STYLE='WIDTH:100%'></TD>
			<TD><INPUT TYPE=TEXT NAME=DISTRICT STYLE='WIDTH:100%'></TD>
			<TD><INPUT TYPE=TEXT NAME=LOCATION STYLE='WIDTH:100%'></TD>";
		ECHO "<TD>
			<INPUT TYPE=RADIO NAME=METHOD VALUE='NORMAL' CHECKED>平信
			<INPUT TYPE=RADIO NAME=METHOD VALUE='ADV'>廣告回函
			<INPUT TYPE=RADIO NAME=METHOD VALUE='PRI'>限時專送<BR>
			<INPUT TYPE=RADIO NAME=METHOD VALUE='REGISTERED'>掛號
			<INPUT TYPE=RADIO NAME=METHOD VALUE='PRI_REG'>限時掛號
			<INPUT TYPE=TEXT NAME=REG_NO STYLE='width:100%' placeholder='掛號/限時掛號信追蹤編號'>
			</TD></TR>";
		ECHO "<TR><TD COLSPAN=8 ALIGN=RIGHT STYLE='background-color:#eeeeee'>
			<INPUT TYPE=BUTTON ONCLICK=history.go(-1) VALUE='取消' STYLE='width:80'>
			<INPUT TYPE=SUBMIT VALUE='新增紀錄' STYLE='width:80'>
			</TD></TR>
			</FORM>";

	}
	ELSE IF($_GET[ACT]=="ADDEXE")
	{
		ECHO "
			<TR><TD ALIGN=CENTER>新增測試郵件紀錄結果</TD></TR>";
		$QUERY_STRING="INSERT INTO TEST_RECORD 
			(SERIAL_NO,TESTER,MAIL_METHOD,CITY,DISTRICT,SEND_LOCATION,SEND_DATE,REG_NO)
			VALUES(
			'".$_POST['SNO']."',
			'".$_POST['TESTER']."',
			'".$_POST['METHOD']."',
			'".$_POST['CITY']."',
			'".$_POST['DISTRICT']."',
			'".$_POST['LOCATION']."',
			'".$_POST['SEND_DATE']."',
			'".$_POST['REG_NO']."')";
		IF(MYSQL_QUERY($QUERY_STRING))
		{
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>輸入成功<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=location.href='test_mail_management.php' VALUE='前往列表'><BR><BR>
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
	ELSE IF($_GET[ACT]=="REPORT_SEND")
	{
		$QUERY_STRING="SELECT * FROM TEST_RECORD WHERE TEST_RECORD_ID='".$_GET['TRID']."'";
		IF($RESULT=MYSQL_QUERY($QUERY_STRING))
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			ECHO "
			<TR><TD COLSPAN=8 ALIGN=CENTER>設定寄出資訊</TD></TR>
			<TR STYLE='text-align:center;background-color:#DDDDFF'>
				<TD ROWSPAN=2 STYLE='width:150'>測試人</TD>
				<TD ROWSPAN=2 STYLE='width:150'>測試文件流水號</TD>
				<TD ROWSPAN=2 STYLE='width:150'>寄出日期<BR>YYYY-MM-DD</TD>
				<TD COLSPAN=3>寄出地點</TD>
				<TD ROWSPAN=2>寄送方式</TD></TR>
			<TR STYLE='background-color:#ffeeee;text-align:center'><TD STYLE='width:100;'>縣市</TD><TD STYLE='width:100'>鄉鎮市區</TD><TD STYLE='width:300'>地點（如郵局名稱或郵筒地址）</TD></TR>";
		ECHO "
			<FORM NAME=TESTMAIL_FORM ACTION=?ACT=RSEXE&TRID=".$_GET['TRID']." METHOD=POST>
			<TR>
			<TD STYLE='background-color:#eeeeee;color:red;text-align:center'>".$DATA['tester']."<INPUT TYPE=HIDDEN NAME=TESTER VALUE='".$DATA['tester']."'></TD>
			<TD STYLE='background-color:#eeeeee;color:red;text-align:center'>".$DATA['serial_no']."<INPUT TYPE=HIDDEN NAME=SNO VALUE='".$DATA['serial_no']."'></TD>
			<TD><INPUT TYPE=TEXT NAME=SEND_DATE STYLE='width:100%;font-size:16;text-align:center' VALUE='".date('Y-m-d')."'></TD>
			<TD><INPUT TYPE=TEXT NAME=CITY STYLE='WIDTH:100%'></TD>
			<TD><INPUT TYPE=TEXT NAME=DISTRICT STYLE='WIDTH:100%'></TD>
			<TD><INPUT TYPE=TEXT NAME=LOCATION STYLE='WIDTH:100%'></TD>";
		ECHO "<TD>
			<INPUT TYPE=RADIO NAME=METHOD VALUE='NORMAL' CHECKED>平信
			<INPUT TYPE=RADIO NAME=METHOD VALUE='ADV'>廣告回函
			<INPUT TYPE=RADIO NAME=METHOD VALUE='PRI'>限時專送<BR>
			<INPUT TYPE=RADIO NAME=METHOD VALUE='REGISTERED'>掛號
			<INPUT TYPE=RADIO NAME=METHOD VALUE='PRI_REG'>限時掛號
			<INPUT TYPE=TEXT NAME=REG_NO STYLE='width:100%' placeholder='掛號/限時掛號信追蹤編號'>
			</TD></TR>";
		ECHO "<TR><TD COLSPAN=8 ALIGN=RIGHT STYLE='background-color:#eeeeee'>
			<INPUT TYPE=BUTTON ONCLICK=history.go(-1) VALUE='取消' STYLE='width:80'>
			<INPUT TYPE=SUBMIT VALUE='設定資訊' STYLE='width:80'>
			</TD></TR>
			</FORM>";
		}

	}
	ELSE IF($_GET[ACT]=="RSEXE")
	{
		ECHO "
			<TR><TD ALIGN=CENTER>設定寄出資訊結果</TD></TR>";
		$QUERY_STRING="UPDATE TEST_RECORD 
			SET MAIL_METHOD='".$_POST['METHOD']."'
			,CITY='".$_POST['CITY']."'
			,DISTRICT='".$_POST['DISTRICT']."'
			,SEND_LOCATION='".$_POST['LOCATION']."'
			,SEND_DATE='".$_POST['SEND_DATE']."'
			,REG_NO='".$_POST['REG_NO']."' 
			WHERE TEST_RECORD_ID='".$_GET[TRID]."'";
		IF(MYSQL_QUERY($QUERY_STRING))
		{
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>設定成功<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=location.href='test_mail_management.php' VALUE='前往列表'><BR><BR>
			</TD></TR>";
		}
		ELSE
		{
			ECHO $QUERY_STRING;
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>設定失敗<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=history.go(-1) VALUE='回上一頁'><BR><BR>
			</TD></TR>";
		}
	}
	ELSE IF($_GET[ACT]=="REPORT_RECEIVED")
	{
		ECHO "
			<TR><TD ALIGN=CENTER COLSPAN=2>通報測試郵件送達日期</TD></TR>";
		$QUERY_STRING="SELECT * FROM TEST_RECORD WHERE TEST_RECORD_ID='".$_GET['TRID']."'";
		IF($RESULT=MYSQL_QUERY($QUERY_STRING))
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			ECHO "
			<FORM NAME=TESTMAIL_FORM ACTION=?ACT=RREXE&TRID=".$_GET['TRID']." METHOD=POST>
				<TR><TD STYLE='background-color:#eeffee;text-align:center'>測試郵件編號</TD><TD  STYLE='background-color:#eeeeff;text-align:center'>".$DATA['serial_no']."</TD></TR>
				<TR><TD STYLE='background-color:#eeffee;text-align:center'>送達日期</TD>
				<TD><INPUT TYPE=TEXT NAME=RECEIVED_DATE STYLE='width:100%;height:30;font-size:16;text-align:center' VALUE='".date('Y-m-d')."'></TD></TR>
				<TR><TD COLSPAN=2 STYLE='background-color:#eeeeee;text-align:center'>
				<INPUT TYPE=BUTTON ONCLICK=location.href='test_mail_management.php' VALUE='取消' STYLE='width:80'>
				<INPUT TYPE=SUBMIT VALUE='通報送達' STYLE='width:80'></TD></TR>
			</FORM>";
		}
	}
	ELSE IF($_GET[ACT]=="RREXE")
	{
		ECHO "
			<TR><TD ALIGN=CENTER COLSPAN=2>通報測試郵件送達日期結果</TD></TR>";
		$QUERY_STRING="UPDATE TEST_RECORD SET RECEIVED_DATE='".$_POST['RECEIVED_DATE']."' WHERE TEST_RECORD_ID='".$_GET['TRID']."'";
		IF(MYSQL_QUERY($QUERY_STRING))
		{
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>通報成功<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=location.href='test_mail_management.php' VALUE='前往列表'><BR><BR>
			</TD></TR>";
		}
		ELSE
		{
			ECHO $QUERY_STRING;
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>通報失敗<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=history.go(-1) VALUE='回上一頁'><BR><BR>
			</TD></TR>";
		}
		
	}
	ELSE IF($_GET[ACT]=="DEL")
	{
		ECHO "
			<TR><TD ALIGN=CENTER>刪除測試郵件</TD></TR>";
		$QUERY_STRING="SELECT * FROM TEST_RECORD WHERE TEST_RECORD_ID='".$_GET['TRID']."'";
		IF($RESULT=MYSQL_QUERY($QUERY_STRING))
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			ECHO "<TR><TD STYLE='width:250;background-color:#eeeeff;text-align:center'><BR>是否確定要刪除以下測試郵件<BR><BR>
				<FONT COLOR=RED><B>".$DATA['serial_no']."</B></FONT><BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=history.go(-1) VALUE='取消' STYLE='width:80'>
				<INPUT TYPE=BUTTON ONCLICK=location.href='?ACT=DELEXE&TRID=".$_GET[TRID]."' VALUE='確定刪除' STYLE='width:80'>
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
		ECHO "<TR><TD ALIGN=CENTER>刪除測試郵件結果</TD></TR>";
		$QUERY_STRING="DELETE FROM TEST_RECORD WHERE TEST_RECORD_ID='".$_GET[TRID]."'";
		IF(MYSQL_QUERY($QUERY_STRING))
		{
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>刪除成功<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=location.href='test_mail_management.php' VALUE='前往列表'><BR><BR>
			</TD></TR>";
		}
		ELSE
		{
			ECHO $QUERY_STRING;
			ECHO "<TR><TD STYLE='width:200;background-color:#eeeeff;text-align:center'><BR>刪除失敗<BR><BR>
				<INPUT TYPE=BUTTON ONCLICK=location.href='test_mail_management.php' VALUE='前往列表'><BR><BR>
			</TD></TR>";
		}
	}
	ELSE
	{
		$QUERY_STRING="SELECT COUNT(*) AS NO_DATA FROM TEST_RECORD";
		$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
		$GENERATED_NO=$DATA['NO_DATA'];

		$QUERY_STRING="SELECT COUNT(*) AS NO_DATA FROM TEST_RECORD WHERE SEND_DATE<>''";
		$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
		$SEND_NO=$DATA['NO_DATA'];
		
		$QUERY_STRING="SELECT COUNT(*) AS NO_DATA FROM TEST_RECORD WHERE RECEIVED_DATE<>''";
		$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
		$RECEIVED_NO=$DATA['NO_DATA'];
		
		$QUERY_STRING="SELECT * FROM TEST_RECORD ORDER BY SEND_DATE ASC,CITY ASC,DISTRICT ASC,SERIAL_NO ASC,RECEIVED_DATE ASC";
		$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
		ECHO "
			<TR><TD COLSPAN=10 ALIGN=RIGHT>
			<DIV STYLE='float:left'>產製測試文件數：".$GENERATED_NO."／寄出：".$SEND_NO."／寄達：".$RECEIVED_NO."</DIV>
			<INPUT TYPE=BUTTON ONCLICK=location.href='input_proposal_test_form.php' VALUE='新增測試提議書'>
			<INPUT TYPE=BUTTON ONCLICK=location.href='input_petition_test_form.php' VALUE='新增測試連署書'>
			<INPUT TYPE=BUTTON ONCLICK=location.href='?ACT=ADD' VALUE='新增測試郵件紀錄'>
			</TD></TR>
			<TR STYLE='text-align:center;background-color:#DDDDFF'><TD ROWSPAN=2>No.</TD>
				<TD ROWSPAN=2 STYLE='width:100'>測試人</TD>
				<TD ROWSPAN=2 STYLE='width:100'>文件流水號</TD>
				<TD ROWSPAN=2>寄出日期</TD>
				<TD COLSPAN=3>寄出地點</TD>
				<TD ROWSPAN=2>寄送方式</TD>
				<TD ROWSPAN=2>寄達日期</TD>
				<TD ROWSPAN=2>遞送所需時間</TD></TR>
			<TR STYLE='background-color:#ffeeee;text-align:center'><TD STYLE='width:100;'>縣市</TD><TD STYLE='width:100'>鄉鎮市區</TD><TD STYLE='width:300'>地點（如郵局名稱或郵筒地址）</TD></TR>";
		IF($NO_OF_DATA>0)
			ECHO "<TR><TD COLSPAN=10 STYLE='height:3;background-color:#cccccc'></TD></TR>";
		ELSE
			ECHO "<TR><TD COLSPAN=10 STYLE='text-align:center;background-color:#ffffff'><BR>目前無測試郵件<BR><BR></TD></TR>";
		
		FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			
			IF($SEED%2==0)
				$BGCOLOR="#DDFFDD";
			ELSE
				$BGCOLOR="#FFDDDD";
			
			ECHO "<TR STYLE='BACKGROUND-COLOR:".$BGCOLOR.";TEXT-ALIGN:CENTER'><TD>".($SEED+1)."</TD>";
			ECHO "<TD>".$DATA['tester']."</TD><TD>".$DATA['serial_no']."</TD>";
			IF($DATA['send_date']!="")
			{
				ECHO "<TD>".substr($DATA['send_date'],0,10)."</TD>
				<TD>".$DATA['city']."</TD><TD>".$DATA['district']."</TD><TD>".$DATA['send_location']."</TD><TD>";
				IF($DATA['mail_method']=='NORMAL')
					ECHO "平信";
				ELSE IF($DATA['mail_method']=='PRI')
				{
					ECHO "限時專送<BR>";
				}
				ELSE IF($DATA['mail_method']=='REGISTERED')
				{
					ECHO "掛號<BR>".$DATA['reg_no'];
				}
				ELSE IF($DATA['mail_method']=='PRI_REG')
				{
					ECHO "限時掛號<BR>".$DATA['reg_no'];
				}
				ELSE IF($DATA['mail_method']=='ADV')
					ECHO "廣告回函";
				ECHO "</TD><TD>";
				IF($DATA['received_date']!="")
				{
					ECHO substr($DATA['received_date'],0,10);
				}
				ELSE
				{
					ECHO "<INPUT TYPE=BUTTON ONCLICK=location.href='?ACT=REPORT_RECEIVED&TRID=".$DATA['test_record_id']."' VALUE='通報送達時間' STYLE='width:100%;font-size:16'>";
				}
				ECHO "
				<TD></TD></TR>";
			}
			ELSE
			{
				ECHO "<TD COLSPAN=5>
					<INPUT TYPE=BUTTON ONCLICK=location.href='?ACT=REPORT_SEND&TRID=".$DATA['test_record_id']."' VALUE='設定寄出資訊' STYLE='width:100%;font-size:16'></TD>
				<TD>
					<INPUT TYPE=BUTTON ONCLICK=location.href='?ACT=DEL&TRID=".$DATA['test_record_id']."' VALUE='刪除測試郵件' STYLE='width:100%;font-size:16'></TD>
				<TD></TD></TR>";
			}
		}
		ECHO "<TR><TD COLSPAN=10 ALIGN=RIGHT>
			<DIV STYLE='float:left'>產製測試文件數：".$GENERATED_NO."／寄出：".$SEND_NO."／寄達：".$RECEIVED_NO."</DIV></TD></TR>";
	}
	ECHO "</TABLE>";
?>