<?php
	require_once "inc/sql.php";
	connect_valid();
	
	$QUERY_STRING="SELECT * FROM DOC_ACCEPT_SPOT WHERE ACCEPT_SPOT_ID='".$_GET['ID']."'";
	$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));

	$PROCESSING_PATH="http://www.uisltsc.com.tw/appendectomy/accept_spot_v.php";
//	$PROCESSING_PATH="http://appy.tw/accept_spot_v.php";
	$IMAGE_PATH="APDocSpot_".$DATA['accept_spot_id']."_".date('Ymd').".jpg";
	$CHECKING_PATH=$PROCESSING_PATH."&VC=".$DATA['validation_code'];
	IF($CHECKING_PATH!=$DATA['checking_path'])
	{
		IF(copy("http://140.113.207.111:4000/QRCode/".$CHECKING_PATH,$IMAGE_PATH))
		{
			$QUERY_STRING="UPDATE DOC_ACCEPT_SPOT SET CHECKING_PATH='".$CHECKING_PATH."' WHERE ACCEPT_SPOT_ID='".$_GET['ID']."'";
			MYSQL_QUERY($QUERY_STRING);
		}
	}
	
	ECHO "
		<BR>
		<CENTER>
		罷免文件配合收件地點管理頁面<BR><BR>
		<TABLE BORDER=0 CELLSPACING=3 STYLE='background-color:#EEEEEE;text-align:center'>";
		ECHO "<TR><TD ALIGN=CENTER COLSPAN=6 STYLE='background-color:#CCCCCC'>QRCode 相關影像</TD></TR>";
		ECHO "<TR><TD>地點</TD></TR><TR><TD STYLE='background-color:#CCCCCC'>".$DATA['name']."</TD></TR>";
		ECHO "<TR><TD>基本 QR Code</TD></TR><TR><TD><IMG SRC=".$IMAGE_PATH."></TD></TR>";
/*		ECHO "<TR><TD>含影像 (短)</TD></TR><TR><TD>";
		require_once "createimage.php";
		ECHO "</TD></TR>";*/
		ECHO "<TR><TD>含影像 (短)</TD></TR><TR><TD><IMG SRC='createimage.php?BASE=1&CODEIMG=".$IMAGE_PATH."' WIDTH='1000'></TD>";
//		ECHO "<TR><TD>含影像 (短)</TD></TR><TR><TD><IMG SRC=spot_base1.jpg WIDTH='1000'></TD>";
		ECHO "<TR><TD>含影像 (長)</TD></TR><TR><TD><IMG SRC='createimage.php?BASE=2&CODEIMG=".$IMAGE_PATH."' WIDTH='1000'></TD></TR>";
//		ECHO "<TR><TD>含影像 (長)</TD></TR><TR><TD><IMG SRC=spot_base2.jpg WIDTH='1000'></TD></TR>";
		ECHO "</TABLE>";
	
?>