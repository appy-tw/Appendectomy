已移到application/controller/appy矣<br/>
// <?php
// 	require_once "inc/sql.php";
// 	connect_valid();
// 	ECHO "<CENTER><FORM NAME=DATAINPUT ACTION=proposalframe.php METHOD=POST>
// 	<TABLE BORDER=0 STYLE='FONT-SIZE:16'>
// 	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDDD'>填寫提議表單</TD></TR>
// 	<TR><TD><INPUT TYPE=HIDDEN ID=Size NAME=Size VALUE=1>
// 		<TABLE BORDER=0 WIDTH=100%>
// 		<TR><TD STYLE='WIDTH:80;TEXT-ALIGN:CENTER'>電子信箱</TD><TD><INPUT TYPE=TEXT NAME=EMAIL STYLE='WIDTH:300;FONT-SIZE:16'></TD>
// 			<TD STYLE='WIDTH:100;TEXT-ALIGN:CENTER;BORDER:2px solid #666666'>
// 				<SPAN STYLE='CURSOR:POINTER;' ONCLICK=ADDFORM()>增加份數</SPAN>
// 			</TD>
// 			<TD ALIGN=CENTER>
// 				<SPAN STYLE='CURSOR:POINTER;COLOR:BLACK'><IMG SRC='info.png' STYLE='WIDTH:20' ALT='可製作數份罷免相同立委的提議書' TITLE='可製作數份罷免相同立委的提議書'></SPAN>
// 			</TD>
// 		</TR>
// 		<TR><TD STYLE='WIDTH:80;TEXT-ALIGN:CENTER'>罷免對象</TD><TD COLSPAN=3>";
// 	$QUERY_STRING="SELECT * FROM DISTRICT_DATA";
// 	$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
// 	IF($NO_OF_DATA>0)
// 	{
// 		ECHO "<SELECT NAME=DISTRICT_ID STYLE='WIDTH:300;HEIGHT:30;FONT-SIZE:16'>";
// 		FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
// 		{
// 			$DATA=MYSQL_FETCH_ARRAY($RESULT);
// 			ECHO "<OPTION VALUE='".$DATA[district_id]."'>".$DATA[district_name]."．".$DATA[district_legislator]."．".$DATA[party_name].")</OPTION>";
// 		}
// 		ECHO "</SELECT>";
// 	}
// 	ECHO "</TD></TR>
// 		<TR><TD COLSPAN=4>
// 		<DIV ID=INPUTFORM>
// 			<DIV>
// 			<TABLE STYLE='BACKGROUND-COLOR:#DDDDDD'>
// 			<TR><TD STYLE='WIDTH:80;TEXT-ALIGN:CENTER'>1</TD>
// 				<TD>姓　　　名</TD><TD><INPUT TYPE=TEXT NAME=Name_0 STYLE='WIDTH:100;FONT-SIZE:16'></TD>
// 				<TD>身分證字號</TD><TD><INPUT TYPE=TEXT NAME=IDNo_0 STYLE='WIDTH:150;FONT-SIZE:16'></TD><TD><IMG SRC='info.png' STYLE='WIDTH:20;CURSOR:POINTER' ALT='請輸入半形英文數字' TITLE='請輸入半形英文數字'></TD></TR>
// 			<TR><TD></TD>
// 				<TD>性　　　別</TD><TD><INPUT TYPE=RADIO NAME=Sex_0 VALUE='M' CHECKED>男&nbsp;<INPUT TYPE=RADIO NAME=Sex_0 VALUE='F'>女</TD>
// 				<TD>出生年月日</TD><TD>";
// 			RETURN_Y("Birthday_y_0","WIDTH:80;FONT-SIZE:16",1984);
// 			RETURN_M("Birthday_m_0","WIDTH:60;FONT-SIZE:16",1);
// 			RETURN_D("Birthday_d_0","WIDTH:60;FONT-SIZE:16",1);
// 			ECHO "</TD><TD><IMG SRC='info.png' STYLE='WIDTH:20;CURSOR:POINTER' ALT='必須在 1992 年 1 月 13 日（含）以前才能提議或連署罷免' TITLE='必須在 1992 年 1 月 13 日（含）以前出生才能提議罷免'></TD></TR>
// 			<TR><TD></TD>
// 				<TD>職　　　業</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=Occupation_0 STYLE='WIDTH:100;FONT-SIZE:16'>（請勿超過４個字）</TD></TR>
// 			<TR><TD></TD>
// 				<TD>地　　　址</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=RegAdd_0 STYLE='WIDTH:400;FONT-SIZE:16'></TD></TR>
// 			<TR><TD></TD><TD></TD><TD COLSPAN=3><IMG SRC='info.png' STYLE='WIDTH:20'><SPAN STYLE='HEIGHT:20;VERTICAL-ALIGN:TOP'>&nbsp;請完全依身分證背後地址欄內容填寫，鄰里勿漏</SPAN></TD></TR>
// 			</TABLE>
// 			</DIV>
// 		</DIV>
// 		<HR>
// 		</TD></TR>
// 		</TABLE></TD></TR>
// 	<TR><TD ALIGN=CENTER><INPUT TYPE=BUTTON ONCLICK=checkInput() VALUE='製作提議書' STYLE='HEIGHT:30;FONT-SIZE:16'></TD></TR>
// 	</TABLE>
// 	</FORM>";
	
