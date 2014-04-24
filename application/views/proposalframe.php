<body onload=document.TRANSFER.submit();>

<center>
<br>
<input type="button" id="btn_print_1" value="列印提議文件" style="display:block;font-size:16" onclick="print_page();" /><br>
<iframe id="pdfframe" name="pdfframe" src="dummy.html" width="800" height="800" scrolling="auto">
</iframe>
</center>


<script type="text/javascript">
function print_page() {
	window.frames["pdfframe"].focus();
	window.frames["pdfframe"].print();
}
</script>

</body>
</html>
