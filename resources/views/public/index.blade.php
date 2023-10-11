<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/css/dashboard-styles.css') }}" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('DASHBOARD_ASSETS/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ url('DASHBOARD_ASSETS/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('DASHBOARD_ASSETS/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('DASHBOARD_ASSETS/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    {{-- toastr --}}
    <link href="{{ asset('vendor/css/toastr.min.css') }}" rel="stylesheet">
    <style>
        .masthead {
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/4/4d/University_of_Ilorin_logo.jpg');
            background-size: cover;
            background-position: center;
            height: 500px;
        }
    </style>
    
</head>

<body>
    <div class="container">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <!-- Add the VMS logo here -->
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/4d/University_of_Ilorin_logo.jpg"
                    alt="VMS Logo" height="40" />
                VMS
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="ml-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            @auth
                                @if (auth()->user()->role === 'security')
                                    <!-- Show security dashboard link if user is logged in as security -->
                                    <a class="btn btn-primary navlink" href="{{ route('security.dashboard') }}">Security
                                        Dashboard</a>
                                @elseif (auth()->user()->role === 'resident')
                                    <!-- Show resident dashboard link if user is logged in as resident -->
                                    <a class="btn btn-primary navlink" href="{{ route('resident.dashboard') }}">Resident
                                        Dashboard</a>
                                @endif
                                <!-- Add logout button if user is logged in -->
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Logout</button>
                                </form>
                            @else
                                <!-- Show signup and login links if user is not logged in -->
                                <a class="btn btn-primary navlink" href="{{ route('register') }}">Sign Up</a>
                                <a class="btn btn-primary navlink" href="{{ route('login') }}">Login</a>
                            @endauth
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        
        

    </div>

    <!-- Masthead-->
    <header class="masthead" style="background-image: url('https://pbs.twimg.com/media/Ettl4LHXcAAHd4X.jpg'); height:140%">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="text-center text-white">
                        <!-- Page heading-->
                        <h1 class="mb-5">Welcome to the Visitor Management System!</h1>
                        <!-- Signup form-->
                        <form class="form-subscribe" id="contactForm" data-sb-form-api-token="API_TOKEN">
                            <!-- Email address input-->
                            <div class="row">
                                <div class="col">
                                    <input class="form-control form-control-lg" id="emailAddress" type="email"
                                        placeholder="Enter your email address" data-sb-validations="required,email" />
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:required">
                                        Email Address is required.</div>
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:email">Email
                                        Address Email is not valid.</div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary btn-lg disabled" id="submitButton"
                                        type="submit">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Icons Grid-->
    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="bi-window m-auto text-primary"></i></div>
                        <h3>Fully Responsive</h3>
                        <p class="lead mb-0">Our system is designed to work perfectly on any device, big or small.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="bi-layers m-auto text-primary"></i></div>
                        <h3>Bootstrap 5 Ready</h3>
                        <p class="lead mb-0">We utilize the latest Bootstrap 5 framework for modern web development.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="bi-terminal m-auto text-primary"></i></div>
                        <h3>Easy to Use</h3>
                        <p class="lead mb-0">Get started quickly and easily with our user-friendly interface.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials-->
    <section class="testimonials text-center bg-light">
        <div class="container">
            <h2 class="mb-5">What People Are Saying...</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="assets/img/testimonials-1.jpg" alt="..." />
                        <h5>Margaret E.</h5>
                        <p class="font-weight-light mb-0">"This system is fantastic! Thanks so much!"</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="assets/img/testimonials-2.jpg" alt="..." />
                        <h5>Fred S.</h5>
                        <p class="font-weight-light mb-0">"I love using this system to manage visitors."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="assets/img/testimonials-3.jpg" alt="..." />
                        <h5>Sarah W.</h5>
                        <p class="font-weight-light mb-0">"Thanks for providing this service for free!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action-->
    <section class="call-to-action text-white text-center" id="signup">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <h2 class="mb-4">Ready to Get Started? Sign Up Now!</h2>
                    <!-- Signup form-->
                    <form class="form-subscribe" id="contactFormFooter" data-sb-form-api-token="API_TOKEN">
                        <!-- Email address input-->
                        <div class="row">
                            <div class="col">
                                <input class="form-control form-control-lg" id="emailAddressBelow" type="email"
                                    placeholder="Enter your email address" data-sb-validations="required,email" />
                                <div class="invalid-feedback text-white" data-sb-feedback="emailAddressBelow:required">
                                    Email Address is required.</div>
                                <div class="invalid-feedback text-white" data-sb-feedback="emailAddressBelow:email">
                                    Email Address Email is not valid.</div>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-lg disabled" id="submitButton"
                                    type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item"><a href="#!">About</a></li>
                        <li class="list-inline-item">⋅</li>
                        <li class="list-inline-item"><a href="#!">Contact</a></li>
                        <li class="list-inline-item">⋅</li>
                        <li class="list-inline-item"><a href="#!">Terms of Use</a></li>
                        <li class="list-inline-item">⋅</li>
                        <li class="list-inline-item"><a href="#!">Privacy Policy</a></li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">&copy; Your Website 2023. All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item me-4">
                            <a href="#!"><i class="bi-facebook fs-3"></i></a>
                        </li>
                        <li class="list-inline-item me-4">
                            <a href="#!"><i class="bi-twitter fs-3"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!"><i class="bi-instagram fs-3"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="{{ url('DASHBOARD_ASSETS/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('DASHBOARD_ASSETS/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('DASHBOARD_ASSETS/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('DASHBOARD_ASSETS/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <script src="{{ url('DASHBOARD_ASSETS/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('vendor/js/dashboard-scripts') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ url('DASHBOARD_ASSETS/dist/js/pages/dashboard.js') }}"></script>
</body>

</html>
