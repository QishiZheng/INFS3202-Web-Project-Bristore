<?php
//generate a pdf file for invoice
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Order No.'.$order_id.' Invoice');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Bristroe');
$pdf->SetDisplayMode('real', 'default');

$pdf->AddPage();

$pdf->writeHTML($html, true, false, true, false, 'left');
$file_name = $order_id."_invoice";

//TODO: make it dynamic, This PATH ONLY WORKS AT LOCAL
$path = '/Applications/XAMPP/xamppfiles/htdocs/bristore/invoice_pdf/';
$pdf->Output($path.$file_name.'.pdf', 'F');