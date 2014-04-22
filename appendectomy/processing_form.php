<?php 
	SESSION_START();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>文件處理輸入頁面</title>
</head>

<body onload=initial()>
<?php
	require_once "inc/sql.php";
	connect_valid();
	IF($_GET['ACT']=="GO")
	{
		$STAFF=$_POST['STAFF'];
		$STATUS=$_POST['STATUS'];
		
		//文件為提議書
		IF($_POST['DOCTYPE']==1)
		{
			$MAIN_TABLE="PROPOSAL";
			$RECORD_TABLE="PROPOSAL_CHANGE_RECORD";
		}
		//文件為連署書
		ELSE IF($_POST['DOCTYPE']==2)
		{
			$MAIN_TABLE="PETITION";
			$RECORD_TABLE="PETITION_CHANGE_RECORD";
		}
		
		//若要將文件狀態設為「被中選會拒收」或「喪失效力」
		IF($_POST['STATUS']=='voided'||$_POST['STATUS']=='refused')
		{
			$STAFF_ID="";
			IF($_POST['PASSWORD']=="")
			{
				$PROCESSING_RESULT.="設定狀態為「中選會拒收」或「失效」時，必須輸入密碼！";
			}
			ELSE
			{
				$QUERY_STRING="SELECT staff_id,nickname FROM STAFF_INFO WHERE NICKNAME='".$_POST['NICKNAME']."' AND PASSWORD=PASSWORD('".$_POST['PASSWORD']."')";
			}
		}
		//若不是要將文件狀態設為「被中選會拒收」或「喪失效力」，且表單內沒有 STAFF_ID 資料 (STAFF)
		ELSE IF(($_POST['NICKNAME']!=$_POST['CURRENT_USER'])||$_POST['STAFF']=="")
		{
			$QUERY_STRING="SELECT staff_id,nickname FROM STAFF_INFO WHERE NICKNAME='".$_POST['NICKNAME']."' AND PASSWORD=PASSWORD('".$_POST['PASSWORD']."')";
			$_POST['CURRENT_USER']="";
		}
		//若不是要將文件狀態設為「被中選會拒收」或「喪失效力」，且表單內已經有 STAFF_ID 資料 (STAFF)
		ELSE IF($_POST['STAFF']!="")
		{
			$STAFF_ID=$_POST['STAFF'];
		}
		
		//取得 STAFF_ID 資料
		$PROCESSOR="";
		IF($QUERY_STRING!="")
		{
			IF($RESULT=MYSQL_QUERY($QUERY_STRING))
			{
				IF(MYSQL_NUM_ROWS($RESULT)==1)
				{
					$DATA=MYSQL_FETCH_ARRAY($RESULT);
					$STAFF_ID=$DATA['staff_id'];
					$_POST['NICKNAME']=$DATA['nickname'];
					$_POST['CURRENT_USER']=$_POST['NICKNAME'];
				}
				ELSE
				{
					$_POST['NICKNAME']="";
					$PROCESSOR="<SPAN STYLE='COLOR:RED'>無此文件處理人</SPAN><BR>";
				}
			}
		}
		
		//輸入文件狀態更新紀錄
		IF($STAFF_ID!="")
		{
			FOR($SEED=0;$SEED<10;$SEED++)
			{
				IF($_POST['"SNO_".$SEED']!="")
				{
					$SNO=$_POST['"SNO_".$SEED'];
					$IDL5=$_POST['"IDL5_".$SEED'];
					$PROCESSING_RESULT.="<BR>AP<FONT COLOR=BLUE>".SPRINTF("%02d",$_POST['DISTRICT_ID'])."</FONT><FONT COLOR=RED>".$_POST['DOCTYPE']."</FONT>".SPRINTF("%06d",$SNO)."<BR>";
					ECHO $QUERY_STRING="INSERT INTO ".$RECORD_TABLE."(".$MAIN_TABLE."_ID,STATUS_CHANGED_TO,STAFF_ID)VALUES('".$SNO."','".$STATUS."','".$STAFF_ID."')";
					IF(MYSQL_QUERY($QUERY_STRING))
					{
						IF($IDL5==""||STRLEN($IDL5)!=5)
						{
							$PROCESSING_RESULT.="必須輸入";
							IF($_POST['DOCTYPE']==1)
								$PROCESSING_RESULT.="提議";
							ELSE
								$PROCESSING_RESULT.="連署";
							$PROCESSING_RESULT.="人的身分證字號後五碼<BR>";
							$QUERY_STRING="";
						}
						ELSE
						{
							$RECORD_ID=MYSQL_INSERT_ID();
							$QUERY_STRING="SELECT id_last_five FROM ".$MAIN_TABLE." WHERE ".$MAIN_TABLE."_ID='".$SNO."'";
							$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
							IF($DATA['id_last_five']=="")
							{
								//更新文件狀態
								$QUERY_STRING="UPDATE ".$MAIN_TABLE." SET CURRENT_STATUS='".$STATUS."',ID_LAST_FIVE='".$IDL5."' WHERE ".$MAIN_TABLE."_ID='".$SNO."'";
							}
							ELSE
							{
								//更新文件狀態並儲存身分證字號後五碼
								$QUERY_STRING="UPDATE ".$MAIN_TABLE." SET CURRENT_STATUS='".$STATUS."' WHERE ".$MAIN_TABLE."_ID='".$SNO."' AND ID_LAST_FIVE='".$IDL5."'";
							}
							IF($QUERY_STRING!="")
							{
								IF(MYSQL_QUERY($QUERY_STRING))
								{
									IF(MYSQL_AFFECTED_ROWS()==1)
									{
										$QUERY_STRING="UPDATE ".$RECORD_TABLE." SET SUCCEED='1' WHERE ".$RECORD_TABLE."_ID='".$RECORD_ID."'";
										MYSQL_QUERY($QUERY_STRING);
										$PROCESSING_RESULT.="成功更新<BR>";
									}
									ELSE
									{
										$PROCESSING_RESULT.="資料已更新，未變動<BR>";
											
									}
								}
								ELSE
								{
									$PROCESSING_RESULT.="更新失敗<BR>";
								}
							}
							ELSE
							{
								$PROCESSING_RESULT.="更新失敗<BR>";
							}
						}
					}
				}
			}
		}
}

	
ECHO "
	<CENTER>
	<BR>
	<FORM ACTION=processing_form.php?ACT=GO METHOD=POST>
	<TABLE BORDER=0>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:20;BACKGROUND-COLOR:#BBBBBB' COLSPAN=";
	IF($_GET['ACT']=="GO")
	{
		ECHO "3";
		ECHO " ALIGN=CENTER>罷免相關文件處理系統</TD></TR>
		<TR><TD><BR>";
	}
	ELSE
	{
		ECHO "1";
		ECHO " ALIGN=CENTER>罷免相關文件處理系統</TD></TR>
		<TR><TD>";
	}
	ECHO "
	<TABLE BORDER=0 STYLE='BACKGROUND-COLOR:#FFFFFF;WIDTH:100%' CELLSPACING=3>
	<TR STYLE='TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:20;BACKGROUND-COLOR:#DDDDDD'><TD COLSPAN=4 ALIGN=CENTER>待處理文件資料</TD></TR>
	<TR><TD STYLE='WIDTH:150;TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:16;BACKGROUND-COLOR:#EEEEEE'>文件處理人代號</TD>
	<TD STYLE='TEXT-ALIGN:CENTER;FONT-SIZE:16'><INPUT TYPE=HIDDEN NAME=NICKNAME VALUE='".$_SESSION['NICKNAME']."'>".$_SESSION['NICKNAME']."<INPUT TYPE=HIDDEN ID=STAFF NAME=STAFF VALUE='".$_SESSION['SID']."'></TD>
	<TD STYLE='WIDTH:150;TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#EEEEEE'>密　　　　　碼</TD><TD ALIGN=CENTER><INPUT NAME=PASSWORD TYPE=PASSWORD STYLE='WIDTH:150;FONT-SIZE:16;HEIGHT:30'>";
	ECHO "<DIV ID='PWDWARNING' STYLE='FONT-SIZE:12;COLOR:RED;DISPLAY:NONE'>(請輸入密碼)</DIV>";
	ECHO "</TD></TR>
	<TR><TD STYLE='WIDTH:150;TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:16;BACKGROUND-COLOR:#EEEEEE'>罷　免　對　象</TD><TD>";
	IF($_SESSION['DISTRICT_ID']!="")
		$QUERY_STRING="SELECT * FROM DISTRICT_DATA WHERE DISTRICT_ID='".$_SESSION['DISTRICT_ID']."'";
	ELSE
		$QUERY_STRING="SELECT * FROM DISTRICT_DATA";
	$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
	IF($NO_OF_DATA>0)
	{
		ECHO "<SELECT NAME=DISTRICT_ID STYLE='HEIGHT:30;FONT-SIZE:16;WIDTH:200' ONCHANGE=change_district()>";
		IF($NO_OF_DATA>1)
			ECHO "<OPTION VALUE='0'>請選擇罷免對象</OPTION>";
		FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			ECHO "<OPTION VALUE='".$DATA['district_id']."' ";
			IF($_POST['DISTRICT_ID']==$DATA['district_id'])
			{
				ECHO "SELECTED";
				$CURRENT_LEGISLATOR=$DATA['district_name']."．".$DATA['district_legislator'];
			}
			ECHO ">".$DATA['district_name']."．".$DATA['district_legislator']."</OPTION>";
		}
		ECHO "</SELECT>";
	}
	ECHO "</TD><TD STYLE='WIDTH:150;TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:16;BACKGROUND-COLOR:#EEEEEE'>文　件　類　別</TD><TD>";
	IF($_POST['DOCTYPE']==1)
	{
		ECHO "
		<INPUT TYPE=RADIO NAME=DOCTYPE VALUE='1' CHECKED ONCLICK=change_doctype()>提議書
		<INPUT TYPE=RADIO NAME=DOCTYPE VALUE='2' ONCLICK=change_doctype()>連署書";
	}
	ELSE IF($_POST['DOCTYPE']==2)
	{
		ECHO "
		<INPUT TYPE=RADIO NAME=DOCTYPE VALUE='1' ONCLICK=change_doctype()>提議書
		<INPUT TYPE=RADIO NAME=DOCTYPE VALUE='2' CHECKED ONCLICK=change_doctype()>連署書";
	}
	ELSE
	{
		ECHO "
		<INPUT TYPE=RADIO NAME=DOCTYPE VALUE='1' ONCLICK=change_doctype()>提議書
		<INPUT TYPE=RADIO NAME=DOCTYPE VALUE='2' ONCLICK=change_doctype()>連署書";
	}
	IF($_SESSION['DISTRICT_ID']=="")
		$DID="00";
	ELSE
		$DID=SPRINTF("%02d",$_SESSION['DISTRICT_ID']);
	ECHO "
	</TD></TR>
	<TR><TD STYLE='WIDTH:150;TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:16;BACKGROUND-COLOR:#EEEEEE'>設定文件狀態為</TD><TD COLSPAN=3>
		<INPUT TYPE=RADIO NAME=STATUS VALUE='received'";
		IF($_POST['STATUS']=='received')
			ECHO " CHECKED";
		ECHO " ONCLICK=check_status()>已收到
		<INPUT TYPE=RADIO NAME=STATUS VALUE='sent'";
		IF($_POST['STATUS']=='sent')
			ECHO " CHECKED";
		ECHO " ONCLICK=check_status()>已送出
		<INPUT TYPE=RADIO NAME=STATUS VALUE='refused'";
		IF($_POST['STATUS']=='refused')
			ECHO " CHECKED";
		ECHO " ONCLICK=check_status()>被中選會拒收
		<INPUT TYPE=RADIO NAME=STATUS VALUE='voided'";
		IF($_POST['STATUS']=='voided')
			ECHO " CHECKED";
		ECHO " ONCLICK=check_status()>喪失效力
	</TD></TR>
	<TR STYLE='TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:16;BACKGROUND-COLOR:#EEEEEE'><TD>文　件　內　容</TD><TD STYLE='TEXT-ALIGN:CENTER;'>流水號&nbsp;<SPAN STYLE='FONT-SIZE:14;COLOR:'>補零部分不必輸入<BR>(如 AP<SPAN ID=DISTEXP STYLE='COLOR:BLUE'>".$DID."</SPAN><SPAN ID=DTYPEEXP STYLE='COLOR:RED'>1</SPAN>00133 輸入 133 即可)</SPAN></TD><TD>身分證後五碼<BR><SPAN STYLE='FONT-SIZE:12;COLOR:RED'>（用於確認是否有重複資料）</SPAN></TD>
	<TD ROWSPAN=11 STYLE=';BACKGROUND-COLOR:#EEEEEE'><INPUT TYPE=SUBMIT VALUE='送出' STYLE='FONT-SIZE:20'></TD>
		</TR>";
	FOR($SEED=0;$SEED<10;$SEED++)
	{
		ECHO "
		<TR ALIGN=CENTER>
				<TD ALIGN=CENTER STYLE='WIDTH:30;BACKGROUND-COLOR:#EEEEFF'>".($SEED+1)."</TD>
				<TD>AP<SPAN ID=DISTRICT_IDDIV_".$SEED." STYLE='COLOR:BLUE'>".$DID."</SPAN><SPAN ID=DOCTYPE_".$SEED." STYLE='COLOR:RED'>1</SPAN><INPUT TYPE=TEXT NAME=SNO_".$SEED." STYLE='WIDTH:150;FONT-SIZE:16'></TD><TD><INPUT TYPE=TEXT NAME=IDL5_".$SEED." STYLE='WIDTH:150;FONT-SIZE:16'></TD></TR>";
	}
	ECHO "
	
	</TABLE></FORM></TD>";
	IF($_GET['ACT']=="GO")
	{
		ECHO "
			<TD>&nbsp;&nbsp;&nbsp;</TD><TD STYLE='VERTICAL-ALIGN:TOP'><BR>
			<TABLE BORDER=0 STYLE='BACKGROUND-COLOR:#EEEEEE;WIDTH:200' CELLSPACING=3>";
			ECHO "<TR STYLE='TEXT-ALIGN:CENTER'><TD><INPUT TYPE=BUTTON ONCLICK=location.href='processing_system.php' VALUE='登出' STYLE='FONT-SIZE:16;WIDTH:150'><BR></TD></TR>";
			ECHO "<TR STYLE='TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:20;BACKGROUND-COLOR:#DDDDDD'><TD COLSPAN=4 ALIGN=CENTER>目前文件處理人</TD></TR>";
			IF($STAFF_ID!="")
			{
				ECHO "<TR><TD ALIGN=CENTER><BR>".$_POST['CURRENT_USER']."<BR><SPAN STYLE='FONT-SIZE:12;COLOR:RED;'>(若要變更請登出後重新登入)</SPAN><BR><BR></TD></TR>";
			}
			ELSE
			{
				IF($_SESSION['NICKNAME']!="")
					ECHO "<TR><TD ALIGN=CENTER><BR>".$_SESSION['NICKNAME']."<BR><SPAN STYLE='FONT-SIZE:12;COLOR:RED;'>(若要變更請登出後重新登入)</SPAN><BR><BR></TD></TR>";
				ELSE
					ECHO "<TR><TD ALIGN=CENTER><BR>".$PROCESSOR."目前無處理人<BR><BR></TD></TR>";
			}
		ECHO "
			<TR STYLE='TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:20;BACKGROUND-COLOR:#DDDDDD'><TD COLSPAN=4 ALIGN=CENTER>文件處理結果</TD></TR>
			<TR><TD ALIGN=CENTER>".$PROCESSING_RESULT."<BR><BR></TD></TR>
			</TABLE>
			</TD>";
	}
	ECHO "</TR>";
	IF($_POST['DISTRICT_ID']!="")
	{
		$DISTRICT_ID=$_POST['DISTRICT_ID'];
	 	$QUERY_STRING="SELECT CURRENT_STATUS,COUNT(CURRENT_STATUS) AS COUNTS FROM proposal WHERE DISTRICT_ID='".$DISTRICT_ID."' AND id_last_five IS NOT NULL GROUP BY CURRENT_STATUS";
		$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
		IF($NO_OF_DATA>0)
		{
			$PRO['created']=$PRO['received']=$PRO['sent']=$PRO['refused']=$PRO['voided']=0;
			FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
			{
				$S_DATA=MYSQL_FETCH_ARRAY($RESULT);
				$PRO[$S_DATA['CURRENT_STATUS']]=$S_DATA['COUNTS'];
				$PRO['total']+=$S_DATA['COUNTS'];
			}
		}
		$QUERY_STRING="SELECT DISTRICT_ID,ID_LAST_FIVE,COUNT(ID_LAST_FIVE) AS COUNTS FROM proposal WHERE DISTRICT_ID='".$DISTRICT_ID."' AND id_last_five is not null GROUP BY DISTRICT_ID,ID_LAST_FIVE HAVING COUNTS>1";
		$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
		IF($NO_OF_DATA>0)
		{
			FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
			{
				$S_DATA=MYSQL_FETCH_ARRAY($RESULT);
				$PRO['rep_total']+=$S_DATA['COUNTS'];
			}
			$PRO['rep_total']-=$NO_OF_DATA;
		}		
		
		$QUERY_STRING="SELECT CURRENT_STATUS,COUNT(CURRENT_STATUS) AS COUNTS FROM petition WHERE DISTRICT_ID='".$DISTRICT_ID."' AND id_last_five IS NOT NULL GROUP BY CURRENT_STATUS";
		$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
		IF($NO_OF_DATA>0)
		{
			$PET['created']=$PET['received']=$PET['sent']=$PET['refused']=$PET['voided']=0;
			FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
			{
				$S_DATA=MYSQL_FETCH_ARRAY($RESULT);
				$PET[$S_DATA['CURRENT_STATUS']]=$S_DATA['COUNTS'];
				$PET['total']+=$S_DATA['COUNTS'];
			}
		}
		$QUERY_STRING="SELECT DISTRICT_ID,ID_LAST_FIVE,COUNT(ID_LAST_FIVE) AS COUNTS FROM petition WHERE DISTRICT_ID='".$DISTRICT_ID."' AND id_last_five is not null GROUP BY DISTRICT_ID,ID_LAST_FIVE HAVING COUNTS>1";
		$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
		IF($NO_OF_DATA>0)
		{
			FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
			{
				$S_DATA=MYSQL_FETCH_ARRAY($RESULT);
				$PET['rep_total']+=$S_DATA['COUNTS'];
			}
			$PET['rep_total']-=$NO_OF_DATA;
		}
		
		IF($PRO['total']>0||$PET['total']>0)
		{
			ECHO "
			<TR STYLE='TEXT-ALIGN:CENTER;HEIGHT:30;FONT-SIZE:20;BACKGROUND-COLOR:#DDDDDD'><TD COLSPAN=3>".$CURRENT_LEGISLATOR."罷免文書統計數據</TD></TR>
			<TR><TD COLSPAN=3>
				<TABLE BORDER=0 WIDTH=100%>
				<TR ALIGN=CENTER><TD COLSPAN=6></TD></TR>
				<TR ALIGN=CENTER STYLE='BACKGROUND-COLOR:#CCCCCC;WIDTH:80'><TD ROWSPAN=2>項目</TD><TD COLSPAN=2>已產製文書</TD><TD COLSPAN=2>已寄達文書</TD><TD COLSPAN=2>未寄達文書</TD><TD COLSPAN=2>寄至中選會</TD><TD COLSPAN=2>中選會退回</TD><TD COLSPAN=2>無效文書</TD><TD COLSPAN=2>疑似重複</TD></TR>
				<TR ALIGN=CENTER><TD STYLE='BACKGROUND-COLOR:#DDDDDD;WIDTH:60'>數量</TD><TD STYLE='BACKGROUND-COLOR:#EEEEEE;WIDTH:50'>比例</TD><TD STYLE='BACKGROUND-COLOR:#DDDDDD;WIDTH:60'>數量</TD><TD STYLE='BACKGROUND-COLOR:#EEEEEE;WIDTH:50'>比例</TD><TD STYLE='BACKGROUND-COLOR:#DDDDDD;WIDTH:60'>數量</TD><TD STYLE='BACKGROUND-COLOR:#EEEEEE;WIDTH:50'>比例</TD><TD STYLE='BACKGROUND-COLOR:#DDDDDD;WIDTH:60'>數量</TD><TD STYLE='BACKGROUND-COLOR:#EEEEEE;WIDTH:50'>比例</TD><TD STYLE='BACKGROUND-COLOR:#DDDDDD;WIDTH:60'>數量</TD><TD STYLE='BACKGROUND-COLOR:#EEEEEE;WIDTH:50'>比例</TD><TD STYLE='BACKGROUND-COLOR:#DDDDDD;WIDTH:60'>數量</TD><TD STYLE='BACKGROUND-COLOR:#EEEEEE;WIDTH:50'>比例</TD><TD STYLE='BACKGROUND-COLOR:#DDDDDD;WIDTH:60'>數量</TD><TD STYLE='BACKGROUND-COLOR:#EEEEEE;WIDTH:50'>比例</TD></TR>";
			IF($PRO['total']>0)
			{
				$Received=$PRO['received']+$PRO['sent']+$PRO['refused']+$PRO['voided'];
				$ToBeRecevied=$PRO['total']-$Received;
				ECHO "
				<TR ALIGN=CENTER><TD STYLE='BACKGROUND-COLOR:#DDDDDD'>提議書</TD>
					<TD>".$PRO['total']."</TD><TD>100%</TD>
					<TD STYLE='COLOR:GREEN'>".$Received."</TD><TD STYLE='COLOR:GREEN'>".SPRINTF("%0.2f",($Received/$PRO['total'])*100)."%</TD>
					<TD STYLE='COLOR:RED'>".$ToBeRecevied."</TD><TD STYLE='COLOR:RED'>".SPRINTF("%0.2f",($ToBeRecevied/$PRO['total'])*100)."%</TD>
					<TD>".$PRO['sent']."</TD><TD>".SPRINTF("%0.2f",($PRO['sent']/$PRO['total'])*100)."%</TD>
					<TD>".$PRO['refused']."</TD><TD>".SPRINTF("%0.2f",($PRO['refused']/$PRO['total'])*100)."%</TD>
					<TD>".$PRO['voided']."</TD><TD>".SPRINTF("%0.2f",($PRO['voided']/$PRO['total'])*100)."%</TD>
					<TD>".$PRO['rep_total']."</TD><TD>".SPRINTF("%0.2f",($PRO['rep_total']/$PRO['total'])*100)."%</TD>
				</TR>";
			}
			IF($PET['total']>0)
			{
				$Received=$PET['received']+$PET['sent']+$PET['refused']+$PET['voided'];
				$ToBeRecevied=$PET['total']-$Received;
				ECHO "
				<TR ALIGN=CENTER><TD STYLE='BACKGROUND-COLOR:#DDDDDD'>連署書</TD>
					<TD>".$PET['total']."</TD><TD>100%</TD>
					<TD STYLE='COLOR:GREEN'>".$Received."</TD><TD STYLE='COLOR:GREEN'>".SPRINTF("%0.2f",($Received/$PET['total'])*100)."%</TD>
					<TD STYLE='COLOR:RED'>".$ToBeRecevied."</TD><TD STYLE='COLOR:RED'>".SPRINTF("%0.2f",($ToBeRecevied/$PET['total'])*100)."%</TD>
					<TD>".$PET['sent']."</TD><TD>".SPRINTF("%0.2f",($PET['sent']/$PET['total'])*100)."%</TD>
					<TD>".$PET['refused']."</TD><TD>".SPRINTF("%0.2f",($PET['refused']/$PET['total'])*100)."%</TD>
					<TD>".$PET['voided']."</TD><TD>".SPRINTF("%0.2f",($PET['voided']/$PET['total'])*100)."%</TD>
					<TD>".$PET['rep_total']."</TD><TD>".SPRINTF("%0.2f",($PET['rep_total']/$PET['total'])*100)."%</TD>
				</TR>";
			}
			ECHO "
				</TABLE>
			</TD></TR>";
		}
	}
	ECHO "
	</TABLE>
	</CENTER>";

