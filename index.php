<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Perfect Gym Club</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/animated-headline.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .feedback-form {
            margin: 0 auto;
            max-width: 600px;
        }

        .footer-area.black-bg .container {
            display: flex;
            justify-content: center;
        }

        .footer-top {
            max-width: 1200px;
        }

/* Make images responsive */
.topic-img img {
    width: 100%;
    height: auto;
}

/* Set all text color to white */
.topic-content, .topic-content h3, .topic-content p {
    color: white;
}

/* Ensure the content box adapts to different screen sizes */
.topic-content-box {
    padding: 20px;
}


    </style>
</head>

<body class="black-bg">
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader End -->

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gymnsb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $feedback = $_POST["feedback"];

        $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $feedback);

        if ($stmt->execute()) {
            echo "<script>alert('Feedback submitted successfully');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <!-- Header Start -->
    <header>
        <div class="header-area header-transparent">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="menu-wrapper d-flex align-items-center justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="assets/img/logo.png" alt=""></a>
                        </div>
                        <div class="main-menu f-right d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="courses.html">Courses</a></li>
                                    <li><a href="gallery.html">Gallery</a></li>
                                    <li><a href="Gym-System/logins.php" class="btn">Login</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <main>
        <!-- Slider Area Start -->
        <div class="slider-area position-relative">
            <div class="slider-active">
                <!-- Single Slider -->
                <div class="single-slider slider-height d-flex align-items-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-9 col-lg-9 col-md-10">
                                <div class="hero__caption">
                                    <span data-animation="fadeInLeft" data-delay="0.1s">This is Perfect GYM Club</span>
                                    <h1 data-animation="fadeInLeft" data-delay="0.4s">Gym System</h1>
                                    <a href="courses.html" class="border-btn hero-btn" data-animation="fadeInLeft" data-delay="0.8s">Gym Courses</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider Area End -->

<!-- Training categories Start -->
<section class="training-categories black-bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="single-topic text-center mb-30">
                    <div class="topic-img">
                        <img src="assets/img/gallery/cat1.png" alt="" class="img-fluid">
                        <div class="topic-content-box">
                            <div class="topic-content">
                                <h3>Personal Training</h3>
                                <p>A certified personal trainer is someone who is trained in creating and implementing safe and effective exercise programs for their clients. Fitness Trainers who work one-on-one with clients in a gym, exercise facility, or in the client's home are known as Personal Trainers. They draw up a plan for each client and help them determine goals that relate to strength, endurance, and weight.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="single-topic text-center mb-30">
                    <div class="topic-img">
                        <img src="assets/img/gallery/cat2.png" alt="" class="img-fluid">
                        <div class="topic-content-box">
                            <div class="topic-content">
                                <h3>Group Training</h3>
                                <p>The term group fitness encompasses any and all form of fitness that's done in a group setting, lead by a personal trainer or group instructor. With this form of exercise growing in popularity, you can now find group fitness classes of nearly any kind, both aerobic- and strength-based.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Training categories End -->


        <!-- Team -->
        <section class="team-area fix">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section-tittle text-center mb-55 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                            <h2>Services</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-cat text-center mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                            <div class="cat-icon">
                                <img src="assets/img/gallery/fit.jpg" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="courses.html">Fitness Gym</a></h5>
                                <p>A health club (also known as a fitness club, fitness center, health spa, and commonly referred to as a gym) is a place that houses exercise equipment for the purpose of physical exercise.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-cat text-center mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                            <div class="cat-icon">
                                <img src="assets/img/gallery/tread2.jpg" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="courses.html">Cardio Gym</a></h5>
                                <p>People often think that cardio is the best exercise for weight loss, but both cardio and strength training are important. It is well known that cardio is a good way to burn calories. Cardio will burn more calories than lifting weights for 30 minutes or doing any other cardio activity for the same amount of time.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-cat text-center mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                            <div class="cat-icon">
                                <img src="assets/img/gallery/stre.jpg" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="courses.html">Strength Training</a></h5>
                                <p>Strength training is a type of physical exercise specializing in the use of resistance to induce muscular contraction, which builds the strength, anaerobic endurance, and size of skeletal muscles. When properly performed, strength training can provide significant functional benefits and improvement in overall health and well-being.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Team End -->

        <!-- Feedback Form Start -->
        <section class="feedback-form-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section-tittle text-center mb-55 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                            <h2>Feedback Form</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="feedback-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="feedback" rows="4" placeholder="Your Feedback" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Feedback Form End -->
    </main>

    <!-- Footer Start -->
    <footer>
        <div class="footer-area black-bg">
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="single-footer-caption mb-50 text-center">
                                <div class="footer-logo">
                                    <a href="index.html"><img src="assets/img/logo.png" alt=""></a>
                                </div>
                                <div class="footer-menu">
                                    <nav>
                                        <ul>
                                            <li><a href="index.php">Home</a></li>
                                            <li><a href="about.html">About</a></li>
                                            <li><a href="courses.html">Courses</a></li>
                                            <li><a href="contact.html">Contact</a></li>
                                            <li><a href="Gym-System/logins.php">Login</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="footer-social">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- JS here -->
    <script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/animated.headline.js"></script>
    <script src="assets/js/jquery.magnific-popup.js"></script>
    <script src="assets/js/gijgo.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/jquery.sticky.js"></script>
    <script src="assets/js/jquery.barfiller.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.countdown.min.js"></script>
    <script src="assets/js/hover-direction-snake.min.js"></script>
    <script src="assets/js/contact.js"></script>
    <script src="assets/js/jquery.form.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/mail-script.js"></script>
    <script src="assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
