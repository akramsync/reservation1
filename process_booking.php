<!-- require('fpdf.php');

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

$pdf->Output('F', 'reservation.pdf'); -->


<?php
$host = "localhost";
$dbname = "canberra_bus";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $location = $_POST['location'];
    $zip_code = $_POST['zip_code'];
    $ticket_type = $_POST['ticket_type'];

    // Enregistrer en base
    $sql = "INSERT INTO reservations (email, location, zip_code, ticket_type) 
            VALUES (:email, :location, :zip_code, :ticket_type)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':location' => $location,
        ':zip_code' => $zip_code,
        ':ticket_type' => $ticket_type
    ]);

    // Redirection selon ticket
    if (isset($_POST['pay_crypto'])) {
        switch ($ticket_type) {
            case 'General':
                header("Location: https://site-general.com/");
                break;
            case 'Floor Standing':
                header("Location: https://site-floor.com/");
                break;
            case 'Golden Circle':
                header("Location: https://site-golden.com/");
                break;
            case 'VIP Seated':
                header("Location: https://site-vip.com/");
                break;
            case 'Meet & Greet':
                header("Location: https://site-meet.com/");
                break;
            default:
                header("Location: https://site-default.com/");
        }
        exit;
    }
}
