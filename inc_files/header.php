<?php include("api/db_connection.php"); ?>

<?php
// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all brands from the brand table
$brandQuery = "SELECT id, name FROM brand";
$brandResult = $conn->query($brandQuery);
?>
  <style>
    li.dropdown a {
        position: relative;
        display: inline-block;
        color: #000; /* Adjust color as needed */
        text-decoration: none;
        font-weight: bold;
    }

    li.dropdown a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px; /* Adjust thickness of underline */
        background-color: #000; /* Adjust underline color */
        transition: width 0.3s ease-in-out;
    }

    li.dropdown a:hover::after {
        width: 100%; /* Expands the underline to full width on hover */
    }
    /* Underline effect when navbar is scrolled */
    .navbar-default.scrolled li.dropdown a::after {
        background-color: #fff; /* Change underline to white when scrolled */
    }
    .navbar-default.scrolled ul .dropdown-menu{
      background:#fff;
    }
    .navbar-default {
          background-color: transparent; /* Initial transparent background */
          transition: background-color 0.3s ease, color 0.3s ease;
      }

      .navbar-default.scrolled {
          background-color: #fff !important; /* Background after scrolling */
          color: white; /* Font color after scrolling */
          box-shadow: 0px 0px 60px 0px rgba(0, 0, 0, 0.1);
          
      }

      .navbar-default.scrolled .navbar-nav > li > a {
          color: #000 !important; /* Change nav link colors */
          font-weight: bold;
      }

      .navbar-default.scrolled .navbar-brand {
          color: white !important; /* Change brand color */
      }
      li.dropdown a::after {
        bottom: 20px !important;
      }
      .wrap-sticky{
        height: 76px;
      }
      

  </style>
    <header>
      <nav class="navbar navbar-default navbar-sticky bootsnav">
        <div class="container">
          <!-- Start Header Navigation -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
              <i class="fa fa-bars">
              </i>
            </button>
            <a class="navbar-brand" href="index.php">
              <img src="images/logo.png" class="logo" alt="" id="navbar-logo">
            </a>
          </div>
          <!-- End Header Navigation -->
          <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav navbar-right" data-in="fadeIn" data-out="fadeOut">
              <li class="dropdown active">
                <a href="https://anh.ongoingwp.xyz/index.php" class="index.php" data-toggle="#home" style="font-weight: bolder;">Home
                </a>
              </li>
              <!-- <li class="dropdown">
                <a href="products.php" class="dropdown-toggle" data-toggle="dropdown">Products
                </a> -->
               <!-- 
                    <ul class="dropdown-menu">
                      <li>
                        <a href="grid.php">Grid Default
                        </a>
                      </li>
                      <li>
                        <a href="grid_list.php">Grid Lists
                        </a>
                      </li>
                      <li>
                        <a href="grid_sidebar.php">Grid Sidebar
                        </a>
                      </li>
                      <li>
                        <a href="list_sidebar.php">Lists Sidebar
                        </a>
                      </li>
                    </ul> 
                    -->
              </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-weight: bolder;">Brands</a>
                    <ul class="dropdown-menu" style="margin-top: 2vh; ">
                        <?php if ($brandResult && $brandResult->num_rows > 0): ?>
                            <?php while ($brand = $brandResult->fetch_assoc()): ?>
                                <li>
                                    <a href="brands.php?id=<?php echo htmlspecialchars($brand['id']); ?>" style="padding: 0px 10px; font-size: 15px;">
                                        <?php echo htmlspecialchars($brand['name']); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li><a href="#">No Brands Available</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

              <!-- <li>
                <a href="#.">collection
                </a>
              </li> -->
              <!-- <li class="dropdown megamenu-fw">
                <a href="#." class="dropdown-toggle" data-toggle="dropdown">pages
                </a>
                <ul class="dropdown-menu megamenu-content" role="menu">
                  <li>
                    <div class="row">
                      <div class="col-menu col-md-3">
                        <h5 class="title heading_border">Blog
                        </h5>
                        <div class="content">
                          <ul class="menu-col">
                            <li>
                              <a href="blog1.php">Blog Two Cols
                              </a>
                            </li>
                            <li>
                              <a href="blog2.php">Blog Three Cols
                              </a>
                            </li>
                            <li>
                              <a href="blog_post.php">Blog Posts
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-menu col-md-3">
                        <h5 class="title heading_border">Products Elements
                        </h5>
                        <div class="content">
                          <ul class="menu-col">
                            <li>
                              <a href="checkout.php">Product Chekouts
                              </a>
                            </li>
                            <li>
                              <a href="product_detail.php">Products Details
                              </a>
                            </li>
                            <li>
                              <a href="cart.php">Shopping Cart
                              </a>
                            </li> 
                          </ul>
                        </div>
                      </div>
                      <div class="col-menu col-md-3">
                        <h5 class="title heading_border">Theme Elements
                        </h5>
                        <div class="content">
                          <ul class="menu-col">
                            <li>
                              <a href="#.">Skills
                              </a>
                            </li>
                            <li>
                              <a href="#.">Team & Testimonials
                              </a>
                            </li>
                            <li>
                              <a href="404.php">Errors
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>    
                      <div class="col-menu col-md-3">
                        <div class="content">
                          <img src="images/mega-menu.png"  alt="menu" class="img-responsive">
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </li> -->
              <li class="dropdown" >
                <a href="about_us.php" style="font-weight: bolder;">About Us
                </a>
              </li>
              <li class="dropdown">
                <a href="contact_us.php" style="font-weight: bolder;">Contact us
                </a>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
          <div class=" search-toggle">
            <div class="top-search">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon">
                  <i class="fa fa-search">
                  </i>
                </span>
              </div>
            </div>
          </div>
        </div>   
      </nav>
    </header>

    <script>
      document.addEventListener('scroll', function() {
          //console.log('Scroll position:', window.scrollY);
          const navbar = document.querySelector('.navbar-default');
          const logo = document.querySelector('#navbar-logo');
          if (window.scrollY > 50) {
              //console.log('Scrolled: Changing to logo22.png');
              navbar.classList.add('scrolled');
              logo.src = 'images/logo.png';
          } else {
            // console.log('Not Scrolled: Reverting to logo.png');
              navbar.classList.remove('scrolled');
              logo.src = 'images/logo.png';
          }
      });
    </script>