<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffle Ticket Generator</title>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="row mb-2">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <h1 class="h4 mb-0 text-gray-800">Raffle Ticket Generator</h1>
                    <a href="#" class="btn btn-primary btn-sm shadow-sm d-none d-md-inline-block history-btn">
                        <i class="fas fa-history fa-xs text-white-50"></i> History
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards - Ultra Compact -->
        <div class="row compact-stats mb-2">
            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card border-left-primary shadow stats-card">
                    <div class="card-body py-1">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tickets</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="ticketsCount">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card border-left-warning shadow stats-card">
                    <div class="card-body py-1">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Size</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="selectedSize">4x3 cm</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ruler text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card border-left-success shadow stats-card">
                    <div class="card-body py-1">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Design</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="designStatus">None</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-image text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card border-left-info shadow stats-card">
                    <div class="card-body py-1">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Status</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="statusReady">Ready</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Form Column -->
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-1">
                        <h6 class="m-0 font-weight-bold text-white">Generate Tickets</h6>
                    </div>
                    <div class="card-body">
                        <div id="message"></div>
                        <form id="ticketForm" enctype="multipart/form-data">
                            <div class="form-group mb-2">
                                <label for="names" class="font-weight-bold text-primary mb-1">Participant Names</label>
                                <small class="form-text text-muted">One name per line</small>
                                <textarea class="form-control" id="names" name="names" rows="4" required 
                                          placeholder="John Doe&#10;Jane Smith&#10;Robert Johnson"></textarea>
                            </div>
                            
                            <div class="form-group mb-2">
                                <label for="design" class="font-weight-bold text-primary mb-1">Ticket Design</label>
                                <small class="form-text text-muted">JPG or PNG files</small>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="design" name="design" accept=".jpg,.png" required>
                                    <label class="custom-file-label" for="design" id="designLabel">Choose file</label>
                                </div>
                            </div>
                            
                            <div class="form-group mb-2">
                                <label for="size" class="font-weight-bold text-primary mb-1">Ticket Size</label>
                                <select class="form-control" id="size" name="size" required>
                                    <option value="4x3">4cm x 3cm</option>
                                    <option value="6x4">6cm x 4cm</option>
                                    <option value="8x5">8cm x 5cm</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-magic fa-fw"></i> Generate Tickets
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Column -->
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header py-1">
                        <h6 class="m-0 font-weight-bold text-white">Preview & Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="preview-title">Preview</div>
                        <div class="ticket-preview mb-2">
                            <div>
                                <i class="fas fa-ticket-alt text-gray-400 mb-1"></i>
                                <p class="small mb-0">Upload design for preview</p>
                            </div>
                        </div>
                        
                        <div class="preview-title">Instructions</div>
                        <ul class="instructions-list text-gray-600">
                            <li>Enter names, one per line</li>
                            <li>Upload JPG/PNG design</li>
                            <li>Select ticket size</li>
                            <li>Generate and download</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script src="js/script.js"></script>
</body>
</html>