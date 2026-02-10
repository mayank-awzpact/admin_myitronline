<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @livewireStyles
    <style>
        .footer-link {
    position: relative;
    color: white;
    text-decoration: none;
    display: inline; 
    background-image: linear-gradient(to right, white 100%, transparent 0%);
    background-position: 0 100%;  
    background-size: 0% 2px;     
    background-repeat: no-repeat;
    transition: background-size 1.5s ease;  
}

.footer-link:hover {
    background-size: 100% 2px;  
}

.text-link {
    position: relative;
    color: rgb(0, 0, 0);
    text-decoration: none;
    display: inline; 
    background-image: linear-gradient(to right, rgb(3, 3, 3) 100%, transparent 0%);
    background-position: 0 100%;  
    background-size: 0% 2px;     
    background-repeat: no-repeat;
    transition: background-size 1.5s ease;  
}

.text-link:hover {
    background-size: 100% 2px;  
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}
.bi-bookmark-star , .bi-megaphone , .bi-images{
    display: inline-block;
    animation: pulse 1.5s infinite ease-in-out;
}



.tiny-slider {
    position: relative;
    color: rgb(7, 7, 7);
    text-decoration: none;
    display: inline; 
    background-image: linear-gradient(to right, rgb(8, 8, 8) 100%, transparent 0%);
    background-position: 0 100%;  
    background-size: 0% 1px;      
    background-repeat: no-repeat;
    transition: background-size 1.5s ease;  
}

.tiny-slider:hover {
    background-size: 100% 1px; 
}


.card-fold {
  position: relative;
  -webkit-transform: translateZ(0);
          transform: translateZ(0);
  -webkit-box-shadow: 0 0 1px rgba(0, 0, 0, 0);
          box-shadow: 0 0 1px rgba(0, 0, 0, 0);
}

.card-fold:after {
  position: absolute;
  content: "";
  height: 0;
  width: 0;
  bottom: 0;
  right: 0;
  z-index: 1000;
  background: linear-gradient(-45deg, var(--bs-body-bg) 45%, var(--bs-body-bg) 45%, #d0d4d9 50%, #fff 70%);
  -webkit-box-shadow: -5px -5px 5px rgba(0, 0, 0, 0.4);
          box-shadow: -5px -5px 5px rgba(0, 0, 0, 0.4);
  -webkit-transition: 0.3s;
  transition: 0.3s;
  border-radius: 0.7rem 0px 0px 0px;
}

.card:hover .card-fold:after,
.card:focus .card-fold:after,
.card:active .card-fold:after,
.card:hover.card-fold:after,
.card:focus.card-fold:after,
.card:active.card-fold:after {
  width: 40px;
  height: 40px;
}

.bg-dark .card-fold:after {
  --bs-bg-opacity: 1;
  background: linear-gradient(-45deg, rgba(var(--bs-dark-rgb), var(--bs-bg-opacity)) 45%, #000 45%, #d0d4d9 50%, #fff 70%);
}

.card-bg-scale {
        transition: transform 0.2s ease-in-out;
        background-size: contain;
    }

    .card-bg-scale:hover {
        transform: scale(1.1); /* Zoom in on hover */
    }

    

    </style>
    
    
      
</head>
<body>
    @livewire('navbar')
    <main class="py-1">

        @yield('content') 
    </main>
    
    @include('layouts.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>

    
    @livewireScripts
</body>
</html>
