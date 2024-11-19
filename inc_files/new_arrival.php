 <!--NEW ARRIVALS-->
    <section id="arrivals" class="padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="heading_space uppercase">Brand Products
          </h2>
        </div>
      </div>
      <div class="row">
        <div id="fourCol-slider" class="owl-carousel">
        <?php include("api/db_connection.php"); ?>

              <?php
                  // Establish database connection
                  $conn = mysqli_connect($host, $username, $password, $dbname);
                  if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                  }

                  // Fetch unique brand IDs from the products table
                  $brandQuery = "SELECT DISTINCT brand_id FROM products";
                  $brandResult = $conn->query($brandQuery);

                  if ($brandResult && $brandResult->num_rows > 0):
                      while ($brand = $brandResult->fetch_assoc()):
                          $brandId = $brand['brand_id'];

                          // Fetch 4 random products for each brand
                          $productQuery = "SELECT * FROM products WHERE brand_id = $brandId ORDER BY RAND() LIMIT 4";
                          $productResult = $conn->query($productQuery);

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
                <div class="item">
                    <div class="product_wrap">
                        <div class="image">
                            <div class="social">
                                <!-- Add social icons or buttons if needed -->
                            </div>
                            <a class="fancybox" href="<?php echo htmlspecialchars($imageLink); ?>">
                                <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="Product" class="img-responsive">
                            </a>
                        </div>
                        <div class="product_desc">
                            <p><?php echo htmlspecialchars($product['name']); ?></p>
                        </div>
                    </div>
                </div>
                <?php
                              endwhile;
                          endif;
                      endwhile;
                  else:
                      echo "No brands found.";
                  endif;

                  $conn->close();

                ?>          
        </div>
      </div>
    </div>
  </section>