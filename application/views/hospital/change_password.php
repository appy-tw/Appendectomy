<form action=<?php echo site_url($trg);?> method="post">
	<label>原本密碼：</label><input type='password' name='origin'/><br/>
	<label>新密碼：</label><input type='password' name='new'/><br/>
	<label>再來一次：</label><input type='password' name='twice'/><br/>
	<input type="submit" value='改'/>
</form>