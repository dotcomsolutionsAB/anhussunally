 <!--NEW ARRIVALS-->
    <section id="arrivals" class="padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="heading_space uppercase">new arri
          </h2>
          <p class="bottom_half">Claritas est etiam processus dynamicus, qui sequitur.
          </p>
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
                // Define the image URL or use a default image if not available
                $imageLink = !empty($product['images']) ? "../api/uploads/assets/" . explode(',', $product['images'])[0] : "../images/default.png";
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
                            <span class="price">
                                <i class="fa fa-gbp"></i> <?php echo htmlspecialchars(number_format($product['price'], 2)); ?>
                            </span>
                            <a class="fancybox" href="<?php echo htmlspecialchars($imageLink); ?>" data-fancybox-group="gallery">
                                <i class="fa fa-shopping-bag open"></i>
                            </a>
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
          <div class="item">
            <div class="product_wrap">
              <div class="image">
                <div class="tag">
                  <div class="tag-btn">
                    <span class="uppercase text-center">New
                    </span>
                  </div>
                </div>
                <a class="fancybox" href="images/product6.jpg">
                  <img src="images/product6.jpg" alt="Product" class="img-responsive">
                </a>
                <div class="social">
                  <ul>
                    <li>
                      <a href="#.">
                        <i class="fa fa-expand">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-exchange">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-heart-o">
                        </i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="product_desc">
                <p>Sacrificial Chair Design
                </p>
                <span class="price">
                  <i class="fa fa-gbp">
                  </i>170.00
                </span>
                <a class="fancybox" href="images/product6.jpg" data-fancybox-group="gallery">
                  <i class="fa fa-shopping-bag open">
                  </i>
                </a>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="product_wrap">
              <div class="image">
                <a class="fancybox" href="images/product7.jpg">
                  <img src="images/product7.jpg" alt="Product" class="img-responsive">
                </a>
                <div class="social">
                  <ul>
                    <li>
                      <a href="#.">
                        <i class="fa fa-expand">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-exchange">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-heart-o">
                        </i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="product_desc">
                <p>Sacrificial Chair Design
                </p>
                <span class="price">
                  <i class="fa fa-gbp">
                  </i>170.00
                </span>
                <a class="fancybox" href="images/product7.jpg" data-fancybox-group="gallery">
                  <i class="fa fa-shopping-bag open">
                  </i>
                </a>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="product_wrap">
              <div class="image">
                <a class="fancybox" href="images/product8.jpg">
                  <img src="images/product8.jpg" alt="Product" class="img-responsive">
                </a>
                <div class="social">
                  <ul>
                    <li>
                      <a href="#.">
                        <i class="fa fa-expand">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-exchange">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-heart-o">
                        </i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="product_desc">
                <p>Sacrificial Chair Design
                </p>
                <span class="price">
                  <i class="fa fa-gbp">
                  </i>170.00
                </span>
                <a class="fancybox" href="images/product8.jpg" data-fancybox-group="gallery">
                  <i class="fa fa-shopping-bag open">
                  </i>
                </a>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="product_wrap">
              <div class="image">
                <a class="fancybox" href="images/product1.jpg">
                  <img src="images/product1.jpg" alt="Product" class="img-responsive">
                </a>
                <div class="social">
                  <ul>
                    <li>
                      <a href="#.">
                        <i class="fa fa-expand">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-exchange">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-heart-o">
                        </i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="product_desc">
                <p>Sacrificial Chair Design
                </p>
                <span class="price">
                  <i class="fa fa-gbp">
                  </i>170.00
                </span>
                <a class="fancybox" href="images/product1.jpg" data-fancybox-group="gallery">
                  <i class="fa fa-shopping-bag open">
                  </i>
                </a>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="product_wrap">
              <div class="image">
                <div class="tag">
                  <div class="tag-btn">
                    <span class="uppercase text-center">New
                    </span>
                  </div>
                </div>
                <a class="fancybox" href="images/product2.jpg">
                  <img src="images/product2.jpg" alt="Product" class="img-responsive">
                </a>
                <div class="social">
                  <ul>
                    <li>
                      <a href="#.">
                        <i class="fa fa-expand">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-exchange">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-heart-o">
                        </i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="product_desc">
                <p>Sacrificial Chair Design
                </p>
                <span class="price">
                  <i class="fa fa-gbp">
                  </i>170.00
                </span>
                <a class="fancybox" href="images/product2.jpg" data-fancybox-group="gallery">
                  <i class="fa fa-shopping-bag open">
                  </i>
                </a>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="product_wrap">
              <div class="image">
                <div class="tag">
                  <div class="tag-btn">
                    <span class="uppercase text-center">New
                    </span>
                  </div>
                </div>
                <a class="fancybox" href="images/product3.jpg">
                  <img src="images/product3.jpg" alt="Product" class="img-responsive">
                </a>
                <div class="social">
                  <ul>
                    <li>
                      <a href="#.">
                        <i class="fa fa-expand">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-exchange">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-heart-o">
                        </i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="product_desc">
                <p>Sacrificial Chair Design
                </p>
                <span class="price">
                  <i class="fa fa-gbp">
                  </i>170.00
                </span>
                <a class="fancybox" href="images/product3.jpg" data-fancybox-group="gallery">
                  <i class="fa fa-shopping-bag open">
                  </i>
                </a>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="product_wrap">
              <div class="image">
                <div class="tag">
                  <div class="tag-btn">
                    <span class="uppercase text-center">New
                    </span>
                  </div>
                </div>
                <a class="fancybox" href="images/product4.jpg">
                  <img src="images/product4.jpg" alt="Product" class="img-responsive">
                </a>
                <div class="social">
                  <ul>
                    <li>
                      <a href="#.">
                        <i class="fa fa-expand">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-exchange">
                        </i>
                      </a>
                    </li>
                    <li>
                      <a href="#.">
                        <i class="fa fa-heart-o">
                        </i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="product_desc">
                <p>Sacrificial Chair Design
                </p>
                <span class="price">
                  <i class="fa fa-gbp">
                  </i>170.00
                </span>
                <a class="fancybox" href="images/product4.jpg" data-fancybox-group="gallery">
                  <i class="fa fa-shopping-bag open">
                  </i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>