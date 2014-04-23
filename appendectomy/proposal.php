<?PHP
	require('inc/pdoCon.php');
	function dashLine($pdf,$STARTX,$STARTY,$ENDX,$ENDY,$DASHWIDTH,$SPACING)
	{
		$pdf->SetLineWidth(0.1);
		$SKIPWIDTH=$DASHWIDTH+$SPACING;
		FOR($SEED=1;$SEED<$ENDX;$SEED=$SEED+$SKIPWIDTH)
		{
			$pdf->Line($STARTX+$SEED, $STARTY, ($STARTX+$DASHWIDTH)+$SEED, $ENDY);
		}
	}
	
	function returnValidation()
	{
	//	$BASESTRING="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$BASESTRING="0123456789";
		$FINALSTRING='';
		FOR($SEED=0;$SEED<30;$SEED++)
		{
			$FINALSTRING.=$BASESTRING[RAND(0,9)];
		}
		RETURN $FINALSTRING;
	}
/*
	$dbh = db_connect('資料庫', '帳號', '密');
	$sql = 'SELECT "GpsLatitude", "GpsLongitude"
	FROM "ClusteringResult"
	WHERE "GpsLatitude" >= :down AND
	  "GpsLatitude" <= :top AND
	  "GpsLongitude" >= :left AND
	  "GpsLongitude" <= :right';
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':down', $down);
	$stmt->bindParam(':top', $top);
	$stmt->bindParam(':left', $left);
	$stmt->bindParam(':right', $right);
	
	$stmt->execute();
	while($row = $stmt->fetch())
	{

 */
	$dbh = db_connect('資料庫', '帳號', '密');
	IF($_POST['Size']>0)
	{
		//依 constituency 取得 DISTRICT_ID
		IF(isset($_POST['constituency'])&&$_POST['constituency']!="")
		{
// 			$QUERY_STRING="SELECT district_id FROM district_data WHERE CONSTITUENCY='".$_POST[constituency]."'";
			$QUERY_STRING="SELECT district_id FROM district_data WHERE CONSTITUENCY=:constituency";
			$stmt = $dbh->prepare($QUERY_STRING);
			$stmt->bindParam(':constituency', $_POST[constituency]);
			$stmt->execute();
// 			IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
			if($DATA_DISTRICT = $stmt->fetch(PDO::FETCH_ASSOC))
			{
// 				$DATA=MYSQL_FETCH_ARRAY($RESULT);
				$_POST['DISTRICT_ID']=$DATA_DISTRICT['district_id'];
			}
		}

// 		$QUERY_STRING="SELECT user_id FROM user_basic WHERE EMAIL='".$_POST[EMAIL]."'";
		$QUERY_STRING="SELECT user_id FROM user_basic WHERE EMAIL=:EMAIL";
		$stmt = $dbh->prepare($QUERY_STRING);
		$stmt->bindParam(':EMAIL', $_POST['EMAIL']);
		$stmt->execute();
		//取得使用者代號
// 		IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
		if($DATA = $stmt->fetch(PDO::FETCH_ASSOC))
		{
// 			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			$USER_ID=$DATA[user_id];
		}
		ELSE
		{
// 			$QUERY_STRING="INSERT INTO user_basic(EMAIL)VALUES('".$_POST[EMAIL]."')";
			$QUERY_STRING="INSERT INTO user_basic (EMAIL) VALUES (:EMAIL)";
			$stmt = $dbh->prepare($QUERY_STRING);
			$stmt->bindParam(':EMAIL', $_POST['EMAIL']);
			$stmt->execute();
// 			IF(MYSQL_QUERY($QUERY_STRING))
// 				$USER_ID=MYSQL_INSERT_ID();
			$QUERY_STRING="SELECT user_id FROM user_basic WHERE EMAIL=:EMAIL";
			$stmt = $dbh->prepare($QUERY_STRING);
			$stmt->bindParam(':EMAIL', $_POST['EMAIL']);
			$stmt->execute();
			if($DATA = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				// 			$DATA=MYSQL_FETCH_ARRAY($RESULT);
				$USER_ID=$DATA[user_id];
			}
		}
		

		
		FOR($SEED=0;$SEED<$_POST['Size'];$SEED++)
		{
			
			//更新產製資料
// 			$QUERY_STRING="INSERT INTO proposal(USER_ID,DISTRICT_ID,ID_LAST_FIVE,VALIDATION_CODE,CREATED_TIME)
// 				VALUES('".
// 				$USER_ID."','".
// 				$_POST[DISTRICT_ID]."','".
// 				SUBSTR($_POST["IDNo_".$SEED],5)."','";
			$QUERY_STRING='INSERT INTO proposal(USER_ID,DISTRICT_ID,ID_LAST_FIVE,VALIDATION_CODE,CREATED_TIME)
				VALUES(:USER_ID,:DISTRICT_ID,:SEED5,:VCODE,NOW())';
			$stmt = $dbh->prepare($QUERY_STRING);
			$stmt->bindParam(':USER_ID', $USER_ID);
			$stmt->bindParam(':DISTRICT_ID', $_POST['DISTRICT_ID']);
			$stmt->bindValue(':SEED5', SUBSTR($_POST["IDNo_".$SEED],5));
			$VCODE=returnValidation();
			$stmt->bindParam(':VCODE', $VCODE);
// 			IF(MYSQL_QUERY($QUERY_STRING))
			if($stmt->execute())
			{
				$QUERY_STRING='SELECT proposal_id FROM proposal
							WHERE USER_ID=:USER_ID AND DISTRICT_ID=:DISTRICT_ID
							AND ID_LAST_FIVE=:SEED5 AND VALIDATION_CODE=:VCODE ';
				$stmt = $dbh->prepare($QUERY_STRING);
				$stmt->bindParam(':USER_ID', $USER_ID);
				$stmt->bindParam(':DISTRICT_ID', $_POST[DISTRICT_ID]);
				$stmt->bindValue(':SEED5', SUBSTR($_POST["IDNo_".$SEED],5));
				$VCODE=returnValidation();
				$stmt->bindParam(':VCODE', $VCODE);
				// 			IF(MYSQL_QUERY($QUERY_STRING))
				$stmt->execute();
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
				//建立流水號
				$_POST["SNo_".$SEED]="AP".SPRINTF("%02d",$_POST[DISTRICT_ID])."1".SPRINTF("%06d",$row[0]);
				//設定 QR Code 檔案路徑
				$_POST["QRImgPath_".$SEED]='img/'.$_POST["SNo_".$SEED].".jpg";
				//複製 QR Code 檔案
				copy("http://140.113.207.111:4000/QRCode/".$_POST["SNo_".$SEED]."&VC=".$VCODE,$_POST["QRImgPath_".$SEED]);
			}
// 			print_r($stmt->errorInfo());
		}
	}

