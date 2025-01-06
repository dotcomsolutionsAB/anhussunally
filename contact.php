<?php
    session_start(); // Start the session
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>AN Hussunally & Co - Contact Us</title>
    <meta name="description" content="AN Hussunally & Co">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/fontello.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/default-icons.css">
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/odometer.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/tg-cursor.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="shortcut icon" href="images/favicon.png">
</head>

<body>

    <!--Preloader-->
    <!-- <div id="preloader">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class="loader-icon"><img src="assets/img/logo/preloader.svg" alt="Preloader"></div>
            </div>
        </div>
    </div> -->
    <!--Preloader-end -->

    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="renova-up-arrow"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- header-area -->
        <?php include("inc_files/header.php"); ?>
    <!-- header-area-end -->



    <!-- main-area -->
    <main class="main-area fix">

        <!-- breadcrumb-area -->
        <?php include("inc_files/breadcrumb.php"); ?>
        <!-- breadcrumb-area-end -->

        <!-- contact-area -->
        <section class="contact__area section-py-120">
            <div class="container">
                <div class="row gutter-24">
                    <div class="col-lg-4">
                        <div class="contact__info-wrap">
                            <div class="contact__info-item">
                                <!-- <div class="contact__info-thumb">
                                    <img src="assets/img/images/contact_img01.jpg" alt="img">
                                </div> -->
                                <div class="contact__info-content">
                                    <div class="icon">
                                        <i class="renova-map"></i>
                                    </div>
                                    <div class="content">
                                        <span>Location</span>
                                        <h2 class="title">Hussunally Buildings
                                        Post Box No. 68628, Strand Road, Kolkata West Bengal-700 001</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="contact__info-item">
                                <!-- <div class="contact__info-thumb">
                                    <img src="assets/img/images/contact_img02.jpg" alt="img">
                                </div> -->
                                <div class="contact__info-content">
                                    <div class="icon">
                                        <i class="renova-envelope-open"></i>
                                    </div>
                                    <div class="content">
                                        <span>E-mail</span>
                                        <h2 class="title"><a href="mailto:info@renova.com">hussunally@gmail.com</a></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="contact__info-item">
                                <div class="contact__info-thumb">
                                    <!-- <img src="assets/img/images/contact_img03.jpg" alt="img"> -->
                                </div>
                                <div class="contact__info-content">
                                    <div class="icon">
                                        <i class="renova-headphone"></i>
                                    </div>
                                    <div class="content">
                                        <span>Call Us 24/7</span>
                                        <h2 class="title"><a href="tel:0123456789">+91-33-2230-4140</a></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <!-- contact-map -->
                        <div class="contact-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3684.010458022371!2d88.34563767535545!3d22.578712179487383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0277bb65e7eed7%3A0x98eee9c0ded7dfe2!2sA.N.Hussunally%20%26%20Co.!5e0!3m2!1sen!2sin!4v1733480034069!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <!-- contact-map-end -->
                        <div class="contact__form-wrap">
                            <div class="section__title section__title-three mb-40">
                                <span class="sub-title">Get In Touch</span>
                                <h2 class="title">Needs Help? Let’s Get in Touch</h2>
                            </div>
                            <form id="contact-form" method="post" action="mail.php" class="contact__form">
                                <div class="row gutter-20">
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <input type="text" name="name" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <input type="email" name="email" placeholder="Email Address">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-grp">
                                    <input type="text" name="subject" placeholder="Your Subject">
                                </div>
                                <div class="form-grp">
                                    <textarea name="message" placeholder="Type Your Message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-two">Send Message</button>
                                 <!-- Flash Message -->
                                <?php if (isset($_SESSION['message'])): ?>
                                    <div class="alert alert-<?php echo $_SESSION['message_type'] === 'success' ? 'success' : 'danger'; ?>" role="alert">
                                        <?php
                                        echo $_SESSION['message'];
                                        unset($_SESSION['message']); // Clear the message
                                        unset($_SESSION['message_type']); // Clear the message type
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact-area-end -->

    </main>
    <!-- main-area-end -->

    <!-- footer-area -->
    <?php include("inc_files/footer.php"); ?>
    <!-- footer-area-end -->

    <!-- JS here -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.odometer.min.js"></script>
    <script src="assets/js/jquery.appear.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/jquery.marquee.min.js"></script>
    <script src="assets/js/tg-cursor.min.js"></script>
    <script src="assets/js/ajax-form.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/svg-inject.min.js"></script>
    <script src="assets/js/tween-max.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        SVGInject(document.querySelectorAll("img.injectable"));
    </script>
</body>

</html>