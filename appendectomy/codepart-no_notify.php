<?php

//用途：將特定罷免文件的狀態設為 no_notify=1 之後使用者將不會再收到通知

	//表單名稱
	if (($TABLE_NAME = $this->input->get ( 'DOCTYPE', true )) === false)
	{
		$dataValid = false;
		$errorInfo = $errorInfo."DOCTYPE Error\n";
	}

	//表單內索引名稱
	$TABLE_ID = $TABLE_NAME."_id";

	//文件流水號
	if (($data ['id'] = $this->input->get ( 'ID', true )) === false)
	{
		$dataValid = false;
		$errorInfo = $errorInfo."ID Error\n";
	}

	//文件驗證碼
	if (($data ['vc'] = $this->input->get ( 'VC', true )) === false)
	{
		$dataValid = false;
		$errorInfo = $errorInfo."VC Error\n";
	}

	$data = array (
		'no_notify' => '1'
	);

	if($this->db->update($TABLE_NAME,data,$TABLE_ID." = '".$data['id']."' AND validation_code='".$data ['vc']."'"))
	{
		ECHO "感謝您的通知。";
	}
?>