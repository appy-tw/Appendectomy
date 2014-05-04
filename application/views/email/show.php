<CENTER>
	<TABLE BORDER=0 STYLE='BACKGROUND-COLOR: #FFFFFF; WIDTH: 100%' CELLSPACING=3>
		<TR ALIGN=CENTER>
			<TD STYLE='TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 20; BACKGROUND-COLOR: #BBBBBB'
			COLSPAN=4 ALIGN=CENTER>通知列表</TD>
		</TR>
		<TR STYLE='TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 16; BACKGROUND-COLOR: #EEEEEE'>
			<TD>
				User ID</TD>
			<TD>
				身份證後五碼</TD>
			<TD>
				Email</TD>
			<TD>
				已申請時間</TD>
		</TR>
		<?php if($isData){?>
			<?php foreach ($data as $item):?>
				<TR ALIGN=CENTER>
					<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>
						<?php echo $item['user_id'] ?>
					</TD>
					<TD>
						<?php echo $item['id_last_five'] ?>
					</TD>
					<TD>
						<?php echo $item['email'] ?>
					</TD>
					<TD>
						<?php echo $item['apply_time'] ?>
					</TD>	
				</TR>
			<?php endforeach;?>
		<?php }?>		
	</TABLE>
</CENTER>