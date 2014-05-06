<?php
	require_once "inc/sql.php";
	connect_valid();

	$QUERY_STRING="SELECT * FROM DOC_ACCEPT_SPOT ORDER BY CITY, DISTRICT";
	$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
	ECHO "
		<CENTER>
		<BR>
		<H2>罷免文件配合收件地點</H2>
		<BR>
		<TABLE BORDER=0 CELLSPACING=3 STYLE='background-color:#EEEEEE'>
		<TR STYLE='text-align:center;background-color:#DDDDFF'><TD ROWSPAN=2>No.</TD><TD ROWSPAN=2 STYLE='width:300'>收件點名稱</TD><TD STYLE='width:100' ROWSPAN=2>縣市</TD><TD STYLE='width:100' ROWSPAN=2>鄉鎮市區</TD><TD STYLE='width:300'>地址</TD><TD STYLE='width:100'>電話</TD><TD ROWSPAN=2 STYLE='width:200'>備註</TD></TR>
		<TR STYLE='text-align:center;'><TD COLSPAN=2 STYLE='BACKGROUND-COLOR:#EEEEFF'>營業時間</TD></TR>
		<TR><TD COLSPAN=7 STYLE='height:3;background-color:#cccccc'></TD></TR>";
	FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
	{
		$DATA=MYSQL_FETCH_ARRAY($RESULT);
		
		IF($SEED%2==0)
			$BGCOLOR="#DDFFDD";
		ELSE
			$BGCOLOR="#FFDDDD";
		
		ECHO "<TR STYLE='BACKGROUND-COLOR:".$BGCOLOR.";TEXT-ALIGN:CENTER'><TD ROWSPAN=2>".($SEED+1)."</TD><TD ROWSPAN=2>";
			IF($DATA['website_path']!="")
			{
					ECHO "<A HREF='".$DATA['website_path']."' TARGET=_blank>".$DATA['name']."</A>";
			}
			ELSE
			{
					ECHO $DATA['name'];
			}
			ECHO "</TD><TD ROWSPAN=2>".$DATA['city']."</TD><TD ROWSPAN=2>".$DATA['district']."</TD><TD>".$DATA['address']."</TD><TD>".$DATA['telephone']."</TD><TD ROWSPAN=2>".nl2br($DATA['note'])."</TD></TR>
			<TR><TD COLSPAN=2>".nl2br($DATA['business_hour'])."</TD></TR>";
		
	}
	ECHO "</TABLE>";
?>