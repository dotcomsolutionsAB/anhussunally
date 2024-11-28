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

<style>
      /* Container for the input box */
      .search-input-box {
          position: relative;
          display: flex;
          align-items: center;
          /* background-color: #ffeb3b; Yellow background */
          padding: 5px;
          border-radius: 25px; /* Rounded corners */
          width: 300px; /* Adjust the width */
          transition: width 0.3s ease;
      }

      /* Input field styling */
      .search-input-box input {
          width: 100%;
          padding: 8px 35px 8px 12px; /* Added extra padding to the right to accommodate the clear icon */
          font-size: 14px;
          border: 1px solid #d1d1d1;
          border-radius: 25px;
          outline: none;
          background-color: transparent;
          color: #333;
      }

      /* Search Icon */
      .search-input-box svg {
          position: absolute;
          right: 30px; /* Position the search icon slightly to the left */
          fill: #b5b5bf;
          cursor: pointer;
          transition: fill 0.3s ease;
          pointer-events: none; /* Prevent icon from blocking input click */
      }

      /* Cross (clear) Icon */
      .search-input-box .clear-icon {
          position: absolute;
          right: 10px; /* Place the cross button 10px from the right edge */
          fill: #b5b5bf;
          cursor: pointer;
          visibility: hidden; /* Hidden by default */
      }

      /* Show cross icon when there's text in the input */
      .search-input-box input:not(:placeholder-shown) ~ .clear-icon {
          visibility: visible;
      }

      /* Hover effect for the icons */
      .search-input-box svg:hover,
      .search-input-box .clear-icon:hover {
          fill: #ff9800; /* Change color on hover */
      }

      /* Input focus state */
      .search-input-box input:focus {
          border-color: #021e40;
      }

      /* Focus effect for search icon */
      .search-input-box svg:hover {
          fill: #ff9800;
      }           
      #search-results {
            margin-top: 10px;
            max-height: 215px;
            /* overflow-y: auto; */
            width: 295px;  /* Set the width to 30% of the viewport width */
        }

        .search-result-item {
            /* border-bottom: 1px solid #ddd; */
            padding: 10px;
            display: flex;
            align-items: center;
            cursor: pointer;  /* Show pointer cursor on hover */
        }

        .search-result-item img {
            margin-right: 10px;
        }

        .search-result-item p {
            margin: 0;
            padding: 0;
        }

        .search-result-item strong {
            font-size: 14px;
        }

        #search-results p {
            color: #888;
        }

</style>

    <header>
      <nav class="navbar navbar-default navbar-sticky bootsnav">
        <div class="container" style="display:flex; justify-content:space-around; align-items:center;">
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

          <!-- Search bar -->
          <div class="navbar-header">
            <div class="search-input-box">
              <input type="text" class="border border-soft-light form-control fs-14 hov-animate-outline" id="search" name="keyword" placeholder="Search Product name or SKU" autocomplete="off">
              <svg id="Group_723" data-name="Group 723" xmlns="http://www.w3.org/2000/svg" width="20.001" height="20" viewBox="0 0 20.001 20">
                  <path id="Path_3090" data-name="Path 3090" d="M9.847,17.839a7.993,7.993,0,1,1,7.993-7.993A8,8,0,0,1,9.847,17.839Zm0-14.387a6.394,6.394,0,1,0,6.394,6.394A6.4,6.4,0,0,0,9.847,3.453Z" transform="translate(-1.854 -1.854)" fill="#b5b5bf"></path>
                  <path id="Path_3091" data-name="Path 3091" d="M24.4,25.2a.8.8,0,0,1-.565-.234l-6.15-6.15a.8.8,0,0,1,1.13-1.13l6.15,6.15A.8.8,0,0,1,24.4,25.2Z" transform="translate(-5.2 -5.2)" fill="#b5b5bf"></path>
              </svg>

              <!-- Clear Icon -->
              <svg class="clear-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" style="display:none;">
                  <path d="M7 0C3.141 0 0 3.141 0 7s3.141 7 7 7 7-3.141 7-7-3.141-7-7-7zM7 13C3.686 13 1 10.314 1 7S3.686 1 7 1s6 3.686 6 6-3.686 6-6 6z"/>
                  <path d="M9.293 4.707l-2.586 2.586-2.586-2.586-1.414 1.414 2.586 2.586-2.586 2.586 1.414 1.414 2.586-2.586 2.586 2.586 1.414-1.414-2.586-2.586 2.586-2.586z"/>
              </svg>
            </div>

            <div id="search-results" style="z-index: 1000; position: absolute; background: #fff; scroll-behavior: smooth;">
            </div>

          </div>
          <!-- End Header Navigation -->
          <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav navbar-right" data-in="fadeIn" data-out="fadeOut">
              <li class="dropdown active">
                <a href="index.php" class="index.php" data-toggle="#home" style="font-weight: bolder;">Home
                </a>
              </li>
              </li>
                <!-- <li class="dropdown">
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
                </li> -->

              
              <li class="dropdown" >
                <a href="about_us.php" style="font-weight: bolder;">About Us
                </a>
              </li>
              <li class="dropdown" >
                <a href="#" style="font-weight: bolder;">Certificates
                </a>
              </li>
              <li class="dropdown">
                <a href="contact_us.php" style="font-weight: bolder;">Contact us
                </a>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
          <div class="search-toggle">
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

    <script>
      document.getElementById('search').addEventListener('input', function() {
      const searchQuery = this.value;
          // Only trigger search if the query has at least 3 characters
          if (searchQuery.length >= 3) {
              // Perform the AJAX request
              fetch(`search_api.php?search=${encodeURIComponent(searchQuery)}`)
                  .then(response => response.json())
                  .then(data => {
                      const resultsContainer = document.getElementById('search-results');
                      resultsContainer.innerHTML = ''; // Clear previous results

                      if (data.length > 0) {
                          data.forEach(product => {
                              const resultItem = document.createElement('div');
                              resultItem.classList.add('search-result-item');
                              resultItem.innerHTML = `
                                  <img src="${product.image_url}" alt="${product.name}" width="50" height="50">
                                  <p><strong>${product.name}</strong></p>
                                  

                              `;
                              
                              // Add click event to each result item
                              resultItem.addEventListener('click', function() {
                                  window.location.href = `product_detail.php?sku=${product.sku}`;
                              });

                              resultsContainer.appendChild(resultItem);
                          });
                      } else {
                          resultsContainer.innerHTML = '<p>No results found.</p>';
                      }
                  })
                  .catch(error => {
                      console.error('Error fetching data:', error);
                      alert('There was an error with the search. Please try again later.');
                  });
          }
      });
    </script>