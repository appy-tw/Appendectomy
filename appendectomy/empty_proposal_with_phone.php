<?PHP
	require('inc/sql.php');
	connect_valid();

require('../FPDF/chinese-unicode.php'); 
$pdf=new PDF_Unicode(); 

$CHI_FONT="DFKai-SB";
$ENG_FONT="DFKai-SB";
$pdf->AddUniCNShwFont($CHI_FONT); 

$pdf->Open();

IF($_POST['ProDescImgPath']!="")
{
	$QUERY_STRING="UPDATE DISTRICT_DATA SET PRODESCIMGPATH='".$_POST['ProDescImgPath']."' WHERE DISTRICT_ID='".$_POST['DISTRICT_ID']."'";
	MYSQL_QUERY($QUERY_STRING);
}

$QUERY_STRING="UPDATE DISTRICT_DATA SET ";
IF($_POST['RECEIVER']!="")
{
	$QUERY_STRING.="RECEIVER='".$_POST['RECEIVER']."',ZIPCODE='".$_POST['ZIPCODE']."',MAILING_ADDRESS='".$_POST['ADDRESS']."' ";
}
IF($_POST['PREPAID']==1)
{
	$QUERY_STRING.=",PREPAID='1',POSTOFFICE='".$_POST['POSTOFFICE']."',ADV_NO='".$_POST['ADV_NO']."' ";
}
$QUERY_STRING.=" WHERE  DISTRICT_ID='".$_POST['DISTRICT_ID']."'";
MYSQL_QUERY($QUERY_STRING);
$UPDATE_STRING=$QUERY_STRING;

IF($_POST['DISTRICT_ID']!="")
{
	$QUERY_STRING="SELECT * FROM DISTRICT_DATA WHERE DISTRICT_ID='".$_POST['DISTRICT_ID']."'";
	$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
}

//DUMMY DATA
IF($DATA['receiver']=="")
{
	$DATA['reason']="理由";
	$DATA['notice']="注意事項";
	$DATA['others']="其他";
	$DATA['zipcode']="郵遞區號";
	$DATA['mailing_address']="提議書郵寄地址";
	$DATA['receiver']="提議書收件人";
}
$NAME="提議人姓名";

IF($_POST['PREPAID']==0)
{
	$DATA['prepaid']="0";
}

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
	$_POST['Name_0']="";
	$_POST['IDNo_0']="";
	$_POST['Sex_0']="";
	$_POST['Birthday_0']="";
	$_POST['Occupation_0']="";
	$_POST['RegAdd_0']="";	
	$_POST['SNo_0']="";
}

IF($_POST['Size']=="")
{
	$SIZE=1;
}
ELSE
{
	$SIZE=$_POST['Size'];
}

for($SEED=0;$SEED<$SIZE;$SEED++)
{
	$NAME=$_POST['"Name_".$SEED'];
	$IDNo=$_POST['"IDNo_".$SEED'];
	$SEX=$_POST['"Sex_".$SEED'];
	$BIRTHDAY="____.__.__";
	$OCCUPATION=$_POST['"Occupation_".$SEED'];
	$REGADD=$_POST['"RegAdd_".$SEED'];
	$QRImgPath="qrcode.jpg";
	$DescImgPath=$_POST['ProDescImgPath'];
	IF($_POST['"QRImgPath_".$SEED']!="")
		$QRImgPath=$_POST['"QRImgPath_".$SEED'];
	$SNo=$_POST['"SNo_".$SEED'];


	generatePDF($pdf,$CHI_FONT,$ENG_FONT,$DATA,$NAME,$IDNo,$SEX,$BIRTHDAY,$OCCUPATION,$REGADD,$QRImgPath,$SNo,$DescImgPath);
}

function generatePDF($pdf,$CHI_FONT,$ENG_FONT,$DATA,$NAME,$IDNo,$SEX,$BIRTHDAY,$OCCUPATION,$REGADD,$QRImgPath,$SNo,$DescImgPath)
{
$pdf->AddPage();
$pdf->SetFont($CHI_FONT,'',14);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,1,'',0,1);


