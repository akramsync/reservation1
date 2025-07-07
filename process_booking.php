require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,"Réservation de Billet");

$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,"Email: {$_POST['email']}", 0, 1);
$pdf->Cell(0,10,"Ville: {$_POST['location']}", 0, 1);
$pdf->Cell(0,10,"Code Postal: {$_POST['zip_code']}", 0, 1);
$pdf->Cell(0,10,"Type de Billet: {$_POST['ticket_type']}", 0, 1);

$pdf->Output('F', 'reservation.pdf');