require('../FPDF/chinese-unicode.php'); 
$pdf=new PDF_Unicode(); 

$CHI_FONT="DFKai-SB";
$ENG_FONT="DFKai-SB";
$pdf->AddUniCNShwFont($CHI_FONT); 

$pdf->Open();

IF($_POST[DISTRICT_ID]!="")
{
// 	$QUERY_STRING="SELECT * FROM district_data WHERE DISTRICT_ID='".$_POST[DISTRICT_ID]."'";
// 	$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
	$QUERY_STRING='SELECT * FROM district_data WHERE DISTRICT_ID=:DISTRICT_ID';
	$stmt->bindParam(':DISTRICT_ID', $_POST['DISTRICT_ID']);
	$stmt->execute();
	$DATA=$stmt->fetch();
}

//DUMMY DATA
IF($DATA['receiver']=="")
{
	$DATA['reason']="罷免理由";
	$DATA['notice']="注意事項";
	$DATA['others']="其他";
	$DATA['zipcode']="郵遞區號";
	$DATA['mailing_address']="提議書郵寄地址";
	$DATA['receiver']="提議書收件人";
}
$NAME="提議人姓名";
$IDNo="A135792468";
$SEX="M";
$BIRTHDAY="YYYY.MM.DD";
$OCCUPATION="職業";
$REGADD="提案人戶籍地址";

IF($_GET['NO']=="")
{
	$NO=1;
}
ELSE IF($_GET['NO']>0)
{
	$NO=$_GET['NO'];
}

//DUMMY DATA
IF($_POST['Name_0']=="")
{
	$_POST['Name_0']="馬娘娘";
	$_POST['IDNo_0']="A246813579";
	$_POST['Sex_0']="F";
	$_POST['Birthday_0']="YYYY.MM.DD";
	$_POST['Occupation_0']="孬孬";
	$_POST['RegAdd_0']="魯蛇大本營";	
	$_POST['SNo_0']="123456789";
}
IF($_POST['Name_1']=="")
{
	$_POST['Name_1']="金小刀";
	$_POST['IDNo_1']="A135792468";
	$_POST['Sex_1']="M";
	$_POST['Birthday_1']="YYYY.MM.DD";
	$_POST['Occupation_1']="孬孬";
	$_POST['RegAdd_1']="魯蛇大本營";
	$_POST['SNo_1']="987654321";
}

