<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffle Ticket Generator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        function handleSuccess(response) {
            if (response.success) {
                const messageDiv = document.getElementById("message");
                messageDiv.innerHTML = `
                    <div class="alert alert-success">
                        Tickets generated successfully! 
                        <a href="${response.path}" target="_blank" download>Download PDF</a>
                    </div>`;
            } else {
                const messageDiv = document.getElementById("message");
                messageDiv.innerHTML = `<div class="alert alert-danger">${response.message}</div>`;
            }
        }

        async function submitForm(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const response = await fetch('generate.php', { method: 'POST', body: formData });
            const jsonResponse = await response.json();
            handleSuccess(jsonResponse);
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Raffle Ticket Generator</h2>
        <div id="message"></div>
        <form id="ticketForm" onsubmit="submitForm(event)" enctype="multipart/form-data">
            <div class="form-group">
                <label for="names">Participant Names (one per line):</label>
                <textarea class="form-control" id="names" name="names" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <label for="design">Upload Ticket Skin (.jpg/.png):</label>
                <input type="file" class="form-control-file" id="design" name="design" accept=".jpg,.png" required>
            </div>
            <div class="form-group">
                <label for="size">Choose Ticket Size:</label>
                <select class="form-control" id="size" name="size" required>
                    <option value="4x3">4cm x 3cm</option>
                    <option value="6x4">6cm x 4cm</option>
                    <option value="8x5">8cm x 5cm</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Generate Tickets</button>
        </form>
    </div>
</body>
</html>
