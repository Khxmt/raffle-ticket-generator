<?php
require('fpdf.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate and process participant names
        if (empty($_POST['names'])) {
            throw new Exception('Participant names cannot be empty.');
        }
        $names = array_filter(array_map('trim', explode(PHP_EOL, $_POST['names'])));

        // Validate the uploaded design file
        if (!isset($_FILES['design']) || empty($_FILES['design']['tmp_name'])) {
            throw new Exception('No design file uploaded.');
        }
        $design = $_FILES['design'];
        if (!in_array($design['type'], ['image/jpeg', 'image/png'])) {
            throw new Exception('Only JPEG and PNG files are supported.');
        }

        // Create necessary directories
        $uploadDir = 'uploads';
        $outputDir = 'output';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        if (!is_dir($outputDir)) mkdir($outputDir, 0777, true);

        // Move the uploaded design file to a permanent location
        $extension = pathinfo($design['name'], PATHINFO_EXTENSION);
        $designPath = $uploadDir . '/ticket_design.' . $extension;
        if (!move_uploaded_file($design['tmp_name'], $designPath)) {
            throw new Exception('Failed to upload the design file.');
        }

        // Initialize PDF generation
        $pdf = new FPDF('P', 'cm', 'A4');
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        $x = 1;
        $y = 1;

        foreach ($names as $name) {
            // Adjust position for next row or page
            if ($x + 4 > 21) { // Exceeds page width
                $x = 1;
                $y += 3.5;
            }
            if ($y + 3 > 29.7) { // Exceeds page height
                $pdf->AddPage();
                $x = 1;
                $y = 1;
            }

            // Draw the ticket design image
            $pdf->Image($designPath, $x, $y, 4, 3);

            // Split the name into two lines if it exceeds 20 characters
            $maxCharsPerLine = 16; // Adjust the character limit as needed
            if (strlen($name) > $maxCharsPerLine) {
                $nameLines = wordwrap($name, $maxCharsPerLine, "\n", true);
                $nameArray = explode("\n", $nameLines);
            } else {
                $nameArray = [$name];
            }

            // Dynamically adjust font size based on the number of lines
            $fontSize = 10;
            if (count($nameArray) > 1) {
                $fontSize = 8; // Reduce font size for two lines
            }
            $pdf->SetFont('Arial', 'B', $fontSize);
            $lineHeight = 0.5; // Line height for text

            // Print each line of the name, centered
            $textY = $y + 1.2; // Starting Y position for the text
            foreach ($nameArray as $line) {
                $textWidth = $pdf->GetStringWidth($line);
                $textX = $x + (4 - $textWidth) / 2; // Center text horizontally
                $pdf->SetXY($textX, $textY);
                $pdf->Cell($textWidth, $lineHeight, $line, 0, 1, 'C');
                $textY += $lineHeight; // Move to the next line
            }

            // Draw a signature line
            $pdf->Line($x + 0.5, $y + 2.8, $x + 3.5, $y + 2.8);

            // Move to the next ticket position
            $x += 4.5;
        }

        // Save the PDF file
        $outputPath = $outputDir . '/tickets.pdf';
        $pdf->Output('F', $outputPath);

        // Return success response
        echo json_encode(['success' => true, 'path' => $outputPath]);
    } catch (Exception $e) {
        // Return error response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
