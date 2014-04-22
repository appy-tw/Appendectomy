<body>

<?php
	ECHO "<FORM NAME=TRANSFER ACTION='' METHOD=POST TARGET=pdfframe>";
	while($element = current($_POST)) {
    echo "<INPUT TYPE=HIDDEN NAME=".key($_POST)." VALUE='".$_POST[key($_POST)]."'>";
    next($_POST);
	}
	ECHO "</FORM>";
?>

<center>
<br>
<FORM NAME=CREATESTICKER ACTION='' METHOD=POST TARGET=pdfframe>
<TABLE BORDER=0>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#EEEEEE' COLSPAN=2>產生標籤／連署．提議文書</TD></TR>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:60'>選區</TD><TD>
	<SELECT NAME=DISTRICT_ID STYLE='WIDTH:300;HEIGHT:30;FONT-SIZE:16'><OPTION VALUE='1'>山地原住民．孔文吉．中國國民黨)</OPTION><OPTION VALUE='2'>山地原住民．高金素梅．無黨團結聯盟)</OPTION><OPTION VALUE='3'>山地原住民．簡東明．中國國民黨)</OPTION><OPTION VALUE='4'>平地原住民．廖國棟．中國國民黨)</OPTION><OPTION VALUE='5'>平地原住民．鄭天財．中國國民黨)</OPTION><OPTION VALUE='6'>宜蘭縣選區．陳歐珀．民主進步黨)</OPTION><OPTION VALUE='7'>花蓮縣選區．王廷升．中國國民黨)</OPTION><OPTION VALUE='8'>金門縣選區．楊應雄．中國國民黨)</OPTION><OPTION VALUE='9'>南投縣第01選區．馬文君．中國國民黨)</OPTION><OPTION VALUE='10'>南投縣第02選區．林明溱．中國國民黨)</OPTION><OPTION VALUE='11'>屏東縣第01選區．蘇震清．民主進步黨)</OPTION><OPTION VALUE='12'>屏東縣第02選區．王進士．中國國民黨)</OPTION><OPTION VALUE='13'>屏東縣第03選區．潘孟安．民主進步黨)</OPTION><OPTION VALUE='14'>苗栗縣第01選區．陳超明．中國國民黨)</OPTION><OPTION VALUE='15'>苗栗縣第02選區．徐耀昌．中國國民黨)</OPTION><OPTION VALUE='16'>桃園縣第01選區．陳根德．中國國民黨)</OPTION><OPTION VALUE='17'>桃園縣第02選區．廖正井．中國國民黨)</OPTION><OPTION VALUE='18'>桃園縣第03選區．陳學聖．中國國民黨)</OPTION><OPTION VALUE='19'>桃園縣第04選區．楊麗環．中國國民黨)</OPTION><OPTION VALUE='20'>桃園縣第05選區．呂玉玲．中國國民黨)</OPTION><OPTION VALUE='21'>桃園縣第06選區．孫大千．中國國民黨)</OPTION><OPTION VALUE='22'>高雄市第01選區．邱議瑩．民主進步黨)</OPTION><OPTION VALUE='23'>高雄市第02選區．邱志偉．民主進步黨)</OPTION><OPTION VALUE='24'>高雄市第03選區．黃昭順．中國國民黨)</OPTION><OPTION VALUE='25'>高雄市第04選區．林岱樺．民主進步黨)</OPTION><OPTION VALUE='26'>高雄市第05選區．管碧玲．民主進步黨)</OPTION><OPTION VALUE='27'>高雄市第06選區．李昆澤．民主進步黨)</OPTION><OPTION VALUE='28'>高雄市第07選區．趙天麟．民主進步黨)</OPTION><OPTION VALUE='29'>高雄市第08選區．許智傑．民主進步黨)</OPTION><OPTION VALUE='30'>高雄市第09選區．林國正．中國國民黨)</OPTION><OPTION VALUE='31'>基隆市選區．謝國樑．中國國民黨)</OPTION><OPTION VALUE='32'>連江縣選區．陳雪生．無黨籍)</OPTION><OPTION VALUE='33'>雲林縣第01選區．張嘉郡．中國國民黨)</OPTION><OPTION VALUE='34'>雲林縣第02選區．劉建國．民主進步黨)</OPTION><OPTION VALUE='35'>新北市第01選區．吳育昇．中國國民黨)</OPTION><OPTION VALUE='36'>新北市第02選區．林淑芬．民主進步黨)</OPTION><OPTION VALUE='37'>新北市第03選區．高志鵬．民主進步黨)</OPTION><OPTION VALUE='38'>新北市第04選區．李鴻鈞．中國國民黨)</OPTION><OPTION VALUE='39'>新北市第05選區．黃志雄．中國國民黨)</OPTION><OPTION VALUE='40'>新北市第06選區．林鴻池．中國國民黨)</OPTION><OPTION VALUE='41'>新北市第07選區．江惠貞．中國國民黨)</OPTION><OPTION VALUE='42'>新北市第08選區．張慶忠．中國國民黨)</OPTION><OPTION VALUE='43'>新北市第09選區．林德福．中國國民黨)</OPTION><OPTION VALUE='44'>新北市第10選區．盧嘉辰．中國國民黨)</OPTION><OPTION VALUE='45'>新北市第11選區．羅明才．中國國民黨)</OPTION><OPTION VALUE='46'>新北市第12選區．李慶華．中國國民黨)</OPTION><OPTION VALUE='47'>新竹市選區．呂學樟．中國國民黨)</OPTION><OPTION VALUE='48'>新竹縣選區．徐欣瑩．中國國民黨)</OPTION><OPTION VALUE='49'>僑居國外國民．詹凱臣．中國國民黨)</OPTION><OPTION VALUE='50'>嘉義市選區．李俊俋．民主進步黨)</OPTION><OPTION VALUE='51'>嘉義縣第01選區．翁重鈞．中國國民黨)</OPTION><OPTION VALUE='52'>嘉義縣第02選區．陳明文．民主進步黨)</OPTION><OPTION VALUE='53'>彰化縣第01選區．王惠美．中國國民黨)</OPTION><OPTION VALUE='54'>彰化縣第02選區．林滄敏．中國國民黨)</OPTION><OPTION VALUE='55'>彰化縣第03選區．鄭汝芬．中國國民黨)</OPTION><OPTION VALUE='56'>彰化縣第04選區．魏明谷．民主進步黨)</OPTION><OPTION VALUE='57'>臺中市第01選區．蔡其昌．民主進步黨)</OPTION><OPTION VALUE='58'>臺中市第02選區．顏寬恒．中國國民黨)</OPTION><OPTION VALUE='59'>臺中市第03選區．楊瓊瓔．中國國民黨)</OPTION><OPTION VALUE='60'>臺中市第04選區．蔡錦隆．中國國民黨)</OPTION><OPTION VALUE='61'>臺中市第05選區．盧秀燕．中國國民黨)</OPTION><OPTION VALUE='62'>臺中市第06選區．林佳龍．民主進步黨)</OPTION><OPTION VALUE='63'>臺中市第07選區．何欣純．民主進步黨)</OPTION><OPTION VALUE='64'>臺中市第08選區．江啟臣．中國國民黨)</OPTION><OPTION VALUE='65'>臺北市第01選區．丁守中．中國國民黨)</OPTION><OPTION VALUE='66'>臺北市第02選區．姚文智．民主進步黨)</OPTION><OPTION VALUE='67'>臺北市第03選區．羅淑蕾．中國國民黨)</OPTION><OPTION VALUE='68'>臺北市第04選區．蔡正元．中國國民黨)</OPTION><OPTION VALUE='69'>臺北市第05選區．林郁方．中國國民黨)</OPTION><OPTION VALUE='70'>臺北市第06選區．蔣乃辛．中國國民黨)</OPTION><OPTION VALUE='71'>臺北市第07選區．費鴻泰．中國國民黨)</OPTION><OPTION VALUE='72'>臺北市第08選區．賴士葆．中國國民黨)</OPTION><OPTION VALUE='73'>臺東縣選區．劉櫂豪．民主進步黨)</OPTION><OPTION VALUE='74'>臺南市第01選區．葉宜津．民主進步黨)</OPTION><OPTION VALUE='75'>臺南市第02選區．黃偉哲．民主進步黨)</OPTION><OPTION VALUE='76'>臺南市第03選區．陳亭妃．民主進步黨)</OPTION><OPTION VALUE='77'>臺南市第04選區．許添財．民主進步黨)</OPTION><OPTION VALUE='78'>臺南市第05選區．陳唐山．民主進步黨)</OPTION><OPTION VALUE='79'>澎湖縣選區．楊曜．民主進步黨)</OPTION></SELECT>
	</TD></TR>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:100'>文書</TD><TD>
		<INPUT ID=BUTPR TYPE=BUTTON VALUE='產生空白提議書' ONCLICK="gen_blank_proposal();" STYLE='FONT-SIZE:16'>
		<INPUT ID=BUTPA TYPE=BUTTON VALUE='產生空白連署書' ONCLICK="gen_blank_petition();" STYLE='FONT-SIZE:16'></TD></TR>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDFF;FONT-SIZE:16;WIDTH:100' ROWSPAN=2>標籤</TD><TD>
		<INPUT ID=BUTPR TYPE=BUTTON VALUE='產生提議書標籤' ONCLICK="gen_proposal_sticker();" STYLE='FONT-SIZE:16'>
		<INPUT ID=BUTPA TYPE=BUTTON VALUE='產生連署書標籤' ONCLICK="gen_petition_sticker();" STYLE='FONT-SIZE:16'></TD></TR>
	<TR><TD>
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
	</TD></TR>
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
	window.frames["pdfframe"].focus();
	window.frames["pdfframe"].print();
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
