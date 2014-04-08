<?PHP
	require('inc/sql.php');
	connect_valid();

	IF($_POST[Size]>0)
	{
		$QUERY_STRING="SELECT user_id FROM USER_BASIC WHERE EMAIL='".$_POST[EMAIL]."'";
		//取得使用者代號
		IF(MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING))==1)
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			$USER_ID=$DATA[user_id];
		}
		ELSE
		{
			$QUERY_STRING="INSERT INTO USER_BASIC(EMAIL)VALUES('".$_POST[EMAIL]."')";
			IF(MYSQL_QUERY($QUERY_STRING))
				$USER_ID=MYSQL_INSERT_ID();
		}
		
		FOR($SEED=0;$SEED<$_POST[Size];$SEED++)
		{
			//更新產製資料
			$QUERY_STRING="INSERT INTO PETITION(USER_ID,DISTRICT_ID,ID_LAST_FIVE,VALIDATION_CODE,CREATED_TIME)
				VALUES('".
				$USER_ID."','".
				$_POST[DISTRICT_ID]."','".
				SUBSTR($_POST["IDNo_".$SEED],5)."','";
			$VCODE=returnValidation();
			$QUERY_STRING.=$VCODE;
			$QUERY_STRING.="',NOW())";
			IF(MYSQL_QUERY($QUERY_STRING))
			{
				//建立流水號
				$_POST["SNo_".$SEED]="AP".SPRINTF("%02d",$_POST[DISTRICT_ID])."2".SPRINTF("%06d",MYSQL_INSERT_ID());
				//複製 QR Code 檔案
				copy("http://140.113.207.111:4000/QRCode/".$_POST["SNo_".$SEED]."&VC=".$VCODE,$_POST["SNo_".$SEED].".jpg");
				//設定 QR Code 檔案路徑
				$_POST["QRImgPath_".$SEED]=$_POST["SNo_".$SEED].".jpg";
			}
		}
	}

require('../FPDF/chinese-unicode.php'); 
$pdf=new PDF_Unicode(); 

$CHI_FONT="DFKai-SB";
$ENG_FONT="DFKai-SB";
$pdf->AddUniCNShwFont($CHI_FONT); 

$pdf->Open();

$REASON=$_POST[Reason];
$NOTICE=$_POST[Notice];
$OTHERS=$_POST[Others];
$ZIPCODE=$_POST[Zipcode];
$ADDRESS=$_POST[Address];
$RECEIVER=$_POST[Receiver];
$ELEDIST=$_POST[EleDist];
$TARGETNAME=$_POST[TargetName];

//DUMMY DATA
$REASON="罷免理由";
$NOTICE="注意事項";
$OTHERS="其他";
$ZIPCODE="郵遞區號";
$ADDRESS="連署書郵寄地址";
$RECEIVER="連署書收件人";
$ELEDIST="選區";
$TARGETNAME="罷免對象姓名";
$NAME="連署人姓名";
$IDNo="A135792468";
$SEX="M";
$BIRTHDAY="YYYY.MM.DD";
$OCCUPATION="職業";
$REGADD="提案人戶籍地址";


IF($_POST[DISTRICT_ID]!="")
{
	$QUERY_STRING="SELECT * FROM DISTRICT_DATA WHERE DISTRICT_ID='".$_POST[DISTRICT_ID]."'";
	$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
	$ELEDIST=$DATA[district_name];
	$TARGETNAME=$DATA[district_legislator];
}

IF($_GET[NO]=="")
{
	$NO=1;
}
ELSE IF($_GET[NO]>0)
{
	$NO=$_GET[NO];
}

//DUMMY DATA
IF($_POST[Name_0]=="")
{
	$_POST[Name_0]="馬娘娘";
	$_POST[IDNo_0]="A246813579";
	$_POST[Sex_0]="F";
	$_POST[Birthday_0]="YYYY.MM.DD";
	$_POST[Occupation_0]="孬孬";
	$_POST[RegAdd_0]="魯蛇大本營";	
	$_POST[SNo_0]="123456789";
}
IF($_POST[Name_1]=="")
{
	$_POST[Name_1]="金小刀";
	$_POST[IDNo_1]="A135792468";
	$_POST[Sex_1]="M";
	$_POST[Birthday_1]="YYYY.MM.DD";
	$_POST[Occupation_1]="孬孬";
	$_POST[RegAdd_1]="魯蛇大本營";
	$_POST[SNo_1]="987654321";
}

