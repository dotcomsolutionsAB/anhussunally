<?php
    ini_set('display_errors', 1);
    // Include the database connection file
    include('connection/db_connect.php');

?>
<header>
        <div class="tg-header__top" style="display:none;">
            <div class="container custom-container">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="tg-header__top-menu">
                            <ul class="list-wrap">
                                <!-- <li><a href=""></a></li> -->
                                <li>
                                    <a href="tel:+913322304140">📞 +91-33-2230 4140</a>
                                </li> |
                                <li>
                                    <a href="mailto:hussunally@gmail.com">✉️ hussunally@gmail.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tg-header__top-delivery">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tg-header__top-social">
                            <ul class="list-wrap">
                                <!-- <li><a href=""> Hussunally Buildings</a></li> -->
                                <li>
                                    <a href="#">🏢 Post Box No. 68628, Strand Road, Kolkata West Bengal-700 001</a>
                                </li>
                                <!-- <li><a href="https://www.linkedin.com/" target="_blank">LI</a></li> -->
                                <!-- <li><a href="https://www.instagram.com/" target="_blank">IN</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="header-fixed-height"></div>
        <div id="sticky-header" class="tg-header__area">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-12">
                        <div class="tgmenu__wrap">
                            <nav class="tgmenu__nav">
                                <!-- <div class="offCanvas-toggle">
                                    <a href="javascript:void(0)" class="menu-tigger">
                                        <img src="assets/img/icons/bar_icon.svg" alt="" class="injectable">
                                    </a>
                                </div> -->
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
                                            $brandQuery = "SELECT id, name FROM brand ORDER BY `custom_order`";
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
                                        <!-- <li class="menu-item-has-children"><a href="products.php">Products</a> -->
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
                                            <a href="javascript:void(0)" class="search-open-btn" style="display: flex; justify-content: center;
    align-items: center; gap:10px; font-size: x-large;"><i class="renova-search"></i>Search</a>
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
            <form action="#" method="GET" id="mobile-search-form">
                <input type="text" placeholder="Search products..." id="mobileSearchInput" autocomplete="off">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="tgmobile__menu-outer" id="mobile-search-results">
            <!-- Search results for mobile will appear here -->
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
            <style>
                #searchResults {
                    max-height: 400px; /* Set a max height for the results container */
                    overflow-y: auto; /* Enable vertical scrolling when results exceed max height */
                    padding: 10px; /* Optional padding for better styling */
                    border: 1px solid #ddd; /* Optional border for better visibility */
                    background-color: #fff; /* Ensure the background is white */
                }
                #searchResults::-webkit-scrollbar {
                    width: 8px; /* Customize scrollbar width */
                }
                #searchResults::-webkit-scrollbar-thumb {
                    background: #ccc; /* Customize scrollbar color */
                    border-radius: 4px; /* Optional rounded edges */
                }
                #searchResults::-webkit-scrollbar-thumb:hover {
                    background: #aaa; /* Darker color on hover */
                }
            </style>

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
                            <div id="searchResults"></div> <!-- For displaying results -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-popup-overlay"></div>
        <!-- header-search-end -->


        <!-- offCanvas-menu -->
        <div class="offCanvas__info">
            <div class="offCanvas__close-icon menu-close">
                <button><i class="far fa-window-close"></i></button>
            </div>
            <div class="offCanvas__logo mb-30">
                <a href="index.html">
                    <img src="images/logo.png" alt="Logo">
                </a>
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
                    <p>+(090) 0000 0000 000</p>
                </div>
                <div class="contact-list mb-30">
                    <h4>Email Address</h4>
                    <p>hussunally@gmail.com</p>
                    <p>example.mail@hum.com</p>
                </div>
            </div>
            <div class="offCanvas__social-icon mt-30">
                <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                <a href="javascript:void(0)"><i class="fab fa-google-plus-g"></i></a>
                <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="offCanvas__overly"></div>
        <!-- offCanvas-menu-end -->

    </header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    
    // Get elements
    const searchOpenBtn = document.querySelector('.search-open-btn');
    const searchCloseBtn = document.querySelector('.search-close-btn');
    const searchPopup = document.querySelector('.search__popup');
    const searchInput = document.getElementById('searchInput');

    // Open search popup
    searchOpenBtn.addEventListener('click', () => {
        searchPopup.style.display = 'block'; // Show the search popup
        searchInput.focus(); // Automatically focus the input box
    });

    // Close search popup
    searchCloseBtn.addEventListener('click', () => {
        searchPopup.style.display = 'none'; // Hide the search popup
    });

    // Optional: Hide popup if clicked outside
    document.addEventListener('click', (e) => {
        if (!searchPopup.contains(e.target) && !searchOpenBtn.contains(e.target)) {
            searchPopup.style.display = 'none'; // Hide the popup
        }
    });
</script>

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
</script>

<script>
    function fetchSearchResults(query) {
        fetch('search.php?q=' + query)
            .then(response => response.json())
            .then(data => {
                let resultsHtml = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        resultsHtml += `
                            <div class="search-result-item" style="display: flex; align-items: center;">
                                <div style="width: 210px; height: 200px;display: flex; justify-content: center; align-items: center;">
                                    <img src="uploads/assets/${item.image}" style="width:100%; object-fit:contain; border-radius: 5px;">
                                </div>    
                                <div style="padding-left:20px;">
                                    <strong>${item.product_name}</strong>
                                    <div style="display: flex; flex-direction:column; margin-top: 5px;">
                                        <p style="margin: 0px;"><span style="font-weight: 500; margin-bottom: 0px;"> SKU: ${item.sku}</span></p>
                                        <p style="margin: 0px;">Category: ${item.category_name}</p>
                                        <p style="margin: 0px;">Brand: ${item.brand_name}</p>
                                    </div>
                                    <a href="product-details.php?sku=${item.sku}" style="text-decoration: none; color: blue;">View Details</a>
                                </div>
                            </div>
                            <hr style="border: 0; border-top: 1px solid #ddd; margin: 10px 0;">
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

<script>
    // Listen for input changes in the mobile search bar
    document.getElementById('mobileSearchInput').addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length >= 3) {
            fetchMobileSearchResults(query);
        } else {
            document.getElementById('mobile-search-results').innerHTML = '';
        }
    });

    // Fetch search results for mobile
    function fetchMobileSearchResults(query) {
        fetch('search.php?q=' + query)
            .then(response => response.json())
            .then(data => {
                let resultsHtml = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        resultsHtml += `
                            <div class="search-result-item" style="display: flex; flex-direction: column; gap: 10px; padding: 10px; border: 1px solid #ddd; margin-bottom: 10px; border-radius: 5px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>${item.product_name}</strong>
                                        <p style="font-size: 14px; color: #666;">Category: ${item.category_name}</p>
                                        <p style="font-size: 14px; color: #666;">Brand: ${item.brand_name}</p>
                                    </div>
                                    <div>
                                        <img src="uploads/assets/${item.image}" alt="${item.product_name}" style="width: 60px; height: auto; border-radius: 5px;">
                                    </div>
                                </div>
                                <a href="product-details.php?sku=${item.sku}" style="text-decoration: none; color: #007bff; font-size: 14px;">View Details</a>
                            </div>
                        `;
                    });
                } else {
                    resultsHtml = '<p style="color: #999; text-align: center;">No results found</p>';
                }
                document.getElementById('mobile-search-results').innerHTML = resultsHtml;
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
            });
    }
</script>