IF($_POST['Size']=="")
{
	$SIZE=2;
}
ELSE
{
	$SIZE=$_POST['Size'];
}

for($SEED=0;$SEED<$SIZE;$SEED++)
{
	$NAME=$_POST["Name_".$SEED];
	$IDNo=$_POST["IDNo_".$SEED];
	$SEX=$_POST["Sex_".$SEED];
	$BIRTHDAY=$_POST["Birthday_y_".$SEED]."-".$_POST["Birthday_m_".$SEED]."-".$_POST["Birthday_d_".$SEED];
	$OCCUPATION=$_POST["Occupation_".$SEED];
	$REGADD=$_POST["RegAdd_".$SEED];
	$QRImgPath="";
	IF($_POST["QRImgPath_".$SEED]!="")
		$QRImgPath=$_POST["QRImgPath_".$SEED];
	$SNo=$_POST["SNo_".$SEED];


	generatePDF($pdf,$CHI_FONT,$ENG_FONT,$DATA,$NAME,$IDNo,$SEX,$BIRTHDAY,$OCCUPATION,$REGADD,$QRImgPath,$SNo);
}

function generatePDF($pdf,$CHI_FONT,$ENG_FONT,$DATA,$NAME,$IDNo,$SEX,$BIRTHDAY,$OCCUPATION,$REGADD,$QRImgPath,$SNo)
{
$pdf->AddPage();
$pdf->SetFont($CHI_FONT,'',14);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,1,'',0,1);


$add_offset=104;
$form_offset=213;
$first_line=104;
$second_line=203;

//說明資訊列===================================
IF($DATA['prodescimgpath']!="")
{
	$pdf->Image($DATA['prodescimgpath'],0,0,210);
}
ELSE
{
	$pdf->SetXY(10,11);
	$pdf->SetFillColor(200,200,200);
	$pdf->Cell(150,50,$DATA['reason'],1,1,'C',true);
	$pdf->SetXY(10,63);
	$pdf->SetFillColor(150,150,150);
	$pdf->Cell(150,30,$DATA['notice'],1,1,'C',true);
	$pdf->SetXY(163,10);
	$pdf->SetFillColor(100,100,100);
	$pdf->Cell(40,83,$DATA['others'],1,1,'C',true);
}

//地址資訊列===================================
$pdf->SetXY(175,5+$add_offset);
$pdf->Cell(20,25,'郵票',1,1,'C',false);

if($DATA[prepaid]==1)
{
	$pdf->Image("adv_mail.jpg",0,$add_offset,210);
	$pdf->SetXY(141.1,14.7+$add_offset);
	$pdf->SetFont($CHI_FONT,'',11);
	$pdf->Cell(41.5,7.4,$DATA['postoffice']."郵局登記證",０, 0,'C',false);
	$pdf->SetXY(141.1,22.1+$add_offset);
	$pdf->Cell(41.5,7.4,$DATA['adv_no'],0,0,'C',false);

}

$pdf->SetFont($CHI_FONT,'',20);
$pdf->SetXY(60,55+$add_offset);
$pdf->Cell(0,8,$DATA['zipcode'],0,1,'L',false);
$pdf->SetXY(60,63+$add_offset);
$pdf->Cell(0,8,$DATA['mailing_address'],0,0,'L',false);
$pdf->SetXY(60,76+$add_offset);
$pdf->Cell(0,8,$DATA['receiver'].'　啟',0,0,'L',false);

if($QRImgPath!="")
{
	//QR Code 影像
	$pdf->Image($QRImgPath,10,1+$add_offset,33);
	//刪除 QR Code 影像
	unlink($QRImgPath);
	$pdf->SetXY(10,28+$add_offset);
	$pdf->SetFont($CHI_FONT,'',14);
	$pdf->Cell(33,12,$SNo,0,1,'C',false);
}
//提議書表單列===================================
$pdf->SetXY(5,5+$form_offset);
$pdf->SetFont($CHI_FONT,'',24);
$pdf->Cell(205,8,'公職人員罷免提議人名冊',0,0,'C',false);
$pdf->SetFont($CHI_FONT,'',18);

//$pdf->Cell(0,2,'',0,1);

$pdf->SetXY(5,15+$form_offset);
$pdf->SetFont($CHI_FONT,'',12);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(200,8,$DATA['district_name'].'立法委員'.$DATA['district_legislator'].'罷免案提議人名冊',1,1,'C',false);