// 	FUNCTION RETURN_Y($NAME,$STYLE,$DEFAULT)
// 	{
// 		ECHO "<SELECT NAME='".$NAME."' STYLE='".$STYLE."'>";
// 		$START=date('Y');
// 		FOR($SEED=22;$SEED<120;$SEED++)
// 		{
// 			ECHO "<OPTION VALUE='".($START-$SEED)."' ";
// 			IF($SEED==$DEFAULT)
// 				ECHO "SELECTED";
// 			ECHO ">".($START-$SEED)." 年</OPTION>";
// 		}
// 		ECHO "</SELECT>";
// 	}
// 	FUNCTION RETURN_M($NAME,$STYLE,$DEFAULT)
// 	{
// 		ECHO "<SELECT NAME='".$NAME."' STYLE='".$STYLE."'>";
// 		FOR($SEED=1;$SEED<13;$SEED++)
// 		{
// 			ECHO "<OPTION VALUE='".$SEED."' ";
// 			IF($SEED==$DEFAULT)
// 				ECHO "SELECTED";
// 			ECHO ">".$SEED." 月</OPTION>";
// 		}
// 		ECHO "</SELECT>";
// 	}
// 	FUNCTION RETURN_D($NAME,$STYLE,$DEFAULT)
// 	{
// 		ECHO "<SELECT NAME='".$NAME."' STYLE='".$STYLE."'>";
// 		FOR($SEED=1;$SEED<32;$SEED++)
// 		{
// 			ECHO "<OPTION VALUE='".$SEED."' ";
// 			IF($SEED==$DEFAULT)
// 				ECHO "SELECTED";
// 			ECHO ">".$SEED." 日</OPTION>";
// 		}
// 		ECHO "</SELECT>";
// 	}
// php?>
<!-- <SCRIPT> -->
// //動態增加表單
// function ADDFORM()
// {
// 	var no=parseInt(document.getElementById('Size').value);
// 	document.getElementById('Size').value=no+1;
// 	if(no%2==0)
// 		bgcolor='#DDDDDD';
// 	else
// 		bgcolor='#FFFFFF';
// 	var nameArray=new Array();
// 	var idnoArray=new Array();
// 	var sexArray=new Array();
// 	var birthdayYArray=new Array();
// 	var birthdayMArray=new Array();
// 	var birthdayDArray=new Array();
// 	var occupationDArray=new Array();
// 	var regaddArray=new Array();
// 	var radios;
// 	for(i=0;i<no;i++)
// 	{
// 		nameArray[i]=document.getElementsByName('Name_'+i)[0].value;
// 		idnoArray[i]=document.getElementsByName('IDNo_'+i)[0].value;
// 		radios = document.getElementsByName('Sex_'+i);
// 		for (var j = 0; j < radios.length; j++) {
//     		if (radios[j].type === 'radio' && radios[j].checked) {
//         	// get value, set checked flag or do whatever you need to
//         	sexArray[i] = radios[j].value;
//         	}
//     	}
// 		birthdayYArray[i]=document.getElementsByName('Birthday_y_'+i)[0].value;
// 		birthdayMArray[i]=document.getElementsByName('Birthday_m_'+i)[0].value;
// 		birthdayDArray[i]=document.getElementsByName('Birthday_d_'+i)[0].value;
// 		occupationDArray[i]=document.getElementsByName('Occupation_'+i)[0].value;
// 		regaddArray[i]=document.getElementsByName('RegAdd_'+i)[0].value;
// 	}
// 	document.getElementById('INPUTFORM').innerHTML+='<DIV><HR>'+
// 			'<TABLE STYLE=\'BACKGROUND-COLOR:'+bgcolor+'\'>'+
// 			'<TR><TD STYLE=\'WIDTH:80;TEXT-ALIGN:CENTER\'>'+(no+1)+'</TD>'+
// 				'<TD>姓　　　名</TD><TD><INPUT TYPE=TEXT NAME=Name_'+no+' STYLE=\'WIDTH:100;FONT-SIZE:16\'></TD>'+
// 				'<TD>身分證字號</TD><TD><INPUT TYPE=TEXT NAME=IDNo_'+no+' STYLE=\'WIDTH:150;FONT-SIZE:16\' REQUIRED="required" PATTERN="[A-Z0-9]"></TD><TD><IMG SRC=\'info.png\' STYLE=\'WIDTH:20;CURSOR:POINTER\' ALT=\'請輸入半形英文數字\' TITLE=\'請輸入半形英文數字\'></TD></TR>'+
// 			'<TR><TD></TD>'+
// 				'<TD>性　　　別</TD><TD><INPUT TYPE=RADIO NAME=Sex_'+no+' VALUE=\'M\' CHECKED>男&nbsp;<INPUT TYPE=RADIO NAME=Sex_'+no+' VALUE=\'F\'>女</TD>'+
// 				'<TD>出生年月日</TD><TD>'+returnB_Y(no)+returnB_M(no)+returnB_D(no)+'</TD><TD><IMG SRC=\'info.png\' STYLE=\'WIDTH:20;CURSOR:POINTER\' ALT=\'必須在 1992 年 1 月 13 日（含）以前才能提議罷免\' TITLE=\'必須在 1992 年 1 月 13 日（含）以前出生才能提議或連署罷免\'></TD></TR>'+
// 			'<TR><TD></TD>'+
// 				'<TD>職　　　業</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=Occupation_'+no+' STYLE=\'WIDTH:100;FONT-SIZE:16\'>（請勿超過５個字）</TD></TR>'+
// 			'<TR><TD><INPUT TYPE=CHECKBOX ID=SAMEADD_'+no+' ONCLICK=filladd('+no+')>同 1</TD>'+
// 				'<TD>地　　　址</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=RegAdd_'+no+' STYLE=\'WIDTH:400;FONT-SIZE:16\'></TD></TR>'+
// 			'<TR><TD></TD><TD></TD><TD COLSPAN=3><IMG SRC=\'info.png\' STYLE=\'WIDTH:20\'><SPAN STYLE=\'HEIGHT:20;VERTICAL-ALIGN:TOP\'>&nbsp;請完全依身分證背後地址欄內容填寫，鄰里勿漏</SPAN></TD></TR>'+
// 			'</TABLE>'+
// 			'</DIV>';
// 	for(i=0;i<no;i++)
// 	{
// 		document.getElementsByName('Name_'+i)[0].value=nameArray[i];
// 		document.getElementsByName('IDNo_'+i)[0].value=idnoArray[i];
// 		radios = document.getElementsByName('Sex_'+i);
// 		for (var j = 0; j < radios.length; j++) {
//     		if (radios[j].type === 'radio' && sexArray[i]==radios[j].value) {
//         	radios[j].checked=true;
//         	}
//     	}
// 		document.getElementsByName('Birthday_y_'+i)[0].value=birthdayYArray[i];
// 		document.getElementsByName('Birthday_m_'+i)[0].value=birthdayMArray[i];
// 		document.getElementsByName('Birthday_d_'+i)[0].value=birthdayDArray[i];
// 		document.getElementsByName('Occupation_'+i)[0].value=occupationDArray[i];
// 		document.getElementsByName('RegAdd_'+i)[0].value=regaddArray[i];
// 	}
// }

