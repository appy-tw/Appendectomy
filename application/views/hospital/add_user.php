<form action=<?php echo site_url($trg);?> method="post">
	<label>原本密碼：</label><input type='text' name='nickname'/><br/>
	<label>新密碼：</label><input type='password' name='password'/><br/>
	<label>再來一次：</label><input type='password' name='twice'/><br/>
	<label>權限：</label><select name='level'>
		<option value="app_qrcode">app QR Code的帳號</option>
		<option value="email">讀系統資料寄通知信帳號</option>
	</select> <br/>
	<input type="submit" value='新增'/>
</form>