$add_offset=104;
$form_offset=215;
$first_line=104;
$second_line=203;

//說明資訊列===================================
//$pdf->SetXY(10,11);
$pdf->SetXY(0,0);
$pdf->SetFillColor(240,240,240);
IF($DATA['prodescimgpath']==""&&$DescImgPath=="")
{
	$pdf->Cell(210,99,"可放置長寬比 2 : 1 的圖檔（內容可為罷免理由、注意事項、罷免團體聯絡方式等）",1,1,'C',true);
}
ELSE IF($DescImgPath!="")
{
	$pdf->Image($DescImgPath,0,0,210);
}
ELSE
{
	$pdf->Image($DATA['prodescimgpath'],0,0,210);
}

//地址資訊列===================================
$pdf->SetXY(175,5+$add_offset);
$pdf->Cell(20,25,'郵票',1,1,'C',false);

if($DATA['prepaid']==1)
{
	$pdf->Image("adv_mail.jpg",0,$add_offset,210);
	$pdf->SetXY(141.1,14.7+$add_offset);
	$pdf->SetFont($CHI_FONT,'',11);
	$pdf->Cell(41.5,7.4,$DATA['postoffice']."郵局登記證",０,0,'C',false);
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

$pdf->SetFont($CHI_FONT,'',14);
//QR Code 影像
$pdf->SetXY(10,5+$add_offset);
$pdf->Cell(33,33,"條碼黏貼處",1,0,'C',false);
$pdf->SetXY(10,28+$add_offset);
$pdf->Cell(33,12,$SNo,0,1,'C',false);

//提議書表單列===================================
$pdf->SetXY(145,$form_offset-11);
$pdf->SetFont($CHI_FONT,'',14);
$pdf->Cell(190,8,'聯絡電話：'.$PHONE,0,0,'L',false);

$pdf->SetXY(5,5+$form_offset);
$pdf->SetFont($CHI_FONT,'',24);
$pdf->Cell(205,8,'公職人員罷免提議人名冊',0,0,'C',false);
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
$pdf->Cell(40,8,'',1,0,'C',false);
$pdf->Cell(8,20,'',1,0,'C',true);
$pdf->Cell(26,20,$BIRTHDAY,1,0,'C',true);
$pdf->Cell(20,20,'',1,0,'C',true);
$pdf->Cell(62,20,'',1,0,'C',false);
$pdf->Cell(20,20,'',1,0,'C',true);
$pdf->Cell(12,20,'',1,0,'C',true);
$pdf->Cell(20,8,'',0,1);
//$pdf->Cell(1);
$pdf->SetFont($CHI_FONT,'',14);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(17,47+$form_offset);
$pdf->Cell(4,12,$IDNo['0'],1,0,'C',true);
$pdf->Cell(4,12,$IDNo['1'],1,0,'C',true);
$pdf->Cell(4,12,$IDNo['2'],1,0,'C',true);
$pdf->Cell(4,12,$IDNo['3'],1,0,'C',true);
$pdf->Cell(4,12,$IDNo['4'],1,0,'C',true);
$pdf->Cell(4,12,$IDNo['5'],1,0,'C',true);
$pdf->Cell(4,12,$IDNo['6'],1,0,'C',true);
$pdf->Cell(4,12,$IDNo['7'],1,0,'C',true);
$pdf->Cell(4,12,$IDNo['8'],1,0,'C',true);
$pdf->Cell(4,12,$IDNo['9'],1,0,'C',true);
$pdf->Cell(20,8,'',0,1);

dashLine($pdf,5,$first_line,200,$first_line,2,2);
dashLine($pdf,5,$second_line,200,$second_line,2,2);
dashLine($pdf,10,$second_line+10,190,$second_line+10,2,2);

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
		$FINALSTRING.=$BASESTRING['RAND(0,9)'];
	}
	RETURN $FINALSTRING;
}

?>