// //複製戶籍地址
// function filladd(no)
// {
// 	if(document.getElementById('SAMEADD_'+no).checked)
// 		document.getElementsByName('RegAdd_'+no)[0].value=document.getElementsByName('RegAdd_0')[0].value;
// 	else
// 		document.getElementsByName('RegAdd_'+no)[0].value='';
// }

// //年份選單
// function returnB_Y(no)
// {
// 	var currentYear= new Date().getFullYear();
	
// 	rtnStr='<SELECT NAME=\'Birthday_y_'+no+'\' STYLE=\'WIDTH:80;FONT-SIZE:16\'>';
// 	for(i=22;i<120;i++)
// 	{
// 		rtnStr+='<OPTION VALUE=\''+parseInt(currentYear-i)+'\'>'+parseInt(currentYear-i)+' 年</OPTION>';
// 	}
// 	rtnStr+='</SELECT>';
// 	return rtnStr;
// }

// //月份選單
// function returnB_M(no)
// {
// 	rtnStr='<SELECT NAME=\'Birthday_m_'+no+'\' STYLE=\'WIDTH:60;FONT-SIZE:16\'>';
// 	for(i=1;i<13;i++)
// 	{
// 		rtnStr+='<OPTION VALUE=\''+i+'\'>'+i+' 月</OPTION>';
// 	}
// 	rtnStr+='</SELECT>';
// 	return rtnStr;
// }

