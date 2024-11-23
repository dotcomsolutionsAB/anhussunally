<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <title>Contact Us</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/animate.min.css">
  <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
  <link rel="stylesheet" type="text/css" href="css/owl.transitions.css">
  <link rel="stylesheet" type="text/css" href="css/cubeportfolio.min.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css">
  <link rel="stylesheet" type="text/css" href="css/bootsnav.css">
  <link rel="stylesheet" type="text/css" href="css/settings.css">
  <link rel="stylesheet" type="text/css" href="css/loader.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <link rel="shortcut icon" href="images/favicon.png">


  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

  <!--Loader-->
  <!-- <div class="loader">
    <div class="spinner-load">
      <div class="dot1"></div>
      <div class="dot2"></div>
    </div>
  </div> -->


  <!--TOPBAR-->
  <!-- <div class="topbar">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <div class="header-top-entry">
            <div class="title">
              ENGLISH<i class="fa fa-angle-down"></i>
            </div>
            <div class="list">
              <a class="list-entry" href="#">English</a>
              <a class="list-entry" href="#">Spanish</a>
            </div>
          </div>
          <div class="header-top-entry">
            <div class="title">
              USD<i class="fa fa-angle-down"></i>
            </div>
            <div class="list">
              <a class="list-entry" href="#">$ CAD</a>
              <a class="list-entry" href="#">€ EUR</a>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <ul class="top_link">
            <li><a href="#" class="uppercase">My Account</a>
            </li>
            <li><a href="#" class="uppercase">wishlish</a>
            </li>
            <li><a href="#" class="uppercase">checkout</a>
            </li>
            <li><a href="#" class="uppercase">login</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div> -->

  <!--HEADER-->
  <?php include("inc_files/header.php");?>

  <!-- Breadcumb -->
  <?php include("inc_files/breadcumb.php"); ?>

  <!--Contact Us-->
  <section id="contact" class="padding_top">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h3 class="uppercase heading bottom30">Send us a message</h3>
          <form class="contact-form padding_bottom">
            <div class="row">
              <div class="col-md-6 form-group">
                <label for="exampleInputName2">Name</label>
                <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
              </div>
              <div class="col-md-6 form-group">
                <label for="exampleInputEmail2">Mail</label>
                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
              </div>
              <div class="col-md-12 form-group">
                <label for="message">Message</label>
                <textarea class="form-control" placeholder="Write your message here..."></textarea>
                <input type="submit" class="btn-form uppercase border-radius margintop40" value="send your message">
              </div>
            </div>
          </form>
        </div>

        <div class="col-md-4">
          <div class="contact_detail padding_bottom">
            <h3 class="uppercase heading bottom30">Get Office Info.</h3>
            <p class="bottom30">Pioneering the hydraulics market in Eastern India, the 100-year old A.N. Hussunally & Co. has today emerged as among the market leaders in providing customers with holistic hydraulic solutions.</p>
            <div class="address bottom30">
              <i class="fa fa-map-marker"></i>
              <h5 class="uppercase">Our Address</h5>
              <p>Hussunally Buildings<br>
                Post Box No. 68628,
                Strand Road, Kolkata
                West Bengal-700 001.</p>
            </div>
            <div class="address bottom30">
              <i class="fa  fa-phone"></i>
              <h5 class="uppercase">Phone Number</h5>
              <p>+91-33-2230 4140</p>
            </div>
            <div class="address">
              <i class="fa fa-envelope-o"></i>
              <h5 class="uppercase">Email Address</h5>
              <p>Email: <a href="mailto:hussunally@gmail.com.">hussunally@gmail.com</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="padding_bottom">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3684.0104580223724!2d88.34563767484305!3d22.57871217948732!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0277bb65e7eed7%3A0x98eee9c0ded7dfe2!2sA.N.Hussunally%20%26%20Co.!5e0!3m2!1sen!2sin!4v1731402795801!5m2!1sen!2sin" width="2000" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </section>

  <?php include("inc_files/wpp_sticky.php"); ?>
  <!--Footer-->
  <?php include("inc_files/footer.php");?>

  <script src="js/jquery-2.2.3.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOBKD6V47-g_3opmidcmFapb3kSNAR70U"></script>
  <script src="js/gmap3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootsnav.js"></script>
  <script src="js/jquery.parallax-1.1.3.js"></script>
  <script src="js/jquery.appear.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.cubeportfolio.min.js"></script>
  <script src="js/jquery.fancybox.js"></script>
  <script src="js/jquery.themepunch.tools.min.js"></script>
  <script src="js/jquery.themepunch.revolution.min.js"></script>
  <script src="js/revolution.extension.layeranimation.min.js"></script>
  <script src="js/revolution.extension.navigation.min.js"></script>
  <script src="js/revolution.extension.parallax.min.js"></script>
  <script src="js/revolution.extension.slideanims.min.js"></script>
  <script src="js/revolution.extension.video.min.js"></script>
  <script src="js/kinetic.js"></script>
  <script src="js/jquery.final-countdown.js"></script>
  <script src="js/functions.js"></script>

</body>

</html>