?>
</FORM>

<SCRIPT>
function initial()
{
/*	var radios = document.getElementsByName('DOCTYPE');
	for (var j = 0; j < radios.length; j++) {
    	if (radios['j'].type === 'radio' && radios['j'].checked) {
       	document.getElementById('DOCTYPE').innerHTML = radios['j'].value;
       	}
    }*/
    change_doctype();
    change_district();
    if(document.getElementById('STAFF').value=='')
    	show_warning('1');
}
function  change_doctype()
{
	var radios = document.getElementsByName('DOCTYPE');
	for (var j = 0; j < radios.length; j++) {
    	if (radios['j'].type === 'radio' && radios['j'].checked) {
    		for(var i=0;i<10;i++)
    		{
    			idpin='DOCTYPE_'+i;
		       	document.getElementById(idpin).innerHTML = radios['j'].value;
		    }
       	document.getElementById('DTYPEEXP').innerHTML = radios['j'].value;
       	}
    }
}
function check_status()
{
	var radios = document.getElementsByName('STATUS');
	for (var j = 0; j < radios.length; j++) {
    	if (radios['j'].type === 'radio' && radios['j'].checked) {
			if(radios['j'].value=='refused'||radios['j'].value=='voided')
			{
				show_warning('1');
				return true;
			}
			else
				show_warning('0');
       	}
    }
}

function change_district()
{
	var distid=document.getElementsByName('DISTRICT_ID')['0'].value;
	if(distid.length==1)
		distid='0'+distid;
	for(var i=0;i<10;i++)
	{
    	idpin='DISTRICT_IDDIV_'+i;
	   	document.getElementById(idpin).innerHTML = distid;
	}
   	document.getElementById('DISTEXP').innerHTML = distid;
}
function show_warning(pin)
{
	if(pin=='1')
	{
		document.getElementById('PWDWARNING').style.display='';
	}
	else
	{
		document.getElementById('PWDWARNING').style.display='none';
	}
}

</SCRIPT>

</body>
</html>
