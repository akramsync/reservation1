<?php
require_once('fpdf/fpdf.php');

class ReportTemplate extends FPDF {
    private $reportTitle;
    private $reportType;
    private $filterData;

    function __construct($orientation = 'L', $unit = 'mm', $size = 'A4', $title = '', $type = '', $filters = []) {
        parent::__construct($orientation, $unit, $size);
        $this->reportTitle = $title;
        $this->reportType = $type;
        $this->filterData = $filters;
        $this->SetAutoPageBreak(true, 25);
    }

    // Page Header
    function Header() {
        // Add logo
        $this->Image('../assets/images/logo.png', 10, 10, 30);
        
        // Company name and report title with gradient background
        $this->SetFillColor(0, 64, 128); // Dark blue
        $this->Rect(0, 0, $this->GetPageWidth(), 40, 'F');
        
        // White text for header
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 24);
        $this->SetXY(45, 10);
        $this->Cell(0, 10, 'GOBus Booking System', 0, 1, 'L');
        
        $this->SetFont('Arial', '', 14);
        $this->SetXY(45, 22);
        $this->Cell(0, 10, $this->reportTitle, 0, 1, 'L');
        
        // Reset text color
        $this->SetTextColor(0, 0, 0);
        
        // Filter section with light gray background
        if (!empty($this->filterData)) {
            $this->SetFillColor(245, 245, 245);
            $this->Rect(10, 45, $this->GetPageWidth() - 20, 20, 'F');
            
            $this->SetFont('Arial', 'B', 10);
            $this->SetXY(15, 48);
            $this->Cell(30, 6, 'Filters:', 0, 0, 'L');
            
            $this->SetFont('Arial', '', 10);
            $x = 50;
            foreach ($this->filterData as $label => $value) {
                $filterText = $label . ': ' . $value;
                $this->SetXY($x, 48);
                $this->Cell(80, 6, $filterText, 0, 0, 'L');
                $x += 85;
            }
        }
        
        // Add some space before the content
        $this->Ln(30);
    }

    // Page Footer
    function Footer() {
        $this->SetY(-20);
        
        // Draw line
        $this->SetDrawColor(0, 64, 128);
        $this->Line(10, $this->GetY(), $this->GetPageWidth() - 10, $this->GetY());
        
        // Footer text
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
        
        // Generation date
        $this->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'R');
    }

    // Table Header
    function TableHeader($headers, $widths) {
        // Header row with gradient background
        $this->SetFillColor(0, 64, 128);
        $this->SetTextColor(255);
        $this->SetFont('Arial', 'B', 11);
        
        foreach ($headers as $i => $header) {
            $this->Cell($widths[$i], 10, $header, 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Reset text color
        $this->SetTextColor(0);
    }

    // Table Row
    function TableRow($data, $widths, $fill = false) {
        $this->SetFont('Arial', '', 10);
        
        // Alternate row colors
        $this->SetFillColor(245, 245, 245);
        
        foreach ($data as $i => $value) {
            // Determine alignment based on content type
            $align = is_numeric($value) ? 'R' : 'L';
            if (strpos($value, '$') !== false) $align = 'R'; // Right align for currency
            
            $this->Cell($widths[$i], 8, $value, 1, 0, $align, $fill);
        }
        $this->Ln();
    }

    // Summary Section
    function AddSummary($summaryData) {
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, 'Summary', 0, 1, 'L');
        
        $this->SetFont('Arial', '', 11);
        foreach ($summaryData as $label => $value) {
            $this->SetFillColor(245, 245, 245);
            $this->Cell(120, 8, $label, 1, 0, 'L', true);
            $this->Cell(80, 8, $value, 1, 1, 'R', true);
        }
    }

    // Add Chart (if needed)
    function AddChart($title, $data) {
        // Implementation for charts if needed
        // This would require additional libraries or manual chart drawing
    }
} 