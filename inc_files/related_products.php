<section id="feature_product" class="bottom_half">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="heading uppercase bottom30">Related Products</h4>
        </div>
        <?php while ($relatedProduct = $relatedProductsResult->fetch_assoc()): ?>
          <div class="col-md-3 col-sm-6">
            <div class="product_wrap bottom_half" style="padding: 5px; border-radius: 20px; margin-bottom: 5px; box-shadow: -1px 4px 19px -9px rgba(0, 0, 0, 0.5); background-color: white">
              <?php if ($relatedProduct['hours_since_creation'] <= 24): ?>
                <div class="tag-btn"><span class="uppercase text-center" style="color:#7ab6c8;">New</span></div>
              <?php endif; ?>
              <div style="display: block; width: 14vw; padding: 1vw; margin: 1vw" class="image">
                <?php
                // Get the first image from the images column
                $imageIds = explode(',', $relatedProduct['images']);
                $firstImageId = $imageIds[0];
                $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                $imageResult = $conn->query($imageQuery);
                $image = $imageResult->fetch_assoc();
                $imageLink = $image ? "../api/uploads/assets/" . $image['file_original_name'] : "../images/default.png";
                ?>
                <a href="product_detail.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>">
                  <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($relatedProduct['name']); ?>" class="img-responsive">
                </a>
              </div>
                <div class="product_desc" style="padding: 2px; margin: 4px; height: 8vh; display: flex;justify-content:center; text-align: center;">
                  <p class="title"><?php echo htmlspecialchars($relatedProduct['name']); ?></p>
                  <!-- <span style="color: #049ddf; font-weight: bold; text-align: center;" class="brand"><?php echo htmlspecialchars($relatedProduct['brand_id']); ?></span> -->
                </div>
                <style>
                  .stylish-linkab {
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

                  .stylish-linkab:hover {
                      /* background-color: #309ec7; */
                      color: #f0f0f0;
                      /* border: 2px solid #ffffff; */
                      /* transform: translateY(-3px); */
                      /* box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.15); */
                      /* color: #23527c; */
                      text-decoration: none;
                  }
                </style>
                <a href="product_detail.php?sku=<?php echo htmlspecialchars($product['sku']); ?>">
                  <div class="btn" style="display: flex; justify-content: center; padding-bottom: 20px;">
                      <a href="#" class="stylish-linkab" style="padding: 8px 15px;">Read More</a>
                  </div>
                </a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>