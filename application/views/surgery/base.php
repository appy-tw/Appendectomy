<CENTER>
	<TABLE BORDER=0>
		<TR>
			<TD STYLE='TEXT-ALIGN: CENTER; BACKGROUND-COLOR: #BBBBBB'>罷免工作人員管理及罷免文書處理系統</TD>
		</TR>
		<TR>
			<td STYLE='BACKGROUND-COLOR: #EEEEEE; TEXT-ALIGN: CENTER; WIDTH: 300'>
				<table>
					<tr>
						<td>
				<?php foreach ($menu as $item):?>
						<TD>
							<form action='<?php echo site_url($item[0]);?>' method="get">
								<INPUT TYPE="submit" value='<?php echo $item[1];?>'
									STYLE='FONT-SIZE: 16; WIDTH: 150'>
							</form>
						</TD>
				<?php endforeach;?>
				</tr>
					</td>
				</table>
			</td>
		</TR>
		<?php if(isset($content)) {?>
		<TR>
			<TD STYLE='BACKGROUND-COLOR: #EEEEEE; TEXT-ALIGN: CENTER; WIDTH: 300'>
				<?php echo $content;?>
			</TD>
		</TR>
		<?php } ?>
	</TABLE>
</CENTER>
