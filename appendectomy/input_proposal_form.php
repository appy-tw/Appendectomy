<?php
	require_once "inc/sql.php";
	connect_valid();
	ECHO "<CENTER><FORM NAME=DATAINPUT ACTION=proposal.php METHOD=POST>
	<TABLE BORDER=0 STYLE='FONT-SIZE:16'>
	<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDDD'>填寫提議表單</TD><TD STYLE='WIDTH:100;TEXT-ALIGN:CENTER;BORDER:2px solid #666666'><SPAN STYLE='CURSOR:POINTER;' ONCLICK=ADDFORM()>增加份數</SPAN></TD></TR>
	<TR><TD COLSPAN=2><INPUT TYPE=HIDDEN ID=Size NAME=Size VALUE=1>
		<TABLE BORDER=0 WIDTH=100%>
		<TR><TD STYLE='WIDTH:80;TEXT-ALIGN:CENTER'>電子信箱</TD><TD><INPUT TYPE=TEXT NAME=EMAIL STYLE='WIDTH:300;FONT-SIZE:16'></TD></TR>
		<TR><TD STYLE='WIDTH:80;TEXT-ALIGN:CENTER'>罷免對象</TD><TD>";
	$QUERY_STRING="SELECT * FROM DISTRICT_DATA";
	$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
	IF($NO_OF_DATA>0)
	{
		ECHO "<SELECT NAME=DISTRICT_ID STYLE='WIDTH:300;HEIGHT:30;FONT-SIZE:16'>";
		FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			ECHO "<OPTION VALUE='".$DATA[district_id]."'>".$DATA[district_name]."．".$DATA[district_legislator]."．".$DATA[party_name].")</OPTION>";
		}
		ECHO "</SELECT>";
	}
	ECHO "</TD></TR>
		<TR><TD COLSPAN=2>
		<DIV ID=INPUTFORM>
			<DIV>
			<TABLE STYLE='BACKGROUND-COLOR:#DDDDDD'>
			<TR><TD STYLE='WIDTH:80;TEXT-ALIGN:CENTER'>1</TD>
				<TD>姓　　　名</TD><TD><INPUT TYPE=TEXT NAME=Name_0 STYLE='WIDTH:100;FONT-SIZE:16'></TD>
				<TD>身分證字號</TD><TD><INPUT TYPE=TEXT NAME=IDNo_0 STYLE='WIDTH:150;FONT-SIZE:16'></TD></TR>
			<TR><TD></TD>
				<TD>性　　　別</TD><TD><INPUT TYPE=RADIO NAME=Sex_0 VALUE='M' CHECKED>男&nbsp;<INPUT TYPE=RADIO NAME=Sex_0 VALUE='F'>女</TD>
				<TD>出生年月日</TD><TD>";
			RETURN_Y("Birthday_y_0","WIDTH:80;FONT-SIZE:16",1984);
			RETURN_M("Birthday_m_0","WIDTH:60;FONT-SIZE:16",1);
			RETURN_D("Birthday_d_0","WIDTH:60;FONT-SIZE:16",1);
			ECHO "</TD></TR>
			<TR><TD></TD>
				<TD>職　　　業</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=Occupation_0 STYLE='WIDTH:100;FONT-SIZE:16'>（請勿超過４個字）</TD></TR>
			<TR><TD></TD>
				<TD>地　　　址</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=RegAdd_0 STYLE='WIDTH:400;FONT-SIZE:16'></TD></TR>
			<TR><TD></TD><TD></TD><TD COLSPAN=3>（請完全依身分證背後地址欄內容填寫）</TD></TR>
			</TABLE>
			</DIV>
		</DIV>
		<HR>
		</TD></TR>
		</TABLE></TD></TR>
	<TR><TD COLSPAN=2 ALIGN=RIGHT><INPUT TYPE=BUTTON ONCLICK=checkInput() VALUE='製作提議書'></TD></TR>
	</TABLE>
	</FORM>";
	
	FUNCTION RETURN_Y($NAME,$STYLE,$DEFAULT)
	{
		ECHO "<SELECT NAME='".$NAME."' STYLE='".$STYLE."'>";
		$START=date('Y');
		FOR($SEED=20;$SEED<120;$SEED++)
		{
			ECHO "<OPTION VALUE='".($START-$SEED)."' ";
			IF($SEED==$DEFAULT)
				ECHO "SELECTED";
			ECHO ">".($START-$SEED)." 年</OPTION>";
		}
		ECHO "</SELECT>";
	}
	FUNCTION RETURN_M($NAME,$STYLE,$DEFAULT)
	{
		ECHO "<SELECT NAME='".$NAME."' STYLE='".$STYLE."'>";
		FOR($SEED=1;$SEED<13;$SEED++)
		{
			ECHO "<OPTION VALUE='".$SEED."' ";
			IF($SEED==$DEFAULT)
				ECHO "SELECTED";
			ECHO ">".$SEED." 月</OPTION>";
		}
		ECHO "</SELECT>";
	}
	FUNCTION RETURN_D($NAME,$STYLE,$DEFAULT)
	{
		ECHO "<SELECT NAME='".$NAME."' STYLE='".$STYLE."'>";
		FOR($SEED=1;$SEED<32;$SEED++)
		{
			ECHO "<OPTION VALUE='".$SEED."' ";
			IF($SEED==$DEFAULT)
				ECHO "SELECTED";
			ECHO ">".$SEED." 日</OPTION>";
		}
		ECHO "</SELECT>";
	}
