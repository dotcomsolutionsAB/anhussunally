<style>
    .owl-theme .owl-controls {
        display: none !important;
    }
    .owl-item {
        /* width: 293px !important; */
    }
    .product_wrap .product_desc {
        padding: 5px 5px 5px 5px;
        font-size:16px;
    }
    .heading_space{
        font-family:'Oswald';   
    }
</style>

<!--NEW ARRIVALS-->
<section id="arrivals" class="padding">
<?php
    // Define the specific brand IDs
    $brandIds = [1, 4];

    // Establish database connection
    $conn = mysqli_connect($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    foreach ($brandIds as $brandId):
        // Fetch brand name
        $brandQuery = "SELECT name FROM brand WHERE id = $brandId";
        $brandResult = $conn->query($brandQuery);
        $brandName = $brandResult && $brandResult->num_rows > 0 ? $brandResult->fetch_assoc()['name'] : "Unknown Brand";

        // Fetch 10 random products for the current brand
        $productQuery = "SELECT * FROM products WHERE brand_id = $brandId ORDER BY RAND() LIMIT 10";
        $productResult = $conn->query($productQuery);
?> 
    <div class="container" style="">
        <div class="row">
            <div class="col-md-12 text-center" style="display: flex; justify-content: flex-start; ">
                <h2 style="text-align: left;" class="heading_space uppercase">
                    <?php echo htmlspecialchars($brandName); ?> 
                </h2>
            </div>
        </div>
        <style>
            .stylish-linka {
                display: flex;
                width: 120px;
                border-radius: 15px;
                text-align: center;
                background-color: #3ab6e9;
                color: #ffffff;
                text-decoration: none;
                padding: 12px 20px;
                font-size: 13px;
                font-weight: bold;
                text-transform: uppercase; /* Uppercase text */
                letter-spacing: 1px; /* Slightly spaced letters */
                border: 2px solid transparent; /* Add a border for hover effect */
                cursor: pointer; /* Pointer cursor on hover */
                transition: all 0.3s ease; /* Smooth transition for all properties */
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
            }

            .stylish-linka:hover {
                /* background-color: #309ec7; */
                color: #f0f0f0;
                /* border: 2px solid #ffffff; */
                /* transform: translateY(-3px); */
                /* box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.15); */
                /* color: #23527c; */
                text-decoration: none;
            }
        </style>
        <div class="row">
        <div class="slider-wrapper">
            <!-- <button class="prev-btn" data-target="fourCol-slider-<?php echo $brandId; ?>"><i class="fa fa-chevron-left"></i></button> -->
            <div id="fourCol-slider-<?php echo $brandId; ?>" class="owl-carousel" >
                <?php
                    if ($productResult && $productResult->num_rows > 0):
                        while ($product = $productResult->fetch_assoc()):
                            // Initialize the image link
                            $imageLink = "../images/default.png"; // Default image

                            // Check if the product has images and fetch the first image
                            if (!empty($product['images'])) {
                                $imageIds = explode(',', $product['images']);
                                $firstImageId = $imageIds[0] ?? null;

                                if ($firstImageId) {
                                    // Fetch the file name from the upload table
                                    $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                                    $imageResult = $conn->query($imageQuery);

                                    if ($imageResult && $imageResult->num_rows > 0) {
                                        $image = $imageResult->fetch_assoc();
                                        $imageLink = "../api/uploads/assets/" . $image['file_original_name'];
                                    }
                                }
                            }
                ?>
                    <!-- HTML structure for each product -->
                    <div class="item" style="padding:15px; width:280px;" style="">
                        <div class="product_wrap">
                            <div class="image">
                                <a href="product_detail.php?sku=<?php echo htmlspecialchars($product['sku']); ?>">
                                    <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="display: block; width: 14vw; padding: 1vw; margin: 1vw;" class="img-responsive">
                                </a>
                            </div>
                            <div class="product_desc" style="padding: 2px; margin: 4px; height: 8vh; display: flex; flex-direction: column; justify-content:space-evenly; text-align: center;">
                                <p>
                                    <?php $productName = htmlspecialchars($product['name']);
                                    $words = explode(' ', $productName);
                                    if (count($words) > 3) {
                                        echo htmlspecialchars(implode(' ', array_slice($words, 0, 5))) . '...';
                                    } else {
                                        echo $productName;
                                    } ?> 
                                </p>
                            </div>
                            <div class="btn" style="display: flex; justify-content: center; padding-bottom: 20px;">
                                <a href="product_detail.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="stylish-linka" style="padding: 8px 15px;">Read More</a>
                            </div>
                        </div>
                    </div>
                    <?php
                        endwhile;
                    else:
                        echo "<p>No products found for this brand.</p>";
                    endif;
                    ?>          
            </div>
            <!-- <button class="next-btn" data-target="fourCol-slider-<?php echo $brandId; ?>"><i class="fa fa-chevron-right"></i></button> -->
        </div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php $conn->close(); ?>
  </section>

<!-- Owl Carousel Scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Custom CSS for Navigation Buttons -->
<style>
    .slider-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .prev-btn, .next-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: #333;
        color: #fff;
        border: none;
        font-size: 24px;
        padding: 10px 15px;
        cursor: pointer;
        z-index: 10;
        border-radius: 50%;
    }

    .prev-btn {
        left: -60px; /* Move button further to the left */
    }

    .next-btn {
        right: -60px; /* Move button further to the right */
    }

    .prev-btn:hover, .next-btn:hover {
        background-color: #555;
    }

    .owl-nav, .owl-dots {
        display: none !important; /* Disable default Owl Carousel buttons */
    }
</style>

<!-- Owl Carousel Initialization Script -->
<script>
    $(document).ready(function () {
        // Initialize all Owl Carousels
        $(".owl-carousel").each(function () {
            const carousel = $(this);
            carousel.owlCarousel({
                loop: false,
                margin: 10,
                nav: false,
                dots: false,
                items: 4, // Display 4 products at a time
                responsive: {
                    0: { items: 1 },
                    600: { items: 2 },
                    1000: { items: 4 }
                }
            });

            // Custom navigation buttons
            $(".prev-btn").off("click").on("click", function () {
                const target = $(this).data("target");
                $("#" + target).trigger("prev.owl.carousel");
            });

            $(".next-btn").off("click").on("click", function () {
                const target = $(this).data("target");
                $("#" + target).trigger("next.owl.carousel");
            });
        });
    });
</script>
