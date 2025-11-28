// Raffle Ticket Generator JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeTicketGenerator();
});

function initializeTicketGenerator() {
    // Update stats when form changes
    document.getElementById('names').addEventListener('input', function() {
        const count = this.value.split('\n').filter(name => name.trim() !== '').length;
        document.getElementById('ticketsCount').textContent = count;
    });
    
    document.getElementById('size').addEventListener('change', function() {
        const sizeText = this.options[this.selectedIndex].text;
        document.getElementById('selectedSize').textContent = sizeText;
    });
    
    document.getElementById('design').addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
        document.getElementById('designLabel').textContent = fileName;
        document.getElementById('designStatus').textContent = 'Selected';
        
        // Preview image if available
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.ticket-preview').innerHTML = 
                    `<img src="${e.target.result}" class="img-fluid" alt="Preview" style="max-height: 70px;">`;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Handle form submission
    document.getElementById('ticketForm').addEventListener('submit', function(event) {
        event.preventDefault();
        submitForm(event);
    });
    
    // Handle history button click
    const historyBtn = document.querySelector('.history-btn');
    if (historyBtn) {
        historyBtn.addEventListener('click', function(event) {
            event.preventDefault();
            showHistory();
        });
    }
    
    // Initialize stats
    updateInitialStats();
}

function updateInitialStats() {
    document.getElementById('ticketsCount').textContent = 
        document.getElementById('names').value.split('\n').filter(name => name.trim() !== '').length;
    document.getElementById('selectedSize').textContent = 
        document.getElementById('size').options[document.getElementById('size').selectedIndex].text;
}

function handleSuccess(response) {
    const messageDiv = document.getElementById("message");
    
    if (response.success) {
        messageDiv.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="fas fa-check-circle"></i> Success! 
                <a href="${response.path}" target="_blank" class="btn btn-success btn-sm ml-1 py-1" style="font-size: 0.8rem;">
                    <i class="fas fa-download"></i> Download
                </a>
                <button type="button" class="close py-1" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>`;
        
        // Add to history
        addToHistory(response.path, document.getElementById('names').value.split('\n').length);
    } else {
        messageDiv.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <i class="fas fa-exclamation-triangle"></i> ${response.message}
                <button type="button" class="close py-1" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>`;
    }
}

async function submitForm(event) {
    event.preventDefault();
    
    // Show loading state
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
    submitBtn.disabled = true;
    
    try {
        const formData = new FormData(event.target);
        const response = await fetch('generate.php', { 
            method: 'POST', 
            body: formData 
        });
        const jsonResponse = await response.json();
        handleSuccess(jsonResponse);
    } catch (error) {
        document.getElementById("message").innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <i class="fas fa-exclamation-triangle"></i> Error: ${error.message}
                <button type="button" class="close py-1" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>`;
    } finally {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

// History functionality
function addToHistory(filePath, ticketCount) {
    let history = JSON.parse(localStorage.getItem('ticketHistory') || '[]');
    
    const historyItem = {
        id: Date.now(),
        filePath: filePath,
        ticketCount: ticketCount,
        timestamp: new Date().toLocaleString(),
        size: document.getElementById('size').value
    };
    
    history.unshift(historyItem); // Add to beginning
    history = history.slice(0, 10); // Keep only last 10 items
    
    localStorage.setItem('ticketHistory', JSON.stringify(history));
}

function showHistory() {
    const history = JSON.parse(localStorage.getItem('ticketHistory') || '[]');
    
    if (history.length === 0) {
        alert('No generation history found.');
        return;
    }
    
    // Create modal for history
    const modalHtml = `
        <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="historyModalLabel">Generation History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Tickets</th>
                                        <th>Size</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${history.map(item => `
                                        <tr>
                                            <td>${item.timestamp}</td>
                                            <td>${item.ticketCount}</td>
                                            <td>${item.size}</td>
                                            <td>
                                                <a href="${item.filePath}" target="_blank" class="btn btn-sm btn-success">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                                <button onclick="deleteHistoryItem(${item.id})" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="clearAllHistory()">Clear All History</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('historyModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body and show it
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    $('#historyModal').modal('show');
}

function deleteHistoryItem(id) {
    let history = JSON.parse(localStorage.getItem('ticketHistory') || '[]');
    history = history.filter(item => item.id !== id);
    localStorage.setItem('ticketHistory', JSON.stringify(history));
    
    // Refresh the modal
    $('#historyModal').modal('hide');
    setTimeout(() => showHistory(), 300);
}

function clearAllHistory() {
    if (confirm('Are you sure you want to clear all history?')) {
        localStorage.removeItem('ticketHistory');
        $('#historyModal').modal('hide');
        alert('History cleared successfully.');
    }
}

// Make functions available globally for modal buttons
window.deleteHistoryItem = deleteHistoryItem;
window.clearAllHistory = clearAllHistory;