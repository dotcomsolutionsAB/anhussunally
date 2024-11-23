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
                $imageLink = $image ? "api/uploads/assets/" . $image['file_original_name'] : "path/to/default-image.jpg";
                ?>
                <a href="product_detail.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>">
                  <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($relatedProduct['name']); ?>" class="img-responsive">
                </a>
              </div>
              <a href="product_detail.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>" class="fancybox">
                <div class="product_desc" style="padding: 2px; margin: 4px; height: 15vh; display: flex; flex-direction: column; justify-content:space-evenly; text-align: center;">
                  <p class="title"><?php echo htmlspecialchars($relatedProduct['name']); ?></p>
                  <span style="color: #049ddf; font-weight: bold; text-align: center;" class="brand"><?php echo htmlspecialchars($relatedProduct['brand_id']); ?></span>
                </div>
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>