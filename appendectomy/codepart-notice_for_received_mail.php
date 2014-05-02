<?php

//用途：為收到的文件建立通知信內容、寄出信件，並更新通知時間
//使用時機：在使用作業 APP 或文書作業網頁將收到的特定罷免文件的狀態由 created 變更為 received 時
	
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

	$condition = array (
		$TABLE_ID=>$data ['id'],
		'validation_code'=>$data ['vc']
	);

	$query = $this->db->get_where($TABLE_NAME, $condition);
	
	foreach($query->result() as $row)
	{
		$MAILLIST_ITEM['CREATE_TIME']=$row->created_time;
		$MAILLIST_ITEM['IDL5']=$row->id_last_five;
		IF($DOCTYPE=='proposal')
		{
			$ID=$row->proposal_id;
			$MAILLIST_ITEM['SNO']="AP".SPRINTF("%02d",$row->district_id)."1".SPRINTF("%06d",$ID);
		}
		ELSE IF($DOCTYPE=='petition')
		{
			$ID=$row->petition_id;
			$MAILLIST_ITEM['SNO']="AP".SPRINTF("%02d",$row->district_id)."2".SPRINTF("%06d",$ID);
		}
		//建立信件內文
		$TEXT=returnEmailText($DOCTYPE,$MAILLIST_ITEM);

		//寄送信件
		//可使用 PHP 的 MAIL 函式

		//更新通知時間
		updateNotifiedTime($DOCTYPE,$ID);
	}

//回傳郵件內容
function returnEmailText($DOCTYPE,$MAILLIST_ITEM)
{
	IF($DOCTYPE=="proposal")
	{
		$USERTYPE="提議人";
		$DOCNAME="提議書";
	}
	ELSE IF($DOCTYPE=="petition")
	{
		$USERTYPE=="連署人";
		$DOCNAME="連署書";
	}
	$TEXT="親愛的".$USERTYPE."您好：<BR>
		謝謝您在 ".$MAILLIST_ITEM['CREATE_TIME']." 到割闌尾網站製作了".$DOCNAME."。<BR><BR>
		今天寄這封信給您，是要通知您我們已經收到您為身分證後五碼為 ".$MAILLIST_ITEM['IDL5']."的".$USERTYPE."所寄出，<BR>
		流水號為 ".$MAILLIST_ITEM['SNO']." 的".$DOCNAME."。<BR>
		謝謝您的配合與支持。<BR><BR>
		
		祝您　一切順心<BR><BR>
		割闌尾團隊敬上";

	RETURN $TEXT;
}

//更新通知時間
function updateNotifiedTime($DOCTYPE,$ID)
{
	$QUERY_STRING="UPDATE ".$DOCTYPE." SET NOTIFIED_TIME=NOW() WHERE ".$DOCTYPE."_ID='".$ID."'";
	MYSQL_QUERY($QUERY_STRING);
}



?>