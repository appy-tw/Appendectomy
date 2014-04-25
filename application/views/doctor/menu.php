<CENTER>
	<TABLE BORDER=0>
		<TR>
			<TD COLSPAN=3 STYLE='TEXT-ALIGN: CENTER; BACKGROUND-COLOR: #BBBBBB'>罷免工作人員管理及罷免文書處理系統</TD>
		</TR>
		<TR>
			<TD STYLE='BACKGROUND-COLOR: #EEEEEE; TEXT-ALIGN: CENTER; WIDTH: 300'>
				<?php foreach ($link as $item):?>
					<form action='<?php echo site_url($item[0]);?>' method="get">
					<INPUT TYPE="submit" value='<?php echo $item[1];?>'
						STYLE='FONT-SIZE: 16; WIDTH: 150'>
					</form>
				<?php endforeach;?>
			</TD>
		</TR>
	</TABLE>
</CENTER>