// //日期選單
// function returnB_D(no)
// {
// 	rtnStr='<SELECT NAME=\'Birthday_d_'+no+'\' STYLE=\'WIDTH:60;FONT-SIZE:16\'>';
// 	for(i=1;i<32;i++)
// 	{
// 		rtnStr+='<OPTION VALUE=\''+i+'\'>'+i+' 日</OPTION>';
// 	}
// 	rtnStr+='</SELECT>';
// 	return rtnStr;
// }

// //輸入資訊辨識
// function checkInput()
// {
// 	var warningStr='';
// 	if(document.getElementsByName('EMAIL')[0].value=='')
// 	{
// 		warningStr+='電子信箱不可為空白\n';
// 	}
// 	for(i=0;i<document.getElementById('Size').value;i++)
// 	{
// 		if(document.getElementsByName('Name_'+i)[0].value=='')
// 		{
// 			warningStr+='編號 '+(i+1)+' 的姓名不可為空白\n';
// 		}
// 		if(document.getElementsByName('IDNo_'+i)[0].value=='')
// 		{
// 			warningStr+='編號 '+(i+1)+' 的身分證字號不可為空白\n';
// 		}
// 		if(idCheck(document.getElementsByName('IDNo_'+i)[0].value)==false)
// 		{
// 			warningStr+='編號 '+(i+1)+' 的身分證字號錯誤\n';
// 		}
// 		if(document.getElementsByName('Occupation_'+i)[0].value=='')
// 		{
// 			warningStr+='編號 '+(i+1)+' 的職業不可為空白\n';
// 		}
// 		if(document.getElementsByName('RegAdd_'+i)[0].value=='')
// 		{
// 			warningStr+='編號 '+(i+1)+' 的地址不可為空白\n';
// 		}
// 	}
// 	if(warningStr!='')
// 	{
// 		alert(warningStr);
// 	}
// 	else
// 	{
// 		document.DATAINPUT.submit();
// 	}
// }

// //身分證辨識
// function idCheck(id)
// {
// 	var idArray=new Array();
// 	idArray[10]="A";	idArray[11]="B";	idArray[12]="C";	idArray[13]="D";
// 	idArray[14]="E";	idArray[15]="F";	idArray[16]="G";	idArray[17]="H";
// 	idArray[34]="I";	idArray[18]="J";	idArray[19]="K";	idArray[20]="L";
// 	idArray[21]="M";	idArray[22]="N";	idArray[35]="O";	idArray[23]="P";
// 	idArray[24]="Q";	idArray[25]="R";	idArray[26]="S";	idArray[27]="T";
// 	idArray[28]="U";	idArray[29]="V";	idArray[30]="X";	idArray[31]="Y";
// 	var newIdArray=idArray.indexOf(id.toUpperCase().substr(0,1))+id.substr(1,9);
// 	var baseNumber=
// 		parseInt(newIdArray.substr(0,1))*1+
// 		parseInt(newIdArray.substr(1,1))*9+
// 		parseInt(newIdArray.substr(2,1))*8+
// 		parseInt(newIdArray.substr(3,1))*7+
// 		parseInt(newIdArray.substr(4,1))*6+
// 		parseInt(newIdArray.substr(5,1))*5+
// 		parseInt(newIdArray.substr(6,1))*4+
// 		parseInt(newIdArray.substr(7,1))*3+
// 		parseInt(newIdArray.substr(8,1))*2+
// 		parseInt(newIdArray.substr(9,1))*1;
// 	if((baseNumber%10)==0)
// 		residue=0;
// 	else
// 		residue=10-(baseNumber%10);
// 	if(parseInt(newIdArray.substr(10,1))==residue)
// 		return true;
// 	else
// 		return false;
// }

<!-- </SCRIPT> -->