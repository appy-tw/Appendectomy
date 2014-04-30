<?php
	require_once "inc/sql.php";
	connect_valid();

//$DOCTYPE => "proposal" (提議書) 或 "petition" (連署書)
//$STATUS => "created" (已產製) "received" (已收到) "refused" (遭退回) "voided" 已設為無效
//$DAY_INTERVAL => 相隔天數 (數字）

//取得郵寄名單
function returnEmailList($DOCTYPE,$STATUS,$DAY_INTERVAL)
{
	$QUERY_STRING="SELECT * FROM ".$DOCTYPE." AS DOC,USER_BASIC AS UB WHERE DOC.USER_ID=UB.USER_ID AND CURRENT_STATUS='".$STATUS."' AND CREATED_TIME<=date_sub(NOW(), interval '".$DAY_INTERVAL."' day) AND NOTIFIED_TIME<=date_sub(NOW(), interval '".$DAY_INTERVAL."' day)";
	$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
	IF($DOCTYPE=="proposal")
		$DOCTYPEID="1";
	ELSE IF($DOCTYPE=="petition")
		$DOCTYPEID="2";
		
	IF($NO_OF_DATA>0)
	{
		//$MAILLIST['SIZE'] 為符合條件資料數
		$MAILLIST['SIZE']=$NO_OF_DATA;
		FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			//文件 ID 流水號
			$MAILLIST[$SEED]['DID']=$DATA[STRTOLOWER($DOCTYPE).'_id'];
			//流水號
			$MAILLIST[$SEED]['SNO']="AP".SPRINTF("%02d",$DATA['district_id']).$DOCTYPEID.SPRINTF("%06d",$DATA[STRTOLOWER($DOCTYPE).'_id']);
			//文件建立時間
			$MAILLIST[$SEED]['CREATE_TIME']=$DATA['create_time'];
			//身分證後五碼
			$MAILLIST[$SEED]['IDL5']=$DATA['id_last_five'];
			//E-MAIL
			$MAILLIST[$SEED]['EMAIL']=$DATA['email'];
		}
	}
	RETURN $MAILLIST;
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
		今天寄這封信給您，是想提醒您儘快寄出您之前為身分證後五碼為 ".$MAILLIST_ITEM['IDL5']."的".$USERTYPE."所製作，<BR>
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

//使用方式說明：
//步驟 1：呼叫 returnEmailList($DOCTYPE,$STATUS,$DAY_INTERVAL) 取得郵件名單
//　　　　若要取得產製後過了三天還沒收的提議書的製作者的資料：$MAILLIST=returnEmailList("proposal","created","3");
//
//步驟 2：以迴圈來處理 returnEmailList 回傳的資料，如：
//		　	for($SEED<0;$SEED<$MAILLIST['SIZE'];$SEED++)
//			{
//				$MAILLIST_ITEM['CREATE_TIME']=$MAILLIST[$SEED]['CREATE_TIME'];
//				$MAILLIST_ITEM['SNO']=$MAILLIST[$SEED]['SNO'];
//				$MAILLIST_ITEM['IDL5']=$MAILLIST[$SEED]['IDL5'];
//
//				//取得信件內要放的內容
//				$TEXT_TO_SEND=returnEmailText($DOCTYPE,$MAILLIST_ITEM);
//
//				//利用電子信箱 $MAILLIST[$SEED]['EMAIL'] 及文件內容 $TEXT_TO_SEND 搭配寄信功能來寄送信件（例如使用 PHP 的 MAIL 函式）
//				
//				//寄送成功後更新資料庫內的 NOTIFIED_TIME 資料
//				updateNotifiedTime($DOCTYPE,$MAILLIST[$SEED]['DID']);
//			}

?>