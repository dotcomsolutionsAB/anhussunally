<?php 
  // Include the configuration file
  include(__DIR__ . '/inc_files/config.php');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <title>AN Hussunally & Co
  </title>
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
  <!-- <?php include("inc_files/loader.php"); ?> -->
  <!--TOPBAR-->
  <!-- <div class="topbar">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <div class="header-top-entry">
              <div class="title">
                ENGLISH
                <i class="fa fa-angle-down">
                </i>
              </div>
              <div class="list">
                <a class="list-entry" href="#.">English
                </a>
                <a class="list-entry" href="#.">Spanish
                </a>
              </div>
            </div>
            <div class="header-top-entry">
              <div class="title">
                USD
                <i class="fa fa-angle-down">
                </i>
              </div>
              <div class="list">
                <a class="list-entry" href="#.">$ CAD
                </a>
                <a class="list-entry" href="#.">€ EUR
                </a>
              </div>
            </div>
          </div>
          <div class="col-sm-8">
            <ul class="top_link">
              <li>
                <a href="#." class="uppercase">My Account
                </a>
              </li>
              <li>
                <a href="#." class="uppercase">wishlish
                </a>
              </li>
              <li>
                <a href="#." class="uppercase">checkout
                </a>
              </li>
              <li>
                <a href="#." class="uppercase">login
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div> -->
  <!--HEADER-->
  <?php include("inc_files/header.php"); ?>
  <style>
    /* Full Page Section */
    .flex {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        background-image: url("images/About_Us.png");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: white;
        height: 100vh; /* Full-screen height */
    }

    .flex::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Black overlay */
        z-index: 1; /* Ensure overlay is behind content */
    }

    .flex > * {
        position: relative;
        z-index: 2; /* Bring content above the overlay */
    }

    /* Grid Layout */
    .brand-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Responsive grid */
        gap: 20px; /* Space between cards */
        max-width: 1200px;
        padding: 40px;
        width: 100%;
    }

    /* Brand Card */
    .brand-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 140px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        overflow: hidden;
        position: relative;
    }

    .brand-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Brand Logo */
    .brand-logo {
        max-width: 80%;
        max-height: 70%;
        transition: transform 0.3s ease;
    }

    .brand-card:hover .brand-logo {
        transform: scale(1.1);
    }

    /* Responsive Text */
    .flex h1 {
        font-size: 36px;
        text-align: center;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .flex h1 {
        font-size: 28px;
        }

        .brand-card {
        height: 120px;
        }
    }
    @media (max-width: 480px) {
      .brand-card {
          height: 70px;
          width: 100px;
      }

      .brand-logo {
          max-width: 100%;
      }
      .brand-grid {
          grid-template-columns: 1fr 1fr 1fr;
          gap: 10px;
          padding: 10px;
      }
    }
  </style>

<div class="flex">
    <div class="brand-grid">
      <div class="brand-card"><img src="images/ALFOMEGA.png" alt="Brand 1" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Atos.png" alt="Brand 2" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Bearing-Pullers.png" alt="Brand 3" class="brand-logo"></div>
      <div class="brand-card"><img src="images/HYDROLINE.png" alt="Brand 4" class="brand-logo"></div>
      <div class="brand-card"><img src="images/DOWTY.png" alt="Brand 5" class="brand-logo"></div>
      <div class="brand-card"><img src="images/DEMCON.png" alt="Brand 6" class="brand-logo"></div>
      <div class="brand-card"><img src="images/DOWTY.png" alt="Brand 7" class="brand-logo"></div>
      <div class="brand-card"><img src="images/EPE.jpg" alt="Brand 8" class="brand-logo"></div>
      <div class="brand-card"><img src="images/GEMELS1.png" alt="Brand 9" class="brand-logo"></div>
      <div class="brand-card"><img src="images/HAWE.png" alt="Brand 10" class="brand-logo"></div>
      <div class="brand-card"><img src="images/HYLOC.png" alt="Brand 11" class="brand-logo"></div>
      <div class="brand-card"><img src="images/POLYHYDR0N.png" alt="Brand 12" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Positron-1.png" alt="Brand 13" class="brand-logo"></div>
      <div class="brand-card"><img src="images/REXROTH.png" alt="Brand 14" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Spica.jpg" alt="Brand 15" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Minitest.png" alt="Brand 16" class="brand-logo"></div>
      <div class="brand-card"><img src="images/VELJAN.png" alt="Brand 17" class="brand-logo"></div>
      <div class="brand-card"><img src="images/WIKAI.png" alt="Brand 18" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Water-Test-Pump.png" alt="Brand 19" class="brand-logo"></div>
      <div class="brand-card"><img src="images/YUKEN.png" alt="Brand 20" class="brand-logo"></div>
      <div class="brand-card"><img src="images/VIP.png" alt="Brand 21" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Hose-Crimping-Machine.png" alt="Brand 22" class="brand-logo"></div>
      <div class="brand-card"><img src="images/STAUFF.png" alt="Brand 23" class="brand-logo"></div>
      <div class="brand-card"><img src="images/WALVOIL.png" alt="Brand 24" class="brand-logo"></div>
    </div>
