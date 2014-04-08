<body onload=document.TRANSFER.submit();>

<?php
	ECHO "<FORM NAME=TRANSFER ACTION=petition.php METHOD=POST TARGET=pdfframe>";
	while($element = current($_POST)) {
    echo "<INPUT TYPE=HIDDEN NAME=".key($_POST)." VALUE='".$_POST[key($_POST)]."'>";
    next($_POST);
	}
	ECHO "</FORM>";
?>

<center>
<br>
<input type="button" id="btn_print_1" value="列印連署文件" style="display:block;font-size:16" onclick="print_page();" /><br>
<iframe id="pdfframe" name="pdfframe" src="dummy.html" width="800" height="800" scrolling="auto">
</iframe>
</center>
<?php

?>

<script type="text/javascript">
function print_page() {
	window.frames["pdfframe"].focus();
	window.frames["pdfframe"].print();
}
</script>

</body>
</html>
