<?php
	require('inc/sql.php');
	connect_valid();

	$NO_OF_PAGE=$_POST['PNO'];
	$STICKER_PER_PAGE=54;
	$NO_OF_STICKER=$STICKER_PER_PAGE*$NO_OF_PAGE;
	FOR($SEED=0;$SEED<$NO_OF_STICKER;$SEED++)
	{
		$QUERY_STRING="INSERT INTO PROPOSAL(DISTRICT_ID,VALIDATION_CODE,CREATED_TIME)
			VALUES('".
			$_POST['DISTRICT_ID']."','";
			$VCODE=returnValidation();
			$QUERY_STRING.=$VCODE;
			$QUERY_STRING.="',NOW())";
		IF(MYSQL_QUERY($QUERY_STRING))
		{
			$SNO[$SEED]="AP".SPRINTF("%02d",$_POST['DISTRICT_ID'])."1".SPRINTF("%06d",MYSQL_INSERT_ID());
			//複製 QR Code 檔案
			copy("http://140.113.207.111:4000/QRCode/".$SNO[$SEED]."&VC=".$VCODE,$SNO[$SEED].".jpg");
			//設定 QR Code 檔案路徑
			$STICKER[$SEED]=$SNO[$SEED].".jpg";
		}
	}

require('../FPDF/chinese-unicode.php'); 
$CHI_FONT="DFKai-SB";
$ENG_FONT="DFKai-SB";
$pdf=new PDF_Unicode('P','mm','A4');
//0,'Arial',5,5,0,0,0,0,'P'); 
$pdf->SetMargins(0.0,0.0,0.0);
$pdf->AddUniCNShwFont($CHI_FONT); 

$pdf->Open();
$pdf->SetFont('Arial','',12);

//$NO_OF_PAGE=($NO_OF_STICKER-($NO_OF_STICKER%$STICKER_PER_PAGE))/$STICKER_PER_PAGE+1;

//$NO_OF_PAGE=2;
FOR($PAGESEED=0;$PAGESEED<$NO_OF_PAGE;$PAGESEED++)
{
	$pdf->AddPage();
	//QR Code 影像
	FOR($SEED=1;$SEED<$STICKER_PER_PAGE;$SEED++)
	{
		IF($SEED>0)
		{
			$LINE=($SEED-($SEED%6))/6;
		}
		$PIN=$SEED+($STICKER_PER_PAGE*$PAGESEED);
		$pdf->Image($STICKER[$PIN],4+34*($SEED%6),1.5+$LINE*32,32);
		//刪除 QR Code 影像
	}
	$pdf->Image($STICKER[$STICKER_PER_PAGE*$PAGESEED],4,1.5,32);

	$LINE=0;
	FOR($SEED=0;$SEED<$STICKER_PER_PAGE;$SEED++)
	{
		IF($SEED>0)
		{
			$LINE=($SEED-($SEED%6))/6;
		}
		$PIN=$SEED+$STICKER_PER_PAGE*$PAGESEED;
//		$pdf->SetXY(3+34*($SEED%6),28+$LINE*34);
		$pdf->Text(6+34*($SEED%6),34+$LINE*32,$SNO[$PIN]);
//		$pdf->Cell(34,10,$SNO[$PIN],0,1,'C',false);
	}
}

FOR($SEED=0;$SEED<$NO_OF_STICKER;$SEED++)
{
	unlink($STICKER[$SEED]);

}
$pdf->Output();

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

php?>