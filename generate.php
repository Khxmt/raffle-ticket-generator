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

        // Validate ticket size selection
        if (empty($_POST['size']) || !in_array($_POST['size'], ['4x3', '6x4', '8x5'])) {
            throw new Exception('Invalid ticket size selected.');
        }
        list($ticketWidth, $ticketHeight) = explode('x', $_POST['size']);
        $ticketWidth = (float)$ticketWidth;
        $ticketHeight = (float)$ticketHeight;

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
            if ($x + $ticketWidth > 21) {
                $x = 1;
                $y += $ticketHeight + 0.5;
            }
            if ($y + $ticketHeight > 29.7) {
                $pdf->AddPage();
                $x = 1;
                $y = 1;
            }

            // Draw the ticket design image
            $pdf->Image($designPath, $x, $y, $ticketWidth, $ticketHeight);

            // Auto-fit text to ticket size
            $pdf->SetFont('Arial', 'B');
            $fontSize = 12;
            $maxWidth = $ticketWidth - 1; // Leave margin
            do {
                $pdf->SetFontSize($fontSize);
                $textWidth = $pdf->GetStringWidth($name);
                if ($textWidth > $maxWidth) {
                    $fontSize -= 0.5;
                } else {
                    break;
                }
            } while ($fontSize > 6); // Ensure readability

            // Split name if too long
            $textLines = [];
            if ($pdf->GetStringWidth($name) > $maxWidth) {
                $textLines = explode("\n", wordwrap($name, ceil($maxWidth / $pdf->GetStringWidth('W')), "\n"));
            } else {
                $textLines[] = $name;
            }

            // Center and draw text on ticket
            $textY = $y + ($ticketHeight / 2) - (count($textLines) * 0.2);
            foreach ($textLines as $line) {
                $textWidth = $pdf->GetStringWidth($line);
                $textX = $x + ($ticketWidth - $textWidth) / 2;
                $pdf->SetXY($textX, $textY);
                $pdf->Cell($textWidth, 0.4, $line, 0, 1, 'C');
                $textY += 0.5; // Line spacing
            }

            // Draw a signature line
            $pdf->Line($x + 0.5, $y + $ticketHeight - 0.3, $x + $ticketWidth - 0.5, $y + $ticketHeight - 0.3);

            // Move to the next ticket position
            $x += $ticketWidth + 0.5;
        }

        // Save the PDF file
        $outputPath = $outputDir . '/tickets.pdf';
        $pdf->Output('F', $outputPath);

        // Return success response
        echo json_encode(['success' => true, 'path' => $outputPath]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
