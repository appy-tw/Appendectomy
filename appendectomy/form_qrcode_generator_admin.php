<?php
	SESSION_START();
php?>
<TITLE>空白提議書＆ＱＲ條碼產生器</TITLE>
<body>

<?php
	require_once "inc/sql.php";
	connect_valid();
	
	ECHO "<FORM NAME=TRANSFER ACTION='' METHOD=POST TARGET=pdfframe>";
	while($element = current($_POST)) {
    echo "<INPUT TYPE=HIDDEN NAME=".key($_POST)." VALUE='".$_POST['key($_POST)']."'>";
    next($_POST);
	}
	ECHO "</FORM>";
	IF($_GET['DDID']!="")
	{
		$QUERY_STRING="SELECT * FROM DISTRICT_DATA WHERE DISTRICT_ID='".$_GET['DDID']."'";
		IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
	}
?>

<center>
<br>
<FORM NAME=CREATESTICKER ACTION='' METHOD=POST TARGET=pdfframe>
<TABLE BORDER=0>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#EEEEEE' COLSPAN=7>產生流水號標籤／產生空白連署．提議文書／設定連署．提議文書樣版</TD></TR>
	<TR>
	<TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:80'>選區</TD><TD>
	<SELECT NAME=DISTRICT_ID STYLE='WIDTH:300;HEIGHT:30;FONT-SIZE:16'>
	<?php
	IF($_SESSION['LEVEL']=='admin')
		$QUERY_STRING="SELECT * FROM DISTRICT_DATA";
	ELSE
		$QUERY_STRING="SELECT * FROM DISTRICT_DATA WHERE DISTRICT_ID='".$_SESSION['DISTRICT_ID']."'";
		$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
		IF($NO_OF_DATA>0)
		{
			FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
			{
				$DDATA=MYSQL_FETCH_ARRAY($RESULT);
				ECHO "<OPTION VALUE='".$DDATA['district_id']."' ";
				IF($DDATA['district_id']==$_GET['DDID'])
					ECHO "SELECTED";
				ECHO ">".$DDATA['district_name']."．".$DDATA['district_legislator']."．".$DDATA['party_name'].")</OPTION>";
			}
		}
	?>
	</SELECT></TD>
	<TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#FFDDDD;FONT-SIZE:16;WIDTH:20' ROWSPAN=6>郵<BR>寄<BR>資<BR>訊</TD>
	</TD>
		<TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:80'>廣告回函</TD><TD>
		<?php
			IF($DATA['prepaid']==1)
				ECHO "<INPUT TYPE=RADIO NAME=PREPAID VALUE='1' CHECKED>是<INPUT TYPE=RADIO NAME=PREPAID VALUE='0'>否";
			ELSE
				ECHO "<INPUT TYPE=RADIO NAME=PREPAID VALUE='1'>是<INPUT TYPE=RADIO NAME=PREPAID VALUE='0' CHECKED>否";
		?>
		</TD>
		<TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:60;WIDTH:80'>郵遞區號</TD><TD>
		<?php
			ECHO "<INPUT TYPE=TEXT NAME=ZIPCODE STYLE='WIDTH:60;FONT-SIZE:16;HEIGHT:30' VALUE='".$DATA['zipcode']."'>";
		?>
		</TD>
	</TR>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:80'>產生文書</TD><TD>
		<INPUT ID=BUTPR TYPE=BUTTON VALUE='產生空白提議書' ONCLICK="gen_blank_proposal();" STYLE='FONT-SIZE:16;WIDTH:145'>
		<INPUT ID=BUTPA TYPE=BUTTON VALUE='產生空白連署書' ONCLICK="gen_blank_petition();" STYLE='FONT-SIZE:16;WIDTH:145'>
			<BR>
		<INPUT ID=BUTPR TYPE=BUTTON VALUE='三格式空白提議書' ONCLICK="gen_3_blank_proposal();" STYLE='FONT-SIZE:16;WIDTH:145'>
		<INPUT ID=BUTPA TYPE=BUTTON VALUE='三格式空白連署書' ONCLICK="gen_3_blank_petition();" STYLE='FONT-SIZE:16;WIDTH:145'>
			</TD>
		<TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:80'>收件地址</TD><TD COLSPAN=3>
		<?php
			ECHO "<INPUT TYPE=TEXT NAME=ADDRESS STYLE='WIDTH:220;FONT-SIZE:16;HEIGHT:30' VALUE='".$DATA['mailing_address']."'>";
		?>
		</TD>
	</TR>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:100' ROWSPAN=2>產生標籤</TD><TD>
		<SELECT NAME=PNO STYLE='WIDTH:100;HEIGHT:30;FONT-SIZE:16'>
			<OPTION VALUE=1>1 頁</OPTION>
			<OPTION VALUE=2>2 頁</OPTION>
			<OPTION VALUE=3>3 頁</OPTION>
			<OPTION VALUE=4>4 頁</OPTION>
			<OPTION VALUE=5>5 頁</OPTION>
			<OPTION VALUE=6>6 頁</OPTION>
			<OPTION VALUE=7>7 頁</OPTION>
			<OPTION VALUE=8>8 頁</OPTION>
			<OPTION VALUE=9>9 頁</OPTION>
		</SELECT>（每頁有<FONT COLOR=RED>５４</FONT>張標籤）
		</TD>
		<TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:60'>收件人</TD><TD COLSPAN=3>
		<?php
			ECHO "<INPUT TYPE=TEXT NAME=RECEIVER STYLE='WIDTH:220;FONT-SIZE:16;HEIGHT:30' VALUE='".$DATA['receiver']."'>";
		?>
		</TD>
	</TR>
	<TR><TD>
		<INPUT ID=BUTPR TYPE=BUTTON VALUE='產生提議書標籤' ONCLICK="gen_proposal_sticker();" STYLE='FONT-SIZE:16;WIDTH:145'>
		<INPUT ID=BUTPA TYPE=BUTTON VALUE='產生連署書標籤' ONCLICK="gen_petition_sticker();" STYLE='FONT-SIZE:16;WIDTH:145'>
	</TD>
	<TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:60'>申請郵局</TD><TD COLSPAN=3>
	<?php
		ECHO "<INPUT TYPE=TEXT NAME=POSTOFFICE STYLE='WIDTH:220;FONT-SIZE:16;HEIGHT:30' VALUE='".$DATA['postoffice']."'>";
	?>
	</TD>
	</TR>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:100' ROWSPAN=2>圖檔網址</TD>
		<TD ROWSPAN=2>
	<?php
		ECHO "提議書<INPUT TYPE=TEXT NAME=ProDescImgPath STYLE='WIDTH:250;HEIGHT:30;FONT-SIZE:16' VALUE='".$DATA['prodescimgpath']."'><BR>
		連署書<INPUT TYPE=TEXT NAME=PetDescImgPath STYLE='WIDTH:250;HEIGHT:30;FONT-SIZE:16' VALUE='".$DATA['petdescimgpath']."'><BR>";
	?>
		（以 GIF/JPEG 檔為限，建議長寬比 2:1）</TD>
	<TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:60'>廣告字號</TD><TD COLSPAN=3>
	<?php
		ECHO "<INPUT TYPE=TEXT NAME=ADV_NO STYLE='WIDTH:220;FONT-SIZE:16;HEIGHT:30' VALUE='".$DATA['adv_no']."'>";
	?>
	</TD>
	</TR>
	<TR><TD COLSPAN=4下午 03:29 2014/4/12><INPUT ID=BUTPR TYPE=BUTTON VALUE='預覽＆設定