$pdf->SetXY(5,23+$form_offset);
$pdf->SetFont($CHI_FONT,'',14);
$pdf->Cell(12,16,'編號',1,0,'C',true);
$pdf->Cell(40,8,'姓名',1,0,'C',false);
$pdf->Cell(8,16,'',1,0,'C',true);
$pdf->Cell(26,16,'',1,0,'C',true);
$pdf->Cell(20,16,'職業',1,0,'C',true);
$pdf->Cell(62,16,'戶籍地址',1,0,'C',true);
$pdf->Cell(20,16,'',1,0,'C',true);
$pdf->Cell(12,16,'備註',1,0,'C',true);
$pdf->Cell(20,8,'',0,1);
//$pdf->Cell(1);
$pdf->SetFont($CHI_FONT,'',14);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(17,31+$form_offset);
$pdf->Cell(40,8,'身分證字號',1,0,'C',true);
$pdf->Cell(20,8,'',0,1);

$pdf->SetXY(51,24+$form_offset);
$pdf->Cell(20,8,'性',0,0,'C',false);
$pdf->SetXY(51,30+$form_offset);
$pdf->Cell(20,8,'別',0,0,'C',false);

$pdf->SetXY(173,24+$form_offset);
$pdf->Cell(20,8,'簽　名',0,0,'C',false);
$pdf->SetXY(173,30+$form_offset);
$pdf->Cell(20,8,'或蓋章',0,0,'C',false);

$pdf->SetXY(66,24+$form_offset);
$pdf->Cell(24,8,'出　生',0,0,'C',false);
$pdf->SetXY(66,30+$form_offset);
$pdf->Cell(24,8,'年月日',0,0,'C',false);

$pdf->Cell(20,8,'',0,1);

$pdf->SetXY(5,39+$form_offset);

$pdf->Cell(12,20,'',1,0,'C',true);
$pdf->Cell(40,8,$NAME,1,0,'C',false);
IF($SEX=="M"||$SEX=="男")
	$SEX_STRING="男";
ELSE
	$SEX_STRING="女";
$pdf->Cell(8,20,$SEX_STRING,1,0,'C',true);
$pdf->Cell(26,20,$BIRTHDAY,1,0,'C',true);
$pdf->Cell(20,20,$OCCUPATION,1,0,'C',true);
$pdf->Cell(62,20,'',1,0,'C',false);
$pdf->Cell(20,20,'',1,0,'C',true);
$pdf->Cell(12,20,'',1,0,'C',true);
$pdf->Cell(20,8,'',0,1);
//$pdf->Cell(1);
$pdf->SetFont($CHI_FONT,'',14);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(17,47+$form_offset);
$pdf->Cell(4,12,$IDNo[0],1,0,'C',true);
$pdf->Cell(4,12,$IDNo[1],1,0,'C',true);
$pdf->Cell(4,12,$IDNo[2],1,0,'C',true);
$pdf->Cell(4,12,$IDNo[3],1,0,'C',true);
$pdf->Cell(4,12,$IDNo[4],1,0,'C',true);
$pdf->Cell(4,12,$IDNo[5],1,0,'C',true);
$pdf->Cell(4,12,$IDNo[6],1,0,'C',true);
$pdf->Cell(4,12,$IDNo[7],1,0,'C',true);
$pdf->Cell(4,12,$IDNo[8],1,0,'C',true);
$pdf->Cell(4,12,$IDNo[9],1,0,'C',true);
$pdf->Cell(20,8,'',0,1);

dashLine($pdf,5,$first_line,200,$first_line,2,2);
dashLine($pdf,5,$second_line,200,$second_line,2,2);

$ADDLEN=MB_STRLEN($REGADD);
$WORDPERLINE=12;
$LINE=($ADDLEN-$ADDLEN%$WORDPERLINE)/$WORDPERLINE;
IF(($ADDLEN%$WORDPERLINE)>0)
{
	$LINE++;
}
IF($LINE==""||$LINE==0)
	$LINE=1;
$HEIGHT=20/$LINE;
FOR($LINESEED=0;$LINESEED<$LINE;$LINESEED++)
{
	$pdf->SetXY(111,39+$form_offset+$LINESEED*$HEIGHT);
	$pdf->Cell(62,$HEIGHT,MB_SUBSTR($REGADD,$LINESEED*$WORDPERLINE,$WORDPERLINE),'C',false);
}

$pdf->SetXY(95,2);
$pdf->SetFont($CHI_FONT,'',10);
$pdf->Cell(24,7,"請以膠帶黏貼",1,0,'C',true);

}

$pdf->Output();



?>
