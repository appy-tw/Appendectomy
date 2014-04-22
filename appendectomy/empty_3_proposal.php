<?PHP
	require('inc/sql.php');
	connect_valid();

require('../FPDF/chinese-unicode.php'); 
$pdf=new PDF_Unicode(); 

$CHI_FONT="DFKai-SB";
$ENG_FONT="DFKai-SB";
$pdf->AddUniCNShwFont($CHI_FONT); 

$pdf->Open();

IF($_POST['DISTRICT_ID']!="")
{
	$QUERY_STRING="SELECT * FROM DISTRICT_DATA WHERE DISTRICT_ID='".$_POST['DISTRICT_ID']."'";
	$DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
}
ELSE
{
	$QUERY_STRING="SELECT * FROM DISTRICT_DATA WHERE DISTRICT_ID='1'";
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

generatePDF($pdf,$CHI_FONT,$ENG_FONT,$DATA);

function generatePDF($pdf,$CHI_FONT,$ENG_FONT,$DATA)
{
	$pdf->AddPage();
	$pdf->SetFont($CHI_FONT,'',14);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(0,1,'',0,1);

	//第一空白列===================================
	showEmptyForm($pdf,$DATA,15);

	//第二空白列===================================
	showEmptyForm($pdf,$DATA,114);

	//第三空白列===================================
	showEmptyForm($pdf,$DATA,213);
}

$first_line=99;
$second_line=198;

dashLine($pdf,5,$first_line,200,$first_line,2,2);
dashLine($pdf,5,$second_line,200,$second_line,2,2);


$pdf->Output();

FUNCTION showEmptyForm($pdf,$DATA,$form_offset)
{
	$pdf->SetXY(5,5+$form_offset);
	$pdf->SetFont($CHI_FONT,'',24);
	$pdf->Cell(205,8,'公職人員罷免提議人名冊',0,0,'C',false);
	$pdf->SetFont($CHI_FONT,'',18);

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
	$pdf->Cell(26,20,'____.__.__',1,0,'C',true);
	$pdf->Cell(20,20,'',1,0,'C',true);
	$pdf->Cell(62,20,'',1,0,'C',false);
	$pdf->Cell(20,20,'',1,0,'C',true);
	$pdf->Cell(12,20,'',1,0,'C',true);
	$pdf->Cell(20,8,'',0,1);
	$pdf->SetFont($CHI_FONT,'',14);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetXY(17,47+$form_offset);
	FOR($SEED=0;$SEED<10;$SEED++)
	{
		$pdf->Cell(4,12,'',1,0,'C',true);
	}
	$pdf->Cell(20,8,'',0,1);
}

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