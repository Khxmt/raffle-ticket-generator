<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffle Ticket Generator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .ticket-preview {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .ticket {
            width: 4cm;
            height: 3cm;
            margin: 5px;
            border: 1px solid #ccc;
            position: relative;
            background-size: cover;
            background-position: center;
        }
        .ticket-name {
            position: absolute;
            bottom: 30px;
            width: 100%;
            text-align: center;
            font-weight: bold;
        }
        .signature-line {
            position: absolute;
            bottom: 10px;
            width: 80%;
            border-bottom: 1px solid #000;
            left: 10%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Raffle Ticket Generator</h2>
        <div id="alertMessage" class="alert d-none"></div>
        <form id="ticketForm" method="POST" action="generate.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="names" class="form-label">Participant Names (one per line):</label>
                <textarea class="form-control" id="names" name="names" rows="8" required></textarea>
            </div>
            <div class="mb-3">
                <label for="design" class="form-label">Upload Ticket Design (.jpg or .png 4cm x 3cm):</label>
                <input type="file" class="form-control" id="design" name="design" accept=".jpg,.png" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Generate Tickets</button>
        </form>
    </div>

    <script>
        document.getElementById('ticketForm').onsubmit = async (event) => {
            event.preventDefault();
            const formData = new FormData(event.target);
            try {
                const response = await fetch('generate.php', { method: 'POST', body: formData });
                const result = await response.json();
                const alertBox = document.getElementById('alertMessage');
                if (result.success) {
                    alertBox.className = 'alert alert-success';
                    alertBox.innerHTML = `<strong>Success!</strong> Tickets have been generated. 
                        <a href="${result.path}" target="_blank">Download PDF</a>`;
                } else {
                    alertBox.className = 'alert alert-danger';
                    alertBox.textContent = result.message || 'An error occurred. Please try again.';
                }
            } catch (error) {
                alertBox.className = 'alert alert-danger';
                alertBox.textContent = 'An error occurred. Please check your inputs and try again.';
            }
            alertBox.classList.remove('d-none');
        };
    </script>
</body>
</html>
