<?php
/*require('chinese.php');

$pdf=new PDF_Chinese();
$pdf->AddBig5Font();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Big5','',20);
$pdf->Write(10,'現時氣溫 18 C 濕度 83 %');
$pdf->Output();*/

require('chinese.php'); 

$pdf=new PDF_Chinese(); 
$pdf->AddBig5hwFont('kai-hw', iconv ('utf-8', 'big5', '標楷體')); 
$pdf->AddUniCNShwFont('uni-hw'); 
$pdf->Open(); 
$pdf->AddPage(); 
$pdf->SetFont('uni-hw','',20); 
$pdf->Write(10,iconv('utf8','big5',"楊逸珉服務 18 C 濕度 83 %")); 
/*$pdf->Ln(); 
$pdf->SetFont('kai-hw','',20); 
$pdf->Write(10,iconv('utf8', 'big5', '現時氣溫 18 C 濕度 83 %')); 
$pdf->Ln(); 
$pdf->SetFont('uni-hw','',20); 
$pdf->Write(10,iconv('utf8', 'utf16be', '特別的 Unicode 中文字: 伃堃綉亘学')); */
$pdf->Ln(); 
$pdf->Output(); 
?>
