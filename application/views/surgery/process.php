
<CENTER>
	<BR>
	<FORM ACTION='<?php echo site_url('surgery/process_update'); ?>' METHOD=POST>
		<TABLE BORDER=0>
			<TR>
				<TD
					STYLE='TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 20; BACKGROUND-COLOR: #BBBBBB'
					COLSPAN=3 ALIGN=CENTER>罷免相關文件處理系統</TD>
			</TR>
			<TR>
				<TD><BR>
					<TABLE BORDER=0 STYLE='BACKGROUND-COLOR: #FFFFFF; WIDTH: 100%'
						CELLSPACING=3>
						<TR
							STYLE='TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 20; BACKGROUND-COLOR: #DDDDDD'>
							<TD COLSPAN=4 ALIGN=CENTER>待處理文件資料</TD>
						</TR>
						<TR>
							<TD
								STYLE='WIDTH: 20; TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 16; BACKGROUND-COLOR: #EEEEEE'>文件處理人代號</TD>
							<TD colspan='3' STYLE='TEXT-ALIGN: CENTER; FONT-SIZE: 16'>
							</TD>
						</tr>
						<tr>
							<TD
								STYLE='WIDTH: 20; TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 16; BACKGROUND-COLOR: #EEEEEE'>罷
								免 對 象</TD>
							<TD colspan='3'>
							<input type='text' name='DISTRICT_ID' value='001'/>
							</TD>
							
						</TR>
						<TR>
							<TD
								STYLE='WIDTH: 20; TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 16; BACKGROUND-COLOR: #EEEEEE'>文
								件 類 別</TD>
							<TD colspan='3'><INPUT TYPE=RADIO NAME=DOCTYPE VALUE='proposal'
								ONCLICK=change_doctype()>提議書 <INPUT TYPE=RADIO NAME=DOCTYPE
								VALUE='petition' ONCLICK=change_doctype()>連署書</TD>
						</TR>
						<TR>
							<TD
								STYLE='WIDTH: 20; TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 16; BACKGROUND-COLOR: #EEEEEE'>設定文件狀態為</TD>
							<TD COLSPAN=3><INPUT TYPE=RADIO NAME=STATUS VALUE='received'
								ONCLICK=check_status()>已收到 <INPUT TYPE=RADIO NAME=STATUS
								VALUE='sent' ONCLICK=check_status()>已送出 <INPUT TYPE=RADIO
								NAME=STATUS VALUE='refused' ONCLICK=check_status()>被中選會拒收 <INPUT
								TYPE=RADIO NAME=STATUS VALUE='voided' ONCLICK=check_status()>喪失效力
							</TD>
						</TR>
						<TR
							STYLE='TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 16; BACKGROUND-COLOR: #EEEEEE'>
							<TD>文 件 內 容</TD>
							<TD STYLE='TEXT-ALIGN: CENTER;'>流水號&nbsp;<SPAN
								STYLE='FONT-SIZE: 14; COLOR:'>補零部分不必輸入<BR>(如 AP<SPAN ID=DISTEXP
									STYLE='COLOR: BLUE'>00</SPAN><SPAN ID=DTYPEEXP
									STYLE='COLOR: RED'>1</SPAN>00133 輸入 133 即可)
							</SPAN></TD>
							<TD>身分證後五碼<BR>
							<SPAN STYLE='FONT-SIZE: 12; COLOR: RED'>（用於確認是否有重複資料）</SPAN></TD>
							<TD ROWSPAN=11 STYLE='BACKGROUND-COLOR: #EEEEEE'><INPUT
								TYPE=SUBMIT VALUE='送出' STYLE='FONT-SIZE: 20'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>1</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_0 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_0 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_0 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_0
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>2</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_1 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_1 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_1 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_1
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>3</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_2 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_2 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_2 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_2
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>4</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_3 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_3 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_3 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_3
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>5</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_4 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_4 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_4 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_4
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>6</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_5 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_5 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_5 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_5
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>7</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_6 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_6 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_6 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_6
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>8</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_7 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_7 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_7 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_7
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>9</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_8 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_8 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_8 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_8
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>
						<TR ALIGN=CENTER>
							<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>10</TD>
							<TD>AP<SPAN ID=DISTRICT_IDDIV_9 STYLE='COLOR: BLUE'>00</SPAN><SPAN
								ID=DOCTYPE_9 STYLE='COLOR: RED'>1</SPAN><INPUT TYPE=TEXT
								NAME=SNO_9 STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
							<TD><INPUT TYPE=TEXT NAME=IDL5_9
								STYLE='WIDTH: 20; FONT-SIZE: 16'></TD>
						</TR>

					</TABLE>
					</FORM></TD>
			</TR>
		</TABLE>

</CENTER>
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