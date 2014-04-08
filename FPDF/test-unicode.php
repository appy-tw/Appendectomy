<?
require('chinese-unicode.php'); 

$pdf=new PDF_Unicode(); 

$pdf->Open(); 
$pdf->AddPage(); 

$pdf->AddUniCNShwFont('uni'); 
$pdf->SetFont('uni','',20); 

$pdf->Write(10, "1234學生名字\n伃綉堃亘");
$pdf->Ln();
$pdf->MultiCell (120, 10, "服\n務\n單\n位");
$pdf->Cell (240, 10, "本文用UTF8做為中文字編碼, 在這裡還是呼叫同樣的FPDF函數");
$pdf->Ln();

$pdf->Output();

?>
