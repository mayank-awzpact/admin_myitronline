
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .offcanvas {
            width: 300px;
        }

        .offcanvas-header {
            border-bottom: 1px solid #dee2e6;
        }

        .offcanvas-body ul {
            padding: 0;
        }

        .offcanvas-body ul li a {
            color: #333;
            font-weight: 500;
            text-decoration: none;
        }

        .offcanvas-body ul li a:hover {
            color: #0d6efd;
        }
        
    </style>
</head>
<body>

<header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom py-1">
        <div class="container d-flex justify-content-between align-items-center">

            <ul class="navbar-nav flex-row">
                
                <li class="nav-item me-3"><a class="nav-link" href="{{ url('/Contact') }}">Contact Us</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="{{ url('/privacy_policy') }}">Privacy</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="{{ url('/author') }}">Author</a></li>
                
            </ul>

            <div class="d-flex align-items-center">

                <div class="btn-group me-3">
                    <button id="decreaseFont" class="btn btn-outline-primary btn-sm">A-</button>
                    <button id="defaultFont" class="btn btn-outline-primary btn-sm">A</button>
                    <button id="increaseFont" class="btn btn-outline-primary btn-sm">A+</button>
                </div>
                <div class="btn-group me-3">
                    <livewire:language-switcher />
                </div>

                
                
                <div class="d-flex align-items-center">
                    <a href="https://www.facebook.com/myitronline" class="text-dark me-2"><i class="bi bi-facebook"></i></a>
                    <a href="https://twitter.com/myitronline" class="text-dark me-2"><i class="bi bi-twitter-x"></i></a>
                    <a href="https://www.instagram.com/myitronline/" class="text-dark me-2"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/myitronline" class="text-dark me-2"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-2">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="/">
                {{-- <i class="bi bi-chat-left-quote-fill text-primary me-2 fs-4"></i>
                <strong>blogzine</strong> --}}
                <img src="{{  asset('storage/img/ApnoKaCAcolor.svg') }}" alt="Logo" class="img-fluid" style="width: 150px;">

            </a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 d-flex flex-wrap gap-2">
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/income-tax') }}">Income tax</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/gst') }}">GST</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/finance') }}">Finance</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/rbi') }}">RBI</a></li>
                    <li class="nav-item d-flex align-items-center"> 
                        <a class="nav-link text-danger fw-bold" href="{{ url('/budget') }}">Budget</a>
                        <span class="badge bg-success ms-1">New</span>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/compliance') }}">Compliance</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/notice') }}">Notice</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/Pan_Aadhaar_News') }}">Pan & Aadhaar News</a></li>
                </ul>
                
                <div class="d-flex align-items-center">
                    {{-- <button class="btn btn-danger me-3">Subscribe!</button> --}}
                    {{-- <i class="bi bi-search fs-5 me-3"></i> --}}

                    <i class="bi bi-list fs-4" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu"></i>
                </div>
            </div>
        </div>
    </nav>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title d-flex align-items-center" id="offcanvasMenuLabel">
                <img src="{{  asset('storage/img/ApnoKaCAcolor.svg') }}" alt="Logo" class="img-fluid" style="width: 150px;">
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p class="small">
                Navigate the World of Finance and Money with Ease! apnokaca.com is a One-Stop solution for all legal & Financial blogs & updates! Empowering You with Knowledge to Make Informed Decisions! Stay Ahead for the latest legal and financial with apnokaca.com!
            </p>

            <p class="small">
                An exclusive national news network with a Delhi base is labeled apnokaca. Its English-language channels target the legal and financial sectors. To make legal and financial services simple to understand for our readership & viewers is our objective.
            </p>

            <ul class="list-unstyled">
                <li><a href="#" class="d-block py-2">Home</a></li>
                <li><a href="#" class="d-block py-2">About</a></li>
                <li><a href="#" class="d-block py-2">Contact Us</a></li>
            </ul>

            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                               href="https://www.facebook.com/myitronline" target="_blank" style="width: 40px; height: 40px;">
                               <i class="bi bi-facebook"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                               href="https://twitter.com/myitronline" target="_blank" style="width: 40px; height: 40px;">
                               <i class="bi bi-twitter-x"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                               href="https://www.instagram.com/myitronline/" target="_blank" style="width: 40px; height: 40px;">
                               <i class="bi bi-instagram"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                               href="https://www.linkedin.com/company/myitronline" target="_blank" style="width: 40px; height: 40px;">
                               <i class="bi bi-linkedin"></i>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="mt-auto pb-3 pt-3 bg-light rounded shadow-sm p-3">
                <p class="text-dark mb-2 fw-bold fs-5">
                    <i class="bi bi-geo-alt-fill me-2"></i>Patparganj, Delhi (HQ)
                </p>
                <address class="mb-3 text-muted">
                    305, 3rd Floor, Plot No. 51, Hasanpur, I.P. Extension, 110092
                </address>
                <a href="mailto:info@myitronline.com" class="text-decoration-none text-primary fw-semibold d-block">
                    <i class="bi bi-envelope-fill me-2"></i>Myitronline Global Services
                </a>
            </div>
            
            
        </div>
    </div>
</header>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var offcanvasElement = document.getElementById('offcanvasMenu');
        if (offcanvasElement) {
            var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
        }

        // Font size changer functionality
        let body = document.body;
        let currentFontSize = 16; // Default font size in pixels

        document.getElementById('decreaseFont').addEventListener('click', function () {
            if (currentFontSize > 12) { // Minimum font size limit
                currentFontSize -= 2;
                body.style.fontSize = currentFontSize + 'px';
            }
        });

        document.getElementById('defaultFont').addEventListener('click', function () {
            currentFontSize = 18; // Reset to default
            body.style.fontSize = currentFontSize + 'px';
        });

        document.getElementById('increaseFont').addEventListener('click', function () {
            if (currentFontSize < 24) { // Maximum font size limit
                currentFontSize += 2;
                body.style.fontSize = currentFontSize + 'px';
            }
        });
    });
   

    
</script>

