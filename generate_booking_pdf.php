<?php
ob_end_clean(); // Clear any previous output buffer
require('includes/fpdf/fpdf.php');
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['booking_id'])) {
    header('Location: login.php');
    exit();
}

$booking_id = $_POST['booking_id'];
$user_id = $_SESSION['user_id'];

// Get booking details with all necessary information including seat prices
$booking_query = "SELECT b.id, b.bus_id, b.seat_numbers, b.booking_time, b.status, 
                 u.username, u.email, r.route_name, bu.bus_number, bu.date, bu.time,
                 (SELECT price FROM seats s WHERE s.bus_id = b.bus_id AND FIND_IN_SET(s.seat_number, b.seat_numbers) LIMIT 1) as seat_price,
                 (SELECT SUM(s.price) FROM seats s WHERE s.bus_id = b.bus_id AND FIND_IN_SET(s.seat_number, b.seat_numbers)) as total_price
                 FROM bookings b
                 JOIN users u ON b.user_id = u.id
                 JOIN buses bu ON b.bus_id = bu.id
                 JOIN routes r ON bu.route_id = r.id
                 WHERE b.id = ? AND b.user_id = ?";

$stmt = $conn->prepare($booking_query);
if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die('Booking not found or unauthorized access');
}

// Calculate seat details
$seat_numbers = explode(',', $booking['seat_numbers']);
$seat_price = $booking['seat_price'];
$total_price = $booking['total_price'];

// Create custom PDF class for the e-ticket
class ETicket extends FPDF {
    function Header() {
        // This is intentionally empty as we'll handle the header in the main content
    }
    
    function Footer() {
        // Add a subtle footer
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
    }

    function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234') {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));

        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));

        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));

        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', 
            $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k,
            $x3*$this->k, ($h-$y3)*$this->k));
    }
}

// Initialize PDF with landscape orientation and millimeter unit
$pdf = new ETicket('L', 'mm', array(200, 80));
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

// Set background color
$pdf->SetFillColor(240, 240, 240);
$pdf->Rect(0, 0, 200, 80, 'F');

// Add decorative elements - slightly smaller border to prevent text overflow
$pdf->SetDrawColor(0, 64, 128);
$pdf->SetLineWidth(0.5);
$pdf->RoundedRect(5, 5, 190, 70, 3);

// Add logo - slightly smaller and repositioned
$pdf->Image('assets/images/logo.png', 8, 8, 25);

// Company name and heading - adjusted position
$pdf->SetFont('Arial', 'B', 22);
$pdf->SetTextColor(0, 64, 128);
$pdf->SetXY(35, 10);
$pdf->Cell(100, 10, 'GOBus E-Ticket', 0, 0, 'L');

// Booking reference - adjusted position
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(128, 128, 128);
$pdf->SetXY(35, 20);
$pdf->Cell(100, 6, 'Booking Reference: ' . sprintf('%06d', $booking['id']), 0, 0, 'L');

// Draw a dotted line for tear-off - moved slightly left
$pdf->SetLineWidth(0.2);
$pdf->SetDrawColor(128, 128, 128);
for($i=5; $i<75; $i+=5) {
    $pdf->Line(145, $i, 145, $i+2);
}

// Main ticket section (left side) - adjusted positions and font sizes
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(0, 0, 0);

// Journey details - reorganized layout
$pdf->SetXY(8, 30);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 6, 'Passenger:', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(105, 6, $booking['username'], 0, 1);

$pdf->SetXY(8, 37);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 6, 'Route:', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(105, 6, $booking['route_name'], 0, 1);

$pdf->SetXY(8, 44);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 6, 'Date:', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(105, 6, date('d M Y', strtotime($booking['date'])), 0, 1);

$pdf->SetXY(8, 51);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 6, 'Time:', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(105, 6, date('H:i', strtotime($booking['time'])), 0, 1);

// Add bus and seat info - adjusted layout
$pdf->SetXY(8, 58);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 6, 'Bus No:', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(35, 6, $booking['bus_number'], 0, 1);

$pdf->SetXY(8, 65);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 6, 'Seat(s):', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(35, 6, $booking['seat_numbers'], 0, 1);

// Price information section
$pdf->SetXY(75, 58);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 6, 'Price/Seat:', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(35, 6, '$' . number_format($seat_price, 2), 0, 1);

$pdf->SetXY(75, 65);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 6, 'Total Price:', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(35, 6, '$' . number_format($total_price, 2), 0, 1);

// Tear-off stub (right side) - adjusted position and sizes
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetXY(150, 30);
$pdf->Cell(40, 6, 'Quick Reference', 0, 1, 'C');

$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(150, 38);
$pdf->Cell(40, 5, substr($booking['username'], 0, 15), 0, 1, 'C');
$pdf->SetXY(150, 43);
$pdf->Cell(40, 5, 'Bus: ' . $booking['bus_number'], 0, 1, 'C');
$pdf->SetXY(150, 48);
$pdf->Cell(40, 5, 'Seat(s): ' . $booking['seat_numbers'], 0, 1, 'C');
$pdf->SetXY(150, 53);
$pdf->Cell(40, 5, date('d M Y H:i', strtotime($booking['date'] . ' ' . $booking['time'])), 0, 1, 'C');

// Add QR code placeholder - adjusted position
$pdf->SetXY(150, 60);
$pdf->Cell(40, 15, 'QR Code Here', 1, 0, 'C');

// Output PDF
$pdf->Output('D', 'GOBus_Ticket_' . sprintf('%06d', $booking['id']) . '.pdf');