php?>
<SCRIPT>
function ADDFORM()
{
	var no=parseInt(document.getElementById('Size').value);
	document.getElementById('Size').value=no+1;
	if(no%2==0)
		bgcolor='#DDDDDD';
	else
		bgcolor='#FFFFFF';
	var nameArray=new Array();
	var idnoArray=new Array();
	var sexArray=new Array();
	var birthdayYArray=new Array();
	var birthdayMArray=new Array();
	var birthdayDArray=new Array();
	var occupationDArray=new Array();
	var regaddArray=new Array();
	var radios;
	for(i=0;i<no;i++)
	{
		nameArray[i]=document.getElementsByName('Name_'+i)[0].value;
		idnoArray[i]=document.getElementsByName('IDNo_'+i)[0].value;
		radios = document.getElementsByName('Sex_'+i);
		for (var j = 0; j < radios.length; j++) {
    		if (radios[j].type === 'radio' && radios[j].checked) {
        	// get value, set checked flag or do whatever you need to
        	sexArray[i] = radios[j].value;
        	}
    	}
		birthdayYArray[i]=document.getElementsByName('Birthday_y_'+i)[0].value;
		birthdayMArray[i]=document.getElementsByName('Birthday_m_'+i)[0].value;
		birthdayDArray[i]=document.getElementsByName('Birthday_d_'+i)[0].value;
		occupationDArray[i]=document.getElementsByName('Occupation_'+i)[0].value;
		regaddArray[i]=document.getElementsByName('RegAdd_'+i)[0].value;
	}
	document.getElementById('INPUTFORM').innerHTML+='<DIV><HR>'+
			'<TABLE STYLE=\'BACKGROUND-COLOR:'+bgcolor+'\'>'+
			'<TR><TD STYLE=\'WIDTH:80;TEXT-ALIGN:CENTER\'>'+(no+1)+'</TD>'+
				'<TD>姓　　　名</TD><TD><INPUT TYPE=TEXT NAME=Name_'+no+' STYLE=\'WIDTH:100;FONT-SIZE:16\'></TD>'+
				'<TD>身分證字號</TD><TD><INPUT TYPE=TEXT NAME=IDNo_'+no+' STYLE=\'WIDTH:150;FONT-SIZE:16\'></TD></TR>'+
			'<TR><TD></TD>'+
				'<TD>性　　　別</TD><TD><INPUT TYPE=RADIO NAME=Sex_'+no+' VALUE=\'M\' CHECKED>男&nbsp;<INPUT TYPE=RADIO NAME=Sex_'+no+' VALUE=\'F\'>女</TD>'+
				'<TD>出生年月日</TD><TD>'+returnB_Y(no)+returnB_M(no)+returnB_D(no)+'</TD></TR>'+
			'<TR><TD></TD>'+
				'<TD>職　　　業</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=Occupation_'+no+' STYLE=\'WIDTH:100;FONT-SIZE:16\'>（請勿超過５個字）</TD></TR>'+
			'<TR><TD><INPUT TYPE=CHECKBOX ID=SAMEADD_'+no+' ONCLICK=filladd('+no+')>同 1</TD>'+
				'<TD>地　　　址</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=RegAdd_'+no+' STYLE=\'WIDTH:400;FONT-SIZE:16\'></TD></TR>'+
			'<TR><TD></TD><TD></TD><TD COLSPAN=3>（請完全依身分證背後地址欄內容填寫）</TD></TR>'+
			'</TABLE>'+
			'</DIV>';
	for(i=0;i<no;i++)
	{
		document.getElementsByName('Name_'+i)[0].value=nameArray[i];
		document.getElementsByName('IDNo_'+i)[0].value=idnoArray[i];
		radios = document.getElementsByName('Sex_'+i);
		for (var j = 0; j < radios.length; j++) {
    		if (radios[j].type === 'radio' && sexArray[i]==radios[j].value) {
        	radios[j].checked=true;
        	}
    	}
		document.getElementsByName('Birthday_y_'+i)[0].value=birthdayYArray[i];
		document.getElementsByName('Birthday_m_'+i)[0].value=birthdayMArray[i];
		document.getElementsByName('Birthday_d_'+i)[0].value=birthdayDArray[i];
		document.getElementsByName('Occupation_'+i)[0].value=occupationDArray[i];
		document.getElementsByName('RegAdd_'+i)[0].value=regaddArray[i];
	}
}

