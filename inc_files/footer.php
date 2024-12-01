<?php  ini_set('display_errors', 0); ?>    
    <footer class="bottom_half" style="padding-top:70px;">
      <a href="#." class="go-top text-center" style="display: none;">
        <i class="fa fa-angle-double-up">  </i>
      </a>
      <div class="container">
        <div class="row" style="gap: 5vw; display: flex;">

          <div class="col-md-4 col-sm-12">
            <div class="footer_panel content_space" style="display: flex; flex-direction: column; gap: 5vh;">
              <a class="navbar-brand" href="index.php">
                <img src="images/logo22.png" class="logo" alt="" id="navbar-logo">
              </a>
              <p style="color:#fff;">
                Pioneering the hydraulics market in Eastern India, the 100-year old A.N. Hussunally & Co. has today emerged as among the    market leaders in providing customers with holistic hydraulic solutions.
              </p>
            </div>
          </div>

          <div class="col-md-4 col-sm-12">
            <div class="footer_panel content_space">
              <h4 class="heading_border heading_space">Contact Us
              </h4>
              <ul class="about_foot">
                <li>
                  <i class="fa fa-home">
                  </i>Hussunally Buildings<br>
                      Post Box No. 68628,
                      Strand Road, Kolkata
                      West Bengal-700 001..
                </li>
                <li>
                  <i class="fa fa-phone">
                  </i>+91-33-2230 4140
                </li>
                <li style="">
                    <i class="fa fa-envelope">
                    </i>hussunally@gmail.com
                </li>
              </ul>
            </div>
          </div>

          <div class="col-md-4 col-sm-12">
            <div class="footer_panel content_space" >
              <h4 class="heading_border heading_space">Quick Links
              </h4>
              <ul class="account_foot">
                <li>
                  <a href="#.">Home
                  </a>
                </li>
                <li>
                  <a href="#.">About Us
                  </a>
                </li>
                <li>
                  <a href="#.">Contact Us
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <div class="copyright">
      <div style="text-align: center;" class="container" >
        <div class="row" style="display:flex; align-items: center; justify-content: center;">
          <div class="col-sm-4">
            <p style="color: #fff;">Copyright &copy; 2024 
              <a href="#.">A N Hussunally & Co
              </a>. All Rights Reserved.
            </p>
          </div>
          <!-- <div class="col-sm-8">
            <ul class="social">
              <li>
                <a href="#.">
                  <i class="fa fa-facebook">
                  </i>
                </a>
              </li>
              <li>
                <a href="#.">
                  <i class="fa fa-twitter">
                  </i>
                </a>
              </li>
              <li>
                <a href="#.">
                  <i class="fa fa-rss">
                  </i>
                </a>
              </li>
              <li>
                <a href="#.">
                  <i class="fa fa-google-plus">
                  </i>
                </a>
              </li>
              <li>
                <a href="#.">
                  <i class="fa fa-linkedin">
                  </i>
                </a>
              </li>
            </ul>
          </div> -->
        </div>
      </div>
    </div>

 <!-- Add Font Awesome for WhatsApp Icon -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    /* Sticky Buttons */
    .sticky-buttons {
        position: fixed; /* Keeps the button fixed to the viewport */
        bottom: 20px; /* Distance from the top of the viewport */
        left: 20px; /* Distance from the left of the viewport */
        z-index: 10000; /* Ensures it stays above all other elements */
        pointer-events: auto; /* Ensures the button is clickable */
    }
    .sticky-buttons a:hover {
        color: #f5f5f5;
        text-decoration: none;
    }
    .whatsapp-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #25D366; /* WhatsApp green color */
        color: white;
        border-radius: 50%;
        width: 60px; /* Size of the button */
        height: 60px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        text-align: center;
    }

    .whatsapp-btn i {
        font-size: 30px; /* Size of the icon */
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .whatsapp-btn {
            width: 50px; /* Smaller size for mobile */
            height: 50px;
        }

        .whatsapp-btn i {
            font-size: 24px;
        }

        .sticky-buttons {
            left: 10px; /* Adjust for smaller screens */
        }
    }
    @media (max-width: 768px) {
        .whatsapp-btn {
            width: 50px; /* Smaller size for mobile */
            height: 50px;
        }

        .whatsapp-btn i {
            font-size: 24px;
        }

        .sticky-buttons {
            left: 50%; /* Adjust for smaller screens */
        }
    }
</style>
<?php
  // footer.php
  // include(__DIR__ . './404.php');
?>
<!-- Sticky Buttons -->
<div class="sticky-buttons">
    <a href="https://wa.me/+1234567890" target="_blank" class="whatsapp-btn" title="WhatsApp">
        <i class="fab fa-whatsapp"></i> <!-- WhatsApp Icon -->
    </a>
</div>

<style>
  @media (max-width: 480px) {
    .row {
      gap: 5vw;
      display: flex;
      flex-direction: column;
      justify-content: center;
      /* align-items: center; */
      text-align: justify;
    }
    .footer_panel{
      margin-left: 0px;
    }
    .content_space {
      margin-bottom: 0px;
    }
    .padding_top {
      padding-top: 90px;
    } 

    .bottom_half {
      margin-top: 20px;
      padding-bottom: 45px;
    }
    .copyright p {
    /* font-size: 14px; */
      margin: 0px;
    }
    footer .bottom_half{
      padding-top:20px !important;
    }
  }
</style>


