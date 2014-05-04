<?php

// D�finition facultative du r�pertoire des polices syst�mes
// Sinon tFPDF utilise le r�pertoire [chemin vers tFPDF]/font/unifont/
// define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");

require('tfpdf.php');

$pdf = new tFPDF();
$pdf->AddPage();

// Ajoute une police Unicode (utilise UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',14);

// Charge une cha�ne UTF-8 � partir d'un fichier
$txt = file_get_contents('HelloWorld.txt');
$pdf->Write(8,$txt);

// S�lectionne une police standard (utilise windows-1252)
$pdf->SetFont('Arial','',14);
$pdf->Ln(10);
$pdf->Write(5,"La taille de ce PDF n'est que de 12 ko.");

$pdf->Output();
?>