</div>

  <?php include("inc_files/home_about.php"); ?>
  <?php include("inc_files/counts.php"); ?>
  <?php include("inc_files/new_arrival.php"); ?>
    <div id="rev_slider" class="rev_slider" data-version="5.0">
      <ul> -->
        <!-- SLIDE  -->
        <!-- <li data-transition="fade"> -->
          <!-- MAIN IMAGE -->
          <!-- <img src="images/home2-banner1.jpg" alt="" data-bgposition="center center" data-bgfit="cover">
          <div class="tp-caption tp-resizeme"
            data-x="right" data-hoffset=""
            data-y="0" data-voffset="10"
            data-width="['auto','auto','auto','auto']"
            data-height="['auto','auto','auto','auto']"
            data-transform_idle="o:1;"
            data-transform_in="x:right;s:2000;e:Power4.easeInOut;"
            data-transform_out="s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
            data-start="3000"
            data-splitin="none"
            data-splitout="none"
            data-responsive_offset="on"
            style="z-index: 7; white-space: nowrap;">
            <img src="#" alt="">
          </div> -->
          <!-- LAYER NR. 1 -->
          <!-- <h3 class="tp-caption tp-resizeme uppercase" 							
                data-x="left"
                data-y="185"							
                data-width="full"
                data-transform_idle="o:1;"
                data-transform_in="y:-50px;opacity:0;s:1500;e:Power3.easeOut;" 
                data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 							 
                data-start="800">new arrivals
            </h3> -->
          <!-- <h1 class="tp-caption tp-resizeme uppercase" 							
                data-x="left"
                data-y="228"							
                data-width="full"
                data-transform_idle="o:1;"
                data-transform_in="y:-50px;opacity:0;s:1500;e:Power3.easeOut;" 
                data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"  							 
                data-start="1000">
              <strong>new style
              </strong> for lamp
            </h1> -->
          <!-- <div class="tp-caption tp-resizeme" 							
                 data-x="left"
                 data-y="415"							
                 data-width="full"
                 data-transform_idle="o:1;"
                 data-transform_in="y:-50px;opacity:0;s:1500;e:Power3.easeOut;" 
                 data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"  							 
                 data-start="1300">
              <p>Claritas est etiam processus dynamicus, qui sequitur mutationem
                <br>consuetudium lectorum.
              </p>
            </div> -->
          <!-- <div class="tp-caption tp-resizeme" 							
                 data-x="left"
                 data-y="510"							
                 data-width="full"
                 data-transform_idle="o:1;"
                 data-transform_in="y:-50px;opacity:0;s:1500;e:Power3.easeOut;" 
                 data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 							 
                 data-start="1600">
              <a href="#." class="btn-common">Shop Now
              </a>
            </div> -->
          <!-- </li>
          <li data-transition="fade">
            <img src="images/banner2.jpg"  alt="" data-bgposition="center center" data-bgfit="cover">	
            <div class="tp-caption tp-resizeme"
                 data-x="500" data-hoffset="" 
                 data-y="0" data-voffset="10" 
                 data-width="['auto','auto','auto','auto']"
                 data-height="['auto','auto','auto','auto']"
                 data-transform_idle="o:1;"
                 data-transform_in="x:right;s:2000;e:Power4.easeInOut;" 
                 data-transform_out="s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" 
                 data-start="3000" 
                 data-splitin="none" 
                 data-splitout="none" 
                 data-responsive_offset="on" 
                 style="z-index: 7; white-space: nowrap;">
              <img src="images/baner1-layer.png" alt="" >
            </div>						
            <h3 class="tp-caption tp-resizeme uppercase" 							
                data-x="left"
                data-y="185"							
                data-width="full"
                data-transform_idle="o:1;"
                data-transform_in="y:-50px;opacity:0;s:1500;e:Power3.easeOut;" 
                data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"  							 
                data-start="800">new arrivals
            </h3>
            <h1 class="tp-caption  tp-resizeme uppercase" 							
                data-x="left"
                data-y="228"							
                data-width="full" data-transform_idle="o:1;"
                data-transform_in="y:-50px;opacity:0;s:1500;e:Power3.easeOut;" 
                data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"  							 
                data-start="1100">
              <strong>new style
              </strong> for lamp
            </h1>
            <div class="tp-caption  tp-resizeme" 							
                 data-x="left"
                 data-y="415"							
                 data-width="full"
                 data-transform_idle="o:1;"
                 data-transform_in="y:-50px;opacity:0;s:1500;e:Power3.easeOut;" 
                 data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 							 
                 data-start="1400">
              <p>Claritas est etiam processus dynamicus, qui sequitur mutationem
                <br>consuetudium lectorum.
              </p>
            </div>
            <div class="tp-caption  tp-resizeme" 							
                 data-x="left"
                 data-y="510"							
                 data-width="full"
                 data-transform_idle="o:1;"
                 data-transform_in="y:-50px;opacity:0;s:1500;e:Power3.easeOut;" 
                 data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 							 
                 data-start="1700">
              <a href="#." class="btn-common">Shop Now
              </a>
            </div>
          </li>
        </ul>				
      </div> -->
          <!-- END REVOLUTION SLIDER -->

   
    <!--About-->
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .body5 {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .container5 {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .section5 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .section:hover {
            transform: translateY(-5px);
        }

        .text5 {
            flex: 1;
        }

        .text h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .text p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .image5 {
            flex: 1;
            text-align: center;
        }

        .image img {
            max-width: 100%;
            border-radius: 12px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .text h2 {
                font-size: 1.5rem;
            }

            .text p {
                font-size: 0.9rem;
            }

            .image {
                margin-top: 20px;
            }
        }
    </style>
      <div class="container">
        <div class="row">
          <div class="design clearfix">
            <div class="col-md-5 col-md-offset-1">
              <div class="design_img">
                <div class="tag">
                  <div class="tag-btn">
                    <span class="uppercase text-center">New
                    </span>
                  </div>
                </div>
                <img src="images/design-prouct.jpg" alt="desing Product">
              </div>
            </div>
            <div class="col-md-5 col-md-offset-1">
              <div class="descrp">
                <h3 class="uppercase heading_space">
                  <a href="product_detail.php">Sacrificial Chair Design
                  </a>
                </h3>
                <ul class="review">
                  <li>
                    <img src="images/star.png" alt="rating">
                  </li>
                  <li>
                    <a href="#.">10 review(s)
                    </a>
                  </li>
                  <li>
                    <a href="#.">Add your review
                    </a>
                  </li>
                </ul>
                <h3 class="price marginbottom15">
                  <i class="fa fa-gbp" aria-hidden="true">
                  </i>170.00 &nbsp; 
                  <span>
                    <i class="fa fa-gbp" aria-hidden="true">
                    </i>69.00
                  </span> 
                </h3>
                <p class="marginbottom15 detail">Size: 
                  <span>Large
                  </span>
                </p>
                <p class="marginbottom15 detail">Color:
                  <span>Grey white & Brown
                  </span>
                </p>
                <p class="detail">Dimensions: 
                  <span>Height: 13cm x Length: 15cm
                  </span>
                </p>
                <div class="countdown countdown-container margintop15"
                     data-start="1362139200"
                     data-end="1388461320"
                     data-now="1387461319"
                     data-border-color="#79b6c8">
                  <div class="clock row">
                    <div class="clock-item clock-days countdown-time-value col-xs-6 col-sm-3">
                      <div class="wrap">
                        <div class="inner">
                          <div id="canvas-days" class="clock-canvas">
                          </div>
                          <div class="text">
                            <p class="val">0
                            </p>
                          </div>
                          <p class="type-days type-time">DAYS
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="clock-item clock-hours countdown-time-value col-xs-6 col-sm-3">
                      <div class="wrap">
                        <div class="inner">
                          <div id="canvas-hours" class="clock-canvas">
                          </div>
                          <div class="text">
                            <p class="val">0
                            </p>
                          </div>
                          <p class="type-hours type-time">HOURS
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="clock-item clock-minutes countdown-time-value col-xs-6 col-sm-3">
                      <div class="wrap">
                        <div class="inner">
                          <div id="canvas-minutes" class="clock-canvas">
                          </div>
                          <div class="text">
                            <p class="val">0
                            </p>
                          </div>
                          <p class="type-minutes type-time">MINUTES
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="clock-item clock-seconds countdown-time-value col-xs-6 col-sm-3">
                      <div class="wrap">
                        <div class="inner">
                          <div id="canvas-seconds" class="clock-canvas">
                          </div>
                          <div class="text">
                            <p class="val">0
                            </p>
                          </div>
                          <p class="type-seconds type-time">SECONDS
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="heading_space uppercase">from our blog
            </h2>
            <p class="bottom_half">Claritas est etiam processus dynamicus, qui sequitur
            </p>
          </div>
          <div class="col-md-6">
            <div class="media blog_box">
              <div class="media-left">
                <a href="blog_post.php">
                  <img class="media-object" src="images/blog1.jpg" alt="...">
                </a>
              </div>
              <div class="media-body">
                <h2 class="media-heading uppercase bottom30">27
                  <sub>/ april
                  </sub>
                </h2>
                <h5 class="uppercase bottom30">
                  <a href="blog_post.php">Claritas est etiam processus 
                    <br>dynamicus.
                  </a>
                </h5>
                <p class="bottom30">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum...
                </p>
                <a href="blog_post.php" class="readmor uppercase">read more 
                  <i class="fa fa-angle-double-right">
                  </i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="media blog_box">
              <div class="media-left">
                <a href="blog_post.php">
                  <img class="media-object" src="images/blog2.jpg" alt="...">
                </a>
              </div>
              <div class="media-body">
                <h2 class="media-heading uppercase bottom30">27
                  <sub>/ april
                  </sub>
                </h2>
                <h5 class="uppercase bottom30">
                  <a href="blog_post.php">Claritas est etiam processus 
                    <br>dynamicus.
                  </a>
                </h5>
                <p class="bottom30">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum...
                </p>
                <a href="blog_post.php" class="readmor uppercase">read more 
                  <i class="fa fa-angle-double-right">
                  </i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
  <!--Testinomial-->
  <!-- <section id="testinomial" class="padding">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">
            <div id="tstinomial-slider" class="owl-carousel">
              <div class="item text-center">
                <div class="testinomial_pic heading_space">
                  <img src="images/testinomial1.png" alt="testinomial">
                  <h6 class="uppercase">michel smith
                  </h6>
                  <span class="uppercase">Developer
                  </span>
                </div>
                <p>Typi non habent claritatem insitam, est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem 
                  consuetudium lectorum. Mirum est notare quam littera gothica.
                </p>
              </div>
              <div class="item text-center">
                <div class="testinomial_pic heading_space">
                  <img src="images/testinomial1.png" alt="testinomial">
                  <h6 class="uppercase">michel Deneal
                  </h6>
                  <span class="uppercase">Developer
                  </span>
                </div>
                <p>Typi non habent claritatem insitam, est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem 
                  consuetudium lectorum. Mirum est notare quam littera gothica.
                </p>
              </div>
              <div class="item text-center">
                <div class="testinomial_pic heading_space">
                  <img src="images/testinomial1.png" alt="testinomial">
                  <h6 class="uppercase">michel smith
                  </h6>
                  <span class="uppercase">Designer
                  </span>
                </div>
                <p>Typi non habent claritatem insitam, est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem 
                  consuetudium lectorum. Mirum est notare quam littera gothica.
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-1">
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="availability text-center margin_top">
              <i class="fa fa-headphones">
              </i>
              <h5 class="uppercase">free shipping worldwide
              </h5>
              <span>Free shipping worldwide
              </span>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="availability text-center margin_top">
              <i class="fa fa-headphones">
              </i>
              <h5 class="uppercase">24/7 CUSTOMER SERVICE
              </h5>
              <span>Free shipping worldwide
              </span>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="availability text-center margin_top">
              <i class="fa fa-headphones">
              </i>
              <h5 class="uppercase">MONEY BACK GUARANTEE!
              </h5>
              <span>Free shipping worldwide
              </span>
            </div>
          </div>
        </div>
      </div>
    </section> -->
  <!--Footer-->

  <?php include("inc_files/footer.php"); ?>
  <script src="js/jquery-2.2.3.js">
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOBKD6V47-g_3opmidcmFapb3kSNAR70U">
  </script>
  <script src="js/gmap3.min.js">
  </script>
  <script src="js/bootstrap.min.js">
  </script>
  <script src="js/bootsnav.js">
  </script>
  <script src="js/jquery.parallax-1.1.3.js">
  </script>
  <script src="js/jquery.appear.js">
  </script>
  <script src="js/owl.carousel.min.js">
  </script>
  <script src="js/jquery.cubeportfolio.min.js">
  </script>
  <script src="js/jquery.fancybox.js">
  </script>
  <script src="js/jquery.themepunch.tools.min.js">
  </script>
  <script src="js/jquery.themepunch.revolution.min.js">
  </script>
  <script src="js/revolution.extension.layeranimation.min.js">
  </script>
  <script src="js/revolution.extension.navigation.min.js">
  </script>
  <script src="js/revolution.extension.parallax.min.js">
  </script>
  <script src="js/revolution.extension.slideanims.min.js">
  </script>
  <script src="js/revolution.extension.video.min.js">
  </script>
  <script src="js/kinetic.js">
  </script>
  <script src="js/jquery.final-countdown.js">
  </script>
  <script src="js/functions.js">
  </script>
</body>

</html>