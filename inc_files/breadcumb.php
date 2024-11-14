<?php
        // Determine the current page or category dynamically
        $current_page = basename($_SERVER['PHP_SELF'], ".php"); // Gets the current PHP file name without extension

        // Example logic for generating breadcrumb items
        $breadcrumb_items = [];
        $breadcrumb_items[] = ['name' => 'Home', 'link' => 'index.php'];

        if ($current_page === 'products') {
            $breadcrumb_items[] = ['name' => 'Products', 'link' => 'products.php'];

            // If there is a specific product category or name, you can add it here
            if (isset($_GET['category'])) {
                $breadcrumb_items[] = ['name' => htmlspecialchars($_GET['category']), 'link' => '#'];
            } elseif (isset($_GET['sku'])) {
                $breadcrumb_items[] = ['name' => 'Product Details', 'link' => '#'];
            }
        } else {
            $breadcrumb_items[] = ['name' => ucfirst($current_page), 'link' => '#'];
        }
?>

    <section class="page_menu" style="padding-top: 0px; ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="hidden">hidden</h3>
                    <ul class="breadcrumb" style="background: beige;">
                        <?php foreach ($breadcrumb_items as $index => $item): ?>
                            <li <?php echo $index === count($breadcrumb_items) - 1 ? 'class="active"' : ''; ?>>
                                <?php if ($index !== count($breadcrumb_items) - 1): ?>
                                    <a href="<?php echo htmlspecialchars($item['link']); ?>">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </a>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($item['name']); ?>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>