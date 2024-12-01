<style>
    /* General Styling for Related Products */
    #feature_product {
        padding: 30px 0;
    }

    #feature_product .heading {
        font-size: 24px;
        /* text-align: center; */
        margin-bottom: 30px;
    }

    .product_wrap {
        padding: 10px;
        border-radius: 20px;
        margin-bottom: 10px;
        box-shadow: -1px 4px 19px -9px rgba(0, 0, 0, 0.5);
        background-color: white;
        transition: box-shadow 0.3s ease;
    }

    .product_wrap:hover {
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
    }

    .product_desc {
        padding: 10px;
        margin-top: 10px;
    }

    .product_desc .title {
        font-size: 16px;
        line-height: 1.5;
    }

    /* CSS Grid for the product container */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Default 4 columns for desktop */
        gap: 15px;
        padding: 15px 0;
    }

    /* Mobile and Tablet Responsiveness */

    /* For small screens (mobile, tablets) */
    @media (max-width: 767px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 products per row */
        }
        
        .product_desc .title {
            font-size: 14px;
        }
        .stylish-linkab {
            font-size: 12px;
            padding: 8px 12px;
        }
    }

    /* For large screens (desktops) */
    @media (min-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(4, 1fr); /* 4 products per row on larger screens */
        }
    }

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
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stylish-linkab:hover {
        color: #f0f0f0;
        text-decoration: none;
    }

</style>
<section id="feature_product" class="bottom_half">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="heading uppercase bottom30">Related Products</h4>
            </div>
        </div>
        <div class="product-grid">
            <?php while ($relatedProduct = $relatedProductsResult->fetch_assoc()): ?>
                <div class="grid-item">
                    <div class="product_wrap bottom_half" style="padding: 5px; border-radius: 20px; margin-bottom: 5px; box-shadow: -1px 4px 19px -9px rgba(0, 0, 0, 0.5); background-color: white">
                        <?php if ($relatedProduct['hours_since_creation'] <= 24): ?>
                            <div class="tag-btn"><span class="uppercase text-center" style="color:#7ab6c8;">New</span></div>
                        <?php endif; ?>
                        <div class="image" style="display: block; width: 100%; padding: 1vw; margin: 1vw;">
                            <?php
                            // Get the first image from the images column
                            $imageIds = explode(',', $relatedProduct['images']);
                            $firstImageId = $imageIds[0];
                            $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                            $imageResult = $conn->query($imageQuery);
                            $image = $imageResult->fetch_assoc();
                            $imageLink = $image ? "../api/uploads/assets/" . $image['file_original_name'] : "../images/default.png";

                         
                                $productName = htmlspecialchars($relatedProduct['name']);
                                $words = explode(' ', $productName);
                                if (count($words) > 2) {
                                    echo htmlspecialchars(implode(' ', array_slice($words, 0, 3))) . '...';
                                } else {
                                    echo $productName;
                                } 
                            ?>
                            <a href="product_detail.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>">
                                <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($productName); ?>" class="img-responsive" style="max-width: 100%; height: auto;">
                            </a>
                        </div>
                        <div class="product_desc" style="padding: 2px; margin: 4px; height: auto; display: flex; justify-content: center; text-align: center;">
                            <p class="title" style="font-size: 14px;"><?php echo htmlspecialchars($productName); ?></p>
                        </div>
                        <div class="btn" style="display: flex; justify-content: center; padding-bottom: 20px;">
                            <a href="product_detail.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>" class="stylish-linkab" style="padding: 8px 15px;">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>