提議書樣版' ONCLICK="gen_blank_proposal();" STYLE='FONT-SIZE:16;WIDTH:150'>
	<INPUT ID=BUTPA TYPE=BUTTON VALUE='預覽＆設定
連署書樣版' ONCLICK="gen_blank_petition();" STYLE='FONT-SIZE:16;WIDTH:150'>
	</TD>
	</TR>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#EEEEEE' COLSPAN=2>
	</TR>
</TABLE>
</FORM>
<!--
<input type="button" id="btn_print" value="列印標籤" style="display:block;font-size:16" onclick="print_page();" disabled /><br>
-->

<iframe id="pdfframe" name="pdfframe" src="dummy_sticker.html" width="800" height="600" scrolling="auto">
</iframe>
</center>
<?php

?>

<script type="text/javascript">
function print_page() {
	window.frames['"pdfframe"'].focus();
	window.frames['"pdfframe"'].print();
	document.getElementById('BUTPR').disabled=false;
	document.getElementById('BUTPA').disabled=false;
}

function gen_blank_proposal(){
	document.CREATESTICKER.action="empty_proposal.php";
	document.CREATESTICKER.submit();
}

function gen_blank_petition(){
	document.CREATESTICKER.action="empty_petition.php";
	document.CREATESTICKER.submit();
}

function gen_3_blank_proposal(){
	document.CREATESTICKER.action="empty_3_proposal.php";
	document.CREATESTICKER.submit();
}

function gen_3_blank_petition(){
	document.CREATESTICKER.action="empty_3_petition.php";
	document.CREATESTICKER.submit();
}


function gen_proposal_sticker(){
	document.CREATESTICKER.action="proposal_sticker.php";
	document.CREATESTICKER.submit();
}

function gen_petition_sticker(){
	document.CREATESTICKER.action="petition_sticker.php";
	document.CREATESTICKER.submit();
}

</script>

</body>
</html>
