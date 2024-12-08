<?php
    ini_set('display_errors', 1);
    // Include the database connection file
    include('connection/db_connect.php');

?>
<header>
        <!-- <div class="tg-header__top">
            <div class="container custom-container">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="tg-header__top-menu">
                            <ul class="list-wrap">
                                <li><a href="contact.html">Contact</a></li>
                                <li><a href="contact.html">Careers</a></li>
                                <li><a href="contact.html">Insights</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tg-header__top-delivery">
                            <p>Express delivery and free returns within 24 hours</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tg-header__top-social">
                            <ul class="list-wrap">
                                <li><a href="https://www.facebook.com/" target="_blank">FB</a></li>
                                <li><a href="https://twitter.com/home" target="_blank">TW</a></li>
                                <li><a href="https://www.linkedin.com/" target="_blank">LI</a></li>
                                <li><a href="https://www.instagram.com/" target="_blank">IN</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div id="header-fixed-height"></div>
        <div id="sticky-header" class="tg-header__area">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-12">
                        <div class="tgmenu__wrap">
                            <nav class="tgmenu__nav">
                                <div class="offCanvas-toggle">
                                    <a href="javascript:void(0)" class="menu-tigger">
                                        <img src="assets/img/icons/bar_icon.svg" alt="" class="injectable">
                                    </a>
                                </div>
                                <div class="logo">
                                    <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
                                </div>
                                <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-xl-flex">
                                    <ul class="navigation">
                                        <li class="active menu-item-has-children"><a href="index.php">Home</a>
                                            <!-- <ul class="sub-menu">
                                                <li class="active"><a href="index.html">01. Construction</a></li>
                                                <li><a href="index-2.html">02. Engineering</a></li>
                                                <li><a href="index-3.html">03. Building</a></li>
                                                <li><a href="index-4.html">04. Architecture</a></li>
                                                <li><a href="index-5.html">05. Renovation</a></li>
                                            </ul> -->
                                        </li>
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
                                        <li class="menu-item-has-children"><a href="#">Brands</a>
                                            <ul class="sub-menu">
                                            <?php 
                                                if ($brandResult && $brandResult->num_rows > 0):
                                                    while ($brand = $brandResult->fetch_assoc()): 
                                            ?>
                                                <li>
                                                    <a href="brand-products.php?id=<?php echo htmlspecialchars($brand['id']); ?>">
                                                        <?php echo htmlspecialchars($brand['name']); ?>
                                                    </a>
                                                </li>
                                            <?php endwhile; ?>
                                            <?php else: ?>
                                                <li><a href="#">No Brands Available</a></li>
                                            <?php endif; ?>
                                            </ul>
                                        </li>

                                        <li class="menu-item-has-children"><a href="about.php">About Us</a>
                                        <!-- <li class="menu-item-has-children"><a href="brands.php">Brands</a> -->
                                        <!-- <li class="menu-item-has-children"><a href="faq.php">Faq</a> -->
                                        <li class="menu-item-has-children"><a href="products.php">Products</a>
                                        <!-- <li class="menu-item-has-children"><a href="product-details.php">Product Details</a> -->
                                        <li class="menu-item-has-children"><a href="contact.php">Contact Us</a>

                                        <!-- <li class="menu-item-has-children"><a href="#">Shop</a>
                                            <ul class="sub-menu">
                                                <li><a href="shop.html">Shop Page</a></li>
                                                <li><a href="shop-details.html">Shop Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children"><a href="#">Portfolio</a>
                                            <ul class="sub-menu">
                                                <li><a href="project.html">Portfolio Page</a></li>
                                                <li><a href="project-details.html">Portfolio Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children"><a href="#">Blog</a>
                                            <ul class="sub-menu">
                                                <li><a href="blog.html">Blog Standard</a></li>
                                                <li><a href="blog-2.html">Blog List</a></li>
                                                <li><a href="blog-3.html">Blog Grid</a></li>
                                                <li><a href="blog-details.html">Blog Details</a></li>
                                            </ul>
                                        </li> -->
                                    </ul>
                                </div>
                                <div class="tgmenu__action">
                                    <ul class="list-wrap">
                                        <li class="header-search">
                                            <a href="javascript:void(0)" class="search-open-btn"><i class="renova-search"></i></a>
                                        </li>
                                        <!-- <li class="header-cart">
                                            <a href="shop.html" class="cart-count">
                                                <i class="renova-cart"></i>
                                                <span class="mini-cart-count">2</span>
                                            </a>
                                        </li>
                                        <li class="header-btn">
                                            <a href="contact.html" class="btn border-btn">Get In Touch</a>
                                        </li> -->
                                    </ul>
                                </div>
                                <div class="mobile-nav-toggler"><i class="tg-flaticon-menu-1"></i></div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu  -->
        <div class="tgmobile__menu">
            <nav class="tgmobile__menu-box">
                <div class="close-btn"><i class="tg-flaticon-close-1"></i></div>
                <div class="nav-logo">
                    <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
                </div>
                <div class="tgmobile__search">
                    <form action="#" method="GET" id="search-form">
                        <input type="text" placeholder="Search here..." id="search-input" autocomplete="off">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="tgmobile__menu-outer" id="search-results">
                    <!-- Search results will appear here -->
                </div>

                <div class="social-links">
                    <ul class="list-wrap">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="tgmobile__menu-backdrop"></div>
        <!-- End Mobile Menu -->

        <!-- header-search -->
        <div class="search__popup">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="search__wrapper">
                            <div class="search__close">
                                <button type="button" class="search-close-btn">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 1L1 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path d="M1 1L17 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="search__form">
                                <form action="#">
                                    <div class="search__input">
                                        <input class="search-input-field" type="text" id="searchInput" placeholder="Type keywords here">
                                        <span class="search-focus-border"></span>
                                        <button>
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-popup-overlay" id="searchResults"></div>
        <!-- header-search-end -->


        <!-- offCanvas-menu -->
        <div class="offCanvas__info">
            <div class="offCanvas__close-icon menu-close">
                <button><i class="far fa-window-close"></i></button>
            </div>
            <div class="offCanvas__logo mb-30">
                <a href="index.html"><img src="images/logo.png" alt="Logo"></a>
            </div>
            <div class="offCanvas__side-info mb-30">
                <div class="contact-list mb-30">
                    <h4>Office Address</h4>
                    <p>Hussunally Buildings <br>
                         Post Box No. 68628, Strand Road, Kolkata West Bengal-700 001</p>
                </div>
                <div class="contact-list mb-30">
                    <h4>Phone Number</h4>
                    <p>+91-33-2230 4140</p>
                    <!-- <p>+(090) 0000 0000 000</p> -->
                </div>
                <div class="contact-list mb-30">
                    <h4>Email Address</h4>
                    <p>hussunally@gmail.com</p>
                    <!-- <p>example.mail@hum.com</p> -->
                </div>
            </div>
            <!-- <div class="offCanvas__social-icon mt-30">
                <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                <a href="javascript:void(0)"><i class="fab fa-google-plus-g"></i></a>
                <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
            </div> -->
        </div>
        <div class="offCanvas__overly"></div>
        <!-- offCanvas-menu-end -->

    </header>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            var query = this.value.trim();
            if (query.length >= 3) {
                // Perform the AJAX request only if the query has 3 or more characters
                fetchSearchResults(query);
            } else {
                // Clear search results if query is less than 3 characters
                document.getElementById('searchResults').innerHTML = '';
            }
        });

        function fetchSearchResults(query) {
            fetch('search.php?q=' + query)
                .then(response => response.json())
                .then(data => {
                    let resultsHtml = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            resultsHtml += `
                                <div class="search-result-item">
                                    <img src="${item.image}" alt="${item.name}">
                                    <p><strong>${item.name}</strong></p>
                                    <p>Brand: ${item.brand_id}</p>
                                    <a href="product_details.php?sku=${item.sku}">View Details</a>
                                </div>
                            `;
                        });
                    } else {
                        resultsHtml = '<p>No results found</p>';
                    }
                    document.getElementById('searchResults').innerHTML = resultsHtml;
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        }
    </script>