<CENTER>
	<TABLE BORDER=0 STYLE='BACKGROUND-COLOR: #FFFFFF; WIDTH: 100%' CELLSPACING=3>
		<TR ALIGN=CENTER>
			<TD STYLE='TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 20; BACKGROUND-COLOR: #BBBBBB'
			COLSPAN=5 ALIGN=CENTER>各立委罷免文書統計表</TD>
		</TR>
		<TR STYLE='TEXT-ALIGN: CENTER; HEIGHT: 30; FONT-SIZE: 16; BACKGROUND-COLOR: #EEEEEE'>
			<TD>
				立委</TD>
			<TD>
				申請連署總數</TD>
			<TD>
				非重複連署筆數</TD>
			<TD>
				已收到連署書</TD>
			<TD>
				三天前產生未收到連署書</TD>
		</TR>
		<?php if($isData){?>
			<?php foreach ($data as $item):?>
				<TR ALIGN=CENTER>
					<TD ALIGN=CENTER STYLE='WIDTH: 30; BACKGROUND-COLOR: #EEEEFF'>
						<?php echo $item['district_id'] ?>
					</TD>
					<TD>
						<?php echo $item['totalApply'] ?>
					</TD>
					<TD>
						<?php echo $item['withoutRepeat'] ?>
					</TD>
					<TD>
						<?php echo $item['received'] ?>
					</TD>
					<TD>
						<?php echo $item['no_received_within_3days'] ?>
					</TD>
					
				</TR>
			<?php endforeach;?>
		<?php }?>		
	</TABLE>
</CENTER>