function filladd(no)
{
	if(document.getElementById('SAMEADD_'+no).checked)
		document.getElementsByName('RegAdd_'+no)[0].value=document.getElementsByName('RegAdd_0')[0].value;
	else
		document.getElementsByName('RegAdd_'+no)[0].value='';
}

function returnB_Y(no)
{
	var currentYear= new Date().getFullYear();
	
	rtnStr='<SELECT NAME=\'Birthday_y_'+no+'\' STYLE=\'WIDTH:80;FONT-SIZE:16\'>';
	for(i=20;i<120;i++)
	{
		rtnStr+='<OPTION VALUE=\''+parseInt(currentYear-i)+'\'>'+parseInt(currentYear-i)+' 年</OPTION>';
	}
	rtnStr+='</SELECT>';
	return rtnStr;
}

function returnB_M(no)
{
	rtnStr='<SELECT NAME=\'Birthday_m_'+no+'\' STYLE=\'WIDTH:60;FONT-SIZE:16\'>';
	for(i=1;i<13;i++)
	{
		rtnStr+='<OPTION VALUE=\''+i+'\'>'+i+' 月</OPTION>';
	}
	rtnStr+='</SELECT>';
	return rtnStr;
}

function returnB_D(no)
{
	rtnStr='<SELECT NAME=\'Birthday_d_'+no+'\' STYLE=\'WIDTH:60;FONT-SIZE:16\'>';
	for(i=1;i<32;i++)
	{
		rtnStr+='<OPTION VALUE=\''+i+'\'>'+i+' 日</OPTION>';
	}
	rtnStr+='</SELECT>';
	return rtnStr;
}

function checkInput()
{
	var warningStr='';
	if(document.getElementsByName('EMAIL')[0].value=='')
	{
		warningStr+='電子信箱不可為空白\n';
	}
	for(i=0;i<document.getElementById('Size').value;i++)
	{
		if(document.getElementsByName('Name_'+i)[0].value=='')
		{
			warningStr+='編號 '+(i+1)+' 的姓名不可為空白\n';
		}
		if(document.getElementsByName('IDNo_'+i)[0].value=='')
		{
			warningStr+='編號 '+(i+1)+' 的身分證字號不可為空白\n';
		}
		if(document.getElementsByName('Occupation_'+i)[0].value=='')
		{
			warningStr+='編號 '+(i+1)+' 的職業不可為空白\n';
		}
		if(document.getElementsByName('RegAdd_'+i)[0].value=='')
		{
			warningStr+='編號 '+(i+1)+' 的地址不可為空白\n';
		}
	}
	if(warningStr!='')
	{
		alert(warningStr);
	}
	else
	{
		document.DATAINPUT.submit();
	}
}

</SCRIPT>