IF($_POST[Size]=="")
{
	$SIZE=2;
}
ELSE
{
	$SIZE=$_POST[Size];
}

for($SEED=0;$SEED<$SIZE;$SEED++)
{
	$NAME=$_POST["Name_".$SEED];
	$IDNo=$_POST["IDNo_".$SEED];
	$SEX=$_POST["Sex_".$SEED];
	$BIRTHDAY=$_POST["Birthday_y_".$SEED]."-".$_POST["Birthday_m_".$SEED]."-".$_POST["Birthday_d_".$SEED];
	$OCCUPATION=$_POST["Occupation_".$SEED];
	$REGADD=$_POST["RegAdd_".$SEED];
	$QRImgPath="qrcode.jpg";
	IF($_POST["QRImgPath_".$SEED]!="")
		$QRImgPath=$_POST["QRImgPath_".$SEED];
	$SNo=$_POST["SNo_".$SEED];


	generatePDF($pdf,$CHI_FONT,$ENG_FONT,$REASON,$NOTICE,$OTHERS,$ZIPCODE,$ADDRESS,$RECEIVER,$ELEDIST,$TARGETNAME,$NAME,$IDNo,$SEX,$BIRTHDAY,$OCCUPATION,$REGADD,$QRImgPath,$SNo);
}

function generatePDF($pdf,$CHI_FONT,$ENG_FONT,$REASON,$NOTICE,$OTHERS,$ZIPCODE,$ADDRESS,$RECEIVER,$ELEDIST,$TARGETNAME,$NAME,$IDNo,$SEX,$BIRTHDAY,$OCCUPATION,$REGADD,$QRImgPath,$SNo)
{
$pdf->AddPage();
$pdf->SetFont($CHI_FONT,'',14);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,1,'',0,1);


$add_offset=99;
$form_offset=198;

//說明資訊列===================================
$pdf->SetXY(10,11);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(150,50,$REASON,1,1,'C',true);
$pdf->SetXY(10,63);
$pdf->SetFillColor(150,150,150);
$pdf->Cell(150,30,$NOTICE,1,1,'C',true);
$pdf->SetXY(163,10);
$pdf->SetFillColor(100,100,100);
$pdf->Cell(40,83,$OTHERS,1,1,'C',true);


//地址資訊列===================================
$pdf->SetXY(175,5+$add_offset);
$pdf->Cell(20,25,'郵票',1,1,'C',false);

$pdf->SetXY(80,45+$add_offset);
$pdf->Cell(0,8,$ZIPCODE,0,1,'L',false);
$pdf->SetXY(80,53+$add_offset);
$pdf->Cell(0,8,$ADDRESS,0,0,'L',false);
$pdf->SetXY(80,66+$add_offset);
$pdf->Cell(0,8,$RECEIVER.'　啟',0,0,'L',false);

//QR Code 影像
$pdf->Image($QRImgPath,10,140,40);
//刪除 QR Code 影像
unlink($QRImgPath);
$pdf->SetXY(10,78+$add_offset);
$pdf->Cell(40,12,$SNo,0,1,'C',false);

//連署書表單列===================================
$pdf->SetXY(5,5+$form_offset);
$pdf->SetFont($CHI_FONT,'',24);
$pdf->Cell(205,8,'公職人員罷免連署人名冊',0,0,'C',false);
$pdf->SetFont($CHI_FONT,'',18);

/*$pdf->SetFont($CHI_FONT,'',18);
$pdf->SetFillColor(0,0,125);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0,10,'環世聯訊法律翻譯服務中心 - 服務請款單...',0,1,'C',true);*/

//$pdf->Cell(0,2,'',0,1);

$pdf->SetXY(5,15+$form_offset);
$pdf->SetFont($CHI_FONT,'',12);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(200,8,$ELEDIST.'立法委員'.$TARGETNAME.'罷免案連署人名冊',1,1,'C',false);

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

dashLine($pdf,5,99,200,99,2,2);
dashLine($pdf,5,198,200,198,2,2);

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
	FOR($SEED=0;$SEED<30;$SEED++)
	{
		$FINALSTRING.=$BASESTRING[RAND(0,9)];
	}
	RETURN $FINALSTRING;
}

?>